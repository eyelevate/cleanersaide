<?php
$_SESSION['old_reservation_total'] = 0;
$_SESSION['new_reservation_total'] = 0;
$new_ferry_reservation_total = 0;
$_SESSION['new_reservation_dueAtCheckout'] = 0;
$_SESSION['new_reservation_dueAtTravel'] = 0;
$new_ferry_fee = 0;
$count_hotels = count($new_hotels);
$count_attractions = count($new_attractions);
$count_packages = count($new_packages);

//debug($new_schedule);
?>
<div class="formRow clearfix">
	<legend>Edit Confirmation</legend>
	<form action="/reservations/processing_reservation_edit" method="post">
		
	
		<div class="span12 clearfix" style="margin-left:0px; padding-left:0px; margin-bottom:20px;">
			<div class="span5 pull-left well well-large" style="padding-top:10px; margin:0px;">
				<h3 style="text-align:center">Old Schedule</h3>
				<ul class="unstyled">
					<?php
					echo $this->element('/reservations/confirmEdit/old_ferry',array(
						'new_schedule'=>$new_schedule,
						'count_hotels'=>$count_hotels,
						'count_attractions'=>$count_attractions,
						'count_packages'=>$count_packages,
						
					));

					echo $this->element('/reservations/confirmEdit/old_hotel',array(
						'new_hotels'=>$new_hotels,
						
					));
					
					echo $this->element('/reservations/confirmEdit/old_attraction',array(
						'new_attractions'=>$new_attractions,
						
					));
					
					echo $this->element('/reservations/confirmEdit/old_package',array(
					
					));
					?>
					<li><br/></li>
					<li style="border-top:1px solid #5e5e5e;">
						<p class=""> Total Old Reservation: <span class="pull-right">$<?php echo sprintf('%.2f',$_SESSION['old_reservation_total']);?></span></p>
					</li>	
								
				</ul>
				
			</div>

			<div class="pull-left well well-large span6" style="padding-top:10px; margin:0px;">
				<h3 style="text-align:center">New Schedule</h3>
				<ul class="unstyled">
					<?php
					echo $this->element('/reservations/confirmEdit/new_ferry',array(
						'new_schedule'=>$new_schedule,
						'new_ferry_reservation_total'=>$new_ferry_reservation_total,
						'count_hotels'=>$count_hotels,
						'count_attractions'=>$count_attractions,
						'count_packages'=>$count_packages,
						'new_ferry_fee'=>$new_ferry_fee,
	
					));
					echo $this->element('/reservations/confirmEdit/new_hotel',array(
						'new_hotels'=>$new_hotels,
					));
					echo $this->element('/reservations/confirmEdit/new_attraction',array(
						'new_attractions'=>$new_attractions,
					));
					//new package data goes here	
					echo $this->element('/reservations/confirmEdit/new_package',array(
						'new_packages'=>$new_packages
					));	
					?>
					<li><br/></li>
					<li style="border-top:1px solid #5e5e5e;">
						<p class=""> Total New Reservation: <span class="pull-right">$<?php echo sprintf('%.2f',$_SESSION['new_reservation_total']);?></span></p>
					</li>	
				</ul>
			</div>
		</div>
		<div class="formRow" style="padding-top:20px;">
			<legend>Payment</legend>
			<table class="table table-bordered table-striped" style="width:400px;">
				<tbody>
					<?php
					
					if($count_hotels > 0 || $count_attractions >0 || $count_packages >0){
					
						$compare_reservation_prices = sprintf('%.2f',round($_SESSION['new_reservation_total'] - $_SESSION['old_reservation_total'],2));
						if($compare_reservation_prices >0){
						?>
						<tr>
							
							<td>Total Due from Customer Now</td>
							<td width="100px"><strong class="text text-success">$<?php echo $compare_reservation_prices;?></strong></td>
						</tr>
						<?php
						} else {
						?>
						<tr>
							<td>Total Owed to Customer Now</td>
							<td width="100px"><strong class="text text-error">$<?php echo sprintf('%.2f',round(($compare_reservation_prices*-1),2));?></strong></td>	
						</tr>
						<?php				
						}
					
					} else {
						$compare_reservation_prices = sprintf('%.2f',round($_SESSION['new_reservation_total'] - $_SESSION['old_reservation_total'],2));
						if($compare_reservation_prices >0){
						?>
						<tr>
							
							<td>Total Due from Customer at Travel</td>
							<td width="100px"><strong class="text text-success">$<?php echo $compare_reservation_prices;?></strong></td>
						</tr>
						<?php
						} else {
						?>
						<tr>
							<td>Total Owed to Customer at Travel</td>
							<td width="100px"><strong class="text text-error">$<?php echo sprintf('%.2f',round(($compare_reservation_prices*-1),2));?></strong></td>	
						</tr>
						<?php				
						}						
					}
					?>
	
	
				</tbody>

			</table>
	
			
		</div>
		<div class="hide">
			<input type="hidden" name="data[reservation_id]" value="<?php echo $reservation_id;?>"/>
			<input type="hidden" name="data[Reservation][dueAtCheckout]" value="<?php echo $_SESSION['new_reservation_dueAtCheckout'];?>"/>
			<input type="hidden" name="data[Reservation][dueAtTravel]" value="<?php echo $_SESSION['new_reservation_dueAtTravel'];?>"/>
		</div>
		<div class="formRow">
				
			<a class="btn btn-danger" href="/reservations/view/<?php echo $reservation_id;?>">Go Back</a>
			<button class="btn btn-primary" type="submit">Change Reservation</button>
		</div>
	</form>
</div>
<?php
unset($_SESSION['old_reservation_total']);
unset($_SESSION['new_reservation_total']);
unset($_SESSION['new_reservation_dueAtCheckout']);
unset($_SESSION['new_reservation_dueAtTravel']);
?>