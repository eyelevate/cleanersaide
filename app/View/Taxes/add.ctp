<?php
echo $this->Html->script(array('admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js','admin/taxes.js'),FALSE);

?>
<div class="row-fluid">
	<h4 class="heading">Create Tax Rate</h4>
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
		'after'=>'</div>'
	));
	echo $this->Form->input('country',array(
		'label'=>false,
		'div'=>'control-group',
		'options'=>array(''=>'Select Country','CAN'=>'Canada','USA'=>'United States'),
		'class'=>'taxCountry',
		'before'=>'<label class="control-label">Country</label><div class="controls">',
		'after'=>'</div>'
	));
	echo $this->Form->input('per_basis',array(
		'label'=>false,
		'div'=>'control-group',
		'options'=>array(''=>'Select taxable amount','Per Night or Ticket only'=>'Per night or ticket only','Overall subtotal'=>'Overall subtotal'),
		'default'=>'Overall subtotal',
		'class'=>'taxPerBasis',
		'before'=>'<label class="control-label">Applicable to</label><div class="controls">',
		'after'=>'</div>'
	));
	echo $this->Form->input('rate',array(
		'label'=>false,
		'div'=>'control-group',
		'class'=>'taxrate',
		'before'=>'<label class="control-label"><strong>Tax Rate</strong></label><div class="controls"><div class="input-append">',
		'after'=>'<span class="add-on">%</span></div></div>',
		'value'=>'0.00'
	));
	echo $this->Form->submit('Add Tax Rate',array(
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