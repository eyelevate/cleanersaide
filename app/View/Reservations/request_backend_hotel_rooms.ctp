<?php
foreach ($room_rates as $room) {
	$room_id = $room['room_id'];
	$blackout = $room['blackout'];
	$room_count = $room['room_count'];
	$blackout_string = $room['blackout_dates'];
	$bs_count = count($blackout_string);
	$room_name = $room['room_name'];
	$room_desc = $room['room_desc'];
	if($room['room_primary_image'] ==''){
		$room_primary_image = 'http://placehold.it/150x150';
	} else {
		$room_primary_image = "/img/hotels/".$room['room_primary_image'];
	}		
	$occupancy_base = $room['occupancy_base'];
	$occupancy_max = $room['occupancy_max'];
	$add_ons = $room['add-ons'];
	if(is_null($add_ons)){
		$add_on_select = 'No';
	} else {
		$add_on_select = 'Yes';
	}
	$plus_net = $room['plus_net'];
	$plus_fee = $room['plus_fee'];
	$taxes = $room['taxes'];
	$total_taxes = 0;
	if(isset($taxes)){
		foreach ($taxes as $key => $value) {
			$tax_code = $key;
			$total_taxes = $total_taxes+$value;
		}
	}
	$total_tax = ($total_taxes / 100);
	$tax_rate= $room['tax_rate'];
	$status	 = $room['status'];
	if(!empty($room['rates'])){
		$rates = $room['rates'];	
	} else {
		$rates = array();
	}
	
	$min_occupancy_text = '<strong>Base Occupancy:</strong> '.$occupancy_base;
	$max_occupancy_text = '<strong>Max Occupancy:</strong> '.$occupancy_max;
	$extra_person_text = '<strong>Extra Person Fee:</strong> $'.sprintf('%.2f',$plus_fee).' per night';

	?>
	<li id="roomLi-<?php echo $room_id;?>" class="roomLi well well-small" style="padding:10px; border-bottom: 1px dashed #aaa;" >
		<div class="clearfix" style="margin-bottom:5px;">
			<!-- <div class="pull-left" style="width:15%">
				<a class="colorbox" style="height:100%;">
					<img class="media-object img-border" src="<? echo $room_primary_image; ?>" style="width:150px;"/>
				</a>					
			</div> -->
			<div class="pull-left">
				<h4 class="media-heading"><strong><?php echo $room_name;?></strong></h4>
				<p><?php echo $room_desc;?></p>
			</div>
		</div>

		
		<div class="clearfix">
			<?php
			//create total summary data
			$adults = $_REQUEST['adults'];
			$children = $_REQUEST['children'];
			if($children == ''){
				$children = 0;
			}
			$total_occupants = $adults + $children;
			$min_rooms = ceil($total_occupants / $occupancy_base);
			$max_rooms = ceil($total_occupants / $occupancy_max);
			$extra_fee_multiplier = $adults - ($room_count * $occupancy_base);					
			?>
			<div class="well well-small clearfix">
			<?php
			
			
			if(count($rates)>0){
				$avg_gross = 0;
				$avg_net = 0;
				$nights = 0;
				$available= 0;
				$total_gross = 0;
				$total_net = 0;
				foreach ($rates as $rkey =>$rvalue) {
					$nights++;
					$check_in = strtotime($rkey);
					$cutoff = $rvalue['cutoff'];
					$blackout_date_check = $rvalue['date'];
					$date = strtoupper(date('D n/d',$rvalue['date']));
					$net = $rvalue['net'];
					$gross = sprintf('%.2f',$rvalue['gross']);
					$extra_person_fee_nightly = sprintf('%.2f',round($extra_fee_multiplier * $plus_fee,2));
					$grossPlusFee = sprintf('%.2f',($gross + $extra_person_fee_nightly)*(1+$total_tax)); //now includes tax, JFD 4.17
					$total_gross = $total_gross + $gross;
					$avg_gross = $avg_gross + $gross;
					$avg_net = $avg_net + $net;
					$reserved = $rvalue['reserved'];
					$new_reserved = $reserved + $room_count;
					$total_rooms = $rvalue['total_rooms'];
					$markup = $rvalue['markup'];
					if($new_reserved > $total_rooms || ($adults + $children) > ($room_count * $occupancy_max)) {
						$available  = $available + 1;
						$text_color = 'error';
						$price_text = '';
						$available_text = '<label>Not Available</label>';
					} else {
						$price_text = '<p style="margin:0px">$'.$grossPlusFee.'</p>';
						$available_text = '<label class="label label-success">Available</label>';
						$text_color = '';
					}							
					if($bs_count > 0){
						foreach ($blackout_string as $key => $value) {
							
							if(date('Y-m-d',$value) == date('Y-m-d',$blackout_date_check)){

								$available  = $available + 1;
								$text_color = 'error';
								$price_text = '';
								$available_text = '<label>Not Available</label>';

							} 

						}

					}
					if($check_in < $cutoff){
						$price_text = '';
						$text_color = 'error';	
						$available_text = '<label>Past Cutoff</label>';
											
					}

					?>
					<div class="control-group <?php echo $text_color;?> well well-small pull-left" style="width:65px; height: 55px; margin:0px; text-align:center">
						<label><?php echo $date;?></label>
						<?php echo $price_text;?>
						<?php echo $available_text;?>
					</div>
					<?php
				
				}	

				//$extra_fee_multiplier = $total_occupants - ($room_count * $occupancy_base); JFD 3.26 1:47PM
				$total_extra_fee = sprintf('%.2f',round(($extra_fee_multiplier * $plus_fee)*$nights,2));	
				if($total_extra_fee < 0){
					$total_extra_fee = '0.00';
				}

				$total_net = sprintf('%.2f',round(($total_gross*$room_count)+$total_extra_fee,2));
				$total_gross = sprintf('%.2f',round($total_net*(1+$total_tax),2));//now includes tax, JFD 4.17
				
				$sum_tax = sprintf('%.2f',$total_gross - $total_net);
				$avg_gross = sprintf('%.2f',round(($total_gross+$total_extra_fee) / $nights,2));

				$removeBookNow = 'No';
			} else {
				$avg_gross = '0.00';
				$total_gross = '0.00';
				$available=0;
				$removeBookNow = 'Yes';
			?>
			<label class="label label-important">No rates available yet for these days</label>
			<?php
			}				
			?>	
			
			</div>

			<?php
			if($add_on_select == "Yes"){
			?>
			<label style="clear:both;">Choose room add-ons:</label>
			<?php
			} 
			?>							
		</div>
		<?php
			
			if($removeBookNow == 'No'){
			?>
			
			
			<div>
				
				<ul class="unstyled">
					<?php
					if($available==0){
					?>
					<div style="">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>PER NIGHT AVG. (inc. taxes)</th>
									<th>TOTAL (inc. taxes)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><span>$<?php echo $avg_gross;?></span></td>
									<td><span>$<?php echo $total_gross;?></span></td>
								</tr>
							</tbody>				
						</table>						
					</div>
					<li>
						<button id="bookRoom-<?php echo $room_id;?>" class="bookRoom btn btn-success btn-block" type="button" base="<?php echo $occupancy_base;?>" max="<?php echo $occupancy_max;?>" >SELECT ROOM</a>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
			<?php
			}
			?>
			<input type="hidden" value="<?php echo $room_id;?>" name="data[Reservation][room_id]"/>
			<input type="hidden" value="<?php echo $total_gross;?>" name="data[Reservation][total]"/>
	</li>					
	<?php
}	
?>