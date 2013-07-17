<?php
?>
<ul class="ageRangeUl unstyled">
	<?php
	$adx= -1;
	foreach ($tour_rates as $key => $value) {
		foreach ($tour_rates[$key] as $at) {
			$blackout = $at['blackout'];
			$blackout_dates = $at['blackout_dates'];
			$tour_name = $at['tour_name'];
			$tour_id = $at['tour_id'];
			$tour_tax_rate = 1+($at['tax_rate']/100);
			
			if($tour_id == $selected_tour_id){
				
				$timed_tour = $at['time_tour'];
				if($timed_tour == '' || empty($timed_tour)){
					$timed_tour = 'No';
					$time = 'No';
				}
				$tour_inventory = $at['tour_inventory'];
	
			
				if($tour_timed_check == 'Yes'){
					$adx++;
					if(!empty($tour_inventory[$time_selected]) && count($tour_inventory[$time_selected])>0 && !is_null($tour_inventory[$time_selected])){
	
							
						foreach ($tour_inventory[$time_selected] as $mkey => $mvalue) {
							
							if(!empty($mvalue['age_range'])){
								$age_range_name = $mvalue['age_range'];
								$age_range_net = $mvalue['net'];
								$age_range_markup = $mvalue['markup'];
								$age_range_gross = sprintf('%.2f',round($mvalue['gross'] * $tour_tax_rate,2));		
								
								if(isset($mvalue['age_range'])){
									?>
									<li class="control-group">
										<div class="input-prepend input-append">
											<span class="add-on">#</span>
											
											<input type="text" class="attraction_age_group attractionEditable" value="0" gross="<?php echo $age_range_gross;?>" style="width:25px;" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][amount]" age_range="<?php echo $age_range_name;?>" edit="Yes"/>
											<span class="add-on"><?php echo $age_range_name;?> @ $<?php echo $age_range_gross;?></span>		
										</div>
										<div class="hiddenAgeRangeDiv">
											<input class="attractionEditable" type="hidden" value="<?php echo $age_range_name;?>" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][name]" edit="Yes"/>
											<input class="attractionEditable" type="hidden" value="<?php echo $age_range_net;?>" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][net]" edit="Yes"/>
											<input class="attractionEditable" type="hidden" value="<?php echo $age_range_markup;?>" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][markup]" edit="Yes"/>
											<input class="attractionEditable" type="hidden" value="<?php echo $age_range_gross;?>" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][gross]" edit="Yes"/>
										</div>
									</li>					
									<?php						
								}
							}
				
		
						}
					}					
				} else {
					
					foreach ($tour_inventory as $mkey => $mvalue) {
						if(!empty($tour_inventory[$mkey]['age_range'])){
						$age_range_name = $tour_inventory[$mkey]['age_range'];
						$age_range_net = $tour_inventory[$mkey]['net'];
						$age_range_markup = $tour_inventory[$mkey]['markup'];
						$age_range_gross = sprintf('%.2f',round($tour_inventory[$mkey]['gross']* $tour_tax_rate,2));	
								
							?>
							<li class="control-group">
								<div class="input-prepend input-append">
									<span class="add-on">#</span>
									
									<input type="text" class="attraction_age_group attractionEditable" value="0" gross="<?php echo $age_range_gross;?>" style="width:25px;" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][amount]" age_range="<?php echo $age_range_name;?>" edit="Yes"/>
									
									
									<span class="add-on"><?php echo $age_range_name;?> @ $<?php echo $age_range_gross;?></span>		
								</div>
								<div class="hiddenAgeRangeDiv">
									<input class="attractionEditable" type="hidden" value="<?php echo $age_range_name;?>" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][name]" edit="Yes"/>
									<input class="attractionEditable" type="hidden" value="<?php echo $age_range_net;?>" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][net]" edit="Yes"/>
									<input class="attractionEditable" type="hidden" value="<?php echo $age_range_markup;?>" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][markup]" edit="Yes"/>
									<input class="attractionEditable" type="hidden" value="<?php echo $age_range_gross;?>" name="data[Attraction_reservation][<?php echo $index;?>][age_range][<?php echo $age_range_name;?>][gross]" edit="Yes"/>									
								</div>

							</li>					
							<?php									
									
						}
	
	
						
					}
				}
	 
	
	
	
			}
		}
	}
	?>
</ul>