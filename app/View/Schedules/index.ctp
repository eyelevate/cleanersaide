<?php
echo $this->Html->script(array('admin/schedules.js'),FALSE);
//create the json array here

?>

<? if ($group_id == 1 || $group_id == 2 || $group_id == 7 ) { //hardcoded for super admin, admin, and supervisors ?> 

<div class="row-fluid">
	<div class="style_switcher" style="display: none; width:40%">
		<div class="sepH_c">
			<h4 class="heading">Edit Ferry Schedule</h4>
		</div>
			<div class="tabbable tabbable-bordered clearfix">
				<ul class="nav nav-tabs">
			    	<li class="active"><a data-toggle="tab" href="#edit1">Edit Date Range</a></li>
			    	<li class=""><a data-toggle="tab" href="#edit2">Edit Multiple Dates</a></li>
			    </ul>			
		 		<div class="tab-content" style="background-color:#ffffff;">
			    	<div id="edit1" class="tab-pane active">
				    	<form id="editScheduleForm1" class="form-horizontal" method="post" action="/schedules/edit">		    	
					    	<input type="hidden" name="data[form_type]" value="Edit_Schedule_Incoming"/>
					    	<ul class="unstyled">
					    		<li id="startDateDiv" class="control-group">
					    			<label class="control-label" style="color:#000000;">Select Start Date</label>
					    			<div class="controls">
						    			<input type="text" id="dp1" class="search-query" placeholder="Start Date" name="data[start]"/>
						    		</div>
						    		<span class="help-block"></span>			    			
					    		</li>
					    		<li id="endDateDiv" class="control-group">
					    			<label class="control-label" style="color:#000000;">Select End Date</label>
					    			<div class="controls">
						 				<input type="text" id="dp2" class="search-query" placeholder="End Date" name="data[end]"/>
						 			</div>
						 			<span class="help-block"></span>				    			
					    		</li>
					    		<li class="control-group">
					    			<div class="controls">
					    				<button id="editDateRangeButton" type="button" class="btn btn-primary">Edit</button>
					    			</div>
					    		</li>
					    	</ul>
						</form>
			    	</div>
			    	<div id="edit2" class="tab-pane">
			    		<h5 class="heading" style="color:#000000;">Select Date <span id="datesSelected" class="label label-inverse"><span id="selectedSpan">0</span> Selected</span></h5>
		
			    		<div class="well well-small">
			    			<input id="dp3" type="text" class="" placeholder="Click Here To Select Dates"/>
			    			<ul id="addEditSelectableDates" class="ms-list unstyled"></ul>    			
			    		</div>
						<div class="clearfix" style="padding-top: 100px;">
							<button id="selectDatesButton" class="btn btn-primary">Edit Schedule</button>	
						</div>
						<form id="editScheduleForm2" method="post" action="/schedules/edit">		    	
					    	<input type="hidden" name="data[form_type]" value="Edit_Schedule_Incoming2"/>
					   </form>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
	<? } ?>
	
	<div class="row-fluid">
		<ul id="scheduleMainUl" class="nav nav-pills heading">
		<?php
		$idx = -1;
		foreach ($inventories as $ii) {
			$idx = $idx+1;
			$inventory_id = $ii['Inventory']['id'];
			$inventory_name = $ii['Inventory']['name'];
			if($idx == 0){
			?>
			<li class="active" style="cursor:pointer">
				<a id="switchCalendar-<?php echo $inventory_id;?>" class="switchCalendar" href="#<?php echo $inventory_name;?>" data-toggle="tab"><?php echo $inventory_name;?></a>
			</li>			
			<?php				
			} else {
			?>
			<li style="cursor:pointer">
				<a id="switchCalendar-<?php echo $inventory_id;?>" class="switchCalendar" href="#<?php echo $inventory_name;?>" data-toggle="tab"><?php echo $inventory_name;?></a>
			</li>			
			<?php				
			}

		}
		
		?>

		</ul>
		<div id="displayCalendar">

			<div id="calendar"></div>	
			
		</div>
		
	</div>
</div>
<br/>

<?php

/**
 * schedule edit event
 * 
 * need to know.. 
 * if user does not have access to edit place access control here
 */

?>
<? if ($group_id == 1 || $group_id == 2 || $group_id == 7 ) { //hardcoded for super admin, admin, and supervisors ?> 

<a class="ssw_trigger active" href="javascript:void(0)">
	 <i class="icon-cog icon-white"></i>
</a>

<? } ?>
