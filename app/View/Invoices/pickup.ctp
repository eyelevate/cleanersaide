<?php
$this->Html->css(array('admin/invoices_pickup'),'stylesheet', array('inline' => false)); 
//add scripts to header
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/invoices_pickup.js'	
	),
	FALSE
);

$tax_rate  = 0;
if(!empty($taxes)){
	foreach ($taxes as $t) {
		$tax_rate = $t['Tax']['rate'];
	}
}

//get important variables
foreach ($invoices as $i) {
	$customer_id = $i['Invoice']['customer_id'];
	$due_date = date('n/d/Y',strtotime($i['Invoice']['due_date']));
}

?>
<div class="row-fluid">
	<h1 class="heading">Pickup Invoice</h1>

	<div class="formRow span8 pull-left" style="margin-left:0px">
		<legend>Select Invoice To Pickup</legend>
		<table id="invoiceSelectTable" class="table table-bordered">
			<thead>
				<tr>
					<th></th>
					<th>Invoice</th>
					<th>Rack</th>
					<th>Dropoff</th>
					<th>Due</th>
					<th>Quantity</th>
					<th>Before Tax</th>
					<th>Tax</th>
					<th>After Tax</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($invoices as $inv) {
					$invoice_id = sprintf('%06d',$inv['Invoice']['invoice_id']);
					$quantity = $inv['Invoice']['quantity'];
					$before_tax = $inv['Invoice']['pretax'];
					$tax = $inv['Invoice']['tax'];
					$rack = $inv['Invoice']['rack'];
					$total = sprintf('%.2f',$inv['Invoice']['total']);
					$created = date('D n/d/y',strtotime($inv['Invoice']['created']));
					$due_date = date('D n/d/y',strtotime($inv['Invoice']['due_date']));
					$status = $inv['Invoice']['status'];
					switch($status){
						case '1': //newly created 
							$today_string = strtotime(date('Y-m-d H:i:s'));
							$due_string = strtotime($inv['Invoice']['due_date']);
							if($today_string > $due_string){ //if todays date is greater than the due date and not racked
								$background_class = 'status_two';
							} else { //still not racked but not ready yet
								$background_class = 'status_one';
							}
						break;
						
						case '3': //racked and ready to pick up
							$background_class = 'status_three';
						break;
							
					}					
					
				?>
					<tr class="pointer invoiceSelectTr" invoice_id="<?php echo $invoice_id;?>">
						<td class="<?php echo $background_class;?>"><input class="invoiceSelectInput" type="checkbox" value="<?php echo $invoice_id;?>" name="data[Complete][<?php echo $invoice_id;?>]"/></td>
						<td id="invoice_td-invoice_id" class="<?php echo $background_class;?>" value="<?php echo $invoice_id;?>"><?php echo $invoice_id;?></td>
						<td id="invoice_td-rack" class="<?php echo $background_class;?>" value="<?php echo $rack;?>"><?php echo $rack;?></td>
						<td id="invoice_td-created" class="<?php echo $background_class;?>" value="<?php echo $created;?>"><?php echo $created;?></td>
						<td id="invoice_td-due" class="<?php echo $background_class;?>" value="<?php echo $due_date;?>"><?php echo $due_date;?></td>
						<td id="invoice_td-quantity" class="<?php echo $background_class;?>" value="<?php echo $quantity;?>"><?php echo $quantity;?></td>
						<td id="invoice_td-bt" class="<?php echo $background_class;?>" value="<?php echo $before_tax;?>">$<?php echo $before_tax;?></td>
						<td id="invoice_td-tax" class="<?php echo $background_class;?>" value="<?php echo $tax;?>">$<?php echo $tax;?></td>	
						<td id="invoice_td-total" class="<?php echo $background_class;?>" value="<?php echo $total;?>">$<?php echo $total;?></td>
					</tr>
				<?php
				}
				?>				
			</tbody>
		</table>
	</div>
	<div class="formRow span3 pull-left">
		<legend>Selected Invoice Totals</legend>
		<table id="tableSummary" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Totals</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>Quantity</th>
					<td id="total_quantity" value="0">0</td>
					<td></td>
				</tr>
				<tr>
					<th>Before Tax</th>
					<td id="total_bt" value="0.00">$0.00</td>
					<td></td>
				</tr>
				<tr>
					<th>Tax</th>
					<td id="total_tax" value="0.00">$0.00</td>
					<td></td>
				</tr>
				<tr>
					<th>Discount</th>
					<td id="total_discount" value="0"></td>
					<td><button data-toggle="modal" href="#myModalDiscount" class="btn btn-info" style="width:75px;">Add</button></td>
				</tr>

			</tbody>
			<tfoot>
				<tr>
					<th style="border-top:2px solid #5e5e5e;">Total Due</th>
					<td id="total_at" style="border-top:2px solid #5e5e5e;" value="0.00">$0.00</td>
					<td style="border-top:2px solid #5e5e5e;"><button data-toggle="modal" href="#myModalFinish" class="btn btn-primary" style="width:75px;">Finish</button></td>
				</tr>				
			</tfoot>
		</table>
	</div>
	<div class="form_row span8 clearfix" style="margin-left:0px;">
		<legend>Selected Invoice Line-items</legend>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Invoice</th>
					<th>Quantity</th>
					<th>Item(s)</th>
					<th>Color(s)</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($invoices as $inv) {
				$invoice_id = sprintf('%06d',$inv['Invoice']['invoice_id']);
				//create items string
				$items = json_decode($inv['Invoice']['items'],true);
				$color_list = '';
				
				foreach ($items as $item) {
					$item_qty = $item['quantity'];
					$item_name = $item['name'];
					$item_colors = array();
					if(!empty($item['colors'])){
						$item_colors = $item['colors'];
					}
					$color_list = '';
					//switch qty
					if($item_colors > 0){
						foreach ($item_colors as $ikey => $ivalue) {
							$color_qty = $ivalue['quantity'];
							$color_name = $ivalue['color'];
							if($color_qty >1){
								$color_list .= '('.$color_qty.') '.$color_name.', '; 
							} else {
								$color_list .= $color_name.', '; 
							}
						}
						
					}
					
					$color_list = substr($color_list,0,-2);
					?>
					<tr class="invoiceSummary-<?php echo $invoice_id;?> hide">
						<td><?php echo $invoice_id;?></td>
						<td><?php echo $item_qty;?></td>
						<td><?php echo $item_name;?></td>
						<td><?php echo $color_list;?></td>
					</tr>
					<?php
				}

			}
			?>
			</tbody>
		</table>
	</div>
