<?php

foreach ($reservations as $reservation) {
?>
<tr>
	<td><?php echo h($reservation['Reservation']['id']); ?>&nbsp;</td>
	<td><?php echo h($reservation['Reservation']['name']); ?>&nbsp;</td>
	<td><?php echo h($reservation['Reservation']['description']); ?>&nbsp;</td>
	<td><?php echo h($reservation['Reservation']['created']); ?>&nbsp;</td>
	<td><?php echo h($reservation['Reservation']['modified']); ?>&nbsp;</td>
	<td><?php echo h($reservation['Reservation']['status']); ?>&nbsp;</td>
	<td class="actions">
		<?php echo $this->Html->link(__('View'), array('action' => 'view', $reservation['Reservation']['id'])); ?>
		<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $reservation['Reservation']['id'])); ?>
		<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $reservation['Reservation']['id']), null, __('Are you sure you want to delete # %s?', $reservation['Reservation']['id'])); ?>
	</td>
</tr>
<?php		
}
?>