<?php

/**
 * HOME PAGE
 */
 
//load scripts to layout
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form',
	'../js/frontend/plugins/jquery.bxslider/jquery.bxslider',
	'frontend/home'
	),
	'stylesheet',
	array('inline'=>false)
);
//JS Files
echo $this->Html->script(array(
	'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui js file
	'frontend/plugins/jquery.bxslider/jquery.bxslider.min.js',
	'frontend/home.js',
	'frontend/bootstrap-tabs.min.js'
	),
	FALSE
);


if(count($contents)>0){
	$contents = json_decode($contents[0]['Page_content']['html'], TRUE);	
}



?>
<script>
$(document).ready(function() {
	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	})

});
	
</script>


	<div class="row no_bm">
		<div id="slider_holder" class="sixteen columns">
				
				<div id="trip_planner">
					<div class="trip_planner_title">Schedule a free delivery</div>
						<ul class="nav nav-pills" id="myTab">
						  <li class="active" style="margin-left:25px;"><a href="#guest">Guest Delivery</a></li>
						  <li><a href="#login" >Member Login</a></li>
						</ul>
						<div class="tab-content">
		  					<div class="tab-pane active" id="guest">
							<form action="/deliveries/process_sad" method="post" style="display: block;">
								
									
								<div class="row-fluid">
									<div class="control-group span6">
										<label class="sub-label">First Name</label>
										<input name="data[User][first_name]" type="text" style="color:#000000; font-size:12px;">
									</div>
									
									<div id="onewaydiv" class="control-group span6">
										<label class="sub-label">Last Name</label>
										<input name="data[User][last_name]" type="text" style="color:#000000; font-size:12px;">
									</div>
									
								</div>
								
								<!-- <label>How many passengers? </label> -->

								<div class="row-fluid">
									<div class="control-group span6">
										<label class="sub-label">Phone</label>
										<input  type="text" name="data[User][contact_phone]" style="color:#000000; font-size:12px;">
									</div>		
									<div class="control-group span4">
										<label class="sub-label">Zipcode</label>
										<input type="text" name="data[User][contact_zip]" style="color:#000000; font-size:12px;">
									</div>
								</div>
								<div class="row-fluid">
									<div class="control-group span12">
										<label class="sub-label">Email</label>
										<input type="text" name="data[User][contact_email]" style="color:#000000; font-size:12px;">
									</div>									
								</div>

										
							<?php
							echo $this->Form->submit(__('Schedule'),array(
								'class'=>'btn btn-bbfl pull-right',
								'id'=>'',
							)); 
							?>
							</form>
							</div>
							  <div class="tab-pane" id="login">
								<form method="post" action="/deliveries/process_login">		
									<div class="row-fluid">
										<div class="control-group span8">
											<label class="sub-label">Username</label>
											<input type="text" name="data[User][username]" style="color:#000000; font-size:12px;">
										</div>									
									</div>
									<div class="row-fluid">
										<div class="control-group span8">
											<label class="sub-label">Password</label>
											<input type="password" name="data[User][password]" style="color:#000000; font-size:12px;">
										</div>									
									</div>
									<div class="row-fluid">
										<a href="/users/forgot" style="font-style: italic; color:#ffffff; text-decoration: underline">Forgot Login Information? - Click Here</a>
									</div>							
								<?php
								echo $this->Form->submit(__('Login'),array(
									'class'=>'btn btn-bbfl pull-right',
									'id'=>'',
								)); 
								?>
								</form>
							  </div>
						</div>
					</div>
					<div class="nomobile">
						
						<ul class="bxslider">
							<li>
								<div id="homeBodyDiv1" class="span6 pull-left"></div>
								<div id="homeBodyDiv2" class="span6 pull-left">
									<br/><br/>
									<p id="homeBody1">Toxin-Free</p>
									<p id="homeBody2">Eco-Friendly</p>
									<p id="homeBody3">Cleaning</p>
								</div>									
							</li>
							<li>
								<div id="homeBodyDiv1" class="span6 pull-left"></div>
								<div id="" class="span6 pull-left">
									<br/><br/>
									<h2>About Us</h2>
									<p id="aboutUsTextFront" class="text">
										Jays Dry Cleaners has been serving Seattle for over 35 years.  We are locally-owned and family-operated and provide the highest quality toxin-free, eco-friendly dry cleaning and laundry services for all your clothing and household needs.<br/><br/> We also offer expert alteration services and free pick up and delivery to local Seattle neighborhood homes and offices.	
									</p>
									
								</div>								
							</li>
						</ul>

					</div>
		</div>
		<!-- MUslider Slider::END-->
	</div>

	<div class="container">

		<div class="row">

		</div>
		
		<!-- Tertiary Section -->
		<div class="row" style="padding: 30px 0;">	

		</div>	
		
		<!-- Featured Texts Section -->
		<div class="row">
			<div class="section_featured_text">

			</div>
		</div>	
