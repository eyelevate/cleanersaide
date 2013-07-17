<?php
//load scripts
echo $this->Html->script(array('admin/schedules_add.js','admin/schedule_save.js'),FALSE);
//set base variables
if(!empty($_POST)){
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$trips = $_POST['trips'];
	$rates_id = $_POST['rates_id'];
} else {
	$start_date = '';
	$end_date = '';
	$trips = '';
	$rates_id = '';
}
?>
<div class="">
	<legend>Schedule Preview</legend>
	<h3>Time Frame</h3>
	<div class="form-actions">	
		<ul class="form-horizontal unstyled">
			<li class="control-group">
				<label class="control-label">Start Date</label>
				<div class="controls">
					<input type="text" disabled="disabled" value="<?php echo $start_date;?>"/>
				</div>
				
			</li>
			<li class="control-group">
				<label class="control-label">End Date</label>
				<div class="controls">
					<input type="text" disabled="disabled" value="<?php echo $end_date;?>"/>
				</div>
				
			</li>
			<li class="control-group">
				<label class="control-label">Total Trips Per Day</label>
				<div class="controls">
					<input type="text" disabled="disabled" value="<?php echo $trips;?>"/>
				</div>
			</li>
		</ul>
	</div>
	
	<h3>Trips & Departure Time</h3>
	<div class="form-actions">
		<ul class="form-horizontal unstyled">
		<?php
		for ($i=1; $i <= $trips; $i++) {
			$start_name = 'depart_1_'.$i;
			$end_name = 'depart_2_'.$i; 
			$start[$i] = $_POST[$start_name];
			$end[$i] = $_POST[$end_name];
			?>
			<legend>Trip <?php echo $i;?></legend>
			<li id="tripTimeLi-<?php echo $i;?>" class="tripTimeLi control-group" name="depart1">
				
				<label class="control-label">Departs Port Angeles</label>
				<div class="controls">
					<input id="tripD1-<?php echo $i;?>" class="tripD1" type="text" disabled="disabled" value="<?php echo $start[$i];?>"/>
				</div>
			</li>
			<li id="tripTimeLi-<?php echo $i;?>" class="tripTimeLi control-group" name="depart2">
				<label class="control-label">Departs Victoria</label>
				<div class="controls">
					<input id="tripD2-<?php echo $i;?>" class="tripD2" type="text" disabled="disabled" value="<?php echo $end[$i];?>"/>
				</div>
			</li>
			<?php
		}
		?>
		</ul>
	</div>
	
	<h3>Rates & Capacity</h3>
	<div class="form-actions">
		<ul class="form-horizontal unstyled">
		<?php
	
		foreach ($inv_items as $key=>$value):
			$type = $key;
			//get limits
			$limit_reserved_name = 'limit_'.$type.'_reserved';
			$limit_reserved = $_POST[$limit_reserved_name];
			$limit_total_name = 'limit_'.$type.'_total';
			$limit_total = $_POST[$limit_total_name];
			$limit_perc = round(($limit_reserved/$limit_total)*100,2);

			?>
			<li id="capacityLi-<?php echo $type;?>" class="capacityLi control-group" limit="<?php echo $limit_reserved;?>" total="<?php echo $limit_total;?>">
				<legend><?php echo $type;?> - <?php echo $limit_perc;?>% Reservable [<?php echo $limit_reserved;?> Units Allowed / <?php echo $limit_total;?> Units Total] </legend>
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
						$inv_type = $inv_items[$type][$key]['type'];
						$inv_name = $inv_items[$type][$key]['name'];
						$inv_desc = $inv_items[$type][$key]['desc'];
						$inventory_id = $inv_items[$type][$key]['inventory_id'];
						$one_way_name = 'rates_oneWay_'.$inventory_id.'_'.$inv_id;
						$surcharge_name = 'rates_surcharge_'.$inventory_id.'_'.$inv_id;
						$surchargeTotal_name = 'rates_total_'.$inventory_id.'_'.$inv_id;
						$one_way = $_POST[$one_way_name];
						$surcharge = $_POST[$surcharge_name];
						$surcharge_total = $_POST[$surchargeTotal_name];

					?>
						<tr id="setRate-<?php echo $inv_id;?>" class="setRate" name="<?php echo $inventory_id;?>">
							<td><?php echo $inv_name;?></td>
							<td><?php echo $inv_desc;?></td>
							<td id="setOneWayTd-<?php echo $inv_id;?>" class="setOneWayTd">
								<div class="input-prepend">
									<span class="add-on">US$</span>
									<input class="ferry_oneWay span2" type="text" disabled="disabled" value="<?php echo $one_way;?>"/>
								</div>
								
							</td>
							<td id="setSurchargeTd-<?php echo $inv_id;?>" class="setSurchargeTd">
									<div class="input-prepend">
										<span class="add-on">US$</span>
										<input type="text" class="ferry_surcharge span2" disabled="disabled" value="<?php echo $surcharge;?>"/>
									</div>
							</td>
							<td id="setSurchargeTotalTd-<?php echo $inv_id;?>"class="setSurchargeTotalTd">
									<div class="input-prepend">
										<span class="add-on">US$</span>
										<input type="text" class="ferry_surchargeTotal span2" disabled="disabled" value="<?php echo $surcharge_total;?>"/>
									</div>

							</td>
						</tr>
					<?php
						
						echo $this->Form->end();
					endforeach;	
					?>
		    		</tbody>
		    	</table>
			</li>
			<?php
		endforeach;
		?>
		</ul>	
	</div>	
	
