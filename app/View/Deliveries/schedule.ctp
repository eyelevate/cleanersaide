<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
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
				<a id="submitDeliveryForm" class="add-on" style="cursor:pointer;">Create CSV</a>
			</div>				
			</form>

			
		</div>
		
	</div>
	<div class="formRow">
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
			foreach ($today as $tkey =>$tvalue) {
				foreach ($today[$tkey] as $t) {
					$route_name = $t['route_name'];
					$zipcode = $t['zipcode'];
					$first_name = $t['first_name'];
					$last_name = $t['last_name'];
					$phone = $t['phone'];	
					$start_time = $t['start_time'];
					$end_time = $t['end_time'];
					$time_range = $start_time.' - '.$end_time;
					?>
					<tr>
						<td><?php echo $route_name;?></td>
						<td><?php echo $time_range;?></td>
						<td><?php echo $tkey;?></td>
						<td><?php echo $zipcode;?></td>
						<td><?php echo $first_name;?></td>
						<td><?php echo $last_name;?></td>
						<td><?php echo $phone;?></td>
						<td>
							<a href="">View</a>
							<a href="">Edit</a>
							<a href="">Remove</a>
						</td>
					</tr>
					<?php				
				}
			}
			?>
			</tbody>
		</table>
	</div>
</div>