<?php
//add scripts to header
echo $this->Html->script(array('admin/events.js'),FALSE);

?>


<div>
	<!-- To be edited later Admin index body content goes here -->
	<div class="well well-large">
		<h4 class="heading">Customer Information</h4>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Phone</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<div class="formRow">
			<form action="/invoices/dropoff" method="post">
				<input value="" name="" type="hidden"/>
				<input class="btn btn-success" type="submit" value="Drop Off"/>
			</form>
			
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
			<div class="formRow">
				<button class="btn btn-primary">Pickup</button>
			</div>	
		</form>
	</div>
	
</div>


