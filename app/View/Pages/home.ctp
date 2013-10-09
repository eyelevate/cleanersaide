<?php

/**
 * HOME PAGE
 */
 
//load scripts to layout
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form'
	),
	'stylesheet',
	array('inline'=>false)
);
//JS Files
echo $this->Html->script(array(
	'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui js file
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
	
	$('.tripRadio').change(function(){
    	if($('#oneway').is(':checked')) { 
			$('#ReservationReturns').prop('disabled', true);
			$('#onewaydiv').hide();
		} else {
			$('#ReservationReturns').prop('disabled', false);
			$('#onewaydiv').show();
		}
	});
});
	
</script>


	<div class="row no_bm">
		<div id="slider_holder" class="sixteen columns">

				<div id="trip_planner">
					<div class="trip_planner_title">Schedule a delivery</div>
						<ul class="nav nav-pills" id="myTab">
						  <li class="active"><a href="#guest">Guest Delivery</a></li>
						  <li><a href="#login">Member Login</a></li>
						</ul>
						<div class="tab-content">
		  					<div class="tab-pane active" id="guest">
							<form action="/deliveries/process_sad" method="post" style="display: block;">
								
									
								<div class="row-fluid">
									<div class="control-group span6">
										<label class="sub-label">First Name:</label>
										<input name="data[User][first_name]" type="text">
									</div>
									
									<div id="onewaydiv" class="control-group span6">
										<label class="sub-label">Last Name:</label>
										<input name="data[User][last_name]" type="text">
									</div>
									
								</div>
								
								<!-- <label>How many passengers? </label> -->

								<div class="row-fluid">
									<div class="control-group span6">
										<label class="sub-label">Phone</label>
										<input  type="text" name="data[User][contact_phone]">
									</div>		
									<div class="control-group span4">
										<label class="sub-label">Zipcode</label>
										<input type="text" name="data[User][contact_zip]">
									</div>
								</div>
								<div class="row-fluid">
									<div class="control-group span8">
										<label class="sub-label">Email</label>
										<input type="text" name="data[User][contact_email]">
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
											<input type="text" name="data[User][username]">
										</div>									
									</div>
									<div class="row-fluid">
										<div class="control-group span8">
											<label class="sub-label">Password</label>
											<input type="password" name="data[User][password]">
										</div>									
									</div>
									<div class="row-fluid">
										<a href="/users/forgot" style="font-style: italic">Forgot Login Information? - Click Here</a>
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

				<div id="sequence" class="nomobile">
	
					<ul>
						<li>
							<img class="slider_bgr animate-in" src="/img/frontend/CohoBanner.jpg"/>
							<img class="slider_img animate-in" src="/img/frontend/1_1.png"/>
						</li>
						<li>
							<img class="slider_bgr" src="/img/frontend/SeattleBanner.jpg" />
							<img class="slider_img" src="/img/frontend/1_1.png"/>
						</li>
						<li>
							<img class="slider_bgr" src="/img/frontend/OlympicPeninsula.jpg" />
							<img class="slider_img" src="/img/frontend/1_1.png"/>
						</li>
						<li>
							<img class="slider_bgr" src="/img/frontend/VictoriaBanner.jpg" />
							<img class="slider_img" src="/img/frontend/1_1.png"/>
						</li>
										
					</ul>
 
				<div class="slider_nav_holder">
					<span class="slider_nav"></span>
					<span class="slider_nav"></span>
					<span class="slider_nav"></span>
					<span class="slider_nav"></span>
				</div>

			</div>
		</div>
		<!-- Sequence Slider::END-->
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
