<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('group_id',array(
			'type'=>'hidden',
			'value'=>'5'		
		));		
		
		// echo $this->Form->input('username',array(
			// 'label'=>'Username <span class="f_req">*</span>',
			// 'div'=>array('class'=>'control-group'),
			// 'after'=>'<span class="help-block"></span>',
			// 'error'=>array('attributes' => array('class' => 'help-block')),
			// 'placeholder'=>'create username'			
		// ));
		echo $this->Form->input('first_name',array(
			'label'=>'First Name <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'First Name'			
		));
		echo $this->Form->input('last_name',array(
			'label'=>'Last Name <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'Last Name'			
		));
		
		echo $this->Form->input('contact_address',array(
			'label'=>'Street',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'Steet Address'			
		));
		echo $this->Form->input('contact_city',array(
			'label'=>'City <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'City'			
		));
		echo $this->Form->input('contact_state',array(
			'label'=>'State <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'State'			
		));
		echo $this->Form->input('contact_zip',array(
			'label'=>'Zipcode <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'First Name'			
		));
		echo $this->Form->input('contact_phone',array(
			'label'=>'Phone <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'Phone'			
		));
		echo $this->Form->input('contact_email',array(
			'label'=>'Email Address <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'Email Address'	
		));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

