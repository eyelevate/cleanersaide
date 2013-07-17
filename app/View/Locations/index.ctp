<?php

?>
<div class="row-fluid">
	
	<h3 class="heading">Locations</h3>
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>

				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('city'); ?></th>
				<th><?php echo $this->Paginator->sort('state'); ?></th>
				<th><?php echo $this->Paginator->sort('country'); ?></th>
				<th><?php echo $this->Paginator->sort('created'); ?></th>
				<th><?php echo $this->Paginator->sort('modified'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($locations as $location) {
			?>
			<tr>
				<td><?php echo $location['Location']['name'];?></td>
				<td><?php echo $location['Location']['city'];?></td>
				<td><?php echo $location['Location']['state'];?></td>
				<td><?php echo $location['Location']['country'];?></td>
				<td><?php echo $location['Location']['created'];?></td>
				<td><?php echo $location['Location']['modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $location['Location']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $location['Location']['id']), null, __('Are you sure you want to delete?')); ?>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<p class="muted">
	<?php
	//echo $this->Paginator->counter(array(
	//'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	//));
	?>	</p>

	<div class="paging">
	<?php
	//	echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled btn'));
	//	echo $this->Paginator->numbers(array('separator' => ''));
	//	echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled btn'));
	?>
	</div>
</div>