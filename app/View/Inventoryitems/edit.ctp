<?php
//load styles & scripts to layout
$this->Html->css(array('admin/inventory_item_add'),'stylesheet', array('inline' => false)); 


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
	$name = $ii['Inventory_item']['name'];
	$desc = $ii['Inventory_item']['description'];
	$price = $ii['Inventory_item']['price'];
	$tags = $ii['Inventory_item']['tags'];
	$order = $ii['Inventory_item']['order'];
	$image = $ii['Inventory_item']['image'];

}
?>


<div class="row-fluid">
	<fieldset class="formSep">
		<legend>Create A New Inventory Item</legend>
	<?php
	echo $this->Form->create('Inventory_item');

	echo $this->Form->input('inventory_id', 
		array(
			'options' => $inv_array, 
			'empty' => '(choose one)',
			'selected'=>$inventory_id,
			'div' => array('class' => 'control-group', 'id'=>'invNameDiv'),
	    	'label'=>false,
	    	'before' => '<label class="control-label">Inventory Group <span class="f_req">*</span></label><div class="controls">',
	    	'after'=>'<span class="help-block"></span></div>',
			'class' => 'inventory_type span6',
			'error' => array('attributes' => array('class' => 'text-error')),
		)
	);
	echo $this->Form->input('name',
    	array(
        	'div' => array('class' => 'control-group', 'id'=>'invNameDiv'),
	    	'label'=>false,
	    	'value'=>$name,
	    	'before' => '<label class="control-label">Name <span class="f_req">*</span></label><div class="controls">',
	    	'after'=>'<span class="help-block"></span></div>',
        	'class' => 'inventory_name span6',
        	'error' => array('attributes' => array('class' => 'text-error')),
        	'placeholder'=>'Enter vehicle type here'
		)
	);
	echo $this->Form->input('description',
    	array(
        	'div' => array('class' => 'control-group', 'id'=>'invDescriptionDiv'),
	    	'label'=>false,
	    	'value'=>$desc,
	    	'before' => '<label class="control-label">Description <span class="f_req">*</span></label><div class="controls">',
	    	'after'=>'<span class="help-block"></span></div>',
	    	'error' => array('attributes' => array('class' => 'text-error')),
        	'class' => 'vehicle_description span6',
        	'placeholder'=>'Short description of vehicle'
		)	
	);
	
	echo $this->Form->input('price',
		array(
	    	'div' => array('class' => 'control-group'),
	    	'label'=>false,
	    	'type'=>'text',
	    	'value'=>$price,
	    	'before' => '<label class="control-label">Price <span class="f_req">*</span></label><div class="controls"><div class="input-prepend"><span class="add-on">US$</span>',
	    	'after'=>'</div><span class="help-block"></span></div>',
	    	'class' => 'price',
	    	'placeholder'=>'Set price of item',
		)	
	);

	?>
	</fieldset>
	<fieldset class="formSep">
		<legend>Select Image</legend>
		<div class="well well-small">
			<ul class="unstyled clearfix">

				<?php
				foreach ($images as $image_key => $image_src) {
				?>
				<li class="inventoryImage pull-left"><img style="height:75px; width:75px;" src="<?php echo $image_src;?>"/></li>
				<?php
				}
				?>

				
			</ul>
		</div>
		<div id="selectedImageDiv">
			<input id="imageInput" type="hidden" name="data[Inventory_item][image]" value="<?php echo $image;?>"/>
		</div>
	</fieldset>
	<div class="formRow">
	<?php
	echo $this->Form->submit('Create Inventory Item',array('class'=>'btn btn-large btn-primary pull-right'));
	?>	
	</div>
	<?php
	echo $this->Form->end();
	
	?>		

</div>