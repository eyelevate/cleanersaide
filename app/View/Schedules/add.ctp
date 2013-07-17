<?php
echo $this->Html->script(array('admin/schedules_add.js'),FALSE);

?>
	
<h2>Add Schedule</h2>

<div id="side_accordion2" class="accordion">
	<div class="accordion-group" id="scheduleAttributes">
		<div class="accordion-heading sdb_h_active">
			<a href="#collapse-attributes" data-parent="#side_accordion2" data-toggle="collapse" class="accordion-toggle acc-in">Choose Schedule Form Attributes</a>
		</div>	
		<div class="accordion-body in collapse" id="collapse-attributes">
			<div class="accordion-inner">
				<div class="form-horizontal">
					<legend>Choose Date Range</legend>
					<div id="startDateDiv" class="control-group">
						<label>Start Date</label>
						<input type="text" class="span3 search-query" id="schedule_start">
						<span class="help-block"></span>
					</div>
					<div id="endDateDiv" class="control-group">
						<label>End Date</label>
						<input type="text" class="span3 search-query" id="schedule_end">
						<span class="help-block"></span>
					</div>
					
				</div>
				<legend>Select Number Of Trips/Day</legend>
				<div class="form-horizontal">
					<div id="tripsDiv" class="control-group">	
						<select id="tripsSelected">
							<option value="none">Select Trip</option>
							<option value="NIS">Not In Service</option>
							<?php
							for ($i=1; $i <= 10; $i++) { 
								?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php
							}
							?>
						</select>
						<span class="help-block"></span>
					</div>
				</div>	
				<button id="submitScheduleAttributes" class=" btn btn-primary">Create Schedule Form</button>
			</div>
		</div>	
	</div>
	<div class="accordion-group hide" id="scheduleForm">
		<div class="accordion-heading">
			<a href="#collapse-form" data-parent="#side_accordion2" data-toggle="collapse" class="accordion-toggle">Schedule Form</a>
		</div>	
		<div class="accordion-body collapse" id="collapse-form">
			<div id="createdFormDiv" class="accordion-inner">
				<div id="nisDiv">
					<legend>Not In Service Reason</legend>
					<form id="formNIS" class="form-actions" method="post">
						<div id="nisFormInputDiv" class="control-group">
							<label>Reason</label>
							<input type="text" id="nisReasonInput" class="span6" name="nis"/>
							<span class="help-block"></span>
						</div>
						<input id="nisStartDate" value="" type="hidden" name="startDate"/>
						<input id="nisEndDate" value="" type="hidden" name="endDate"/> 	
						<input type="hidden" name="type" value="NIS"/>					
						
					</form>
					<button id="cancelNIS" class="btn btn-large">Cancel</button>
					<button id="saveNIS" class="btn btn-primary btn-large">Save Schedule</button>
				</div>
				<div id="scheduleFormDiv">			
					<legend>Set Schedule</legend>
					<div id="errorMessageAlert" class="alert hide">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<small></small>
					</div>
					<table class="scheduleFormTable table table-bordered">
						<thead>
							<tr>
								<th>Trip #</th>
								<th>Start</th>
								<th>End</th>
								<th>Leaving Port Angeles</th>
								<th>Leaving Victoria</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody id="scheduleFormTbody"></tbody>
					</table>
					<legend>Set Sailing Rates</legend>
					<div id="side_accordion3" class="accordion">
						<?php
						foreach ($inv_items as $key=>$value):
							$type = $key;
						?>
							<div class="accordion-group">
								<div class="accordion-heading">
									<a href="#collapse-<?php echo $type;?>" data-parent="#side_accordion3" data-toggle="collapse" class="accordion-toggle">Set <?php echo $type;?> Rates</a>
						    	</div>
								<div class="accordion-body collapse" id="collapse-<?php echo $type;?>">
							    	<div class="accordion-inner">
								    	<table class="table table-hover table-bordered">
								    		<thead>
								    			<tr>
								    				<th>Name</th>
								    				<th>Description</th>
								    				<th>Regular One Way</th>
								    				<th>Surcharge</th>
								    				<th>Surcharged One Way</th>
								    			</tr>
								    		</thead>
								    		<tbody>
								    		<?php  

								    		foreach ($inv_items[$type] as $key=>$value):
												$inv_id = $inv_items[$type][$key]['id'];
												$inventory_id = $inv_items[$type][$key]['inventory_id'];
												$inv_type = $inv_items[$type][$key]['type'];
												$inv_name = $inv_items[$type][$key]['name'];
												$inv_desc = $inv_items[$type][$key]['desc'];
												$one_way = $inv_items[$type][$key]['oneway'];
												$surcharge = $inv_items[$type][$key]['surcharge'];
												$surcharge_total = $inv_items[$type][$key]['total'];
												$inventory_id = $inv_items[$type][$key]['inventory_id'];
												echo $this->Form->create('Ferry_inventory',array('class'=>'sendRates'));
												echo $this->Form->input('ferry_id',array('type'=>"hidden",'value'=>''));
												echo $this->Form->input('inventory_id',array('type'=>'hidden','value'=>$inventory_id));
												echo $this->Form->input('item_id',array('type'=>'hidden','value'=>$inv_id));
												
											?>
												<tr id="setRate-<?php echo $inv_id;?>" class="setRate" name="<?php echo $inventory_id;?>">
													<td><?php echo $inv_name;?></td>
													<td><?php echo $inv_desc;?></td>
													<td id="setOneWayTd-<?php echo $inv_id;?>" class="setOneWayTd control-group">
														<div class="controls">
															<div class="input-prepend">
																<span class="add-on">US$</span>
																<input type="text" class="ferry_oneWay span2" value="<?php echo $one_way;?>" old="<?php echo $one_way;?>" changed="No"/>
															</div>
															<span class="help-block"></span>														
														</div>
													</td>
													<td id="setSurchargeTd-<?php echo $inv_id;?>" class="setSurchargeTd control-group">
														<div class="controls">
															<div class="input-prepend">
																<span class="add-on">US$</span>
																<input type="text" class="ferry_surcharge span2" value="<?php echo $surcharge;?>" old="<?php echo $surcharge;?>" changed="No"/>
															</div>
															<span class="help-block"></span>														
														</div>
													</td>
													<td id="setSurchargeTotalTd-<?php echo $inv_id;?>"class="setSurchargeTotalTd control-group">
														<div class="controls">
															<div class="input-prepend">
																<span class="add-on">US$</span>
																<input type="text" class="ferry_surchargeTotal span2" value="<?php echo $surcharge_total;?>" old="<?php echo $surcharge_total;?>" changed="No" disabled="disabled"/>
															</div>
															<span class="help-block"></span>														
														</div>
	
													</td>
												</tr>
											<?php
												echo $this->Form->end();
											endforeach;	
											?>
								    		</tbody>
								    	</table>
										<div id="ferry_limits-<?php echo $inv_id;?>" class="ferry_limits form-horizontal offset5 form-actions" name="<?php echo $inventory_id;?>">
										<legend name="<?php echo $type;?>">Set <?php echo $type;?> Capacity</legend>
										<?php
										$total_reserved  = $limits[$inventory_id]['reservable'];
										$total_allowed = $limits[$inventory_id]['total_units'];
										$total_perc = round(($total_reserved/$total_allowed)*100,2);
										echo $this->Form->create('Ferry_limit');
										echo $this->Form->input('total_reserved',
											array(
												'div'=>array('class'=>'ferryReservableUnitsDiv control-group','id'=>'ferryReservableUnitsDiv-'.$inv_id),
									        	'label' => array('class' => 'control-label','text'=>'Reservable Units Allowed'),
									        	'between' => '<div class="controls"><div class="input-prepend input-append"><span class="add-on">#</span>',
									        	'after' => '<span class="add-on">Units</span></div><span class="help-block"></span></div>',
									        	'error' => array('attributes' => array('class' => 'help-block')),
									        	'class' => 'ferry_reservableUnits span2',
									        	'type'=>'text',
									        	'value'=>$total_reserved,
									        	'old'=>$total_reserved,
									        	'changed'=>'No',
									        	'placeholder'=>'Enter reservabled units'			
											)
										);
										echo $this->Form->input('total_allowed',
											array(
												'div'=>array('class'=>'ferryTotalUnitsDiv control-group','id'=>'ferryTotalUnitsDiv-'.$inv_id),
									        	'label' => array('class' => 'control-label','text'=>'Total Units Allowed'),
									        	'between' => '<div class="controls"><div class="input-prepend input-append"><span class="add-on">#</span>',
									        	'after' => '<span class="add-on">Units</span></div><span class="help-block"></span></div>',
									        	'error' => array('attributes' => array('class' => 'help-block')),
									        	'class' => 'ferry_totalUnits span2',
									        	'type'=>'text',
									        	'value'=>$total_allowed,
									        	'old'=>$total_allowed,
									        	'changed'=>'No',
									        	'placeholder'=>'Enter total units'			
											)
										);
										echo $this->Form->input('total_percent',
											array(
												'div'=>array('class'=>'ferryCapacityDiv control-group','id'=>'ferryCapacityDiv-'.$inv_id),
									        	'label' => array('class' => 'control-label','text'=>'Reservable Capacity'),
									        	'between' => '<div class="controls"><div class="input-append">',
									        	'after' => '<span class="add-on">%</span></div><span class="help-block"></span></div>',
									        	'error' => array('attributes' => array('class' => 'help-block')),
									        	'class' => 'ferry_capacity span1',
									        	'type'=>'text',
									        	'value'=>$total_perc,
									        	'old'=>$total_perc,
									        	'changed'=>'No',
									        	'disabled'=>'disabled',				
											)
										);
										echo $this->Form->end();
										?>
									</div>
								</div>
							</div>
						</div>
						<?php
						endforeach;
						?>
					</div>
					<button id="attributesBackButton" class="btn btn-large">Back To Attributes</button>
					<button id="previewSchedule" class="btn btn-primary">Preview Schedule</button>
				</div>
			</div>
		</div>		
	</div>
</div>

<form id="previewScheduleForm" method="post" action="/schedules/preview">
	
</form>



