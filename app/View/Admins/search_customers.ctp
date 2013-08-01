<?php
//CSS Files
$this->Html->css(array(
	'admin/events'
	),
	'stylesheet',
	array('inline'=>false)
);

?>

<div class="formRow">
	<h2 class="heading">Select Customer</h2>
	<form action="/admins/search_customers" method="post" >
		<table class="table table-bordered table-condensed table-hover table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Last Name</th>		
					<th>First Name</th>
					<th>Phone</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
			<?php
			
			if(count($users)>0){
				
				foreach ($users as $u) {
					$user_id = $u['User']['id'];
					$first_name = $u['User']['first_name'];
					$last_name = $u['User']['last_name'];
					//$middle_initial = $u['User']['middle_initial'];
					$phone = $u['User']['contact_phone'];
					$street = $u['User']['contact_address'];
					$city = $u['User']['contact_city'];
					$state = $u['User']['contact_state'];
					$zip = $u['User']['contact_zip'];
					$email = $u['User']['contact_email'];
					?>
					<tr class="finger">
						<td><label class="radio"><input value="<?php echo $user_id;?>" type="radio" name="query"/> <?php echo $user_id;?></label></td>
						<td><?php echo $last_name;?></td>
						<td><?php echo $first_name;?></td>
						<td><?php echo $phone;?></td>
						<td><?php echo $street;?></td>
						<td><?php echo $city;?></td>
						<td><?php echo $state;?></td>
						<td><?php echo $zip;?></td>
						<td><?php echo $email;?></td>
					</tr>
					
					
					<?php
				}
			}
			
			?>		
			</tbody>
		</table>
		<button id="searchButton" type="submit" class="btn btn-primary">Select Customer</button>
	</form>
</div>