<?php
echo $this->Form->create('Schedule',array('action'=>'add','class'=>'saveScheduleForm'));
//save time first
$startMonth = substr($start_date,0,2);
$startDay = substr($start_date,3,2);
$startYear = substr($start_date,-4);
$endMonth = substr($end_date,0,2);
$endDay = substr($end_date,3,2);
$endYear = substr($end_date,-4);
$startDate = strtotime($startYear.'-'.$startMonth.'-'.$startDay.' 00:00:00');
$endDate = strtotime($endYear.'-'.$endMonth.'-'.$endDay.' 00:00:00');
$total_days = ($endDate-$startDate)/86400;
$count = -1;

for ($i=0; $i <= $total_days; $i++) {
	 
	$newDay = date('Y-m-d',strtotime(date("Y-m-d H:i:s", $startDate)."+".$i." day"));
	for ($a=1; $a <= $trips; $a++) {
		$start_name = 'depart_1_'.$a;
		//rearrange start for 24 hr time 
		$start = $_POST[$start_name];
		$timeConverted = date('H:i',strtotime($start));
		$dateStart = $newDay.' '.$timeConverted.':00';
		$dateStart = date('Y-m-d H:i:s',strtotime($dateStart));
		$special_check_date = date('Y-m-d',strtotime($dateStart)).' 00:00:00';
		//departing Port Angeles
		$count = $count+1;
		$service_date = 'Schedule.'.$count.'.service_date';
		$check_date = 'Schedule.'.$count.'.check_date';
		$depart_start = 'Schedule.'.$count.'.depart_time';
		$departs = 'Schedule.'.$count.'.departs';
		$tripNumber = 'Schedule.'.$count.'.trip';
		$rates_id_name = 'Schedule.'.$count.'.rates_id';
		echo $this->Form->input($tripNumber, array('type'=>'hidden','value'=>$a));
		echo $this->Form->input($service_date,array('type'=>'hidden','value'=>$dateStart));
		echo $this->Form->input($check_date,array('type'=>'hidden','value'=>$special_check_date));
		echo $this->Form->input($depart_start, array('type'=>'hidden', 'value'=>$start));
		echo $this->Form->input($departs,array('type'=>'hidden','value'=>'Port Angeles'));	
		echo $this->Form->input($rates_id_name,array('type'=>'hidden','value'=>$rates_id));	
	}
	for ($a=1; $a <= $trips; $a++) {
		$end_name = 'depart_2_'.$a; 
		//rearrange end for 24 hr time
		$end = $_POST[$end_name];	
		$timeConverted = date('H:i',strtotime($end));
		$dateEnd = $newDay.' '.$timeConverted.':00';
		$dateEnd = date('Y-m-d H:i:s',strtotime($dateEnd));
		$special_check_date = date('Y-m-d',strtotime($dateEnd)).' 00:00:00';
		//departing Port Angeles
		$count = $count+1;
		$service_date = 'Schedule.'.$count.'.service_date';
		$check_date = 'Schedule.'.$count.'.check_date';
		$depart_start = 'Schedule.'.$count.'.depart_time';
		$departs = 'Schedule.'.$count.'.departs';
		$tripNumber = 'Schedule.'.$count.'.trip';
		$rates_id_name = 'Schedule.'.$count.'.rates_id';
		echo $this->Form->input($tripNumber, array('type'=>'hidden','value'=>$a));
		echo $this->Form->input($service_date,array('type'=>'hidden','value'=>$dateEnd));
		echo $this->Form->input($check_date,array('type'=>'hidden','value'=>$special_check_date));
		echo $this->Form->input($depart_start, array('type'=>'hidden', 'value'=>$end));
		echo $this->Form->input($departs,array('type'=>'hidden','value'=>'Victoria'));	
		echo $this->Form->input($rates_id_name,array('type'=>'hidden','value'=>$rates_id));		
	}	
}
$count = -1;
foreach ($inv_items as $key=>$value){
	$type = $key;
	//get limits
	$inventory_id = $switchInv[$type];
	$limit_reserved_name = 'limit_'.$type.'_reserved';
	$limit_reserved = $_POST[$limit_reserved_name];
	$limit_total_name = 'limit_'.$type.'_total';
	$limit_total = $_POST[$limit_total_name];
	$limit_perc = round(($limit_reserved/$limit_total)*100,2);
	$count = $count+1;
	$inventory = 'Schedule_limit.'.$count.'.inventory_id';
	echo $this->Form->input($inventory,array('type'=>'hidden','value'=>$inventory_id));
	$reservableUnits = 'Schedule_limit.'.$count.'.reservableUnits';
	echo $this->Form->input($reservableUnits,array('type'=>'hidden','value'=>$limit_reserved));
	$totalUnits = 'Schedule_limit.'.$count.'.totalUnits';
	echo $this->Form->input($totalUnits,array('type'=>'hidden','value'=>$limit_total));
}

