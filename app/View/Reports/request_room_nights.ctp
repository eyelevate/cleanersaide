<? //debug($rooms); 

if($rooms){

?>
	<!-- <h3>Room Night Report</h3> -->
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>Room Name</th>
				<th>Nights Booked</th>
			</tr>			
		</thead>

		<tbody id="voucherHotelTbody">
		<?php 
			foreach ($rooms as $r): 
				?>
				<tr>
					<td><?php echo $r['name'];?> &nbsp;</td>
					<td><?php echo $r['count'];?> &nbsp;</td>
				</tr>
		<?php endforeach; ?>		
		</tbody>
	</table> 
<?php
} else {
	?>
	<p>Doesn't seem to be anything here. Did you select a date and hotel?</p>
	<?php
}
?>