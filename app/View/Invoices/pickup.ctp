<?php
$this->Html->css(array('admin/invoices_pickup'),'stylesheet', array('inline' => false)); 
//add scripts to header
echo $this->Html->script(array('admin/invoices_pickup.js'),FALSE);

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
					<td><button data-toggle="modal" href="#myModalDiscount" class="btn btn-info">Add</button></td>
				</tr>

			</tbody>
			<tfoot>
				<tr>
					<th style="border-top:2px solid #5e5e5e;">Total Due</th>
					<td id="total_at" style="border-top:2px solid #5e5e5e;" value="0.00">$0.00</td>
					<td style="border-top:2px solid #5e5e5e;"><button data-toggle="modal" href="#myModalFinish" class="btn btn-primary">Finish</button></td>
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
					$item_colors = $item['colors'];
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
	     	<h3>Select Due Date</h3>
	     	<div class="control-group">
	     		<div class="input-append">
	     			<input id="due_date" type="text" value="<?php echo $due_date;?>"/>
	     			<span class="add-on"><i class="icon-calendar"></i></span>
	     		</div>
	     	</div>
	     	<br/><br/>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	      <button id="editButton" type="button" class="btn btn-primary pull-right">Edit Invoice</button>
	    </div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal Disount -->
<?php
$reward_points = 400;
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
	     			<option value="" >Select Here</option>
	     			<?php
	     			if($reward_points <= 100){
	     				?>
	     				<option value="0.1" points="100">10% Off (100 points)</option>
	     				<?php
	     			} elseif($reward_points <= 200) {
	     				?>
	     				<option value="0.1" points="100">10% Off (100 points)</option>
	     				<option value="0.2" points="200">20% Off (200 points)</option>
	     				<?php
	     			} elseif($reward_points <= 300) {
	     				?>
	     				<option value="0.1" points="100">10% Off (100 points)</option>
	     				<option value="0.2" points="200">20% Off (200 points)</option>
	     				<option value="0.3" points="300">30% Off (300 points)</option>	     				
	     				<?php
	     			} elseif($reward_points <= 400) {
	     				?>
	     				<option value="0.1" points="100">10% Off (100 points)</option>
	     				<option value="0.2" points="200">20% Off (200 points)</option>
	     				<option value="0.3" points="300">30% Off (300 points)</option>	
		     			<option value="0.4" points="400">40% Off (400 points)</option>	     				
	     				<?php
	     			} else {
	     				?>
	     				<option value="0.1" points="100">10% Off (100 points)</option>
	     				<option value="0.2" points="200">20% Off (200 points)</option>
	     				<option value="0.3" points="300">30% Off (300 points)</option>	
		     			<option value="0.4" points="400">40% Off (400 points)</option>		
	     				<option value="0.5" points="500">50% Off (500 points)</option>
	     				<?php
	     			}
	     			?>

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
<form method="post" action="/invoices/pickup"></form>