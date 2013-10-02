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
		<form method="post" action="/deliveries/index">		
			<div class="row">
				<div class="control-group four columns alpha">
					<label>Username</label>
					<input type="text" name="data[User][username]"/>
					<span class="help-block"></span>
				</div>
			</div>
			<div class="row">
				<div class="control-group four columns alpha">
					<label>Password</label>
					<input type="password" name="data[User][password]"/>
					<span class="help-block"></span>
				</div>
			</div>
			<div class="row">
				<a href="/deliveries/forgot" style="font-style: italic">Forgot Login Information? - Click Here</a>
			</div>
			<div class="row">
				<button type="submit" class="btn btn-success btn-large">Sign In</button>
			</div>
		</form>
	</div>
	<div class="eight columns omega well well-small" >
		<h3>Guest Delivery Form</h3>
		<br/>
		<form id="guestForm" method="post" action="/deliveries/process_delivery_form">
			
		<div class="row">
			<div class="control-group four columns alpha">
				<label>First Name <span class="required">*</span></label>
				<input type="text" name="data[User][first_name]"/>
				<span class="help-block"></span>
			</div>	
			<div class="control-group four columns alpha clearfix">
				<label>Last Name <span class="required">*</span></label>
				<input type="text" name="data[User][last_name]"/>
				<span class="help-block"></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group four columns alpha">
				<label>Phone Number <span class="required">*</span></label>
				<input class="phone" type="text" name="data[User][contact_phone]"/>
				<span class="help-block"></span>
			</div>		
		</div>
		<div class="row">
			<div class="control-group six columns alpha">
				<label>Email Address <span class="required">*</span></label>
				<input type="text" name="data[User][contact_email]"/>
				<span class="help-block"></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group six columns alpha">
				<label>Street Address <span class="required">*</span></label>
				<input type="text" name="data[User][contact_address]"/>
				<span class="help-block"></span>
			</div>
			<div class="control-group two columns alpha">
				<label>Apt. / Suite #</label>
				<input type="text" name="data[User][contact_suite]"/>
			</div>
		</div>
		<div class="row">
			<div class="control-group four columns alpha">
				<label>City <span class="required">*</span></label>
				<input type="text" name="data[User][contact_city]"/>
				<span class="help-block"></span>
			</div>
			<div class="control-group two columns alpha">
				<label>State <span class="required">*</span></label>
				<input type="text" name="data[User][contact_state]"/>
				<span class="help-block"></span>
			</div>
			<div class="control-group two columns alpha">
				<label>Zipcode <span class="required">*</span></label>
				<input type="text" name="data[User][contact_zip]"/>
				<span class="help-block"></span>
			</div>
		</div>
		<div class="row">
			<div class="control-group eight columns alpha">
				<label>Special Pickup/Dropoff Instructions</label>
				<textarea name="data[User][special_instructions]"></textarea>
			</div>
		</div>
		<div class="row">
			<button id="newMemberButton" class="pull-left btn btn-large" type="button">New Member Resgistration</button>
			<button id="nextButton" class="pull-right btn btn-large btn-primary" type="button">Next</button>
		</div>
		</form>
	</div>


</div>