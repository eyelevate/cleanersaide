<?php
echo $this->Html->script(array(
	'admin/plugins/validation/jquery.validate.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/schedules_edit.js'),
	FALSE
);


?>

<h2 class="heading">Edit Schedule</h2>

<div class="formSep">
	<h3 class="heading">Edit By Time</h3>
	<table id="tripTimeTable-master" class="table table-bordered">
		<thead>
			<tr>
				<th>Select Trip</th>
				<th>Leaving Port Angeles</th>
				<th>Leaving Victoria</th>
				<th>Actions</th>
			</tr>
		</thead>	
		<tbody>
			<tr>
				<td class="control-group">
					<?php
					//get the trip count
					
					?>
					<select class="chooseTripNumber">
						<option value="none">Choose Trip Number</option>
						<?php
						for ($i=1; $i <= $avg_trips; $i++) { 
						?>
						<option value="<?php echo $i;?>"><?php echo $i;?></option>
						<?php
						}
						?>
					</select>
					<span class="help-block"></span>
				</td>
				<td class="control-group">
					<input id="tripStart" type="text" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead"/>
					<span class="help-block"></span>									
				</td>
				<td>
					<input id="tripEnd" type="text" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead"/>
					<span class="help-block"></span>									
				</td>
				<td>
					<button id="setAllByTripButton" class="btn btn-primary btn-small">Edit All</button>
				</td>
			</tr>
		</tbody>
	</table>				
</div>
<?php
//start the form
echo $this->Form->create('edit',array('class'=>'formEdit'));

?>
<input type="hidden" name="data[form_type]" value="Edit_Final"/>
<div id="side_accordion2" class="accordion">
	<h3 class="heading">Service Schedule</h3>
	<?php

	foreach ($edit as $key => $value) {
		$created_id = strtotime($key);
		$today =date('n/d/Y l',strtotime($key));
	?>
	<div class="accordion-group" id="dateEdit">
		<div class="accordion-heading sdb_h_active">
			<a href="#collapse-<?php echo $created_id;?>" data-parent="#side_accordion2" data-toggle="collapse" class="accordion-toggle">
				<?php echo $today;?> 
				<span class="label label-warning">Not Edited</span>
			</a>
		</div>	
		<div class="accordion-body collapse" id="collapse-<?php echo $created_id;?>">
			<div class="accordion-inner">
				<table id="tripTimeTable-<?php echo $created_id;?>" class="table table-bordered">
					<thead>
						<tr>
							<th>Trip</th>
							<th>Leaving Port Angeles</th>
							<th>Leaving Victoria</th>
							<!-- <th>Actions</th> -->
						</tr>
					</thead>
					<tbody id="tripTimeTableTbody">
						<?php
						$idx = 0;

						foreach ($edit[$key] as $ekey => $evalue) {
							$idx = $idx+1;
						
						?>
						<tr id="trip-<?php echo $key;?>" class="tripTr" row="<?php echo $idx;?>">
							<td><?php echo $ekey;?></td>
							<?php

							foreach ($edit[$key][$ekey] as $lkey =>$lvalue) {
								$departs = $edit[$key][$ekey][$lkey]['departs'];	
								$trip_id = $edit[$key][$ekey][$lkey]['id'];
								$value = $edit[$key][$ekey][$lkey]['time'];
								$service_date = date('Y-m-d',strtotime($edit[$key][$ekey][$lkey]['date']));
								
								if($departs=='Port Angeles'){
								?>
								<td id="dest1" class="control-group" row="<?php echo $trip_id;?>" city="PortAngeles">
									<div class="input-append">
										<input status="notedited" id="tripTime-<?php echo $trip_id;?>" class="tripTimeInput" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead" type="text" name="data[Schedule][<?php echo $trip_id;?>][depart_time]" value="<?php echo $value;?>" old="<?php echo $value;?>"/>									
										<span class="deleteDateButton add-on btn btn-link" row="<?php echo $trip_id;?>" status="notdeleted">Delete Sailing</span>	
									</div>
									<input type="hidden" name="data[Schedule][<?php echo $trip_id;?>][service_date]" value="<?php echo $service_date;?>"/>
								</td>	
								<?php	
								} else {
								?>
								<td id="dest2" class="control-group" row="<?php echo $trip_id;?>" city="Victoria">
									<div class="input-append">
										<input status="notedited" id="tripTime-<?php echo $trip_id;?>" class="tripTimeInput" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead" type="text" name="data[Schedule][<?php echo $trip_id;?>][depart_time]" value="<?php echo $value;?>" old="<?php echo $value;?>"/>												
										<span class="deleteDateButton add-on btn btn-link" row="<?php echo $trip_id;?>" status="notdeleted">Delete Sailing</span>
									</div>
									<input type="hidden" name="data[Schedule][<?php echo $trip_id;?>][service_date]" value="<?php echo $service_date;?>"/>
								</td>
								<?php
								}									

							} 
						
							?>
							
							<!-- <td><button class="btn btn-link">Delete Trip</button></td> -->
						</tr>
						<?php							
						}
						?>

					</tbody>
				</table>

			</div>
		</div>	
	</div>
	<?php		
	}
	if(!empty($nis)){
		?>
		<div class="formSep"></div>
		<h3 class="heading">Not In Service</h3>
		<?php
		//debug($nis);
		foreach ($nis as $key => $value) {
			$created_id = strtotime($key);
			$today =date('n/d/Y l',strtotime($nis[$key]['newStart']));
			$trip_id = $nis[$key]['id'];
		?>
		<div id="removeNIS-<?php echo $trip_id;?>" class="alert alert-error" style="margin-bottom:2px;">
			
			<span>Not In Service <?php echo $today;?></span> 
			<span class="removeNIS pull-right" row="<?php echo $trip_id;?>" style="cursor:pointer">Remove</span>	
			
		</div>
		<?php			
		}
	}
	?>
	
