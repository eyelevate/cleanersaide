

<div class="inventory_items index">
	<h2><?php echo __('Inventory Items'); ?></h2>
	<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('inc_units');?></th>
			<th><?php echo $this->Paginator->sort('towed_units');?></th>
			<th><?php echo $this->Paginator->sort('overlength');?></th>
			<th><?php echo $this->Paginator->sort('oneway');?> (US$)</th>
			<th><?php echo $this->Paginator->sort('surcharge');?> (US$)</th>
			<th><?php echo $this->Paginator->sort('total_price');?> (US$)</th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($inventory_items as $inv): ?>
	<tr>
		<td><?php echo h($inv['Inventory_item']['type']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['name']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['description']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['inc_units']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['towed_units']);?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['overlength']); ?>&nbsp;</td>
		<td>
			<?php 
			if(h($inv['Inventory_item']['oneway'])==''){
				echo 'None';
			} else {
				echo '$'.h($inv['Inventory_item']['oneway']); 	
			}			
			?>&nbsp;
		</td>
		<td>
			<?php 
			if(h($inv['Inventory_item']['surcharge'])==''){
				echo 'None';
			} else {
				echo '$'.h($inv['Inventory_item']['surcharge']); 	
			}			
			?>&nbsp;			
		</td>
		<td>
			<?php 
			if(h($inv['Inventory_item']['total_price'])==''){
				echo 'None';
			} else {
				echo '$'.h($inv['Inventory_item']['total_price']); 	
			}			
			?>&nbsp;			
		</td>
		<td class="actions">
			<?php 
			echo $this->Html->link(__('Edit'), 
				array(
					'action' => 'edit', 
					$inv['Inventory_item']['id']
				)
			); 
			?>
			<?php 
			echo $this->Form->postLink(__('Delete'), 
				array(
					'action' => 'delete', 
					$inv['Inventory_item']['id']), 
					null, 
					__('Warning! Deleting inventory items may cause errors in scheduling. Are you sure you want to delete "%s"?', 
					$inv['Inventory_item']['name']
				)
			); 
			?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<div class="formRow">
		<?php
		echo $this->Html->link('Add Item',array('action'=>'add'),array('class'=>'btn btn-primary btn-large pull-right'));
		
		?>
	</div>

</div>
