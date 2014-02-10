<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('group_id');
		// echo $this->Form->input('username',array(
			// 'div'=>array('class'=>'control-group'),		
			// 'error'=>array('attributes' => array('class' => 'help-block')),
		// ));
		// echo $this->Form->input('password',array(
			// 'value'=>'',
			// 'label'=>'Enter New Password',
			// 'div'=>array('class'=>'control-group'),		
			// 'error'=>array('attributes' => array('class' => 'help-block')),
		// ));
		// echo $this->Form->input('retypePassword',array(
			// 'type'=>'password',
			// 'label'=>'Re-enter New Password',
			// 'div'=>array('class'=>'control-group'),		
			// 'error'=>array('attributes' => array('class' => 'help-block')),
		// ));
		echo $this->Form->input('first_name',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('middle_initial',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('last_name',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('contact_address',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('contact_suite',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('contact_city',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('contact_state',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('contact_zip',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('contact_phone',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('contact_email',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		echo $this->Form->input('special_instructions',array(
			'div'=>array('class'=>'control-group'),		
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));
		$options = array('none'=>'None','light'=>'Light','medium'=>'Medium','heavy'=>'Heavy');
		echo $this->Form->input('starch',array(
			'div'=>array('class'=>'control-group'),		
			'options'=>$options,
			'error'=>array('attributes' => array('class' => 'help-block')),		
		));

	?>
	</fieldset>
<?php echo $this->Form->end(__('Save Changes')); ?>
</div>

