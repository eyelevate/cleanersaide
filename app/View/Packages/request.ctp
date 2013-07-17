<?php
//ferry
if($_REQUEST['type']=="Ferry" && $_REQUEST['adults'] && $_REQUEST['children'] && $_REQUEST['trip_count'] && $_REQUEST['vehicle']){
	print_r($results);
}
if($_REQUEST['type']=="Ferry_summary" && $_REQUEST['adults'] && $_REQUEST['children'] && $_REQUEST['trip_count'] && $_REQUEST['vehicle']){
	$total_adult_price = sprintf('%.2f',$adult_price*$trips*$adults);
	$total_children_price = sprintf('%.2f',$children_price*$trips*$children);
	$total_vehicle_price = sprintf('%.2f',$vehicle_price*$trips);

	?>
	<li><?php echo $adults;?> adult(s) @ $<span id="adult_single_price"><?php echo $adult_price;?></span> * <?php echo $trips;?> trip(s) = $<?php echo $total_adult_price;?></li>
	<li><?php echo $children;?> child(ren) @ $<span id="child_single_price"><?php echo $children_price;?></span> * <?php echo $trips;?> trip(s) = $<?php echo $total_children_price;?> </li>
	<?php 
	if($vehicle_type != 'NONE'){
	?>
	<li><?php echo $vehicle_type;?> @ $<?php echo $vehicle_price;?> * <?php echo $trips;?> trip(s) = $<?php echo $total_vehicle_price;?> </li>
	<li>Reservation fee (<?php echo $trip_type.' '.$vehicle_type;?>) = $<?php echo $surcharge;?> </li>
	<?php	
	} else {
	?>
	<li>No Vehicle selected</li>
	<li>Reservation fee = $<?php echo $surcharge;?></li>
	<?php		
	}

}
if($_REQUEST['type']=="Hotel_rates" && $_REQUEST['hotel_room'] && $_REQUEST['start_date'] && $_REQUEST['end_date'] && $_REQUEST['nights']){
	$count_results = count($results);
	switch ($count_results) {
		case 0:
			?>
			<li><span class="label label-important">Warning</span> There are no hotel rates set for this date range. Please add the proper rates and try again.</li>
			<?php
			break;
		case 1:
			if(!empty($results)>0){
				foreach ($results as $key => $value) {
					$room_rate = $key;
					$room_gross = $results[$key]['gross'];
					$room_markup = $results[$key]['markup'];
					
				}
			} else {
				$room_rate = 0;
				$room_gross = 0;
				$room_markup = 0;
			}
			?>
			<li><?php echo $room_name;?> @ $<span class="hotelDefaultRate"><?php echo $room_rate;?></span> per night</li>
			<li>Taxes applied: [
			<?php
			$tax_string ='';
			$tax_sum = 0;
			foreach ($taxes as $tax) {
				$tax_id = $tax['id'];
				$tax_name = $tax['name'];
				$tax_country = $tax['country'];
				$tax_rate = $tax['rate'];
				$tax_sum = $tax_rate+ $tax_sum;
				$tax_basis = $tax['per_basis'];
				$tax_string = $tax_string.', '.$tax_name.' @ '.$tax_rate.'%';
			}
			$tax_string = substr_replace($tax_string, "", 0,1);
			$total_net = sprintf('%.2f',round($room_rate * (1+($tax_sum/100)) * $nights,2));
			$total_gross = sprintf('%.2f',round($total_net * (1+($room_markup / 100)),2));
			echo $tax_string;
			?>] = <span class="hotel_tax_sum" sum="<?php echo $tax_sum;?>"><?php echo $tax_sum;?></span>%
			</li>
			<li><span class="count_nights"><?php echo $nights;?></span> Nights</li>			
			<li>Underlying Cost: <span class="roomUnderlyingCost" sum="<?php echo $total_net;?>">$<?php echo $total_net;?></span></li>
			<li>Markup: <span class="roomMarkupRate" sum="<?php echo $room_markup;?>"><?php echo $room_markup;?>%</span></li>
			<li class="hotel_plus_fee" plus_fee="<?php echo $plus_fee;?>">À la carte: <span class="roomGrossRate" sum="<?php echo $total_gross;?>">$<?php echo $total_gross;?></span></li>

			<?php
			break;
			
		
		default:
			?>
			<li><span class="label label-important">Warning</span> There are multiple rates created for this hotel room.			
				<br/>
				<div class="control-group">
					<label><strong>Select Default Rate</strong></label>
					<div class="">
						<select class="hotel_default_rate">
							<option value="">Select default rate</option>
							<?php
							foreach ($results as $key => $value) {
								$room_net = $key;
								$room_gross = $value;
								$room_markup =sprintf('%.2f',round((($value / $key)-1) * 100,2));
								
							?>
							<option value="<?php echo $key;?>" markup="<?php echo $room_markup;?>" gross="<?php echo $room_gross;?>">$<?php echo $key;?></option>
							<?php
							}
							?>
						</select>
					</div>
					<span class="help-block"></span>
				</div>
				
			</li>
			<?php
			break;
	}

}
if($_REQUEST['type']=="Hotel_default" && $_REQUEST['hotel_room'] && $_REQUEST['default_rate'] && $_REQUEST['default_gross'] && $_REQUEST['default_markup'] && $_REQUEST['nights']){
		
	?>
	<li><?php echo $room_name;?> @ $<span class="hotelDefaultRate"><?php echo $default_rate;?></span> per night</li>
	<li>Taxes applied: [
	<?php
	$tax_string ='';
	$tax_sum = 0;
	foreach ($taxes as $tax) {
		$tax_id = $tax['id'];
		$tax_name = $tax['name'];
		$tax_country = $tax['country'];
		$tax_rate = $tax['rate'];
		$tax_sum = $tax_rate+ $tax_sum;
		$tax_basis = $tax['per_basis'];
		$tax_string = $tax_string.', '.$tax_name.' @ '.$tax_rate.'%';
	}
	$tax_string = substr_replace($tax_string, "", 0,1);
	echo $tax_string;
	?>] = <span class="hotel_tax_sum" sum="<?php echo $tax_sum;?>"><?php echo $tax_sum;?></span>%
	</li>
	<li><span class="count_nights"><?php echo $nights;?></span> Nights</li>
	<?php
	$total_cost = sprintf('%.2f',round($default_rate * (1+($tax_sum/100)) * $nights,2));
	$total_markup = $default_markup;
	$total_gross = sprintf('%.2f',round($total_cost * (1+($total_markup / 100)),2));
	?>
	<li>Underlying Cost: $<span class="roomUnderlyingCost" sum="<?php echo $total_cost;?>"><?php echo $total_cost;?></span></li>
	<li>Markup: <span class="roomMarkupRate" sum="<?php echo $total_markup;?>"><?php echo $total_markup;?>%</span></li>
	<li class="hotel_plus_fee" plus_fee="<?php echo $plus_fee;?>">À la carte: <span class="roomGrossRate" sum="<?php echo $total_gross;?>">$<?php echo $total_gross;?></span></li>
	<?php
}
if($_REQUEST['type'] == "Attraction_grabTickets" && $_REQUEST['attraction_id'] && $_REQUEST['start_date'] && $_REQUEST['end_date']){
	$count_results = count($results);
	
	switch ($count_results) {
		case '0':
			?>
			<option>No tickets available during these dates</option>
			<?php
			break;
		
		default:
			?>
			<option value="" value="" net="" markup="" gross="">Select Ticket</option>
			<?php
			foreach ($results as $key => $value) {
			?>
			<optgroup label="<?php echo $key;?>">
			<?php
			foreach ($results[$key] as $rr) {
				$net = $rr['net'];
				$gross = $rr['gross'];
				$inventory = $rr['inventory'];
				$markup = $rr['markup'];				
				?>
				<option value="<?php echo $key;?>" net="<?php echo $net;?>" markup="<?php echo $markup;?>" gross="<?php echo $gross;?>">$<?php echo $net;?></option>
				<?php
			}
			?>
			</optgroup>
			<?php
			}			
			break;
	}

}

