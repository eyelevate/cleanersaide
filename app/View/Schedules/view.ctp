<?php
echo $this->Html->script(array(
	'admin/plugins/validation/jquery.validate.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/schedules_view.js'),
	FALSE
);




$date = $schedules['Schedule']['service_date'];
$date_formatted = date('l n/d/Y g:ia',strtotime($date));
$departs = $schedules['Schedule']['departs'];

?>

<? if ($group_id == 1 || $group_id == 2 || $group_id == 7 ) { //hardcoded for super admin, admin, and supervisors ?> 
	<form id="editScheduleForm1" class="form-horizontal" method="post" action="/schedules/edit">
	<div id="editFormDiv" class="row-fluid">
			
		<div class="style_switcher" style="display: none; width:70%; overflow: auto; max-height: 80%;">
			
			<div class="sepH_c">
				<h4 class="heading">Edit Ferry Schedule</h4>
			</div>
			<div class="tabbable tabbable-bordered clearfix">
				<ul class="nav nav-tabs">
			    	<li class="active"><a data-toggle="tab" href="#edit1">Edit Departure Time</a></li>
			    	<li class=""><a data-toggle="tab" href="#edit2">Edit Rates & Limits</a></li>
			    </ul>			
		 		<div class="tab-content" style="background-color:#ffffff;">
			    	<div id="edit1" class="tab-pane active">
				    			
				    	<input type="hidden" name="data[form_type]" value="Edit_Final"/>
				    	<ul class="unstyled">
				    		<li id="startDateDiv" class="control-group">
				    			<label class="control-label" style="color:#000000;">Departure Time</label>
				    			<div class="controls">
					    			<input status="notedited" id="tripTime-<?php echo $trip_id;?>" class="tripTimeInput" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead" type="text" name="data[Schedule][<?php echo $trip_id;?>][depart_time]" value="<?php echo  date('g:ia',strtotime($date));?>"/>
					    		</div>
					    		<span class="help-block"></span>	
					    		<input type="hidden" name="data[Schedule][<?php echo $trip_id;?>][service_date]" value="<?php echo date('Y-m-d',strtotime($date));?>"/>	
					    		<input type="hidden" name="data[View]" value="<?php echo $trip_id;?>"/>
				    		</li>

				    	</ul>
						
			    	</div>
			    	<div id="edit2" class="tab-pane" style="color:#000000;">
						<div id="side_accordion45" class="accordion">
							<?php
						
							foreach ($inv_items as $key=>$value):
								$type = $key;
							?>
								<div class="accordion-group">
									<div class="accordion-heading">
										<a href="#collapse-<?php echo $type;?>" data-parent="#side_accordion45" data-toggle="collapse" class="accordion-toggle">Set <?php echo $type;?> Rates & Limits <span class="label label-warning">Not Edited</span></a>
										
							    	</div>
									<div class="accordion-body collapse" id="collapse-<?php echo $type;?>">
								    	<div class="accordion-inner">
									    	<table class="table table-hover table-bordered table-condensed table-striped">
									    		<thead>
									    			<tr>
									    				<th>Name</th>
									    				<th>Description</th>
									    				<th>Regular One Way</th>
									    				<th>Surcharge</th>
									    				<th>Surcharged One Way</th>
									    			</tr>
									    		</thead>
									    		<tbody id="ratesLimitTbody">
									    		<?php  
									    		foreach ($inv_items[$type] as $key=>$value):
													$inv_id = $inv_items[$type][$key]['id'];
													$inv_type = $inv_items[$type][$key]['type'];
													$inv_name = $inv_items[$type][$key]['name'];
													$inv_desc = $inv_items[$type][$key]['desc'];
													$one_way = $inv_items[$type][$key]['oneway'];
													$surcharge = $inv_items[$type][$key]['surcharge'];
													$surcharge_total = $inv_items[$type][$key]['total'];
													$inventory_id = $inv_items[$type][$key]['inventory_id'];
													
													//echo $this->Form->create('Ferry_inventory',array('class'=>'sendRates'));
													//echo $this->Form->input('ferry_id',array('type'=>"hidden",'value'=>''));
													echo $this->Form->input('Schedule_rate.'.$inv_id.'.inventory_id',array('type'=>'hidden','value'=>$inventory_id));
													echo $this->Form->input('Schedule_rate.'.$inv_id.'.item_id',array('type'=>'hidden','value'=>$inv_id));
													
												?>
													<tr id="setRate-<?php echo $inv_id;?>" class="setRate" name="<?php echo $inventory_id;?>">
														<td><?php echo $inv_name;?></td>
														<td><?php echo $inv_desc;?></td>
														<td id="setOneWayTd-<?php echo $inv_id;?>" class="setOneWayTd control-group">
															<div class="input-prepend" style="width:100px">
																<span class="add-on">US$</span>
																<input style="width:60%" type="text" class="ferry_oneWay" value="<?php echo $one_way;?>" old="<?php echo $one_way;?>" name="data[Schedule_rate][<?php echo $inv_id;?>][one_way]" changed="No"/>
														
															</div>
															<span class="help-block"></span>														
														</td>
														<td id="setSurchargeTd-<?php echo $inv_id;?>" class="setSurchargeTd control-group" >
															<div class="input-prepend" style="width:100px">
																<span class="add-on">US$</span>
																<input style="width:60%" type="text" class="ferry_surcharge" value="<?php echo $surcharge;?>" old="<?php echo $surcharge;?>" name="data[Schedule_rate][<?php echo $inv_id;?>][surcharge]" changed="No"/>
															</div>
															<span class="help-block"></span>														
														</td>
														<td id="setSurchargeTotalTd-<?php echo $inv_id;?>"class="setSurchargeTotalTd control-group">
															<div class="input-prepend" style="width:100px">
																<span class="add-on">US$</span>
																<input style="width:60%" type="text" class="ferry_surchargeTotal" value="<?php echo $surcharge_total;?>" old="<?php echo $surcharge_total;?>" name="data[Schedule_rate][<?php echo $inv_id;?>][total_surcharged]" changed="No"/>
															</div>
															<span class="help-block"></span>																				
														</td>
													</tr>
												<?php

												endforeach;	
												?>
									    		</tbody>
									    	</table>
											<div id="ferry_limits-<?php echo $inv_id;?>" style="margin-top:15px;" class="ferry_limits form-horizontal pull-right well well-small" name="<?php echo $inventory_id;?>">
											<legend name="<?php echo $type;?>">Set <?php echo $type;?> Capacity</legend>
											<?php
											$total_reserved  = $ferry_limit[$inventory_id]['reservable'];
											$total_allowed = $ferry_limit[$inventory_id]['total_units'];
											$total_perc = round(($total_reserved/$total_allowed)*100,2);
						
											echo $this->Form->input('Schedule_limit.'.$inventory_id.'.reservableUnits',
												array(
													'div'=>array('class'=>'ferryReservableUnitsDiv control-group','id'=>'ferryReservableUnitsDiv-'.$inventory_id),
										        	'label' => array('class' => 'control-label','text'=>'Reservable Units Allowed','style'=>'color:#000000'),
										        	'between' => '<div class="controls"><div class="input-prepend input-append"><span class="add-on">#</span>',
										        	'after' => '<span class="add-on">Units</span></div><span class="help-block"></span></div>',
										        	'error' => array('attributes' => array('class' => 'help-block')),
										        	'class' => 'ferry_reservableUnits span5',
										        	'type'=>'text',
										        	'value'=>$total_reserved,
										        	'old'=>$total_reserved,
										        	'changed'=>'No',
										        	'placeholder'=>'Enter reservabled units'			
												)
											);
											echo $this->Form->input('Schedule_limit.'.$inventory_id.'.totalUnits',
												array(
													'div'=>array('class'=>'ferryTotalUnitsDiv control-group','id'=>'ferryTotalUnitsDiv-'.$inv_id),
										        	'label' => array('class' => 'control-label','text'=>'Total Units Allowed','style'=>'color:#000000'),
										        	'between' => '<div class="controls"><div class="input-prepend input-append"><span class="add-on">#</span>',
										        	'after' => '<span class="add-on">Units</span></div><span class="help-block"></span></div>',
										        	'error' => array('attributes' => array('class' => 'help-block')),
										        	'class' => 'ferry_totalUnits span5',
										        	'type'=>'text',
										        	'value'=>$total_allowed,
										        	'old'=>$total_allowed,
										        	'changed'=>'No',
										        	'placeholder'=>'Enter total units'			
												)
											);
											echo $this->Form->input('Schedule_limit.'.$inventory_id.'.total_percent',
												array(
													'div'=>array('class'=>'ferryCapacityDiv control-group','id'=>'ferryCapacityDiv-'.$inv_id),
										        	'label' => array('class' => 'control-label','text'=>'Reservable Capacity','style'=>'color:#000000'),
										        	'between' => '<div class="controls"><div class="input-append">',
										        	'after' => '<span class="add-on">%</span></div><span class="help-block"></span></div>',
										        	'error' => array('attributes' => array('class' => 'help-block')),
										        	'class' => 'ferry_capacity span5',
										        	'type'=>'text',
										        	'value'=>$total_perc,
										        	'old'=>$total_perc,
										        	'changed'=>'No',
										        	'disabled'=>'disabled',				
												)
											);
						
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
							endforeach;
							?>
							
						</div>
			    	</div>
			    </div>
			</div>
			
			<div class="well well-small clearfix" style="margin-top:20px;">
				<button id="deleteFormButton" type="button" class="btn btn-danger btn-large pull-left">Delete</button>
				<button id="editFormButton" type="button" class="btn btn-primary btn-large pull-right">Save</button>
			</div>
			
		</div>
	
	</div>	

	</form>
	
	<? } ?>
	
	<legend>Leaving <?php echo $departs.' on '. $date_formatted;?></legend>
	<h2>Current Capacity</h2>

	<div id="side_accordion9" class="accordion">
	<?php 
		$idx= -1;
		foreach ($limits as $key => $value):
			$idx = $idx+1;
			$row = 't-'.$idx;
			$reserved = $limits[$key]['reserved'];
			$reservable = $limits[$key]['reservableUnits'];
			$total = $limits[$key]['totalUnits'];
			$inventory_id = $limits[$key]['inventory_id'];
			
			if($reserved == 0){
				$status = 'success';
				$alert = 'alert alert-success';
				$capacity_formatted = '0%';				
			} else {
				$capacity = ($reserved / $reservable) * 100;
				$capacity_formatted = sprintf('%.2f',round($capacity,2)).'%';	
				if($capacity < 50){
					$status = 'success';
					$alert = 'alert alert-success';
				} elseif($capacity >= 50 && $capacity <=100){
					$status = 'warning';
					$alert = 'alert';
				} else{
					$status = 'error';
					$alert = 'alert alert-error';
				}				
			}
			switch ($inventory_id) {
				case '2':
					$overlength = $limits[$key]['overlength'];
					$inc_units = $limits[$key]['inc_units'];
					$actual_units = $reserved - $inc_units;
					if($actual_units < 0){
						$actual_units = 0;
					}
					$overlength_units = sprintf('%.2f',round($overlength / 18,2));

					break;
			}
			

			

	?>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapsable-<?php echo $row;?>" data-parent="#side_accordion9" data-toggle="collapse" class="accordion-toggle">
				<?php echo $key.' Capacity - <span class="label label-'.$status.'">'.$capacity_formatted.' ['.$reserved.'/'.$reservable.'] Units reserved</span>';?>
			</a>
    	</div>
		<div class="accordion-body collapse" id="collapsable-<?php echo $row;?>">
			<div class="accordion-inner">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<?php
							switch ($inventory_id) {
								case '2':
								?>
								<th>Capacity</th>
								<th>Reserved Units</th>
								<th>Actual Units</th>
								<th>Incremental Units</th>
								<th>Overlength Feet</th>
								<th>Overlength Units</th>
								<th>Reservable Units Allowed</th>
								<th>Remaining Reservable Units</th>
								<th>Total Capacity</th>
								<?php	
									break;
								default:
								?>
								<th>Capacity</th>
								<th>Reserved Units</th>
								<th>Reservable Units Allowed</th>
								<th>Remaining Reservable Units</th>
								<th>Total Capacity</th>									
								<?php
									break;
							}
							?>							
			
						</tr>
					</thead>
					<tbody>
						<tr class="<?php //echo $status;?>">
							<?php
							switch ($inventory_id) {
								case '2':
								?>
								<td class="<?php //echo $alert;?>"><strong><?php echo $capacity_formatted;?></strong></td>
								<td><?php echo $reserved;?></td>
								<td><?php echo $actual_units;?></td>
								<td><?php echo $inc_units;?></td>
								<td><?php echo $overlength;?></td>
								<td><?php echo $overlength_units;?></td>
								<td><?php echo $reservable;?></td>
								<td><?php echo $reservable-$reserved;?></td>
								<td><?php echo $total;?></td>
								<?php	
									break;
									
								default:
								?>
								<td class="<?php //echo $alert;?>"><strong><?php echo $capacity_formatted;?></strong></td>
								<td><?php echo $reserved;?></td>
								<td><?php echo $reservable;?></td>
								<td><?php echo $reservable-$reserved;?></td>
								<td><?php echo $total;?></td>								
								<?php	
									break;
							}
							?>							

						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endforeach;?>
	</div>
	<h2>Current Reservations</h2>
	<div class="row-fluid">	
		<div class="span4">
			<div id="accordion1" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" href="#search_customer" data-toggle="collapse" data-parent="#accordion1">Search By</a>
					</div>
					<div id="search_customer" class="accordion-body collapse" >			
						<form action="/reservations/admin" method="post" style="margin:20px">
							<div class="control-group">
								<input type="text"/>
							</div>
							<div><label class="radio"><input type="radio" name="searchBy" checked="checked" value="confirmation"/> By Confirmation</label></div>
							<div><label class="radio"><input type="radio" name="searchBy" value="lastname"/> By Last Name</label></div>
							<div><label class="radio"><input type="radio" name="searchBy" value="firstname"/> By First Name</label></div>
							<div><label class="radio"><input type="radio" name="searchBy" value="email"/> By Email</label></div>
							<div><label class="radio"><input type="radio" name="searchBy" value="phone"/> By Phone</label></div>		
							<div>
								<button type="button" class="btn btn-primary">Search</button>
							</div>			
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="span4 well">
			<h4>Customs Email</h4>
			<p>Customs email scheduled for 8:00AM on <? echo date('m/d/y', strtotime($schedules['Schedule']['check_date']) - 172800); ?>.</p>
			<a href="/schedules/download_customs/<?php echo $trip_id;?>" class="btn"><i class="icon-print"></i> Customs CSV</a>
			<? //echo $this->Html->link('Download',array('controller'=>'schedules','action'=>'download_customs'), array('target'=>'_blank')); ?>
		</div>
		<div class="span4 well">
			<h4>Sailing Check-in Lists</h4>
			<p>Use the buttons below to print this sailing's check-in list.</p>
			<a href="/schedules/print_vmanifest/<?php echo $trip_id;?>" class="btn" target="_blank"><i class="icon-print"></i> Vehicle & Motorcycles</a>
			<a href="/schedules/print_pmanifest/<?php echo $trip_id;?>" class="btn" target="_blank"><i class="icon-print"></i> Passenger & Bicycles</a>
			
			<h4 style="margin-top:15px;">HAP Report</h4>
			<p>Use the button below to print this sailing's voucher inventory list.</p>
			<a href="/schedules/print_hap_report/<?php echo $trip_id;?>" class="btn" target="_blank"><i class="icon-print"></i> HAP Report</a>
		</div>
	</div>	
		<div class="reservations index">
			<table class="table table-bordered table-hover table-striped">
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('confirmation');?></th>
				<th><?php echo $this->Paginator->sort('last_name'); ?></th>
				<th><?php echo $this->Paginator->sort('first_name'); ?></th>
				<th><?php echo $this->Paginator->sort('email'); ?></th>
				<th><?php echo $this->Paginator->sort('phone');?></th>
				<th><?php echo $this->Paginator->sort('inventory_id');?></th>
				<th><?php echo $this->Paginator->sort('created'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<tbody id="reservationTbody">
			<?php foreach ($reservations as $reservation): ?>
			<?php
				switch ($reservation['Ferry_reservation']['inventory_id']) {
					case '1':
						$inventory_name = 'Passenger';
						break;
					case '2':
						$inventory_name = 'Vehicle';
						break;
					case '3':
						$inventory_name = 'Motorcycle';
						break;
					default:
						$inventory_name = 'Bicycle';
						break;
				}
			
			?>
			<tr>
				<td><?php echo h($reservation['Ferry_reservation']['id']); ?>&nbsp;</td>
				<td><?php echo h($reservation['Ferry_reservation']['confirmation']);?> &nbsp;</td>
				<td><?php echo h(ucfirst($reservation['Ferry_reservation']['last_name'])); ?>&nbsp;</td>
				<td><?php echo h(ucfirst($reservation['Ferry_reservation']['first_name'])); ?>&nbsp;</td>
				<td><?php echo h($reservation['Ferry_reservation']['email']); ?>&nbsp;</td>
				<td><?php echo h($reservation['Ferry_reservation']['phone']); ?>&nbsp;</td>
				<td><?php echo h($inventory_name);?> &nbsp;</td>
				<td><?php echo h(date('n/d/y',strtotime($reservation['Ferry_reservation']['created']))); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller'=>'reservations','action' => 'view', $reservation['Ferry_reservation']['reservation_id']), array('class' => 'btn btn-mini' )); ?>
					

				</td>
			</tr>
			<?php endforeach; ?>		
			</tbody>
		
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
</div>
<div >
	
	<form id="deleteTrip" method="post" action="/schedules/edit">
		<input type="hidden" name="data[form_type]" value="Edit_Final"/>
		<input id="trip_id" type="hidden" value="<?php echo $trip_id;?>"/>
	
	</form>

</div>

<? if ($group_id == 1 || $group_id == 2 || $group_id == 7 ) { //hardcoded for super admin, admin, and supervisors ?> 

<a class="ssw_trigger active" href="javascript:void(0)">
	 <i class="icon-cog icon-white"></i>
</a>

<? } ?>