<?php
//load styles & scripts to layout
echo $this->Html->script(array(
	'admin/plugins/validation/jquery.validate.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/inventory_item.js'),
	FALSE
);

//set variables here
$inv_array = array();
foreach ($inventories as $inventory) {
	$inv_array[$inventory['Inventory']['id']]=$inventory['Inventory']['name'];
}

foreach ($inv_items as $ii) {
	$inventory_id = $ii['Inventory_item']['inventory_id'];
	$type = $ii['Inventory_item']['type'];
	$name = $ii['Inventory_item']['name'];
	$desc = $ii['Inventory_item']['description'];
	$overlength = $ii['Inventory_item']['overlength'];
	$inc_units = $ii['Inventory_item']['inc_units'];
	$towed_units =$ii['Inventory_item']['towed_units'];
	$oneway = $ii['Inventory_item']['oneway'];
	$surcharge = $ii['Inventory_item']['surcharge'];
	$total_price = $ii['Inventory_item']['total_price'];
}
?>

<div class="row-fluid">
	<fieldset class="formSep">
		<legend>Edit an Inventory Item</legend>
	<?php
	echo $this->Form->create('Inventory_item');

	echo $this->Form->input('type', 
		array(
			'options' => $inv_array, 
			'empty' => '(choose one)',
			'selected'=>false,
			'div' => array('class' => 'control-group', 'id'=>'invNameDiv'),
			'label' => array('class' => 'control-label'),
			'class' => 'inventory_type span6',
			'error' => array('attributes' => array('class' => 'text-error')),
			'value'=>$inventory_id
		)
	);
	echo $this->Form->input('name',
    	array(
        	'div' => array('class' => 'control-group', 'id'=>'invNameDiv'),
        	'label' => array('class' => 'control-label'),
        	'class' => 'inventory_name span6',
        	'error' => array('attributes' => array('class' => 'text-error')),
        	'placeholder'=>'Enter vehicle type here',
        	'value'=>$name
		)
	);
	echo $this->Form->input('description',
    	array(
        	'div' => array('class' => 'control-group', 'id'=>'invDescriptionDiv'),
        	'label' => array('class' => 'control-label'),
        	'class' => 'vehicle_description span6',
        	'placeholder'=>'Short description of vehicle',
        	'value'=>$desc
		)	
	);
	echo $this->Form->input('overlength',
		array(
	    	'div' => array('class' => 'control-group'),
	    	'label'=>false,
	    	'before' => '<label class="control-label">Overlength Vehicle</label><div class="controls">',
	    	'after'=>'<span class="help-block"></span></div>',
	    	'class' => 'overlength',
			'options'=>array('No'=>'No','Yes'=>'Yes'),
			'default'=>$overlength
		)
	);
	echo $this->Form->input('inc_units',
		array(
	    	'div' => array('class' => 'control-group'),
	    	'label'=>false,
	    	'before' => '<label class="control-label">Incremental Units</label><div class="controls">',
	    	'after'=>'<span class="help-block"></span></div>',
	    	'class' => 'inc_units',
			'options'=>array('No'=>'No','Yes'=>'Yes'),
			'default'=>$inc_units
		)
	);
	echo $this->Form->input('towed_units',
		array(
	    	'div' => array('class' => 'control-group'),
	    	'label'=>false,
	    	'before' => '<label class="control-label">Towed Units</label><div class="controls">',
	    	'after'=>'<span class="help-block"></span></div>',
	    	'class' => 'towed_units',
			'options'=>array('No'=>'No','Yes'=>'Yes'),
			'default'=>$towed_units
		)
	);	
	echo $this->Form->input('oneway',
		array(
	    	'div' => array('class' => 'control-group'),
	    	'label'=>false,
	    	'before' => '<label class="control-label">One Way Rate <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">US$</span>',
	    	'after'=>'</div><span class="help-block"></span></div>',
	    	'class' => 'oneway',
	    	'placeholder'=>'one way rate',
	    	'value'=>$oneway
		)	
	);
	echo $this->Form->input('surcharge',
		array(
	    	'div' => array('class' => 'control-group'),
	    	'label'=>false,
	    	'before' => '<label class="control-label">Surcharge Rate <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">US$</span>',
	    	'after'=>'</div><span class="help-block"></span></div>',
	    	'class' => 'surcharge',
	    	'placeholder'=>'surcharge rate',
	    	'value'=>$surcharge
		)	
	);	
	echo $this->Form->input('total_price',
		array(
	    	'div' => array('class' => 'control-group'),
	    	'label'=>false,
	    	'before' => '<label class="control-label">Total Rate <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">US$</span>',
	    	'after'=>'</div><span class="help-block"></span></div>',
	    	'class' => 'total',
	    	'placeholder'=>'Total rate',
	    	'value'=>$total_price
		)	
	);	
	?>
	</fieldset>
	<div class="formRow">
	<?php
	echo $this->Form->submit('Save Inventory Item',array('class'=>'btn btn-large btn-primary pull-right'));
	?>	
	</div>
	<?php
	echo $this->Form->end();
	
	?>		

</div>