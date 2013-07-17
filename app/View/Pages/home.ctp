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

//displays a message bar if the user has not logged in, before accessing. Uses auth->authError variable set in controller
echo $this->TwitterBootstrap->flashes(array(
    "auth" => true,
    "closable"=>false
    )
);


$contents = json_decode($contents[0]['Page_content']['html'], TRUE);

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
					<div class="trip_planner_title">Plan your trip</div>
											
						<ul class="nav nav-pills" id="myTab">
						  <li class="active"><a href="#ferry">Ferry Reservation</a></li>
						  <li><a href="#package">Package Deal</a></li>
						</ul>

						<div class="tab-content">
		  					<div class="tab-pane active" id="ferry">
							<form action="/reservations/ferry" method="post" style="display: block;">
								
								<!-- <legend>Is this a roundtrip or a one-way trip?</legend> -->
								<div class="row-fluid">
									<div class="control-group span4">
										<label for="roundtrip"><input id="roundtrip" class="tripRadio" type="radio" name="data[Reservation][trip_type]" value="roundtrip" checked="checked"/> <span>Roundtrip</span></label>
										<label for="oneway"><input id="oneway" class="tripRadio" type="radio" name="data[Reservation][trip_type]" value="oneway"/> <span>One way</span></label>
									</div>
									<div class="control-group span8">
										<label class="sub-label" for="ReservationDepartPort">Departing from:</label>
										<select name="data[Reservation][depart_port]" id="ReservationDepartPort">
											<option value="Port Angeles" selected="selected">Port Angeles</option>
											<option value="Victoria">Victoria</option>
										</select>
									</div>
								</div>
									
								<div class="row-fluid">
									<div class="control-group span6">
										<label class="sub-label">Departing:</label>
										<input name="data[Reservation][departs]" class="datepicker" type="text" id="ReservationDeparts">
									</div>
									
									<div id="onewaydiv" class="control-group span6">
										<label class="sub-label">Returning:</label>
										<input name="data[Reservation][returns]" class="datepicker" type="text" id="ReservationReturns">
									</div>
									
								</div>
								
								<!-- <label>How many passengers? </label> -->
								<div class="row-fluid">
									<div class="control-group span4">
										<label class="sub-label">Adult (12+)</label>
										<input class="adults" type="text" value="0" name="data[Reservation][adults]">
									</div>
									<div class="control-group span4">
										<label class="sub-label">Youth (5-11)</label>
										<input class="children" type="text" value="0" name="data[Reservation][children]">
									</div>
									<div class="control-group span4">
										<label class="sub-label">Child (0-4)</label>
										<input class="infants" type="text" value="0" name="data[Reservation][infants]">
									</div>
								</div>
										
							<?php
							echo $this->Form->submit(__('Search'),array(
								'class'=>'btn btn-bbfl pull-right',
								'id'=>'',
							)); 
							?>
							</form>
							</div>
							  <div class="tab-pane" id="package">
								<form action="/packages/home" method="post" style="display: block;">
									
									<!-- <legend>Is this a roundtrip or a one-way trip?</legend> -->
									<div class="row-fluid">
										<div class="control-group span12">
											<label class="sub-label" for="PackageDepartPort">Departing from:</label>
											<select name="package[Reservation][depart_port]" id="PackageDepartPort">
												<option value="Port Angeles" selected="selected">Port Angeles</option>
												<option value="Victoria">Victoria</option>
											</select>
										</div>
									</div>
										
									<div class="row-fluid">
										<div class="control-group span12">
											<label class="sub-label">Departing:</label>
											<input name="package[Reservation][departs]" class="datepicker" type="text" id="PackageDeparts">
										</div>
										
									</div>
									
									<!-- <label>How many passengers? </label> -->
