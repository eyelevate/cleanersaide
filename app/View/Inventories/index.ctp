<?php



?>
<div class="vehicles index">
	<h2><?php echo __('Inventory Types'); ?></h2>
	<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('description');?></th>
		<th><?php echo $this->Paginator->sort('created');?></th>
		<th><?php echo $this->Paginator->sort('modified');?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($inventories as $inventory): 

	?>
	<tr>
		<td><?php echo h($inventory['Inventory']['name']); ?>&nbsp;</td>
		<td><?php echo h($inventory['Inventory']['description']); ?>&nbsp;</td>
		<td><?php echo h($inventory['Inventory']['created']); ?>&nbsp;</td>
		<td><?php echo h($inventory['Inventory']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $inventory['Inventory']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $inventory['Inventory']['id']), null, __('Are you sure you want to delete %s?', $inventory['Inventory']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<div class="formRow">
		<?php
		echo $this->Html->link('Add Inventory',array('action'=>'add'),array('class'=>'btn btn-primary btn-large pull-right'));	
		?>
	</div>
	<p>
	<?php
	//echo $this->Paginator->counter(array(
	//'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	//));
	?>	</p>

	<div class="paging">
	<?php
	//	echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled btn btn-small'));
	//	echo $this->Paginator->numbers(array('separator' => ''));
	//	echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled btn btn-small'));
	?>
	</div>
</div>
