<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form',
	'frontend/bootstrap-toggle-buttons'
	),
	'stylesheet',
	array('inline'=>false)
);

echo $this->Html->script(array(
	'timezone/src/date.js',
	'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui file
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'frontend/deliveries_form.js'
	),FALSE);
	
if(isset($_SESSION['message'])){
	?>
	<p class="alert alert-success"><?php echo $_SESSION['message'];?></p>
	<?php
} else {
	?>
	<p class="alert alert-info">Welcome Guest. Please select a delivery time and date in the form below.</p>
	<?php	
}
?>
<div class="container">
<?php

if($route_status == '1'){ //there are routes
	?>
	<div class="well well-large sixteen columns alpha">
		<h3>Current Weekly Delivery Schedule <span class="pull-right badge badge-inverse"><?php echo date('D n/d/Y');?></span></h3>
		<p>Our current weekly schedule to deliver to your zipcode - <?php echo $zipcode;?> are as follows:</p>
	
		
		<div class="row six columns alpha">
			<table id="deliveryScheduleTable" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Day</th>
						<th>Time Schedule</th>
						<th>Blackout Dates</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($routes as $rkey => $rvalue) {
					$index = 0;
					switch($rkey){
						case 'Monday':
							$date_day = 1;
						break;
							
						case 'Tuesday':
							$date_day = 2;
						break;
						
						case 'Wednesday':
							$date_day = 3;
						break;
							
						case 'Thursday':
							$date_day = 4;
						break;
							
						case 'Friday':
							$date_day = 5;
						break;
						
						case 'Saturday':
							$date_day = 6;
						break;
							
						case 'Sunday':
							$date_day = 0;
						break;	
					
					}
					?>
					<tr day="<?php echo $date_day;?>">
						<td><?php echo $rkey;?></td>
						<td>
							<ul>							
							<?php
							foreach ($rvalue as $key => $value) {
								$index++;
								$route_id = $rvalue[$key]['id'];
								$route_name = $rvalue[$key]['name'];
								$day = $rvalue[$key]['day'];
								$limit = $rvalue[$key]['limit'];
								$start = $rvalue[$key]['start'];
								$end = $rvalue[$key]['end'];
								?>
								<li><?php echo $start.' - '.$end;?></li>
								<?php
							
							}
							?>
							</ul>
						</td>
						<td>
							<ul id="blackoutUl-<?php echo $rkey;?>">							
							<?php
							foreach ($rvalue as $key => $value) {
								$blkout = $rvalue[$key]['blackouts'];
								foreach ($blkout as $bkey => $bvalue) {
									if(strtotime(date('Y-m-d H:i:s')) < strtotime($bvalue)){
									$blk_date = date('D n/d/Y', strtotime($bvalue));
									
										?>
										<li class="blackoutLi" blackout="<?php echo date('n/d/Y',strtotime($bvalue));?>"><?php echo $blk_date;?></li>
										<?php
									}
								}
							
							}
							?>
							</ul>							
						</td>
					</tr>	
						<?php	
					}
	
					?>
					
				
				</tbody>
			</table>			
		</div>

	</div>
	<form id="dateTimeForm" action="/deliveries/form" method="post">	
		<div class="well well-large sixteen columns alpha" style="margin-left:0px">
			<h2>Delivery Request Form</h2>
			
			<div id="step1Div" class="row stepDiv alert alert-info">
				<h3>(Step 1) Select delivery pickup date and time</h3>	
				<strong><em>Please note that all delivery requests must be made by 7am of the date requested.</em></strong>
				<br/>
				<?php
	
				echo $this->Form->input('Schedule.pickup_date',array(
					'div'=>array('class'=>'pickupDateDiv control-group ten columns alpha'),
					'label'=>false,
					'class'=>'pickupDate',
					'type'=>'text',
					'style'=>'cursor:pointer; width:250px;',
					'before'=>'<label>Select Pickup Date <span class="required">*</span></label><div class="input-append">',
					'after'=>'<span class="add-on pointer"><i class="small-icon-calendar"></i></span></div><span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
				));
			
				?>		
				<div id="deliveryTimeDiv" class="control-group ten columns alpha">
					<label>Select Pickup Time <span class="required">*</span></label>
					<select id="schedule_pickup_time" name="data[Schedule][pickup_time]" style="width:250px;">
						<option value="none">Select pickup time</option>
	
					</select>
					<span class="help-block"></span>
				</div>				
				
				<div id="step1ButtonDiv" class="row stepButtonDiv fifteen columns alpha">
					<hr/>
					<p id="successfulPickupMessage" class="hide"></p>
					<button id="step1Button" class="btn btn-primary pull-right disabled" type="button">Next</button>
				</div>
			</div>
			

			<div id="step2Div" class="row stepDiv alert alert-info hide">
				<h3>(Step 2) Select delivery dropoff date and time</h3>
				<strong><em>Please select a valid dropooff date and time.</em></strong>
				<br/>
				<?php
	
				echo $this->Form->input('Schedule.dropoff_date',array(
					'div'=>array('class'=>'dropoffDateDiv control-group ten columns alpha'),
					'label'=>false,
					'class'=>'dropoffDate',
					'style'=>'cursor:pointer; width:250px;',
					'type'=>'text',
					'before'=>'<label>Select Dropoff Date <span class="required">*</span></label><div class="input-append">',
					'after'=>'<span class="add-on pointer calendar-icon"><i class="small-icon-calendar"></i></span></div><span class="help-block"></span>',
					'error'=>array('attributes' => array('class' => 'help-block')),
				));
			
				?>
				<div id="deliveryTimeDiv" class="control-group ten columns alpha">
					<label>Select Dropoff Time <span class="required">*</span></label>
					<select id="schedule_dropoff_time" name="data[Schedule][dropoff_time]" style="width:250px;">
						<option value="">Select dropoff time</option>
	
					</select>
					<span class="help-block"></span>
				</div>

			</div>			
			<div id="pickupFormCheck" class="row">
				<hr/>
				
				<p id="successfulDropoffMessage" class="hide"></p>
				<input id="pickupFinishFake" class="btn btn-large pull-right disabled" type="disabled" value="Set Delivery"/>
				<input id="deliveryFinish" class="btn btn-large btn-primary pull-right hide" value="Set Delivery"/>
				
			</div>			
		</div>


	</form>
	<?php
} else { //there are no routes
	?>
	<div class="row">
		
		<div class="alert alert-danger">
			<h3>Warning! There are currently no scheduled routes to your zipcode at time! </h3>
			<p>Please keep checking back with us as we are planning on expanding our service areas in the near future. <a href="/Contact-Us" >Contact Us</a></p>

		</div>
		
	</div>
	<?php
}
?>
</div>

<div id="hiddenFormFields" class="hide">
	<div id="dateFieldsDiv"></div>
	<div id="deliveryDateFieldsDiv"></div>
	<div id="timeFieldsDiv">
	<?php
	if(count($route_schedule)){
		foreach ($route_schedule as $rkey => $rvalue) {
			$date = date('l n/d/Y',$rkey);
			
			foreach ($rvalue as $rrkey => $rrvalue) {
				$delivery_id = $rvalue[$rrkey]['id'];
				$delivery_limit = $rvalue[$rrkey]['limit'];
				$delivery_max = $rvalue[$rrkey]['max'];
				?>
				<option value="<?php echo $delivery_id;?>" date="<?php echo $rkey;?>"><?php echo $rrkey;?></option>
				<?php

			}
		}
	}
	?>			
	</div>

</div>
<div id="hiddenFormFields2" class="hide"></div>

