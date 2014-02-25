<?php
$this->Html->css(array('admin/invoices_dropoff'),'stylesheet', array('inline' => false)); 
//add scripts to header
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/invoices_edit.js',
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
	<h1 class="heading">Edit Invoice #<?php echo $invoice_id;?></h1>
	<div class="formRow">
		<div class="pull-left span12">
			<ul style="margin-left:0px;" class="number_list unstyled">
				<li class="well well-small" val="C">C</li>
				<li class="well well-small" val="0">0</li>
				<li class="well well-small" val="1">1</li>
				<li class="well well-small" val="2">2</li>
				<li class="well well-small" val="3">3</li>
				<li class="well well-small" val="4">4</li>
				<li class="well well-small" val="5">5</li>
				<li class="well well-small" val="6">6</li>
				<li class="well well-small" val="7">7</li>
				<li class="well well-small" val="8">8</li>
				<li class="well well-small" val="9">9</li>
				<li id="finalTotal" class="well well-small" val="0" style="cursor:default; border: 1px solid #5e5e5e; background-color:#e5e5e5;">--</li>
			</ul>
		</div>

	</div>
	<div class="formRow clearfix">
		<div class="pull-left span6 tabbable-bordered">
			<ul class="nav nav-tabs">
			<?php
			$udx = -1;
			$active_inv_id = '';
			foreach ($inv_groups as $ig) {
				$inv_id = $ig['Inventory']['id'];
				$inv_name = $ig['Inventory']['name'];
				$inv_desc = $ig['Inventory']['description'];
				$udx++;
				if($udx == 0){
					$li_class = 'active';
					$active_inv_id = $inv_id;
				} else {
					$li_class = '';
				}
				?>
				<li class="<?php echo $li_class;?>" >
					<a href="#inventory-<?php echo $inv_id;?>" data-toggle="tab"><?php echo $inv_name;?></a>
				</li>
				<?php
			}
			?>
				
			</ul>
			<div class="tab-content">
		
			<?php
			foreach ($inv_groups as $ig) {
				$inventory_id = $ig['Inventory']['id'];
				if($inventory_id == $active_inv_id){
					$active_class = 'tab-pane active';
				} else {
					$active_class = 'tab-pane';
				}
				?>
				<div id="inventory-<?php echo $inventory_id;?>" class="<?php echo $active_class;?>">
				<?php				
				foreach ($inv_items as $ii) {
					$ii_id = $ii['Inventory_item']['id'];
					$ii_inv_id = $ii['Inventory_item']['inventory_id'];
					$ii_name = $ii['Inventory_item']['name'];
					$ii_desc = $ii['Inventory_item']['description'];
					$ii_price = $ii['Inventory_item']['price'];
					$ii_image = $ii['Inventory_item']['image'];
					if($ii_inv_id == $inventory_id){

					?>
					<div id="item-<?php echo $ii_id;?>" class="inventory_item well well-small span2 pull-left" price="<?php echo $ii_price;?>" item="<?php echo $ii_name;?>" style="margin-left:0px; margin-right:7px;">
						<p style="text-align:center;"><img style="height:50px; width:50px;" src="<?php echo $ii_image;?>" alt="No Image"/></p>
						<p style="text-align:center; line-height:80%;">$<?php echo $ii_price;?></p>
						<p style="text-align:center; line-height:80%;"><?php echo $ii_name;?></p>
					
					</div>
					<?php
					}
				}					
					
				?>
				</div>
				<?php
			}
			?>
			</div>
		</div>
		<div class="pull-left span6 well well-small" style="background-color:#ffffff">
			<form id="invoiceForm" method="post" action="/invoices/process_edit">
				<legend>Invoice Summary</legend>
				<table id="invoiceTable" class="table table-bordered table-condensed">
					
					<thead>
						<tr>
							<th>Qty</th>
							<th>Item(s)</th>
							<th>Color(s)</th>
							<th>Price</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="invoiceTbody">
					<?php
					$item_colors = '';
					foreach ($invoices as $inv) {
						$items = json_decode($inv['Invoice']['items'],true);
						
						if(count($items)>0){
							
							foreach ($items as $ikey => $ivalue) {

								$item_qty = $ivalue['quantity'];
								$item_name = $ivalue['name'];
								$item_bt = $ivalue['before_tax'];
								$item_id = $ivalue['item_id'];
								
								if(isset($ivalue['colors'])){
									$item_colors = $ivalue['colors'];
								} else {
									$item_colors = array();	
								}

								?>
								<tr id="invoice_item_td-<?php echo $item_id;?>" class="invoice_item_td" status="notactive">
									<td class="quantityTd"><?php echo $item_qty;?></td>
									<td class="itemTd"><?php echo $item_name;?></td>
									<td class="colorsTd">
										<ul class="unstyled" count="0">
										<?php
										if(count($item_colors)>0){
											foreach ($item_colors as $ckey => $cvalue) {
												$color_qty = $cvalue['quantity'];
												$color_name = $cvalue['color'];

												if($color_qty > 1){
	
													$color_title = '('.$color_qty.'x) '.$color_name;
												} else {
													$color_title = $color_name;
												}
												
												?>
												<li class="badge badge-inverse pull-left" color="<?php echo $color_name;?>" count="<?php echo $color_qty;?>"><?php echo $color_title;?></li>
												<?php
											}
										}										
										?>											
										</ul>
									</td>
									<td class="priceTd">
										<div class="input-prepend">
											<span class="add-on">$</span>
											<input type="text" class="span4" value="<?php echo $item_bt;?>" name="data[delete]"/>
										</div>
									</td>
									<td>
										<a class="removeRow">remove</a>
										<div class="invoiceData hide">
											<input id="invoiceItemInput-quantity" type="hidden" name="data[Invoice][items][<?php echo $item_id;?>][quantity]" value="<?php echo $item_qty;?>"/>
											<input id="invoiceItemInput-name" type="hidden" name="data[Invoice][items][<?php echo $item_id;?>][name]" value="<?php echo $item_name;?>"/>
											<input id="invoiceItemInput-before_tax" type="hidden" name="data[Invoice][items][<?php echo $item_id;?>][before_tax]" value="<?php echo $item_bt;?>"/>
											<input id="invoiceItemInput-item_id" type="hidden" name="data[Invoice][items][<?php echo $item_id;?>][item_id]" value="<?php echo $item_id;?>"/>											
										</div>
									</td>
								</tr>
								<?php

							}
						}
					}
					?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3"></th>
							<th>Total Qty</th>
							<td id="total_qty"></td>
						</tr>
						<tr>
							<th colspan="3"></th>
							<th>Total Pre-tax</th>
							<td id="total_pretax"></td>
						</tr>
						<tr>
							<th colspan="3"></th>
							<th>Total Tax</th>
							<td id="total_tax"></td>
						</tr>
						<tr>
							<th colspan="3"></th>
							<th>Total After-tax</th>
							<td id="total_aftertax"></td>
						</tr>
					</tfoot>
				</table>
				<div id="hiddenInvoiceDiv" class="hide">
					<input type="hidden" name="data[Invoice][invoice_id]" value="<?php echo $invoice_id;?>"/>
					<input id="due_date_input" type="hidden" name="data[Invoice][due_date]" value="<?php echo $due_date;?>"/>
				</div>
				<div id="hiddenTotalsDiv" class="hide"></div>
			</form>
		</div>
	</div>
	<div class="formRow clearfix">
		<div class="span12 well well-small" style="margin-top:15px;">
			<legend>Select a color</legend>
			<ul class="colorUl unstyled">
				<li class="span1 well well-small" style="background-color:#ffffff;" color="black">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:#000000"/></p>
					<p style="text-align:center; line-height:80%;">Black</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;" color="white">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:#ffffff"/></p>
					<p style="text-align:center; line-height:80%;">White</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;" color="red">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:red"/></p>
					<p style="text-align:center; line-height:80%;">Red</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;" color="green">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:green"/></p>
					<p style="text-align:center; line-height:80%;">Green</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;" color="yellow">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:yellow"/></p>
					<p style="text-align:center; line-height:80%;">Yellow</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;" color="blue">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:blue"/></p>
					<p style="text-align:center; line-height:80%;">Blue</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;" color="tan">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:tan"/></p>
					<p style="text-align:center; line-height:80%;">Tan</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;" color="pink">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:pink"/></p>
					<p style="text-align:center; line-height:80%;">Pink</p>
				</li>			
				<li class="span1 well well-small" style="background-color:#ffffff;" color="purple">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:purple"/></p>
					<p style="text-align:center; line-height:80%;">Purple</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;" color="brown">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:brown"/></p>
					<p style="text-align:center; line-height:80%;">Brown</p>
				</li>
			</ul>
		</div>
	</div>
	<div class="formRow ">
		<div class="formSep"></div>
		<form action="/invoices/process_dropoff/">
			<input id="tax_rate" type="hidden" name="tax_rate" value="<?php echo $tax_rate;?>"/>

		</form>
		<div class="clearfix">
			<button id="cancelDropOffButton" class="btn btn-danger pull-left">Cancel</button>
			  <!-- Button trigger modal -->
  			<a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg pull-right">Finish</a>

		</div>

	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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