<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/deliveries_finish.js'),FALSE);

echo $this->Form->create();
?>
<div class="row-fluid">
	<h1 class="heading">Finish Delivery Orders</h1>
	<div class="well well-small">
		<div class="control-group">
			<label>Select Delivery Date</label>
			<form action="/deliveries/finish" method="post">
			<div class="input-append">
				<input id="deliveryDate" type="text" value="<?php echo $date;?>" name="data[Delivery][date]" readonly="true"/>
				<span class="add-on"><i class="icon-calendar"></i></span>
				<a id="submitDeliveryForm" class="add-on" style="cursor:pointer;">Search</a>
			</div>				
			</form>
		</div>
		
	</div>
	<div class="formRow">

		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Address</th>
					<th>Zipcode</th>
					<th>Special Instructions</th>
					<th>Phone</th>
					<th>Invoices</th>
					<th>Amount Due</th>
					<th>Action</th>
				</tr>
			</thead>
			
			<tbody>				
			<?php
			$idx = -1;
			foreach ($today as $tkey =>$tvalue) {
		
				foreach ($tvalue as $ttkey => $ttvalue) {
					$type = $ttkey; //what type of dropoff or pickup
					foreach ($ttvalue as $tttkey => $tttvalue) {
						$idx++;
						$customer_id = $ttvalue[$tttkey]['customer_id'];
						$schedule_id = $ttvalue[$tttkey]['schedule_id'];
						$schedule_status = $ttvalue[$tttkey]['status'];
						$route_name = (isset($ttvalue[$tttkey]['route_name'])) ? $ttvalue[$tttkey]['route_name'] : '';
						$zipcode = $ttvalue[$tttkey]['zipcode'];
						$first_name = $ttvalue[$tttkey]['first_name'];
						$last_name = $ttvalue[$tttkey]['last_name'];
						$phone = $ttvalue[$tttkey]['phone'];	
						$start_time = (isset($ttvalue[$tttkey]['start_time'])) ? $ttvalue[$tttkey]['start_time'] : '';
						$end_time = (isset($ttvalue[$tttkey]['end_time'])) ? $ttvalue[$tttkey]['end_time'] : '';
						$time_range = $start_time.' - '.$end_time;
						$address = $ttvalue[$tttkey]['address'];
						$suite = (!empty($ttvalue[$tttkey]['suite'])) ? '#'.$ttvalue[$tttkey]['suite'] : '';	
						$city = $ttvalue[$tttkey]['city'];
						$state = $ttvalue[$tttkey]['state'];
						$delivery_address = $address.' '.$suite.'<br/>'.ucfirst($city).', '.ucwords($state);
						$country = "USA";
						$email = $ttvalue[$tttkey]['email'];
						$special_instructions = (is_null($ttvalue[$tttkey]['special_instructions']) || empty($ttvalue[$tttkey]['special_instructions'])) ? $ttvalue[$tttkey]['default_special_instructions'] : $ttvalue[$tttkey]['special_instructions'];
						$suite = $ttvalue[$tttkey]['suite'];
						$total = (isset($ttvalue[$tttkey]['total'])) ? '$'.$ttvalue[$tttkey]['total'] : '';	
						$invoices = (isset($ttvalue[$tttkey]['invoices'])) ? $ttvalue[$tttkey]['invoices'] : array();

						switch($type){
							case 'Pickup':
								$delivery_status_style = ($schedule_status == 1) ? 'style="background-color:#bceaff;"' : 'style="background-color:#e5e5e5; color:#5e5e5e;"';								
							break;
							default:
								switch($schedule_status){
									case '1'://still in cleaning
 										$delivery_status_style = 'style="background-color:#c4ffbc;"';
									break;	
									case '2': //ready to dropoff
										$delivery_status_style = 'style="background-color:#c4ffbc;"';
									break;
									case '3': //finished and paid
										$delivery_status_style = 'style="background-color:#e5e5e5; color:#5e5e5e;"';
									break;
								}										
							break;
						}

						?>
						<tr <?php echo $delivery_status_style;?>>
							<td><?php echo $schedule_id;?></label></td>
							<td><?php echo $last_name;?></td>
							<td><?php echo $first_name;?></td>
							<td><?php echo $delivery_address;?></td>
							<td><?php echo $zipcode;?></td>
							<td><?php echo $special_instructions;?></td>
							<td><?php echo $phone;?></td>
							<td>
								<ul>
								<?php
								if(count($invoices)>0){
									foreach ($invoices as $ikey => $ivalue) {
										$invoice_id = $ivalue['invoice_id'];
										?>
										<li><?php echo $invoice_id;?></li>
										<?php
									}
								}
								?>									
								</ul>
							</td>
							<td><?php echo $total;?></td>
							<td>
								<?php
								if($type == 'Dropoff'){
									switch($schedule_status){
										case '1':
										?>
										<form action="/deliveries/dropoff_order" method="post">
											<input type="hidden" value="<?php echo $date;?>" name="data[Schedule][date]"/>
											<input type="hidden" value="<?php echo $schedule_id;?>" name="data[Schedule][id]"/>
											<input type="hidden" value="<?php echo $customer_id;?>" name="data[Schedule][customer_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['profile_id'];?>" name="data[Schedule][profile_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_status'];?>" name="data[Schedule][payment_status]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_id'];?>" name="data[Schedule][payment_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['total'];?>" name="data[Schedule][total]"/>
											<input type="hidden" value='<?php echo json_encode($invoices);?>' name="data[Schedule][invoices]"/>
											
											<input type="hidden" value="3" name="data[Schedule][status]"/>
											<button class="finish btn btn-small btn-inverse" type="submit">Dropoff & Pay <?php echo $schedule_id;?></button>	
										</form>		
										<?php											
										break;
										case '2':
										?>
										<form action="/deliveries/dropoff_order" method="post">
											<input type="hidden" value="<?php echo $date;?>" name="data[Schedule][date]"/>
											<input type="hidden" value="<?php echo $schedule_id;?>" name="data[Schedule][id]"/>
											<input type="hidden" value="<?php echo $customer_id;?>" name="data[Schedule][customer_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['profile_id'];?>" name="data[Schedule][profile_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_status'];?>" name="data[Schedule][payment_status]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_id'];?>" name="data[Schedule][payment_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['total'];?>" name="data[Schedule][total]"/>
											<input type="hidden" value='<?php echo json_encode($invoices);?>' name="data[Schedule][invoices]"/>
											
											<input type="hidden" value="3" name="data[Schedule][status]"/>
											<button class="finish btn btn-small btn-inverse" type="submit">Dropoff & Pay <?php echo $schedule_id;?></button>	
										</form>		
										<?php									
										break;
											
										case '3':
										?>
										<form action="/deliveries/dropoff_revert_order" method="post">
											<input type="hidden" value="<?php echo $date;?>" name="data[Schedule][date]"/>
											<input type="hidden" value="<?php echo $schedule_id;?>" name="data[Schedule][id]"/>
											<input type="hidden" value="<?php echo $customer_id;?>" name="data[Schedule][customer_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['profile_id'];?>" name="data[Schedule][profile_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_status'];?>" name="data[Schedule][payment_status]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_id'];?>" name="data[Schedule][payment_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['total'];?>" name="data[Schedule][total]"/>
											<input type="hidden" value='<?php echo json_encode($invoices);?>' name="data[Schedule][invoices]"/>
											<input type="hidden" value="2" name="data[Schedule][status]"/>
											<button class="finish btn btn-small btn-danger" type="submit">Revert Dropoff & Pay <?php echo $schedule_id;?></button>	
										</form>										
										<?php
										break;
									}
								?>

								
								<?php
								} else {

									switch($schedule_status){
										case '1':
										?>
										<form action="/deliveries/pickup_order" method="post">
											<input type="hidden" value="<?php echo $date;?>" name="data[Schedule][date]"/>
											<input type="hidden" value="<?php echo $schedule_id;?>" name="data[Schedule][id]"/>
											<input type="hidden" value="<?php echo $customer_id;?>" name="data[Schedule][customer_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['profile_id'];?>" name="data[Schedule][profile_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_id'];?>" name="data[Schedule][payment_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_status'];?>" name="data[Schedule][payment_status]"/>
											<input type="hidden" value="<?php echo $total;?>" name="data[Schedule][total]"/>

											<input type="hidden" value="2" name="data[Schedule][status]"/>
											<button class="finish btn btn-small btn-primary" type="submit">Pickup <?php echo $schedule_id;?></button>	
										</form>
										
										<?php										
										break;
											
										case '2':
										?>
										<form action="/deliveries/pickup_revert_order" method="post">
											<input type="hidden" value="<?php echo $date;?>" name="data[Schedule][date]"/>
											<input type="hidden" value="<?php echo $schedule_id;?>" name="data[Schedule][id]"/>
											<input type="hidden" value="<?php echo $customer_id;?>" name="data[Schedule][customer_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['profile_id'];?>" name="data[Schedule][profile_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_id'];?>" name="data[Schedule][payment_id]"/>
											<input type="hidden" value="<?php echo $ttvalue[$tttkey]['payment_status'];?>" name="data[Schedule][payment_status]"/>
											<input type="hidden" value="<?php echo $total;?>" name="data[Schedule][total]"/>
											<input type="hidden" value="1" name="data[Schedule][status]"/>
											<button class="finish btn btn-small btn-danger" type="submit">Revert Pickup <?php echo $schedule_id;?></button>	
										</form>
										
										<?php	
										break;
									}

								}
								?>
								
							</td>
						</tr>
						<?php										
					}
					
				}
			}
			?>
				</tbody>
			</table>

	</div>
</div>
<?php

echo $this->Form->end();
?>