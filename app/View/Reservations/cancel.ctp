<?php

$count_ferry = count($ferry_content);
$count_hotels = count($hotel_content);
$count_attractions = count($attraction_content);
$count_packages = count($package_content);
$total_refund = 0; //gets every refund including ferry, hotels, attractions, packages
$total_ferry_refund = 0; //gets the total ferry refund
$total_units = 0; // gets total units
$total_overlength = 0; //gets total overlength
$total_hotel_cost = 0; //gets total hotel refund
$total_hotel_rooms = 0; //gets total hotel rooms
$total_attraction_cost = 0; // gets total attraction cost
$total_attraction_refund = 0; //gets total attractgion refund

//post data sent via controller
foreach ($cancel as $key => $value) {
	$type = $cancel['type'];
}

//set ferry refund content
if($count_ferry>0){
	foreach ($ferry_content as $key => $value) {
		$ferry_id = $key;
		$vehicles = json_decode($ferry_content[$key]['vehicles'],2);
		$refund_ferry = $ferry_content[$key]['ferry_refund'];
		//get the total refund for ferries
		$total_refund = $total_refund + $refund_ferry;
	}
}
if($count_hotels>0){
	//set hotel refund content
	foreach ($hotel_content as $key => $value) {


	}
}
if($count_attractions>0){
	//set attraction refund content
	foreach ($attraction_content as $key => $value) {
		
	}
}

?>

