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
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'frontend/deliveries_form.js'),FALSE);
	
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
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Day</th>
						<th>Start Time</th>
						<th>End Time</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($routes as $r) {
					$route_id = $r['id'];
					$route_name = $r['name'];
					$day = $r['day'];
					$limit = $r['limit'];
					$start = $r['start'];
					$end = $r['end'];
					?>
					<tr>
						<td><?php echo $day;?></td>
						<td><?php echo $start;?></td>
						<td><?php echo $end;?></td>
					</tr>
					<?php	
				}
				?>
				</tbody>
			</table>			
		</div>

	</div>
	<form id="dateTimeForm" action="/deliveries/form" method="post">	
		<div class="alert span12" style="margin-left:0px">
			<h3>Delivery Pickup Request Form</h3>
			<h5>(1) Search for delivery pickup dates</h5>
			
			<div class="row">
				
				<div class="control-group four columns alpha">
					<label>Select Month</label>
					<select id="selectPickupMonth" name="data[Schedule][pickup_month]">
						<?php
						$months = array();
						$months[1] = 'January';
						$months[2] = 'February';
						$months[3] = 'March';
						$months[4] = 'April';
						$months[5] = 'May';
						$months[6] = 'June';
						$months[7] = 'July';
						$months[8] = 'August';
						$months[9] = 'September';
						$months[10] = 'October';
						$months[11] = 'November';
						$months[12] = 'December';
						foreach ($months as $key => $value) {
							if(date('m') == $key){
							?>
							<option value="<?php echo $key;?>" selected="selected"><?php echo $value;?></option>
							<?php							
							} else {
							?>
							<option value="<?php echo $key;?>"><?php echo $value;?></option>
							<?php							
							}
	
						}
						?>
					</select>
					<span class="help-block"></span>
				</div>
				<div class="control-group four columns alpha">
					<label>Select Year</label>
					<select id="selectPickupYear" name="data[Schedule][pickup_year]">
					<?php
						$years[date('Y')] = date('Y');
						$years[date('Y')+1] = date('Y') + 1;
						foreach ($years as $key => $value) {
							if(date('Y') == $key){
							?>
							<option value="<?php echo $key;?>" selected="selected"><?php echo $value;?></option>
							<?php
							} else {
							?>
							<option value="<?php echo $key;?>"><?php echo $value;?></option>
							<?php					
	
							}
	
						}
					?>
				
					</select>
				</div>
			</div>
			<h5>(2) Select delivery pickup date and time</h5>
			
			<div class="row">
			
				<div id="deliveryDateDiv" class="control-group four columns alpha">
					<label>Select Pickup Date <span class="required">*</span></label>
					<select id="schedule_pickup_date" name="data[Schedule][pickup_date]">
						<option value="">Select pickup date</option>
					<?php
					if(count($route_schedule)){
						$today = strtotime(date('Y-m-d H:i:s'));
						foreach ($route_schedule as $rkey => $rvalue) {
							$date = date('l n/d/Y',$rkey);
							if($rkey > $today){
							?>
							<option value="<?php echo $rkey;?>"><?php echo $date;?></option>
							<?php
							}
						}
					}
					?>
					</select>	
					<span class="help-block"></span>
				</div>
				<div id="deliveryTimeDiv" class="control-group four columns alpha">
					<label>Select Pickup Time <span class="required">*</span></label>
					<select id="schedule_pickup_time" name="data[Schedule][pickup_time]">
						<option value="">Select pickup time</option>
	
					</select>
					<span class="help-block"></span>
				</div>
			</div>
			
			<div id="pickupFormCheck" class="row">
				<hr/>
				<p id="successfulPickupMessage" class="hide"></p>
				<input id="pickupFinishFake" class="btn btn-large pull-right disabled" type="disabled" value="Set Pickup"/>
				<button id="pickupFinish" class="btn btn-large btn-primary pull-right hide" type="button">Next</button>
				
			</div>			
		</div>
		<div id="dropoffFormDiv" class="alert alert-info span12 hide" style="margin-left:0px;">
			<h3>Delivery Dropoff Request Form</h3>
			<p><span class="required">*</span> Dropoff must be within 90 days of pickup date</p>

			
			
			<div class="row">
			
				<div id="deliveryDateDiv" class="control-group four columns alpha">
					<label>Select Dropoff Date <span class="required">*</span></label>
					<select id="schedule_dropoff_date" name="data[Schedule][dropoff_date]">
						<option value="">Select dropoff date</option>
					<?php
					if(count($route_schedule)){
						$today = strtotime(date('Y-m-d H:i:s'));
						foreach ($route_schedule as $rkey => $rvalue) {
							$date = date('l n/d/Y',$rkey);
							if($rkey > $today){
							?>
							<option value="<?php echo $rkey;?>"><?php echo $date;?></option>
							<?php
							}
						}
					}
					?>
					</select>	
					<span class="help-block"></span>
				</div>
				<div id="deliveryTimeDiv" class="control-group four columns alpha">
					<label>Select Dropoff Time <span class="required">*</span></label>
					<select id="schedule_dropoff_time" name="data[Schedule][dropoff_time]">
						<option value="">Select dropoff time</option>
	
					</select>
					<span class="help-block"></span>
				</div>
				<div id="dropoffFormCheck" class="row">
					<hr/>
					<p id="successfulDropoffMessage" class="hide"></p>
					<button id="dropoffFinish" class="btn btn-large btn-primary pull-right">Confirm Delivery</button>
					
				</div>	
			</div>		
			
			
						
		</div>

	</form>
	<?php
} else { //there are no routes
	?>
	<div class="row">
		
		<div class="alert alert-danger">
			<h3>Warning! There are currently no scheduled routes to your zipcode at this time! </h3>
			<p>We apologize that we have not setup any current route to your zipcode. Although we have no direct routes to your zipcode, we may be able to provide a delivery by special request. Please contact us at...(finish statement)</p>

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

