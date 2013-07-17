<?php
//alerts on page
echo $this->TwitterBootstrap->flashes(array(
    "auth" => False,
    "closable"=>true
    )
);
?>

<div class="packageAddOns index">
	<h2><?php echo __('Package Add Ons'); ?></h2>
	<table class="table table-bordered table-hover table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('inventory'); ?></th>
			<th><?php echo $this->Paginator->sort('country');?></th>
			<th><?php echo $this->Paginator->sort('gross').' US$';?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($packageAddOns as $packageAddOn): ?>
	<tr>
		<td><?php echo h($packageAddOn['PackageAddOn']['id']); ?>&nbsp;</td>
		<td><?php echo h($packageAddOn['PackageAddOn']['name']); ?>&nbsp;</td>
		<td><?php echo h($packageAddOn['PackageAddOn']['description']); ?>&nbsp;</td>
		<td><?php echo h($packageAddOn['PackageAddOn']['inventory']); ?>&nbsp;</td>
		<td>
			<?php 
			if($packageAddOn['PackageAddOn']['country']  == 1){
				$country = 'USA';
			} else {
				$country = 'CAN';
			}
			echo h($country);?> &nbsp;
		</td>
		<td>$<?php echo h($packageAddOn['PackageAddOn']['gross']);?> &nbsp;</td>
		<td>
			<?php 
			switch($packageAddOn['PackageAddOn']['status']){
				case '1':
					echo 'Unfinished';
					break;
					
				default:
					echo $this->Form->create();
					$status = array(
						''=>'Select Status',
						'2'=>'Unbookable',
						'3'=>'Unbookable, except in packages',
						'4'=>'Unbookable, except in packages or by employees',
						'5'=>'Bookable, but not public',
						'6'=>'Bookable, and public'
					);
					echo $this->Form->input('PackageAddOn.id',array('type'=>'hidden','value'=>$packageAddOn['PackageAddOn']['id']));
					echo $this->Form->input('PackageAddOn.status', array(
						'options'=>$status,
						'class'=>'statusSelect pull-left',
						'label'=>false,
						'div'=>false,
						'error'=>array('attributes' => array('class' => 'help-block')),
						'default'=>$packageAddOn['PackageAddOn']['status']
					));
					echo $this->Form->submit('change',array('class'=>'btn btn-small pull-left'));
					echo $this->Form->end();					
					break;
			}

			?>&nbsp;
			
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $packageAddOn['PackageAddOn']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $packageAddOn['PackageAddOn']['id']), null, __('Are you sure you want to delete # %s?', $packageAddOn['PackageAddOn']['id'])); ?>
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
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
