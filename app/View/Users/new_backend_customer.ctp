<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
		<input type="hidden" value="5" name="data[User][group_id]"/>
	<?php	
		
		// echo $this->Form->input('username',array(
			// 'label'=>'Username <span class="f_req">*</span>',
			// 'div'=>array('class'=>'control-group'),
			// 'after'=>'<span class="help-block"></span>',
			// 'error'=>array('attributes' => array('class' => 'help-block')),
			// 'placeholder'=>'create username'			
		// ));
// 
		// echo $this->Form->input('password',array(
			// 'label'=>'Password <span class="f_req">*</span>',
			// 'div'=>array('class'=>'control-group'),
			// 'after'=>'<span class="help-block"></span>',
			// 'error'=>array('attributes' => array('class' => 'help-block')),
			// 'placeholder'=>'enter password'	
		// ));
		// echo $this->Form->input('retypePassword',array(
			// 'label'=>'Retype Password <span class="f_req">*</span>',
			// 'div'=>array('class'=>'control-group'),
			// 'after'=>'<span class="help-block"></span>',
			// 'error'=>array('attributes' => array('class' => 'help-block')),
			// 'placeholder'=>'retype password',
			// 'type'=>'password'			
		// ));
		echo $this->Form->input('first_name',array(
			'label'=>'First Name <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'first name'	
		));
		echo $this->Form->input('last_name',array(
			'label'=>'Last Name <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'first name'	
		));	
		echo $this->Form->input('contact_phone',array(
			'label'=>'Phone <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'phone'	
		));		
		echo $this->Form->input('address',array(
			'label'=>'Street Address',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'street address'	
		));	
		echo $this->Form->input('city',array(
			'label'=>'City',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'city'	
		));
		echo $this->Form->input('state',array(
			'label'=>'State',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'class'=>'span1',
			'placeholder'=>'state'	
		));
		echo $this->Form->input('zipcode',array(
			'label'=>'Zipcode',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'zipcode'	
		));		
		echo $this->Form->input('email',array(
			'label'=>'Email Address',
			'div'=>array('class'=>'control-group'),
			'after'=>'<span class="help-block"></span>',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'placeholder'=>'enter email address'	
		));
		$shirts_array = array(
			'hanger'=>'On Hanger',
			'boxed'=>'Boxed',
			'folded'=>'Folded'
		);		
		echo $this->Form->input('shirt',array(
			'class'=>'shirt',
			'label'=>'Shirt Preference <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group four columns alpha'),
			'after'=>'<span class="help-block"></span>',
			'options'=>$shirts_array,
			'error'=>array('attributes' => array('class' => 'help-block')),

		));	
		
		$starch_array = array(
			'none'=>'None',
			'light'=>'Light',
			'medium'=>'Medium',
			'heavy'=>'Heavy'
		);
		echo $this->Form->input('starch',array(
			'class'=>'starch',
			'label'=>'Starch <span class="f_req">*</span>',
			'div'=>array('class'=>'control-group two columns alpha'),
			'after'=>'<span class="help-block"></span>',
			'options'=>$starch_array,
			'error'=>array('attributes' => array('class' => 'help-block')),
		));	
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

