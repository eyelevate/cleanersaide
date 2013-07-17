
		<h1 style="text-align: center;">Passenger Check-in Sheet</h1>
		<h2 style="text-align: center; margin-bottom: 20px;"><? echo date ('M d, Y', strtotime($schedule[0]['Schedule']['service_date'])); ?> | <? echo $schedule[0]['Schedule']['depart_time']; ?> | Departing: <? echo $schedule[0]['Schedule']['departs']; ?></h2>	
		
		<table class="table table-striped table-bordered">
			<thead>
				<tr style="font-weight: bold;">
					<td>Name</td>
					<td>Contents</td>
					<td>Confirmation</td>
					<td>Type</td>
					<td>Adults</td>
					<td style="width:50px;">Child (5-11)</td>
					<td style="width:50px;">Child (Under 5)</td>
					<td>Roundtrip?</td>
					<td>Leg</td>
					<td style="width:300px;">Signature</td>
				</tr>
			</thead>
			<tbody>
				

				
				<? 
				
				
				//debug($ferry);
				//exit();
				
				foreach ($ferry as $f) {
					
			if ($f['Ferry_reservation']['schedule_id1'] == $schedule[0]['Schedule']['id'] ) {
				if ($f['Ferry_reservation']['status_depart'] != "1") {continue;}
			} elseif ($f['Ferry_reservation']['schedule_id2'] == $schedule[0]['Schedule']['id'] ) {
				if ($f['Ferry_reservation']['status_return'] != "1") {continue;}
			}
					
					// var_dump($f);
					// echo "<br>";
					// var_dump(json_decode($f['Ferry_reservation']['vehicles'], true));
					// echo "<br><br>";
						
						//$vehicles = json_decode($f['Ferry_reservation']['vehicles'], true);
						//foreach ($vehicles as $v){
						$v = json_decode($f['Ferry_reservation']['vehicles'], true);
						
						
						
						if ($f['Ferry_reservation']['vehicle_count'] == 0 || $f['Ferry_reservation']['vehicles'] == "0" || $v[0]['item_id'] == 28) {
							
							
						?>
						<tr>
							<td><? echo $f['Ferry_reservation']['last_name'] . ", " . $f['Ferry_reservation']['first_name'] ;?></td>
							<td><? echo $f['Ferry_reservation']['contents']; ?></td>
							<td><? echo $f['Ferry_reservation']['confirmation']; ?></td>
							<td><? if ( $v[0]['item_id'] == 28 ) {echo $f['Ferry_reservation']['vehicle_count'] . " bicycle(s)";} else {echo "Passenger";} ?></td>
							<td><? echo ($f['Ferry_reservation']['adults']); ?></td>
							<td><? echo $f['Ferry_reservation']['children']; ?></td>
							<td><? echo $f['Ferry_reservation']['infants']; ?></td>
							<td><? echo $f['Ferry_reservation']['trip_type']; ?></td>
							<td><? echo $f['Ferry_reservation']['leg']; ?></td>
							<td></td>
						</tr>
						<?	
						}					

					
					//}
				} ?>
				
				
				
<!-- 				<tr>
					<td>Driftmier, John</td>
					<td>000186AS</td>
					<td>Standard Vehicle</td>
					<td>None</td>
					<td>18</td>
					<td>1</td>
					<td>2</td>
					<td>0</td>
					<td>1</td>
				</tr> -->
			</tbody>
		</table>