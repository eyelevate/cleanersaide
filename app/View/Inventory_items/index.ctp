<!-- SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='cleanersaide' 
    AND `TABLE_NAME`='inventory_items'; -->
    
<!-- ALTER TABLE  `inventory_items` ADD  `image` VARCHAR( 100 ) NULL AFTER  `price`   -->  
    

<div class="inventory_items index">
	<h2><?php echo __('Inventory Items'); ?></h2>
	<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('inventory_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('price');?></th>
			<th><?php echo $this->Paginator->sort('image');?></th>

			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($inventory_items as $inv): ?>
	<tr>
		<td><?php echo h($inv['Inventory_item']['inventory_name']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['name']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['description']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['price']); ?>&nbsp;</td>
		<td><?php echo h($inv['Inventory_item']['image']); ?>&nbsp;</td>
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