//attraction
if($_REQUEST['type'] == "Attraction_rates" && $_REQUEST['tickets'] && $_REQUEST['adults'] && $_REQUEST['children'] && $_REQUEST['adult_price'] && $_REQUEST['children_price']){
	
	?>
	<li style="margin-top:1px; margin-bottom:3px" class="alert alert-info">
			<button id="closeTicket-<?php echo $ticket_id;?>" type="button" class="close">&times;</button>
			<ul>
				<h4 class="heading"><?php echo $ticket_name;?> - [<?php echo $attraction_name;?>]</h4>
				<li><?php echo $adults;?> Adults @ <span class="adultTicketPrice" sum="<?php echo $adult_price;?>">$<?php echo $adult_price;?></span></li>
				<li><?php echo $children;?> Children @ <span class="childTicketPrice" sum="<?php echo $children_price;?>">$<?php echo $children_price;?></span></li>

				<li><strong>Taxes applied:</strong> [
				<?php
				$tax_string ='';
				$tax_sum = 0;
				foreach ($taxes as $tax) {
					$tax_id = $tax['id'];
					$tax_name = $tax['name'];
					$tax_country = $tax['country'];
					$tax_rate = $tax['rate'];
					$tax_sum = $tax_rate+ $tax_sum;
					$tax_basis = $tax['per_basis'];
					$tax_string = $tax_string.', '.$tax_name.' @ '.$tax_rate.'%';
				}
				$tax_string = substr_replace($tax_string, "", 0,1);
				$total_adults_net = sprintf('%.2f',round($adult_price* (1+($tax_sum/100)),2));
				$total_children_net = sprintf('%.2f',round($children_price * (1+($tax_sum/100)),2));
				$markup_adults = ($total_adults_net * (1+($adult_markup/100)))*$adults;
				$markup_children = ($total_children_net * (1+($children_markup/100)))*$children;
				$total_net = ($total_adults_net * $adults)+($total_children_net * $children);
				$total_net = sprintf('%.2f',round($total_net,2));
				$total_gross = sprintf('%.2f',round($markup_adults+$markup_children,2));
				$total_markup = sprintf('%.2f',round((($total_gross / $total_net)-1) * 100));
				echo $tax_string;
				?>] = <span class="attraction_tax" sum="<?php echo $tax_sum;?>"><?php echo $tax_sum;?></span>%
				</li>
				<li><strong>Underlying Cost:</strong> <span class="attractionUnderlyingCost" sum="<?php echo $total_net;?>">$<?php echo $total_net;?></span></li>
				<li><strong>Markup:</strong> <span class="attractionMarkupRate" sum="<?php echo $total_markup;?>"><?php echo $total_markup;?>%</span></li>
				<li><strong>À la carte:</strong> <span class="attractionGrossRate" sum="<?php echo $total_gross;?>">$<?php echo $total_gross;?></span></li>
			</ul>
			<input ticket_id="<?php echo $ticket_id;?>" type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][ticket_id]" value="<?php echo $ticket_id;?>"/>
			<input type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][ticket_name]" value="<?php echo $ticket_name;?>"/>
			<input type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][adult_price]" value="<?php echo $adult_price;?>"/>
			<input type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][children_price]" value="<?php echo $children_price;?>"/>
			<input type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][total_net]" value="<?php echo $total_net;?>"/>
			<input type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][total_markup]" value="<?php echo $total_markup;?>"/>
			<input type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][total_gross]" value="<?php echo $total_gross;?>"/>
			<input type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][tax_string]" value="<?php echo $tax_string;?>"/>
			<input type="hidden" name="data[Package][attraction_tickets][<?php echo $ticket_id;?>][tax_sum]" value="<?php echo $tax_sum;?>"/>
			

	</li>
	<?php

}

