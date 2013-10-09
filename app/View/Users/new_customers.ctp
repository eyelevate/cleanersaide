<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form',
	'frontend/bootstrap-toggle-buttons'
	),
	'stylesheet',
	array('inline'=>false)
);
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/users_new_customers.js'),FALSE);

if(!empty($error_message)){
	?>
	<p class="alert alert-error"><?php echo $error_message;?></p>
	<?php
}

?>

<div class="container">
	<?php echo $this->Form->create();?>
		<br/>
		<h1><?php echo __('New Member Registration Form'); ?></h1>
		
		<fieldset class="sixteen columns alpha well well-small">
			<h3>Login Information</h3>
			<div class="row" >
			<?php		
			
			echo $this->Form->input('username',array(
				'label'=>'Username <span class="required">*</span>',
				'div'=>array('class'=>'control-group four columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'create username'			
			));
			?>
			</div>
			<div class="row">
			<?php
			echo $this->Form->input('password',array(
				'label'=>'Password <span class="required">*</span>',
				'div'=>array('class'=>'control-group four columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'create password'			
			));	
			?>
			</div>
			<div class="row">
			<?php
			echo $this->Form->input('password2',array(
				'label'=>'Re-enter Password <span class="required">*</span>',
				'div'=>array('class'=>'control-group four columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'type'=>'password',
				'placeholder'=>'re-enter password'			
			));			
			?>		
			</div>			
		</fieldset>
		<fieldset class="sixteen columns alpha well well-small">
			<h3>Basic Information</h3>
			<div class="row">
			<?php
			if(isset($users)){
				$first_name = $users['User']['first_name'];
				$last_name = $users['User']['last_name'];
				$phone = $users['User']['contact_phone'];
				$address = $users['User']['contact_address'];
				$suite = $users['User']['contact_suite'];
				$city = $users['User']['contact_city'];
				$state = $users['User']['contact_state'];
				$zipcode = $users['User']['contact_zip'];
				$email = $users['User']['email'];
				$special_instructions = $users['User']['special_instructions'];
				
				echo $this->Form->input('first_name',array(
					'label'=>'First Name <span class="required">*</span>',
					'div'=>array('class'=>'control-group four columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'First Name',	
					'value'=>$first_name,	
				));
				echo $this->Form->input('last_name',array(
					'label'=>'Last Name <span class="required">*</span>',
					'div'=>array('class'=>'control-group four columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Last Name',
					'value'=>$last_name			
				));
				?>
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('contact_phone',array(
					'class'=>'phone',
					'label'=>'Phone <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group four columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Phone',
					'value'=>$phone			
				));			
				?>	
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('contact_email',array(
					'label'=>'Email Address <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group six columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Email Address',
					'value'=>$email
				));				
				?>	
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('contact_address',array(
					'label'=>'Street Address <span class="required">*</span>',
					'div'=>array('class'=>'control-group six columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Steet Address',
					'value'=>$address		
				));
				echo $this->Form->input('suite',array(
					'label'=>'Apt/Suite #',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'optional',
					'value'=>$suite			
				));
				?>
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('contact_city',array(
					'label'=>'City <span class="required">*</span>',
					'div'=>array('class'=>'control-group four columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'City',
					'value'=>$city		
				));
				echo $this->Form->input('contact_state',array(
					'label'=>'State <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'State',
					'value'=>$state			
				));
				echo $this->Form->input('contact_zip',array(
					'label'=>'Zipcode <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'zipcode',
					'value'=>$zipcode		
				));			
				?>	
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('special_instructions',array(
					'type'=>'textarea',
					'label'=>'Special Delivery Instructions',
					'div'=>array('class'=>'control-group eight columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'optional',
					'value'=>$special_instructions		
				));	
				?>				
				</div>
				<?php
			} else {
				echo $this->Form->input('first_name',array(
					'label'=>'First Name <span class="required">*</span>',
					'div'=>array('class'=>'control-group four columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'First Name',
				));
				echo $this->Form->input('last_name',array(
					'label'=>'Last Name <span class="required">*</span>',
					'div'=>array('class'=>'control-group four columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Last Name',		
				));
				?>
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('contact_phone',array(
					'class'=>'phone',
					'label'=>'Phone <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group four columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Phone',
				));			
				?>	
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('contact_email',array(
					'label'=>'Email Address <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group six columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Email Address'
				));				
				?>	
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('contact_address',array(
					'label'=>'Street Address <span class="required">*</span>',
					'div'=>array('class'=>'control-group six columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Steet Address'	
				));
				echo $this->Form->input('suite',array(
					'label'=>'Apt/Suite #',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'optional'
				));
				?>
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('contact_city',array(
					'label'=>'City <span class="required">*</span>',
					'div'=>array('class'=>'control-group four columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'City'
				));
				echo $this->Form->input('contact_state',array(
					'label'=>'State <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'State'	
				));
				echo $this->Form->input('contact_zip',array(
					'label'=>'Zipcode <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'zipcode'
				));
				?>	
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('special_instructions',array(
					'type'=>'textarea',
					'label'=>'Special Delivery Instructions',
					'div'=>array('class'=>'control-group eight columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'optional'	
				));	
				?>				
				</div>
			<?php
			}
			?>
		</fieldset>
		<fieldset class="sixteen columns alpha well well-small">
			<h3>Payment Information</h3>
			<div class="row"> 
				<label>Would you like us to store your personal credit card information?</label>
				<label class="radio"><input class="piInput" type="radio" name="data[User][store_credit_data]" value="Yes"/>Yes</label>

				<label class="radio"><input class="piInput" type="radio" name="data[User][store_credit_data]" value="No" checked="checked"/>No</label>
				<span class="help-block"></span>
			</div>
			<div id="paymentForm" class="alert hide">
				<div class="row">
				<?php
				echo $this->Form->input('card_full_name',array(
					'label'=>'Name on Card <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group eight columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'Full name as it appears on your credit card',
					'disabled'=>'disabled'		
				));					
				?>
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('ccnum',array(
					'label'=>'Credit Card Number <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group eight columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'credit card number as it is shown on your card',
					'disabled'=>'disabled'		
				));					
				?>
				</div>
				<div class="row">
				<?php
				echo $this->Form->input('exp_month',array(
					'label'=>'Expired Month <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'mm',
					'disabled'=>'disabled'
				));		
				echo $this->Form->input('exp_year',array(
					'label'=>'Expired Year <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'yyyy',
					'disabled'=>'disabled'		
				));					
				echo $this->Form->input('cvv',array(
					'label'=>'CVV <span class="f_req">*</span>',
					'div'=>array('class'=>'control-group two columns alpha'),
					'after'=>'<span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'placeholder'=>'ex. 123',
					'disabled'=>'disabled'		
				));				
			
				?>
				</div>
			</div>	
		</fieldset>
		<fieldset>
			<div class="row">
				<button id="goBackButton" class="btn btn-danger btn-large pull-left" type="button">Go Back</button>
				<button class="btn btn-primary btn-large pull-right" type="submit">Create Account</button>
			</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>

