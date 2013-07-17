<?php
//debug($hotel_count);

if($vouchers){

?>
	<h3>Vouchers</h3>
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>BBFL Confirmation</th>
				<th>Hotel Confirmation</th>
				<th>Name</th>
				<th>Printed?</th>
				<th class="actions">Actions</th>
			</tr>			
		</thead>

		<tbody id="voucherHotelTbody">
		<?php 
			foreach ($vouchers as $v): 
				?>
				<tr>
					<td><?php echo $v['bbfl_confirmation'];?> &nbsp;</td>
					<td><?php echo $v['hotel_confirmation'];?> &nbsp;</td>
					<td><?php echo $v['name']; ?>&nbsp;</td>
					<td><?php echo $v['printed']; ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Print'), array('controller'=>'reports','action' => 'request_voucher_pdf', $v['reservation_id']), array('class' => 'btn btn-mini' )); ?>
						<?php echo $this->Html->link(__('View Reservation'), array('controller'=>'reservations','action' => 'view', $v['reservation_id']), array('class' => 'btn btn-mini' )); ?>
					</td>
				</tr>
		<?php endforeach; ?>		
		</tbody>
	</table> 
<?php
} else {
	?>
	<p>There are no reservations with hotels or attractions for this period.</p>
	<?php
}
?>