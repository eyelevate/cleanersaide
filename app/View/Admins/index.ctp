<?php
//add scripts to header
echo $this->Html->script(array('admin/events.js'),FALSE);

?>


<div class="row-fluid">
	<div class="well well-small">
		<h1 class="heading">Delivery Summary - <?php echo date('D n/d/Y');?></h1>
		<div id="side_accordion-delivery" class="accordion">
			
			
			<?php
			$count_deliveries = isset($schedules) ? count($schedules) : 0;
			?>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-delivery" data-parent="#side_accordion-reports" data-toggle="collapse" class="accordion-toggle collapsed">Delivery [<?php echo $count_deliveries;?> Requested]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-delivery">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-hover">
							<thead>
								<tr>
									<th>Customer ID</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Phone</th>
									<th>Zipcode</th>
									<th>Pickup Date</th>
									<th>Dropoff Date</th>
									<th>Special Instructions</th>
									<th>Profile ID</th>
									<th>Payment ID</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>	
							<?php 
							if(isset($schedules) && count($schedules)>0){
								foreach ($schedules as $s) {
									$customer_id = $s['Schedule']['customer_id'];
									$first_name = $s['Schedule']['first_name'];
									$last_name = $s['Schedule']['last_name'];
									$phone = $s['Schedule']['phone'];
									$zipcode = $s['Schedule']['zipcode'];
									$pickup = $s['Schedule']['pickup_date'];
									$dropoff = $s['Schedule']['dropoff_date'];
									$special_instructions = $s['Schedule']['special_instructions'];
									$profile_id = $s['Schedule']['profile_id'];
									$payment_id = $s['Schedule']['payment_id'];
									$token = $s['Schedule']['token'];
									$token_change = '/deliveries/reschedule/'.$token;
									
									?>
									<tr>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $first_name;?></td>
										<td><?php echo $last_name;?></td>
										<td><?php echo $phone;?></td>
										<td><?php echo $zipcode;?></td>
										<td><?php echo $pickup;?></td>
										<td><?php echo $dropoff;?></td>
										<td><?php echo $special_instructions;?></td>
										<td><?php echo $profile_id;?></td>
										<td><?php echo $payment_id;?></td>
										<td><a target="_blank" href="<?php echo $token_change;?>">Change Schedule</a></td>
									</tr>
									<?php
									
								}
							}
							?>
							</tbody>		
						</table>
					</div>
				</div>	
			</div>		
		</div>	
		
		<a href="/deliveries" class="btn btn-info" target="_blank">Create Delivery</a>
	</div>
	<div class="well well-small">
		<h1 class="heading">Drop Off Summary - <?php echo date('D n/d/Y');?></h1>
		<table class="table table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Quantity</th>
					<th>Before Tax</th>
					<th>Tax</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
			<?php

			$total_qty = 0;
			$total_before_tax = 0;
			$total_tax = 0;
			$total_after_tax = 0;
			if(isset($split_invoices['Dry Clean']) && count($split_invoices['Dry Clean'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($split_invoices['Dry Clean'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Dry Clean</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}

			if(isset($split_invoices['Laundry']) && count($split_invoices['Laundry'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($split_invoices['Laundry'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Laundry</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}
			if(isset($split_invoices['Household']) && count($split_invoices['Household'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($split_invoices['Household'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Household</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}
			if(isset($split_invoices['Alteration']) && count($split_invoices['Alteration'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($split_invoices['Alteration'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Alteration</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}
			if(isset($split_invoices['Other']) && count($split_invoices['Other'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($split_invoices['Other'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Other</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}
			?>
			</tbody>
			
			<tfoot>
				<tr>
					<th style="border-top:2px solid #5e5e5e;">Totals</th>
					<th style="border-top:2px solid #5e5e5e;"><?php echo $total_qty;?></th>
					<th style="border-top:2px solid #5e5e5e;">$<?php echo sprintf('%.2f',$total_before_tax);?></th>
					<th style="border-top:2px solid #5e5e5e;">$<?php echo sprintf('%.2f',$total_tax);?></th>
					<th style="border-top:2px solid #5e5e5e;">$<?php echo sprintf('%.2f',$total_after_tax);?></th>
				</tr>
			</tfoot>

			
		</table>
		<?php
		$count_dry_clean = isset($split_invoices['Dry Clean']) ? count($split_invoices['Dry Clean']) : 0;
		$count_laundry = isset($split_invoices['Laundry']) ? count($split_invoices['Laundry']) : 0;
		$count_household = isset($split_invoices['Household']) ? count($split_invoices['Household']) : 0;
		$count_alteration = isset($split_invoices['Alteration']) ? count($split_invoices['Alteration']) : 0;
		$count_other = isset($split_invoices['Other']) ? count($split_invoices['Other']) : 0;
		?>
		<div id="side_accordion-reports" class="accordion">

			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-Dry_Clean" data-parent="#side_accordion-reports" data-toggle="collapse" class="accordion-toggle collapsed">Dry Clean [<?php echo $count_dry_clean;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-Dry_Clean">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($split_invoices['Dry Clean']) && count($split_invoices['Dry Clean'])>0){
								
								foreach ($split_invoices['Dry Clean'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									$items = json_decode($value['items'],true);
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>	
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-Laundry" data-parent="#side_accordion-reports" data-toggle="collapse" class="accordion-toggle collapsed">Laundry [<?php echo $count_laundry;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-Laundry">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($split_invoices['Laundry']) && count($split_invoices['Laundry'])>0){
								
								foreach ($split_invoices['Laundry'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>	
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-Household" data-parent="#side_accordion-reports" data-toggle="collapse" class="accordion-toggle collapsed">Household [<?php echo $count_household;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-Household">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($split_invoices['Household']) && count($split_invoices['Household'])>0){
								
								foreach ($split_invoices['Household'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>	
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-Alteration" data-parent="#side_accordion-reports" data-toggle="collapse" class="accordion-toggle collapsed">Alteration [<?php echo $count_alteration;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-Alteration">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($split_invoices['Alteration']) && count($split_invoices['Alteration'])>0){
								
								foreach ($split_invoices['Alteration'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>	
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-Other" data-parent="#side_accordion-reports" data-toggle="collapse" class="accordion-toggle collapsed">Other [<?php echo $count_other;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-Other">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($split_invoices['Other']) && count($split_invoices['Other'])>0){
								
								foreach ($split_invoices['Other'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>		
		</div>
	</div>
	<div class="well well-small">
		<h1 class="heading">Pickup Summary - <?php echo date('D n/d/Y');?></h1>
		<table class="table table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Quantity</th>
					<th>Before Tax</th>
					<th>Tax</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
			<?php

			$total_qty = 0;
			$total_before_tax = 0;
			$total_tax = 0;
			$total_after_tax = 0;
			if(isset($pickup_invoices['Dry Clean']) && count($pickup_invoices['Dry Clean'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($pickup_invoices['Dry Clean'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Dry Clean</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}

			if(isset($pickup_invoices['Laundry']) && count($pickup_invoices['Laundry'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($pickup_invoices['Laundry'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Laundry</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}
			if(isset($pickup_invoices['Household']) && count($pickup_invoices['Household'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($pickup_invoices['Household'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Household</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}
			if(isset($pickup_invoices['Alteration']) && count($pickup_invoices['Alteration'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($pickup_invoices['Alteration'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Alteration</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}
			if(isset($pickup_invoices['Other']) && count($pickup_invoices['Other'])>0){
				$qty = 0;
				$before_tax = 0;
				$tax = 0;
				$after_tax = 0;
				foreach ($pickup_invoices['Other'] as $key => $value) {
					$qty += $value['quantity'];
					$before_tax += $value['pretax'];
					$tax += $value['tax'];
					$after_tax += $value['total'];
					$total_qty += $value['quantity'];
					$total_before_tax += $value['pretax'];
					$total_tax += $value['tax'];
					$total_after_tax += $value['total'];
				}
				?>
				<tr>
					<td>Other</td>
					<td><?php echo $qty;?></td>
					<td><?php echo '$'.sprintf('%.2f',$before_tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$tax);?></td>
					<td><?php echo '$'.sprintf('%.2f',$after_tax);?></td>
				</tr>				
				<?php	
			}
			?>
			</tbody>
			
			<tfoot>
				<tr>
					<th style="border-top:2px solid #5e5e5e;">Totals</th>
					<th style="border-top:2px solid #5e5e5e;"><?php echo $total_qty;?></th>
					<th style="border-top:2px solid #5e5e5e;">$<?php echo sprintf('%.2f',$total_before_tax);?></th>
					<th style="border-top:2px solid #5e5e5e;">$<?php echo sprintf('%.2f',$total_tax);?></th>
					<th style="border-top:2px solid #5e5e5e;">$<?php echo sprintf('%.2f',$total_after_tax);?></th>
				</tr>
			</tfoot>

			
		</table>
		<?php
		$count_dry_clean = isset($pickup_invoices['Dry Clean']) ? count($pickup_invoices['Dry Clean']) : 0;
		$count_laundry = isset($pickup_invoices['Laundry']) ? count($pickup_invoices['Laundry']) : 0;
		$count_household = isset($pickup_invoices['Household']) ? count($pickup_invoices['Household']) : 0;
		$count_alteration = isset($pickup_invoices['Alteration']) ? count($pickup_invoices['Alteration']) : 0;
		$count_other = isset($pickup_invoices['Other']) ? count($pickup_invoices['Other']) : 0;
		?>
		<div id="side_accordion-pickup" class="accordion">

			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-pickup-dryclean" data-parent="#side_accordion-pickup" data-toggle="collapse" class="accordion-toggle collapsed">Dry Clean [<?php echo $count_dry_clean;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-pickup-dryclean">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($pickup_invoices['Dry Clean']) && count($pickup_invoices['Dry Clean'])>0){
								
								foreach ($pickup_invoices['Dry Clean'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									$items = json_decode($value['items'],true);
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>	
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-pickup-laundry" data-parent="#side_accordion-pickup" data-toggle="collapse" class="accordion-toggle collapsed">Laundry [<?php echo $count_laundry;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-pickup-laundry">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($pickup_invoices['Laundry']) && count($pickup_invoices['Laundry'])>0){
								
								foreach ($pickup_invoices['Laundry'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>	
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-pickup-household" data-parent="#side_accordion-pickup" data-toggle="collapse" class="accordion-toggle collapsed">Household [<?php echo $count_household;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-pickup-household">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($pickup_invoices['Household']) && count($pickup_invoices['Household'])>0){
								
								foreach ($pickup_invoices['Household'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>	
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-pickup-alteration" data-parent="#side_accordion-pickup" data-toggle="collapse" class="accordion-toggle collapsed">Alteration [<?php echo $count_alteration;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-pickup-alteration">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($pickup_invoices['Alteration']) && count($pickup_invoices['Alteration'])>0){
								
								foreach ($pickup_invoices['Alteration'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>	
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#collapse-pickup-other" data-parent="#side_accordion-pickup" data-toggle="collapse" class="accordion-toggle collapsed">Other [<?php echo $count_other;?> Invoices]</a>
				</div>	
				<div class="accordion-body collapse" id="collapse-pickup-other">			
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Customer ID</th>
									<th>Items</th>
									<th>Qty</th>
									<th>Pretax</th>
									<th>Tax</th>
									<th>Total</th>
									<th>Dropoff</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(isset($pickup_invoices['Other']) && count($pickup_invoices['Other'])>0){
								
								foreach ($pickup_invoices['Other'] as $key => $value) {
									$invoice_id = sprintf('%06d',$value['invoice_id']);
									$customer_id = $value['customer_id'];
									//create items string
									if(count(json_decode($value['items'],true))>0){
										$items = json_decode($value['items'],true);
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
									$quantity = $value['quantity'];
									$pretax = $value['pretax'];
									$tax = $value['tax'];
									$total = $value['total'];
									$dropoff_date = date('D n/d g:ia',strtotime($value['created']));
									$due_date = date('D n/d',strtotime($value['due_date'])).' 4:00pm';
									?>
									<tr>
										<td><?php echo $invoice_id;?></td>
										<td><?php echo $customer_id;?></td>
										<td><?php echo $item_list;?></td>
										<td><?php echo $quantity;?></td>
										<td>$<?php echo $pretax;?></td>
										<td>$<?php echo $tax;?></td>
										<td>$<?php echo $total;?></td>
										<td><?php echo $dropoff_date;?></td>
										<td><?php echo $due_date;?></td>
									</tr>
									<?php
								}
							}
							?>									
							</tbody>

						</table>
					</div>
				</div>	
			</div>		
		</div>
	</div>

</div>


