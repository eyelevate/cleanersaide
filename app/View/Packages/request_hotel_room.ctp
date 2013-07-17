<?php
//ferry data

$grab_lowest_hotel = array();
foreach ($hotels as $hkey => $hvalue) {
	$hotel_id = $hotels[$hkey]['Hotel']['id'];
	$hotel_name = $hotels[$hkey]['Hotel']['name'];
	$hotel_country = $hotels[$hkey]['Hotel']['country'];
	$hotel_status = $hotels[$hkey]['Hotel']['status'];	
	
	switch ($hotel_status) {
		case '1':
			
			break;
		case '2': //unbookable
				$hotel_status_label = 'Unbookable';
				$hotel_status_class = 'label-important';
			break;
		case '3': //unbookable except in packages
				$hotel_status_label = 'Unbookable, except in packages';
				$hotel_status_class = 'label-warning';
			break;
			 
		case '4': //unbookbale excpet in packages or by employees
				$hotel_status_label = 'Unbookable, except in packages or by employees';
				$hotel_status_class = 'label-warning';
			break;
		case '5': //bookable but not public
				$hotel_status_label = 'Bookable, but not public';
				$hotel_status_class = 'label-success';
			break;
		case '6'://bookbale and public
				$hotel_status_label = 'Bookable, and public';
				$hotel_status_class = 'label-success';
			break;
		default:
				$hotel_status_label = 'Not Set';
				$hotel_status_class = '';
			break;
	}
	
	?>
	<li class="well well-small" style="margin-top:0px; margin-bottom:0px;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h2><?php echo $hotel_name;?> <span class="label <?php echo $hotel_status_class;?>"><?php echo $hotel_status_label;?></span></h2>
		<?php
		foreach ($hotels[$hkey]['HotelRoom'] as $hrkey => $hrvalue) {
			$room_id = $hotels[$hkey]['HotelRoom'][$hrkey]['id'];
			$room_name =$hotels[$hkey]['HotelRoom'][$hrkey]['name'];
			$room_tax_rate = $hotels[$hkey]['HotelRoom'][$hrkey]['tax_rate'];
			$room_inventory = $hotels[$hkey]['HotelRoom'][$hrkey]['inventory'];
			foreach ($room_inventory as $rikey => $rivalue) {
				$room_lowest_net = $room_inventory['net'];
				$room_lowest_markup = $room_inventory['markup'];
				$room_lowest_gross = $room_inventory['gross'];
			}
			$room_tax = sprintf('%.2f',round($room_lowest_gross * $room_tax_rate,2));
			$room_after_tax = sprintf('%.2f',$room_lowest_gross + $room_tax);
			$grab_lowest_hotel[$room_after_tax] = array('name'=>$room_name,'gross'=>$room_after_tax);
			$room_status = $hotels[$hkey]['HotelRoom'][$hrkey]['status'];
			switch ($room_status) {
				case '1': //unfinished
					
					break;
				case '2': //unbookable
						$room_status_label = 'Unbookable';
						$room_status_class = 'label-important';
					break;
				case '3': //unbookable except in packages
						$room_status_label = 'Unbookable, except in packages';
						$room_status_class = 'label-warning';
					break;
					 
				case '4': //unbookbale excpet in packages or by employees
						$room_status_label = 'Unbookable, except in packages or by employees';
						$room_status_class = 'label-warning';
					break;
				case '5': //bookable but not public
						$room_status_label = 'Bookable, but not public';
						$room_status_class = 'label-success';
					break;
				case '6'://bookbale and public
						$room_status_label = 'Bookable, and public';
						$room_status_class = 'label-success';
					break;
				default:
						$room_status_label = 'Not Set';
						$room_status_class = '';
					break;
			}
			?>
			<div id="sizedRoomDiv" class="well well-small" style="margin-top:3px;margin-bottom:3px;">
				<label class="checkbox heading"><input class="checkHotelRoom" type="checkbox" checked="checked"/><strong><?php echo $room_name;?></strong> <span class="label <?php echo $room_status_class;?>"><?php echo $room_status_label;?></span></label>
				<div class="clearfix">
					<table class="table table-bordered pull-left" style="width:45%">
						<thead>
							<tr>
								<th></th>
								<th>Lowest Rate</th>
								<th>Package Setup</th>
							</tr>
						</thead>
						<tbody>
							<?php
							switch ($hotel_country) {
								case '1': //us
									?>
									<tr style="padding:0px;">
										<th>Net</th>
										<td class="input-prepend"><span class="add-on">US$</span><input class="lrNet" type="text" disabled="disabled" style="width:75px;" value="<?php echo $room_lowest_net;?>"/></td>
										<td class="input-prepend"><span class="prependLabel add-on">US$</span><input class="psNet" type="text" style="width:75px" name="data[Package][hotel_rooms][<?php echo $room_id;?>][net]" value="<?php echo $room_lowest_net;?>"/></td>
									</tr>									
									<?php
									break;
								
								default: //can
									?>
									<tr style="padding:0px;">
										<th>Net</th>
										<td class="input-prepend"><span class="add-on">CN$</span><input class="lrNet" type="text" disabled="disabled" style="width:75px" value="<?php echo $room_lowest_net;?>"></td>
										<td class="input-prepend"><span class="prependLabel add-on">CN$</span><input class="psNet" type="text" style="width:75px" name="data[Package][hotel_rooms][<?php echo $room_id;?>][net]" value="<?php echo $room_lowest_net;?>"/></td>
									</tr>	
									<tr style="padding:0px;">
										<th>Exchange</th>
										<td class="input-append"><input class="lrExchange" type="text" style="width:75px" disabled="disabled"  value="<?php echo $exchange;?>"/><span class="add-on"><a class="exchangeRate" type="canusd">CAN/USD</a></span></td>
										<td class="input-append"><input class="psExchange" type="text" style="width:75px" exchange="<?php echo $exchange;?>" name="data[Package][hotel_rooms][<?php echo $room_id;?>][exchange]" value="<?php echo $exchange;?>"/><span class="add-on"><a class="exchangeRateSetup" type="canusd">CAN/USD</a></span></td>
									</tr>									
									<?php
									break;
							}
							?>
							<tr>
								<th>Markup</th>
								<td class="input-append"><input class="lrMarkup" type="text" disabled="disabled" style="width:75px" value="<?php echo $room_lowest_markup;?>"/><span class="add-on">%</span></td>
								<td class="input-append"><input class="psMarkup" type="text" style="width:75px" name="data[Package][hotel_rooms][<?php echo $room_id;?>][markup]" value="<?php echo $room_lowest_markup;?>"/><span class="add-on">%</span></td>
							</tr>
							<tr>
								<th>Gross</th>
								<td class="input-prepend"><span class="add-on">US$</span><input class="lrGross" type="text" style="width:75px" disabled="disabled" value="<?php echo $room_lowest_gross;?>"/></td>
								<td class="input-prepend"><span class="add-on">US$</span><input class="psGross" type="text" style="width:75px" name="data[Package][hotel_rooms][<?php echo $room_id;?>][gross]" value="<?php echo $room_lowest_gross;?>"/></td>
							</tr>
							<tr>
								<th>Tax</th>
								<td class="input-prepend"><span class="add-on">US$</span><input class="lrTax" type="text" style="width:75px" disabled="disabled" value="<?php echo $room_tax;?>"/></td>
								<td class="input-prepend"><span class="add-on">US$</span><input class="psTax" type="text" style="width:75px" tax_rate="<?php echo $room_tax_rate;?>" value="<?php echo $room_tax;?>"/></td>
							</tr>
							<tr>
								<th>After Tax</th>
								<td class="input-prepend"><span class="add-on">US$</span><input class="lrAfterTax" type="text" style="width:75px" disabled="disabled" value="<?php echo $room_after_tax;?>"/></td>
								<td class="input-prepend">
									<span class="add-on">US$</span>
									<input class="psAfterTax" type="text" style="width:75px" value="<?php echo $room_after_tax;?>"/>
									<span class="add-on"><a class="roundUp" style="cursor:pointer">Round</a></span>	
								</td>
							</tr>
						</tbody>
					</table>				
					
				</div>

			</div>			
			<?php
		}
		?>
	<input name="data[Package][hotel_id]" value="<?php echo $hotel_id;?>" type="hidden"/>
	<?php
	$lowest_key = min(array_keys($grab_lowest_hotel));
	$lowest_room_name = $grab_lowest_hotel[$lowest_key]['name'];
	$lowest_gross = $grab_lowest_hotel[$lowest_key]['gross'];
	?>
	<input class="lowest_room_name" type="hidden" value="<?php echo $lowest_room_name;?>"/>
	<input class="lowest_gross" type="hidden" value="<?php echo $lowest_gross;?>"/>
	</li>
	<?php
}
?>