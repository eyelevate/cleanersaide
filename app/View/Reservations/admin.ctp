<?php 

//load scripts to layout
echo $this->Html->script(array(
	'admin/reservations_admin.js'),FALSE);

//start the body
?>
<div class="row-fluid">
	
	<div id="accordion1" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" href="#search_customer" data-toggle="collapse" data-parent="#accordion1">Search</a>
			</div>
			<div id="search_customer" class="accordion-body collapse" >			
				<form action="/reservations/admin" method="post" style="margin:20px">
					<!-- <div class="control-group">
						<input type="text" name="results" value="" class="span6"/>
					</div> -->
					<div class="clearfix">
						<div class="well well-small pull-left">
							<label class="heading">Search for</label>
							<input type="text" name="results" value="" class="span12"/>
							<div><label class="radio"><input type="radio" name="searchBy" checked="checked" value="confirmation"/> Confirmation</label></div>
							<div><label class="radio"><input type="radio" name="searchBy" value="lastname"/> Last Name</label></div>
							<div><label class="radio"><input type="radio" name="searchBy" value="firstname"/> First Name</label></div>
							<div><label class="radio"><input type="radio" name="searchBy" value="email"/> Email</label></div>
							<div><label class="radio"><input type="radio" name="searchBy" value="phone"/> Phone</label></div>							
						</div>
						<div class="well well-small pull-left" style="margin-left:10px;">
							<label class='heading'>Order By</label>
							<div><label class="radio"><input type="radio" name="orderBy" checked="checked" value="confirmationAZ"/> By Confirmation (A-Z)</label></div>
							<div><label class="radio"><input type="radio" name="orderBy" value="confirmationZA"/> By Confirmation (Z-A)</label></div>							
							<div><label class="radio"><input type="radio" name="orderBy" value="dateAZ"/> By Date (Newest to Oldest)</label></div>
							<div><label class="radio"><input type="radio" name="orderBy" value="dateZA"/> By Date (Oldest to Newest)</label></div>
							<div><label class="radio"><input type="radio" name="orderBy" value="lastnameAZ"/> By Last Name (A-Z)</label></div>
							<div><label class="radio"><input type="radio" name="orderBy" value="lastnameZA"/> By Last Name (Z-A)</label></div>
							<div><label class="radio"><input type="radio" name="orderBy" value="firstnameAZ"/> By First Name (A-Z)</label></div>
							<div><label class="radio"><input type="radio" name="orderBy" value="firstnameZA"/> By First Name (Z-A)</label></div>
							<div><label class="radio"><input type="radio" name="orderBy" value="email"/> By Email</label></div>
							<div><label class="radio"><input type="radio" name="orderBy" value="phone"/> By Phone</label></div>							
						</div>	
						<div class="well well-small pull-left" style="margin-left:10px;">
							<label class='heading'>Show </label>
							<div><label class="radio"><input type="radio" name="show" checked="checked" value="10"/> Show 10 Results</label></div>
							<div><label class="radio"><input type="radio" name="show" value="25"/> Show 25 Results</label></div>
							<div><label class="radio"><input type="radio" name="show" value="50"/> Show 50 Results</label></div>
							<div><label class="radio"><input type="radio" name="show" value="75"/> Show 75 Results</label></div>
							<div><label class="radio"><input type="radio" name="show" value="100"/> Show 100 Results</label></div>	
							<div><label class="radio"><input type="radio" name="show" value="1000"/> Show 1000 Results</label></div>					
						</div>		
						<div class="well well-small pull-left" style="margin-left:10px;">
							<label class='heading'>Filter by type </label>
							<div><label><input type="checkbox" name="ferry" value="ferry"/> Ferry</label></div>
							<div><label><input type="checkbox" name="hotel" value="hotel"/> Hotel</label></div>
							<div><label><input type="checkbox" name="attraction" value="attraction"/> Attraction</label></div>
							<div><label><input type="checkbox" name="package" value="package"/> Package</label></div>						
						</div>	
						<div class="well well-small pull-left" style="margin-left:10px;">
							<label class='heading'>Filter by date </label>
							<div class="input-append" style="margin-left:0px;">
								<input id="start" name="start" class="span10 date" placeholder="Start date" type="text" />
								<span class="add-on pointer"><i class="icon-calendar"></i></span>	
							</div>
						
							<div class="input-append" style="margin-left:0px;">
								<input id="end" name="end" class="span10 date" placeholder="End date" type="text" />
								<span class="add-on pointer"><i class="icon-calendar"></i></span>	
							</div>
						</div>
											
					</div>

	
					<div>
						<button type="submit" class="btn btn-primary">Search</button>
					</div>			
				</form>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Form->input('',array('type'=>'hidden','class'=>'searchAction','value'=>'/reservations/request'));