//attraction
if($_REQUEST['type'] == "ADDONS" && $_REQUEST['addOn']){
	switch($type){
		case 'person':
			$add_on_type = 'Per person';
			break;
			
		default:
			$add_on_type = 'Per trip';
			break;
	}
	?>
	<li style="margin-top:1px; margin-bottom:3px" class="addOnLi alert alert-info">
			<button id="addOnCloseTicket-<?php echo $id;?>" type="button" class="close">&times;</button>
			<ul>
				<h4 class="heading"><?php echo $name;?></h4>
				<li><strong>Type:</strong> <span class="addOnType"><?php echo $add_on_type;?></span></li>
				<li><strong>Description:</strong> <?php echo $desc;?></li>
				<li><strong>Taxes applied:</strong> [
				<?php
				$tax_string ='';
				$tax_sum = 0;
				foreach ($taxes as $tax) {
					$tax_id = $tax['id'];
					$tax_name = $tax['name'];
					$tax_country = $tax['country'];
					$tax_rate = $tax['rate'];
					$tax_sum = $tax_rate+ $tax_sum;
					$tax_basis = $tax['per_basis'];
					$tax_string = $tax_string.', '.$tax_name.' @ '.$tax_rate.'%';
					
	
				}
				$sum_tax = 1+($tax_sum / 100);
				$after_tax = sprintf('%.2f',round(($gross * $sum_tax),2));
				$tax_string = substr_replace($tax_string, "", 0,1);
				echo $tax_string;
				?>] = <span class="addOnTax"><?php echo $tax_sum;?></span>%
				</li>
				<li><strong>Gross:</strong> $<span class="addonGross"></span><?php echo $gross;?></li>
				<li><strong>After Tax:</strong> $<span><?php echo $after_tax;?></span></li>
			</ul>
			<input class="addOn_id" ticket_id="<?php echo $id;?>" type="hidden" name="data[Package][add_ons][<?php echo $id;?>][id]" value="<?php echo $id;?>"/>			
			<input class="addOn_name" type="hidden" name="data[Package][add_ons][<?php echo $id;?>][name]" value="<?php echo $name;?>"/>
			<input class="addOn_gross" type="hidden" name="data[Package][add_ons][<?php echo $id;?>][gross]" value="<?php echo $gross;?>"/>
			<input class="addOn_type" type="hidden" name="data[Package][add_ons][<?php echo $id;?>][type]" value="<?php echo $type;?>"/>
			<input class="addOn_tax_string" type="hidden" name="data[Package][add_ons][<?php echo $id;?>][tax_string]" value="<?php echo $tax_string;?>"/>
			<input class="addOn_tax_sum" type="hidden" name="data[Package][add_ons][<?php echo $id;?>][tax_sum]" value="<?php echo $tax_sum;?>"/>
			<input class="addOn_aftertax" type="hidden" name="data[Package][add_ons][<?php echo $id;?>][after_tax]" value="<?php echo $after_tax;?>"/>
	</li>
	<?php

}

if($_REQUEST['type']=='GET_DEPART_TIMES' && $_REQUEST['date'] && $_REQUEST['port']){
	?>
	<option value="No">select depart time</option>
	<?php
	foreach ($trip_times as $key => $value) {
		
		?>
		<option value="<?php echo $value;?>"><?php echo $value;?></option>
		<?php
	}
	
}
if($_REQUEST['type']=='GET_RETURN_TIMES' && $_REQUEST['date'] && $_REQUEST['port']){
	?>
	<option value="No">select return time</option>
	<?php
	foreach ($trip_times as $key => $value) {
		
		?>
		<option value="<?php echo $value;?>"><?php echo $value;?></option>
		<?php
	}
	
}

?>