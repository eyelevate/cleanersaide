<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/reservation_ferry',
	'frontend/bootstrap-form',
	'frontend/package_details'
	),
	'stylesheet',
	array('inline'=>false)
);

echo $this->Html->script(array(
	'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui file
	'frontend/reservation_packages.js',
	'frontend/reservation_sidebar.js'
	),
	FALSE
);


//create variables here
foreach ($packages as $p) {
	$package_id = $p['Package']['id'];
	$package_location = $p['Package']['location'];
	switch($package_location){
		case 'Victoria':
			$departing_port = 'Port Angeles';
		break;
			
		case 'Seattle':
			$departing_port = 'Victoria';
		break;
			
		case 'Portland':
			$departing_port = 'Victoria';
		break;
			
		case 'Vancouver Island':
			$departing_port = 'Port Angeles';
		break;
			
		default:
			$departing_port = 'Victoria';
		break;
	}
	$package_city = $p['Package']['city'];
	$package_state = $p['Package']['state'];
	$package_name = $p['Package']['name'];
	$package_desc = $p['Package']['description'];
	$package_image_main = $p['Package']['image_main'];
	$package_image_sort = $p['Package']['image_sort'];
	if($p['Package']['image_main'] ==''){
		$package_primary_image = 'http://placehold.it/75x75';
	} else {
		$package_primary_image = '/img/packages/'.$package_image_main;
	}

	$package_inventory = $p['Package']['inventory'];
	$package_start = $p['Package']['start_date'];
	$package_end = $p['Package']['end_date'];
	$package_cutoff = $p['Package']['cutoff'];
	$package_cutoff_by = $p['Package']['cutoff_by'];
	if(is_null($package_cutoff_by)){
		$cutoff = 0;
	} else {
		switch ($package_cutoff_by) {
			case 'seconds':
				$cutoff = $package__cutoff;
				break;	
			case 'minutes':
				$cutoff = ($package_cutoff * 60);
				break;
			case 'hours':
				$cutoff = ($package_cutoff * 60) * 60;
				break;
			case 'days':
				$cutoff = (($package_cutoff*24)*60)*60;
				break;
		}
	}
	$package_starting_point = $p['Package']['starting_point'];
	if($package_starting_point == 'Port Angeles'){
		$package_returning_point = 'Victoria';
	} else {
		$package_returning_point = 'Port Angeles';
	}

	$package_created = $p['Package']['created'];
	$package_modified = $p['Package']['modified'];
	$package_attraction = $p['Package']['attractions'];
	$package_status = $p['Package']['status'];
	if(!is_null($p['Package']['hotels'])){
		$hotel_id = $p['Package']['hotels'];	
		$day_trip = 'No';
	} else {
		$hotel_id = $p['Package']['hotels'];
		$day_trip = 'Yes';
	}
	
	
	if(!empty($p['Package']['hotel_name'])){
		$hotel_name = $p['Package']['hotel_name'];	
	} else {
		$hotel_name = '';	
	}
	if(!empty($p['Package']['max_age_free'])){
		$hotel_max_age_free = $p['Package']['max_age_free'];
	} else {
		$hotel_max_age_free = '';
	}

	$package_transportation = $p['Package']['transportation'];
	$base_passenger_check = 0;
	foreach ($package_transportation as $key => $value) {
		$trans_id = $key;
		if($trans_id=='19'){
			$base_passenger_check++;
		}
	}
	switch($base_passenger_check){
		case '0':
			$summary_type = 'Vehicle';
		break;
			
		default:
			$summary_type = 'Passenger';	
		break;	
	}
	$package_rt_vehicle = $p['Package']['rtVehicle'];
	$package_rt_walkon = $p['Package']['rtWalkon'];
	if(!empty($p['Package']['addOns'])){
		$package_add_ons = $p['Package']['addOns'];
	} else {
		$package_add_ons = array();
	}
	
}

if(!isset($package_date)){
	$package_date = date('m/d/Y');
}

//session counter comes from controller based on cookies set if not saved for after 20 mins then delete and start over

?>

