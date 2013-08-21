<?php
//add scripts to header
echo $this->Html->script(array('admin/home.js'),FALSE);

?>


<div>
	<!-- To be edited later Admin index body content goes here -->
	<div class="well well-large">
		<h4 class="heading">Customer Information</h4>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Last</th>
					<th>First</th>
					<th>Phone</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(isset($users)){
					foreach ($users as $u) {
						$id = $u['User']['id'];
						$last_name = $u['User']['last_name'];
						$first_name = $u['User']['first_name'];
						$phone = $u['User']['contact_phone'];
						$street = $u['User']['contact_address'];
						$city = $u['User']['contact_city'];
						$state = $u['User']['contact_state'];
						$zip = $u["User"]['contact_zip'];
						?>
						<tr>
							<td><?php echo $id;?></td>
							<td><?php echo $last_name;?></td>
							<td><?php echo $first_name;?></td>
							<td><?php echo $phone;?></td>
							<td><?php echo $street;?></td>
							<td><?php echo $city;?></td>
							<td><?php echo $state;?></td>
							<td><?php echo $zip;?></td>
						</tr>						
						<?php
					}

				}
				?>
			</tbody>
		</table>
		<div class="formRow">
			<?php
			if(!is_null($customer_id)){
			?>
			<form action="/invoices/dropoff" method="post">
				<input value="" name="" type="hidden"/>
				<input class="btn btn-success" type="submit" value="Drop Off"/>
			</form>
			<?php
			}
			?>
		</div>
	</div>
	<div class="well well-large">
		<form action="/invoices/pickup" method="post">
			<h4 class="heading">Invoices</h4>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Invoice</th>
						<th>Drop</th>
						<th>Due</th>
						<th>Items</th>
						<th>Qty</th>
						<th>Price</th>
					</tr>
				</thead>
			</table>
			<?php
			if(!is_null($customer_id)){
			?>
			<div class="formRow">
				<button class="btn btn-primary">Pickup</button>
			</div>	
			<?php
			}
			?>
		</form>
	</div>
	
</div>