</div>
<!-- Modal Finish Pickup -->
<div class="modal fade" id="myModalFinish" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      <h4 class="modal-title">Finish Invoice</h4>
	    </div>
	    <div class="modal-body">
			<div class="control-group">
				<div class="input-prepend input-append"> 
					<span class="add-on">$</span>
					<input id="finalTotalDue" type="text" disabled="disabled" value="0.00"/>
					<span class="add-on">Total Due</span>
				</div>
			</div>
			<ul id="paymentTypeUl" class="nav nav-tabs">
				<li class="active" payment="credit" ><a href="#creditLi" data-toggle="tab">Credit</a></li>
				<li payment="cash"><a href="#cashLi" data-toggle="tab">Cash</a></li>
				
			</ul>
			<ol class="unstyled tab-content">
				<li id="creditLi" class="tab-pane active">
					<div class="control-group">
						<label>Last 4 digits</label>
						<input type="text" placeholder="optional"/>
					</div>
				</li>
				<li id='cashLi' class="tab-pane">
					<div class="row-fluid">
						<div class="pull-left" style="width:50%;">
							<div class="calculatorDiv">
								<div class="control-group">
									<ul id="calculator" class="unstyled">
										<li id="totalPaidLi" class="clearfix control-group"><input id="totalPaidFinal" class="center-text" type="text" disabled="disabled" style="background-color:#ffffff;" value="0.00"/></li>
										<li class="clearfix">
											<button class="pull-left" value="7">7</button>
											<button class="pull-left" value="8">8</button>
											<button class="pull-left" value="9">9</button>
										</li>
										<li class="clearfix">
											<button class="pull-left" value="4">4</button>
											<button class="pull-left" value="5">5</button>
											<button class="pull-left" value="6">6</button>
										</li>
										<li class="clearfix">
											<button class="pull-left" value="1">1</button>
											<button class="pull-left" value="2">2</button>
											<button class="pull-left" value="3">3</button>
										</li>
										<li class="clearfix">
											<button class="pull-left" value="00">00</button>
											<button class="pull-left" value="0">0</button>
											<button class="pull-left" value="C">C</button>
										</li>
										<li id="totalChangeLi" class="clearfix control-group" style="margin-top:5px;"><input id="totalChangeDue" class="center-text text" type="text" disabled="disabled" value="0.00"/></li>
									</ul>
								</div>
							</div>
						</div>
	
						<div class="pull-right" style="width:50%;">
							<ul id="quickButtonsUl" class="unstyled">
								<li><button class="quickButtons btn btn-info" value="5.00">$5.00</button></li>
								<li><button class="quickButtons btn btn-info" value="10.00">$10.00</button></li>
								<li><button class="quickButtons btn btn-info" value="20.00">$20.00</button></li>
								<li><button class="quickButtons btn btn-info" value="50.00">$50.00</button></li>
								<li><button class="quickButtons btn btn-info" value="100.00">$100.00</button></li>
							</ul>
						</div>
					</div>
				</li>
			</ol>			
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	      <button id="printPickup" type="button" class="btn btn-success pull-right">Print Reciept</button>
	      <button id="noPrintPickup" type="button" class="btn btn-primary pull-right">No Reciept</button>
	    </div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal Disount -->
