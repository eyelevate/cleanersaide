<?php
//($tour_rates);
?>
<select class="tourSelect attractionEditable" name="data[Attraction_reservation][<?php echo $index;?>][tour_id]" edit="Yes">
	<option value="NONE">Select Tour</option>
	<?php
	foreach ($tour_rates as $key => $value) {
		foreach ($value as $at) {
			$blackout = $at['blackout'];
			$blackout_dates = $at['blackout_dates'];
			$tour_name = $at['tour_name'];
			$tour_id = $at['tour_id'];
			$timed_tour = $at['time_tour'];
			if($timed_tour == '' || empty($timed_tour)){
				$timed_tour = 'No';
				$time = 'No';
			}
			$tour_inventory = $at['tour_inventory'];
			if($timed_tour == 'Yes'){
			?>
			<optgroup label="<?php echo $tour_name;?>">
			<?php
			foreach ($tour_inventory as $tikey => $tivalue) {
				
				$time = $tikey;

				$edited_tour_name = $tour_name.' @ '.$time;
				if($edited_tour_name == $tour_selected){
					?>
					<option timed="Yes" value="<?php echo $tour_id;?>" time="<?php echo $time;?>" selected="selected"><?php echo $edited_tour_name;?></option>				
					<?php					
					} else {
					?>
					<option timed="Yes" value="<?php echo $tour_id;?>" time="<?php echo $time;?>"><?php echo $edited_tour_name;?></option>				
					<?php
				}

			}
			?>
			</optgroup>
			<?php	
			} else {
			if($tour_name == $tour_selected){
				?>
				<option timed="No" value="<?php echo $tour_id;?>" selected="selected"><?php echo $tour_name;?></option>
				<?php					
				} else {
				?>
				<option timed="No" value="<?php echo $tour_id;?>"><?php echo $tour_name;?></option>
				<?php					
			}
			
			}

		}
	}
	?>
</select>
<?php
//if there is a time tour then also add the hidden time element
	foreach ($tour_rates as $key => $value) {
		foreach ($value as $at) {
			$blackout = $at['blackout'];
			$blackout_dates = $at['blackout_dates'];
			$tour_name = $at['tour_name'];
			$tour_id = $at['tour_id'];
			$timed_tour = $at['time_tour'];
			if($timed_tour == '' || empty($timed_tour)){
				$timed_tour = 'No';
				$time = 'No';
			}
			$tour_inventory = $at['tour_inventory'];
			if($timed_tour == 'Yes'){

			foreach ($tour_inventory as $tikey => $tivalue) {
				
				$time = $tikey;

				$edited_tour_name = $tour_name.' @ '.$time;
				if($edited_tour_name == $tour_selected){
				?>
				<input class="attractionTourTime attractionEditable" edit="Yes" type="hidden" value="<?php echo $time;?>" name="data[Attraction_reservation][<?php echo $index;?>][time]"/>
				<?php
				}

			}

			} 

		}
	}
	?>