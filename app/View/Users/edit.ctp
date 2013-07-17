<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('username',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),
		));
		echo $this->Form->input('password',array(
			'value'=>'',
			'label'=>'Enter New Password',
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),
		));
		echo $this->Form->input('retypePassword',array(
			'type'=>'password',
			'label'=>'Re-enter New Password',
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),
		));
		echo $this->Form->input('email',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Save Changes')); ?>
</div>

