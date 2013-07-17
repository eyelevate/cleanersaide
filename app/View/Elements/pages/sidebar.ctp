

<div class="four columns omega sidebar">
		
	<!-- Accordions -->
	<h2 class="title"><span>Current Reservation</span></h2>
	<div class="acc_holder" style="">
		<?php
		if($Ferries == 'YES'){
			if($current_page=='ferry'){
				$current_class = 'accordion active_acc';
				$current_display = 'style="display:block"';
			} else {						
				$current_class = 'accordion';
				$current_display = '';			
			}
			$trip = 0;
			foreach ($ferry_sidebar as $key => $value) {
				$trip++;
				$trip_type = $ferry_sidebar[$key]['trip_type'];
				$depart_port = $ferry_sidebar[$key]['depart_port'];
				$depart_date = $ferry_sidebar[$key]['depart_date'];
				$depart_time = $ferry_sidebar[$key]['depart_time'];
				$return_port = $ferry_sidebar[$key]['return_port'];
				$return_date = $ferry_sidebar[$key]['return_date'];
				$return_time = $ferry_sidebar[$key]['return_time'];
				$adults = $ferry_sidebar[$key]['adults'];
				$children = $ferry_sidebar[$key]['children'];
				$infants = $ferry_sidebar[$key]['infants'];
				$inventory_id = $ferry_sidebar[$key]['inventory_id'];
				$reservable = $ferry_sidebar[$key]['reservable'];
				$online_oneway = $ferry_sidebar[$key]['online_oneway'];
				$online_roundtrip = $ferry_sidebar[$key]['online_roundtrip'];
				$overlength_rate = $ferry_sidebar[$key]['overlength_rate'];
				$schedule_id1 = $ferry_sidebar[$key]['schedule_id1'];
				$schedule_id2 = $ferry_sidebar[$key]['schedule_id2'];
				$vehicle_count = $ferry_sidebar[$key]['vehicle_count'];
				$vehicles = $ferry_sidebar[$key]['vehicles'];
				
				$depart_message = '<strong>[Depart]</strong> '. $depart_port.' on '.date('M d, Y',strtotime($depart_date)).' @ '.$depart_time;
				switch ($trip_type) {
					case 'roundtrip':					
						$return_message = '<strong>[Return]</strong> '. $return_port.' on '.date('M d, Y',strtotime($return_date)).' @ '.$return_time;						
						break;
					
					default:
						$return_message = '';						
						break;
				}

				
				switch ($inventory_id) {
					case '1':
						$inventory_message = '<strong>[Reservation Type]</strong> Foot Passenger';
						break;
					case '2':
						$inventory_message = '<strong>[Reservation Type]</strong> Vehicle';
						break;
						
					case '3':
						$inventory_message = '<strong>[Reservation Type]</strong> Motorcycle';
						break;					
					default:
						$inventory_message = '<strong>[Reservation Type]</strong> Bicycle';
						break;
				}
				switch ($inventory_id) {
					case '2':
						if($adults > 0){
							$adult_message = '- '.$adults.' Additional Adult(s) (ages 12+)';
						} else {
							$adult_message = '';
						}
						if($children > 0){
							$child_message = '- '.$children.' Child(ren) (ages 5-11)';
						} else {
							$child_message = '';
						}
						if($infants > 0){
							$infant_message = '- '.$infants.' Child(ren) (ages 0-4)';
						} else {
							$infant_message = '';
						}						
						break;
					
					default:
						if($adults > 0){
							$adult_message = '- '.$adults.' Adult(s) (ages 12+)';
						} else {
							$adult_message = '';
						}
						if($children > 0){
							$child_message ='- '. $children.' Child(ren) (ages 5-11)';
						} else {
							$child_message = '';
						}
						if($infants > 0){
							$infant_message = '- '.$infants.' Child(ren) (ages 0-4)';
						} else {
							$infant_message = '';
						}						
						break;
				}

				?>
				<div class="acc_item ferry">
					<h4 class="<?php echo $current_class;?>"><span class="acc_control"></span><span class="acc_heading">Ferry Trip <?php echo $trip;?> (<span id="innerTripType"><?php echo $trip_type;?></span>)</span></h4>
					<div class="accordion_content" <?php echo $current_display;?>>
						<ul id="ferrySideBarUl">
							<li><span id="departPortSpan"><?php echo $depart_message;?></span><span id="departTimeSpan"></span></li>
							<li><span id="returnPortSpan"><?php echo $return_message;?></span><span id="returnTimeSpan"></span></li>
							<li><span><?php echo $inventory_message;?></span></li>
							<?php
							if(!empty($vehicles)){
								//count types
								$count22 = 0;	//standard vehicle							
								$count23 = 0;  //overlength vehicle
								$count24 = 0;	//motorcycles
								$count25 = 0;	//motorcycle sidecar
								$count26 = 0;	//tricycle
								$count27 = 0;	//tricycle with trailer
								$count28 = 0; 	//bicycles
								foreach ($vehicles as $vkey => $vvalue) {
									if($vehicles[$vkey]['item_id']==='22'){
										$count22++;
										$count22_name = $vehicles[$vkey]['name'].' + Driver';
									}
									if($vehicles[$vkey]['item_id']==='23'){
										$towed_unit = $vehicles[$vkey]['towed_unit'];
										$count23++;
										$count23_name = $vehicles[$vkey]['name'].' '.$towed_unit.' + Driver';
									}
									if($vehicles[$vkey]['item_id']==='24'){
										$count24++;
										$count24_name = $vehicles[$vkey]['name'];
									}
									if($vehicles[$vkey]['item_id']==='25'){
										$count25++;
										$count25_name = $vehicles[$vkey]['name'];
									}
									if($vehicles[$vkey]['item_id']==='26'){
										$count26++;
										$count26_name = $vehicles[$vkey]['name'];
									}
									if($vehicles[$vkey]['item_id']==='27'){
										$count27++;
										$count27_name = $vehicles[$vkey]['name'];
									}
									if($vehicles[$vkey]['item_id']==='28'){
										$count28++;
										$count28_name = 'Bicycle(s)';
									}
								}
								if($count22 > 0){
								?>
								<li><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count22.' '.$count22_name;?></span></li>
								<?php									
								}
								if($count23 > 0){
								?>
								<li><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count23.' '.$count23_name;?></span></li>
								<?php									
								}
								if($count24 > 0){
								?>
								<li><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count24.' '.$count24_name;?></span></li>
								<?php									
								}
								if($count25 > 0){
								?>
								<li><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count25.' '.$count25_name;?></span></li>
								<?php									
								}
								if($count26 > 0){
								?>
								<li><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count26.' '.$count26_name;?></span></li>
								<?php									
								}
								if($count27 > 0){
								?>
								<li><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count27.' '.$count27_name;?></span></li>
								<?php									
								}
								
							}
							
							?>							
							
							<li><span id="adultSpan"><?php echo $adult_message;?></span></li>
							<li><span id="childrenSpan"><?php echo $child_message;?></span></li>
							<li><span id="infantSpan"><?php echo $infant_message;?></span></li>
 							<li><button id="removeSidebar-<?php echo $key;?>" class="removeSidebar btn btn-bbfl btn-small btn-block" row="<?php echo $key;?>" type="button">Remove Trip</button></li>
						</ul>
					</div>
				</div>
				<?php				
			}

		} if($Hotels == 'YES'){
			
			foreach ($hotel_sidebar as $hkey => $hvalue) {
				$hotel_name = $hotel_sidebar[$hkey]['hotel_name'];
				$room_name = $hotel_sidebar[$hkey]['room_name'];
				$start = $hotel_sidebar[$hkey]['start'];
				$end = $hotel_sidebar[$hkey]['end'];
				$days = ($end - $start) / 86400;
				$nights = $days;

				$adults = $hotel_sidebar[$hkey]['adults'];
				$children= $hotel_sidebar[$hkey]['children'];
			?>
			<div class="acc_item hotel">
				<h4 class="accordion"><span class="acc_control"></span><span class="acc_heading"><?php echo $hotel_name;?> <br/>(<?php echo $nights;?> nights)</span></h4>
				<div class="accordion_content" style="margin-top:10px;padding-top:0px;">
					<legend style="margin-top:0px;"><?php echo $room_name;?></legend>
					<table style="width:100%">
						<tbody>
							<tr>
								<th><strong>Adults:</strong></th>
								<td><?php echo $adults;?></td>
							</tr>
							<tr>
								<th><strong>Children:</strong></th>
								<td><?php echo $children;?></td>
							</tr>
							<tr>
								<th><strong>Check In:</strong></th>
								<td><?php echo date('M d, Y',$start);?></td>
							</tr>
							<tr>
								<th><strong>Check Out:</strong></th>
								<td><?php echo date('M d, Y',$end);?></td>
							</tr>
						</tbody>
					</table>
					<button id="removeHotel-<?php echo $hkey;?>" class="removeHotel btn btn-bbfl btn-small btn-block" row="<?php echo $hkey;?>" type="button">Remove Hotel</button>
				</div>
			</div>
			<?php				
			}

		} if($Attractions == 'YES'){
			foreach ($attraction_sidebar as $ikey => $ivalue) {
				$attraction_name = $attraction_sidebar[$ikey]['attraction_name'];
				$tour_name = $attraction_sidebar[$ikey]['tour_name'];
				$start = $attraction_sidebar[$ikey]['start'];	
				$time = $attraction_sidebar[$ikey]['time'];	
				$time_tour = $attraction_sidebar[$ikey]['time_tour'];
				switch ($time_tour) {
					case 'Yes':
						$tour_name = $attraction_name.' @ '.$time;
						break;
					
					default:
						$tour_name = $attraction_name;
						break;
				}
				$purchase_info = $attraction_sidebar[$ikey]['purchase_info'];
				?>
				<div class="acc_item attraction">
					<h4 class="accordion"><span class="acc_control"></span><span class="acc_heading"><?php echo $attraction_name;?></span></h4>
					<div class="accordion_content">
						<legend style="margin-top:0px;"><?php echo $tour_name;?></legend>
						<table style="width:100%">
							<tbody>
							<?php
							foreach ($purchase_info as $pi) {
								$name = $pi['name'];
								$amount = $pi['amount'];
								$net = $pi['net'];
								$markup = $pi['markup'];
								$gross = $pi['gross'];
								?>
								<tr>
									<th><strong><?php echo $name;?></strong></th>
									<td><?php echo $amount;?></td>
								</tr>
								<?php	
							}
							?>							
							</tbody>
						</table>
					<button id="removeAttraction-<?php echo $ikey;?>" class="removeAttraction btn btn-bbfl btn-small btn-block" row="<?php echo $ikey;?>" type="button">Remove Attraction</button>
					</div>
				</div>
				<?php
			}
		}
		if($Packages == 'YES'){
			foreach ($package_sidebar as $pkey => $pvalue) {
				$packages = $package_sidebar[$pkey]['packages'];
				$ferries = $package_sidebar[$pkey]['ferries'];
				$hotels = $package_sidebar[$pkey]['hotels'];
				$attractions = $package_sidebar[$pkey]['attractions'];
				
				foreach ($packages as $pk) {
					$package_id = $pk['id'];
					$package_name = $pk['name'];

				}
				?>
				<div class="acc_item attraction">
					<h4 class="accordion"><span class="acc_control"></span><span class="acc_heading"><?php echo $package_name;?></span></h4>
					<div class="accordion_content">
					<?php
					if(count($ferries)>0){
					?>
					<legend style="margin-top:0px;"><strong>FERRY</strong></legend>
					<?php
					foreach ($ferries as $f) {
						$trip++;
						$trip_type = $f['trip_type'];
						$depart_port = $f['depart_port'];
						$depart_date = $f['depart_date'];
						$depart_time = $f['depart_time'];
						$return_port = $f['return_port'];
						$return_date = $f['return_date'];
						$return_time = $f['return_time'];
						$adults = $f['adults'];
						$children = $f['children'];
						$infants = $f['infants'];
						$inventory_id = $f['inventory_id'];
						$reservable = $f['reservable'];
						$online_oneway = $f['online_oneway'];
						$online_roundtrip = $f['online_roundtrip'];
						$overlength_rate = $f['overlength_rate'];
						$schedule_id1 = $f['schedule_id1'];
						$schedule_id2 = $f['schedule_id2'];
						$vehicle_count = $f['vehicle_count'];
						$vehicles = $f['vehicles'];
						
						$depart_message = '<strong>[Depart]</strong> '. $depart_port.' on '.date('M d, Y',strtotime($depart_date)).' @ '.$depart_time;
						switch ($trip_type) {
							case 'roundtrip':					
								$return_message = '<strong>[Return]</strong> '. $return_port.' on '.date('M d, Y',strtotime($return_date)).' @ '.$return_time;						
								break;
							
							default:
								$return_message = '';						
								break;
						}
		
						
						switch ($inventory_id) {
							case '1':
								$inventory_message = '<strong>[Reservation Type]</strong> Foot Passenger';
								break;
							case '2':
								$inventory_message = '<strong>[Reservation Type]</strong> Vehicle';
								break;
								
							case '3':
								$inventory_message = '<strong>[Reservation Type]</strong> Motorcycle';
								break;					
							default:
								$inventory_message = '<strong>[Reservation Type]</strong> Bicycle';
								break;
						}
						switch ($inventory_id) {
							case '2':
								if($adults > 0){
									$adult_message = '- '.$adults.' Additional Adult(s) (ages 12+)';
								} else {
									$adult_message = '';
								}
								if($children > 0){
									$child_message = '- '.$children.' Child(ren) (ages 5-11)';
								} else {
									$child_message = '';
								}
								if($infants > 0){
									$infant_message = '- '.$infants.' Child(ren) (ages 0-4)';
								} else {
									$infant_message = '';
								}						
								break;
							
							default:
								if($adults > 0){
									$adult_message = '- '.$adults.' Adult(s) (ages 12+)';
								} else {
									$adult_message = '';
								}
								if($children > 0){
									$child_message ='- '. $children.' Child(ren) (ages 5-11)';
								} else {
									$child_message = '';
								}
								if($infants > 0){
									$infant_message = '- '.$infants.' Child(ren) (ages 0-4)';
								} else {
									$infant_message = '';
								}						
								break;
						}
		
						?>
							<ul id="ferrySideBarUl">
								<li style="font-size:90%; margin-bottom:5px;"><span id="departPortSpan"><?php echo $depart_message;?></span><span id="departTimeSpan"></span></li>
								<li style="font-size:90%; margin-bottom:5px;"><span id="returnPortSpan"><?php echo $return_message;?></span><span id="returnTimeSpan"></span></li>
								<li style="font-size:90%; margin-bottom:5px"><span><?php echo $inventory_message;?></span></li>
								<?php
								if(!empty($vehicles)){
									//count types
									$count22 = 0;	//standard vehicle							
									$count23 = 0;  //overlength vehicle
									$count24 = 0;	//motorcycles
									$count25 = 0;	//motorcycle sidecar
									$count26 = 0;	//tricycle
									$count27 = 0;	//tricycle with trailer
									$count28 = 0; 	//bicycles
									foreach ($vehicles as $vkey => $vvalue) {
										if($vehicles[$vkey]['item_id']==='22'){
											$count22++;
											$count22_name = $vehicles[$vkey]['name'].' + Driver';
										}
										if($vehicles[$vkey]['item_id']==='23'){
											$towed_unit = $vehicles[$vkey]['towed_unit'];
											$count23++;
											$count23_name = $vehicles[$vkey]['name'].' '.$towed_unit.' + Driver';
										}
										if($vehicles[$vkey]['item_id']==='24'){
											$count24++;
											$count24_name = $vehicles[$vkey]['name'];
										}
										if($vehicles[$vkey]['item_id']==='25'){
											$count25++;
											$count25_name = $vehicles[$vkey]['name'];
										}
										if($vehicles[$vkey]['item_id']==='26'){
											$count26++;
											$count26_name = $vehicles[$vkey]['name'];
										}
										if($vehicles[$vkey]['item_id']==='27'){
											$count27++;
											$count27_name = $vehicles[$vkey]['name'];
										}
										if($vehicles[$vkey]['item_id']==='28'){
											$count28++;
											$count28_name = 'Bicycle(s)';
										}
									}
									if($count22 > 0){
									?>
									<li style="font-size:90%; line-height:90%;"><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count22.' '.$count22_name;?></span></li>
									<?php									
									}
									if($count23 > 0){
									?>
									<li style="font-size:90%; line-height:90%;"><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count23.' '.$count23_name;?></span></li>
									<?php									
									}
									if($count24 > 0){
									?>
									<li style="font-size:90%; line-height:90%;"><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count24.' '.$count24_name;?></span></li>
									<?php									
									}
									if($count25 > 0){
									?>
									<li style="font-size:90%; line-height:90%;"><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count25.' '.$count25_name;?></span></li>
									<?php									
									}
									if($count26 > 0){
									?>
									<li style="font-size:90%; line-height:90%;"><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count26.' '.$count26_name;?></span></li>
									<?php									
									}
									if($count27 > 0){
									?>
									<li style="font-size:90%; line-height:90%;"><span id="vehicleAmount"></span> <span id="vehicleType"><?php echo '- '.$count27.' '.$count27_name;?></span></li>
									<?php									
									}
									
								}
								
								?>							
								
								<li style="font-size:90%"><span id="adultSpan"><?php echo $adult_message;?></span></li>
								<li style="font-size:90%"><span id="childrenSpan"><?php echo $child_message;?></span></li>
								<li style="font-size:90%"><span id="infantSpan"><?php echo $infant_message;?></span></li>

							</ul>

						<?php				
					}}
					if(count($hotels)>0){
					?>

						<legend><strong>HOTELS</strong></legend>
					<?php
						foreach ($hotels as $h) {
							$hotel_name = $h['hotel_name'];
							$room_name = $h['room_name'];
							$start = $h['start'];
							$end = $h['end'];
							$days = ($end - $start) / 86400;
							$nights = $days;
			
							$adults = $h['adults'];
							$children= $h['children'];
						?>

						<p style="font-size:90%; line-height:90%; margin-bottom:5px;"><?php echo $hotel_name;?>: <em style="margin-top:0px;"><?php echo $room_name;?></em></p>
						<table style="width:100%">
							<tbody>
								<tr>
									<th style="font-size:90%; line-height:90%;"><strong>Adults:</strong></th>
									<td style="font-size:90%; line-height:90%;"><?php echo $adults;?></td>
								</tr>
								<tr>
									<th style="font-size:90%; line-height:90%;"><strong>Children:</strong></th>
									<td style="font-size:90%; line-height:90%;" ><?php echo $children;?></td>
								</tr>
								<tr>
									<th style="font-size:90%; line-height:90%;"><strong>Check In:</strong></th>
									<td style="font-size:90%; line-height:90%;"><?php echo date('M d, Y',$start);?></td>
								</tr>
								<tr>
									<th style="font-size:90%; line-height:90%;"><strong>Check Out:</strong></th>
									<td style="font-size:90%; line-height:90%;"><?php echo date('M d, Y',$end);?></td>
								</tr>
							</tbody>
						</table>

						<?php				
						}					
					
					
					}
					if(count($attractions)>0){
					?>
						<br/>
						<legend><strong>ATTRACTION</strong></legend>
					<?php
						foreach ($attractions as $a) {
							$attraction_name = $a['attraction_name'];
							$tour_name = $a['tour_name'];
							$start = $a['start'];	
							$time = $a['time'];	
							$time_tour = $a['time_tour'];
							switch ($time_tour) {
								case 'Yes':
									$tour_name = $attraction_name.' @ '.$time;
									break;
								
								default:
									$tour_name = $attraction_name;
									break;
							}
							$purchase_info = $a['purchase_info'];
							?>

							<legend style="font-size:90%; line-height:90%; margin-bottom:5px;"><?php echo $attraction_name.': '.$tour_name;?></legend>
							<table style="width:100%">
								<tbody>
									<tr>
										<th style="font-size:90%; line-height:90%;"><strong>Date</strong></th>
										<td style="font-size:90%; line-height:90%;"><?php echo date('M d,Y',$start);?></td>
									</tr>
									<?php
									if($time_tour == 'Yes'){
									?>
									<tr>
										<th style="font-size:90%; line-height:90%;"><strong>Time</strong></th>
										<td style="font-size:90%; line-height:90%;"><?php echo $time;?></td>
									</tr>
									<?php
									}
									foreach ($purchase_info as $pi) {
										$name = $pi['name'];
										$amount = $pi['amount'];
										$net = $pi['net'];
										$markup = $pi['markup'];
										$gross = $pi['gross'];
										?>
										<tr>
											<th style="font-size:90%; line-height:90%;"><strong><?php echo $name;?></strong></th>
											<td style="font-size:90%; line-height:90%;"><?php echo $amount;?></td>
										</tr>
										<?php	
									}
								?>							
								</tbody>
							</table>

							<?php
						}
					}
					?>
					<br/>
					<button id="removePackage-<?php echo $pkey;?>" class="removePackage btn btn-bbfl btn-small btn-block" row="<?php echo $pkey;?>" type="button">Remove Package</button>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
	
	<!-- <a id="clearcart" class="btn btn-small">CLEAR CART</a>  -->
	<?php
	//debug(count($ferry_sidebar).' '.count($hotel_sidebar).' '.count($attraction_sidebar).' '.count($package_sidebar));
	if(count($ferry_sidebar) > 0 || count($hotel_sidebar) > 0 || count($attraction_sidebar)>0 || count($package_sidebar)>0){
		?>
		<a id="checkout" href="/reservations/travelers" class="btn btn-success btn-block" style="float:right;">CHECKOUT</a>	
		<?php
	} else {
		?>
		<input class="btn btn-block" disabled="disabled" value="CHECKOUT"/>
		<?php
	}
	?>
	
	<!-- Accordions::END -->				




			
</div>
<!-- Side Column::END -->