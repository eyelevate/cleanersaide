<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/package_add_ons.js'
	),
	FALSE
);	
if(count($add_ons)>0){
	foreach ($add_ons as $ao) {
		$name=$ao['PackageAddOn']['name'];
		$description = $ao['PackageAddOn']['description'];
		$inventory = $ao['PackageAddOn']['inventory'];
		$country = $ao['PackageAddOn']['country'];
		$net = $ao['PackageAddOn']['net'];
		$exchange = $ao['PackageAddOn']['exchange'];
		$markup = $ao['PackageAddOn']['markup'];
		$gross = $ao['PackageAddOn']['gross'];
		$status = $ao['PackageAddOn']['status'];
		$type = $ao['PackageAddOn']['type'];
		
		$vouchers = json_decode($ao['PackageAddOn']['vouchers'],true);
		$voucher_quantity = $ao['PackageAddOn']['print_quantity'];
	}
} else {
	$name='';
	$description ='';
	$inventory ='';
	$country ='';
	$net ='';
	$exchange ='';
	$markup ='';
	$gross ='';
	$status ='';	
	$type = 'person';
	$voucher_quantity = 0;
	$vouchers = array();
}

?>


<div class="packageAddOns form">
<?php echo $this->Form->create('PackageAddOn'); ?>
	<fieldset>
		<legend><?php echo __('Package Add-On'); ?></legend>
		<div class="form-actions">
			<h3>General Information</h3>
		<?php
		$status = array(
			'1'=>'Select Status',
			'2'=>'Unbookable',
			'5'=>'Bookable, but not public',
			'6'=>'Bookable, and public'
		);
		echo $this->Form->input('status', array(
			'options'=>$status,
			'class'=>'statusSelect',
			'label'=>'Status <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group controls clearfix'),
			'error'=>array('attributes' => array('class' => 'help-block')),
			'default'=>$status
		));	
		echo $this->Form->input('name',array(
			'label'=>'Name <span class="f_req">*</span>',
			'placeholder'=>'Insert name of add-on',
			'class'=>'span6',
			'div'=>'control-group',
			'value'=>$name,
			'error'=>array('attributes' => array('class' => 'help-block')),	
		));
		echo $this->Form->input('description',array(
			'label'=>'Description <span class="f_req">*</span>',
			'class'=>'span6',
			'div'=>'control-group',
			'value'=>$description,
			'error'=>array('attributes' => array('class' => 'help-block')),
		));
		echo $this->Form->input('inventory',
	    	array(
	        	'div' => array('class' => 'control-group'),
	        	'label'=>false,
	        	'before' => '<label class="control-label">Inventory <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">#</span>',
	        	'after'=>'</div><span class="help-block"></span></div>',
	        	'class' => 'addonInventory',
	        	'placeholder'=>'Inventory levels',
	        	'value'=>$inventory,
	        	'type'=>'text',
	        	'error'=>array('attributes' => array('class' => 'help-block')),	
			)	
		);	
		?>	
	
		</div>

	</fieldset>
	<fieldset class="clearfix">
		<legend>Add-on Voucher Printing Details</legend>
		<div class="form-actions">
			<div class="control-group">
				<label>Select Add-on Type (How add on will process) <span class="f_req">*</span></label>
				<div>
					<?php
					if($type == 'person'){
					?>
					<label class="radio"><input type="radio" name="data[PackageAddOn][type]" value="person" checked="checked"/> Per Person</label>
					<label class="radio"><input type="radio" name="data[PackageAddOn][type]" value="trip"/> Per Trip</label>
					<?php						
					} else {
					?>
					<label class="radio"><input type="radio" name="data[PackageAddOn][type]" value="person" /> Per Person</label>
					<label class="radio"><input type="radio" name="data[PackageAddOn][type]" value="trip" checked="checked"/> Per Trip</label>
					<?php							
					}
					?>
				</div>
			</div>	

			<div class="control-group">
				<label>How many vouchers per add-on type? <span class="f_req">*</span></label>
				<div class="input-prepend input-append">
					<span class="add-on">#</span>
					<input type="text" id="PackageAddOnVouchersQuantityEdit" name="data[PackageAddOn][print_quantity]" value="<?php echo $voucher_quantity;?>"/>
					<a id="PackageAddOnVouchersQuantityEditButton" class="add-on"  style="cursor:pointer;">create</a>
				</div>
				<span class="help-block"></span>
			</div>	

			<div id="side_accordion2" class="accordion">
			<?php

			foreach ($vouchers as $key => $value) {
				$name = $value['name'];
				$description = $value['description'];
				?>
				<div class="accordion-group" type="edit" new="No">
					<div class="accordion-heading">
						<a href="#collapse-<?php echo $key;?>" data-parent="#side_accordion2" data-toggle="collapse" class="accordion-toggle collapsed"> Voucher #<span class="voucher_number"><?php echo $key+1;?></span></a>
					</div>
					<div class="accordion-body collapse" id="collapse-<?php echo $key;?>">
						<div class="accordion-inner">
							<div class="control-group">
								<label>Voucher Name <span class="f_req">*</span></label>
								<input id="PackageAddOnVouchersName-<?php echo $key;?>" type="text" class="PackageAddOnVouchersName" name="data[PackageAddOn][vouchers][<?php echo $key;?>][name]" value="<?php echo $name;?>"/>
								<span class="help-block"></span>
							</div>
							<div class="control-group">
								<label>Voucher Description <span class="f_req">*</span></label>
								<textarea id="PackageAddOnVouchersDescription-<?php echo $key;?>" class="PackageAddOnVouchersDescription span5" cols="50" name="data[PackageAddOn][vouchers][<?php echo $key;?>][description]"><?php echo $description;?></textarea>
								<span class="help-block"></span>
							</div>
							<div>
								<button id="removeVoucher-<?php echo $key;?>" type="button" class="removeVoucher btn btn-danger">Remove</button>
							</div>
						</div>
						
					</div>
				</div>		
				<?php		
			}
			
			?>
			</div>

		</div>
	</fieldset>	
	
	
	
	<fieldset>

		<div class="form-actions">	
		<div class="control-group">
			<label>Select Taxes</label>
			<select id="selectTaxes">
				<option value="">Select Tax</option>
			<?php
			foreach ($taxes as $t) {
				$tax_id = $t['Tax']['id'];
				$tax_name = $t['Tax']['name'];
				$tax_country = $t['Tax']['country'];
				$tax_rate = $t['Tax']['rate'];
				$tax_basis = $t['Tax']['per_basis'];
				?>
				<option value="<?php echo $tax_rate;?>" tax_id="<?php echo $tax_id;?>" tax_name="<?php echo $tax_name;?>" tax_country="<?php echo $tax_country;?>" tax_basis="<?php echo $tax_basis;?>">
					<?php echo $tax_name.' ['.$tax_country.']';?>
				</option>
				
				<?php
			}
			?>
			</select>
			<span class="help-block"></span>
		</div>
		<div class="formSep">
			<h5>Taxes Selected</h5>
			<div id="taxesSelectedDiv" class="well well-small">
			<?php
			foreach ($tax_array as $ts) {
				$tax_id = $ts['tax_id'];
				$tax_name = $ts['tax_name'];
				$tax_country = $ts['tax_country'];
				$tax_rate = $ts['tax_rate'];
			?>
			<div class="taxesRatesDivs alert alert-info form-horizontal" style="margin-bottom:2px;">
				<button id="removeTax-0" type="button" class="removeTax pull-right" ><icon class="icon-trash"></icon></button>
				<label class="control-label"><?php echo $tax_name;?></label>
				<div class="controls">
					<div class="input-append">
						
						<input id="taxesInput-<?php echo $tax_id;?>" class="taxesInput" name="" type="text" disabled="disabled" value="<?php echo $tax_rate;?>"/>
						<span class="add-on"><?php echo $tax_country;?></span>
					</div>
					<input type="hidden" name="data[PackageAddOn][0][taxes][<?php echo $tax_id;?>]" value="<?php echo $tax_id;?>"/>
				</div>
				
			</div>			
			<?php				
			}
			?>	
			</div>
		</div>
		<h5 class="heading">Set Rates</h5>

		<?php
		if($country == 1){
		?>
		<div>
			<label class="checkbox"><input id="checkNetCanadian" type="checkbox" /> Check If Canadian Net Rate</label>
			<input id="country" type="hidden" name="data[PackageAddOn][country]" value="1"/>
		</div>
		<table id="usTable" class="table table-hover table-bordered table-striped">
			<thead>
				<tr>
					<th>Net</th>
					<th>Markup</th>
					<th>Gross</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					<?php
					echo $this->Form->input('net',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>$net,
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('markup',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-append">',
						'after'=>'<span class="add-on">%</span></div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>$markup
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('gross',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'type'=>'text',
						'value'=>$gross
					));
					?>
					</td>
				</tr>
			</tbody>
		</table>
		<table id="canTable" class="table table-hover table-bordered table-striped hide">
			<thead>
				<tr>
					<th>Net</th>
					<th>Exchange</th>
					<th>Markup</th>
					<th>Gross</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					<?php
					echo $this->Form->input('net',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>'',
						'disabled'=>'disabled'
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('exchange',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-append">',
						'after'=>'<span class="add-on">US$</span></div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>$exchange,
						'disabled'=>'disabled'
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('markup',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-append">',
						'after'=>'<span class="add-on">%</span></div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>'',
						'disabled'=>'disabled'
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('gross',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>'',
						'disabled'=>'disabled'
					));
					?>
					</td>

				</tr>
			</tbody>
		</table>	
		<?php
		} else {
		?>
		<div>
			<label class="checkbox"><input id="checkNetCanadian" type="checkbox" checked="checked"/> Check If Canadian Net Rate</label>
			<input id="country" type="hidden" name="data[PackageAddOn][country]" value="2"/>
		</div>
		<table id="usTable" class="table table-hover table-bordered table-striped hide">
			<thead>
				<tr>
					<th>Net</th>
					<th>Markup</th>
					<th>Gross</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					<?php
					echo $this->Form->input('net',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>'',
						'disabled'=>'disabled'
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('markup',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-append">',
						'after'=>'<span class="add-on">%</span></div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>'',
						'disabled'=>'disabled'
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('gross',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>'',
						'disabled'=>'disabled'
					));
					?>
					</td>
				</tr>
			</tbody>
		</table>
		<table id="canTable" class="table table-hover table-bordered table-striped">
			<thead>
				<tr>
					<th>Net</th>
					<th>Exchange</th>
					<th>Markup</th>
					<th>Gross</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					<?php
					echo $this->Form->input('net',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>$net,
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('exchange',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-append">',
						'after'=>'<span class="add-on">US$</span></div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>$exchange
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('markup',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-append">',
						'after'=>'<span class="add-on">%</span></div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>$markup
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('gross',array(
						'div'=>array('class'=>'control-group'),
						'type'=>'text',
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
						'value'=>$gross
					));
					?>
					</td>

				</tr>
			</tbody>
		</table>	
		<?php
		}	
		?>
		</div>

	</fieldset>
<?php 
echo $this->Form->submit(__('Submit'),array('class'=>'btn btn-primary'));
echo $this->Form->end(); 

?>
</div>