<!-- 									<div class="row-fluid">
										<div class="control-group span4">
											<label class="sub-label">Adult (12+)</label>
											<input class="adults" type="text" value="0" name="package[Reservation][adults]">
										</div>
										<div class="control-group span4">
											<label class="sub-label">Youth (5-11)</label>
											<input class="children" type="text" value="0" name="package[Reservation][children]">
										</div>
										<div class="control-group span4">
											<label class="sub-label">Child (0-4)</label>
											<input class="infants" type="text" value="0" name="package[Reservation][infants]">
										</div>
									</div> -->
											
								<?php
								echo $this->Form->submit(__('Search'),array(
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
			<!-- Featured packages Section -->
			<h2 class="sixteen columns title"><span>Package Deals</span></h2>
			<div class="clear"></div>
					
				<div class="section_featured_packages sixteen columns alpha">
					<div class='carousel_arrows_bgr'></div>
					<ul id="featured_packages_carousel">
						
						<?php

						foreach ($packages as $key => $value) {
							$packages_id = $packages[$key]['Package']['id'];
							$packages_location = $packages[$key]['Package']['location'];
							$packages_url_location = strtolower($packages_location);
							$packages_url_location = str_replace(array(' ','%20','%26',"'",'&'),array('-','','','','and'),$packages_url_location);
							$packages_name = $packages[$key]['Package']['name'];
							$packages_url_name = strtolower($packages_name);
							$packages_url_name = str_replace(array(' ','%20','%26',"'",'&'),array('-','','','','and'),$packages_url_name);
							$packages_url_display = $packages[$key]['Package']['url'];
							$packages_image_main = $packages[$key]['Package']['image_main'];
							if($packages[$key]['Package']['image_main'] ==''){
								$packages_primary_image = 'http://placehold.it/250x250';
							} else {
								$packages_primary_image = '/img/packages/'.$packages_image_main;
							}
							$packages_starting_price = $packages[$key]['Package']['starting_price'];
							$packages_inventory = $packages[$key]['Package']['inventory'];
							
							$packages_transportation = json_decode($packages[$key]['Package']['transportation'],true);
							$check_walkon = 0;
							
							if(count($packages_transportation)>0){
								foreach ($packages_transportation as $pkey => $pvalue) {
									if($pkey == 19){
										$check_walkon++;
									}
								}
							}
							$packages_rt_walkon = sprintf('%.2f',round($packages[$key]['Package']['rtWalkon'] / 2,2)); 
							$packages_rt_vehicle = sprintf('%.2f',round($packages[$key]['Package']['rtVehicle']/2,2));		
							
							if($check_walkon > 0){
								$package_base_price = $packages_rt_walkon;
							} else {
								$package_base_price = $packages_rt_vehicle;
							}	
								
							?>
										
						<li class="four columns">
							<div class="pic" style="background-size:cover; -moz-border-radius: 3px; -webkit-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;height: 215px; background-image:url(<?php echo $packages_primary_image;?> );" >
								<a class="packageDetailsLink" package_id="<?php echo $packages_id;?>" href="/packages/details<?php echo $packages_url_display;?>" style="width:100%; height:100%; display: block; cursor:pointer" ><!-- <img src="<?php echo $packages_primary_image;?>"/> --><div class="img_overlay"></div></a>
							</div>
							<h3><? echo $packages_location; ?></h3>						
								<h4><a class="packageDetailsLink" package_id="<?php echo $packages_id;?>" href="/packages/details<?php echo $packages_url_display;?>" style="cursor:pointer"><? echo $packages_name?> </a></h4>
							<!-- <p>Includes round trip ferry fare and 1 night hotel stay at Hotel Name.</p> -->
							<a class="packageDetailsLink" package_id="<?php echo $packages_id;?>" href="/packages/details<?php echo $packages_url_display;?>" style="cursor:pointer">From $<?php echo round($package_base_price); ?> per person</a>
						</li>
			
		<?php
		}
		?>		
						
				
					</ul>
				</div>			
				
			<script type="text/javascript">
			$(document).ready(function() {
				// Reload carousels on window resize to scroll only 1 item if viewport is small
			    $(window).resize(function() {
			    	 var el = $("#featured_packages_carousel"), carousel = el.data('jcarousel'), win_width = $(window).width();
			    	   var visibleItems = (win_width > 767 ? 4 : 1);
			    	   carousel.options.visible = visibleItems;
			    	   carousel.options.scroll = visibleItems;
			    	   carousel.reload();
			    });
			 });
			    
			</script>
			<!-- Featured packages section::END -->
		</div>
		
		<!-- Tertiary Section -->
		<div class="row" style="padding: 30px 0;">	
			<div class="nine columns alpha nomobile">
				<? if ($contents['secondary_promo']) { echo $contents['secondary_promo'];} else { ?>
					<a href="/You-Wont-Be-Sorry"><img src="/img/frontend/home_promo.png" /></a>
				<? } ?>
			</div>
			
			
			<div class="seven columns omega">
				<div class="home-feature-boxes passport">
					<? if ($contents['secondary_info_1']) { echo $contents['secondary_info_1'];} else { ?>
						<h3>Travel Information</h3>
						<p>Click here to get the latest travel and passport information.</p>
						<a href="/ID-Requirements">Click here</a>
					<? } ?>
				</div>
				<div class="home-feature-boxes newsletter">	
					<? if ($contents['secondary_info_2']) { echo $contents['secondary_info_2'];} else { ?>
						<h3>Sign up for our e-newsletter</h3>
						<p>And get the latest on last-minute deals, contests, updates, and more.</p>
						<a href="http://visitor.r20.constantcontact.com/manage/optin/ea?v=001g9Qimy9ZAK10-Z9fR7E1IHMVfbX562TjIoHCMrwqmX3VdUUlEBEoD0XB4orRHtT3BaEew3-6xmROIpq0WEDsyg%3D%3D">Click here</a>
					<? } ?>
				</div>
			</div>
		</div>	
		
		<!-- Featured Texts Section -->
		<div class="row">
			<div class="section_featured_text">
				<div class="columns five " style="padding-right: 20px; border-right: 1px dotted #bbb;">
					<? if ($contents['tertiary_1']) { echo $contents['tertiary_1'];} else { ?>
						<h3>Festivals + Events</h3>
						<p>Whether you’re looking for a delicious taste of Dungeness Crab, a weekend filled with great music, or a celebration of local craft brews, we’ve got some great suggestions on the best events happening in the Pacific Northwest.</p>
						<a href="/Festivals-Events">Find out more</a>
					<? } ?>
				</div>
				<div class="columns five" style="padding-right: 20px; border-right: 1px dotted #bbb;">
					<? if ($contents['tertiary_2']) { echo $contents['tertiary_2'];} else { ?>
						<h3>Travel Free on your Birthday</h3>
						<p>Looking for a unique way to celebrate? We’ll give you free round-trip walk-on ferry fare on the MV Coho if you depart on your birthday. </p>
						<a href="/birthdayfare">Find out more</a>
					<? } ?>
				</div>
				<div class="columns five omega">
					<? if ($contents['tertiary_3']) { echo $contents['tertiary_3'];} else { ?>
						<h3>About the Ship</h3>
						<p>The MV Coho travels between downtown Victoria and downtown Port Angeles and has provided safe and reliable transportation for more than 21 million passengers and over 5 million vehicles since beginning operation in 1959.</p>
						<a href="/MV-Coho">Find out more</a>
					<? } ?>
				</div>
			</div>
		</div>	
