<?php
$this->Html->css(array('admin/invoices_dropoff'),'stylesheet', array('inline' => false)); 
//add scripts to header
echo $this->Html->script(array('admin/invoices_dropoff.js'),FALSE);

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
			<legend>Invoice Summary</legend>
			<table class="table table-bordered table-condensed table-hover table-striped">
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
						<td></td>
					</tr>
					<tr>
						<th colspan="3"></th>
						<th>Total Pre-tax</th>
						<td></td>
					</tr>
					<tr>
						<th colspan="3"></th>
						<th>Total Tax</th>
						<td></td>
					</tr>
					<tr>
						<th colspan="3"></th>
						<th>Total After-tax</th>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="formRow clearfix">
		<div class="span12 well well-small" style="margin-top:15px;">
			<legend>Select a color</legend>
			<ul class="colorUl unstyled">
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:#000000"/></p>
					<p style="text-align:center; line-height:80%;">Black</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:#ffffff"/></p>
					<p style="text-align:center; line-height:80%;">White</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:red"/></p>
					<p style="text-align:center; line-height:80%;">Red</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:green"/></p>
					<p style="text-align:center; line-height:80%;">Green</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:yellow"/></p>
					<p style="text-align:center; line-height:80%;">Yellow</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:blue"/></p>
					<p style="text-align:center; line-height:80%;">Blue</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:tan"/></p>
					<p style="text-align:center; line-height:80%;">Tan</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:pink"/></p>
					<p style="text-align:center; line-height:80%;">Pink</p>
				</li>			
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:purple"/></p>
					<p style="text-align:center; line-height:80%;">Purple</p>
				</li>
				<li class="span1 well well-small" style="background-color:#ffffff;">
					<p style="text-align:center;"><img style="height:50px; width:50px; background-color:brown"/></p>
					<p style="text-align:center; line-height:80%;">Brown</p>
				</li>
			</ul>
		</div>
	</div>
	<div class="formRow ">
		<div class="formSep"></div>
		<form action="/invoices/process_dropoff/"></form>
		<div class="clearfix">
			<button class="btn btn-danger pull-left">Cancel</button>
			<button class="btn btn-primary pull-right">Finish</button>
		</div>
	</div>
</div>