<?php

?>
<div class="row-fluid">
	
	<h3 class="heading">Tax Rates</h3>
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>

				<th><?php echo $this->Paginator->sort('country'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('rate'); ?></th>
				<th><?php echo $this->Paginator->sort('created'); ?></th>
				<th><?php echo $this->Paginator->sort('modified'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($taxes as $tax) {
			?>
			<tr>
				<td><?php echo $tax['Tax']['country'];?></td>
				<td><?php echo $tax['Tax']['name'];?></td>
				<td><?php echo $tax['Tax']['rate'];?></td>
				<td><?php echo $tax['Tax']['created'];?></td>
				<td><?php echo $tax['Tax']['modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tax['Tax']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tax['Tax']['id']), null, __('Are you sure you want to delete?')); ?>
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