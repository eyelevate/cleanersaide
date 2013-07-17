<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/package_add_ons.js'
	),
	FALSE
);	


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
			'default'=>'6'
		));	
		echo $this->Form->input('name',array(
			'label'=>'Name <span class="f_req">*</span>',
			'placeholder'=>'Insert name of add-on',
			'class'=>'span6',
			'div'=>'control-group',
			'error'=>array('attributes' => array('class' => 'help-block')),	
		));
		echo $this->Form->input('description',array(
			'label'=>'Description <span class="f_req">*</span>',
			'class'=>'span6',
			'div' => array('class' => 'control-group'),
			'error'=>array('attributes' => array('class' => 'help-block')),
		));
		echo $this->Form->input('inventory',
	    	array(
	        	'div' => array('class' => 'control-group'),
	        	'label'=>false,
	        	'before' => '<label class="control-label">Inventory <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">#</span>',
	        	'after'=>'</div><span class="help-block"></span></div>',
	        	'class' => 'addonInventory',
	        	'type'=>'text',
	        	'placeholder'=>'Inventory levels',
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
					<label class="radio"><input type="radio" name="data[PackageAddOn][type]" value="person" checked="checked"/> Per Person</label>
					<label class="radio"><input type="radio" name="data[PackageAddOn][type]" value="trip"/> Per Trip</label>
				</div>
			</div>	
			<div class="control-group">
				<label>How many vouchers per add-on type? <span class="f_req">*</span></label>
				<div class="input-prepend input-append">
					<span class="add-on">#</span>
					<input type="text" id="PackageAddOnVouchersQuantity" name="data[PackageAddOn][print_quantity]"/>
					<a id="PackageAddOnVouchersQuantityButton" class="add-on"  style="cursor:pointer;">create</a>
				</div>
				<span class="help-block"></span>
			</div>

			<div id="side_accordion2" class="accordion"></div>

		</div>
	</fieldset>

	<fieldset>
		<legend>Tax and Rates</legend>
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
				
			</div>
		</div>
		<h5 class="heading">Set Rates</h5>
		<div>
			<label class="checkbox"><input id="checkNetCanadian" type="checkbox"/> Check If Canadian Net Rate</label>
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
						'label'=>false,
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'type'=>'text',
						'error'=>array('attributes' => array('class' => 'help-block')),	
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('markup',array(
						'div'=>array('class'=>'control-group'),
						'label'=>false,
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<span class="add-on">%</span></div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
					));
					?>
					</td>
					<td>
					<?php
					echo $this->Form->input('gross',array(
						'div'=>array('class'=>'control-group'),
						'label'=>false,
						'type'=>'text',
						'before'=>'<div class="input-prepend"><span class="add-on">US$</span>',
						'after'=>'</div>',
						'error'=>array('attributes' => array('class' => 'help-block')),	
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
					<td class="control-group">
						<div class="input-prepend">
							<span class="add-on">CN$</span>
							<input id="canNet" type="text" disabled="disabled" name="data[PackageAddOn][net]"/>	
						</div>
						<span class="help-block"></span>
					</td>
					<td class="control-group">
						
						<div class="input-append">
							<input id="exchangeRate" type="text" value="<?php echo $exchange;?>" disabled="disabled" name="data[PackageAddOn][exchange]"/>
							<span class="add-on">CAN/US</span>	
						</div>
						<span class="help-block"></span>
					</td>
					<td class="control-group">
						<div class="input-append">
							<input id="markup" type="text" disabled="disabled" name="data[PackageAddOn][markup]"/>	
							<span class="add-on">%</span>
						</div>
						<span class="help-block"></span>
					</td>
					<td class="control-group">
						<div class="input-prepend">
							<span class="add-on">US$</span>
							<input id="gross" type="text" disabled="disabled" name="data[PackageAddOn][gross]"/>	
						</div>
						<span class="help-block"></span>
					</td>
				</tr>
			</tbody>
		</table>		
		</div>


	</fieldset>
<?php 
echo $this->Form->submit(__('Submit'),array('class'=>'btn btn-primary'));
echo $this->Form->end(); 

?>
</div>

