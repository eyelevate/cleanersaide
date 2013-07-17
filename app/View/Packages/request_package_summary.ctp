<thead>
	<tr>
		<th>Item</th>
		<th>Description</th>
		<th>Totals</th>
	</tr>
</thead>
<!-- ferry totals-->
<?php
if($day_trip == 'Yes'){
	switch($summary_type){
		case 'Passenger':
			$package_total = sprintf('%.2f',$package_rt_walkon);
			$package_description ='Base package includes roundtrip ferry walk-on, for 2 adults plus event vouchers.';
		break;
			
		default:
			$package_total = sprintf('%.2f',$package_rt_vehicle);
			$package_description = 'Base package includes roundtrip ferry with vehicle (18 feet or under), 1 night at '.$hotel_name.' for 2 adults';
		break;
			
	}	
} else {
	switch($summary_type){
		case 'Passenger':
			$package_total = sprintf('%.2f',$package_rt_walkon);
			$package_description ='Base package includes roundtrip ferry walk-on, for 2 adults plus 1 night hotel stay.';
		break;
			
		default:
			$package_total = sprintf('%.2f',$package_rt_vehicle);
			$package_description = 'Base package includes roundtrip ferry with vehicle (18 feet or under), 1 night at '.$hotel_name.' for 2 adults';
		break;
			
	}	
}


?>
<tbody id="summaryTbody">
	<tr>
		<td><?php echo $package_name;?></td>
		<td><?php echo $package_description;?></td>
		<td>$<?php echo $package_total;?></td>
	</tr>
<?php

