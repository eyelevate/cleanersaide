<?php


?>

<div class="inventory view">
<h2><?php echo __('Inventory Items'); ?></h2>

<div class="inventory_items index form-actions">
	<legend><?php  echo h($inventory['Inventory']['name']); ?></legend>
	<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('inc_units');?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($inventory_items as $inv): ?>
	<tr>
		<td><?php echo h($inv['Inventory_item']['type']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['name']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['description']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['inc_units']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['created']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('controller'=>'inventory_items','action' => 'view', $inv['Inventory_item']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('controller'=>'inventory_items','action' => 'edit', $inv['Inventory_item']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('controller'=>'inventory_items','action' => 'delete', $inv['Inventory_item']['id']), null, __('Are you sure you want to delete # %s?', $inv['Inventory_item']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled btn'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled btn'));
	?>
	</div>
</div>

<?php
echo $this->Html->link('Back To Inventory',array('controller'=>'inventories','action'=>'index'),array('class'=>'btn btn-large', 'style'=>'margin-right:15px;'));
echo $this->Html->link('Add '. $inventory['Inventory']['name'].' Inventory',array('controller'=>'inventory_items','action'=>'add'),array('class'=>'btn btn-primary btn-large'));
?>
</div>