<div class="container">

	<div class="row-fluid">
		<div class="sixteen columns alpha">
		   
			<div class="page_heading"><h1><?php echo $package_name;?></h1></div>

		</div>		
	</div>
	
	<div class="row-fluid">
		<form class="formPackage" action="/packages/processing_frontend_packages" method="post">
			<!-- Wide Column -->
			<div class="twelve columns alpha">
				<!-- images and description -->
				<div class="twelve columns alpha clearfix">
					<div class="four columns alpha clearfix">
						<img class="media-object" src="<?php echo $package_primary_image;?>" style="width:200px;"/>
					</div>
					<div class="eight columns alpha">
						<p><?php echo $package_desc;?></p>
					</div>
				</div>
				<div class="twelve columns alpha clearfix">
					<br/>
					<p style="font-size: 80%;">Package valid from <?php echo date('F jS Y',strtotime($package_start));?> until <?php echo date('F jS Y',strtotime($package_end));?>.<br>
					 	<?php
					 	if($day_trip=='No'){
					 		echo 'Default package pricing based on two adults, one night stay.';
					 	} else {
					 		echo 'Default package pricing based on two adults.';
					 	}
					 	?>

					</p>					
				</div>	
				<div class="twelve columns alpha clearfix">
					<div class="form-actions">
						<div class="control-group twelve columns alpha" >

							<h3>What is the transportation type? <span class="f_req">*</span></h3>
							<select id="transportationSelect" name="data[Ferry_reservation][vehicles][0][item_id]" style="width:400px;">

								<?php
							
								if($summary_type == 'Vehicle'){ //this is not a day trip so make a standard vehicle the default
									if(count($package_transportation)>0){
										foreach ($package_transportation as $key => $value) {
											$trans_id = $key;
											$trans_name = $package_transportation[$key]['name'];

											
											
											if($trans_id=='22'){
											?>
											<option value="<?php echo $trans_id;?>" selected="selected"><?php echo $trans_name;?></option>
											<?php											
											} else {
											?>
											<option value="<?php echo $trans_id;?>"><?php echo $trans_name;?></option>
											<?php											
											}
	
										}									
									}									
								} else { //this is a day trip so make walk on passengers the default
									if(count($package_transportation)>0){
										foreach ($package_transportation as $key => $value) {
											$trans_id = $key;
											$trans_name = $package_transportation[$key]['name'];
											if($trans_id=='19'){
											?>
											<option value="<?php echo $trans_id;?>" selected="selected"><?php echo $trans_name;?></option>
											<?php											
											} else {
											?>
											<option value="<?php echo $trans_id;?>"><?php echo $trans_name;?></option>
											<?php											
											}
	
										}									
									}										
								}
							

								?>
							</select>

						</div>
						


						<div id="overlengthDiv" class="clearfix hide" >
							<div class="five columns alpha">
								<div class="control-group">
									<label>Length of vehicle (must be over 18 feet)</label>
									<div class="input-append">
										<input id="overlengthInput" type="text" name="data[Ferry_reservation][vehicles][0][overlength]"/>
										<span class="add-on">Feet</span>
									</div>								
								</div>								
							</div>

							<div class="five columns alpha">
							<?php
							foreach ($inv as $inventory) {
								$inventory_id = $inventory['Inventory']['id'];
									$towed_units = json_decode($inventory['Inventory']['towed_units'], true);
									$towed_options = array();
									$tu_idx = -1;
									foreach ($towed_units as $tu) {
										$tu_idx++;
										$towed_name = $tu['name'];
										$towed_desc = $tu['desc'];
										$towed_options[$towed_name.' ('.$towed_desc.')'] = $towed_name.' ('.$towed_desc.')'; 
									}
									echo $this->Form->input('Ferry_reservation.vehicles.0.towed_unit',array(
										'div'=>array('class'=>'control-group'),
										'class'=>'towed_units',
										'label'=>'<label>Towed Unit (if applicable)</label>',
										'options'=>$towed_options,
										'error'=>array('attributes'=>array('class'=>'help-block')),
									));		

							}
							?>								
							</div>

							
						</div>
					</div>				
				</div>

				<!-- basic hotel form -->
				<?php
				if($hotel_name !=''){
				?>	
				<div id="formDiv" class="form-actions twelve columns alpha" style="padding-left:0px;padding-right:0px;">
					<h2 style="padding-left:20px;">Hotel Form <span class="f_req">*</span></h2>
					<div class="clearfix" style="padding:20px;">
						<h3><?php echo $hotel_name;?></h3>
						<div class="control-group pull-left" style="margin-right:5px">
							<label>Hotel check-in date</label>
							<div class="input-append">
								<input id="hotel_start" type="text" style="width:125px;" name="data[Hotel_reservation][check_in]" value="<?php echo $package_date;?>"/>
								<span class="add-on"><i class="small-icon-calendar"></i></span>
							</div>
							
						</div>
						<div class="control-group pull-left" style="margin-right:5px;">
							<label>Nights</label>
							<input id="hotel_nights" type="text" name="data[Hotel_reservation][nights]" style="width:125px" value="1"/>
							
						</div>
						<div class="control-group pull-left" style="margin-right:5px;">
							<label>Rooms</label>
							<select id="hotel_rooms" name="data[Hotel_reservation][rooms]">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
						<div class="control-group pull-left" style="margin-right:5px;">
							<label>Adults (age <?php echo $hotel_max_age_free;?>+)</label>
							<input id="hotel_adults" type="text" value="2" style="width:120px;" name="data[Hotel_reservation][adults]"/>									
						</div>
						<div class="control-group pull-left">
							<label>Children (under <?php echo $hotel_max_age_free;?>)</label>
							<input id="hotel_children" type="text" value="0" style="width:120px;"  name="data[Hotel_reservation][children]"/>
						</div>
						<div class="four columns alpha">
							<button id="searchRooms" class="btn btn-bbfl" type="button">Search Hotel Rooms</button>	
						</div>
						
					</div>
				</div>
				<!-- inserted rooms here -->
				<div id="roomUl" class="clearfix"></div>
				<?php
				} //endif

				if($package_attraction == 'Yes'){
				?>
				<div id="attractionDiv" class="twelve columns alpha clearfix">
					<div class="form-actions">
						<h2>Attraction Form <small><em>(optional)</em></small></h2>
						<div class="control-group twelve columns alpha clearfix">
							<label>Select Attraction</label>
							<select id="attractionSelect" name="data[Attraction_reservation][attraction_id]" style="width:300px">
								<option value="No">No Attraction</option>
								<?php
								foreach ($attractions as $at) {
									$attraction_id = $at['Attraction']['id'];
									$attraction_name = $at['Attraction']['name'];
									?>
									<option value="<?php echo $attraction_id;?>"><?php echo $attraction_name;?></option>
									<?php
								}
								?>
							</select>
						</div>
	
						<div class="twelve columns alpha control-group clearfix">
							<label>Tour Date</label>
							<div class="input-append">
								<input id="tourDate" type="text" style="width:125px" name="data[Attraction_reservation][reserved_date]"/>
								<span class="add-on"><i class="small-icon-calendar"></i></span>
							</div>
						</div>
						<div class="twelve columns alpha clearfix">
							<button class="selectAttractionTour btn btn-bbfl" type="button">Search Tours</button>	
						</div>
						
					</div>					
				</div>
				
				<?php
				}
				?>
				<ul id="toursAvailable" class="clearfix unstyled">
					
				</ul>				
				<div id="ferryDiv" class="twelve columns alpha clearfix">
					<div class="form-actions">
						<h2>Ferry Form <span class="f_req">*</span></h2>
						<div class="control-group twelve columns alpha">
							<legend style="font-size:100%;"><strong>Is this a roundtrip or a one-way trip?<span class="f_req">*</span></strong></legend>
							<div class="controls">
								<label class="radio"><input class="roundTripCheck" type="radio" checked="checked" name="data[Ferry_reservation][trip_type]" value="Yes"/> Roundtrip</label>
								
								<label class="radio"><input class="roundTripCheck" type="radio" name="data[Ferry_reservation][trip_type]" value="No"/> One-way</label>
							</div>
						</div>		
						<div class="control-group twelve columns alpha">
							<legend style="font-size:100%;"><strong>Where will you be departing from? <span class="f_req">*</span></strong></legend>
							<select id="portSelected" style="width:200px;" name="data[Ferry_reservation][depart_port]">
								<?php
								if($departing_port == 'Port Angeles'){
								?>
								<option selected="selected" value="Port Angeles">Port Angeles</option>
								<option value="Victoria">Victoria</option>								
								<?php	
								} else {
								?>
								<option value="Port Angeles">Port Angeles</option>
								<option selected="selected" value="Victoria">Victoria</option>								
								<?php	
								}
								?>
							</select>
						</div>		
						<div class="clearfix">
						<?php
						if($summary_type == 'Passenger'){
						?>
							<div id="driversDiv" class="control-group pull-left hide" style="margin-right:5px">
								<label>Driver</label>
								<input id="driver" type="text" value="0" style="width:125px" name="data[Ferry_reservation][drivers]" disabled="disabled"/>
							</div>
							<div id="addtlAdultsDiv" class="control-group pull-left hide" style="margin-right:5px">
								<label>Extra Adults (ages 12+)</label>
								<input id="extraAdults" type="text" value="0" style="width:125px" name="data[Ferry_reservation][adults]" disabled="disabled"/>
							</div>
							<div id="adultsDiv" class="control-group pull-left" style="margin-right:5px">
								<label>Adults (ages 12+)</label>
								<input id="adults" type="text" value="2" style="width:125px;" name="data[Ferry_reservation][adults]"/>
							</div>
							<div class="control-group pull-left" style="margin-right:5px;">
								<label>Children (ages 5-11)</label>
								<input id="children" type="text" value="0" style="width:125px;" name="data[Ferry_reservation][children]"/>
							</div>
							<div class="control-group pull-left">
								<label>Children (ages 0-5)</label>
								<input id="infants" type="text" value="0" style="width:125px;" name="data[Ferry_reservation][infants]"/>
							</div>							
						<?php
						} else {
						?>
							<div id="driversDiv" class="control-group pull-left" style="margin-right:5px">
								<label>Driver</label>
								<input id="driver" type="text" value="1" style="width:125px" name="data[Ferry_reservation][drivers]"/>
							</div>
							<div id="addtlAdultsDiv" class="control-group pull-left" style="margin-right:5px">
								<label>Extra Adults (ages 12+)</label>
								<input id="extraAdults" type="text" value="1" style="width:125px" name="data[Ferry_reservation][adults]"/>
							</div>
							<div id="adultsDiv" class="control-group pull-left hide" style="margin-right:5px">
								<label>Adults (ages 12+)</label>
								<input id="adults" type="text" value="0" style="width:125px;" name="data[Ferry_reservation][adults]" disabled="disabled"/>
							</div>
							<div class="control-group pull-left" style="margin-right:5px;">
								<label>Children (ages 5-11)</label>
								<input id="children" type="text" value="0" style="width:125px;" name="data[Ferry_reservation][children]"/>
							</div>
							<div class="control-group pull-left">
								<label>Children (ages 0-5)</label>
								<input id="infants" type="text" value="0" style="width:125px;" name="data[Ferry_reservation][infants]"/>
							</div>						
						<?php	
						}
						?>	
							
							
						</div>	
						<div class="clearfix">
							<div id="selectDepartDateDiv" class="control-group twelve columns alpha" style="margin-right:5px;">
								<legend><strong>Select Depart Date<span class="f_req">*</span></strong></legend>
								<div class="input-append">
									<input type="text" id="ferry_start" style="width:100px;" value="<?php echo $package_date;?>" name="data[Ferry_reservation][depart_date]"/>
									<span class="add-on"><i class="small-icon-calendar"></i></span>
								</div>
								<span class="help-block"></span>
							</div>
							<div id="departTableDiv" class="control-group eleven columns alpha">
								<legend><strong>Select Desired Depart Sailing <span class="f_req">*</span></strong></legend>
								<table id="departTable" class="table table-bordered table-condensed">
									<thead>
										<tr style="background-color: #EEE;  border-top: 1px solid #AAA;  text-transform: uppercase;  font-weight: normal;  font-size: 10px;  line-height: 15px;">
											<th>Depart Time</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr class="noTouch">
											<td colspan="2">No date selected</td>
										</tr>
									</tbody>
								</table>
							

								<span class="help-block"></span>
							</div>
							<div id="ferryEndSumDiv" class="control-group twelve columns alpha" style="width:120px;">
								<legend><strong>Return Date<span class="f_req">*</span></strong></legend>
								
								<?php
								//if this is a day trip then make sure that the return day is the same day..
								if($day_trip == 'No'){
									$return_date = date('m/d/Y',strtotime($package_date.' + 1 days'));
									?>
									<input type="hidden" name="data[Ferry_reservation][day_trip]" value="No"/>
									<?php
								} else {
									$return_date = date('m/d/Y',strtotime($package_date));
									?>
									<input type="hidden" name="data[Ferry_reservation][day_trip]" value="Yes"/>
									<?php
								}
								?>
								<div id="ferryEndDiv" class="input-append">
									<input type="text" id="ferry_end" style="width:100px;" value="<?php echo $return_date;?>" name="data[Ferry_reservation][return_date]"/>

									<span class="add-on"><i class="small-icon-calendar"></i></span>
								</div>		
								<span class="help-block"></span>							
							</div>	
							<div id="returnTableDiv" class="control-group eleven columns alpha">
								<legend><strong>Select Desired Return Sailing <span class="f_req">*</span></strong></legend>
								<table id="returnTable" class="table table-bordered table-condensed">
									<thead>
										<tr style="background-color: #EEE;  border-top: 1px solid #AAA;  text-transform: uppercase;  font-weight: normal;  font-size: 10px;  line-height: 15px;">
											<th>Depart Time</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="2">No date selected</td>
										</tr>
									</tbody>
								</table>
								
	
								<span class="help-block"></span>
							</div>					
						</div>		
						<!-- 
						<div class="clearfix">
							<button id="ferryButton" class="btn btn-bbfl" type="button">Select Ferry</button>
						</div>	 
						-->	
					</div>						
				</div>
				<div id="summaryDiv" class="clearfix" summary="<?php echo $summary_type;?>">
					<h3>Package Summary</h3>
			
					<table id="summaryTableLast" class="table table-bordered">
						<thead>
							<tr>
								<th>Item</th>
								<th>Description</th>
								<th>Totals</th>
							</tr>
						</thead>
						<!-- ferry totals-->
						<?php
						switch($summary_type){
							case 'Passenger':
								$package_total = sprintf('%.2f',$package_rt_walkon);
								$package_description ='Base package includes roundtrip ferry walk-on, for 2 adults plus event vouchers';								
							break;
								
							default:
								$package_total = sprintf('%.2f',$package_rt_vehicle);
								$package_description = 'Base package includes roundtrip ferry with vehicle (18 feet or under), 1 night at '.$hotel_name.' for 2 adults';							
							break;
							
						}
						
						?>
						<tbody id="summaryTbody">
							<tr>
								<td><?php echo $package_name;?></td>
								<td><?php echo $package_description;?></td>
								<td>$<?php echo $package_total;?></td>
							</tr>

						<!-- hotel totals-->
						<?php
						if($day_trip == 'No'){
						?>
							<tr>
								<td>Hotel Summary</td>
								<td><?php echo $hotel_name;?>: 1 night, No room selected</td>
								<td><span class="text text-error">[Not Set]</span></td>
							</tr>
						<?php							
						} 
						?>
						</tbody>
						<?php
						if(count($package_add_ons)){
						?>
						<tbody id="addOnDiv">
							<?php
							foreach ($package_add_ons as $p) {
								$package_name = $p['name'];
								$package_desc = $p['description'];
								$package_gross = $p['gross'];
								$package_taxes = $p['taxes'];
								$package_add_on_total = sprintf('%.2f',round($package_gross * (1+$package_taxes),2));

							?>
							<tr>
								<td>Package Includes</td>
								<td><?php echo $package_desc;?></td>
								<td>[Included]</td>
							</tr>
							<?php
							}
							?>
						</tbody>
						<?php
						}
						
						
						?>

						<tfoot>
							<tr >
								<th colspan="2" style="border-top:2px solid #5e5e5e">Package Total</th>
								<td style="border:2px solid #5e5e5e;"><strong>$<?php echo $package_total;?></strong></td>
							</tr>
						</tfoot>
					</table>
					<div>
						<div id="errorDiv" class="alert alert-error hide" >
							<h5><strong>There were errors with your package reservation. Please correct the following issues</strong></h5>
							<br/>
							<ol id="errorUl" style="list-style:decimal;"></ol>	
						</div>
						
						<button id="addToCart" class="btn btn-success" type="button">Add To Cart</button>
											
					</div>
				</div>
			</div>
			<!-- Wide Column::END -->
			<div id="hiddenFormDiv" class="hide">
				<input type="hidden" id="package_id" value="<?php echo $package_id;?>" name="data[Package_reservation][package_id]"/>
				<input type="hidden" id="summary_type" value="<?php echo $summary_type;?>" name="data[Package_reservation][summary_type]"/>
				<input type="hidden" id="package_base" value="<?php echo $package_total;?>" name="data[Package_reservation][base]"/>
				<input type="hidden" id="package_start" value="<?php echo $package_start;?>" />
				<input type="hidden" id="package_end" value="<?php echo $package_end;?>"/>
				<input type="hidden" id="hotel_id" value="<?php echo $hotel_id;?>" name="data[Hotel_reservation][hotel_id]"/>
				<input type="hidden" id="schedule_id1" value="" name="data[Ferry_reservation][schedule_id1]"/>
				<input type="hidden" id="schedule_id2" value="" name="data[Ferry_reservation][schedule_id2]"/>
				<input type="hidden" id="day_trip" value="<?php echo $day_trip;?>" name="data[Package_reservation][day_trip]"/>
			</div>
		</form>		


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