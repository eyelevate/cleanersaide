<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	),
	'stylesheet',
	array('inline'=>false)
);
echo $this->Html->script(array(
	'timezone/src/date.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/deliveries_new_delivery.js'
	),FALSE);
	

?>
<div class="row-fluid">
<?php

if($route_status == '1'){ //there are routes
	?>
	<div class="well well-large sixteen columns alpha">
		<h3>Current Weekly Delivery Schedule <span class="pull-right badge badge-inverse"><?php echo date('D n/d/Y');?></span></h3>
		<p>Our current weekly schedule to deliver to your zipcode - <?php echo $zipcode;?> are as follows:</p>
	
		
		<div class="formRow">
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
	<form id="dateTimeForm" action="/deliveries/new_delivery/<?php echo $customer_id;?>" method="post">	
		<div class="well well-large">
			<h2 class="heading">Delivery Request Form</h2>
			<div id="formTypeRadioDiv" class="well well-small">
				<label class="radio"><input type="radio" value="0" name="data[Delivery][type]" checked="checked"/> Both Pickup & Dropoff</label>
				<label class="radio"><input type="radio" value="1" name="data[Delivery][type]"/> Pickup Only</label>
				<label class="radio"><input type="radio" value="2" name="data[Delivery][type]"/> Dropoff Only</label>
			</div>
			<div id="step1Div" class="formRow alert alert-info">
				<h3 class="heading">Select delivery pickup date and time</h3>	

				<?php
	
				echo $this->Form->input('Schedule.pickup_date',array(
					'div'=>array('class'=>'pickupDateDiv control-group ten columns alpha'),
					'label'=>false,
					'class'=>'pickupDate',
					'type'=>'text',
					'style'=>'cursor:pointer; width:250px;',
					'before'=>'<label>Select Pickup Date <span class="required">*</span></label><div class="input-append">',
					'after'=>'<span class="add-on pointer"><i class="icon icon-calendar"></i></span></div><span class="help-block"></span>',
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
				
			</div>
			

			<div id="step2Div" class="formRow stepDiv alert alert-info">
				<h3 class="heading">Select delivery dropoff date and time</h3>
				<?php
	
				echo $this->Form->input('Schedule.dropoff_date',array(
					'div'=>array('class'=>'dropoffDateDiv control-group ten columns alpha'),
					'label'=>false,
					'class'=>'dropoffDate',
					'style'=>'cursor:pointer; width:250px;',
					'type'=>'text',
					'before'=>'<label>Select Dropoff Date <span class="required">*</span></label><div class="input-append">',
					'after'=>'<span class="add-on pointer calendar-icon"><i class="icon icon-calendar"></i></span></div><span class="help-block"></span>',
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
			<div class="alert alert-danger">
				<h3 class="heading">Setup Payment Information</h3>
				<div class="control-group">
					<label>Save payment information?</label>
					<div class="control-group">
						<label class="radio"><input type="radio" name="data[Payment][payment_status]" value="2"/> Yes</label>
						<label class="radio"><input type="radio" name="data[Payment][payment_status]" value="1" checked="checked"/> No (delete after each payment)</label>					
					</div>						
				</div>

				<?php
				if(empty($payment_id) || !isset($payment_id)){
					echo $this->Form->input('Payment.card_full_name',array(
						'label'=>'Name on Card <span class="f_req">*</span>',
						'div'=>array('class'=>'control-group eight columns alpha'),
						'after'=>'<span class="help-block"></span>',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'placeholder'=>'Full name as it appears on your credit card',
			
					));					
		
					echo $this->Form->input('Payment.ccnum',array(
						'label'=>'Credit Card Number <span class="f_req">*</span>',
						'div'=>array('class'=>'control-group eight columns alpha'),
						'after'=>'<span class="help-block"></span>',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'placeholder'=>'credit card number as it is shown on your card',
		
					));					
		
					echo $this->Form->input('Payment.exp_month',array(
						'label'=>'Expired Month <span class="f_req">*</span>',
						'div'=>array('class'=>'control-group two columns alpha'),
						'after'=>'<span class="help-block"></span>',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'placeholder'=>'mm',
						'maxlength'=>2
		
					));		
					echo $this->Form->input('Payment.exp_year',array(
						'label'=>'Expired Year <span class="f_req">*</span>',
						'div'=>array('class'=>'control-group two columns alpha'),
						'after'=>'<span class="help-block"></span>',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'placeholder'=>'yyyy',
						'maxlength'=>4
			
					));					
					echo $this->Form->input('Payment.cvv',array(
						'label'=>'CVV <span class="f_req">*</span>',
						'div'=>array('class'=>'control-group two columns alpha'),
						'after'=>'<span class="help-block"></span>',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'placeholder'=>'ex. 123',
						'maxlength'=>5
			
					));								
				} else {
				?>
				<p>Payment ID is saved</p>
				<?php
				}
				?>
				<input type="hidden" name="data[Delivery][profile_id]" value="<?php echo $profile_id;?>"/>
				<input type="hidden" name="data[Delivery][payment_id]" value="<?php echo $payment_id;?>"/>
			</div>
			<div id="pickupFormCheck" class="formRow clearfix">

				<input id="deliveryFinish" type="submit" class="btn btn-large btn-primary pull-right " value="Set Delivery"/>
				
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