if($rates_id =='2'){
	foreach ($inv_items as $key=>$value){
		$type = $key;
		
		foreach ($inv_items[$type] as $key=>$value){
			$inv_id = $inv_items[$type][$key]['id'];
			$inv_type = $inv_items[$type][$key]['type'];
			$inv_name = $inv_items[$type][$key]['name'];
			$inv_desc = $inv_items[$type][$key]['desc'];
			$inventory_id = $inv_items[$type][$key]['inventory_id'];
			$one_way_name = 'rates_oneWay_'.$inventory_id.'_'.$inv_id;
			$surcharge_name = 'rates_surcharge_'.$inventory_id.'_'.$inv_id;
			$surchargeTotal_name = 'rates_total_'.$inventory_id.'_'.$inv_id;
			$one_way = $_POST[$one_way_name];
			$surcharge = $_POST[$surcharge_name];
			$surcharge_total = $_POST[$surchargeTotal_name];
			$inventory_id_rates = 'Schedule_rate.'.$key.'.inventory_id';
			echo $this->Form->input($inventory_id_rates,array('type'=>'hidden','value'=>$inventory_id));
			$item_id_rates = 'Schedule_rate.'.$key.'.item_id';
			echo $this->Form->input($item_id_rates,array('type'=>'hidden','value'=>$inv_id));
			$one_way_rates = 'Schedule_rate.'.$key.'.one_way';
			echo $this->Form->input($one_way_rates,array('type'=>'hidden','value'=>$one_way));
			$surcharge_rates = 'Schedule_rate.'.$key.'.surcharge';
			echo $this->Form->input($surcharge_rates,array('type'=>'hidden','value'=>$surcharge));
			$total_surcharged_rates = 'Schedule_rate.'.$key.'.total_surcharged';
			echo $this->Form->input($total_surcharged_rates,array('type'=>'hidden','value'=>$surcharge_total));
			
		}
	}	
}
		

echo $this->Html->tag('button','Cancel',array('class'=>'btn btn-large pull-left', 'id'=>'cancelFerrySchedule','style'=>''));
?>
<div step="1" type="button" class="save_schedule_button span2 btn btn-primary btn-large pull-left" href="#step1Warning" role="button" data-toggle="modal" data-backdrop="static" data-keyboard="false">Save & Close</div>
<?php
echo$this->Form->end();

?>
</div>
	

	<!-- Modal -->
	<div id="step1Warning" row="1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="sampleWarningLabel" aria-hidden="true">
	  <div class="stepValidationErrors">
		  <div class="modal-header">
		    <h3 id="sampleWarningLabel">Processing new schedule</h3>
		  </div>
		  <div class="modal-body">
				<p class="text text-info">Please wait as we process your new schedule. This may take up to a minute.</p>
		    
		  </div>
	
		  <div class="modal-footer">

		  </div>	  	
	  </div>

	</div>
</div> <!-- .row-fluid -->