<?php
?>
<div class="modal fade" id="myModalDiscount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      <h4 class="modal-title">Add Discount</h4>
	    </div>
	    <div class="modal-body">
	    	<legend>Select Discount</legend>
			<div class="control-group">
				<label>Total Reward Points</label>
				<div class="input-append">
					<input type="text" value="<?php echo $reward_points;?>" disabled="disabled" style="text-align:right; width:100px; background-color:#ffffff"/>
					<span class="add-on">Points</span>	
				</div>
				<input id="rewardPoints" type="hidden" value="<?php echo $reward_points;?>"/>
			</div>
	     	<div class="control-group">
	     		<label>Select Discount</label>
	     		<select id="discountSelect">
	     			<option value="none" >Select Here</option>
	     			<optgroup label="Reward Program">
	     			<?php
	     			foreach ($rewards as $r) {
	     				$reward_id = $r['Reward']['id'];
						$reward_discount = $r['Reward']['discount'];
						$reward_name = $r['Reward']['name'];
						$reward_points = $r['Reward']['points'];
						?>
						<option value="<?php echo $reward_id;?>" points="<?php echo $reward_points;?>" discount="<?php echo $reward_discount;?>"><?php echo $reward_name;?></option>
						<?php
					}

	     			?>	     				
	     			</optgroup>


	     		</select>
	     	</div>
			<hr/>
			<legend>Discount Totals</legend>
			<table class="table table-condensed table-hover table-striped table-bordered">
				<tbody>
					<tr>
						<th>Current Total</th>
						<td id="currentTotal" value="0.00">$0.00</td>
					</tr>
					<tr>
						<th>Discount</th>
						<td id="discountTotal"  value="0.00">$0.00</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th style="border-top:2px solid #5e5e5e;">New Total</th>
						<th id="newTotal" value="0.00" style="border-top:2px solid #5e5e5e;">$0.00</th>
					</tr>
					<tr>
						<th>Points Remaining</th>
						<th id="newPoints" value="0"><?php echo $reward_points;?></th>
					</tr>
				</tfoot>
			</table>
	    </div>
	    <div class="modal-footer">
	      <button id="closeDiscountModal" type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	      <button id="addDiscountButton" type="button" class="btn btn-primary pull-right">Add Discount</button>
	    </div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<form id="finalPickupForm" customer_id="<?php echo $customer_id;?>" reward="<?php echo $reward_points;?>" method="post" action="/invoices/process_pickup"></form>