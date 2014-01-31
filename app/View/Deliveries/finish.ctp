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
			<table class="table table-bordered table-striped">
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
				
				foreach ($tvalue as $ttkey => $ttvalue) {
					$type = $ttkey; //what type of dropoff or pickup
					foreach ($ttvalue as $tttkey => $tttvalue) {
						//debug($tttvalue);
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
						if(!empty($ttvalue[$tttkey]['suite'])){
							$suite = '#'.$ttvalue[$tttkey]['suite'];	
						} else {
							$suite = '';
						}
						
					
						$city = $ttvalue[$tttkey]['city'];
						$state = $ttvalue[$tttkey]['state'];
						$delivery_address = $address.' '.$suite.'<br/>'.ucfirst($city).', '.ucwords($state);
						$country = "USA";
						$email = $ttvalue[$tttkey]['email'];
						if(is_null($ttvalue[$tttkey]['special_instructions']) || empty($ttvalue[$tttkey]['special_instructions'])){
							$special_instructions = $ttvalue[$tttkey]['default_special_instructions'];
						} else {
							$special_instructions = $ttvalue[$tttkey]['special_instructions'];
						}
						$suite = $ttvalue[$tttkey]['suite'];
						$total = $ttvalue[$tttkey]['total'];
						$invoices = $ttvalue[$tttkey]['invoices'];
						
						
						?>
						<tr>
							<td><label class="checkbox"><input type="checkbox" value="<?php echo $delivery_id;?>"/> <?php echo $delivery_id;?></label></td>
							<td><?php echo $last_name;?></td>
							<td><?php echo $first_name;?></td>
							<td><?php echo $delivery_address;?></td>
							<td><?php echo $zipcode;?></td>
							<td><?php echo $special_instructions;?></td>
							<td><?php echo $phone;?></td>
							<td>
								<ol>
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
								</ol>
							</td>
							<td>$<?php echo $total;?></td>
							<td><button class="finish disabled btn btn-small btn-inverse" type="button">Finish <?php echo $delivery_id;?></button></td>
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
			<button type="button" class="submit_csv btn btn-primary btn-large pull-right">Create Delivery CSV</button>
		</form>
	</div>
</div>
<?php

echo $this->Form->end();
?>