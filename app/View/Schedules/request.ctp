<?php

if($_REQUEST['type'] =='Create_Form' && $_REQUEST['start_date'] && $_REQUEST['end_date'] && $_REQUEST['trips'])
{
	//create all the variables for script
	$start = $_REQUEST['start_date'];
	$end = $_REQUEST['end_date'];
	
	$startMonth = substr($start,0,2);
	$startDay = substr($start,3,2);
	$startYear = substr($start,-4);
	$endMonth = substr($end,0,2);
	$endDay = substr($end,3,2);
	$endYear = substr($end,-4);
	$startDate = strtotime($startYear.'-'.$startMonth.'-'.$startDay.' 00:00:00');
	$endDate = strtotime($endYear.'-'.$endMonth.'-'.$endDay.' 00:00:00');
	$dateStart = date('m/d/Y',$startDate);
	$dateEnd = date('m/d/Y',$endDate);
	$trips = $_REQUEST['trips'];
	//get all the minutes in a day
    $secondsDay = 86400;
	$minuteSeconds = 60;
	$minutesDay = 1440;
	$todayStart = strtotime(date('Y-m-d 00:00:00'));
	$todayEnd = $todayStart+$secondsDay;
	
	if(isset($prexists_error) && $prexists_error != 'prexists'){	
		
		//check for dates errors if so then return a variable, if its ok then return script
		if($endDate < $startDate){
			echo 'dates_error';
		} else {
			
	
			for ($a=1; $a <= $trips; $a++) { 
			?>
				<tr id="scheduleFormTableTr-<?php echo $a;?>" class="scheduleFormTableTr" name="<?php echo $a;?>">
					<td><?php echo $a;?></td>
					<td id="scheduleStart-<?php echo $a;?>" class="scheduleStart" date="<?php echo $startDate;?>"><?php echo $dateStart;?></td>
					<td id="scheduleEnd-<?php echo $a;?>" class="scheduleEnd" date="<?php echo $endDate;?>"><?php echo $dateEnd;?></td>
					<td id="depart1Td" class="control-group">			
						<input type="search" class="pickTimeInput span2" id="pickTimeInput-<?php echo $a;?>" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead"/>
						<span class="help-block"></span>
					</td>
					<td id="depart2Td" class="control-group">
						<input type="search" class="pickTimeInput2 span2" id="pickTimeInput2-<?php echo $a;?>" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead"/>
						<span class="help-block"></span>
					</td>
					<td id="actions-<?php echo $a;?>" name="<?php echo $a;?>">
						<button id="tripClear-<?php echo $a;?>" class="tripClear"><i class="icon-remove"></i> Clear</button>
					</td>
				</tr>
				<script type="text/javascript">		
 
					$(".ui-autocomplete").addClass('dropdown-menu');  
					//clone value 
			        $("#scheduleFormTableTr-<?php echo $a;?> #tripClear-<?php echo $a;?>").click(function(){
			        	$("#scheduleFormTableTr-<?php echo $a;?> #pickTimeInput-<?php echo $a;?>").val('');
						$("#scheduleFormTableTr-<?php echo $a;?> #pickTimeInput2-<?php echo $a;?>").val('');
			        });
				</script>
			<?php			
			}
			?>
				
			<script type="text/javascript">
		
			</script>
			<?php
		}
	} else { //Prexisting dates 

			for ($a=1; $a <= $trips; $a++) { 
			?>
				<tr id="scheduleFormTableTr-<?php echo $a;?>" class="scheduleFormTableTr" name="<?php echo $a;?>">
					<td><?php echo $a;?></td>
					<td id="scheduleStart-<?php echo $a;?>" class="scheduleStart" date="<?php echo $startDate;?>"><?php echo $dateStart;?></td>
					<td id="scheduleEnd-<?php echo $a;?>" class="scheduleEnd" date="<?php echo $endDate;?>"><?php echo $dateEnd;?></td>
					<td id="depart1Td" class="control-group" >			
						<input type="search" class="pickTimeInput span2" id="pickTimeInput-<?php echo $a;?>" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead"/>
						<span class="help-block"></span>
					</td>
					<td id="depart2Td" class="control-group">
						<input type="search" class="pickTimeInput2 span2" id="pickTimeInput2-<?php echo $a;?>" data-source='<?php echo json_encode($minutesArray);?>' data-provide="typeahead"/>
						<span class="help-block"></span>
					</td>
					<td id="actions-<?php echo $a;?>" name="<?php echo $a;?>">
						<button id="tripClear-<?php echo $a;?>" class="tripClear"><i class="icon-remove"></i> Clear</button>

					</td>
				</tr>

				<script type="text/javascript">		
 
					$(".ui-autocomplete").addClass('dropdown-menu');  
					//clone value 
			        $("#scheduleFormTableTr-<?php echo $a;?> #tripClear-<?php echo $a;?>").click(function(){
			        	$("#scheduleFormTableTr-<?php echo $a;?> #pickTimeInput-<?php echo $a;?>").val('');
						$("#scheduleFormTableTr-<?php echo $a;?> #pickTimeInput2-<?php echo $a;?>").val('');
			        });
			        
			        //send error message to say that there are prexisting dates
					$("#errorMessageAlert").show();
					$("#errorMessageAlert small").html('Warning: There are prexisting trips on this date. Any time matching these set dates will not be written.')
						//on blur check the time
						$("#pickTimeInput-<?php echo $a;?>").blur(function(){
							var time = $(this).val();
							var start_date = '<?php echo date('Y-m-d H:i:s',$startDate);?>';
							var end_date = '<?php echo date('Y-m-d',$endDate).' 23:59:59';?>';
							$.post(
								'/schedules/request',
								{
									type:'Check_Time',
									start_date:start_date,
									end_date:end_date,
									time: time
								}, function(response){
									if(response =='Yes'){
										$('#pickTimeInput-<?php echo $a;?>').parent().attr('class','control-group error');
										$('#pickTimeInput-<?php echo $a;?>').parent().find('.help-block').html('This time has been taken.');
										
									} else {
										$('#pickTimeInput-<?php echo $a;?>').parent().attr('class','depart1Td control-group');
										$('#pickTimeInput-<?php echo $a;?>').parent().find('.help-block').html('');										
									}
								}
								
							);
						});	
						//on blur check the time
						$("#pickTimeInput2-<?php echo $a;?>").blur(function(){
							var time = $(this).val();
							var start_date = '<?php echo date('Y-m-d H:i:s',$startDate);?>';
							var end_date = '<?php echo date('Y-m-d',$endDate).' 23:59:59';?>';

							$.post(
								'/schedules/request',
								{
									type:'Check_Time',
									start_date:start_date,
									end_date:end_date,
									time: time
								}, function(response){
									if(response =='Yes'){
										$('#pickTimeInput2-<?php echo $a;?>').parent().attr('class','control-group error');
										$('#pickTimeInput2-<?php echo $a;?>').parent().find('.help-block').html('This time has been taken.');
										
									} else {
										$('#pickTimeInput2-<?php echo $a;?>').parent().attr('class','control-group');
										$('#pickTimeInput2-<?php echo $a;?>').parent().find('.help-block').html('');										
									}
								}
								
							);
						});					
			        
				</script>
				
			
			<?php		
			}
			?>
				
			<script type="text/javascript">
		
			</script>
			<?php
	}
}
if($_REQUEST['type'] =='Check_Time' && $_REQUEST['start_date'] && $_REQUEST['end_date'])
{
	echo $prexists_error;
}
//sets the schedule id for the saved item
if($_REQUEST['type']== 'Schedule_Time' && $_REQUEST['date'] && $_REQUEST['depart'] && $_REQUEST['time'] && $_REQUEST['trip']){
	echo $schedule_id;
}

if($_REQUEST['type'] == 'NEW_SCHEDULE' && $_REQUEST['form_data']){
	print_r($result);
}

?>