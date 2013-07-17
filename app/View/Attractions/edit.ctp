<?php

//load styles & scripts to layout
echo $this->Html->css(array(
	'/js/admin/plugins/stepy/css/jquery.stepy',
	'/js/admin/plugins/plupload/js/jquery.plupload.queue/css/plupload-gebo.css',
	'/js/admin/plugins/datepicker/datepicker.css',	
	'attractions.css',
	),'stylesheet',array('inline',false)
);
echo $this->Html->script(array(
	'admin/plugins/validation/jquery.validate.min.js',
	'admin/plugins/plupload/js/plupload.full.js',
	'admin/plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.full.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/attraction_html.js',
	'admin/attractions_edit.js',
	'admin/attraction_add_image.js'),
	FALSE
);	
?>

<div class='row-fluid'>
	<div class="">
		<div id="attractionAddTitle" class="well well-small">
		<?php
		foreach ($attractions as $attraction) {
			$attraction_name = $attraction['Attraction']['name'];			
			$attraction_location = $attraction['Attraction']['location'];
			$attraction_url = $attraction['Attraction']['url'];
			$foreign_id = $attraction['Attraction']['foreign_id'];
			$currency = $attraction['Attraction']['currency'];
			$description = $attraction['Attraction']['description'];
			$street = $attraction['Attraction']['address'];
			$city = $attraction['Attraction']['city'];
			$state = $attraction['Attraction']['state'];
			$country = $attraction['Attraction']['country'];
			$region = $attraction['Attraction']['region'];
			$zipcode = $attraction['Attraction']['zipcode'];
			$billing_street = $attraction['Attraction']['billing_address'];
			$billing_city = $attraction['Attraction']['billing_city'];
			$billing_state = $attraction['Attraction']['billing_state'];
			$billing_zip = $attraction['Attraction']['billing_zip'];
			$billing_country = $attraction['Attraction']['billing_country'];
			$phone = $attraction['Attraction']['phone'];
			$phone2 = $attraction['Attraction']['phone2'];
			$phone_fax = $attraction['Attraction']['phone_fax'];
			$web_address = $attraction['Attraction']['web_address'];
			$reservation_email = $attraction['Attraction']['reservation_email'];
			$max_age = $attraction['Attraction']['max_age_free'];
			$amenities = $attraction['Attraction']['amenities'];
			$distance_port = $attraction['Attraction']['distance_port'];
			$distance_units = $attraction['Attraction']['distance_units'];
			$cutoff = $attraction['Attraction']['reservation_cutoff'];
			$cutoff_units = $attraction['Attraction']['reservation_cutoff_units'];
			//$bookable_tickets = $attraction['Attraction']['bookable_tickets'];
			$shuttle = $attraction['Attraction']['shuttle_service'];
			$primary_first_name = $attraction['Attraction']['primary_first_name'];
			$primary_last_name = $attraction['Attraction']['primary_last_name'];
			$primary_phone = $attraction['Attraction']['primary_phone'];
			$primary_ext = $attraction['Attraction']['primary_ext'];
			$primary_email = $attraction['Attraction']['primary_email'];
			$primary_reason = $attraction['Attraction']['primary_reason'];
			$alt_first_name = $attraction['Attraction']['alt_first_name'];
			$alt_last_name = $attraction['Attraction']['alt_last_name'];
			$alt_phone = $attraction['Attraction']['alt_phone'];
			$alt_ext = $attraction['Attraction']['alt_ext'];
			$alt_email = $attraction['Attraction']['alt_email'];
			$alt_reason = $attraction['Attraction']['alt_reason'];
			$selected_featured = $attraction['Attraction']['featured'];
			if($selected_featured == ''){
				$selected_featured = 'no';
			}
			$starting_price = $attraction['Attraction']['starting_price'];
			$class = $attraction['Attraction']['class'];
			//$blocks = $attraction['Attraction']['blocks'];
			$add_ons = json_decode($attraction['Attraction']['add_ons'],true);
			$image_main = $attraction['Attraction']['image_main'];
			$image_sort = json_decode($attraction['Attraction']['image_sort'],true);
			$attraction_status = $attraction['Attraction']['status'];
			$accounting_code = $attraction['Attraction']['accounting_code'];
		}
		?>
			<h3><?php echo $attraction_name;?></h3>
		</div>
		<?php
		
		echo $this->Form->create('Attraction',array('id'=>'attraction','class'=>'stepy-wizzard form-horizontal', 'novalidate'=>'novalidate')); 	
		//step 1 basic_information 
		echo $this->element('/attractions/edit/basic_information',array(
			'attraction_name'=>$attraction_name,
			'attraction_location'=>$attraction_location,
			'locations'=>$locations
		));
		
		//step 2 Attraction Information
		echo $this->element('/attractions/edit/attraction_information',array(
			'street'=>$street,
			'city'=>$city,
			'state'=>$state,
			'zipcode'=>$zipcode,
			'country'=>$country,
			'phone'=>$phone,
			'phone2'=>$phone2,
			'phone_fax'=>$phone_fax,
			'reservation_email'=>$reservation_email,
			'web_address'=>$web_address,
			'billing_street'=>$billing_street,
			'billing_city'=>$billing_city,
			'billing_state'=>$billing_state,
			'billing_zip'=>$billing_zip,
			'billing_country'=>$billing_country,
			'primary_first_name'=>$primary_first_name,
			'primary_last_name'=>$primary_last_name,
			'primary_phone'=>$primary_phone,
			'primary_ext'=>$primary_ext,
			'primary_email'=>$primary_email,
			'primary_reason'=>$primary_reason,
			'alt_first_name'=>$alt_first_name,
			'alt_last_name'=>$alt_last_name,
			'alt_phone'=>$alt_phone,
			'alt_ext'=>$alt_ext,
			'alt_email'=>$alt_email,
			'alt_reason'=>$alt_reason,
			'accounting_code'=>$accounting_code
			
		));
		
		//step 3 Attraction Details
		
		echo $this->element('/attractions/edit/attraction_details',array(
			'attraction_status'=>$attraction_status,
			'distance_units'=>$distance_units,
			'distance_port'=>$distance_port,
			'shuttle'=>$shuttle,
			'country'=>$country,
			'add_ons'=>$add_ons
		));
		
		//step 4 Attraction Tickets
		
		echo $this->element('/attractions/edit/attraction_tickets',array(
			'attraction_tickets'=>$attraction_tickets,
			'country'=>$country,
			'minutes'=>json_encode($minutesArray)
		));
		
		//step 5 Attraction Marketing
		
		echo $this->element('/attractions/edit/attraction_marketing',array(
			'selected_featured'=>$selected_featured,
			'starting_price'=>$starting_price,
			'description'=>$description,
			'image_main'=>$image_main,
			'image_sort'=>$image_sort,
			'attraction_tickets'=>$attraction_tickets,
		));

		//finish the form
		echo $this->Form->end();
		?>
	</div>	
</div>
<!-- A special div to manipulate attraction tickets -->
<div id="attractionTicketManipulate" class="hide"></div>
<div id="variableForm">
	<input class="exchange" type="hidden" value="<?php echo $exchange;?>"/>
	<input class="minutes" datasource='<?php echo json_encode($minutesArray);?>' type="hidden"/>
</div>
