<div class="packageAddOns view">
<h2><?php  echo __('Package Add On'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($packageAddOn['PackageAddOn']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($packageAddOn['PackageAddOn']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($packageAddOn['PackageAddOn']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inventory'); ?></dt>
		<dd>
			<?php echo h($packageAddOn['PackageAddOn']['inventory']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($packageAddOn['PackageAddOn']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($packageAddOn['PackageAddOn']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($packageAddOn['PackageAddOn']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Package Add On'), array('action' => 'edit', $packageAddOn['PackageAddOn']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Package Add On'), array('action' => 'delete', $packageAddOn['PackageAddOn']['id']), null, __('Are you sure you want to delete # %s?', $packageAddOn['PackageAddOn']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Package Add Ons'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Package Add On'), array('action' => 'add')); ?> </li>
	</ul>
</div>
