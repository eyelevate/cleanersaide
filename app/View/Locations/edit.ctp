<?php
echo $this->Html->script(array('admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js','locations.js'),FALSE);

if(!empty($locations)){
	foreach ($locations as $location) {
		$name = $location['Location']['name'];
		$city = $location['Location']['city'];
		$state = $location['Location']['state'];
		$country = $location['Location']['country'];
		//$zipcode = $location['Location']['zipcode'];
	}
} else {
	$name = '';
	$city = '';
	$state ='';
	$country = '';
	//$zipcode = '';	
}
?>
<div class="row-fluid">
	<h4 class="heading">Edit Location</h4>
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
		'after'=>'</div>',
		'value'=>$name
	));
	echo $this->Form->input('city',array(
		'label'=>false,
		'div'=>'control-group',
		'type'=>'text',
		'class'=>'locationCity',
		'before'=>'<label class="control-label">City</label><div class="controls">',
		'after'=>'</div>',
		'value'=>$city
	));
	echo $this->Form->input('state',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'locationState',
		'before'=>'<label class="control-label">State</label><div class="controls">',
		'after'=>'</div>',
		'value'=>$state
	));
	echo $this->Form->input('country',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'taxrate',
		'options'=>array(''=>'Select Country','CAN'=>'Canada','USA'=>'United States'),
		'before'=>'<label class="control-label">Country</label><div class="controls">',
		'after'=>'</div>',
		'default'=>$country
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