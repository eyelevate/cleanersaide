<?php


?>

<div class="packages index">
	<h2><?php echo __('Packages'); ?></h2>
	<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('start_date'); ?></th>
		<th><?php echo $this->Paginator->sort('end_date');?></th>
		<th><?php echo $this->Paginator->sort('rtWalkon','RT Walk-on').' US$';?></th>
		<th><?php echo $this->Paginator->sort('rtPassenger','RT Vehicle').' US$';?></th>
		<th><?php echo $this->Paginator->sort('status');?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($packages as $package): ?>
	<tr>
		<td><?php echo h($package['Package']['id']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['name']); ?>&nbsp;</td>
		<td><?php echo h(date('n/d/Y',strtotime($package['Package']['start_date']))); ?>&nbsp;</td>
		<td><?php echo h(date('n/d/Y',strtotime($package['Package']['end_date'])));?>&nbsp;</td>
		<td>$<?php echo h($package['Package']['rtWalkon']); ?>&nbsp;</td>
		<td>$<?php echo h($package['Package']['rtVehicle']); ?>&nbsp;</td>
		<td>
			<?php 
			switch($package['Package']['status']){
				case '1':
					echo 'Unfinished';
					break;
					
				default:
					echo $this->Form->create();
					$status = array(
						''=>'Select Status',
						'2'=>'Unbookable',

						'5'=>'Bookable, but not public',
						'6'=>'Bookable, and public'
					);
					echo $this->Form->input('id',array('type'=>'hidden','value'=>$package['Package']['id']));
					echo $this->Form->input('status', array(
						'options'=>$status,
						'class'=>'statusSelect pull-left',
						'label'=>false,
						'div'=>false,
						'error'=>array('attributes' => array('class' => 'help-block')),
						'default'=>$package['Package']['status']
					));
					echo $this->Form->submit('change',array('class'=>'btn btn-small pull-left'));
					echo $this->Form->end();					
					break;
			}
			//echo h($attraction['Attraction']['status']);

			?>&nbsp;
			
		</td>

		<td class="actions">

			<?php echo $this->Html->link('Edit', array('action' => 'edit', $package['Package']['id']), array('class'=>'btn btn-mini btn-primary')); ?>
			
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $package['Package']['id']), array('class'=>'btn btn-mini btn-danger'), __('Are you sure you want to delete - %s?', $package['Package']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p class="muted">
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>