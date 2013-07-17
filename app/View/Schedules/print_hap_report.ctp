
		<h1 style="text-align: center;">HAP Report</h1>
		<h2 style="text-align: center; margin-bottom: 20px;"><? echo date ('M d, Y', strtotime($schedule[0]['Schedule']['service_date'])); ?> | <? echo $schedule[0]['Schedule']['depart_time']; ?> | Departing: <? echo $schedule[0]['Schedule']['departs']; ?></h2>
				
		<table class="table table-striped table-bordered">
			<thead>
				<tr style="font-weight: bold;">
					<td>Name</td>
					<td>Confirmation</td>
					<td>Contents</td>
				</tr>
			</thead>
			<tbody>
				<? foreach ($ferry as $f) {
					
						if ($f['Ferry_reservation']['schedule_id1'] == $schedule[0]['Schedule']['id'] ) {
							if ($f['Ferry_reservation']['status_depart'] != "1") {continue;}
						} elseif ($f['Ferry_reservation']['schedule_id2'] == $schedule[0]['Schedule']['id'] ) {
							if ($f['Ferry_reservation']['status_return'] != "1") {continue;}
						}

						if ($f['Ferry_reservation']['contents']) {
						?>
						<tr>
							<td><? echo $f['Ferry_reservation']['last_name'] . ", " . $f['Ferry_reservation']['first_name'] ;?></td>
							<td><? echo $f['Ferry_reservation']['confirmation']; ?></td>
							<td><? echo $f['Ferry_reservation']['contents']; ?></td>
						</tr>
						<?						

					
					}
				} ?>
				
			</tbody>
		</table>