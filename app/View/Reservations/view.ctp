<?php
echo $this->Html->script(array(
	'admin/reservation_view.js'
	),
	FALSE
);

//set variables here
$full_name = ucfirst($reservation['Reservation']['first_name']).' '.ucfirst($reservation['Reservation']['middle_initial']).' '.ucfirst($reservation['Reservation']['last_name']);
$reservation_id = $reservation['Reservation']['id'];
$confirmation = $reservation['Reservation']['confirmation'];
$first_name = $reservation['Reservation']['first_name'];
$last_name = $reservation['Reservation']['last_name'];
$email = $reservation['Reservation']['email'];
$birthdate = $reservation['Reservation']['birthdate'];
$phone = $reservation['Reservation']['phone'];
$address = $reservation['Reservation']['address'];
$city = $reservation['Reservation']['city'];
$state = $reservation['Reservation']['state'];
$zip = $reservation['Reservation']['zip'];
$citizenship = $reservation['Reservation']['citizenship'];
$doctype = $reservation['Reservation']['doctype'];
$docnumber = $reservation['Reservation']['docnumber'];
$reference = $reservation['Reservation']['reference'];
$payment_type = $reservation['Reservation']['payment_type'];
$card_full_name = $reservation['Reservation']['card_full_name'];
$card_number = $reservation['Reservation']['card_number'];
$cvv = $reservation['Reservation']['cvv'];
$expires_month = $reservation['Reservation']['expires_month'];
$expires_year = $reservation['Reservation']['expires_year'];
$billing_city = $reservation['Reservation']['billing_city'];
$billing_address = $reservation['Reservation']['billing_address'];
$billing_state = $reservation['Reservation']['billing_state'];
$billing_zip = $reservation['Reservation']['billing_zip'];
$created = $reservation['Reservation']['created'];
?>

<div class="reservations view">
<h2><?php  echo __('Reservation #').$confirmation; ?> <? if ($reservation['Reservation']['hotel_total'] != "0.00" || $reservation['Reservation']['attraction_total'] != "0.00" || $reservation['Reservation']['package_total']  != "0.00" ) { ?><a href="/reports/request_voucher_pdf/<? echo $reservation_id; ?>" class="btn btn-mini pull-right" style="margin-left: 10px;"><i class="icon-print"></i> Print Voucher</a><? } ?><a href="/reservations/processing_print_reservation_email/<? echo $reservation_id; ?>" class="btn btn-mini pull-right"><i class="icon-print"></i> Print Receipt</a></h2>


