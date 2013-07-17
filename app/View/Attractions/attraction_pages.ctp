<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/reservation_ferry',
	'frontend/bootstrap-form'
	),
	'stylesheet',
	array('inline'=>false)
);

echo $this->Html->script(array(
	'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui file
	'frontend/reservation_attractions.js',
	'frontend/reservation_sidebar.js'
	),
	FALSE
);
//create variables here
//debug($attractions);
foreach ($attractions as $attraction) {
	$attraction_id = $attraction['Attraction']['id'];
	$attraction_location = $attraction['Attraction']['location'];
	$attraction_name = $attraction['Attraction']['name'];
	$attraction_url = $attraction['Attraction']['url'];
	$attraction_description = $attraction['Attraction']['description'];
	$attraction_address = $attraction['Attraction']['address'];
	$attraction_city = $attraction['Attraction']['city'];
	$attraction_state = $attraction['Attraction']['state'];
	$attraction_country = $attraction['Attraction']['country'];
	$attraction_zipcode = $attraction['Attraction']['zipcode'];
	$attraction_billing_address = $attraction['Attraction']['billing_address'];
	$attraction_billing_city = $attraction['Attraction']['billing_city'];
	$attraction_billing_state = $attraction['Attraction']['billing_state'];
	$attraction_billing_zip = $attraction['Attraction']['billing_zip'];
	$attraction_billing_country = $attraction['Attraction']['billing_country'];
	$attraction_phone = $attraction['Attraction']['phone'];
	$attraction_phone2 = $attraction['Attraction']['phone2'];
	$attraction_phone_fax = $attraction['Attraction']['phone_fax'];
	$attraction_web_address = $attraction['Attraction']['web_address'];
	$attraction_reservation_email = $attraction['Attraction']['reservation_email'];
	$attraction_max_free_age = $attraction['Attraction']['max_age_free'];
	$attraction_amenities = $attraction['Attraction']['amenities'];
	$attraction_distance_port = $attraction['Attraction']['distance_port'];
	$attraction_distance_units = $attraction['Attraction']['distance_units'];
	$attraction_reservation_cutoff = $attraction['Attraction']['reservation_cutoff'];
	$attraction_reservation_cutoff_units = $attraction['Attraction']['reservation_cutoff_units'];
	if(is_null($attraction_reservation_cutoff_units)){
		$cutoff = 0;
	} else {
		switch ($attraction_reservation_cutoff_units) {
			case 'seconds':
				$cutoff = $attraction_reservation_cutoff;
				break;	
			case 'minutes':
				$cutoff = ($attraction_reservation_cutoff * 60);
				break;
			case 'hours':
				$cutoff = ($attraction_reservation_cutoff * 60) * 60;
				break;
			case 'days':
				$cutoff = (($attraction_reservation_cutoff*24)*60)*60;
				break;
		}
	}
	$attraction_bookable_rooms = $attraction['Attraction']['bookable_rooms'];
	$attraction_shuttle_service = $attraction['Attraction']['shuttle_service'];
	$attraction_primary_first_name = $attraction['Attraction']['primary_first_name'];
	$attraction_primary_last_name = $attraction['Attraction']['primary_last_name'];
	$attraction_primary_phone = $attraction['Attraction']['primary_phone'];
	$attraction_primary_ext = $attraction['Attraction']['primary_ext'];
	$attraction_primary_reason = $attraction['Attraction']['primary_reason'];
	$attraction_alt_first_name = $attraction['Attraction']['alt_first_name'];
	$attraction_alt_last_name = $attraction['Attraction']['alt_last_name'];
	$attraction_alt_phone = $attraction['Attraction']['alt_phone'];
	$attraction_alt_ext = $attraction['Attraction']['alt_ext'];
	$attraction_alt_reason = $attraction['Attraction']['alt_reason'];
	$attraction_featured = $attraction['Attraction']['featured'];
	$attraction_starting_price = $attraction['Attraction']['starting_price'];
	$attraction_class = $attraction['Attraction']['class'];
	$attraction_add_ons = $attraction['Attraction']['add_ons'];
	$attraction_image_main = $attraction['Attraction']['image_main'];
	$attraction_image_sort = $attraction['Attraction']['image_sort'];
	$attraction_status = $attraction['Attraction']['status'];
	
}

//session counter comes from controller based on cookies set if not saved for after 20 mins then delete and start over
?>

<div class="container">

	<div class="row-fluid">
		<div class="sixteen columns alpha">
		   
			<div class="page_heading"><h1><?php echo $attraction_name;?></h1></div>

		</div>		
	</div>
	
	<div class="row-fluid">
			<!-- Wide Column -->
			<div class="twelve columns alpha">

				<!-- images and description -->
				<div id="twelve columns alpha clearfix">
					<div class="four columns alpha clearfix">
						<img class="media-object img-border" src="/img/attractions/<? echo $attraction_image_main; ?>" style="width:200px;"/>
					</div>
					<div class="eight columns omega">
						<p><?php echo $attraction_description;?></p>
						<div class="" style="background-color: #f5f5f5; padding: 10px 0; display: block; height: 23px;">
							<p style="font-size:12px; margin-left: 10px; float: left; margin-bottom: 0px; color:#666; line-height: 24px; ">
								<?php echo $attraction_city.', '.$attraction_state;?> | 
								Prices from <span style="font-weight:bold;">$<?php echo round($attraction_starting_price); ?></span> per ticket including taxes
							</p>
						</div>
					</div>
				</div>

				<!-- basic attr form -->
				<div id="formDiv" class="form-actions twelve columns alpha" style="padding-left:0px;padding-right:0px;">
					<h3 style="margin-left:20px;">Select Tour Date</h3>	
					<div class="control-group pull-left span3" style="margin-left: 20px;">
						<label>Desired Date</label>
						<div class="input-append span9" style="margin-left:0px;">
							<input id="start" class="span12 datepicker" type="text" cutoff="<?php echo $cutoff;?>"/>
							<span class="add-on pointer"><i class="small-icon-calendar"></i></span>	
						</div>
						<span class="help-block three columns alpha"></span>
					</div>
					<div class="twelve columns alpha">
						<input id="attraction_id" type="hidden" value="<?php echo $attraction_id;?>"/>
						<button id="searchButton" class="btn btn-bbfl" type="button" style="margin-left: 20px;">View Ticket Options</button>
					</div>
				</div>
				<!-- hotel rooms -->
				<div id="resultsDiv" class="hide">
					<h3 class="twelve columns alpha">Available Tours</h3>
					<ul id="tourAvailableUl" class="" ></ul>
				</div>
			</div>
			<!-- Wide Column::END -->
	
	
			<!-- Side Column -->
			<?php 

			echo $this->element('pages/sidebar',array(
				'current_page'=>'reservation',
				'Ferries'=>'YES',
				'Hotels'=>'YES',
				'Attractions'=>'YES',
				'Packages'=>'YES',
				'ferry_sidebar'=>$ferry_sidebar,
				'hotel_sidebar'=>$hotel_sidebar,
				'attraction_sidebar'=>$attraction_sidebar,
				'package_sidebar'=>$package_sidebar
			)); 
			?>
				
		</div>	