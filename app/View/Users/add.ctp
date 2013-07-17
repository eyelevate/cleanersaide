<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('group_id',array(
			'label'=>'Admin Access? <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'default'=>'2'		
		));		
		
		echo $this->Form->input('username',array(
			'label'=>'Username <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'create username'			
		));

		echo $this->Form->input('password',array(
			'label'=>'Password <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'enter password'	
		));
		echo $this->Form->input('retypePassword',array(
			'label'=>'Retype Password <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'retype password',
			'type'=>'password'			
		));
		echo $this->Form->input('email',array(
			'label'=>'Email Address <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'enter email address'	
		));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

