<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'../js/frontend/plugins/popovers/css/bootstrap.min.css',
	'frontend/bootstrap-form',
	'frontend/reservation_ferry'
	),
	'stylesheet',
	array('inline'=>false)
);

echo $this->Html->script(array(
	'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui file
	'frontend/reservation_ferry.js',
	'frontend/reservation_sidebar.js',
	'frontend/plugins/popovers/js/bootstrap.min.js'
	),
	FALSE
);


//create variables here
if($depart_port ==''){
	$depart_port = 'Port Angeles';
	$return_port = 'Victoria';
}

if($trip_type != ''){
	if($trip_type == 'roundtrip'){
		if($depart_date != '' && $return_date != ''){
			$trip_dates = date('l',strtotime($depart_date)).' '.$depart_date.' - '.date('l',strtotime($return_date)).' '.$return_date;
		} else {
			$trip_dates = 'No dates selected';
		}
	} else {
		if($depart_date != '' && $return_date != ''){
			$trip_dates = date('l',strtotime($depart_date)).' '.$depart_date;
		} else {
			$trip_dates = 'No date selected';
		}
		
	}
}
if($adults == '' && $children == ''){
	$total_passengers = 0;
} else {
	$total_passengers = $adults + $children;	
}

//session counter comes from controller based on cookies set if not saved for after 20 mins then delete and start over


?>

        <script>
            $(document).ready(function () {
                $('body').popover({
				    selector: '.icon-question-sign',
				    html: true
				});
            });
        </script>

<div class="container">

	<div class="row">
		<div class="sixteen columns">
		   
			<div class="page_heading"><h1>Ferry Reservation</h1></div>
						

			
