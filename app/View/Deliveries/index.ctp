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
	'frontend/deliveries_index.js'),FALSE);

?>
<div class="container">
	<br/>
	<h1>Delivery</h1>
	<p>To fulfill your delivery request please complete the form below. Returning registered members may sign in to prefill the delivery form.</p>
	<br/>

	<div class="seven columns alpha well well-small">
		<h3>Returning Members</h3>
		<br/>
		<?php
		if($login == 'No'){
			if($success == 'error'){
				$errors = 'error';
				$message = 'There was an error with your login';
			} else {
				$errors = '';
				$message = '';
				
			}
		?>
		<form method="post" action="/deliveries/process_login">		
			<div class="row">
				<div class="control-group <?php echo $errors;?> four columns alpha">
					<label>Username</label>
					<input type="text" name="data[User][username]"/>
					<span class="help-block"></span>
				</div>
			</div>
			<div class="row">
				<div class="control-group <?php echo $errors;?> four columns alpha">
					<label>Password</label>
					<input type="password" name="data[User][password]"/>
					<span class="help-block"><?php echo $message;?></span>
				</div>
			</div>
			<div class="row">
				<a href="/deliveries/forgot" style="font-style: italic">Forgot Login Information? - Click Here</a>
			</div>
			<div class="row">
				<a class="btn btn-danger btn-large" href="/users/frontend_logout">Logout</a>
				<button type="submit" class="btn btn-success btn-large">Sign In</button>
			</div>
		</form>
		<?php
		} else {
		?>
		<p class="alert alert-success">You have successfully logged in!</p>
			<div class="row">
				<a class="btn btn-danger btn-large" href="/users/frontend_logout">Logout</a>
			</div>
		<?php
		}
		?>
	</div>

	<div class="eight columns omega well well-small" >
		<?php
		if(isset($form_errors['first_name'])){
			$first_name_errors = 'error';
			$first_name_error_message = $form_errors['first_name'][0];
		} else {
			$first_name_errors = '';
			$first_name_error_message = '';			
		}		
		if(isset($form_errors['last_name'])){
			$last_name_errors = 'error';
			$last_name_error_message = $form_errors['last_name'][0];
		} else {
			$last_name_errors = '';
			$last_name_error_message = '';			
		}
		if(isset($form_errors['contact_address'])){
			$contact_address_errors = 'error';
			$contact_address_error_message = $form_errors['contact_address'][0];
		} else {
			$contact_address_errors = '';
			$contact_address_error_message = '';			
		}
		if(isset($form_errors['contact_city'])){
			$contact_city_errors = 'error';
			$contact_city_error_message = $form_errors['contact_city'][0];
		} else {
			$contact_city_errors = '';
			$contact_city_error_message = '';			
		}	
		if(isset($form_errors['contact_state'])){
			$contact_state_errors = 'error';
			$contact_state_error_message = $form_errors['contact_state'][0];
		} else {
			$contact_state_errors = '';
			$contact_state_error_message = '';			
		}
		if(isset($form_errors['contact_zip'])){
			$contact_zip_errors = 'error';
			$contact_zip_error_message = $form_errors['contact_zip'][0];
		} else {
			$contact_zip_errors = '';
			$contact_zip_error_message = '';			
		}	
		if(isset($form_errors['contact_email'])){
			$contact_email_errors = 'error';
			$contact_email_error_message = $form_errors['contact_email'][0];
		} else {
			$contact_email_errors = '';
			$contact_email_error_message = '';			
		}		
		if(isset($form_errors['phone'])){
			$contact_phone_errors = 'error';
			$contact_phone_error_message = $form_errors['phone'][0];
		} else {
			$contact_phone_errors = '';
			$contact_phone_error_message = '';			
		}			
		if($login == 'Yes'){
			
			foreach ($customers as $c) {
				$first_name = $c['User']['first_name'];
				$last_name = $c['User']['last_name'];
				$phone = $c['User']['contact_phone'];
				$email = $c['User']['contact_email'];
				$street = $c['User']['contact_address'];
				$suite = $c['User']['contact_suite'];
				$city = $c['User']['contact_city'];
				$state = $c['User']['contact_state'];
				$zipcode = $c['User']['contact_zip'];
				$special_instructions = $c['User']['special_instructions'];
				
			}
			?>
			<h3>Customer Login Information</h3>
			<p class="alert alert-info">Please make sure all current data is up to date. Press next to select delivery/pickup time.</p>
			<?php
		} else {
			if(!empty($customers)){
				$first_name = $customers['User']['first_name'];
				$last_name = $customers['User']['last_name'];
				$phone = $customers['User']['phone'];
				$email = $customers['User']['contact_email'];
				$street = $customers['User']['contact_address'];
				$suite = $customers['User']['contact_suite'];
				$city = $customers['User']['contact_city'];
				$state = $customers['User']['contact_state'];
				$zipcode = $customers['User']['contact_zip'];
				$special_instructions = $customers['User']['special_instructions'];					
			} else {
				if(isset($guest_form)){
					$first_name = $guest_form['User']['first_name'];
					$last_name = $guest_form['User']['last_name'];
					$phone = $guest_form['User']['contact_phone'];
					$zipcode = $guest_form['User']['contact_zip'];
					$email = $guest_form['User']['contact_email'];
					$street = '';
					$suite = '';
					$city = '';
					$state = '';
					$special_instructions = '';	
				} else {
					$first_name = '';
					$last_name = '';
					$phone = '';
					$email = '';
					$street = '';
					$suite = '';
					$city = '';
					$state = '';
					$zipcode = '';
					$special_instructions = '';						
				}
				
				
			}

			
			?>
			<h3>Guest Delivery Form</h3>	
			<p class="alert alert-info">All fields denoted with a <span class="required">*</span> are required. Once the form is completed please press "Next" button to select your delivery time and date.</p>
			<?php		
		}
		?>
		
		<br/>
		<form id="custInfoForm" method="post" action="/deliveries">
			<input type="hidden" value="<?php echo $customer_id;?>" name="data[User][customer_id]"/>
		<div class="row">
			<div class="control-group <?php echo $first_name_errors;?> four columns alpha">
				<label>First Name <span class="required">*</span></label>
				<input type="text" name="data[User][first_name]" value="<?php echo $first_name;?>"/>
				<span class="help-block"><?php echo $first_name_error_message;?></span>
			</div>	
			<div class="control-group <?php echo $last_name_errors;?> four columns alpha clearfix">
				<label>Last Name <span class="required">*</span></label>
				<input type="text" name="data[User][last_name]" value="<?php echo $last_name;?>"/>
				<span class="help-block"><?php echo $last_name_error_message;?></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group <?php echo $contact_phone_errors;?> four columns alpha">
				<label>Phone Number <span class="required">*</span></label>
				<input class="phone" type="text" name="data[User][phone]" value="<?php echo $phone;?>"/>
				<span class="help-block"><?php echo $contact_phone_error_message;?></span>
			</div>		
		</div>
		<div class="row">
			<div class="control-group <?php echo $contact_email_errors;?> six columns alpha">
				<label>Email Address <span class="required">*</span></label>
				<input type="text" name="data[User][contact_email]" value="<?php echo $email;?>"/>
				<span class="help-block"><?php echo $contact_email_error_message;?></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group <?php echo $contact_address_errors;?> six columns alpha">
				<label>Street Address <span class="required">*</span></label>
				<input type="text" name="data[User][contact_address]" value="<?php echo $street;?>"/>
				<span class="help-block"><?php echo $contact_address_error_message;?></span>
			</div>
			<div class="control-group two columns alpha">
				<label>Apt. / Suite #</label>
				<input type="text" name="data[User][contact_suite]" value="<?php echo $suite;?>"/>
			</div>
		</div>
		<div class="row">
			<div class="control-group <?php echo $contact_city_errors;?> four columns alpha">
				<label>City <span class="required">*</span></label>
				<input type="text" name="data[User][contact_city]" value="<?php echo $city;?>"/>
				<span class="help-block"><?php echo $contact_city_error_message;?></span>
			</div>
			<div class="control-group <?php echo $contact_state_errors;?> two columns alpha">
				<label>State <span class="required">*</span></label>
				<input type="text" name="data[User][contact_state]" value="<?php echo $state;?>"/>
				<span class="help-block"><?php echo $contact_state_error_message;?></span>
			</div>
			<div class="control-group <?php echo $contact_zip_errors;?> two columns alpha">
				<label>Zipcode <span class="required">*</span></label>
				<input type="text" name="data[User][contact_zip]" value="<?php echo $zipcode;?>"/>
				<span class="help-block"><?php echo $contact_zip_error_message;?></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group eight columns alpha">
				<label>Special Pickup/Dropoff Instructions</label>
				<textarea name="data[User][special_instructions]"><?php echo $special_instructions;?></textarea>
			</div>
		</div>
		<div class="row">
			<?php 
			
			if($login == 'No'){
			?>
			<button id="newMemberButton" class="pull-left btn btn-large" type="button">New Member Resgistration</button>
			<?php	
			}
			?>
			
			<button id="nextButton" class="pull-right btn btn-large btn-primary" type="button">Next</button>
		</div>
		</form>
	</div>


</div>