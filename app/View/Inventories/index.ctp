<?php



?>
<div class="vehicles index">
	<h2><?php echo __('Inventory Types'); ?></h2>
	<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('reservable');?></th>
		<th><?php echo $this->Paginator->sort('total_units');?></th>
		<th><?php echo $this->Paginator->sort('online_oneway');?></th>
		<th><?php echo $this->Paginator->sort('online_roundtrip');?></th>
		<th><?php echo $this->Paginator->sort('phone_oneway');?></th>
		<th><?php echo $this->Paginator->sort('phone_roundtrip');?></th>
		<th><?php echo $this->Paginator->sort('Base Unit (Feet)');?></th>
		<th><?php echo $this->Paginator->sort('Overlength Rate');?></th>
		<th><?php echo $this->Paginator->sort('towed_units');?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($inventories as $inventory): 
		if(!empty($inventory['Inventory']['towed_units'])){
			$find = json_decode($inventory['Inventory']['towed_units'],true);

			$options = '';
			if(!empty($find)){
				foreach ($find as $tu) {
					$name = $tu['name'];
					$desc = $tu['desc'];
					
					$options =$options.'<option>'.$name.' ('.$desc.')</option>';
				}
				$towed_units = '<select>'.$options.'</select>';
			} else {
				$towed_units = 'None';
			} 
		} else {
			$towed_units = 'None';
		}	
	?>
	<tr>
		<td><?php echo h($inventory['Inventory']['name']); ?>&nbsp;</td>
		<td><?php echo h($inventory['Inventory']['reservable']);?> &nbsp;</td>
		<td><?php echo h($inventory['Inventory']['total_units']);?> &nbsp;</td>
		<td>
			<?php
			if($inventory['Inventory']['online_oneway']==''){
				echo 'None';
			} else {
				echo '$'.h($inventory['Inventory']['online_oneway']);
			}
			?> &nbsp;
		</td>
		<td>
			<?php
			if($inventory['Inventory']['online_roundtrip']==''){
				echo 'None';	
			} else {
				echo '$'.h($inventory['Inventory']['online_roundtrip']);
			}
			?> &nbsp;
		</td>
		<td>
			<?php 
			if($inventory['Inventory']['phone_oneway']==''){
				echo 'None';	
			} else {
				echo '$'.h($inventory['Inventory']['phone_oneway']);
			}
			?> &nbsp;
		</td>
		<td>
			<?php 
			if($inventory['Inventory']['phone_roundtrip']==''){
				echo 'None';	
			} else {
				echo '$'.h($inventory['Inventory']['phone_roundtrip']);
			}
			?> &nbsp;
		</td>
		<td>
			<?php 
			if(h($inventory['Inventory']['overlength_feet']) == ''){
				echo 'None';
			} else {
				echo h($inventory['Inventory']['overlength_feet']);
			}
			?> &nbsp;
		</td>
		<td>
			<?php 
				if(h($inventory['Inventory']['overlength_rate']) ==''){
					echo 'None';
				} else {
					echo '$'.h($inventory['Inventory']['overlength_rate']);	
				}
				
			?> &nbsp;
		</td>
		<td><?php echo $towed_units;?></td>
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
