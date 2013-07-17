<?php

//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	//'frontend/reservation_ferry',
	'frontend/bootstrap-form'
	),
	'stylesheet',
	array('inline'=>false)
);

echo $this->Html->script(array(
	'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui file
	'frontend/reservation_thank_you.js',
	'frontend/reservation_sidebar.js'
	),
	FALSE
);
?>

<div class="container">

	<div class="row">
		<div class="sixteen columns alpha">
		   
			<div class="page_heading"><h1>Thank You</h1></div>
			
<!-- 			<div class="breadcrumb">
		        <a href="index.html" class="first_bc"><span>Home</span></a>
		        <a href="page_right_sidebar.html" class="last_bc"><span>Test Page</span></a>
		    </div> -->
		</div>		
	</div>
	
	<div class="row">
			<!-- Wide Column -->
			<div class="twelve columns alpha">
				
				<?
				
				
switch (end(array_keys($_SESSION))) {
	
	// Ferry Reservation -----------------------------------------------------------------------
	//------------------------------------------------------------------------------------------
	
	case 'Reservation_ferry':
		?><p><img src="/img/frontend/check.png" style="margin-right: 3px;"><b>Your ferry booking has been added to your trip.</b></p><?
		//Get the port of arrival
		switch($_SESSION['Reservation_ferry']['Reservation'][0]['depart_port']){
			case 'Port Angeles':
				$arrive_port = 'Victoria';
				break;
				
			default:
				$arrive_port = 'the Olympic Peninsula';
				break;
		}
		//If a hotel has not been booked-------------------------------------------
		if (!in_array('Reservation_hotel', array_keys($_SESSION))) {
			//if it's a one-way trip, then we want three random hotels, in the port of arrival, with a one-night stay, after the ferry has landed, with available inventory
			// if ($_SESSION['Reservation_ferry']['Reservation'][0]['trip_type'] == 'oneway'){
				// echo "A one night hotel stay in ". $arrive_port ." with a checkin date of ". $_SESSION['Reservation_ferry']['Reservation'][0]['departs'];
			// } 
			// //if it's a roundtrip, then we want three random hotels, in the port of arrival, between the depart & return dates, with available inventory
			// else {	
				?> 
				
				<div style="background-color: #eee;padding: 5px;">
					<h3 style="float: left; margin: 0;">Add a hotel</h3>
					<a href="/hotels-attractions" class="btn btn-mini pull-right" style="margin-top: 1px;">View all hotels →</a>
					<div style="clear:both;"></div>
				</div>
				
				<p>Want to add a hotel to your stay? Check out these hotels in <?php echo $arrive_port ?> available for your trip.</p>
				<div class="row-fluid"> <?
				foreach ($suggested_hotels as $hotel) {
					?>
					<div class="span4 thankyoubox">
							<div class="pic">
								<a href="<? echo $hotel['url']; ?>"><img src="<? echo $hotel['image']; ?>"><div class="img_overlay"></div></a>
							</div>
							<h4 style="font-weight:bold; margin-bottom: 0;"><a href="<? echo $hotel['url']; ?>"><? echo $hotel['name']; ?></a></h4>
							<a style="color: #EE3A43;" href="<? echo $hotel['url']; ?>">From $<? echo $hotel['starting_price']; ?>/night</a>
							
					</div>
					<?
				}
				?> </div> <?
			//}
			
		} 
		// if a hotel has been booked ---------------------------------------------
		else {
			//we want Butchart Gardens (if the arrival port is Victoria) plus two/three random attractions, in the port of arrival, no time constraints 
			//echo $_SESSION['Reservation_dates']['depart_date'] . " and " . $_SESSION['Reservation_dates']['return_date'] . ".";
			
			//echo "<h3>Add an attraction</h3>";
				?> 
				
				<div style="background-color: #eee;padding: 5px;">
					<h3 style="float: left; margin: 0;">Add an attraction</h3>
					<a href="/hotels-attractions" class="btn btn-mini pull-right" style="margin-top: 1px;">View all attractions →</a>
					<div style="clear:both;"></div>
				</div>
				<p>Looking for some entertainment? Check out our great selection of attraction tickets and activities in <? echo $arrive_port; ?> you can add on to your ferry reservation.</p>				
				
				<div class="row-fluid"> <?
				//var_dump($suggested_attractions);
				//var_dump($suggested_hotel);
				//var_dump($suggested_ferry);
				
				//debug($suggested_attractions);
				
				foreach ($suggested_attractions as $attraction) {
					?>
					<div class="span4 thankyoubox">
							<div class="pic">
								<a href="<? echo $attraction['url']; ?>"><img src="<? echo $attraction['image']; ?>"><div class="img_overlay"></div></a>
							</div>
							<h4 style="font-weight:bold; margin-bottom: 0;"><a href="<? echo $attraction['url']; ?>"><? echo $attraction['name']; ?></a></h4>
							<a style="color: #EE3A43;" href="<? echo $attraction['url']; ?>">From $<? echo $attraction['starting_price']; ?>/ticket</a>
							
					</div>
					<?
				}
				?> </div> <?
			
		}
		
		break;

	// Hotel Reservation -----------------------------------------------------------------------
	//------------------------------------------------------------------------------------------

	case 'Reservation_hotel':
		?><p><img src="/img/frontend/check.png" style="margin-right: 3px;"><b>Your hotel reservation has been added to your trip.</b></p><?
		//If a ferry has not been booked--------------------------------------------
		if (!in_array('Reservation_ferry', array_keys($_SESSION))) {
			//we want a round-trip ferry for Victoria (canadian destinations) or Port Angeles (US destinations), 1 vehicle, bookending the hotel stay
			//echo "A roundtrip, vehicle ferry trip between ";
			//echo $_SESSION['Reservation_dates']['depart_date'] . " and " . $_SESSION['Reservation_dates']['return_date'] . ". (design the next step?)";
		?>
				<div style="background-color: #eee;padding: 5px;">
					<h3 style="float: left; margin: 0;">Add a ferry reservation</h3>
					<div style="clear:both;"></div>
				</div>
				
				<p>Need a ferry reservation to go with that hotel room? The MV Coho has sailings from Port Angeles to Victoria and back every day. <a href="/reservations/ferry" style="color: #ee3a43;">Click here to book your ferry reservation.</a></p>
		<?
		//If a ferry has been booked -----------------------------------------------
		} else {
			
			//Get the port of arrival
			switch($_SESSION['Reservation_ferry']['Reservation'][0]['depart_port']){
				case 'Port Angeles':
					$arrive_port = 'Victoria';
					break;
					
				default:
					$arrive_port = 'the Olympic Peninsula';
					break;
			}
			
			//we want Butchart Gardens (if the arrival port is Victoria) plus two/three random attractions, in the port of arrival, no time constraints 
			//echo "<h3>Add an attraction</h3><p>Looking for some entertainment? Check out our great selection of attraction tickets and activities in " . $arrive_port . " you can add on to your hotel stay.";
				?> 
				<div style="background-color: #eee;padding: 5px;">
					<h3 style="float: left; margin: 0;">Add an attraction</h3>
					<a href="/hotels-attractions" class="btn btn-mini pull-right" style="margin-top: 1px;">View all attractions →</a>
					<div style="clear:both;"></div>
				</div>
				<p>Looking for some entertainment? Check out our great selection of attraction tickets and activities in <? echo $arrive_port; ?> you can add on to your hotel reservation.</p>				
				
				
				<div class="row-fluid"> <?
				//var_dump($suggested_attractions);
				//var_dump($suggested_hotel);
				//var_dump($suggested_ferry);
				foreach ($suggested_attractions as $attraction) {
					?>
					<div class="span4 thankyoubox">
							<div class="pic">
								<a href="<? echo $attraction['url']; ?>"><img src="<? echo $attraction['image']; ?>"><div class="img_overlay"></div></a>
							</div>
							<h4 style="font-weight:bold; margin-bottom: 0;"><a href="<? echo $attraction['url']; ?>"><? echo $attraction['name']; ?></a></h4>
							<a style="color: #EE3A43;" href="<? echo $attraction['url']; ?>">From $<? echo $attraction['starting_price']; ?>/ticket</a>
							
					</div>
					<?
				}
				?> </div> <?
		}
		
		break;
		
	// Attraction Reservation ------------------------------------------------------------------
	//------------------------------------------------------------------------------------------
		
	case 'Reservation_attraction':
		?><p><img src="/img/frontend/check.png" style="margin-right: 3px;"><b>Your attraction tickets have been added to your trip.</b></p><?
		
		//If a ferry has not been booked--------------------------------------------
		if (!in_array('Reservation_ferry', array_keys($_SESSION))) {
		?>
				<div style="background-color: #eee;padding: 5px;">
					<h3 style="float: left; margin: 0;">Add a ferry reservation</h3>
					<div style="clear:both;"></div>
				</div>
				
				<p>Need a ferry reservation to go with that hotel room? The MV Coho has sailings from Port Angeles to Victoria and back every day. <a style="color: #ee3a43;" href="/reservations/ferry">Click here to book your ferry reservation.</a></p>
		<?		} 
		//If a hotel has not been booked--------------------------------------------
		elseif (!in_array('Reservation_hotel', array_keys($_SESSION))) {
			
				//Get the port of arrival
				switch($_SESSION['Reservation_ferry']['Reservation'][0]['depart_port']){
					case 'Port Angeles':
						$arrive_port = 'Victoria';
						break;
						
					default:
						$arrive_port = 'the Olympic Peninsula';
						break;
				}
			
				//echo "<h3>Add a hotel</h3><p>Want to add a hotel to your stay? Check out these hotels in " . $arrive_port . ", available for your trip.";
				?> 
				
				<div style="background-color: #eee;padding: 5px;">
					<h3 style="float: left; margin: 0;">Add a hotel</h3>
					<a href="/hotels-attractions" class="btn btn-mini pull-right" style="margin-top: 1px;">View all hotels →</a>
					<div style="clear:both;"></div>
				</div>
				
				<p>Want to add a hotel to your stay? Check out these hotels in <?php echo $arrive_port ?> available for your trip.</p>
				
				<div class="row-fluid"> <?
				foreach ($suggested_hotels as $hotel) {
					?>
					<div class="span4 thankyoubox">
							<div class="pic">
								<a href="<? echo $hotel['url']; ?>"><img src="<? echo $hotel['image']; ?>"><div class="img_overlay"></div></a>
							</div>
							<h4 style="font-weight:bold; margin-bottom: 0;"><a href="<? echo $hotel['url']; ?>"><? echo $hotel['name']; ?></a></h4>
							<a style="color: #EE3A43;" href="<? echo $hotel['url']; ?>">From $<? echo $hotel['starting_price']; ?>/night</a>
							
					</div>
					<?
				}
				?> </div> <?
		} else {
			
			//Get the port of arrival
			switch($_SESSION['Reservation_ferry']['Reservation'][0]['depart_port']){
				case 'Port Angeles':
					$arrive_port = 'Victoria';
					break;
					
				default:
					$arrive_port = 'the Olympic Peninsula';
					break;
			}
			
			//offer another attraction
			//echo "<h3>Add another attraction</h3><p>Make it the trip to end all trips and find even more things to do in " . $arrive_port . ".";
				?> 
				<div style="background-color: #eee;padding: 5px;">
					<h3 style="float: left; margin: 0;">Add another attraction</h3>
					<a href="/hotels-attractions" class="btn btn-mini pull-right" style="margin-top: 1px;">View all attractions →</a>
					<div style="clear:both;"></div>
				</div>
				
				<p>Make it the best trip ever and find even more things to do while you're in <?php echo $arrive_port ?>.</p>
				
				<div class="row-fluid"> <?
				//var_dump($suggested_attractions);
				//var_dump($suggested_hotel);
				//var_dump($suggested_ferry);
				foreach ($suggested_attractions as $attraction) {
					?>
					<div class="span4 thankyoubox">
							<div class="pic">
								<a href="<? echo $attraction['url']; ?>"><img src="<? echo $attraction['image']; ?>"><div class="img_overlay"></div></a>
							</div>
							<h4 style="font-weight:bold; margin-bottom: 0;"><a href="<? echo $attraction['url']; ?>"><? echo $attraction['name']; ?></a></h4>
							<a style="color: #EE3A43;" href="<? echo $attraction['url']; ?>">From $<? echo $attraction['starting_price']; ?>/ticket</a>
							
					</div>
					<?
				}
				?> </div> <?
		}
		
		break;
		
	// Package Reservation ---------------------------------------------------------------------
	//------------------------------------------------------------------------------------------
		
	case 'Reservation_package':
			//offer another attraction
			//echo "<h3>Add an attraction</h3><p>Looking for great deals on local attractions and things to do during your trip? Add an attraction to your package.";
				?> 
				<div style="background-color: #eee;padding: 5px;">
					<h3 style="float: left; margin: 0;">Add an attraction</h3>
					<a href="/hotels-attractions" class="btn btn-mini pull-right" style="margin-top: 1px;">View all attractions →</a>
					<div style="clear:both;"></div>
				</div>
				
				<p>Looking for great deals on local attractions and things to do during your trip? Add an attraction to your package.</p>
				<div class="row-fluid"> <?
				//var_dump($suggested_attractions);
				//var_dump($suggested_hotel);
				//var_dump($suggested_ferry);
				foreach ($suggested_attractions as $attraction) {
					?>
					<div class="span4 thankyoubox">
							<div class="pic">
								<a href="<? echo $attraction['url']; ?>"><img src="<? echo $attraction['image']; ?>"><div class="img_overlay"></div></a>
							</div>
							<h4 style="font-weight:bold; margin-bottom: 0;"><a href="<? echo $attraction['url']; ?>"><? echo $attraction['name']; ?></a></h4>
							<a style="color: #EE3A43;" href="<? echo $attraction['url']; ?>">From $<? echo $attraction['starting_price']; ?>/ticket</a>
							
					</div>
					<?
				}
				?> </div> <?
		
		
		break;
	
	default:
		
		echo "Your reservation has been updated - you can continue browsing or checkout to the right.";
		
		//debug($_SESSION);
		
		break;
}

				
				
				?>
				
			</div>
			<!-- Wide Column::END -->
	
	
			<!-- Side Column -->
			<?php 

			echo $this->element('pages/sidebar',array(
				'current_page'=>'reservation',
				'Ferries'=>'YES',
				'Hotels'=>'YES',
				'Attractions'=>'YES',
				'Packages'=>'YES',
				'ferry_sidebar'=>$ferry_sidebar,
				'hotel_sidebar'=>$hotel_sidebar,
				'attraction_sidebar'=>$attraction_sidebar,
				'package_sidebar'=>$package_sidebar
			)); 
			?>
				
		</div>	