?>
		<div class="reservations index">
			<table class="table table-bordered table-hover table-striped">
			<tr>
					<th>Id</th>
					<th>Confirmation</th>
					<th>Last</th>
					<th>First</th>
					<th>phone</th>
					<th>Ferry</th>
					<th>Hotel</th>
					<th>Attraction</th>
					<th>Package</th>
					<th>Total</th>
					<th>Created</th>
					<th>Created By</th>
					<th class="actions"><?php echo __('Actions'); ?></th>
					<!-- <th><?php echo $this->Paginator->sort('id'); ?></th>

					<th><?php echo $this->Paginator->sort('confirmation');?></th>
					<th><?php echo $this->Paginator->sort('last_name','Last'); ?></th>
					<th><?php echo $this->Paginator->sort('first_name','First'); ?></th>
					<th><?php echo $this->Paginator->sort('phone');?></th>
					<th><?php echo $this->Paginator->sort('ferry_total','Ferry');?></th>
					<th><?php echo $this->Paginator->sort('hotel_total', 'Hotel');?></th>
					<th><?php echo $this->Paginator->sort('attraction_total', 'Attraction');?></th>
					<th><?php echo $this->Paginator->sort('package_total','Package');?></th>
					<th><?php echo $this->Paginator->sort('total'); ?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('created_by');?></th>
					<th class="actions"><?php echo __('Actions'); ?></th> -->
			</tr>
			<tbody id="reservationTbody">
			<?php 
			foreach ($reservations as $reservation): 
				$ferry_total = $reservation['Reservation']['ferry_total'];
				$hotel_total = $reservation['Reservation']['hotel_total'];
				$attraction_total = $reservation['Reservation']['attraction_total'];
				$package_total = $reservation['Reservation']['package_total'];
				$total = $reservation['Reservation']['total'];
				$status = $reservation['Reservation']['status'];
				if($ferry_total > 0){
					$ferry_total_color = 'text-success';
				} else {
					$ferry_total_color = 'muted';
				}
				if($hotel_total > 0){
					$hotel_total_color = 'text-success';
				} else {
					$hotel_total_color = 'muted';
				}
				if($attraction_total > 0){
					$attraction_total_color = 'text-success';
				} else {
					$attraction_total_color = 'muted';
				}
				if($package_total > 0){
					$package_total_color = 'text-success';
				} else {
					$package_total_color = 'muted';
				}	
				if($total > 0){
					$total_color = 'text-success';
				} else {
					$total_color = 'muted';
				}	
				if($status > 1){
					$status_color = 'background-color: #ffa3a3';
				} else {
					$status_color = '';
				}
			?>
		
			<!-- <tr>
				<td><?php echo h($reservation['Reservation']['id']); ?>&nbsp;</td>
				<td><?php echo h($reservation['Reservation']['confirmation']); ?>&nbsp;</td>
				<td><?php echo ucfirst(h($reservation['Reservation']['last_name'])); ?>&nbsp;</td>
				<td><?php echo ucfirst(h($reservation['Reservation']['first_name'])); ?>&nbsp;</td>
				<td><?php echo h($reservation['Reservation']['phone']);?> &nbsp;</td>
				<td class="<?php echo $ferry_total_color;?>">$<?php echo h($reservation['Reservation']['ferry_total']); ?>&nbsp;</td>
				<td class="<?php echo $hotel_total_color;?>">$<?php echo h($reservation['Reservation']['hotel_total']); ?>&nbsp;</td>
				<td class="<?php echo $attraction_total_color;?>">$<?php echo h($reservation['Reservation']['attraction_total']); ?>&nbsp;</td>
				<td class="<?php echo $package_total_color;?>">$<?php echo h($reservation['Reservation']['package_total']); ?>&nbsp;</td>
				<td class="<?php echo $total_color;?>"><strong>$<?php echo h($reservation['Reservation']['total']); ?>&nbsp;</strong></td>
				<td><?php echo date('n/d/y g:iA',strtotime($reservation['Reservation']['created']));?></td>
				<td><?php echo h($reservation['Reservation']['created_by']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $reservation['Reservation']['id'])); ?>

				</td>
			</tr> -->
			<tr >
				<td style="<?php echo $status_color;?>"><?php echo $reservation['Reservation']['id'];?></td>
				<td style="<?php echo $status_color;?>"><?php echo $reservation['Reservation']['confirmation']; ?></td>
				<td style="<?php echo $status_color;?>"><?php echo ucfirst($reservation['Reservation']['last_name']); ?></td>
				<td style="<?php echo $status_color;?>"><?php echo ucfirst($reservation['Reservation']['first_name']); ?></td>
				<td style="<?php echo $status_color;?>"><?php echo $reservation['Reservation']['phone'];?> &nbsp;</td>
				<td style="<?php echo $status_color;?>" class="<?php echo $ferry_total_color;?>">$<?php echo $reservation['Reservation']['ferry_total']; ?>&nbsp;</td>
				<td style="<?php echo $status_color;?>" class="<?php echo $hotel_total_color;?>">$<?php echo $reservation['Reservation']['hotel_total']; ?>&nbsp;</td>
				<td style="<?php echo $status_color;?>" class="<?php echo $attraction_total_color;?>">$<?php echo $reservation['Reservation']['attraction_total']; ?>&nbsp;</td>
				<td style="<?php echo $status_color;?>" class="<?php echo $package_total_color;?>">$<?php echo $reservation['Reservation']['package_total']; ?>&nbsp;</td>
				<td style="<?php echo $status_color;?>" class="<?php echo $total_color;?>"><strong>$<?php echo $reservation['Reservation']['total']; ?>&nbsp;</strong></td>
				<td style="<?php echo $status_color;?>"><?php echo date('n/d/y g:iA',strtotime($reservation['Reservation']['created']));?></td>
				<td style="<?php echo $status_color;?>"><?php echo $reservation['Reservation']['created_by']; ?>&nbsp;</td>
				<td style="<?php echo $status_color;?>" class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $reservation['Reservation']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>		
			</tbody>
		
			</table>
			<!-- <p>
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
			</div> -->
		</div>	
