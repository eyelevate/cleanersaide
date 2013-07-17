
		<h1 style="text-align: center;">Vehicle Check-in Sheet</h1>
		<h2 style="text-align: center; margin-bottom: 20px;"><? echo date ('M d, Y', strtotime($schedule[0]['Schedule']['service_date'])); ?> | <? echo $schedule[0]['Schedule']['depart_time']; ?> | Departing: <? echo $schedule[0]['Schedule']['departs']; ?></h2>
		
		
		
		<? 
		$regular_count = 0;
		$regular_units = 0;
		$oversize_count = 0;
		$oversize_units = 0;
		$motorcycle_count = 0;
		$motorcycle_units = 0;
		
		//var_dump($ferry);
		//echo "test";
		
		foreach ($ferry as $f) {
			
			//var_dump(json_decode('[{"item_id":"23","name":"Vehicle or Vehicle with Towed Unit (over 18 feet)","oneway":"42.50","surcharge":"0.00","total_price:"42.50"}]', true));
				//var_dump($f['Ferry_reservation']['vehicles']);  
				//var_dump(json_last_error('[{"item_id":"23","name":"Vehicle or Vehicle with Towed Unit (over 18 feet)","oneway":"42.50","surcharge":"0.00","total_price:"42.50","overlength":34,"overlength_net":16,"towed_unit":"Unspecified overlength"}]'));
				//echo "<br><br>";	
			
			//exit();
			
			
			if ($f['Ferry_reservation']['schedule_id1'] == $schedule[0]['Schedule']['id'] ) {
				if ($f['Ferry_reservation']['status_depart'] != "1") {continue;}
			} elseif ($f['Ferry_reservation']['schedule_id2'] == $schedule[0]['Schedule']['id'] ) {
				if ($f['Ferry_reservation']['status_return'] != "1") {continue;}
			}
			
			$vehicles = json_decode($f['Ferry_reservation']['vehicles'], true);
			
			//debug($vehicles);
			
			foreach ($vehicles as $v){		
				switch ($v['item_id']) {
					case 22:
						$regular_count++;
						$regular_units++;
						break;
					
					case 23:
						$oversize_count++;
						$oversize_units += ($v['overlength'] / 18);
						break;
					
					case 28:
						break;
					
					default:
						$motorcycle_count++;
						$motorcycle_units++;
						break;
				}
			}
		}
		?>
		
		<table class="table table-bordered">
			<thead>
				<tr style="font-weight: bold">
					<td>Vehicle Category</td>
					<td>Number of Reservations</td>
					<td>Number of Units</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Regular Vehicle</td>
					<td><? echo $regular_count; ?></td>
					<td><? echo $regular_units; ?></td>
				</tr>
				<tr>
					<td>Oversize Vehicle</td>
					<td><? echo $oversize_count; ?></td>
					<td><? echo round($oversize_units, 1); ?></td>
				</tr>
				<tr>
					<td>Motorcycle</td>
					<td><? echo $motorcycle_count; ?></td>
					<td><? echo $motorcycle_units; ?></td>
				</tr>
			</tbody>
		</table>	
		
		<table class="table table-striped table-bordered">
			<thead>
				<tr style="font-weight: bold;">
					<td>Name</td>
					<td>Contents</td>
					<td>Confirmation</td>
					<td>Vehicle Type</td>
					<td>Towing</td>
					<td>Length</td>
					<td>Units</td>
					<td>Adults</td>
					<td>Child (5-11)</td>
					<td>Child (Under 5)</td>
				</tr>
			</thead>
			<tbody>
				<? foreach ($ferry as $f) {
			
			// get rid of canceled reservations	
			if ($f['Ferry_reservation']['schedule_id1'] == $schedule[0]['Schedule']['id'] ) {
				if ($f['Ferry_reservation']['status_depart'] != "1") {continue;}
			} elseif ($f['Ferry_reservation']['schedule_id2'] == $schedule[0]['Schedule']['id'] ) {
				if ($f['Ferry_reservation']['status_return'] != "1") {continue;}
			}
					
					//debug(json_decode($f['Ferry_reservation']['vehicles'], true));
				
						$vehicles = json_decode($f['Ferry_reservation']['vehicles'], true);
						//debug($vehicles);
						foreach ($vehicles as $v){
							if ($v['item_id'] == 28) {continue;}
						//debug($f);
						?>
						<tr>
							<td><? echo $f['Ferry_reservation']['last_name'] . ", " . $f['Ferry_reservation']['first_name'] ;?></td>
							<td><? echo $f['Ferry_reservation']['contents']; ?></td>
							<td><? echo $f['Ferry_reservation']['confirmation']; ?></td>
							<td><? echo $v['name']; ?></td>
							<td><? if ( array_key_exists('towed_unit', $v) && $v['item_id'] != 22) {echo ($v['towed_unit']);} else {echo "";} ?></td>
							<td><? if ( $v['overlength'] == 0 ) {echo "18";} else {echo $v['overlength'];} ?></td>
							<td><? if ( $v['overlength'] == 0 ) {echo "1";} else {echo round($v['overlength'] / 18, 1);} ?></td>
							<td><? echo (1 + $f['Ferry_reservation']['adults']); ?></td>
							<td><? echo $f['Ferry_reservation']['children']; ?></td>
							<td><? echo $f['Ferry_reservation']['infants']; ?></td>
						</tr>
						<?						

					
					}
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