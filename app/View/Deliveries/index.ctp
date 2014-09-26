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
			$errors = ($success == 'error') ? 'error' : '';
			$message = ($success == 'error') ? 'There was an error with your login' : '';
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
				<a href="/users/forgot" style="font-style: italic">Forgot Login Information? - Click Here</a>
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
		$first_name_errors = (isset($form_errors['first_name'])) ? 'error' : '';
		$first_name_error_message = (isset($form_errors['first_name'])) ? $form_errors['first_name'][0] : '';
		$last_name_errors = (isset($form_errors['last_name'])) ? 'error' : '';
		$last_name_error_message = (isset($form_errors['last_name'])) ? $form_errors['last_name'][0] : '';
		$contact_address_errors = (isset($form_errors['contact_address'])) ? 'error' : '';
		$contact_address_error_message = (isset($form_errors['contact_address'])) ? $form_errors['contact_address'][0] : '';
		$contact_city_errors = (isset($form_errors['contact_city'])) ? 'error' : '';
		$contact_city_error_message = (isset($form_errors['contact_city'])) ? $form_errors['contact_city'][0] : '';
		$contact_state_errors = (isset($form_errors['contact_state'])) ? 'error' : '';
		$contact_state_error_message = (isset($form_errors['contact_state'])) ? $form_errors['contact_state'][0] : '';
		$contact_zip_errors = (isset($form_errors['contact_zip'])) ? 'error' : '';
		$contact_zip_error_message = (isset($form_errors['contact_zip'])) ? $form_errors['contact_zip'][0] : '';
		$contact_email_errors = (isset($form_errors['contact_email'])) ? 'error' : '';
		$contact_email_error_message = (isset($form_errors['contact_email'])) ? $form_errors['contact_email'][0] : '';
		$contact_phone_errors = (isset($form_errors['phone'])) ? 'error' : '';
		$contact_phone_error_message = (isset($form_errors['phone'])) ? $form_errors['starch'][0] : '';
		$contact_shirt_errors = (isset($form_errors['shirt'])) ? 'error' : '';
		$contact_shirt_error_message = (isset($form_errors['shirt'])) ? $form_errors['shirt'][0] : '';
		$contact_starch_errors = (isset($form_errors['starch'])) ? 'error' : '';
		$contact_starch_error_message = (isset($form_errors['starch'])) ? $form_errors['starch'][0] : '';	
		$contact_intercom_errors = (isset($form_errors['intercom'])) ? 'error' : '';
		$contact_intercom_error_message = (isset($form_errors['intercom'])) ? $form_errors['intercom'][0] : '';
	
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
				$intercom = $c['User']['intercom'];
				$shirt_preference = $c['User']['shirt'];
				$starch = (isset($c['User']['starch']) && !empty($c['User']['starch'])) ? $c['User']['starch'] : 'none';
				$special_instructions = $c['User']['special_instructions'];
				
			}

			?>
			<h3>Customer Login Information</h3>
			<p class="alert alert-info">Please make sure all current data is up to date. Press next to select delivery/pickup time.</p>
			<?php
		} else {
			$first_name = (!empty($customers) && count($customers)>0) ? $customers['User']['first_name'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['first_name'] : (isset($guest_form)) ? $guest_form['User']['first_name'] : '';
			$last_name = (!empty($customers) && count($customers)>0) ? $customers['User']['last_name'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['last_name'] : (isset($guest_form)) ? $guest_form['User']['last_name'] : '';
			$phone = (!empty($customers) && count($customers)>0) ? $customers['User']['contact_phone'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['contact_phone'] : (isset($guest_form)) ? $guest_form['User']['contact_phone'] : '';
			$zipcode = (!empty($customers) && count($customers)>0) ? $customers['User']['zipcode'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['contact_zip'] : (isset($guest_form)) ? $guest_form['User']['contact_zip'] : '';
			$email = (!empty($customers) && count($customers)>0) ? $customers['User']['contact_email'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['contact_email'] : (isset($guest_form)) ? $guest_form['User']['contact_email'] : '';
			$street = (!empty($customers) && count($customers)>0) ? $customers['User']['contact_address'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['contact_address'] : '';
			$suite = (!empty($customers) && count($customers)>0) ? $customers['User']['contact_suite'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['contact_suite'] : '';
			$city = (!empty($customers) && count($customers)>0) ? $customers['User']['contact_city'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['contact_city'] : '';
			$state = (!empty($customers) && count($customers)>0) ? $customers['User']['contact_state'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['contact_state'] : ''; 
			$intercom = (!empty($customers) && count($customers)>0) ? $customers['User']['intercom'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['intercom'] : '';
			$shirt_preference = (!empty($customers) && count($customers)>0) ? $customes['User']['shirt'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['shirt'] : 'hanger';
			$starch = (!empty($customers) && count($customers)>0) ? (isset($customers['User']['starch']) && !empty($customers['User']['starch'])) ? $customers['User']['starch'] : 'none' : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['starch'] : 'none';
			$special_instructions = (!empty($customers) && count($customers)>0) ? $customers['User']['special_instructions'] : (isset($_SESSION['Delivery'])) ? $_SESSION['Delivery']['User']['special_instructions'] : '';
			
			?>
			<h3>Guest Delivery Form</h3>	
			<p class="alert alert-info">All fields denoted with a <span class="required">*</span> are required. Once the form is completed please press "Next" button to select your delivery time and date.</p>
			<?php		
		}
		?>
		
		<br/>
		<form id="custInfoForm" method="post" action="/deliveries">
			<input type="hidden" value="<?php echo $customer_id;?>" name="data[User][customer_id]" />
		<div class="row">
			<div class="control-group <?php echo $first_name_errors;?> four columns alpha">
				<label>First Name <span class="required">*</span></label>
				<input type="text" name="data[User][first_name]" value="<?php echo $first_name;?>" required="required"/>
				<span class="help-block"><?php echo $first_name_error_message;?></span>
			</div>	
			<div class="control-group <?php echo $last_name_errors;?> four columns alpha clearfix">
				<label>Last Name <span class="required">*</span></label>
				<input type="text" name="data[User][last_name]" value="<?php echo $last_name;?>" required="required"/>
				<span class="help-block"><?php echo $last_name_error_message;?></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group <?php echo $contact_phone_errors;?> four columns alpha">
				<label>Phone Number <span class="required">*</span></label>
				<input class="phone" type="text" name="data[User][contact_phone]" value="<?php echo $phone;?>" required="required"/>
				<span class="help-block"><?php echo $contact_phone_error_message;?></span>
			</div>		
			<div class="control-group <?php echo $contact_intercom_errors;?> three columns alpha">
				<label>Intercom <em>(optional)</em></label>
				<input type="text" name="data[User][intercom]" value="<?php echo $intercom;?>"/>
				<span class="help-block"><?php echo $contact_intercom_error_message;?></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group <?php echo $contact_email_errors;?> six columns alpha">
				<label>Email Address <span class="required">*</span></label>
				<input type="text" name="data[User][contact_email]" value="<?php echo $email;?>" required="required"/>
				<span class="help-block"><?php echo $contact_email_error_message;?></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group <?php echo $contact_address_errors;?> six columns alpha">
				<label>Street Address <span class="required">*</span></label>
				<input type="text" name="data[User][contact_address]" value="<?php echo $street;?>" required="required"/>
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
				<input type="text" name="data[User][contact_city]" value="<?php echo $city;?>" required="required"/>
				<span class="help-block"><?php echo $contact_city_error_message;?></span>
			</div>
			<div class="control-group <?php echo $contact_state_errors;?> two columns alpha">
				<label>State <span class="required">*</span></label>
				<input type="text" name="data[User][contact_state]" value="<?php echo $state;?>" required="required"/>
				<span class="help-block"><?php echo $contact_state_error_message;?></span>
			</div>
			<div class="control-group <?php echo $contact_zip_errors;?> two columns alpha">
				<label>Zipcode <span class="required">*</span></label>
				<input type="text" name="data[User][contact_zip]" value="<?php echo $zipcode;?>" required="required"/>
				<span class="help-block"><?php echo $contact_zip_error_message;?></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group <?php echo $contact_shirt_errors;?> four columns alpha">
				<label>Shirt Preference <span class="required">*</span></label>
				<select name="data[User][shirt]" >
				<?php
				switch($shirt_preference){
					case 'hanger':
					?>
					<option value="hanger" default="default">On Hanger</option>
					<option value="box">Boxed</option>
					<option value="fold">Folded</option>					
					<?php	
					break;				
					case 'box':
					?>
					<option value="hanger" >On Hanger</option>
					<option value="box" default="default">Boxed</option>
					<option value="fold">Folded</option>					
					<?php								
					break;
						
					case 'fold':
					?>
					<option value="hanger" >On Hanger</option>
					<option value="box">Boxed</option>
					<option value="fold" default="default">Folded</option>					
					<?php								
					break;
					
					default:
					?>
					<option value="hanger" default="default">On Hanger</option>
					<option value="box">Boxed</option>
					<option value="fold">Folded</option>					
					<?php							
					break;
				}
				?>
				</select>
				<span class="help-block"><?php echo $contact_shirt_error_message;?></span>
			</div>
			<div class="control-group <?php echo $contact_starch_errors;?> two columns alpha">
				<label>Starch <span class="required">*</span></label>
				<select name="data[User][starch]">
				<?php
				switch($starch){
					
					case 'none':
					?>					
					<option value="none" default"default">None</option>
					<option value="light">Light</option>
					<option value="medium">Medium</option>
					<option value="heavy">Heavy</option>
					<?php
					break;
						
					case 'light':
					?>					
					<option value="none">None</option>
					<option value="light" default="default">Light</option>
					<option value="medium">Medium</option>
					<option value="heavy">Heavy</option>
					<?php						
					break;
						
					case 'medium':
					?>					
					<option value="none">None</option>
					<option value="light">Light</option>
					<option value="medium" default="default">Medium</option>
					<option value="heavy">Heavy</option>
					<?php						
					break;
						
					case 'heavy':
					?>					
					<option value="none">None</option>
					<option value="light">Light</option>
					<option value="medium">Medium</option>
					<option value="heavy" default="default">Heavy</option>
					<?php						
					break;
					
				}
				
				?>
				</select>
				<span class="help-block"><?php echo $contact_starch_error_message;?></span>
			</div>
		
		</div>
		<div class="row">
			<div class="control-group eight columns alpha">
				<label class="checkbox"><input id="deliveryBag" type="checkbox" value="Requires Jays Cleaners garment bag"/> I require a Jays Cleaners garment bag.</label>
			</div>
		</div>
		<div class="row">
			<div class="control-group eight columns alpha">
				<label>Special Pickup/Dropoff Instructions</label>
				<textarea id="special_instructions" name="data[User][special_instructions]"><?php echo $special_instructions;?></textarea>
			</div>
		</div>
		<div class="row">
			<?php 
			
			if($login == 'No'){
			?>
			<button id="newMemberButton" class="pull-left btn btn-large" type="button">New Member Registration</button>
			<?php	
			}
			?>
			
			<button id="nextButton" class="pull-right btn btn-large btn-primary" type="button">Next</button>
		</div>
		</form>
	</div>


</div>