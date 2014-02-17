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
			$contact_phone_error_message = $form_errors['starch'][0];
		} else {
			$contact_phone_errors = '';
			$contact_phone_error_message = '';			
		}
		if(isset($form_errors['shirt'])){
			$contact_shirt_errors = 'error';
			$contact_shirt_error_message = $form_errors['shirt'][0];			
		} else {
			$contact_shirt_errors = '';
			$contact_shirt_error_message = '';				
		}		
		if(isset($form_errors['starch'])){
			$contact_starch_errors = 'error';
			$contact_starch_error_message = $form_errors['starch'][0];			
		} else {
			$contact_starch_errors = '';
			$contact_starch_error_message = '';				
		}	
		if(isset($form_errors['intercom'])){
			$contact_intercom_errors = 'error';
			$contact_intercom_error_message = $form_errors['intercom'][0];			
		} else {
			$contact_intercom_errors = '';
			$contact_intercom_error_message = '';				
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
				$intercom = $c['User']['intercom'];
				$shirt_preference = $c['User']['shirt'];
				$starch = $c['User']['starch'];
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
				$phone = $customers['User']['contact_phone'];
				$email = $customers['User']['contact_email'];
				$street = $customers['User']['contact_address'];
				$suite = $customers['User']['contact_suite'];
				$city = $customers['User']['contact_city'];
				$state = $customers['User']['contact_state'];
				$zipcode = $customers['User']['contact_zip'];
				$intercom = $customers['User']['intercom'];
				$shirt_preference = $customes['User']['shirt'];
				$starch = $customers['User']['starch'];
				$special_instructions = $customers['User']['special_instructions'];					
			} else {
				if(isset($_SESSION['Delivery'])){
					$first_name = $_SESSION['Delivery']['User']['first_name'];
					$last_name = $_SESSION['Delivery']['User']['last_name'];
					$phone = $_SESSION['Delivery']['User']['contact_phone'];
					$zipcode = $_SESSION['Delivery']['User']['contact_zip'];
					$email = $_SESSION['Delivery']['User']['contact_email'];
					$street = $_SESSION['Delivery']['User']['contact_address'];
					$suite = $_SESSION['Delivery']['User']['contact_suite'];
					$city = $_SESSION['Delivery']['User']['contact_city'];
					$state = $_SESSION['Delivery']['User']['contact_state'];
					$intercom = $_SESSION['Delivery']['User']['intercom'];
					$shirt_preference = $_SESSION['Delivery']['User']['shirt'];
					$starch = $_SESSION['Delivery']['User']['starch'];
					$special_instructions = $_SESSION['Delivery']['User']['special_instructions'];						
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
						$intercom = '';
						$shirt_preference = 'hanger';
						$starch = 'none';
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
						$intercom = '';
						$shirt_preference = 'hanger';
						$starch = 'none';
						$special_instructions = '';						
					}					
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
				<input class="phone" type="text" name="data[User][contact_phone]" value="<?php echo $phone;?>"/>
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
			<div class="control-group <?php echo $contact_shirt_errors;?> four columns alpha">
				<label>Shirt Preference <span class="required">*</span></label>
				<select name="data[User][shirt]">
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