<div class="row-fluid">
	<legend>Refund Confirmation </legend>	
	<?php
	if($count_ferry > 0):
	?>	
	<div class="well well-small">	
		<legend>Ferry</legend>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Departs</th>
					<th>Date</th>
					<th>Time</th>
					<th>Inventory</th>
					<th>Drivers</th>
					<th>Adults (12+)</th>
					<th>Child (5-11)</th>
					<th>Child (0-4)</th>
					<th>Units</th>
					<th>Overlength</th>
					<th style="width:150px">Refund</th>
				</tr>
			</thead>
			<tbody>
				<?php				
				foreach ($ferry_content as $fckey =>$fcvalue) {
					$ferry_drivers = $ferry_content[$key]['vehicle_count'];
					$ferry_adults = $ferry_content[$key]['adults'];
					$ferry_children = $ferry_content[$key]['children'];
					$ferry_infants = $ferry_content[$key]['infants'];
					$depart_port = $ferry_content[$key]['depart_port'];
					$depart_time = $ferry_content[$key]['depart_time'];
					$depart_date = $ferry_content[$key]['depart_date'];
					$ferry_refund = $ferry_content[$key]['ferry_refund'];
					$ferry_total = $ferry_content[$key]['ferry_total'];
				?>
				<tr>
					<td><?php echo $depart_port;?></td>
					<td><?php echo $depart_date;?></td>
					<td><?php echo $depart_time;?></td>
					<td>
						<ul>
						<?php
						foreach ($vehicles as $v) {
							$item_id = $v['item_id'];
							$vehicle_name = $v['name'];
							$overlength = $v['overlength'];
							$total_overlength = $total_overlength + $overlength;
		
							switch ($item_id) {
								case '23':
									$inventory_removed = sprintf('%.2f',round($overlength / 18,2));
									?>
									<li><?php echo $vehicle_name.' ('.$overlength.' feet)';?></li>
									<?php
									break;
								
								default:
									$inventory_removed = sprintf('%.2f',1);
									?>
									<li><?php echo $vehicle_name;?></li>
									<?php
									break;
							}
		
							$total_units = $total_units + $inventory_removed;
							
						}		
						?>					
						</ul>
					</td>
					<td><?php echo $ferry_drivers;?></td>
					<td><?php echo $ferry_adults;?></td>
					<td><?php echo $ferry_children;?></td>
					<td><?php echo $ferry_infants;?></td>
					<td><?php echo $total_units;?></td>
					<td><?php echo $total_overlength;?></td>
					<td>$<?php echo $ferry_refund;?></td>
				</tr>
				<?php
				}
				//sum up the total ferry to be returned
				$total_ferry_refund = $total_ferry_refund + $ferry_refund;
				
				?>							

			</tbody>
			<tfoot>
				<tr>
					<th colspan="7"  style="border-top:1px solid #5e5e5e;"></th>
					<th style="border-top:1px solid #5e5e5e;">Totals:</th>
					<th style="border-top:1px solid #5e5e5e;"><?php echo $total_units;?></th>
					<th style="border-top:1px solid #5e5e5e;"><?php echo $total_overlength;?></th>
					<th style="border-top:1px solid #5e5e5e;">$<?php echo sprintf('%.2f',round($total_ferry_refund,2));?></th>
				</tr>
			</tfoot>
		</table>
		<?php
		endif;
		if($count_hotels>0):
		?>	
		<div class="formRow">
			<legend>Hotel</legend>
			<table class="table table-bordered">
				<tr>
					<thead>
						<tr>
							<th>Hotel</th>
							<th>Room</th>
							<th>Qty</th>
							<th>Check In</th>
							<th>Check Out</th>
							<th>Adults</th>
							<th>Children</th>
							<th width="150px">Paid Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php

						foreach ($hotel_content as $hkey =>$hvalue) {
							$hotel_name = $hotel_content[$hkey]['hotel_name'];
							$room_name = $hotel_content[$hkey]['room_name'];
							$room_count = $hotel_content[$hkey]['room_count'];
							$check_in = $hotel_content[$hkey]['check_in'];
							$check_out = $hotel_content[$hkey]['check_out'];
							$adults = $hotel_content[$hkey]['adults'];
							$children = $hotel_content[$hkey]['children'];
							$hotel_total = $hotel_content[$hkey]['total'];
							$hotel_refund = $hotel_content[$hkey]['total_refund'];
							$total_hotel_rooms = $total_hotel_rooms + $room_count;
							$total_hotel_cost = $total_hotel_cost + $hotel_total;
							$total_refund = $total_refund + $hotel_refund;
						?>
						<tr>
							<td><?php echo $hotel_name;?></td>
							<td><?php echo $room_name;?></td>
							<td><?php echo $room_count;?></td>
							<td><?php echo $check_in;?></td>
							<td><?php echo $check_out;?></td>
							<td><?php echo $adults;?></td>
							<td><?php echo $children;?></td>
							<td>$<span><?php echo $hotel_total;?></span></td>
						</tr>					
						<?php	
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="6" style="border-top:1px solid #5e5e5e"></th>
							<th style="border-top:1px solid #5e5e5e">Room Count</th>
							<th style="border-top:1px solid #5e5e5e"><?php echo $total_hotel_rooms;?></th>
						</tr>
						<tr>
							<th colspan="6"  style="border-top:none"></th>
							<th>Total</th>
							<th>$<span><?php echo $total_hotel_cost;?></span></th>
						</tr>
					</tfoot>
				</tr>	
			</table>
	
		</div>
		<?php	
		endif; 
		if($count_attractions>0):
		?>
		<div class="formRow">
			<legend>Attractions</legend>
			<table class="table table-bordered">
				<tr>
					<thead>
						<tr>
							<th>Attraction</th>
							<th>Tour</th>
							<th>Tour Date</th>
							<th>Time Ticket</th>
							<th>Tour Time</th>
							<?php
							$count_attraction_th = 6;
							foreach ($attraction_content as $akey =>$avalue) {
								$age_range = $attraction_content[$akey]['age_range'];
								if(count($age_range)>0){
									foreach ($age_range as $key => $value) {
										$count_attraction_th++;
										$age_range_name = $age_range[$key]['name'];
									?>
									<th><?php echo $age_range_name;?></th>
									<?php
									}
								}
	
							}
							?>
							<th width="150px">Paid Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($attraction_content as $akey =>$avalue) {
							$attraction_name = $attraction_content[$akey]['attraction_name'];
							$tour_name = $attraction_content[$akey]['tour_name'];
							$tour_date = $attraction_content[$akey]['tour_date'];
							$attraction_total = $attraction_content[$akey]['total'];
							$attraction_refund = $attraction_content[$akey]['total_refund'];
							$total_attraction_refund = $total_attraction_refund + $attraction_refund;
							$total_attraction_cost = $total_attraction_cost + $attraction_total;
							$time_ticket = $attraction_content[$akey]['time_ticket'];
							$time = $attraction_content[$akey]['time'];
							$age_range = $attraction_content[$akey]['age_range'];
							$total_refund = $total_refund + $attraction_refund;
						?>
						<tr>
							<td><?php echo $attraction_name;?></td>
							<td><?php echo $tour_name;?></td>
							<td><?php echo $tour_date;?></td>
							<td><?php echo $time_ticket;?></td>
							<td><?php echo $time;?></td>
							<?php
							foreach ($attraction_content as $akey =>$avalue) {
								$age_range = $attraction_content[$akey]['age_range'];
								if(count($age_range)>0){
									foreach ($age_range as $key => $value) {
										$age_range_amount = $age_range[$key]['amount'];
									?>
									<td><?php echo $age_range_amount;?></td>
									<?php
									}
								}
	
							}
							?>
							<td>$<?php echo sprintf('%.2f',$total_attraction_cost);?></td>
						</tr>					
						<?php	
						}
						?>
					</tbody>
					<tfoot>
						<?php
						$attraction_colspan = $count_attraction_th - 2;
						?>
	
						<tr>
							<th colspan="<?php echo $attraction_colspan;?>"  style="border-top:1px solid #5e5e5e"></th>
							<th style="border-top:1px solid #5e5e5e">Total</th>
							<th style="border-top:1px solid #5e5e5e">$<span><?php echo sprintf('%.2f',$total_attraction_cost);?></span></th>
						</tr>
					</tfoot>
				</tr>	
			</table>
	
		</div>
		<?php		
			
		endif;
			
		
		if($count_packages>0):
			
		endif;
	
		?>
		<div class="formRow">
			<legend>Refund Summary</legend>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Summary Totals</th>
						<th width="150px">Totals</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if($count_ferry>0):
					?>
					<tr>
						<td>Ferry</td>
						<td>$<?php echo sprintf('%.2f',$refund_ferry);?></td>
					</tr>
					<?php
					endif;
					if($count_hotels>0):
					?>
					<tr>
						<td>Hotels</td>
						<td>$<?php echo sprintf('%.2f',$hotel_refund);?></td>
					</tr>
					<?php
					endif;
					if($count_attractions>0):
					?>
					<tr>
						<td>Attractions</td>
						<td>$<?php echo sprintf('%.2f',$total_attraction_refund);?></td>
					</tr>
					<?php
					endif;
					if($count_packages>0):
					?>
					<tr>
						<td>Packages</td>
						<td></td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
				<tfoot>
					<tr>
						<th style="border-top:1px solid #5e5e5e;">Refund Amount:</th>
						<th style="border-top:1px solid #5e5e5e;"><strong>$<?php echo sprintf('%.2f',$total_refund);?></strong></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="clearfix">
			<div class="pull-left" style="margin-right:10px;">
				<a href="/reservations/view/<?php echo $reservation_id;?>" class="btn btn-inverse">Go Back</a>
			</div>
			<div class="pull-left">
				<form action="/reservations/cancel_order/<?php echo $reservation_id;?>" method="post">
					<input type="hidden" value="<?php echo $type;?>" name="data[type]"/>
					<input type="hidden" value="<?php echo $total_refund;?>" name="data[total_refund]"/>
					<button class="btn btn-primary" type="submit">Confirm</button>
				</form>
			</div>			
		</div>

	</div>
</div>
<?php
$_SESSION['cancel']['Refund']['amount'] = $total_refund;
?>