<?php
//load styles & scripts to layout
echo $this->Html->script(array(
	'admin/plugins/validation/jquery.validate.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/inventories.js'),
	FALSE
);

?>
<div class="row-fluid">
	<?php
	echo $this->Form->create('Company');
	?>
	<fieldset class="formSep">
		<h4 class="heading">Create A New Company</h4>
		<div class="form-horizontal">
			<?php
			echo $this->Form->input('name',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Company Name <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('street',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Address <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('city',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">City <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('state',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">State <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('zip',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Zipcode <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('phone',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Phone <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('email',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Email <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('owner',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Company Username <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('password',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Company Password <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('password2',array(
				'div'=>'control-group',
				'label'=>false,
				'type'=>'password',
				'before'=>'<label class="control-label">Re-type Password <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			?>
		</div>
	</fieldset>


	<div class="formRow">
		<?php
		echo $this->Form->submit('Save Company',array('class'=>'pull-right btn btn-large btn-primary'));
		?>
	</div>
	<?php
	echo $this->Form->end();
	?>
</div>