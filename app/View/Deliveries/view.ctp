<?php

?>
<div class="row-fluid">
	<div class="formRow">
		<?php
		if(count($routes) >0){
		?>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Weekday</th>
					<th>Delivers</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Limit</th>
					<th>Zipcodes</th>
					<th>Blackouts</th>
					<th>Action(s)</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($routes as $key => $value) {
					
					?>
					<tr>
						<th colspan="8" style="text-align:center; font-size:larger; weight:bolder; text-decoration: underline"><?php echo $key;?></th>
					</tr>
					<?php
					foreach ($value as $rkey => $rvalue) {
						$id = $rvalue['id'];
						switch($rkey){
							case '0':
								$weekday = 'Monday';
							break;
							case '1':
								$weekday = 'Tuesday';
							break;
							case '2':
								$weekday = 'Wednesday';
							break;
							case '3':
								$weekday = 'Thursday';
							break;
							case '4':
								$weekday = 'Friday';
							break;
							case '5':
								$weekday = 'Saturday';
							break;
							default:
								$weekday = 'Sunday';
							break;
						}
						$name = $rvalue['name'];
						$limit = $rvalue['limit'];
						$start_time = $rvalue['start_time'];
						$end_time = $rvalue['end_time'];
						$zipcode = $rvalue['zipcode'];
						$zipcode_list = '<ul>';
						if(count($zipcode)>0){
							foreach ($zipcode as $zkey => $zvalue) {
								$zipcode_list .= '<li>'.$zvalue.'</li>';
							}
						}
						$zipcode_list .= '</ul>';
						$blackout = $rvalue['blackout'];
						$blackout_list = '<ul>';
						if(count($blackout)>0){
							foreach ($blackout as $bkey => $bvalue) {
								$blackout_list .= '<li>'.date('n/d/Y',strtotime($bvalue)).'</li>';
							}
						}
						$blackout_list .= '</ul>';

						if(count($zipcode)>0){
							$delivers = 'Yes';
						} else {
							$delivers = 'No';
						}
						?>
						<tr>
							<td><?php echo $weekday;?></td>
							<td><?php echo $delivers;?></td>
							<td><?php echo $start_time;?></td>
							<td><?php echo $end_time;?></td>
							<td><?php echo $limit;?></td>
							<td><?php echo $zipcode_list;?></td>
							<td><?php echo $blackout_list;?></td>
							<td><a href="/deliveries/edit/<?php echo $id;?>">Edit</a> <a href="/deliveries/delete/<?php echo $id;?>">Delete</a></td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
			
		</table>
		
		<?php
		} else {
			?>
			<p class="alert alert-error">There are no delivery routes set. Please create a delivery route.</p>
			<?php
		}
		?>
	</div>
</div>