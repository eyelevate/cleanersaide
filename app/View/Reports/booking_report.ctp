<?php
echo $this->Html->script(array('admin/reports_booking.js'),FALSE);
//alerts on page
echo $this->TwitterBootstrap->flashes(array(
    "auth" => False,
    "closable"=>true
    )
);
?>

<div class="">
	<legend>Booking Report</legend>
</div>

<div class="row-fluid">
	<div class="span 12 well">
		<div class="row-fluid">
			
			<div class="control-group pull-left span3">
				<label><strong>Start Date</strong></label>
				<div class="input-append" style="margin-left:0px;">
					<input id="start" class="span11 date" type="text" />
					<span class="add-on pointer"><i class="icon-calendar"></i></span>	
				</div>
				<span class="help-block three columns alpha"></span>
			</div>
			
			<div class="control-group pull-left span3">
				<label><strong>End Date</strong></label>
				<div id="checkoutDiv" class="input-append" style="margin-left:0px;">
					<input id="end" class="span11 date" type="text" />
					<span class="add-on pointer"><i class="icon-calendar"></i></span>	
				</div>
				<span class="help-block three columns alpha"></span>
			</div>
			
			<div class="control-group pull-left span3">
				<label><strong>Booking Type</strong></label>
				<div id="" style="margin-left:0px;">
					<label class="radio"><input name="type" type="radio" value="both" checked="checked"/> Both</label>
					<label class="radio"><input name="type" type="radio" value="hotel" /> Hotels</label>
					<label class="radio"><input name="type" type="radio" value="attraction" /> Attractions</label>
				</div>
				<span class="help-block three columns alpha"></span>
			</div>
			
			<div class="control-group pull-left span3">
				<label><strong>Date Criteria</strong></label>
				<div id="" style="margin-left:0px;">
					<label class="radio"><input name="date-criteria" type="radio" value="checkin" checked="checked" /> Attraction Date/Check-in Date</label>
					<label class="radio"><input name="date-criteria" type="radio" value="created"/> Date Reservation Created</label>
				</div>
				<span class="help-block three columns alpha"></span>
			</div>
				
		</div>
		<div class="row-fluid">
			<button id="retrieve" type="button" class="btn btn-small btn-info">Run Report</button>
		</div>
	</div>
</div>

<div class="row-fluid bookings">
	

		
</div>