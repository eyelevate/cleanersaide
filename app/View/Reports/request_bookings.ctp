<? //debug($rooms); 

if($hotels_overview){

?>
	<h3>Hotels Summary</h3>
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Total Reservations Booked</th>
				<th>Total Nights Booked</th>
				<th>Average Stay</th>
			</tr>			
		</thead>

		<tbody id="">
		<?php 
			foreach ($hotels_overview as $ho): 
				if (!$ho['booking_count']) {continue;}
				?>
				<tr>
					<td><?php echo $ho['name'];?> &nbsp;</td>
					<td><?php echo $ho['booking_count'];?> &nbsp;</td>
					<td><?php echo $ho['night_count'];?> &nbsp;</td>
					<td><?php if ($ho['booking_count']) {echo round($ho['night_count'] / $ho['booking_count'], 2);?> nights&nbsp;<?}?></td>
				</tr>
		<?php endforeach; ?>		
		</tbody>
	</table> 
<?php
} else {
	?>
	<p>Doesn't seem to be any hotels here. Check to make sure your inputs are correct... or maybe nothing was booked in this time period.</p>
	<?php
}

if($attractions_overview){
?>
	<h3>Attractions Summary</h3>
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Total Reservations Booked</th>
			</tr>			
		</thead>

		<tbody id="">
		<?php 
			foreach ($attractions_overview as $ao): 
				if (!$ao['booking_count']) {continue;}
				?>
				<tr>
					<td><?php echo $ao['name'];?> &nbsp;</td>
					<td><?php echo $ao['booking_count'];?> &nbsp;</td>
				</tr>
		<?php endforeach; ?>		
		</tbody>
	</table> 
<?php
} else {
	?>
	<p>Doesn't seem to be any attractions here. Check to make sure your inputs are correct... or maybe nothing was booked in this time period.</p>
	<?php
}

?>