<!-- 			<div class="breadcrumb">
		        <a href="index.html" class="first_bc"><span>Home</span></a>
		        <a href="page_right_sidebar.html" class="last_bc"><span>Test Page</span></a>
		    </div> -->
		</div>		
	</div>
	
	<div class="row">
			<!-- Wide Column -->
			<div class="twelve columns alpha">
				<form id="formFerry" action="/reservations/processing" method="post" index="<?php echo $index;?>">
					<input id="index" value="<?php echo $index;?>" type="hidden"/>
					<fieldset class="twelve columns">
						<!-- <label style="font-weight: normal; font-style: italic;">Select Reservation Type</label>	 -->				
						<ul id="inventoryList" class="tabbable">
						<?php
						foreach ($inventories as $inventory) {
							$inventory_name = $inventory['Inventory']['name'];
							switch ($inventory_name) {
								case 'Vehicles':
									$name = 'Vehicle';
									$activeClass = 'class="active"';
									break;
								case 'Passengers':
									$name = 'Walk-on';
									$activeClass = '';
									break;
									
								case 'Motorcycles':
									$name = 'Motorcycle';
									$activeClass = '';
									
									break;
								default:
									$name = 'Bicycle';
									$activeClass = '';
									break;
							}
							//select the active class
							$inventory_id = $inventory['Inventory']['id'];

							?>
							<li inventory_name="<?php echo $inventory_name;?>" inventory_id="<?php echo $inventory_id;?>">
								<a <?php echo $activeClass;?> href="#inventory-<?php echo $inventory_name;?>">
									<i class="inventory-icons-<?php echo $inventory_name;?>"></i>	
									<span class="listSpan"><?php echo $name;?></span>
								</a>
							</li>
								
							<?php
						}
						?> <div style="clear:both;"></div><?
						foreach ($inventories as $inventory) {
							$inventory_name = $inventory['Inventory']['name'];
							$towed_units = json_decode($inventory['Inventory']['towed_units'], true);
							switch($inventory_name){
								case 'Vehicles':
								?>
								<div id="inventory-<?php echo $inventory_name;?>">
									<div class="row-fluid">
										<div class="control-group span6">
											<label>How many vehicles?</label>
											<input id="vehicle_count" type="text" value="1" name="data[Reservation][<?php echo $index;?>][vehicle_count]"/>	
										</div>
										<div id="vehicleTypeAndIncUnitsDiv" class="control-group span6">
										<div id="vtaiud-primary" class="vtaiud">
											<div class="vehicleTypeDiv control-group" style="margin-bottom: 0px;">									
												<label id="vehicleTypeLabel">Select Vehicle Type</label>
												<select class="vehicle_type" name="data[Reservation][<?php echo $index;?>][vehicle][0][inventory_item_id]">
													<option value="">select vehicle</option>
													<?php
													foreach ($inventory_items as $ii) {
														$ii_name = $ii['Inventory_item']['name'];
														$ii_id = $ii['Inventory_item']['id'];
														$ii_inventory_id = $ii['Inventory_item']['inventory_id'];
														$ii_type = $ii['Inventory_item']['type'];
														if($ii_type == 'Vehicles'){
															if($ii_id == '22'){
															?>
															<option inventory_id="<?php echo $ii_inventory_id;?>" value="<?php echo $ii_id;?>" selected="selected"><?php echo $ii_name;?></option>
															<?php																	
															} else {
															?>
															<option inventory_id="<?php echo $ii_inventory_id;?>" value="<?php echo $ii_id;?>"><?php echo $ii_name;?></option>
															<?php																	
															}

														}
													}										
													?>
												</select>
												<span class="help-block"></span>	
											</div>		
											<div id="overlengthDiv" class="hide">
												<div class="control-group">
													<label>Overall length (including towed unit)</label>
													<input id="overlengthAmount" class="overlengthInput" type="text" name="data[Reservation][<?php echo $index;?>][vehicle][0][overlength]"/>													
													<span class="help-block"></span>
												</div>
												

												<?php
												$towed_options = array();
												$tu_idx = -1;
												foreach ($towed_units as $tu) {
													$tu_idx++;
													$towed_name = $tu['name'];
													$towed_desc = $tu['desc'];
													$towed_options[$towed_name.' ('.$towed_desc.')'] = $towed_name.' ('.$towed_desc.')'; 
												}
												echo $this->Form->input('Reservation.'.$index.'.vehicle.0.towed_unit',array(
													'div'=>array('class'=>'control-group'),
													'class'=>'towed_units',
													'label'=>'<label>Towed Unit (if applicable)</label>',
													'options'=>$towed_options,
													'error'=>array('attributes'=>array('class'=>'help-block')),
												));
												?>
												
												
											</div>								
										</div>
										<!-- new inserted vehicle form-->
										<div id="extraVehicleAndIncUnitsDiv"></div>
									</div>
																		
									</div>
									

										<label>How many additional passengers? </label>
									<div class="row-fluid">
										<div class="control-group span3">
											<label class="sub-label">Driver</label>
											<input class="drivers" class="singleinput" type="text" value="1" name="data[Reservation][<?php echo $index;?>][drivers]" readonly/>
											
										</div>
										<?php
										$additional_adults = $adults - 1;
										if($additional_adults < 0){
											$additional_adults = 0;
										}
										
										?>
										<div class="control-group span3">
											<label class="sub-label">Extra Adults (ages 12+)</label>
											<input class="adults" class="singleinput" type="text" value="<?php echo $additional_adults;?>" name="data[Reservation][<?php echo $index;?>][adults]"/>
										</div>
										<div class="control-group span3">
											<label class="sub-label">Children (ages 5-11)</label>
											<input class="children" class="singleinput" type="text" value="<?php echo $children;?>" name="data[Reservation][<?php echo $index;?>][children]"/>
										</div>
										<div class="control-group span3">
											<label class="sub-label">Children (ages 0-4)</label>
											<input class="infants" class="singleinput" type="text" value="<?php echo $infants;?>" name="data[Reservation][<?php echo $index;?>][infants]"/>
										</div>
									</div>
								</div>								
								<?php									
								break;
									
								case 'Passengers':
								?>
								<div id="inventory-<?php echo $inventory_name;?>">
									<label>How many passengers?</label>
									<div class="row-fluid">

										<div class="control-group span3">
											<label class="sub-label">Adults (ages 12+)</label>
											<input class="adults" type="text" value="<?php echo $adults;?>" name="data[Reservation][<?php echo $index;?>][adults]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
										<div class="control-group span3">
											<label class="sub-label">Children (ages 5-11)</label>
											<input class="children" type="text" value="<?php echo $children;?>" name="data[Reservation][<?php echo $index;?>][children]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
										<div class="control-group span3">
											<label class="sub-label">Children (ages 0-4)</label>
											<input class="infants" type="text" value="<?php echo $infants;?>" name="data[Reservation][<?php echo $index;?>][infants]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
									</div>
								</div>								
								<?php	
								break;
									
								case 'Motorcycles':
								?>
								<div id="inventory-<?php echo $inventory_name;?>" >
									<div class="row-fluid">
										<div class="control-group span6">
											<label>How many motorcycles?</label>
											<input id="motorcycle_count" type="text" value="1" name="data[Reservation][<?php echo $index;?>][vehicle_count]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
	
										<div id="motorcycleTypeAndIncUnitsDiv" class="control-group span6">
											<div id="mtaiud-primary" class="mtaiud">
												<div class="motorcycleTypeDiv control-group" style="margin-bottom:0px">									
													<label id="motorcycleTypeLabel">Select motorcycle type</label>
													<select class="motorcycle_type" name="data[Reservation][<?php echo $index;?>][motorcycle][0][inventory_item_id]" disabled="disabled">
														<option value="">Select motorcycle</option>
														<?php
														foreach ($inventory_items as $ii) {
															$ii_name = $ii['Inventory_item']['name'];
															$ii_id = $ii['Inventory_item']['id'];
															$ii_inventory_id = $ii['Inventory_item']['inventory_id'];
															$ii_type = $ii['Inventory_item']['type'];
															if($ii_type == 'Motorcycles'){
															?>
															<option inventory_id="<?php echo $ii_inventory_id;?>" value="<?php echo $ii_id;?>"><?php echo $ii_name;?></option>
															<?php	
															}
														}										
														?>											
													</select>
													<span class="help-block"></span>	
												</div>		
										
											</div>
											<div id="extraMotorcycleAndIncUnitsDiv">
												
											</div>
										</div>	
									</div>						
									
									
									<label>How many passengers?</label>
									<div class="row-fluid">
										<div class="control-group span3">
											<label class="sub-label">Adults (ages 12+)</label>
											<input class="adults" id="motorcycle-adults" type="text" value="<?php if ($adults) {echo $adults;} else {echo "1";}?>" name="data[Reservation][<?php echo $index;?>][adults]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
										<div class="control-group span3">
											<label class="sub-label">Children (ages 5-11)</label>
											<input class="children" type="text" value="<?php echo $children;?>" name="data[Reservation][<?php echo $index;?>][children]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
										<div class="control-group span3">
											<label class="sub-label">Children (ages 0-4)</label>
											<input class="infants" type="text" value="<?php echo $infants;?>" name="data[Reservation][<?php echo $index;?>][infants]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
									</div>
								</div>								
								
								<?php	
								break;
									
								case 'Bicycles':
								?>
								<div id="inventory-<?php echo $inventory_name;?>">
									<div class="row-fluid">
										<div class="control-group span6">
											<label>How many bicycles?</label>
											<input id="bicycle_count" type="text" name="data[Reservation][<?php echo $index;?>][vehicle_count]" value="1" disabled="disabled"/>
											<input id="bicycle_id" type="hidden" name="data[Reservation][<?php echo $index;?>][vehicle][0][inventory_item_id]" value="28" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
									</div>
	
									<label>How many passengers?</label>
									<div class="row-fluid">
										<div class="control-group span3">
											<label class="sub-label">Adults (ages 12+)</label>
											<input class="adults" id="bicycle-adults" type="text" value="<?php if ($adults) {echo $adults;} else {echo "1";}?>" name="data[Reservation][<?php echo $index;?>][adults]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
										<div class="control-group span3">
											<label class="sub-label">Children (ages 5-11)</label>
											<input class="children" type="text" value="<?php echo $children;?>" name="data[Reservation][<?php echo $index;?>][children]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
										<div class="control-group span3">
											<label class="sub-label">Children (ages 0-4)</label>
											<input class="infants" type="text" value="<?php echo $infants;?>" name="data[Reservation][<?php echo $index;?>][infants]" disabled="disabled"/>
											<span class="help-block"></span>
										</div>
									</div>
								</div>								
								<?php	
								break;
							}
							
						}
						?>
						</ul>	
					</fieldset>								
						
					<fieldset class="six columns omega row-fluid">
						<div class="span12">
							<div class="well well-small" >
								<legend ><strong>Is this a roundtrip or a one-way trip? <span class="f_req">*</span></strong></legend>
								<?php
								if($trip_type == 'roundtrip'){
									$roundtrip_checked = 'checked="checked"';
									$oneway_checked = '';
								} else {
									$roundtrip_checked = '';
									$oneway_checked = 'checked="checked"';
								}
								
								?>
								<div class="control-group">
									<label for="roundtrip" style="display: inline-block; margin-right: 10px;margin-bottom: 10px; font-size:100%;"><input id="roundtrip" class="tripRadio" type="radio" name="data[Reservation][<?php echo $index;?>][trip_type]" value="roundtrip" <?php echo $roundtrip_checked;?>/> <span>Roundtrip</span></label>
									<label for="oneway" style="display: inline-block; margin-bottom: 10px; font-size:100%;"><input id="oneway" class="tripRadio" type="radio" name="data[Reservation][<?php echo $index;?>][trip_type]" value="oneway" <?php echo $oneway_checked;?>/> <span>One way</span></label>									
									<span class="help-block"></span>									
								</div>

							</div>	
							<div class="well well-small">
								<legend><strong>Select Depart Sailing <span class="f_req">*</span></strong></legend>
								<?php
								$options = array('Port Angeles'=>'Port Angeles','Victoria'=>'Victoria');
								echo $this->Form->input('Reservation.'.$index.'.depart_port',array(
									'div'=>array('class'=>'reservationDepartPortDiv'),
									'options'=>$options,
									'default'=>$depart_port,
									'class'=>'reservationDepartPort',
									'label'=>'Select your port of departure:'
								));
								?>
								
								<div class="row-fluid">
									
								<?
								//check to see if depart dates are reservable if not then display options for additional dates
								if($depart_date != ''){
									$depart_date = date('l',strtotime($depart_date)).' '.$depart_date;
								} else {
									$depart_date = '';
								}
								echo $this->Form->input('Reservation.'.$index.'.departs',array(
									'div'=>array('class'=>'control-group span11'),
									'label'=>false,
									'class'=>'datepicker',
									'before'=>'<label>Departing: <span id="departPortSpan">'.$depart_port.' to '.$return_port.'</span></label><div class="input-append">',
									'after'=>'<span class="add-on pointer"><i class="small-icon-calendar"></i></span></div><span class="help-block"></span>',
									'value'=>$depart_date,
									'error'=>array('attributes' => array('class' => 'help-block')),
								));
								
								
								?>
								</div>
								<div class="row-fluid">
								<div id="departTableDiv" class="control-group span12">
									
									<table id="departTable" class="table table-bordered table-condensed">
										<thead>
											<tr style="background-color: #EEE;  border-top: 1px solid #AAA;  text-transform: uppercase;  font-weight: normal;  font-size: 10px;  line-height: 15px;">
												<th>Depart Time</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php									
											if(!empty($depart_limits)){
												if($depart_limits == 'empty'){
													?>
													<tr class="noTouch">
														<td colspan="2">No date selected</td>
													</tr>
													<?php										
												} else {
													foreach ($depart_limits as $key => $value) {
														$schedule_time = $key;
														foreach ($depart_limits[$key] as $akey => $avalue) {
															$schedule_id = $depart_limits[$key][$akey]['schedule_id']; 
															$inventory_id = $depart_limits[$key][$akey]['inventory_id']; 
															$inventory_name = $depart_limits[$key][$akey]['inventory_name'];
															//if($inventory_name == 'Passengers'){
																$label = $depart_limits[$key][$akey]['label'];
															//}
														}
													?>
													
		
													<tr <? if (strpos($label,'success') !== false) {?>class="pointer touch"<? } else {?>class="noTouch"<?}?> schedule_id ="<?php echo $schedule_id;?>" inventory_id="<?php echo $inventory_id;?>" >
														<td><?php echo $schedule_time;?></td>
														<td><?php echo $label;?></td>
													</tr>
													<?php										
													}
			
												}
											} else{
												?>
												<tr class="noTouch">
													<td>Not in service</td>
													<td><span class="label label-important">No Service</span></td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
									<span style="text-align: center; display: block; font-size: 11px; font-style: italic; margin-top: -20px;">Please click on your desired sailing.</span>
								
									<span class="help-block"></span>
								</div>
								</div>								
							</div>
							<?php
							if($trip_type == 'oneway'){
								$trip_class = 'hide';
							} else {
								$trip_class = '';
							}
							if($return_date != ''){
								$return_date = date('l',strtotime($return_date)).' '.$return_date;
							} else {
								$return_date = '';
							}							
							?>
							<div id="returnTableDiv" class="well well-small <?php echo $trip_class;?>">
								<legend ><strong>Select Return Sailing <span class="f_req">*</span></strong></legend>
								<div class="row-fluid">
								<?php

								echo $this->Form->input('Reservation.'.$index.'.returns',array(
									'div'=>array('class'=>$trip_class." span11"),
									'label'=>false,
									'class'=>'datepicker',
									'before'=>'<label>Returning: <span id="returnPortSpan">'.$return_port.' to '.$depart_port.'</span></label><div class="input-append">',
									'after'=>'<span class="add-on pointer"><i class="small-icon-calendar"></i></span></div><span class="help-block"></span>',
									'error'=>array('attributes' => array('class' => 'help-block')),
									'value'=>$return_date
								));									
						
								?>
								</div>
								<div class="row-fluid">
								<div class=" span12 control-group">
									<table id="returnTable" class="table table-bordered table-condensed">
										<thead>
											<tr style="background-color: #EEE;  border-top: 1px solid #AAA;  text-transform: uppercase;  font-weight: normal;  font-size: 10px;  line-height: 15px;">
												<th>Depart Time</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if(!empty($return_limits)){
												if($return_limits == 'empty'){
													?>
													<tr>
														<td colspan="2">No date selected</td>
													</tr>
													<?php										
												} else {
													
													foreach ($return_limits as $key => $value) {
														$schedule_time = $key;
														foreach ($return_limits[$key] as $akey => $avalue) {
															$schedule_id = $return_limits[$key][$akey]['schedule_id']; 
															$inventory_id = $return_limits[$key][$akey]['inventory_id']; 
															$inventory_name = $return_limits[$key][$akey]['inventory_name'];
															//if($inventory_name == 'Passengers'){
																$label = $return_limits[$key][$akey]['label'];
															//}
														}
													?>
													
		
													<tr <? if (strpos($label,'success') !== false) {?>class="pointer touch"<? } else {?>class="noTouch"<?}?> schedule_id ="<?php echo $schedule_id;?>" inventory_id="<?php echo $inventory_id;?>" >
														<td><?php echo $schedule_time;?></td>
														<td><?php echo $label;?></td>
													</tr>
													<?php										
													}

												}
											} else{
												?>
												<tr>
													<td>Not in service</td>
													<td><span class="label label-important">No Service</span></td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>	
									<span style="text-align: center; display: block; font-size: 11px; font-style: italic; margin-top: -20px;">Please click on your desired sailing.</span>
									<span class="help-block"></span>
								</div>
								</div>								
							</div>
							
							<div id="calcButtonDiv" class="well well-small">
								<label style="font-size:100%; margin-bottom:10px;"><strong>To Continue Reservation Please Calculate Price <span class="f_req text-error">*</span></strong></label>
								<button id="calcPrice" type="button" class="btn btn-bbfl">Calculate Price</button>
							</div>	
						</div>
										
					</fieldset>	
					<fieldset class="six columns omega">
						<div id="tripSummaryDiv" class="form-actions hide">
							<h3>Trip Summary</h3>
							<legend id="tripSummary"><?php echo $depart_port.' to '.$return_port;?></legend>
							<p id="tripDates"><?php echo $trip_dates;?></p>
							<strong id="tripType"><?php echo $trip_type;?></strong>
							<table id="tripSummaryTable">
								
							</table>
							<div class="alert alert-error" style="padding-bottom:10px; padding-top:10px;">
								<label class="checkbox text text-error" style="font-size:110%;"><input id="acceptSummary" type="checkbox"/>Click here to accept summary <span class="f_req">*</span></label>	
							</div>
							
							<button id="recalculateTotals" type="button" class="btn btn-bbfl">Recalculate</button>
							
							<input id="addToReservation" type="submit" value="Continue" class="btn" disabled="disabled"/>
						</div>							
					</fieldset>
					<div id="hiddenFormInputs" class="hide"></div>
				</form>
				
			</div>
			<!-- Wide Column::END -->
	
	
			<!-- Side Column -->
			<?php 

			echo $this->element('pages/sidebar',array(
				'current_page'=>'reservation',
				'Ferries'=>'YES',
				'Hotels'=>'YES',
				'Attractions'=>'YES',
				'Packages'=>'YES',
				'ferry_sidebar'=>$ferry_sidebar,
				'hotel_sidebar'=>$hotel_sidebar,
				'attraction_sidebar'=>$attraction_sidebar,
				'package_sidebar'=>$package_sidebar,
			)); 
			?>
				
		</div>	