<div class="row-fluid">
	
	<div id="accordion1" class="accordion"> 
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" href="#customer_detail" data-toggle="collapse" data-parent="#accordion1">Traveler Details</a>
			</div>
			<?php
			echo $this->element('/reservations/view/traveler_edit',array(
				'reservation_id'=>$reservation_id,
				'full_name'=>$full_name,
				'first_name'=>$first_name,
				'last_name'=>$last_name,
				'email'=>$email,
				'birthdate'=>$birthdate,
				'phone'=>$phone,
				'address'=>$address,
				'city'=>$city,
				'state'=>$state,
				'zip'=>$zip,
				'citizenship'=>$citizenship,
				'doctype'=>$doctype,
				'docnumber'=>$docnumber
			));
			?>

		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" href="#payment_detail" data-toggle="collapse" data-parent="#accordion1">Payment Details</a>
			</div>
			<?php
			echo $this->element('/reservations/view/payment_edit',array(
				'reservation_id'=>$reservation_id,
				'reference'=>$reference,
				'payment_type'=>$payment_type,
				'card_full_name'=>$card_full_name,
				'card_number'=>$card_number,
				'cvv'=>$cvv,
				'expires_month'=>$expires_month,
				'expires_year'=>$expires_year,
				'billing_city'=>$billing_city,
				'billing_address'=>$billing_address,
				'billing_state'=>$billing_state,
				'billing_zip'=>$billing_zip,
				'created'=>$created
			));
			?>
		</div>
	</div>
	<!-- Ferry Table -->
	<?php

	echo $this->element('/reservations/view/ferry_edit',array(
		'ferries'=>$ferries,
		'towed_units'=>$towed_units,
		'inv_items'=>$inv_items
	));
	//hotel element
	echo $this->element('/reservations/view/hotel_edit',array(
		'hotels'=>$hotels
	));
	//attraction element
	echo $this->element('/reservations/view/attraction_edit',array(
		'attractions'=>$attractions,
		'attraction_main'=>$attraction_main
	));
	//package element
	echo $this->element('/reservations/view/package_edit',array(
		'packages'=>$packages
	));
	?>
	<div class="formRow">
			
		<!-- cancel total reservation form -->
		<div class="clearfix well well-small span4">
			<form action="/reservations/cancel/<?php echo $reservation_id;?>" method="post">
				<h3 class="heading"><strong>Add to Reservation</strong></h3>
	
				<select id="addToReservationSelect" name="data[Reservation][status]" class="pull-left">
					<option value="1">Ferry</option>
					<option value="2">Hotel</option>
					<option value="3">Attraction</option>
					<option value="4">Package</option>
				</select>
				
				<button id="addtoReservationButton" type="button" class="btn btn-info pull-left" style="margin-left:5px;">Add</button>			
				
			</form>
		</div>
		<!-- cancel total reservation form -->
		<div class="clearfix well well-small span4">
			<form action="/reservations/cancel/<?php echo $reservation_id;?>" method="post">
				<h3 class="heading"><strong>Cancel Reservation</strong></h3>
				<input type="hidden" value="ALL" name="data[type]"/>
	
				<select name="data[Reservation][status]" class="pull-left">
					<option value="1">No Action</option>
					<option value="3">Cancel + No Refund</option>
					<option value="4">Cancel + Refund</option>
					<option value='5'>No Cancel + Refund</option>
				</select>
				
				<button id="cancelReservationButton" type="button" class="btn btn-danger pull-left" style="margin-left:5px;">Cancel</button>			

				
			</form>
		</div>
		<!-- edit reservation -->
		<div class="clearfix well well-small span4" confirmation="<?php echo $reservation['Reservation']['confirmation'];?>" >
			<h3 class="heading"><strong>Edit Reservation</strong></h3>

			<form id="editReservationForm" class="hide" action="/reservations/confirm_edit/<?php echo $reservation_id;?>" method="post"></form>
			
			
			<p id="editCounterP" class="hide"><span id="counter" class="label label-warning"></span><span id="counterP" class="text text-warning"></span></p>
			<button id="cancelAll" type="button" class="btn btn-danger">Cancel All Changes</button>
			<input type="button" id="changeReservation" class="btn" value="Change Reservation" disabled="disabled"/>				
		</div>	
		<!-- Reprint email reservations-->
		<div class="clearfix well well-small span4" style="margin-left:0px;">
			<h3 class="heading"><strong>Resend Reservation Email</strong></h3>
			<form action="/reservations/processing_resend_reservation_email" method="post">
				<input type="hidden" name="data[Reservation][id]" value="<?php echo $reservation_id;?>"/>
				<div class="control-group">
					<label>Email Address</label>
					<div class="input-append">
						<input id="emailInput" type="text" value="<?php echo $email;?>" name="data[Reservation][email]"/>	
						<a id="resendEmail" class="add-on" style="cursor:pointer">Send</a>
					</div>
					<span class="help-block"></span>
				</div>				
			</form>
		</div>
		<div class="clearfix well well-small span4" style="margin-left:25px;">
			<h3 class="heading"><strong>Resend Hotel Email</strong></h3>
			<form action="/reservations/processing_resend_hotel_email" method="post">
				<div id="selectHotelResendDiv" class="control-group">
					<label>Select Hotel</label>
					<select id="hotelEmailSelect" name="data[Reservation][hotel_reservation_id]">
						<option value="No">No Hotel Selected</option>
						<?php
					
						foreach ($email_hotels as $hkey =>$hvalue) {
							$hotel_reservation_id = $hvalue['hotel_reservation_id'];
							$hotel_id = $hvalue['hotel_id'];
							$hotel_name = $hvalue['name'];
							$hotel_room = $hvalue['room'];
							$hotel_confirmation = $hvalue['confirmation'];
							$created = $hvalue['created'];
							$modified = $hvalue['modified'];
							if(is_null($hotel_confirmation)){
								$hotel_confirmation = 'Not Set';
							}
							$hotel_email = $hvalue['email'];
							if($created == $modified){
								$status = 'Not Edited';
								
							} else {
								$status = 'Edited';
							}
							?>
							<option value="<?php echo $hotel_reservation_id;?>" hotel_id ="<?php echo $hotel_id;?>" email="<?php echo $hotel_email;?>" confirmation="<?php echo $hotel_confirmation;?>"><?php echo '['.$hotel_confirmation.'] - '.$hotel_name.' ('.$hotel_room.') ['.$status.']';?></option>
							<?php
						}
						?>
					</select>
					<span class="help-block"></span>
				</div>
				<input type="hidden" name="data[Reservation][id]" value="<?php echo $reservation_id;?>"/>
				<div class="formRow">
					<label>Email Type</label>
					<div class="control-group">
						<label class="radio"><input type="radio" value="confirm" checked="checked" name="data[Reservation][type]"/> Request Hotel Confirmation</label>
					</div>
					<div class="control-group hide">
						<label class="radio"><input type="radio" value="change" name="data[Reservation][type]"/> Request Change In Hotel Reservation</label>
					</div>					
				</div>

				<div class="control-group">
					<label>Hotel Email Address</label>
					<div class="input-append">
						<input id="hotelEmailInput" type="text" value="" name="data[Reservation][email]"/>	
						<a id="resendHotelEmail" class="add-on" style="cursor:pointer">Send</a>
					</div>
					<span class="help-block"></span>
				</div>				
			</form>
		</div>
	</div>

</div>
<form id="hiddenForm" class="hide">
	<input id="reservation_id" type="hidden" value="<?php echo $reservation_id;?>"/>
	<!-- <input id="confirm_id" class="editable" type="hidden" value="<?php echo $reservation['Reservation']['confirmation'];?>" edit="Yes" name="data[Reservation][confirmation]"/> -->
</form>
<div id="towedUnitsDiv" class="hide">
	<?php
	foreach ($towed_units as $tu) {
		$towed_name = $tu['name'];
		$towed_desc = $tu['desc'];
		$towed_title = $towed_name.' ('.$towed_desc.')';
		?>
		<option value="<?php echo $towed_title;?>"><?php echo $towed_title;?></option>
		<?php
	}
	?>	
</div>
<div id="hotelRoomsDiv" class="hide">
<?php
//all the remaining hotel rooms for display
foreach ($hotel_main as $hm) {
	foreach ($hm['HotelRoom'] as $rkey=>$rvalue) {
		$room_main_id = $hm['HotelRoom'][$rkey]['id'];
		$room_hotel_id = $hm['HotelRoom'][$rkey]['hotel_id'];
		$room_main_name = $hm['HotelRoom'][$rkey]['name'];
		?>
		<option class="selectedHotelRoomOptions" value="<?php echo $room_main_id;?>" hotel_id="<?php echo $room_hotel_id;?>"><?php echo $room_main_name;?></option>
		<?php
	}
}
?>								
</div>		
<div id="attractionTourDiv" class="hide">
	
</div>

