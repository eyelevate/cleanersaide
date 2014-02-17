<?php

?>
<div class="row-fluid ">
	<form action="/rewards/view/<?php echo $customer_id;?>" method="post">
		<div class="well well-large clearfix">
			<div class="formRow clearfix">
				<div class="control-group pull-left" style="margin-right:5px;">
					<label>Current Points</label>
					<input type="text" readonly="true" value="<?php echo $current_points;?>" name="data[RewardTransaction][current_points]"/>
				</div>
				<div class="control-group pull-left" style="margin-right:5px;">
					<label>Set Points To</label>
					<input type="text" name="data[RewardTransaction][running_total]"/>
				</div>		
				<div class="control-group pull-left">
					<label>Adjustment Reason</label>
					<select name="data[RewardTransaction][reason]">
						<option value="1">Edited total during pickup</option>
						<option value="2">Cancelled pickup order</option>
						<option value="3">Returned Invoice</option>
						<option value="4">Unhappy Customer, gifted points (manager only)</option>
						<option value="5">Other</option>
					</select>
				</div>		
			</div>
			<div class="control-group">
				<input type="submit" class="btn btn-primary" value="Set Points"/>
			</div>	
		</div>

	</form>
</div>
<div class="row-fluid">
	<div class="users index span10">
		<h2 class="heading"><?php echo __('Rewards History'); ?></h2>
		<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
		<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('reward_id'); ?></th>
				<th><?php echo $this->Paginator->sort('transaction_id'); ?></th>
				<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
				<th><?php echo $this->Paginator->sort('employee_id'); ?></th>
				<th><?php echo $this->Paginator->sort('points','New Points'); ?></th>
				<th><?php echo $this->Paginator->sort('credited','+ Points'); ?></th>
				<th><?php echo $this->Paginator->sort('reduced','- Points'); ?></th>
				<th><?php echo $this->Paginator->sort('running_total','Total'); ?></th>
				<th><?php echo $this->Paginator->sort('reason'); ?></th>
				<th><?php echo $this->Paginator->sort('created','Date'); ?></th>
		</tr>
		<?php
		foreach ($rewards as $reward): ?>
		<tr>
			<td><?php echo h($reward['RewardTransaction']['id']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['reward_id']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['transaction_id']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['customer_id']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['employee_id']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['points']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['credited']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['reduced']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['running_total']); ?>&nbsp;</td>
			<td><?php echo h($reward['RewardTransaction']['reason']); ?>&nbsp;</td>
			<td><?php echo h(date('n/d/Y g:ia',strtotime($reward['RewardTransaction']['created']))); ?>&nbsp;</td>

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


</div>
<div class="row-fluid">
	<a href="/invoices/index/<?php echo $customer_id;?>" class="btn btn-large btn-success">Back To Customer Invoice Page</a>
</div>