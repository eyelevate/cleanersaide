<?php
echo $this->Html->script(array('admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js','locations.js'),FALSE);

?>
<div class="row-fluid">
	<h4 class="heading">Create Location</h4>
	<div>
	<?php
	echo $this->Form->create('',array(
		'class'=>'form-horizontal'
	));
	echo $this->Form->input('name',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'locationName',
		'before'=>'<label class="control-label">Location Name</label><div class="controls">',
		'after'=>'</div>'
	));
	echo $this->Form->input('city',array(
		'label'=>false,
		'div'=>'control-group',
		'type'=>'text',
		'class'=>'locationCity',
		'before'=>'<label class="control-label">City</label><div class="controls">',
		'after'=>'</div>',
		'data-provide'=>'typeahead',
		'data-link'=>'/hotels/getCities',
		'autocomplete'=>'off',
		'id'=>'city',
		'type'=>'text',
		'error'=>array('attributes' => array('class' => 'help-block'))
	));
	echo $this->Form->input('state',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'locationState',
		'before'=>'<label class="control-label">State</label><div class="controls">',
		'after'=>'</div>'
	));
	echo $this->Form->input('country',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'locationCountry',
		'options'=>array(''=>'Select Country','CAN'=>'Canada','USA'=>'United States'),
		'before'=>'<label class="control-label">Country</label><div class="controls">',
		'after'=>'</div>'
	));
	echo $this->Form->submit('Add Location',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'btn btn-primary',
		'before'=>'<div class="controls">',
		'after'=>'</div>',
	));
	echo $this->Form->end();
	
	?>
	</div>
</div>