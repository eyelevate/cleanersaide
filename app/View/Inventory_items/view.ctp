<div class="vehicles view">
<h2><?php  echo __('Vehicles'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['id']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Units'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['units']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>