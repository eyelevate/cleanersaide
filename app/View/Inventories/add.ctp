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
	echo $this->Form->create();
	?>
	<fieldset class="formSep">
		<h4 class="heading">Create A New Inventory Group</h4>
		<div class="form-horizontal">
			<?php
			echo $this->Form->input('name',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Inventory Type Name <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'class'=>'span6',
				'error' => array('attributes' => array('class' => 'controls text-error')),
			));
			echo $this->Form->input('description',array(
				'div'=>'control-group',
				'label'=>false,
				'before'=>'<label class="control-label">Inventory Type Description <span class="f_req">*</span></label><div class="controls">',
				'after'=>'</div>',
				'type'=>'textarea',
				'class'=>'span6',
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
	<?php
	echo $this->Form->end();
	?>
</div>