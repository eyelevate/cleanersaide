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
					<th>Starch</th>
					<th>Delivery</th>
					<th>Actions</th>
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
						$starch = $u['User']['starch'];
						$profile_id = $u['User']['profile_id'];
						$payment_id = $u['User']['payment_id'];
						if(isset($profile_id) && !empty($profile_id)){
							$delivery = 'Yes <br/><span>Profile id: <strong>'.$profile_id.'</strong></span> <br/><span>Payment id: <strong>'.$payment_id.'</strong></span>';
						} else {
							$delivery = 'No';
						}
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
							<td><?php echo $starch;?></td>
							<td><?php echo $delivery;?></td>
							<td><a href="/users/edit/<?php echo $customer_id;?>">Edit</a></td>
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
			<form action="/invoices/dropoff/<?php echo $customer_id;?>" method="post">
				<input value="" name="" type="hidden"/>
				<input class="btn btn-large btn-success" type="submit" value="Drop Off"/>
				<?php
				if(isset($profile_id) && !empty($profile_id)){
				?>
				<a href="/deliveries/new_delivery/<?php echo $customer_id;?>" class="btn btn-large btn-primary pull-right">Set Delivery</a>
				<?php	
				}
				?>
				
			</form>
			
			<?php
			}
			?>
		</div>
	</div>
	<div class="well well-large">
		<form action="/invoices/pickup" method="post">
			<h4 class="heading">Invoices</h4>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Invoice</th>
						<th>Rack</th>
						<th>Drop</th>
						<th>Due</th>
						<th>Qty</th>
						<th>Items</th>	
						<th>Price</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach ($invoices as $inv) {
						$invoice_id = sprintf('%06d',$inv['Invoice']['invoice_id']);
						$quantity = $inv['Invoice']['quantity'];
						$total = sprintf('%.2f',$inv['Invoice']['total']);
						$created = date('D n/d/y',strtotime($inv['Invoice']['created']));
						$due_date = date('D n/d/y',strtotime($inv['Invoice']['due_date']));
						$due_string = strtotime($inv['Invoice']['due_date']);
						$today_string = strtotime(date('Y-m-d H:i:s'));
						$rack = $inv['Invoice']['rack'];
						$status = $inv['Invoice']['status'];
						//create items string
						if(count(json_decode($inv['Invoice']['items'],true))>0){
							$items = json_decode($inv['Invoice']['items'],true);
							$item_list = '';
							foreach ($items as $item) {
								$item_qty = $item['quantity'];
								$item_name = $item['name'];
								if(isset($item['colors'])){
									$item_colors = $item['colors'];	
								} else {
									$item_colors = '';
								}
								//switch qty
								if($item_qty > 1){
									$item_list .= '<span class="badge">('.$item_qty.') '.$item_name.'</span>'; 
								} else {
									$item_list .= '<span class="badge">'.$item_name.'</span>';
								}
							}						
						}
						switch($status){
							case '1': //newly created 
							
								if($today_string > $due_string){ //if todays date is greater than the due date and not racked
									$background_color = '#ffd0d0';
								} else { //still not racked but not ready yet
									$background_color = '';
								}
							break;
							
							case '2': //racked and ready to pick up
								$background_color = '#d0ffef';
							break;
							
							case '3':
								
							break;
								
						}
	
					?>
						<tr>
							<td style="background-color:<?php echo $background_color;?>"><?php echo $invoice_id;?></td>
							<td style="background-color:<?php echo $background_color;?>"><?php echo $rack;?></td>
							<td style="background-color:<?php echo $background_color;?>"><?php echo $created;?></td>
							<td style="background-color:<?php echo $background_color;?>"><?php echo $due_date;?></td>
							<td style="background-color:<?php echo $background_color;?>"><?php echo $quantity;?></td>
							<td style="background-color:<?php echo $background_color;?>"><?php echo $item_list;?></td>		
							<td style="background-color:<?php echo $background_color;?>">$<?php echo $total;?></td>
							<td style="background-color:<?php echo $background_color;?>">
								<ul class="unstyled">
									<li class="hide"><?php echo $this->Form->postLink(); ?></li>
									<li class="pull-left" style="margin-right: 5px"><?php echo $this->Form->postLink(__('Reprint'), array('action' => 'reprint', $invoice_id), null, __('Are you sure you want to reprint Invoice #%s?', $invoice_id)); ?></li>
									<li class="pull-left" style="margin-right:5px;"><?php echo $this->Form->postLink(__('Edit'), array('action' => 'edit', $invoice_id), null, __('Are you sure you want to edit Invoice #%s?', $invoice_id)); ?></li>
									<li class="pull-left"><?php echo $this->Form->postLink(__('Cancel'), array('action' => 'cancel', $invoice_id), null, __('Are you sure you want to cancel Invoice #%s?', $invoice_id)); ?></li>
								</ul>
							</td>
						</tr>
					<?php
					}					


				?>
				</tbody>
				<tfoot>
					
				</tfoot>
			</table>
			<?php
			if(!is_null($customer_id)){
			?>
			<div class="formRow">
				<form action="/invoices/pickup" method="post">
					<input value="<?php echo $customer_id;?>" name="data[customer_id]" type="hidden"/>
					<input class="btn btn-large btn-primary" type="submit" value="Pickup"/>
				</form>
			</div>	
			<?php
			}
			?>
		</form>
	</div>
	
</div>


