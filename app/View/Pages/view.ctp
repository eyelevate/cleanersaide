<?php
//add scripts to header
echo $this->Html->script(array('events.js'),FALSE);

?>

<div class="admin-body-content span10">
<?php
//echo $this->Form->create('Page');
//echo $this->Form->input('search');
//echo $this->Form->submit('Search Pages');
//echo $this->Form->end();
?>
<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('keywords'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
	<?php
	foreach ($pages as $page): ?>
	<tr id="pageViewTr-<?php echo h($page['Page']['id']); ?>" class="pageViewTr">
		<td><?php echo h($page['Page']['url']); ?>&nbsp;</td>
		<td><?php echo h($page['Page']['title']); ?>&nbsp;</td>
		<td><?php echo h($page['Page']['keywords']);?>&nbsp;</td>
		<td><?php echo h($page['Page']['description']); ?>&nbsp;</td>
		<td><?php echo h($page['Page']['created']); ?>&nbsp;</td>
		<td><?php echo h($page['Page']['status']); ?>&nbsp;</td>
		<td class="tdactions">

			<?php echo $this->Html->link(__('Preview'),array('action'=>'preview',substr($page['Page']['url'],1)));?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $page['Page']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $page['Page']['id']), null, __('Are you sure you want to delete %s?', $page['Page']['url'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p class='muted'>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	
	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled btn'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled btn'));
	?>
	</div>
</div>