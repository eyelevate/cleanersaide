<?php
	if(count($results)>0){
		foreach ($results as $key => $value) {
			$schedule_id = $key;
			$time = $value;
			?>
			<option value="<?php echo $time;?>"><?php echo $time;?></option>
			<?php
		}
	} else {
		?>
		<option value="No">None Found</option>
		<?php
	}
?>