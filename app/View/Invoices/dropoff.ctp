<?php
$this->Html->css(array('admin/invoices_dropoff'),'stylesheet', array('inline' => false)); 
//add scripts to header
echo $this->Html->script(array('admin/invoices_dropoff.js'),FALSE);

$tax_rate  = 0;
if(!empty($taxes)){
	foreach ($taxes as $t) {
		$tax_rate = $t['Tax']['rate'];
	}
}



?>
<div class="row-fluid">
	<h1 class="heading">Drop Off</h1>
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
			<form id="invoiceForm" method="post" action="/invoices/process_dropoff">
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
					<input type="hidden" name="data[Invoice][customer_id]" value="<?php echo $customer_id;?>"/>
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
	      <h4 class="modal-title">Select Invoice Type</h4>
	    </div>
	    <div class="modal-body">
	     	<h3>Would you like to print a customer copy of the invoice?</h3>
	     	<br/><br/>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	      <button id="printCustomerCopy-No" type="button" class="printCustomerCopy btn btn-danger pull-right">No</button>
	      <button id="printCustomerCopy-Yes" type="button" class=" printCustomerCopy btn btn-primary pull-right">Yes</button>
	    </div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->