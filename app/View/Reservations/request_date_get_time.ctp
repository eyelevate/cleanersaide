<?php
	if(!empty($results)){
		if($results == 'empty'){
			?>
			<tr>
				<td colspan="2">No date selected</td>
			</tr>
			<?php										
		} else {
			foreach ($results as $key => $value) {
				$schedule_time = $key;
				foreach ($results[$key] as $akey => $avalue) {
					$schedule_id = $results[$key][$akey]['schedule_id']; 
					$inventory_id = $results[$key][$akey]['inventory_id']; 
					$inventory_name = $results[$key][$akey]['inventory_name'];
					$label = $results[$key][$akey]['label'];
		
				}
			?>
			<tr <? if (strpos($label,'success') !== false) {?>class="pointer touch"<? } else {?>class="noTouch"<?}?> schedule_id ="<?php echo $schedule_id;?>" inventory_id="<?php echo $inventory_id;?>" >
				<td><?php echo $schedule_time;?></td>
				<td><?php echo $label;?></td>
			</tr>
			<?php
			}
		}
	} else {
		?>
		<tr class="noTouch">
			<td >Not In Service</td>
			<td><span class="label label-important">No Service</span></td>
		</tr>
		<?php
	}

?>