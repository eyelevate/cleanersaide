<?php
	//short variables
	foreach ($inventory_item_name as $iin) {
		$ii_name = $iin['Inventory_item']['name'];
	}
	switch ($trip_type) {
		case 'roundtrip':
			foreach ($adult_rate_depart as $ard) {
				$ar_depart = $ard['total'];
			}
			foreach ($child_rate_depart as $crd) {
				$cr_depart = $crd['total'];
			}
			foreach ($adult_rate_return as $arr) {
				$ar_return = $arr['total'];
			}
			foreach ($child_rate_return as $crr) {
				$cr_return = $crr['total'];
			}
			foreach ($driver_rate_depart as $drd) {
				$dr_depart = $drd['total'];
			}
			foreach ($driver_rate_return as $drr) {
				$dr_return = $drr['total'];
			}
			if(!empty($vehicle_rate_depart)){		
				foreach ($vehicle_rate_depart as $vrd) {
					$vr_depart = $vrd['total'];
				}
			} else {
				$vr_depart = '0.00';
			}
			if(!empty($vehicle_rate_return)){
				foreach ($vehicle_rate_return as $vrr) {
					$vr_return = $vrr['total'];
				}
			} else {
				$vr_return = '0.00';
			}
		
			$adult_rate = sprintf('%.2f',round(($ar_depart+$ar_return)*$adults,2));
			$child_rate = sprintf('%.2f',round(($cr_depart+$cr_return)*$children,2));
			$vehicle_rate = sprintf('%.2f',round(($vr_depart+$vr_return)*$vehicle_count,2));
			
			
			
			
			switch ($inventory_id) {
				case '1': //passengers
					$subtotal = sprintf('%.2f',$adult_rate+$child_rate);
					?>

					<tbody>
						<tr>
							<td><?php echo $adults;?> Adult(s) (ages 12+)</td>
							<td>$<span id="adult_rate"><?php echo $adult_rate;?></span></td>
						</tr>
						<?php
						if($children != '0'):
						?>
						<tr>
							<td><?php echo $children;?> Child(ren) (ages 5-11)</td>
							<td>$<span id="child_rate"><?php echo $child_rate;?></span></td>
						</tr>
						<?php
						endif;
						if($infants != '0'):
						?>
						<tr>
							<td><?php echo $infants;?> Child(ren) (ages 0-4)</td>
							<td >Free</td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
					<tfoot>
						<tr>
							<td><strong>Subtotal:</strong></td>
							<td>$<span id="subtotal"><?php echo $subtotal;?></span></td>
						</tr>
						<tr>
							<td><strong>TOTAL (due at checkout):</strong></td>
							<td>$<span id="dueAtCheckout"><?php echo $subtotal;?></span></td>
						</tr>
					</tfoot>
					<?php
					break;
				case '2': //vehicles
					
					$addtl_adult_rate = sprintf('%.2f',round(($ar_depart+$ar_return)*$adults,2));
					$addtl_child_rate = sprintf('%.2f',round(($cr_depart+$cr_return)*$children,2));
					$addtl_driver_rate= sprintf('%.2f',round(($drivers *($dr_depart+$dr_return)),2));
					$vehicle_rate = 0;

					if(!empty($ovrd)){		
						foreach ($ovrd as $ovd) {
							foreach ($ovd as $key => $value) {
								$vr_depart_id = $ovd[$key]['id'];
							
								$vr_depart = $ovd[$key]['total'];
								$vehicle_rate = $vehicle_rate + $vr_depart;
	
			
							}

						}
					} 
					
					if(!empty($ovrr)){
						foreach ($ovrr as $ovr) {
							foreach ($ovr as $key => $value) {
								$vr_return_id = $ovr[$key]['id'];
								$vr_return = $ovr[$key]['total'];
								$vehicle_rate = $vehicle_rate + $vr_return;		
						
							}

						}
					}

					$subtotal = sprintf('%.2f',$vehicle_rate+$addtl_driver_rate+$addtl_adult_rate+$addtl_child_rate);
					$total = sprintf('%.2f',$subtotal+$online_roundtrip);					
					?>
					<tbody>
						<?php
						$vehicle_rate1 = 0;
						$vehicle_rate2 = 0;		
						$ovrd_overlength = 0;				
						$count_total = count($ovrd);
						foreach ($ovrd as $key => $value) {
							$vehicle_count = count($value);	

							
							foreach ($ovrd[$key] as $akey => $avalue) {
								$id = $ovrd[$key][$akey]['id'];
								$ovrd_total = $ovrd[$key][$akey]['total'];
								$ovrd_overlength =$ovrd_overlength +  $ovrd[$key][$akey]['overlength'];
								$ovrd_overlength_rate = $ovrd[$key][$akey]['overlength_rate'];
								$ovrd_oneway = $ovrd[$key][$akey]['oneway'];
								if($id == '22'){
									$vehicle_rate1 = $vehicle_rate1 + $ovrd_total;
									
								} else {
									$vehicle_rate2 = $vehicle_rate2 + $ovrd_oneway;
									
								}
							}
							$ovrd_driver_rate= sprintf('%.2f',round(($vehicle_count *($dr_depart+$dr_return)),2));
							$ovrd_overlength_oneway = sprintf('%.2f',round(($ovrd_overlength_rate * $ovrd_overlength),2));
							$ovrd_overlength_roundtrip = sprintf('%.2f',round(($ovrd_overlength_rate * $ovrd_overlength)*2,2));							
							$overlength_details = 'Overlength charge: '.$ovrd_overlength.' total extra feet @ $'.$ovrd_overlength_rate.' per foot equals $'.$ovrd_overlength_oneway.' x 2 for roundtrip';
							$ovrd_total_vehicle = sprintf('%.2f',round(($vehicle_count * $ovrd_oneway)*2,2));
							if($key != 'Vehicle or Vehicle with Towed Unit (over 18 feet)'){
							?>
							<tr>
								<td><?php echo $vehicle_count.' '.$key.' @ ($'.$ovrd_total_vehicle.' roundtrip) + '.$vehicle_count.' Driver(s) @ ($'.$ovrd_driver_rate.' roundtrip)';?></td>
								<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',(round($vehicle_rate1*2,2)+$ovrd_driver_rate));?></span></td>								
							</tr>	
							<?php	
							} else {
							?>
							<tr>
								<td><?php echo $vehicle_count.' '.$key.' @ ($'.$ovrd_total_vehicle.' roundtrip) + '.$vehicle_count.' Driver(s) @ ($'.$ovrd_driver_rate.' roundtrip)';?></td>
								<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',(round($vehicle_rate2*2,2)+$ovrd_driver_rate));?></span></td>
							</tr>		
							<tr>
								<td>+ <?php echo $overlength_details;?> </td>
								<td>$<span id="overlength_fee"><?php echo $ovrd_overlength_roundtrip;?></span></td>
							</tr>
							<?php								
							}				
						}

						if($adults != '0'){
						?>
						<tr>
							<td><?php echo $adults;?> Additional adult passengers (ages 12+)</td>
							<td>$<span id="adult_rate"><?php echo $addtl_adult_rate;?></span></td>
						</tr>
						<?php
						}
						if($children != '0'):
						?>
						<tr>
							<td><?php echo $children;?> Child passengers (ages 5-11)</td>
							<td>$<span id="child_rate"><?php echo $child_rate;?></span></td>
						</tr>
						<?php
						endif;
						if($infants != '0'):
						?>
						<tr>
							<td><?php echo $infants;?> Child passengers (ages 0-4)</td>
							<td>Free</td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
					<tfoot>
					<?php
					
					?>
						<tr>
							<td><strong>Subtotal:</strong></td>
							<td>$<span id="subtotal"><?php echo $subtotal;?></span></td>
						</tr>
						<tr>
							<td><strong>Online Reservation Fee:</strong></td>
							<td>$<span id="online_fee"><?php echo $online_roundtrip;?></span></td>
						</tr>
						<tr>
							<td><strong>TOTAL:</strong></td>
							<td>$<span id="total"><?php echo $total;?></span></td>
						</tr>
						<tr>
							<td><strong>Due at checkout:</strong></td>
							<td>$<span id="dueAtCheckout"><?php echo $online_roundtrip;?></span></td>
						</tr>
						<tr>
							<td><strong>Estimated due at time of travel:</strong></td>
							<td>$<span id="dueAtArrival"><?php echo $subtotal;?></span></td>
						</tr>
					</tfoot>
					<?php					
					break;
					
				case '3': //motorcycles
					$vehicle_rate = 0;
					if(!empty($mrd)){		
						foreach ($mrd as $md) {
							foreach ($md as $key => $value) {
								$vr_depart_id = $md[$key]['id'];
								$vr_depart = $md[$key]['total'];
								$vehicle_rate = $vehicle_rate + $vr_depart;
							}

						}
					} 
					if(!empty($mrr)){
						foreach ($mrr as $mr) {
							foreach ($mr as $key => $value) {
								$vr_return_id = $mr[$key]['id'];
								$vr_return = $mr[$key]['total'];
								$vehicle_rate = $vehicle_rate + $vr_return;		
						
							}

						}
					}			
					
					$subtotal = sprintf('%.2f',$vehicle_rate+$adult_rate+$child_rate);
					$total = sprintf('%.2f',$subtotal + $online_roundtrip);
					?>
					<tbody>
						<?php
						$motorcycle_rate1 = 0;
						$motorcycle_rate2 = 0;	
						$motorcycle_rate3 = 0;
						$motorcycle_rate4 = 0;					
						$count_total = count($mrd);
						
						foreach ($mrd as $key =>$value) {
							$vehicle_count = count($value);
							foreach ($mrd[$key] as $akey => $avalue) {
								$id = $mrd[$key][$akey]['id'];
								$mrd_total = $mrd[$key][$akey]['total'];
								switch ($id) {
									case '24':
										$motorcycle_rate1 = $motorcycle_rate1 + $mrd_total;
										break;
									case '25':
										$motorcycle_rate2 = $motorcycle_rate2 + $mrd_total;
										break;
									case '26':
										$motorcycle_rate3 = $motorcycle_rate3 + $mrd_total;
										break;
									case '27':
										$motorcycle_rate4 = $motorcycle_rate4 + $mrd_total;
										break;
	
								}
							}

							?>
							<tr>
								<td><?php echo $vehicle_count.' '.$key;?></td>
								<?php
								switch ($key) {
									case 'Motorcycle':
										?>
										<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',round($motorcycle_rate1*2,2));?></span></td>
										<?php										
										break;
									case 'Motorcycle w/Sidecar and/or Trailer':
										?>
										<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',round($motorcycle_rate2*2,2));?></span></td>
										<?php
										break;
									case 'Motorized Tricycle':
										?>
										<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',round($motorcycle_rate3*2,2));?></span></td>
										<?php									
										break;
									default:
										?>
										<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',round($motorcycle_rate4*2,2));?></span></td>
										<?php										
										break;
								}
								?>
								
							</tr>		
							<?php					
						}
						?>
						<tr>
							<td><?php echo $adults;?> Adult(s) (ages 12+)</td>
							<td>$<span id="adult_rate"><?php echo $adult_rate;?></span></td>
						</tr>
						<?php
						if($children != '0'):
						?>
						<tr>
							<td><?php echo $children;?> Child(ren) (ages 5-11)</td>
							<td>$<span id="child_rate"><?php echo $child_rate;?></span></td>
						</tr>
						<?php
						endif;
						if($infants != '0'):
						?>
						<tr>
							<td><?php echo $infants;?> Child(ren) (ages 0-4)</td>
							<td >Free</td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
					<tfoot>
						<tr>
							<td><strong>Subtotal:</strong></td>
							<td>$<span id="subtotal"><?php echo $subtotal;?></span></td>
						</tr>
						<tr>
							<td><strong>Online Reservation Fee:</strong></td>
							<td>$<span id="online_fee"><?php echo $online_roundtrip;?></span></td>
						</tr>
						<tr>
							<td><strong>TOTAL:</strong></td>
							<td>$<span id="total"><?php echo $total;?></span></td>
						</tr>
						<tr>
							<td><strong>Due at checkout:</strong></td>
							<td>$<span id="dueAtCheckout"><?php echo $online_roundtrip;?></span></td>
						</tr>
						<tr>
							<td><strong>Estimated due at time of travel:</strong></td>
							<td>$<span id="dueAtArrival"><?php echo $subtotal;?></span></td>
						</tr>
					</tfoot>
					<?php					
					break;
					
				case '4': //bicycles
				$subtotal = sprintf('%.2f',$vehicle_rate+$adult_rate+$child_rate);
					$total = sprintf('%.2f',$subtotal + $online_roundtrip);
					?>
					<tbody>
						<tr>
							<td><?php echo $vehicle_count.' '.$ii_name;?></td>
							<td>$<span id="vehicle_rate"><?php echo $vehicle_rate;?></span></td>
						</tr>
						<tr>
							<td><?php echo $adults;?> Adult(s) (ages 12+)</td>
							<td>$<span id="adult_rate"><?php echo $adult_rate;?></span></td>
						</tr>
						<?php
						if($children != '0'):
						?>
						<tr>
							<td><?php echo $children;?> Child(ren) (ages 5-11)</td>
							<td>$<span id="child_rate"><?php echo $child_rate;?></span></td>
						</tr>
						<?php
						endif;
						if($infants != '0'):
						?>
						<tr>
							<td><?php echo $infants;?> Child(ren) (ages 0-4)</td>
							<td >Free</td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
					<tfoot>
						<tr>
							<td><strong>Subtotal:</strong></td>
							<td>$<span id="subtotal"><?php echo $subtotal;?></span></td>
						</tr>

						<tr>
							<td><strong>TOTAL (due at checkout):</strong></td>
							<td>$<span id="dueAtCheckout"><?php echo $total;?></span></td>
						</tr>

					</tfoot>
					<?php				
					break;
			}

			break;
		
		
		default: //oneway trip
			foreach ($adult_rate_depart as $ard) {
				$ar_depart = $ard['total'];
			}
			foreach ($child_rate_depart as $crd) {
				$cr_depart = $crd['total'];
			}

			foreach ($driver_rate_depart as $drd) {
				$dr_depart = $drd['total'];
			}

			if(!empty($vehicle_rate_depart)){		
				foreach ($vehicle_rate_depart as $vrd) {
					$vr_depart = $vrd['total'];
				}
			} else {
				$vr_depart = '0.00';
			}
		
			$adult_rate = sprintf('%.2f',round(($ar_depart)*$adults,2));
			$child_rate = sprintf('%.2f',round(($cr_depart)*$children,2));
			$vehicle_rate = sprintf('%.2f',round(($vr_depart)*$vehicle_count,2));
			
			switch ($inventory_id) {
				case '1': //passengers
					$subtotal = sprintf('%.2f',$adult_rate+$child_rate);
					?>

					<tbody>
						<tr>
							<td><?php echo $adults;?> Adult(s) (ages 12+)</td>
							<td>$<span id="adult_rate"><?php echo $adult_rate;?></span></td>
						</tr>
						<?php
						if($children != '0'):
						?>
						<tr>
							<td><?php echo $children;?> Child(ren) (ages 5-11)</td>
							<td>$<span id="child_rate"><?php echo $child_rate;?></span></td>
						</tr>
						<?php
						endif;
						if($infants != '0'):
						?>
						<tr>
							<td><?php echo $infants;?> Child(ren) (ages 0-4)</td>
							<td >Free</td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
					<tfoot>
						<tr>
							<td><strong>Subtotal:</strong></td>
							<td>$<span id="subtotal"><?php echo $subtotal;?></span></td>
						</tr>

						<tr>
							<td><strong>TOTAL (due at checkout):</strong></td>
							<td>$<span id="dueAtCheckout"><?php echo $subtotal;?></span></td>
						</tr>
					</tfoot>
					<?php
					break;
				case '2': //vehicles

					$addtl_driver_rate= sprintf('%.2f',round(($drivers *($dr_depart)),2));
					$addtl_adult_rate = sprintf('%.2f',round(($ar_depart)*$adults,2));
					$addtl_child_rate = sprintf('%.2f',round(($cr_depart)*$children,2));

					$vehicle_rate = 0;
					if(!empty($ovrd)){		
						foreach ($ovrd as $ovd) {
							foreach ($ovd as $key => $value) {
								$vr_depart_id = $ovd[$key]['id'];
							
								$vr_depart = $ovd[$key]['total'];
								$vehicle_rate = $vehicle_rate + $vr_depart;
	
			
							}

						}
					} 


					$subtotal = sprintf('%.2f',$vehicle_rate+$addtl_adult_rate+$addtl_child_rate+$addtl_driver_rate);
					$total = sprintf('%.2f',$subtotal+$online_oneway);					
					?>
					<tbody>
						<?php
						$vehicle_rate1 = 0;
						$vehicle_rate2 = 0;	
						$ovrd_overlength = 0;					
						$count_total = count($ovrd);
						foreach ($ovrd as $key => $value) {
							$vehicle_count = count($value);	
							
							foreach ($ovrd[$key] as $akey => $avalue) {
								$id = $ovrd[$key][$akey]['id'];
								$ovrd_total = $ovrd[$key][$akey]['total'];
								$ovrd_overlength =$ovrd_overlength +  $ovrd[$key][$akey]['overlength'];
								$ovrd_overlength_rate = $ovrd[$key][$akey]['overlength_rate'];
								$ovrd_oneway = $ovrd[$key][$akey]['oneway'];
								if($id == '22'){
									$vehicle_rate1 = $vehicle_rate1 + $ovrd_total;
									
								} else {
									$vehicle_rate2 = $vehicle_rate2 + $ovrd_oneway;
									
								}
							}
							$ovrd_driver_rate= sprintf('%.2f',round(($vehicle_count *$dr_depart),2));
							$ovrd_overlength_oneway = sprintf('%.2f',round(($ovrd_overlength_rate * $ovrd_overlength),2));
							$ovrd_overlength_roundtrip = sprintf('%.2f',round(($ovrd_overlength_rate * $ovrd_overlength),2));							
							$overlength_details = 'Overlength charge: '.$ovrd_overlength.' total extra feet @ $'.$ovrd_overlength_rate.' per foot';
							$ovrd_total_vehicle = sprintf('%.2f',round(($vehicle_count * $ovrd_oneway),2));
							if($key != 'Vehicle or Vehicle with Towed Unit (over 18 feet)'){
							?>
							<tr>
								<td><?php echo $vehicle_count.' '.$key.' @ ($'.$ovrd_total_vehicle.') + '.$vehicle_count.' Driver(s) @ ($'.$ovrd_driver_rate.')';?></td>
								<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',(round($vehicle_rate1,2)+$ovrd_driver_rate));?></span></td>								
							</tr>	
							<?php	
							} else {
							?>
							<tr>
								<td><?php echo $vehicle_count.' '.$key.' @ ($'.$ovrd_total_vehicle.') + '.$vehicle_count.' Driver(s) @ ($'.$ovrd_driver_rate.')';?></td>
								<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',(round($vehicle_rate2,2)+$ovrd_driver_rate));?></span></td>
							</tr>		
							<tr>
								<td>+ <?php echo $overlength_details;?> </td>
								<td>$<span id="overlength_fee"><?php echo $ovrd_overlength_roundtrip;?></span></td>
							</tr>
							<?php
							}
						}

						if($adults != '0'){
						?>
						<tr>
							<td><?php echo $adults;?> Additional adult passengers (ages 12+)</td>
							<td>$<span id="adult_rate"><?php echo $addtl_adult_rate;?></span></td>
						</tr>
						<?php
						}
						if($children != '0'):
						?>
						<tr>
							<td><?php echo $children;?> Child passengers (ages 5-11)</td>
							<td>$<span id="child_rate"><?php echo $child_rate;?></span></td>
						</tr>
						<?php
						endif;
						if($infants != '0'):
						?>
						<tr>
							<td><?php echo $infants;?> Child passengers (ages 0-4)</td>
							<td>Free</td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
					<tfoot>
					<?php
					
					?>
						<tr>
							<td><strong>Subtotal:</strong></td>
							<td>$<span id="subtotal"><?php echo $subtotal;?></span></td>
						</tr>
						<tr>
							<td><strong>Online Reservation Fee:</strong></td>
							<td>$<span id="online_fee"><?php echo $online_oneway;?></span></td>
						</tr>
						<tr>
							<td><strong>TOTAL:</strong></td>
							<td>$<span id="total"><?php echo $total;?></span></td>
						</tr>
						<tr>
							<td><strong>Due at checkout:</strong></td>
							<td>$<span id="dueAtCheckout"><?php echo $online_oneway;?></span></td>
						</tr>
						<tr>
							<td><strong>Due at time of travel:</strong></td>
							<td>$<span id="dueAtArrival"><?php echo $subtotal;?></span></td>
						</tr>
					</tfoot>
					<?php									
					break;
					
				case '3': //motorcycles
					$vehicle_rate = 0;
					if(!empty($mrd)){		
						foreach ($mrd as $md) {
							foreach ($md as $key => $value) {
								$vr_depart_id = $md[$key]['id'];
								$vr_depart = $md[$key]['total'];
								$vehicle_rate = $vehicle_rate + $vr_depart;
							}

						}
					} 
					if(!empty($mrr)){
						foreach ($mrr as $mr) {
							foreach ($mr as $key => $value) {
								$vr_return_id = $mr[$key]['id'];
								$vr_return = $mr[$key]['total'];
								$vehicle_rate = $vehicle_rate + $vr_return;		
						
							}

						}
					}	
	
					$subtotal = sprintf('%.2f',round(($vr_depart* $vehicle_count)+($adult_rate)+($child_rate),2));
					$total = sprintf('%.2f',$subtotal + $online_oneway);
					?>
					<tbody>
						<?php
						$motorcycle_rate1 = 0;
						$motorcycle_rate2 = 0;	
						$motorcycle_rate3 = 0;
						$motorcycle_rate4 = 0;					
						$count_total = count($mrd);
						
						foreach ($mrd as $key =>$value) {
							$vehicle_count = count($value);
							foreach ($mrd[$key] as $akey => $avalue) {
								$id = $mrd[$key][$akey]['id'];
								$mrd_total = $mrd[$key][$akey]['total'];
								switch ($id) {
									case '24':
										$motorcycle_rate1 = $motorcycle_rate1 + $mrd_total;
										break;
									case '25':
										$motorcycle_rate2 = $motorcycle_rate2 + $mrd_total;
										break;
									case '26':
										$motorcycle_rate3 = $motorcycle_rate3 + $mrd_total;
										break;
									case '27':
										$motorcycle_rate4 = $motorcycle_rate4 + $mrd_total;
										break;
	
								}
							}

							?>
							<tr>
								<td><?php echo $vehicle_count.' '.$key;?></td>
								<?php
								switch ($key) {
									case 'Motorcycle':
										?>
										<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',round($motorcycle_rate1,2));?></span></td>
										<?php										
										break;
									case 'Motorcycle w/Sidecar and/or Trailer':
										?>
										<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',round($motorcycle_rate2,2));?></span></td>
										<?php
										break;
									case 'Motorized Tricycle':
										?>
										<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',round($motorcycle_rate3,2));?></span></td>
										<?php									
										break;
									default:
										?>
										<td>$<span id="vehicle_rate"><?php echo sprintf('%.2f',round($motorcycle_rate4,2));?></span></td>
										<?php										
										break;
								}
								?>
								
							</tr>		
							<?php					
						}
						?>
						<tr>
							<td><?php echo $adults;?> Adult(s) (ages 12+)</td>
							<td>$<span id="adult_rate"><?php echo $adult_rate;?></span></td>
						</tr>
						<?php
						if($children != '0'):
						?>
						<tr>
							<td><?php echo $children;?> Child(ren) (ages 5-11)</td>
							<td>$<span id="child_rate"><?php echo $child_rate;?></span></td>
						</tr>
						<?php
						endif;
						if($infants != '0'):
						?>
						<tr>
							<td><?php echo $infants;?> Child(ren) (ages 0-4)</td>
							<td >Free</td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
					<tfoot>
						<tr>
							<td><strong>Subtotal:</strong></td>
							<td>$<span id="subtotal"><?php echo $subtotal;?></span></td>
						</tr>
						<tr>
							<td><strong>Online Reservation Fee:</strong></td>
							<td>$<span id="online_fee"><?php echo $online_oneway;?></span></td>
						</tr>
						<tr>
							<td><strong>TOTAL:</strong></td>
							<td>$<span id="total"><?php echo $total;?></span></td>
						</tr>
						<tr>
							<td><strong>Due at checkout:</strong></td>
							<td>$<span id="dueAtCheckout"><?php echo $online_oneway;?></span></td>
						</tr>
						<tr>
							<td><strong>Due at time of travel:</strong></td>
							<td>$<span id="dueAtArrival"><?php echo $subtotal;?></span></td>
						</tr>
					</tfoot>
					<?php					
					break;
					
				case '4': //bicycles
					$subtotal = sprintf('%.2f',$vehicle_rate+$adult_rate+$child_rate);
					$total = sprintf('%.2f',$subtotal + $online_oneway);
					?>
					<tbody>
						<tr>
							<td><?php echo $vehicle_count.' '.$ii_name;?></td>
							<td>$<span id="vehicle_rate"><?php echo $vehicle_rate;?></span></td>
						</tr>
						<tr>
							<td><?php echo $adults;?> Adult(s) (ages 12+)</td>
							<td>$<span id="adult_rate"><?php echo $adult_rate;?></span></td>
						</tr>
						<?php
						if($children != '0'):
						?>
						<tr>
							<td><?php echo $children;?> Child(ren) (ages 5-11)</td>
							<td>$<span id="child_rate"><?php echo $child_rate;?></span></td>
						</tr>
						<?php
						endif;
						if($infants != '0'):
						?>
						<tr>
							<td><?php echo $infants;?> Child(ren) (ages 0-4)</td>
							<td >Free</td>
						</tr>
						<?php
						endif;
						?>
					</tbody>
					<tfoot>
						<tr>
							<td><strong>Subtotal:</strong></td>
							<td>$<span id="subtotal"><?php echo $subtotal;?></span></td>
						</tr>

						<tr>
							<td><strong>TOTAL (due at checkout):</strong></td>
							<td>$<span id="dueAtCheckout"><?php echo $total;?></span></td>
						</tr>

					</tfoot>
					<?php				
					break;
					}
			break;
	}
?>