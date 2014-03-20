<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/users_edit.js'),FALSE);
?>

<div class="users form">
<h1 class="heading"><?php echo __('Edit User'); ?></h1>
<?php echo $this->Form->create('User'); ?>
	<fieldset class="well well-small">
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
		echo $this->Form->input('contact_phone',array(
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
	<fieldset class="alert alert-info">
		<label class="heading">Delivery Setup</label>
		<div class="control-group">
			<label>Save profile information?</label>
			<div class="control-group">
				<label class="radio"><input class="profileCheck" type="radio" name="data[Payment][profile_status]" value="1"/> Yes</label>
				<label class="radio"><input class="profileCheck" type="radio" name="data[Payment][profile_status]" value="0" checked="checked"/> No (do not create a profile)</label>					
			</div>				
		</div>
		<div id="profileDiv" class="formRow hide">
			<hr/>
			<?php
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
			echo $this->Form->input('contact_email',array(
				'div'=>array('class'=>'control-group'),		
				'error'=>array('attributes' => array('class' => 'help-block')),		
			));	
			
				?>
				<div class="control-group">
					<label>Setup delivery payment?</label>
					<select id="set_delivery_customer" name="data[Payment][delivery_setup]">
						<option value="0">No</option>
						<option value="1">Yes</option>
					</select>
				</div>
				<div id="paymentDiv" class="control-group hide">
					<hr/>
					<label>Save payment information?</label>
					<div class="control-group">
						<label class="radio"><input type="radio" name="data[Payment][payment_status]" value="2"/> Yes</label>
						<label class="radio"><input type="radio" name="data[Payment][payment_status]" value="1" checked="checked"/> No (delete after each payment)</label>					
					</div>	
				
				<?php
				echo $this->Form->input('User.profile_id',array(
					'type'=>'hidden'
				));		
				echo $this->Form->input('User.payment_id',array(
					'type'=>'hidden'
				));			
				echo $this->Form->input('Payment.card_full_name',array(
					'label'=>'Name on Card <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group eight columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Full name as it appears on your credit card',
		
				));					
	
				echo $this->Form->input('Payment.ccnum',array(
					'label'=>'Credit Card Number <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group eight columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'credit card number as it is shown on your card',
	
				));					
	
				echo $this->Form->input('Payment.exp_month',array(
					'label'=>'Expired Month <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'mm',
					'maxlength'=>2
	
				));		
				echo $this->Form->input('Payment.exp_year',array(
					'label'=>'Expired Year <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'yyyy',
					'maxlength'=>4
		
				));					
				echo $this->Form->input('Payment.cvv',array(
					'label'=>'CVV <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'ex. 123',
					'maxlength'=>5
		
				));				
			
				?>
			</div>
		</div>
	</fieldset>
<?php echo $this->Form->end(__('Save Changes')); ?>
</div>