foreach ($summary as $s) {
	$ferries = $s['ferries'];
	$hotels = $s['hotels'];

	$attractions = $s['attractions'];
	if(!empty($ferries)){
		foreach ($ferries as $f) {
			$trip_type = $f['trip_type'];
			$depart_port = $f['depart_port'];
			$depart_time = $f['depart_time'];
			$depart_full_date = $f['depart_full_date'];
			switch($summary_type){
				case 'Passenger':
					$drivers = '0';		
				break;
					
				default:
					$drivers = '1';
				break;
			}
			if(!empty($f['adults'])){
				$adults = $f['adults'];	
			} else {
				$adults = 0;
			}
			
			$children = $f['children'];
			$infants = $f['infants'];
			$ao_count =$drivers +  $adults + $children + $infants;
			$ferry_subtotal = $f['subtotal'];
			switch($depart_port){
				case 'Port Angeles':
					$return_port = 'Victoria';
				break;
					
				default:
					$return_port = 'Port Angeles';
				break;
			}
			switch($trip_type){
				case 'roundtrip':

					$return_full_date = $f['return_full_date'];
					$trip_title =$depart_port.' -> '.$return_port.' (roundtrip)';
					$ferry_desc = '<ul class"unstyled">'.
						'<li><strong>'.$trip_title.'</strong></li>'.
						'<li>Departs '.$depart_port.' @ '.date('D n/d/Y @ g:ia',strtotime($depart_full_date)).'</li>'.
						'<li>Returns '.$return_port.' @ '.date('D n/d/Y @ g:ia',strtotime($return_full_date)).'</li>'.
						'</ul>';
				break;
					
				default:
					$trip_title = $depart_port.' -> '.$return_port.' (oneway)';
					$ferry_desc = '<ul class"unstyled">'.
						'<li><strong>'.$trip_title.'</strong></li>'.
						'<li>Departs '.$depart_port.' @ '.date('D n/d/Y @ g:ia',strtotime($depart_full_date)).'</li>'.

						'</ul>';
				break;
			}

			
			
		}

		switch($summary_type){
			case 'Vehicle':
				$ferry_subtotal_difference = $ferry_subtotal-$ferry_base;
				if($ferry_subtotal_difference > 0){
					$ferry_difference_display = '+$'.sprintf('%.2f',$ferry_subtotal_difference);
					$package_total = $package_total + ($ferry_subtotal - $ferry_base);
				} elseif($ferry_subtotal_difference == 0){
					$ferry_difference_display = '[Included]';
				} else {
					$ferry_difference_display = '-$'.sprintf('%.2f',($ferry_subtotal_difference* -1));
					$package_total = $package_total + ($ferry_subtotal - $ferry_base);
				}	
			break;
				
			default:
				$ferry_subtotal_difference = $ferry_subtotal-$ferry_base;
				if($ferry_subtotal_difference > 0){
					$ferry_difference_display = '+$'.sprintf('%.2f',$ferry_subtotal_difference);
					$package_total = $package_total + ($ferry_subtotal - $ferry_base);
				} elseif($ferry_subtotal_difference == 0){
					$ferry_difference_display = '[Included]';
				} else {
					$ferry_difference_display = '-$'.sprintf('%.2f',($ferry_subtotal_difference* -1));
					$package_total = $package_total + ($ferry_subtotal - $ferry_base);
				}				
			break;
		}
	



	} else {
		$ferry_desc = 'No trip(s) selected.';
		$ferry_subtotal = '0.00';
		$ferry_difference_display = '<span class="text text-error">[Not Set]</span>';
		$ao_count = 0;
	}
	
	
	

	?>
	<tr>
		<td>Ferry Summary</td>
		<td><?php echo $ferry_desc;?></td>
		<!-- <td><?php echo $ferry_subtotal.' '.$ferry_base;?></td> -->
		<td><?php echo $ferry_difference_display;?></td>
	</tr>
	<?php
	if($day_trip == 'No'){

		foreach ($hotels as $h) {
			$check_in = date('D m/d/Y',$h['start']);
			$check_out = date('D m/d/Y',$h['end']);
			$hotel_nights = ($h['end'] - $h['start']) / 86400;
			$hotel_adults = $h['adults'];
			$hotel_children = $h['children'];
			$hotel_name = $h['hotel_name'];
			$room_name = $h['room_name'];
			$room_count = $h['total_rooms'];
			$room_base = $h['room_base'];
			$hotel_taxes = $h['total_tax'];
			$hotel_net = $h['total_net'];
			$hotel_gross = $h['total_gross'];
			$hotel_extra_fee = $h['total_extra_fee'];
			$hotel_base_after_tax = $hotel_gross;
			$hotel_desc = '<ul class="unstyled">';
			$hotel_desc .='<li><strong>'.$hotel_name.'</strong> : '.$room_name.'</li>';
			$hotel_desc .='<li>'.$room_count.' room(s), '.$hotel_adults.' adults, '.$hotel_children.' children </li>';
			if($hotel_extra_fee > 0){
				$hotel_desc .='<li>[Extra Person fees] +$'.$hotel_extra_fee.'</li>';
			}
			$hotel_desc .='<li>[Check-in] '.$check_in.'</li>';
			$hotel_desc .='<li>[Check-out] '.$check_out.'</li>';
			$hotel_desc .='</ul>';	
			
			//$package_total = $package_total + $hotel_after_tax;
			$hotel_check_base = sprintf('%.2f',round(($hotel_gross - $hotel_extra_fee) / $room_count,2));
			$hotel_check_total = $hotel_gross;
			
			if($hotel_check_total == $room_base){
		
				$hotel_difference = '[Included]';
				$hotel_total_difference = 0;
			} elseif($hotel_gross <= 0){
				$hotel_desc = '<span class="text text-error">No hotel room chosen. Please select a hotel room from above.</span>';
				$hotel_difference = '<span class="text text-error">[Not set]</span>';
			} else {
				
				$hotel_total_difference = $hotel_check_total - $room_base;
				
				$package_total = $package_total + $hotel_total_difference;
				
				$hotel_difference = '+$'.sprintf('%.2f',round($hotel_total_difference,2));
				
			}
		}
		?>
		
		<tr>
			<td>Hotel Summary</td>
			<td><?php echo $hotel_desc;?></td>
			<td><?php echo $hotel_difference;?>
			<?php
			//debug($room_base.' '.$hotel_check_total.' '.$hotel_nights.' '.$room_count.' '.$hotel_extra_fee);
			?>	
				
			</td>
			<!-- <td><?php echo $hotel_difference;?></td>  -->
		</tr>
		<?php
	}  else {
		$hotel_desc = 'No Hotel Room Selected';
		$hotel_difference = '<span class="text text-error">[Not set]</span>';

	}

		
	

	$total_ticket = 0;
	if(!empty($attractions)){
		foreach ($attractions as $a) {
		
			$attraction_name = $a['attraction_name'];
			$tour_name = $a['tour_name'];
			$total_tax = 1+($a['total_tax'] / 100);
			if(!empty($a['timed_tour'])){
				$attraction_timed = $a['timed_tour'];
			} else {
				$attraction_timed = 'No';
			}

			switch($attraction_timed){
				case 'Yes':
					$attraction_date = date('D n/d/Y',$a['start']).' '.$a['time'];
				break;
				default:
					$attraction_date = date('D n/d/Y',$a['start']);
				break;
			}

			$attraction_desc = '<ul class="unstyled">';
			$attraction_desc .= '<li><strong>'.$attraction_name.'</strong> - '.$tour_name.' '.$a['time'].'<li>';
			$attraction_desc .= '<li>'.$attraction_date.'</li>';
			$total_ticket = 0;
			if(!empty($a['purchase_info'])){
				$purchase_info = $a['purchase_info'];
				foreach ($purchase_info as $pi) {
					$tour_inventory_name = $pi['name'];
					$tour_ticket_amount = $pi['amount'];
					$tour_ticket_gross = $pi['gross'];
					$tour_per_ticket = sprintf('%.2f',round(($tour_ticket_gross * $total_tax),2));
					$tour_ticket_after_tax = sprintf('%.2f',round(($tour_ticket_gross * $total_tax)* $tour_ticket_amount,2));
					$total_ticket = $total_ticket + $tour_ticket_after_tax;
					$attraction_desc .= '<li>'.$tour_ticket_amount.' '.$tour_inventory_name.' @ $'.$tour_per_ticket.'/ ticket</li>';
					
				
					
				}
			} 		

			$attraction_desc .= '</ul>';
			
			$package_total = $package_total + $total_ticket;
			
			?>
			<tr>
				<td>Attraction Summary</td>
				<td><?php echo $attraction_desc;?></td>
				<td><?php echo '+$'.sprintf('%.2f',$total_ticket);?></td>
			</tr>				
			<?php
		}
	} 
	$base_people = 2;
	$ao_grand_total = 0;
	
	if(count($add_ons)>0){
		foreach ($add_ons as $ao) {
			$ao_desc = $ao['description'];
			$ao_name = $ao['name'];
			$ao_type = $ao['type'];
			$ao_taxes = $ao['taxes'];
			$ao_gross = $ao['gross'];
			$ao_total = sprintf('%.2f',round($ao_gross * (1+($ao_taxes/100)),2));
			switch($ao_type){
				case 'person': //per person
					$ao_base = $base_people * $ao_total;
					$ao_total = $ao_count * $ao_total;
				break;
				
				default: //this is a per trip
					$ao_base = $ao_total;
					$ao_total = $ao_total;
				break;
			}


			if($ao_base == $ao_total){
				$ao_grand_total = 0;
				$ao_display_total = '[Included]';
			} else {
				$ao_grand_total = $ao_total - $ao_base;
				if($ao_grand_total < 0){
					$ao_display_total = '-$'.sprintf('%.2f',$ao_grand_total);
				} else {
					$ao_display_total = '+$'.sprintf('%.2f',$ao_grand_total);	
				}
				
				
				$package_total += $ao_grand_total;
			}
		}
		

		?>
		<tr>
			<td>Package Includes</td>
			<td><?php echo '<strong>'.$ao_name.'</strong> - '.$ao_desc;?></td>
			<td><?php echo $ao_display_total;?></td>
			
		</tr>		
		<?php
	}

}
?>
</tbody>
<tfoot>
	<tr >
		<th colspan="2" style="border-top:2px solid #5e5e5e">Package Total</th>
		<td style="border:2px solid #5e5e5e;"><strong>$<?php echo sprintf('%.2f',$package_total);?></strong></td>
	</tr>
	<tr class="hide">
		<td>
			<input type="hidden" name="data[Package_reservation][base]" value="<?php echo $package_rt_vehicle;?>"/>
			<input type="hidden" name="data[Package_reservation][ferry]" value="<?php echo $ferry_subtotal_difference;?>"/>
			<?php
			if(!empty($hotel_total_difference)){
			?>
				<input type="hidden" name="data[Package_reservation][hotel]" value="<?php echo $hotel_total_difference;?>"/>
			<?php
			} else {
			?>
				<input type="hidden" name="data[Package_reservation][hotel]" value="0"/>
			<?php				
			}
			?>
			<input type="hidden" name="data[Package_reservation][attraction]" value="<?php echo $total_ticket;?>"/>
			<input type="hidden" name="data[Package_reservation][total]" value="<?php echo $package_total;?>"/>
			<?php
			if(!empty($ao_grand_total)){
			?>
			<input type="hidden" name="data[Package_reservation][add_ons]" value="<?php echo $ao_grand_total;?>"/>
			<?php
			} else {
			?>
			<input type="hidden" name="data[Package_reservation][add_ons]" value="0"/>
			<?php				
			}
			?>
			
		</td>		
	</tr>
</tfoot>
