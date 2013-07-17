<?php


?>

<div class="attractions index">
	<h2><?php echo __('Attractions'); ?></h2>
	<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
	<tr>
		<th>Id</th>
		<th>Name</th>
		<th>City</th>
		<th>Url</th>
		<td>Status</td>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($attractions as $attraction): ?>
	<tr>
		<td><?php echo h($attraction['Attraction']['id']); ?>&nbsp;</td>
		<td><?php echo h($attraction['Attraction']['name']); ?>&nbsp;</td>
		<td><?php echo h($attraction['Attraction']['city']); ?>&nbsp;</td>
		<td><?php echo h($attraction['Attraction']['url']); ?>&nbsp;</td>
		<td>
			<?php 
			switch($attraction['Attraction']['status']){
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
					echo $this->Form->input('id',array('type'=>'hidden','value'=>$attraction['Attraction']['id']));
					echo $this->Form->input('status', array(
						'options'=>$status,
						'class'=>'statusSelect',
						'label'=>false,
						'div'=>false,
						'error'=>array('attributes' => array('class' => 'help-block')),
						'default'=>$attraction['Attraction']['status']
					));
					echo $this->Form->submit('change',array('class'=>'btn btn-small pull-left'));
					echo $this->Form->end();					
					break;
			}
			//echo h($attraction['Attraction']['status']);

			?>&nbsp;
			
		</td>
		<td class="actions">
			<?php 
			echo $this->Html->link('Preview',array('action'=>'preview',$attraction['Attraction']['id']), array('class'=>'btn btn-mini btn-inverse'));
			echo $this->Html->link('Edit', array('action' => 'edit', $attraction['Attraction']['id']), array('class'=>'btn btn-mini btn-primary'));
			echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $attraction['Attraction']['id']), array('class'=>'btn btn-mini btn-danger'), __('Are you sure you want to delete - %s?', $attraction['Attraction']['name'])); 
			
			?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>

</div>