<br/>
<div class="formSep"></div>
<h3 class="heading">Edit Rates & Limits <small><em>will set for above trips only</em></small></h3>
<div id="side_accordion4" class="accordion">
	<?php

	foreach ($inv_items as $key=>$value):
		$type = $key;
	?>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-<?php echo $type;?>" data-parent="#side_accordion4" data-toggle="collapse" class="accordion-toggle">Set <?php echo $type;?> Rates & Limits <span class="label label-warning">Not Edited</span></a>
				
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
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">US$</span>
											<input type="text" class="ferry_oneWay span2" value="<?php echo $one_way;?>" old="<?php echo $one_way;?>" name="data[Schedule_rate][<?php echo $inv_id;?>][one_way]" changed="No"/>
									
										</div>
										<span class="help-block"></span>														
									</div>
								</td>
								<td id="setSurchargeTd-<?php echo $inv_id;?>" class="setSurchargeTd control-group">
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">US$</span>
											<input type="text" class="ferry_surcharge span2" value="<?php echo $surcharge;?>" old="<?php echo $surcharge;?>" name="data[Schedule_rate][<?php echo $inv_id;?>][surcharge]" changed="No"/>
										</div>
										<span class="help-block"></span>														
									</div>
								</td>
								<td id="setSurchargeTotalTd-<?php echo $inv_id;?>"class="setSurchargeTotalTd control-group">
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">US$</span>
											<input type="text" class="ferry_surchargeTotal span2" value="<?php echo $surcharge_total;?>" old="<?php echo $surcharge_total;?>" name="data[Schedule_rate][<?php echo $inv_id;?>][total_surcharged]" changed="No"/>
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
					$total_reserved  = $ferry_limit[$inventory_id]['reservable'];
					$total_allowed = $ferry_limit[$inventory_id]['total_units'];
					$total_perc = round(($total_reserved/$total_allowed)*100,2);

					echo $this->Form->input('Schedule_limit.'.$inv_id.'.reservableUnits',
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
					echo $this->Form->input('Schedule_limit.'.$inv_id.'.totalUnits',
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
					echo $this->Form->input('Schedule_limit.'.$inv_id.'.total_percent',
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

					?>
				</div>
			</div>
		</div>
	</div>
	<?php
	endforeach;
	?>
</div>
<div class="formSep"></div>
<!-- special delete div that adds extra hidden input forms of dates that were deleted by the user -->
<div id="deleteDiv"></div>

<?php
//echo $this->Form->submit('Save Changes',array('class'=>'btn btn-primary btn-large pull-right'));

echo $this->Form->end();
?>
<button id="saveScheduleEditButton" type="button" class="btn btn-primary pull-right">Save Changes</button>
</div>
<input id="minutesArray" type="hidden" value="<?php echo $minutesArray;?>"/>

