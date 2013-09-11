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
		<table class="table table-bordered">
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
					$total = sprintf('%.2f',$inv['Invoice']['total']);
					$created = date('D n/d/y',strtotime($inv['Invoice']['created']));
					$due_date = date('D n/d/y',strtotime($inv['Invoice']['due_date']));


				?>
					<tr>
						<td><input type="checkbox"/></td>
						<td><?php echo $invoice_id;?></td>
						<td></td>
						<td><?php echo $created;?></td>
						<td><?php echo $due_date;?></td>
						<td><?php echo $quantity;?></td>
						<td>$<?php echo $before_tax;?></td>
						<td>$<?php echo $tax;?></td>	
						<td>$<?php echo $total;?></td>
					</tr>
				<?php
				}
				?>				
			</tbody>
		</table>
	</div>
	<div class="formRow span3 pull-left">
		<legend>Selected Invoice Totals</legend>
		<table class="table table-bordered table-hover table-striped">
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
					<td></td>
					<td></td>
				</tr>
				<tr>
					<th>Before Tax</th>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<th>Tax</th>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<th>Discount</th>
					<td></td>
					<td><button class="btn btn-info">Add</button></td>
				</tr>

			</tbody>
			<tfoot>
				<tr>
					<th style="border-top:2px solid #5e5e5e;">Totals</th>
					<td style="border-top:2px solid #5e5e5e;"></td>
					<td style="border-top:2px solid #5e5e5e;"><button class="btn btn-primary">Finish</button></td>
				</tr>				
			</tfoot>
		</table>
	</div>
	<div class="form_row span8 clearfix" style="margin-left:0px;">
		<legend>Selected Invoice Summary</legend>
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
				
					//switch qty
					if($item_colors > 0){
						foreach ($item_colors as $ikey => $ivalue) {
							$color_qty = $ivalue['quantity'];
							$color_name = $ivalue['color'];
							if($color_qty >1){
								$color_list = '('.$color_qty.') '.$color_name.', '; 
							} else {
								$color_list = $color_name.', '; 
							}
						}
						
					}
					
					$color_list = substr($color_list,0,-2);
					?>
					<tr id="invoiceSummary-<?php echo $invoice_id;?>" class="hide">
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