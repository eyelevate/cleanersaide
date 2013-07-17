<?php
if($ferry_sidebar){
	$trip = 0;
	//debug($ferry_sidebar);
	foreach ($ferry_sidebar as $key => $value) {
		$trip++;
		$trip_type = $ferry_sidebar[$key]['trip_type'];
		$depart_port = $ferry_sidebar[$key]['depart_port'];
		$depart_date = $ferry_sidebar[$key]['depart_full_date'];
		$depart_time = $ferry_sidebar[$key]['depart_time'];
		$return_port = $ferry_sidebar[$key]['return_port'];
		$return_date = $ferry_sidebar[$key]['return_full_date'];
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
		
		$depart_message = $depart_port.': '.date('M d, Y',strtotime($depart_date)).' @ '.$depart_time;
		switch ($trip_type) {
			case 'roundtrip':					
				$return_message = $return_port.' on '.date('M d, Y',strtotime($return_date)).' @ '.$return_time;						
				break;
			
			default:
				$return_message = '';						
				break;
		}

		
		switch ($inventory_id) {
			case '1':
				$inventory_message = 'Foot Passenger';
				break;
			case '2':
				$inventory_message = 'Vehicle';
				break;
				
			case '3':
				$inventory_message = 'Motorcycle';
				break;					
			default:
				$inventory_message = 'Bicycle';
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
	
		<li class="ferrySidebarLi" style="margin-bottom: 5px;padding-bottom: 5px;border-bottom: 1px solid #AAA;">
			<div style="width: 260px; float: left;">
			<span style="font-weight: bold; display: block;"><? echo ucfirst ($trip_type)." ". $inventory_message; ?> Ferry</span>
			
			<span id="departPortSpan" style="font-size: 10px; display: block; line-height: 15px;"><?php echo $depart_message;?></span>
			<span id="returnPortSpan" style="font-size: 10px; display: block; line-height: 15px;"><?php echo $return_message;?></span>
			<span style="font-size: 10px; display: block; line-height: 15px;"><? if ($vehicle_count){ echo $vehicle_count; ?> vehicles, <? } ?><?php echo ($adults + 1);?> adults, <?php echo ($children + $infants);?> children</span>
			
			<!-- <span style="font-size: 10px; display: block; line-height: 15px;">1 Vehicle, 2 Adults</span>
			<span style="font-size: 10px; display: block; line-height: 15px;">PA: 8:20, 04 Jan 2000</span>
			<span style="font-size: 10px; display: block; line-height: 15px;">VIC: 4:00, 05 Jan 2000</span> -->
			</div>
			
			<button id="removeFerry-<?php echo $key;?>" class="removeFerry btn btn-mini btn-danger pull-right" row="<?php echo $key;?>" type="button"><i class="icon-white icon-remove"></i></button>
			<div style="clear: both;"></div>
		</li>
		<?php				
		}

	} 
	
	 if($hotel_sidebar){

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
	
		
		<li class="hotelSidebarLi" style="margin-bottom: 5px;padding-bottom: 5px;border-bottom: 1px solid #AAA;">
			<div style="width: 260px; float: left;">
			<span style="font-weight: bold; display: block;"><?php echo $hotel_name;?> - <?php echo $room_name;?></span>
			<span style="font-size: 10px; display: block; line-height: 15px;"><? echo $adults; ?> adults, <? echo $children; ?> children</span>
			<span style="font-size: 10px; display: block; line-height: 15px;"><?php echo date('M d, Y',$start);?> - <?php echo date('M d, Y',$end);?></span>
			</div>
			
			<button id="removeHotel-<?php echo $hkey;?>" class="removeHotel btn btn-mini btn-danger pull-right" row="<?php echo $hkey;?>" type="button"><i class="icon-white icon-remove"></i></button>
			<div style="clear: both;"></div>

		</li>
	
		<?php				
		}

	} if($attraction_sidebar){

		foreach ($attraction_sidebar as $ikey => $ivalue) {
			$attraction_name = $attraction_sidebar[$ikey]['attraction_name'];
			$tour_name = $attraction_sidebar[$ikey]['tour_name'];
			if(strtotime($attraction_sidebar[$ikey]['start'])==false){
				$start = $attraction_sidebar[$ikey]['start'];	
			} else {
				$start = strtotime($attraction_sidebar[$ikey]['start']);
			}
				
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
	
		
		<li class="attractionSidebarLi" style="margin-bottom: 5px;padding-bottom: 5px;border-bottom: 1px solid #AAA;">
			<div style="width: 260px; float: left;">
			<span style="font-weight: bold; display: block;"><?php echo $attraction_name;?> - <?php echo $tour_name;?></span>
			<span style="font-size: 10px; display: block; line-height: 15px;"><?php echo date('M d, Y',$start);?></span>
			<ul>
			<?php
			foreach ($purchase_info as $pkey => $pvalue) {
				$age_range_name = $pvalue['name'];
				$age_range_amount = $pvalue['amount'];
				?>
				<li style="font-size: 10px; line-height: 15px;"><?php echo $age_range_amount.' '.$age_range_name;?></li>
				<?php
			}
			?>				
			</ul>

			</div>
			
			<button id="removeAttraction-<?php echo $ikey;?>" class="removeAttraction btn btn-mini btn-danger pull-right" row="<?php echo $ikey;?>" type="button"><i class="icon-white icon-remove"></i></button>
			<div style="clear: both;"></div>

		</li>
	
		<?php				
		}

	} if($package_sidebar){

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
			<li class="packageSidebarLi">
				<p>
					<strong><?php echo $package_name;?></strong> (package)
					<button id="removePackage-<?php echo $pkey;?>" class="removePackage btn btn-mini btn-danger pull-right" row="<?php echo $pkey;?>" type="button"><i class="icon-white icon-remove"></i></button>													
				</p>
				
				<div class="unstyled clearfix">
				<?php
				if(count($ferries)>0){

					foreach ($ferries as $f) {
						
						if(!empty($f['trip_type'])){
							$trip_type = $f['trip_type'];	
						} else {
							$trip_type = 'roundtrip';
						}
						
						$depart_port = $f['depart_port'];
						$depart_date = $f['depart_full_date'];
						$depart_time = $f['depart_time'];
						$return_port = $f['return_port'];
						$return_date = $f['return_full_date'];
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
								$inventory_message = 'Foot Passenger';
								break;
							case '2':
								$inventory_message = 'Vehicle';
								break;
								
							case '3':
								$inventory_message = 'Motorcycle';
								break;					
							default:
								$inventory_message = 'Bicycle';
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

		
						<div style="border-bottom: 1px dashed #e5e5e5">
							<div style="width: 260px; float: left;">
							<span style="font-weight: bold; display: block;"><? echo ucfirst ($trip_type)." ". $inventory_message; ?> Ferry</span>
							
							<span id="departPortSpan" style="font-size: 10px; display: block; line-height: 15px;"><?php echo $depart_message;?></span>
							<span id="returnPortSpan" style="font-size: 10px; display: block; line-height: 15px;"><?php echo $return_message;?></span>
							<span style="font-size: 10px; display: block; line-height: 15px;"><? if ($vehicle_count){ echo $vehicle_count; ?> vehicles, <? } ?><?php echo ($adults + 1);?> adults, <?php echo ($children + $infants);?> children</span>
							
							<!-- <span style="font-size: 10px; display: block; line-height: 15px;">1 Vehicle, 2 Adults</span>
							<span style="font-size: 10px; display: block; line-height: 15px;">PA: 8:20, 04 Jan 2000</span>
							<span style="font-size: 10px; display: block; line-height: 15px;">VIC: 4:00, 05 Jan 2000</span> -->
							</div>
							<div style="clear: both;"></div>
						</div>
						<?php	

					}
				}
				if(count($hotels)>0){

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
					
						
						<div style="margin-bottom: 5px;padding-bottom: 5px;border-bottom: 1px dashed #e5e5e5">
							<div style="width: 260px; float: left;">
							<span style="font-weight: bold; display: block;"><?php echo $hotel_name;?> - <?php echo $room_name;?></span>
							<span style="font-size: 10px; display: block; line-height: 15px;"><? echo $adults; ?> adults, <? echo $children; ?> children</span>
							<span style="font-size: 10px; display: block; line-height: 15px;"><?php echo date('M d, Y',$start);?> - <?php echo date('M d, Y',$end);?></span>
							</div>
							<div style="clear: both;"></div>
						</div>
					
						<?php			
					}					
				
				
				}
				if(count($attractions)>0){

					foreach ($attractions as $a) {
						$attraction_name = $a['attraction_name'];
						$tour_name = $a['tour_name'];
						if(strtotime($a['start']) == false){
							$start = $a['start'];	
						} else {
							$start = strtotime($a['start']);
						}

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
					
						
						<div style="margin-bottom: 5px;padding-bottom: 5px;border-bottom: 1px solid #AAA;">
							<div style="width: 260px; float: left;">
							<span style="font-weight: bold; display: block;"><?php echo $attraction_name;?> - <?php echo $tour_name;?></span>
							<span style="font-size: 10px; display: block; line-height: 15px;"><?php echo date('M d, Y',$start);?></span>
							</div>
							<div style="clear: both;"></div>

						</div>
					
						<?php	
					}	
				}											
				?>
				</div>
			</li>
			<?php
		}

		
	}
	?>				