<?php
echo $this->Html->script(array('admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js','admin/taxes.js'),FALSE);


//set variables
if(!empty($taxes)){
	foreach ($taxes as $tax) {
		$country = $tax['Tax']['country'];
		$name = $tax['Tax']['name'];
		$rate = $tax['Tax']['rate'];
		$perBasis = $tax['Tax']['per_basis'];
	}	
} else {
	$country = '';
	$name = '';
	$rate = '';
	$perBasis = '';	
}

?>
<div class="row-fluid">
	<h4 class="heading">Edit Tax Rate</h4>
	<div>
	<?php
	echo $this->Form->create('',array(
		'class'=>'form-horizontal'
	));
	echo $this->Form->input('name',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'taxName',
		'before'=>'<label class="control-label">Tax Name</label><div class="controls">',
		'after'=>'</div>',
		'value'=>$name
	));
	echo $this->Form->input('country',array(
		'label'=>false,
		'div'=>'control-group',
		'options'=>array(''=>'Select Country','CAN'=>'Canada','USA'=>'United States'),
		'class'=>'taxCountry',
		'before'=>'<label class="control-label">Country</label><div class="controls">',
		'after'=>'</div>',
		'default'=>$country
	));
	echo $this->Form->input('per_basis',array(
		'label'=>false,
		'div'=>'control-group',
		'options'=>array(''=>'Select taxable amount','Per Night or Ticket only'=>'Per night or ticket only','Overall subtotal'=>'Overall subtotal'),
		'default'=>'Overall subtotal',
		'class'=>'taxPerBasis',
		'before'=>'<label class="control-label">Applicable to</label><div class="controls">',
		'after'=>'</div>',
		'default'=>$perBasis
	));
	echo $this->Form->input('rate',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'taxrate',
		'before'=>'<label class="control-label"><strong>Tax Rate</strong></label><div class="controls"><div class="input-append">',
		'after'=>'<span class="add-on">%</span></div></div>',
		'value'=>$rate
	));
	echo $this->Form->submit('Save Tax Rate',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'btn btn-primary',
		'before'=>'<div class="controls">',
		'after'=>'</div>'
	));
	echo $this->Form->end();
	
	?>
	</div>
</div>