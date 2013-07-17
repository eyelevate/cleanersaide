<?php
echo $this->Html->script(array('admin/reports_room_nights.js'),FALSE);
//alerts on page
echo $this->TwitterBootstrap->flashes(array(
    "auth" => False,
    "closable"=>true
    )
);
?>

<div class="">
	<legend>Room Nights Report</legend>
</div>

<div class="row-fluid">
	<div class="span 12 well">
		<div class="row-fluid">
			
			<div class="control-group pull-left span3">
				<label>Start Date</label>
				<div class="input-append" style="margin-left:0px;">
					<input id="start" class="span11 date" type="text" />
					<span class="add-on pointer"><i class="icon-calendar"></i></span>	
				</div>
				<span class="help-block three columns alpha"></span>
			</div>
			
			<div class="control-group pull-left span3">
				<label>End Date</label>
				<div id="checkoutDiv" class="input-append" style="margin-left:0px;">
					<input id="end" class="span11 date" type="text" />
					<span class="add-on pointer"><i class="icon-calendar"></i></span>	
				</div>
				<span class="help-block three columns alpha"></span>
			</div>
			
			<div class="control-group pull-left span3">
				<label>Hotel</label>
				<div id="checkoutDiv" class="input-append" style="margin-left:0px;">
					<?php
			
					echo $this->Form->input('hotels', array(
						'options'=>$hotels,
						'class'=>'hotelSelect',
						'label'=>false,
						//'before'=>'<label class="control-label">Select Hotel</label><div class="controls">',
						//'after'=>'</div>',
						'div'=>array('class'=>'control-group clearfix'),
						//'default'=>$hotel_id,
						'error'=>array('attributes' => array('class' => 'help-block')),
					));		
					?>
				</div>
				<span class="help-block three columns alpha"></span>
			</div>
				
		</div>
		<div class="row-fluid">
			<button id="retrieve" type="button" class="btn btn-small btn-info">Run Report</button>
		</div>
	</div>
</div>

<div class="row-fluid room_nights">
	

		
</div>