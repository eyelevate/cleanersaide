<?php
//load styles & scripts to layout
echo $this->Html->script(array(
	'admin/plugins/validation/jquery.validate.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/inventories.js'),
	FALSE
);



//set page variables
foreach ($inventories as $inventory) {
	$name = $inventory['Inventory']['name'];
	
	$base = $inventory['Inventory']['overlength_feet'];
	$rate = $inventory['Inventory']['overlength_rate'];
	
	if(!empty($inventory['Inventory']['towed_units'])){
		$towed = json_decode($inventory['Inventory']['towed_units'],true);
	} else {
		$towed = array();
	}
	$reservable = $inventory['Inventory']['reservable'];
	$total_units = $inventory['Inventory']['total_units'];
	$online_oneway = $inventory['Inventory']['online_oneway'];
	$online_roundtrip = $inventory['Inventory']['online_roundtrip'];
	$phone_oneway = $inventory['Inventory']['phone_oneway'];
	$phone_roundtrip = $inventory['Inventory']['phone_roundtrip'];
}





?>
<div class="row-fluid">
	<?php
	echo $this->Form->create();
	?>
	<fieldset class="formSep">
		<h4 class="heading">Edit an Inventory Type</h4>
		<div class="form-horizontal">
			<?php
			echo $this->Form->input('name',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Inventory Type Name <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'value'=>$name,
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			?>
		</div>
	</fieldset>
	<fieldset class="formSep">
		<h4 class="heading">Overlength Vehicle Details <small><em>If Applicable</em></small></h4>
		<div class="form-horizontal">
		<?php
		echo $this->Form->input('overlength_feet',
	    	array(
	        	'div' => array('class' => 'control-group'),
	        	'label'=>false,
	        	'before' => '<label class="control-label">Base Unit Length</label><div class="controls"><div class="input-append">',
	        	'after'=>'<span class="add-on">Feet</span></div><span class="help-block"></span></div>',
	        	'class' => 'overlength_base_unit',
	        	'placeholder'=>'Base Unit Length',
	        	'value'=>$base,
	        	'error' => array('attributes' => array('class' => 'controls text-error')),
			)	
		);
		echo $this->Form->input('overlength_rate',
	    	array(
	        	'div' => array('class' => 'control-group'),
	        	'label'=>false,
	        	'before' => '<label class="control-label">Extra Footage Charge</label><div class="controls"><div class="input-prepend"><span class="add-on">US$</span>',
	        	'after'=>'</div><span class="help-block"></span></div>',
	        	'class' => 'overlength_extra_fee',
	        	'placeholder'=>'Extra Footage Charge',
	        	'value'=>$rate,
	        	'error' => array('attributes' => array('class' => 'controls text-error')),
			)	
		);
		?>
		</div>
	</fieldset>
	<fieldset class="formSep">
		<h4 class="heading">Towed Unit Details <small><em>If Applicable</em></small></h4>
		<div class="form-horizontal">
			<?php
			echo $this->Form->input('NULL.towedUnitName',
		    	array(
		        	'div' => array('class' => 'control-group'),
		        	'label'=>false,
		        	'before' => '<label class="control-label">Towed Unit Name</label><div class="controls">',
		        	'after'=>'<span class="help-block"></span></div>',
		        	'class' => 'towed_unit_name',
		        	'placeholder'=>'Towed Unit Name',
		        	'error' => array('attributes' => array('class' => 'controls text-error')),
				)	
			);
			echo $this->Form->input('NULL.towedUnitDescription',
		    	array(
		        	'div' => array('class' => 'control-group'),
		        	'label'=>false,
		        	'before' => '<label class="control-label">Towed Unit Description</label><div class="controls">',
		        	'after'=>'<span class="help-block"></span></div>',
		        	'class' => 'towed_unit_description',
		        	'placeholder'=>'Short description of inventory',
		        	'error' => array('attributes' => array('class' => 'controls text-error')),
				)	
			);		
			?>
			<div class="controls">
				<button id="addTowedUnit" type="button" class="btn btn-small btn-info">Add Towed Unit</button>
			</div>
		</div>
	</fieldset>
		<div class="formSep">
			<h4 class="heading">Created Towed Units</h4>
			<ol class="towedUnitsOl">
			<?php
				$idx = -1;
				if(!empty($towed)){
					foreach ($towed as $tu) {
						$idx = $idx+1;
						$towed_name = $tu['name'];
						$towed_desc = $tu['desc'];
						?>
						<li class="alert alert-info" style="margin-bottom:2px">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?php echo $towed_name.' ('.$towed_desc.')';?>
							<input type="hidden" name="data[Inventory][towed_units][<?php echo $idx;?>][name]" value="<?php echo $towed_name;?>"/>
							<input type="hidden" name="data[Inventory][towed_units][<?php echo $idx;?>][desc]" value="<?php echo $towed_desc;?>"/>
						</li>
						<?php
					}
				}
			?>	
			</ol>
		</div>
	<fieldset class="formSep">
		<h4 class="heading">Reservation Fees <small><em>This is the surcharge on top of the ticket price for online or phone reservations</em></small></h4>
		<div class="form-horizontal">
			<?php
			echo $this->Form->input('online_oneway',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Online One Way <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">US$</span>',
				'after'=>'</div></div>',
				'class'=>'online_oneway',
				'value'=>$online_oneway,
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('online_roundtrip',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Online Round-Trip <span class="f_req">*</span></label><div class="controls"><div class="input-prepend input-append"><span class="add-on">US$</span>',
				'after'=>'</div></div>',
				'class'=>'online_roundtrip',
				'value'=>$online_roundtrip,
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('phone_oneway',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Phone One Way <span class="f_req">*</span></label><div class="controls"><div class="input-prepend input-append"><span class="add-on">US$</span>',
				'after'=>'</div></div>',
				'class'=>'phone_oneway',
				'value'=>$phone_oneway,
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('phone_roundtrip',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Phone Round-Trip <span class="f_req">*</span></label><div class="controls"><div class="input-prepend input-append"><span class="add-on">US$</span>',
				'after'=>'</div></div>',
				'class'=>'phone_roundtrip',
				'value'=>$phone_roundtrip,
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			?>
		</div>
	</fieldset>
	<fieldset class="formSep">
		<h4 class="heading">Inventory Limits</h4>
		<div class="form-horizontal">
			<?php
			echo $this->Form->input('reservable',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Reservable Units <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">#</span>',
				'after'=>'<span class="add-on">Units</span></div><span class="help-block"></span></div>',
				'value'=>$reservable,
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('total_units',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Total Units <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">#</span>',
				'after'=>'<span class="add-on">Units</span></div><span class="help-block"></span></div>',
				'value'=>$total_units,
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));			
			$capacity = sprintf('%.2f',round($reservable/$total_units,2))*100;
			echo $this->Form->input('capacity',array(
				'div'=>'control-group',
				'label'=>false,
				'disabled'=>'disabled',
				'before'=>'<label class="control-label">Capacity </label><div class="controls"><div class="input-append">',
				'after'=>'<span class="add-on">%</span></div><span class="help-block"></span></div>',
				'class'=>'span4',
				'value'=> $capacity,
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));					
			?>
		</div>
	</fieldset>
	<div class="formRow">
		<?php
		echo $this->Form->submit('Save Inventory',array('class'=>'pull-right btn btn-large btn-primary'));
		?>
	</div>
</div>