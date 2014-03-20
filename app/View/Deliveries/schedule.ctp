<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/datepicker/bootstrap-datepicker.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/deliveries_schedule.js'),FALSE);
?>
<div class="row-fluid">
	<div class="well well-small">
		<div class="control-group">
			<label>Select Delivery Date</label>
			<form action="/deliveries/schedule" method="post">
			<div class="input-append">
				<input id="deliveryDate" type="text" value="<?php echo $date;?>" name="data[Delivery][date]"/>
				<span class="add-on"><i class="icon-calendar"></i></span>
				<a id="submitDeliveryForm" class="add-on" style="cursor:pointer;">Search</a>
			</div>				
			</form>

			
		</div>
		
	</div>
	<div class="formRow">
		<form target="_blank" action="/deliveries/create_delivery_csv" method="post">
		<?php 
		$idx = -1;
		foreach ($today as $tkey =>$tvalue) {
			
		?>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Route</th>
						<th>Time</th>
						<th>Type</th>
						<th>Zipcode</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>				
				<?php
				
				foreach ($tvalue as $ttkey => $ttvalue) {
					$type = $ttkey; //what type of dropoff or pickup
					foreach ($ttvalue as $tttkey => $tttvalue) {
						$idx++;
						$delivery_id = $ttvalue[$tttkey]['delivery_id'];
						$route_name = $ttvalue[$tttkey]['route_name'];
						$zipcode = $ttvalue[$tttkey]['zipcode'];
						$first_name = $ttvalue[$tttkey]['first_name'];
						$last_name = $ttvalue[$tttkey]['last_name'];
						$phone = $ttvalue[$tttkey]['phone'];	
						$start_time = $ttvalue[$tttkey]['start_time'];
						$end_time = $ttvalue[$tttkey]['end_time'];
						$time_range = $start_time.' - '.$end_time;
						$address = $ttvalue[$tttkey]['address'];
						$city = $ttvalue[$tttkey]['city'];
						$state = $ttvalue[$tttkey]['state'];
						$country = "USA";
						$email = $ttvalue[$tttkey]['email'];
						if(is_null($ttvalue[$tttkey]['special_instructions']) || empty($ttvalue[$tttkey]['special_instructions'])){
							$special_instructions = $ttvalue[$tttkey]['default_special_instructions'];
						} else {
							$special_instructions = $ttvalue[$tttkey]['special_instructions'];
						}
						$suite = $ttvalue[$tttkey]['suite'];
						
						?>
						<tr>
							<td><?php echo $route_name;?></td>
							<td><?php echo $time_range;?></td>
							<td><?php echo $type;?></td>
							<td><?php echo $zipcode;?></td>
							<td><?php echo $first_name;?></td>
							<td><?php echo $last_name;?></td>
							<td><?php echo $phone;?></td>
							<td>
								<a href="">View</a>
								<a href="">Edit</a>
								<a href="">Remove</a>
								<div class="hidden">
									<input type="hidden" name="data[Route]" value="<?php echo $route_name;?>"/>
									<input type="hidden" name="data[Date]" value="<?php echo $date;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Address]" value="<?php echo $address;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][City]" value="<?php echo $city;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][State]" value="<?php echo $state;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Zip]" value="<?php echo $zipcode;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Unit]" value="<?php echo $suite;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Invoice Number]" value=""/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Intercom Code]" value=""/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Phone]" value="<?php echo $phone;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][First Name]" value="<?php echo $first_name;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Last Name]" value="<?php echo $last_name;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Email]" value="<?php echo $email;?>"/>
									<input type="hidden" name="data[<?php echo $idx;?>][Delivery][Instructions]" value="<?php echo $special_instructions;?>"/>
									
								</div>
							</td>
						</tr>
						<?php										
					}
					
				}
				?>
					</tbody>
				</table>
			<?php
			}
			?>
			<button type="button" class="submit_csv btn btn-primary btn-large pull-left">Create Delivery CSV</button>
		</form>
		<form action="/deliveries/finish" method="post">
			<input type="hidden" value="<?php echo $date;?>" name="data[Delivery][date]"/>
			<input type="submit" class="btn btn-large btn-success pull-right" value="Finish Delivery"/>
		</form>
	</div>
</div>