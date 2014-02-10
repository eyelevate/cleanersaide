<?php
App::uses('AppModel', 'Model');
/**
 * Reservation Model
 *
 */
class Reservation extends AppModel {
	public $name = 'Reservation';


	//form verification
	///Validation array
	public $validate = array(
		'vdata'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),

  
	);


	public function fixLargeData($find)
	{
		foreach ($find as $key1 => $value1) {
			foreach ($find[$key1] as $key2 => $value2) {
				if(isset($find[$key1][$key2]['created'])){
					$find[$key1][$key2]['created'] = $this->arrangeDate($find[$key1][$key2]['created']);
				}
				if(isset($find[$key1][$key2]['modified'])){
					$find[$key1][$key2]['modified'] = $this->arrangeDate($find[$key1][$key2]['modified']);
				}				
			}
		}

		return $find;
	}
	public function arrangeDate($date)
	{
		$date = date('n/d/Y g:i:sa',strtotime($date));
		return $date;
	}
	
	public function sidebar_ferry($data)
	{
		$sidebar = array();
		$idx = -1;
		if(!empty($data)){
			foreach ($data as $key => $value) {
				foreach ($data[$key] as $d) {
					$idx = $idx + 1;
					$adults = $d['adults'];
					$children = $d['children'];
					$infants = $d['infants'];
					$trip_type = $d['trip_type'];
					$depart_port = $d['depart_port'];
					$depart_date = $d['departs'];
					$return_date = $d['returns'];
					$schedule_id1 = $d['schedule_id1'];
					$schedule_id2 = $d['schedule_id2'];
					$inventory_id = $d['inventory_id'];
					if(empty($d['vehicle_count'])){
						$vehicle_count = 0;
					} else {
						$vehicle_count = $d['vehicle_count'];	
					}
					
					
					//inventory data
					$invs = ClassRegistry::init("Inventory")->find("all",array('conditions'=>array('id'=>$inventory_id)));
					foreach ($invs as $i) {
						$inv_name = $i['Inventory']['name'];
						$inv_reservable = $i['Inventory']['reservable'];
						$inv_total_units = $i['Inventory']['total_units'];
						$online_oneway= $i['Inventory']['online_oneway'];
						$online_roundtrip = $i['Inventory']['online_roundtrip'];
						$phone_oneway = $i['Inventory']['phone_oneway'];
						$phone_roundtrip = $i['Inventory']['phone_roundtrip'];
						$overlength_feet = $i['Inventory']['overlength_feet'];
						$overlength_rate = $i['Inventory']['overlength_rate'];
						
					}
					
					$vehicles = array();
					if($vehicle_count > 0){
						
						$invx = -1;
						//vehicle data
						foreach ($d['vehicle'] as $v) {
							$invx = $invx + 1;
							$item_id = '';
							$item_name = '';
							$item_price = '';
							$item_surcharge = '';
							if(!empty($v['inventory_item_id'])){
								$item_id = $v['inventory_item_id'];
								$inv_items = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>$item_id,'inventory_id'=>$inventory_id)));
								foreach ($inv_items as $ii) {
									$item_name = $ii['Inventory_item']['name'];
									$item_price = $ii['Inventory_item']['oneway'];
									$item_surcharge = $ii['Inventory_item']['surcharge'];
								}			
							} elseif(!empty($v['item_id'])) {
								$item_id = $v['item_id'];
								$inv_items = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>$item_id,'inventory_id'=>$inventory_id)));
								foreach ($inv_items as $ii) {
									$item_name = $ii['Inventory_item']['name'];
									$item_price = $ii['Inventory_item']['oneway'];
									$item_surcharge = $ii['Inventory_item']['surcharge'];
								}
							}

							if(isset($v['overlength'])){
								$overlength = $v['overlength'];
								$overlength_net = $overlength - 18;
								// get incremental unit
								$incremental_units = ClassRegistry::init("Incremental_unit")->query('select * from incremental_units where "'.$overlength_net.'" between start and end');;
								if(count($incremental_units) >0){
									foreach ($incremental_units as $ic) {
										$inc_unit = $ic['incremental_units']['inc_units'];
									}
								} else {
									$inc_unit = 0;
								}	
								
							} else {
								$overlength = 0;
								$inc_unit = 0;
							}
							if(isset($v['towed_unit'])){
								$towed_unit = $v['towed_unit'];
							} else {
								$towed_unit = '';
							}
							$vehicles[$invx] = array(
								'item_id'=>$item_id,
								'name'=>$item_name,
								'oneway'=>$item_price,
								'surcharge'=>$item_surcharge,
								'overlength'=>$overlength,
								'inc_unit'=>$inc_unit,
								'towed_unit'=>$towed_unit,
							);
							
						}
					} else {
						$vehicle_count = 0;
					}
					switch ($trip_type) {
						case 'roundtrip': //this is a roundtrip 
							if($depart_port == 'Port Angeles'){
								$return_port = 'Victoria';
							} else {
								$return_port = 'Port Angeles';
							}
							
							//schedule 1 data
							$s1 = ClassRegistry::init("Schedule")->find("all",array('conditions'=>array('id'=>$schedule_id1)));
							$s2 = ClassRegistry::init("Schedule")->find("all",array('conditions'=>array('id'=>$schedule_id2)));
							$schedule1 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id)));
							$schedule2 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id)));
							if(count($s1) >0){
								foreach ($s1 as $sch1) {
									if(!empty($sch1['Schedule']['depart_time'])){
										$s1_depart_time = $sch1['Schedule']['depart_time'];	
									} else {
										$s1_depart_time = 'Not Set';
									}
									if(!empty($sch1['Schedule']['service_date'])){
										$s1_service_date = $sch1['Schedule']['service_date'];
									} else {
										$s1_service_date = 'Not Set';
									}
									
								}
							} else {
								$s1_depart_time = 'Not Set';
								$s1_service_date = 'Not Set';
								
							}
							if(count($s2)> 0){
								foreach ($s2 as $sch2) {
									if(!empty($sch2['Schedule']['depart_time'])){
										$s2_depart_time = $sch2['Schedule']['depart_time'];	
									} else {
										$s2_depart_time = 'Not Set';
									}
									if(!empty($sch2['Schedule']['service_date'])){
										$s2_service_date = $sch2['Schedule']['service_date'];
									} else {
										$s2_service_date = 'Not Set';
									}									
									
								}
							} else {
								$s2_depart_time = 'Not Set';
								$s2_service_date = 'Not Set';
							}
							
							if(count($schedule1) >0){
								foreach ($schedule1 as $s1) {
									$s1_reserved = $s1['Schedule_limit']['reserved'];
									$s1_reservable_units = $s1['Schedule_limit']['reservableUnits'];
									$s1_total_units = $s1['Schedule_limit']['totalUnits'];
									$s1_holds = $s1['Schedule_limit']['holds'];
								}
							} else {
								$s1_reserved = '';
								$s1_reservable_units = '';
								$s1_total_units = '';
								$s1_holds = '';
							}
							if(count($schedule2) > 0){
								foreach ($schedule2 as $s2) {
									$s2_reserved = $s2['Schedule_limit']['reserved'];
									$s2_reservable_units = $s2['Schedule_limit']['reservableUnits'];
									$s2_total_units = $s2['Schedule_limit']['totalUnits'];
									$s2_holds = $s2['Schedule_limit']['holds'];							
								}
							} else {
								$s2_reserved = '';
								$s2_reservable_units = '';
								$s2_total_units = '';
								$s2_holds = '';								
							}						

							break;
						
						default: //oneway
							$return_port = '';
							//schedule 1 data
							$s1 = ClassRegistry::init("Schedule")->find("all",array('conditions'=>array('id'=>$schedule_id1)));
							$schedule1 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id)));
							
							if(count($s1) >0){
								foreach ($s1 as $sch1) {
									$s1_depart_time = $sch1['Schedule']['depart_time'];
									$s1_service_date = $sch1['Schedule']['service_date'];
								}
							} else {
								$s1_depart_time = 'Not Set';
								$s1_service_date = 'Not Set';								
							}
							$s2_depart_time = '';
							$s2_service_date ='';
							
							if(count($schedule1) >0){
								foreach ($schedule1 as $s1) {
									$s1_reserved = $s1['Schedule_limit']['reserved'];
									$s1_reservable_units = $s1['Schedule_limit']['reservableUnits'];
									$s1_total_units = $s1['Schedule_limit']['totalUnits'];
									$s1_holds = $s1['Schedule_limit']['holds'];
								}
							}
							$s2_reserved = '';
							$s2_reservable_units = '';
							$s2_total_units = '';
							$s2_holds = '';							
							break;
					}
					
					$sidebar[$idx] = array(
						'trip_type'=>$trip_type,
						'depart_port'=>$depart_port,
						'return_port'=>$return_port,
						'depart_date'=>$depart_date,
						'return_date'=>$return_date,
						'depart_time'=>$s1_depart_time,
						'return_time'=>$s2_depart_time,
						'depart_full_date'=>$s1_service_date,
						'return_full_date'=>$s2_service_date,
						'depart_reserved'=>$s1_reserved,
						'depart_reservable_units'=>$s1_reservable_units,
						'depart_total_units'=>$s1_total_units,
						'depart_holds'=>$s1_holds,
						'return_reserved'=>$s2_reserved,
						'return_reservable_units'=>$s2_reservable_units,
						'return_total_units'=>$s2_total_units,
						'return_holds'=>$s2_holds,
						'adults'=>$adults,
						'children'=>$children,
						'infants'=>$infants,
						'inventory_id'=>$inventory_id,
						'reservable'=>$inv_reservable,
						'total_units'=>$inv_total_units,
						'online_oneway'=>$online_oneway,
						'online_roundtrip'=>$online_roundtrip,
						'phone_oneway'=>$phone_oneway,
						'phone_roundtrip'=>$phone_roundtrip,
						'overlength_rate'=>$overlength_rate,
						'schedule_id1'=>$schedule_id1,
						'schedule_id2'=>$schedule_id2,
						'vehicle_count'=>$vehicle_count,
						'vehicles'=>$vehicles,
					);
				}
			}
		}
		
		return $sidebar;
	}
	public function sidebar_hotel($data)
	{
		$sidebar = array();
		$room_rates = array();
		$idx = -1;
		foreach ($data as $hotel) {
			$idx++;
			$hotel_id = $hotel['hotel_id'];
			$room_id = $hotel['room_id'];
			$room_count = $hotel['rooms'];
			$start = $hotel['start'];
			$end = $hotel['end'];
			$adults = $hotel['adults'];
			$children = $hotel['children'];
			$paid = $hotel['total'];
			
			//first get hotel information
			$hotels = ClassRegistry::init("Hotel")->find("all",array('conditions'=>array('id'=>$hotel_id)));
			foreach ($hotels as $h) {
				$hotel_name = $h['Hotel']['name'];
				$country = $h['Hotel']['country'];
			}						

			//next get hotel room information
			$rooms = ClassRegistry::init("Hotel_room")->find("all",array('conditions'=>array('id'=>$room_id)));
			foreach ($rooms as $room) {
				$room_id = $room['Hotel_room']['id'];					
				$room_name = $room['Hotel_room']['name'];
				$room_desc = $room['Hotel_room']['room_description'];
				$room_primary_image = $room['Hotel_room']['image_primary'];
				$room_sorted_images = $room['Hotel_room']['images_sort'];
				$occupancy_base = $room['Hotel_room']['occupancy_base'];
				$occupancy_max = $room['Hotel_room']['occupancy_max'];
				$plus_net = $room['Hotel_room']['plus_net'];
				$plus_fee = $room['Hotel_room']['plus_fee'];
				$taxes = json_decode($room['Hotel_room']['taxes'],true);
				$tax_rate = $room['Hotel_room']['tax_rate'];
				$add_ons = json_decode($room['Hotel_room']['add_ons'], true);
				$blackout = json_decode($room['Hotel_room']['blackout'], true);
				$inventory = json_decode($room['Hotel_room']['inventory'],true);
				$status = $room['Hotel_room']['status'];

				foreach ($inventory as $a) {
					$start_date = strtotime($a['start_date']);
					$end_date =strtotime($a['end_date']);
					$net = $a['net'];
					$gross = $a['gross'];
					$markup = $a['markup'];
					$total_rooms = $a['total'];		
				
				
					for ($i=$start_date; $i <= $end_date; $i+=86400) { 
						$room_rates[$i] = array(
							'total_rooms'=>$total_rooms,
							'net'		=>$net,
							'markup'	=>$markup,
							'gross'		=>$gross,
							'status'	=>$status
						);							
					}
						
				}									
			}
			$total_net = 0; //start calculation of total_net
			$total_markup = 0; //start calculation of total markup
			$total_gross = 0; //start calculation of total gross
			//get prices
			foreach ($room_rates as $key => $value) {
				$check_date = date('Y-m-d',$key);
				$net = $room_rates[$key]['net'];
				$markup = $room_rates[$key]['markup'];
				$gross = $room_rates[$key]['gross'];
				for ($i=$start; $i <= $end; $i+=86400) { 
					$date = date('Y-m-d',$i);
					
					if($check_date == $date){
						$total_net = $total_net + $net;
						$total_markup = $total_markup + $markup;
						$total_gross = $total_gross + $gross;
					}
				}
			}
			
			

			$sidebar[$idx] = array(
				'hotel_id'	=>$hotel_id,
				'room_id'	=>$room_id,
				'start'		=>$start,
				'end'		=>$end,
				'adults'	=>$adults,
				'children'	=>$children,
				'hotel_name'=>$hotel_name,
				'country'	=>$country,
				'room_id'	=>	$room_id,
				'room_count'=>$room_count,
				'room_name'	=>	$room_name,
				'room_desc'	=>	$room_desc,
				'room_primary_image'=>$room_primary_image,
				'room_sorted_images'=>$room_sorted_images,
				'occupancy_base'=>$occupancy_base,
				'occupancy_max'=>$occupancy_max,
				'plus_net'	=>$plus_net,
				'plus_fee'	=>$plus_fee,
				'taxes'		=>$taxes,
				'tax_rate'	=>$tax_rate,
				'total_rooms'=>$total_rooms,
				'net'		=>$net,
				'markup'	=>$markup,
				'gross'		=>$gross,
				'status'	=>$status				
			);
			
			
			
		}
		
		return $sidebar;
	}

	public function hotel_package_sidebar($data, $inventory)
	{
		$sidebar = array();
		$room_rates = array();
		$idx = -1;

		foreach ($data as $hotel) {
			$idx++;
			$hotel_id = $hotel['hotel_id'];
			$room_id = $hotel['room_id'];
			$room_count = $hotel['rooms'];
			$start = $hotel['start'];
			$end = $hotel['end'];
			$adults = $hotel['adults'];
			$children = $hotel['children'];
			$paid = $hotel['total'];

			
			//first get hotel information
			$hotels = ClassRegistry::init("Hotel")->find("all",array('conditions'=>array('id'=>$hotel_id)));
			foreach ($hotels as $h) {
				$hotel_name = $h['Hotel']['name'];
				$country = $h['Hotel']['country'];
			}						

			//next get hotel room information
			$rooms = ClassRegistry::init("Hotel_room")->find("all",array('conditions'=>array('id'=>$room_id)));
			if(count($rooms)>0){
				foreach ($rooms as $room) {
					$room_id = $room['Hotel_room']['id'];					
					$room_name = $room['Hotel_room']['name'];
					$room_desc = $room['Hotel_room']['room_description'];
					$room_primary_image = $room['Hotel_room']['image_primary'];
					$room_sorted_images = $room['Hotel_room']['images_sort'];
					$occupancy_base = $room['Hotel_room']['occupancy_base'];
					$occupancy_max = $room['Hotel_room']['occupancy_max'];
					$plus_net = $room['Hotel_room']['plus_net'];
					$plus_fee = $room['Hotel_room']['plus_fee'];
					$taxes = json_decode($room['Hotel_room']['taxes'],true);
					$tax_rate = $room['Hotel_room']['tax_rate'];
					$add_ons = json_decode($room['Hotel_room']['add_ons'], true);
					$blackout = json_decode($room['Hotel_room']['blackout'], true);

					$status = $room['Hotel_room']['status'];
	
				} 
			} else {
				$room_id = '';					
				$room_name = '';
				$room_desc = '';
				$room_primary_image = '';
				$room_sorted_images = '';
				$occupancy_base = '';
				$occupancy_max = '';
				$plus_net = '';
				$plus_fee = '';
				$taxes = '';
				$tax_rate = '';
				$add_ons = '';
				$blackout = '';
				$status = '';				
			}

			//next get inventory room data
			$room_base = array();
			foreach ($inventory as $key => $value) {

				$room_base_check = $inventory[$key]['after_tax'];
				$room_base[$room_base_check] = $room_base_check; 
				
				if($room_id == $key){
					$net = $inventory[$key]['net'];
					$markup = $inventory[$key]['markup'];
					$gross = $inventory[$key]['gross'];
					
					$aftertax = $inventory[$key]['after_tax'];
				}
			}

			$room_lowest_base = min(array_keys($room_base)); 

			$sidebar[$idx] = array(
				'hotel_id'	=>$hotel_id,
				'room_id'	=>$room_id,
				'start'		=>$start,
				'end'		=>$end,
				'adults'	=>$adults,
				'children'	=>$children,
				'hotel_name'=>$hotel_name,
				'country'	=>$country,
				'room_id'	=>	$room_id,
				'room_count'=>$room_count,
				'room_name'	=>	$room_name,
				'room_desc'	=>	$room_desc,
				'room_base' =>	$room_lowest_base,
				'room_primary_image'=>$room_primary_image,
				'room_sorted_images'=>$room_sorted_images,
				'occupancy_base'=>$occupancy_base,
				'occupancy_max'=>$occupancy_max,
				'plus_net'	=>$plus_net,
				'plus_fee'	=>$plus_fee,
				'taxes'		=>$taxes,
				'tax_rate'	=>$tax_rate,
				'total_rooms'=>$room_count,
				'net'		=>$net,
				'markup'	=>$markup,
				'gross'		=>$gross,
				'aftertax'	=>$aftertax,
				'status'	=>$status				
			);
			
			
			
		}
		
		return $sidebar;		
	}

	public function sidebar_attraction($data)
	{

		$idx = -1;
		$sidebar = array();
		if(count($data)>0){

		foreach ($data as $a) {
			$idx++;
			$attraction_id = $a['attraction_id'];
			
			$tour_id =$a['tour_id'];
			if(strtotime($a['start'])== false){
				$start = $a['start'];	
			} else {
				$start = strtotime($a['start']);
			}

			$check_date =$a['date'];
			$time = $a['time'];
			switch($time){
				case '':
					$time = 'No';
					$time_tour = 'No';
				break;
				default:
					$time_tour = 'Yes';
					$time = $time;
				break;
			}
			$purchase_info = $a['purchase_info'];
			
			//first get hotel information
			$attractions = ClassRegistry::init("Attraction")->find("all",array('conditions'=>array('id'=>$attraction_id)));
			if(count($attractions)>0){
			foreach ($attractions as $b) {
				$attraction_name = $b['Attraction']['name'];
				$country = $b['Attraction']['country'];
			}
			} else {
				$attraction_name = '';
				$country = '';
			}
			//next get hotel room information
			
			
			$tours = ClassRegistry::init("Attraction_ticket")->find("all",array('conditions'=>array('id'=>$tour_id)));		
			if(count($tours)>0){
				foreach ($tours as $c) {
					$tour_id = $c['Attraction_ticket']['id'];					
					$tour_name = $c['Attraction_ticket']['name'];
					$tour_desc = $c['Attraction_ticket']['ticket_description'];
					$tour_primary_image = $c['Attraction_ticket']['image_primary'];
					$tour_sorted_images = $c['Attraction_ticket']['images_sort'];
					$taxes = json_decode($c['Attraction_ticket']['taxes'],true);
					$tax_rate = $c['Attraction_ticket']['tax_rate'];
					$add_ons = json_decode($c['Attraction_ticket']['add_ons'], true);
					$blackout = json_decode($c['Attraction_ticket']['blackout'], true);
					$inventory = json_decode($c['Attraction_ticket']['inventory'],true);
					if(!is_null($c['Attraction_ticket']['time_ticket'])){
						$time_tour = $c['Attraction_ticket']['time_ticket'];
						if($time_tour != 'Yes'){
							$time_tour = 'No';
						}
					} else {
						$time_tour = '';
					}
					$status = $c['Attraction_ticket']['status'];

					foreach ($inventory as $d) {
						$start_date = strtotime(date('Y-m-d',$d['start_date']).' 00:00:00');
						if(strtotime($d['end_date'] == false)){
							
							$end_date = strtotime($d['end_date']);
						} else{
							$end_date = $d['end_date'];	
						}
						switch ($time_tour) {
							case 'Yes':
	
								$t_time = $d['time'];
	
								$tour_inventory = $d['age_range'];		
					
								break;
							
							default:
								$t_time = 'No';
								$age_range = $d['age_range'];
						
								$tour_inventory = $age_range;
								break;
						}
						//parse the dates to find matching dates and return the appropriate inventory levels

						
						foreach ($tour_inventory as $tkey => $tvalue) {
							for ($i=$start_date; $i < $end_date; $i+=86400) {
								if(date('Y-m-d',$start) == date('Y-m-d',$i) && $time == $tkey){
						
									$ticket_prices = $tour_inventory;		
									break;					
								}						
							}							
						}
	
					}					
				}
			} else {
				$tour_name = '';
				$tour_desc = '';
				$tour_primary_image = '';
				$tour_sorted_images = '';
				$taxes = '';
				$tax_rate = '';		
				$status = '';		
			}
			$total_net = 0;
			$total_markup = 0;
			$total_gross = 0;
			$cust_data = array();
			foreach ($purchase_info as $e) {
				$name = $e['name'];
				$amount = $e['amount'];
				if($amount == ''){
					$amount = 0;
				}	

				switch ($time_tour) {
					case 'Yes': //a timed tour
						if(!empty($ticket_prices)){	
							foreach ($ticket_prices as $f) {
								foreach ($f as $ti) {
									$age_range = $ti['age_range'];
									if($name == $age_range){
										
										$inventory = $ti['inventory'];
										$net = $ti['net'];
										$markup = $ti['markup'];
										$gross = $ti['gross'];
										$total_net = $total_net+($amount * $net);
										$total_markup = $total_markup+($markup * $amount);
										$total_gross = $total_gross+($gross * $amount);
										$cust_data[$name] = array(
											'name'=>$name,
											'amount'=>$amount,
											'net'=>$net,
											'markup'=>$markup,
											'gross'=>$gross
										);
									}
								}
							}
						}							
						break;
					
					default: //not a timed tour
						if(!empty($tour_inventory)){

							foreach ($tour_inventory as $f) {
								
								$age_range = $f['age_range'];
								
								if($name == $age_range){
									
									$inventory = $f['inventory'];
									$net = $f['net'];
									$markup = $f['markup'];
									$gross = $f['gross'];
									$total_net = $total_net+($amount * $net);
									$total_markup = $total_markup+($markup * $amount);
									$total_gross = $total_gross+($gross * $amount);
									$cust_data[$name] = array(
										'name'=>$name,
										'amount'=>$amount,
										'net'=>$net,
										'markup'=>$markup,
										'gross'=>$gross
									);
								}
							}
						}
						break;
				}				
				
			}	


			$sidebar[$idx] = array(
				'attraction_id'	=>$attraction_id,
				'tour_id'	=>$tour_id,
				'start'		=>$start,
				'time'		=>$time,
				'time_tour'=>$time_tour,
				'attraction_name'=>$attraction_name,
				'country'	=>$country,
				'tour_id'	=>	$tour_id,
				'tour_name'	=>	$tour_name,
				'tour_desc'	=>	$tour_desc,
				'tour_primary_image'=>$tour_primary_image,
				'tour_sorted_images'=>$tour_sorted_images,
				'taxes'		=>$taxes,
				'tax_rate'	=>$tax_rate,
				'purchase_info'=>$purchase_info,
				'total_net'		=>$total_net,
				'total_markup'	=>$total_markup,
				'total_gross'	=>$total_gross,
				'status'	=>$status				
			);

	
		}	
		} 
		return $sidebar;
	}


	public function sidebar_package($data)
	{
		foreach ($data as $key => $value) {
			$packages = $data[$key]['packages'];
			foreach ($packages as $pkey => $pvalue) {
				$package_id = $pvalue['id'];
			}
			//get the inventory from this package_id 
			$package_find = ClassRegistry::init('Package')->find('all',array('conditions'=>array('id'=>$package_id)));
			if(count($package_find)>0){
				foreach ($package_find as $pfkey => $pfvalue) {
					$inventory = json_decode($pfvalue['Package']['hotel_rooms'],true);
				}
			}
			if(isset($data[$key]['packages'])){
				foreach ($data[$key]['packages'] as $pkey => $pvalue) {
					$package_id = $pvalue['id'];
					
					$packages = ClassRegistry::init('Package')->find('all',array('conditions'=>array('id'=>$package_id)));
					if(count($packages)>0){
						foreach ($packages as $p) {
							$package_add_ons = json_decode($p['Package']['add_ons'],true);
							
							$data[$key]['packages'][$pkey]['add_on_summary'] = $package_add_ons;
						}
					} else{
						$data[$key]['packages'][$pkey]['add_on_summary']  = array();
						
					}
				}
				
			} else {
				$data[$key]['packages'][$pkey]['add_on_summary']  = array();
			}
			//ferry
			if(count($data[$key]['ferries'])>0){
				$data[$key]['ferries'] = $this->sidebar_ferry($data[$key]['ferries']);	
			} else {
				$data[$key]['ferries'] = array();
			}
			//hotel
			if(count($data[$key]['hotels'])>0){
				$data[$key]['hotels'] = $this->hotel_package_sidebar($data[$key]['hotels'], $inventory);
			} else {
				$data[$key]['hotels']  = array();
			}
			//attraction
			if(count($data[$key]['attractions'])>0){
				$data[$key]['attractions'] = $this->sidebar_attraction($data[$key]['attractions']);
			} else{
				$data[$key]['attractions']  = array();	
			}
			
		}


		return $data;
	}

	//reorganize final data push to reservation
	public function finalOrder($data){
		$final = array();
		$idx = -1;
		if(!empty($data)){
			foreach ($data as $key => $value) {
				foreach ($data[$key] as $d) {
					$idx++;
					$adults = $d['adults'];
					if($adults ==''){
						$adults = 0;
					}
					$children = $d['children'];
					if($children == ''){
						$children = 0;
					}
					$infants = $d['infants'];
					if($infants == ''){
						$infants = 0;
					}
					//passenger rates
					$adult_rates = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>'19')));
					foreach ($adult_rates as $ar) {
						$adult_rate = $adults * $ar['Inventory_item']['total_price'];
					}
					$child_rates = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>'20')));
					foreach ($child_rates as $cr) {
						$child_rate = $children * $cr['Inventory_item']['total_price'];
					}
					$infant_rate = '0.00';
					
					$trip_type = $d['trip_type'];
					$depart_port = $d['depart_port'];
					$depart_date = $d['departs'];
					$return_date = $d['returns'];
					$schedule_id1 = $d['schedule_id1'];
					$schedule_id2 = $d['schedule_id2'];
					$inventory_id = $d['inventory_id'];
					if(empty($d['vehicle_count'])){
						$vehicle_count = 0;
					} else {
						$vehicle_count = $d['vehicle_count'];	
					}
					
					
					//inventory data
					$invs = ClassRegistry::init("Inventory")->find("all",array('conditions'=>array('id'=>$inventory_id)));
					foreach ($invs as $i) {
						$inv_name = $i['Inventory']['name'];
						$inv_reservable = $i['Inventory']['reservable'];
						$inv_total_units = $i['Inventory']['total_units'];
						$online_oneway= $i['Inventory']['online_oneway'];
						$online_roundtrip = $i['Inventory']['online_roundtrip'];
						$phone_oneway = $i['Inventory']['phone_oneway'];
						$phone_roundtrip = $i['Inventory']['phone_roundtrip'];
						$overlength_feet = $i['Inventory']['overlength_feet'];
						$overlength_rate = $i['Inventory']['overlength_rate'];
						
					}
					$s1 = ClassRegistry::init("Schedule")->find("all",array('conditions'=>array('id'=>$schedule_id1)));
					$schedule1 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id)));
					switch ($trip_type) {
						case 'roundtrip':
							//schedule 1 data
							$s2 = ClassRegistry::init("Schedule")->find("all",array('conditions'=>array('id'=>$schedule_id2)));
							$schedule2 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id)));
							if(count($s1) >0){
								foreach ($s1 as $sch1) {
									$s1_depart_time = $sch1['Schedule']['depart_time'];
									$s1_service_date = $sch1['Schedule']['service_date'];
								}
							}
							if(count($s2)> 0){
								foreach ($s2 as $sch2) {
									$s2_depart_time = $sch2['Schedule']['depart_time'];
									$s2_service_date = $sch2['Schedule']['service_date'];
								}
							}
							
							if(count($schedule1) >0){
								foreach ($schedule1 as $s1) {
									$s1_reserved = $s1['Schedule_limit']['reserved'];
									$s1_reservable_units = $s1['Schedule_limit']['reservableUnits'];
									$s1_total_units = $s1['Schedule_limit']['totalUnits'];
									$s1_holds = $s1['Schedule_limit']['holds'];
									$s1_prev_overlength = $s1['Schedule_limit']['overlength_count'];
									$s1_inc_units = $s1['Schedule_limit']['inc_units'];
								}
							}
							if(count($schedule2) > 0){
								foreach ($schedule2 as $s2) {
									$s2_reserved = $s2['Schedule_limit']['reserved'];
									$s2_reservable_units = $s2['Schedule_limit']['reservableUnits'];
									$s2_total_units = $s2['Schedule_limit']['totalUnits'];
									$s2_holds = $s2['Schedule_limit']['holds'];	
									$s2_prev_overlength = $s2['Schedule_limit']['overlength_count'];
									$s2_inc_units = $s2['Schedule_limit']['inc_units'];						
								}
							}							
							break;
						
						default:
							//schedule 1 data
							if(count($s1) >0){
								foreach ($s1 as $sch1) {
									$s1_depart_time = $sch1['Schedule']['depart_time'];
									$s1_service_date = $sch1['Schedule']['service_date'];
								}
							}
							$s2_depart_time = '';
							$s2_service_date = '';
							
							if(count($schedule1) >0){
								foreach ($schedule1 as $s1) {
									$s1_reserved = $s1['Schedule_limit']['reserved'];
									$s1_reservable_units = $s1['Schedule_limit']['reservableUnits'];
									$s1_total_units = $s1['Schedule_limit']['totalUnits'];
									$s1_holds = $s1['Schedule_limit']['holds'];
									$s1_prev_overlength = $s1['Schedule_limit']['overlength_count'];
									$s1_inc_units = $s1['Schedule_limit']['inc_units'];
								}
							}
							$s2_reserved = '';
							$s2_reservable_units = '';
							$s2_total_units = '';
							$s2_holds = '';	
							$s2_prev_overlength = '';
							$s2_inc_units = '';										
							break;
					}
					

					
					
					
					$vehicles = array();
					if($vehicle_count > 0){
						$vehicle_total_price = 0;
						$invx = -1;
						//vehicle data
						foreach ($d['vehicle'] as $v) {
							$invx = $invx + 1;
							
							if(isset($v['inventory_item_id'])){
								$item_id = $v['inventory_item_id'];
								$inv_items = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>$item_id,'inventory_id'=>$inventory_id)));
								foreach ($inv_items as $ii) {
									$item_name = $ii['Inventory_item']['name'];
									$item_price = $ii['Inventory_item']['oneway'];
									$item_surcharge = $ii['Inventory_item']['surcharge'];
									$item_total = $ii['Inventory_item']['total_price'];
									
								}
							} else {
								$item_id = '';
							
							}

							if(isset($v['overlength'])){
								if($v['overlength'] == 0){
									$overlength = 18;
								} else {
									$overlength = $v['overlength'];
																		
								}
								$overlength_net = ($overlength - 18);
								
							} else {
								$overlength = 0;
								$overlength_net = 0;
								
							}
								
							
							
							$vehicles[$invx] = array(
								'item_id'=>$item_id,
								'name'=>$item_name,
								'oneway'=>$item_price,
								'surcharge'=>$item_surcharge,
								'total_price'=>$item_total,
								'overlength'=>$overlength,
								'overlength_net'=>$overlength_net,
								
							);
							if($overlength_net > 0){
								$item_total = ($overlength_net * $overlength_rate) + $item_total;
							} else {
								$item_total = $item_total;
							}

							$vehicle_total_price = $vehicle_total_price + $item_total;
							
						}
					} else {
						$vehicle_count = 0;
					}
					switch ($trip_type) {
						case 'roundtrip':
							if($depart_port == 'Port Angeles'){
								$return_port = 'Victoria';
							} else {
								$return_port = 'Port Angeles';
							}
							$trip_fee = sprintf('%.2f',round(($online_roundtrip * $vehicle_count),2));
							
							break;
						
						default:
							$return_port = '';
							$trip_fee = sprintf('%.2f',round(($online_oneway * $vehicle_count),2));
							break;
					}
					//calculate subtotal, online fee, due at checkout, due at time of travel
					switch ($inventory_id) {
						case '1': //passengers
							switch ($trip_type) {
								case 'roundtrip':
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2)); 
									$vehicle_total_price = 0;
									$subtotal = $passenger_total;
									$subtotal = sprintf('%.2f',($subtotal*2));		
									break;
								
								default:
									$vehicle_total_price = 0;
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2)); 
									$subtotal = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									break;
							}
						
							$dueAtCheckout = '0.00';
							$total = $subtotal;
							$dueAtTravel = $subtotal; 
							break;
						case '2'; //vehicles
							switch ($trip_type) {
								case 'roundtrip':
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',($subtotal*2));		
									break;
								
								default:
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',$subtotal);		
									break;
							}
							$dueAtCheckout = $trip_fee;
							$total = sprintf('%.2f',round($subtotal + $dueAtCheckout,2));
							$dueAtTravel = $subtotal;
							break;
						case '3'; //motorcycles
							switch ($trip_type) {
								case 'roundtrip':
									$passenger_total = sprintf('%.2f',round((($adult_rate)  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',($subtotal*2));		
									break;
								
								default:
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',$subtotal);		
									break;
							}							
							
							$dueAtCheckout = $trip_fee;
							$total = $subtotal + $dueAtCheckout;
							$dueAtTravel = $subtotal;						
							break;

						default: //bicycles
							
							switch ($trip_type) {
								case 'roundtrip':
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',($subtotal*2));		
									break;
								
								default:
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',$subtotal);		
									break;
							}								
							
							$dueAtCheckout = $trip_fee;
							$total = $subtotal + $dueAtCheckout;
							$dueAtTravel = $subtotal;							
							break;
					}

					$final[$idx] = array(
						'trip_type'=>$trip_type,
						'depart_port'=>$depart_port,
						'return_port'=>$return_port,
						'depart_date'=>$depart_date,
						'return_date'=>$return_date,
						'depart_time'=>$s1_depart_time,
						'return_time'=>$s2_depart_time,
						'depart_full_date'=>$s1_service_date,
						'return_full_date'=>$s2_service_date,
						'depart_reserved'=>$s1_reserved,
						'depart_reservable_units'=>$s1_reservable_units,
						'depart_total_units'=>$s1_total_units,
						'depart_holds'=>$s1_holds,
						'return_reserved'=>$s2_reserved,
						'return_reservable_units'=>$s2_reservable_units,
						'return_total_units'=>$s2_total_units,
						'return_holds'=>$s2_holds,
						'adults'=>$adults,
						'adult_rate'=>$adult_rate,
						'children'=>$children,
						'child_rate'=>$child_rate,
						'infants'=>$infants,
						'infant_rate'=>$infant_rate,
						'inventory_id'=>$inventory_id,
						'reservable'=>$inv_reservable,
						'total_units'=>$inv_total_units,
						'online_oneway'=>$online_oneway,
						'online_roundtrip'=>$online_roundtrip,
						'overlength_rate'=>$overlength_rate,
						'schedule_id1'=>$schedule_id1,
						'schedule_id2'=>$schedule_id2,
						'vehicle_count'=>$vehicle_count,
						'vehicles'=>$vehicles,
						'trip_fee'=>$trip_fee,
						'passenger_total'=>$passenger_total,
						'vehicle_total_price'=>$vehicle_total_price,
						'subtotal'=>$subtotal,
						'total'=>$total,
						'dueAtCheckout'=>$dueAtCheckout,
						'dueAtTravel'=>$dueAtTravel
					);
				}
			}
		}
		
		return $final;
		
	}


	//saving ferry data into the db
	public function saveData($data1, $reservation_id)
	{
		$confirmations = $this->find('all',array('conditions'=>array('id'=>$reservation_id)));
		foreach ($confirmations as $c) {
			$confirmation_id = $c['Reservation']['confirmation'];
		}		
		$reservations = array();
		$idx = -1;
		if(!empty($data1)){
			foreach ($data1 as $key => $value) {
				foreach ($data1[$key] as $d) {
					$idx++;
					$adults = $d['adults'];
					if($adults ==''){
						$adults = 0;
					}
					$children = $d['children'];
					if($children == ''){
						$children = 0;
					}
					$infants = $d['infants'];
					if($infants == ''){
						$infants = 0;
					}
					if(empty($d['vehicle_count'])){
						$vehicle_count = 0;
					} else {
						$vehicle_count = $d['vehicle_count'];	
					}
					
					//passenger rates
					
					$adult_rates = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>'19')));
					foreach ($adult_rates as $ar) {
						$adult_rate = $adults * $ar['Inventory_item']['total_price'];
					}
					$child_rates = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>'20')));
					foreach ($child_rates as $cr) {
						$child_rate = $children * $cr['Inventory_item']['total_price'];
					}
					$driver_rates = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>'18')));
					foreach ($driver_rates as $dr) {
						$driver_rate = $vehicle_count * $dr['Inventory_item']['total_price'];
					}
					$infant_rate = '0.00';
					
					$trip_type = $d['trip_type'];
					$depart_port = $d['depart_port'];
					$depart_date = $d['departs'];
					$return_date = $d['returns'];
					$schedule_id1 = $d['schedule_id1'];
					$schedule_id2 = $d['schedule_id2'];
					$inventory_id = $d['inventory_id'];
					
					switch($inventory_id){
						case '2':
							$drivers = $vehicle_count;
						break;
						
						
						default:
							$drivers = 0;
						break;
					}
					
					
					//inventory data
					$invs = ClassRegistry::init("Inventory")->find("all",array('conditions'=>array('id'=>$inventory_id)));
					foreach ($invs as $i) {
						$inv_name = $i['Inventory']['name'];
						$inv_reservable = $i['Inventory']['reservable'];
						$inv_total_units = $i['Inventory']['total_units'];
						$online_oneway= $i['Inventory']['online_oneway'];
						$online_roundtrip = $i['Inventory']['online_roundtrip'];
						$phone_oneway = $i['Inventory']['phone_oneway'];
						$phone_roundtrip = $i['Inventory']['phone_roundtrip'];
						$overlength_feet = $i['Inventory']['overlength_feet'];
						$overlength_rate = $i['Inventory']['overlength_rate'];
						
					}
					//schedule 1 data
					$s1 = ClassRegistry::init("Schedule")->find("all",array('conditions'=>array('id'=>$schedule_id1)));
					$s2 = ClassRegistry::init("Schedule")->find("all",array('conditions'=>array('id'=>$schedule_id2)));
					$schedule1 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id)));
					$schedule2 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id)));
					if(count($s1) >0){
						foreach ($s1 as $sch1) {
							$s1_depart_time = $sch1['Schedule']['depart_time'];
							$s1_service_date = $sch1['Schedule']['service_date'];
						}
					}
					if(count($s2)> 0){
						foreach ($s2 as $sch2) {
							$s2_depart_time = $sch2['Schedule']['depart_time'];
							$s2_service_date = $sch2['Schedule']['service_date'];
						}
					}
					
					if(count($schedule1) >0){
						foreach ($schedule1 as $s1) {
							$s1_reserved = $s1['Schedule_limit']['reserved'];
							$s1_reservable_units = $s1['Schedule_limit']['reservableUnits'];
							$s1_total_units = $s1['Schedule_limit']['totalUnits'];
							$s1_holds = $s1['Schedule_limit']['holds'];
							$s1_prev_overlength = $s1['Schedule_limit']['overlength_count'];
							$s1_inc_units = $s1['Schedule_limit']['inc_units'];
						}
					}
					if(count($schedule2) > 0){
						foreach ($schedule2 as $s2) {
							$s2_reserved = $s2['Schedule_limit']['reserved'];
							$s2_reservable_units = $s2['Schedule_limit']['reservableUnits'];
							$s2_total_units = $s2['Schedule_limit']['totalUnits'];
							$s2_holds = $s2['Schedule_limit']['holds'];	
							$s2_prev_overlength = $s1['Schedule_limit']['overlength_count'];
							$s2_inc_units = $s1['Schedule_limit']['inc_units'];						
						}
					}
					
					
					
					$vehicles = array();

					if($vehicle_count > 0 && $inventory_id >1){
						//start count of the total price and overlength
						$vehicle_total_price = 0;
						$vehicle_overlength_count = 0;
						$units_additional = 0;
						$invx = -1;
						//vehicle data 
						foreach ($d['vehicle'] as $v) {
							$invx = $invx + 1;
							$towed_unit = $v['towed_unit'];
							if(isset($v['inventory_item_id'])){
								$item_id = $v['inventory_item_id'];
								$inv_items = ClassRegistry::init("Inventory_item")->find("all",array('conditions'=>array('id'=>$item_id,'inventory_id'=>$inventory_id)));
								
								foreach ($inv_items as $ii) {
									$item_name = $ii['Inventory_item']['name'];
									$item_price = $ii['Inventory_item']['oneway'];
									$item_surcharge = $ii['Inventory_item']['surcharge'];
									$item_total = $ii['Inventory_item']['total_price'];
									
								}
							} else {
								$item_id = '';
								$item_name ='';
								$item_price = '';
								$item_surcharge ='';
								$item_total ='';							
							}

							if(!empty($v['overlength'])){
								if($v['overlength'] == 0){
									$overlength = 0;
									$overlength_net = 0;
									//add units onto the current 18 foot base. 
									$units_additional= $units_additional + 1;
									$towed_unit = '';
								} else {
									$overlength = $v['overlength'];
									$overlength_net = $overlength;
									$units_additional =$units_additional + ($overlength / 18);
									
																		
								}
								
							} else {
								$overlength = 0;
								$overlength_net = 0;
								$units_additional= $units_additional + 1;
								$towed_unit = '';
							}
								

							
							$vehicles[$invx] = array(
								'item_id'=>$item_id,
								'name'=>$item_name,
								'oneway'=>$item_price,
								'surcharge'=>$item_surcharge,
								'total_price'=>$item_total,
								'overlength'=>$overlength,
								'overlength_net'=>$overlength_net,
								'towed_unit'=>$towed_unit
								
							);
							if($overlength_net > 0){
								$item_total = ($overlength_net * $overlength_rate) + $item_total;
								
							} else {
								$item_total = $item_total;
							}
							$vehicle_overlength_count += $overlength_net;
							$vehicle_total_price += $item_total;
							
						}
					} else {
						$vehicle_count = 0;
						$vehicle_overlength_count = 0;
					}
					//update the schedule_limit table with the new overlength feet 
					if($inventory_id != '1'){
						$limit_vehicle1 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id)));
						if(!empty($limit_vehicle1)){
							foreach ($limit_vehicle1 as $l1) {
								$old_vehicle_holds1 = $l1['Schedule_limit']['holds'];
								$old_vehicle_overlength1 = $l1['Schedule_limit']['overlength_count'];
								$old_vehicle_reserved1 = $l1['Schedule_limit']['reserved'];
							}
							if($old_vehicle_overlength1 == ''){
								$old_vehicle_overlength1 = 0;
							}
							if($old_vehicle_holds1 == ''){
								$old_vehicle_holds1 = 0;
							}
							if($old_vehicle_reserved1 == ''){
								$old_vehicle_reserved1 = 0;
							}
						} else {
							$old_vehicle_overlength1 = 0;
							$old_vehicle_holds1 = 0;
							$old_vehicle_reserved = 0;
						}
						
						$new_vehicle_overlength1 = $old_vehicle_overlength1 + $vehicle_overlength_count;
						if($old_vehicle_holds1 = 0){
							$new_vehicle_holds1 = 0;
						} else {
							$new_vehicle_holds1 = $old_vehicle_holds1 - 1;
						}
						if($new_vehicle_holds1 < 0){
							$new_vehicle_holds1 =0;
						}
						$inc_units_measure1 = $new_vehicle_overlength1 / 18;
						//check incremental units here
						$incremental_units = ClassRegistry::init("Incremental_unit")->query('select * from incremental_units where "'.$inc_units_measure1.'" between start and end');
						if(count($incremental_units) >0){
							foreach ($incremental_units as $ic) {
								$inc_unit1 = $ic['incremental_units']['inc_units'];
							}
						} else {
							$inc_unit1 = 0;
						}						
						//update incremental units here
						$new_vehicle_reserved1 = sprintf('%.2f',round($old_vehicle_reserved1 + ($units_additional),2));
						//grab return trip limits
						$limit_vehicles2 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id)));
						if(!empty($limit_vehicles2)){
							foreach ($limit_vehicles2 as $l2) {
								$old_vehicle_holds2 = $l2['Schedule_limit']['holds'];
								$old_vehicle_overlength2 = $l2['Schedule_limit']['overlength_count'];
								$old_vehicle_reserved2 = $l2['Schedule_limit']['reserved'];
							}
							if($old_vehicle_overlength2 == ''){
								$old_vehicle_overlength2 = 0;
							}
							if($old_vehicle_holds2 == ''){
								$old_vehicle_holds2 = 0;
							}
							if($old_vehicle_reserved2 ==''){
								$old_vehicle_reserved2 = 0;
							}
						} else {
							$old_vehicle_overlength2 = 0;
							$old_vehicle_holds2 = 0;
							$old_vehicle_reserved2 = 0;
						}
						
						$new_vehicle_overlength2 = $old_vehicle_overlength2 + $vehicle_overlength_count;
						if($old_vehicle_holds2 = 0){
							$new_vehicle_holds2 = 0;
						} else {
							$new_vehicle_holds2 = $old_vehicle_holds2 - 1;
						}
						if($new_vehicle_holds2 < 0){
							$new_vehicle_holds2 =0;
						}
						$inc_units_measure2 = $new_vehicle_overlength2 / 18;
						//check incremental units here
						$incremental_units = ClassRegistry::init("Incremental_unit")->query('select * from incremental_units where "'.$inc_units_measure2.'" between start and end');
						if(count($incremental_units) >0){
							foreach ($incremental_units as $ic) {
								$inc_unit2 = $ic['incremental_units']['inc_units'];
							}
						} else {
							$inc_unit2 = 0;
						}						
						//update incremental units here
						$new_vehicle_reserved2 =sprintf('%.2f',round($old_vehicle_reserved2 + ($units_additional),2));						
						
					} 
		
					switch ($trip_type) {
						case 'roundtrip':
							if($depart_port == 'Port Angeles'){
								$return_port = 'Victoria';
							} else {
								$return_port = 'Port Angeles';
							}
							$trip_fee = sprintf('%.2f',round(($online_roundtrip * $vehicle_count),2));
							//update limit
							$limit_passenger1 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>'1')));
							if(!empty($limit_passenger1)){
								foreach ($limit_passenger1 as $lp1) {
									$old_passenger1 = $lp1['Schedule_limit']['reserved'];
									
									$old_passenger_holds1 = $lp1['Schedule_limit']['holds'];
								}
								if($old_passenger1 == ''){
									$old_passenger1 = 0;
								}
								if($old_passenger_holds1 == ''){
									$old_passenger_holds1 = 0;
								}
							} else {
								$old_passenger1 = 0;
								$old_passenger_holds1 = 0;
							}
							$new_passenger1 = $old_passenger1 + ($adults+$children+$infants);
							if($old_passenger_holds1 =='0'){
								$new_passenger_holds1 = 0;
							} else {
								$new_passenger_holds1 = $old_passenger_holds1-1;
							}
							$limit_passenger2 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>'1')));
							if(!empty($limit_passenger2)){
								foreach ($limit_passenger2 as $lp2) {
									$old_passenger2 = $lp2['Schedule_limit']['reserved'];
									$old_passenger_holds2 = $lp2['Schedule_limit']['holds'];
								}
								if($old_passenger2 == ''){
									$old_passenger2 = 0;
									
								}
								if($old_passenger_holds2 == ''){
									$old_passenger_holds2 = 0;
								}
							} else {
								$old_passenger2 = 0;
								$old_passenger_holds2 = 0;
							}
							$new_passenger2 = $old_passenger2 + ($adults+$children+$infants);
							if($old_passenger_holds2 =='0'){
								$new_passenger_holds2 = 0;
							} else {
								$new_passenger_holds2 = $old_passenger_holds2-1;
							}							
							
							switch($inventory_id){
								case '1': //passenger limit update
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger1.'", holds="'.$new_passenger_holds1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="1"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger2.'", holds="'.$new_passenger_holds2.'" where schedule_id="'.$schedule_id2.'" and inventory_id="1"');
																
									break;
								case '2': //vehicles limit update
									$new_passenger1 = $new_passenger1+$vehicle_count;
									$new_passenger2 = $new_passenger2+$vehicle_count;
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger1.'", holds="'.$new_passenger_holds1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="1"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger2.'", holds="'.$new_passenger_holds2.'" where schedule_id="'.$schedule_id2.'" and inventory_id="1"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set overlength_count ="'.$new_vehicle_overlength1.'", holds="'.$new_vehicle_holds1.'", reserved="'.$new_vehicle_reserved1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="'.$inventory_id.'"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set overlength_count ="'.$new_vehicle_overlength2.'", holds="'.$new_vehicle_holds2.'", reserved="'.$new_vehicle_reserved2.'" where schedule_id="'.$schedule_id2.'" and inventory_id="'.$inventory_id.'"');							
									break;
								default: //motorcycles and bicycles vehicle update

									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger1.'", holds="'.$new_passenger_holds1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="1"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger2.'", holds="'.$new_passenger_holds2.'" where schedule_id="'.$schedule_id2.'" and inventory_id="1"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set holds="'.$new_vehicle_holds1.'", reserved="'.$new_vehicle_reserved1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="'.$inventory_id.'"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set holds="'.$new_vehicle_holds2.'", reserved="'.$new_vehicle_reserved2.'" where schedule_id="'.$schedule_id2.'" and inventory_id="'.$inventory_id.'"');																
									break;
							}
							
							
							break;
						
						default://oneway
							$return_port = '';
							$trip_fee = sprintf('%.2f',round(($online_oneway * $vehicle_count),2));
							$limit_passenger1 = ClassRegistry::init("Schedule_limit")->find("all",array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>'1')));
							if(!empty($limit_passenger1)){
								foreach ($limit_passenger1 as $lp1) {
									$old_passenger1 = $lp1['Schedule_limit']['reserved'];
									$old_passenger_holds1 = $lp1['Schedule_limit']['holds'];
								}
								if($old_passenger1 == ''){
									$old_passenger1 = 0;
								}
								if($old_passenger_holds1 == ''){
									$old_passenger_holds1 = 0;
								}
							} else {
								$old_passenger1 = 0;
								$old_passenger_holds1 = 0;
							}
							$new_passenger1 = $old_passenger1 + ($drivers+$adults+$children+$infants);
							if($old_passenger_holds1 =='0'){
								$new_passenger_holds1 = 0;
							} else {
								$new_passenger_holds1 = $old_passenger_holds1-1;
							}
							switch($inventory_id){
								case '1': //passenger limit update
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger1.'", holds="'.$new_passenger_holds1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="1"');
																
									break;
								case '2': //vehicles limit update

									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger1.'", holds="'.$new_passenger_holds1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="1"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set overlength_count ="'.$new_vehicle_overlength1.'", holds="'.$new_vehicle_holds1.'", reserved="'.$new_vehicle_reserved1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="'.$inventory_id.'"');					
									break;
								default: //motorcycles and bicycles vehicle update

									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set reserved ="'.$new_passenger1.'", holds="'.$new_passenger_holds1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="1"');
									ClassRegistry::init("Schedule_limit")->query('update schedule_limits set holds="'.$new_vehicle_holds1.'", reserved="'.$new_vehicle_reserved1.'" where schedule_id="'.$schedule_id1.'" and inventory_id="'.$inventory_id.'"');														
									break;
							}
							break;
					}
					$travelers = $_SESSION['Reservation_travelers'];
					foreach ($travelers as $key =>$value) {
						$first_name = $travelers['first_name'];
						$last_name = $travelers['last_name'];
						$middle_initial = $travelers['middle_initial'];
						$birthdate = $travelers['birthdate'];
						$email = $travelers['contact_email'];
						$phone =$this->trim_phone($travelers['contact_phone']); 
					}	
					switch ($trip_type) {
						case 'roundtrip':
							$status_depart = 1;
							$status_return = 1;
							break;
						
						default:
							$status_depart = 1;
							$status_return = 2;
							break;
					}

					$reservations['Ferry_reservation'][$idx] = array(
						'reservation_id'=>$reservation_id,
						'inventory_id'	=>$inventory_id,
						'schedule_id1'	=>$schedule_id1,
						'schedule_id2'	=>$schedule_id2,
						'first_name'	=>$first_name,
						'last_name'		=>$last_name,
						'middle_intial'	=>$middle_initial,
						'email'			=>$email,
						'phone'			=>$phone,
						'drivers'		=>$drivers,
						'adults'		=>$adults,
						'children'		=>$children,
						'infants'		=>$infants,
						'trip_type'		=>$trip_type,
						'depart_port'	=>$depart_port,
						'return_port'	=>$return_port,
						'depart_date'	=>date('Y-m-d H:i:s',strtotime($depart_date)),
						'return_date'	=>date('Y-m-d H:i:s',strtotime($return_date)),
						'vehicle_count'	=>$vehicle_count,
						'vehicle_overlength_count'=>$vehicle_overlength_count,
						'vehicles'		=>json_encode($vehicles),
						'status_depart'	=>$status_depart,
						'status_return'	=>$status_return,
						'confirmation'	=>$confirmation_id
					);

					//calculate subtotal, online fee, due at checkout, due at time of travel
					switch ($inventory_id) {
						case '1': //passengers
							switch ($trip_type) {
								case 'roundtrip':
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2)); 
									$subtotal = $passenger_total;
									$subtotal = sprintf('%.2f',($subtotal*2));		
									break;
								
								default:
									$subtotal = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									break;
							}
						
							$dueAtCheckout = $subtotal;
							$total = $subtotal;
							$dueAtTravel = '0.00'; 
							$reservations['Ferry_reservation'][$idx]['subtotal'] = $subtotal;
							$reservations['Ferry_reservation'][$idx]['ferry_fee'] = '0.00';
							$reservations['Ferry_reservation'][$idx]['dueAtCheckout'] = $dueAtCheckout;
							$reservations['Ferry_reservation'][$idx]['dueAtTravel'] = $dueAtTravel;
							$reservations['Ferry_reservation'][$idx]['total'] = $total;

							break;
						case '2'; //vehicles
							switch ($trip_type) {
								case 'roundtrip':
									$passenger_total = sprintf('%.2f',round((($driver_rate)+($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',round(($subtotal*2),2));		
									break;
								
								default:
									$passenger_total = sprintf('%.2f',round((($driver_rate)+($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',$subtotal);		
									break;
							}
							$totals = $_SESSION['Reservation_totals'];
							foreach ($totals as $key => $value) {
								$count_ferry = $totals['count_ferry'];
								$count_hotel = $totals['count_hotel'];
								$count_attraction = $totals['count_attraction'];
								$count_package = $totals['count_package'];
								$total_ferry = $totals['total_ferry'];
								$online_ferry_fee = $totals['online_ferry_fee']; //this could also be ferry phone fee. 
								if($count_hotel>0 || $count_attraction >0 || $count_package >0){
									$dueAtCheckout = $subtotal;
									$dueAtTravel = '0.00';
									$total = $subtotal + $online_ferry_fee;
									$reservations['Ferry_reservation'][$idx]['subtotal'] = $subtotal;
									$reservations['Ferry_reservation'][$idx]['ferry_fee'] = $online_ferry_fee;
									$reservations['Ferry_reservation'][$idx]['dueAtCheckout'] = $dueAtCheckout;
									$reservations['Ferry_reservation'][$idx]['dueAtTravel'] = $dueAtTravel;
									$reservations['Ferry_reservation'][$idx]['total'] = $subtotal+$online_ferry_fee;

								} else {
									$dueAtCheckout = $online_ferry_fee;
									$dueAtTravel = $subtotal;
									$total = $subtotal + $online_ferry_fee;
									$reservations['Ferry_reservation'][$idx]['subtotal'] = $subtotal;
									$reservations['Ferry_reservation'][$idx]['ferry_fee'] = $online_ferry_fee;
									$reservations['Ferry_reservation'][$idx]['dueAtCheckout'] = $dueAtCheckout;
									$reservations['Ferry_reservation'][$idx]['dueAtTravel'] = $dueAtTravel;
									$reservations['Ferry_reservation'][$idx]['total'] = $total;

								}
							}

							break;
						case '3'; //motorcycles
							switch ($trip_type) {
								case 'roundtrip':
									$passenger_total = sprintf('%.2f',round((($adult_rate)  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',($subtotal*2));	
			
									break;
								
								default:
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',$subtotal);		
									break;
							}							
							
							$dueAtCheckout = $trip_fee;
							$dueAtTravel = $subtotal;			
							$totals = $_SESSION['Reservation_totals'];
							foreach ($totals as $key => $value) {
								$count_ferry = $totals['count_ferry'];
								$count_hotel = $totals['count_hotel'];
								$count_attraction = $totals['count_attraction'];
								$count_package = $totals['count_package'];
								$total_ferry = $totals['total_ferry'];
								$online_ferry_fee = $totals['online_ferry_fee']; //this could also be ferry phone fee. 
								if($count_hotel>0 || $count_attraction >0 || $count_package >0){
									$dueAtCheckout = $subtotal;
									$dueAtTravel = '0.00';
									$total = $subtotal + $online_ferry_fee;
									$reservations['Ferry_reservation'][$idx]['subtotal'] = $subtotal;
									$reservations['Ferry_reservation'][$idx]['ferry_fee'] = $online_ferry_fee;
									$reservations['Ferry_reservation'][$idx]['dueAtCheckout'] = $dueAtCheckout;
									$reservations['Ferry_reservation'][$idx]['dueAtTravel'] = $dueAtTravel;
									$reservations['Ferry_reservation'][$idx]['total'] = $subtotal+$online_ferry_fee;

								} else {
									$dueAtCheckout = $online_ferry_fee;
									$dueAtTravel = $subtotal;
									$total = $subtotal + $online_ferry_fee;
									$reservations['Ferry_reservation'][$idx]['subtotal'] = $subtotal;
									$reservations['Ferry_reservation'][$idx]['ferry_fee'] = $online_ferry_fee;
									$reservations['Ferry_reservation'][$idx]['dueAtCheckout'] = $dueAtCheckout;
									$reservations['Ferry_reservation'][$idx]['dueAtTravel'] = $dueAtTravel;
									$reservations['Ferry_reservation'][$idx]['total'] = $total;

								}
							}
							break;

						default: //bicycles
							
							switch ($trip_type) {
								case 'roundtrip':
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',($subtotal*2));		
									break;
								
								default:
									$passenger_total = sprintf('%.2f',round((($adult_rate )  + ($child_rate) + ($infant_rate)),2));
									$subtotal = $passenger_total + $vehicle_total_price;
									$subtotal = sprintf('%.2f',$subtotal);		
									break;
							}								
							
							$dueAtCheckout = $trip_fee;
							$total = $subtotal + $dueAtCheckout;
							$dueAtTravel = $subtotal;		
							$reservations['Ferry_reservation'][$idx]['subtotal'] = $subtotal;
							$reservations['Ferry_reservation'][$idx]['ferry_fee'] = '0.00';							
							$reservations['Ferry_reservation'][$idx]['dueAtCheckout'] = $dueAtCheckout;
							$reservations['Ferry_reservation'][$idx]['dueAtTravel'] = $dueAtTravel;
							$reservations['Ferry_reservation'][$idx]['total'] = $total;	
			
							break;
					}			

				}
			}
		}
		//save the reservation on reservation table
	ClassRegistry::init("Ferry_reservation")->saveAll($reservations['Ferry_reservation']);
		return $reservations;
	}


	
	public function getCountries()
	{
		$countries = array(
			"NONE"=>'',
			"United States"=>"United States",
			"Canada"=>"Canada",
			"United Kingdom"=>"United Kingdom",
			"Afghanistan"=>"Afghanistan",
			"Albania"=>"Albania",
			"Algeria"=>"Algeria",
			"Algeria"=>"Algeria", 
			"American Samoa"=>"American Samoa", 
			"Andorra"=>"Andorra", 
			"Angola"=>"Angola", 
			"Anguilla"=>"Anguilla", 
			"Antarctica"=>"Antarctica", 
			"Antigua and Barbuda"=>"Antigua and Barbuda", 
			"Argentina"=>"Argentina", 
			"Armenia"=>"Armenia", 
			"Aruba"=>"Aruba", 
			"Australia"=>"Australia", 
			"Austria"=>"Austria", 
			"Azerbaijan"=>"Azerbaijan", 
			"Bahamas"=>"Bahamas", 
			"Bahrain"=>"Bahrain", 
			"Bangladesh"=>"Bangladesh", 
			"Barbados"=>"Barbados", 
			"Belarus"=>"Belarus",
			"Belgium"=>"Belgium", 
			"Belize"=>"Belize", 
			"Benin"=>"Benin", 
			"Bermuda"=>"Bermuda",
			"Bhutan"=>"Bhutan", 
			"Bolivia"=>"Bolivia", 
			"Bosnia and Herzegovina"=>"Bosnia and Herzegovina", 
			"Botswana"=>"Botswana", 
			"Bouvet Island"=>"Bouvet Island", 
			"Brazil"=>"Brazil", 
			"British Indian Ocean Territory"=>"British Indian Ocean Territory", 
			"Brunei Darussalam"=>"Brunei Darussalam", 
			"Bulgaria"=>"Bulgaria", 
			"Burkina Faso"=>"Burkina Faso", 
			"Burundi"=>"Burundi", 
			"Cambodia"=>"Cambodia", 
			"Cameroon"=>"Cameroon", 
			"Cape Verde"=>"Cape Verde", 
			"Cayman Islands"=>"Cayman Islands", 
			"Central African Republic"=>"Central African Republic", 
			"Chad"=>"Chad", 
			"Chile"=>"Chile", 
			"China"=>"China", 
			"Christmas Island"=>"Christmas Island", 
			"Cocos (Keeling) Islands"=>"Cocos (Keeling) Islands", 
			"Colombia"=>"Colombia",
			"Comoros"=>"Comoros", 
			"Congo"=>"Congo", 
			"Congo, The Democratic Republic of The"=>"Congo, The Democratic Republic of The", 
			"Cook Islands"=>"Cook Islands", 
			"Costa Rica"=>"Costa Rica", 
			"Cote D'ivoire"=>"Cote D'ivoire", 
			"Croatia"=>"Croatia", 
			"Cuba"=>"Cuba", 
			"Cyprus"=>"Cyprus", 
			"Czech Republic"=>"Czech Republic", 
			"Denmark"=>"Denmark", 
			"Djibouti"=>"Djibouti", 
			"Dominica"=>"Dominica", 
			"Dominican Republic"=>"Dominican Republic", 
			"Ecuador"=>"Ecuador", 
			"Egypt"=>"Egypt", 
			"El Salvador"=>"El Salvador", 
			"Equatorial Guinea"=>"Equatorial Guinea", 
			"Eritrea"=>"Eritrea", 
			"Estonia"=>"Estonia", 
			"Ethiopia"=>"Ethiopia", 
			"Falkland Islands (Malvinas)"=>"Falkland Islands (Malvinas)", 
			"Faroe Islands"=>"Faroe Islands", 
			"Fiji"=>"Fiji", 
			"Finland"=>"Finland", 
			"France"=>"France", 
			"French Guiana"=>"French Guiana", 
			"French Polynesia"=>"French Polynesia", 
			"French Southern Territories"=>"French Southern Territories", 
			"Gabon"=>"Gabon", 
			"Gambia"=>"Gambia", 
			"Georgia"=>"Georgia", 
			"Germany"=>"Germany", 
			"Ghana"=>"Ghana", 
			"Gibraltar"=>"Gibraltar", 
			"Greece"=>"Greece", 
			"Greenland"=>"Greenland", 
			"Grenada"=>"Grenada", 
			"Guadeloupe"=>"Guadeloupe", 
			"Guam"=>"Guam", 
			"Guatemala"=>"Guatemala", 
			"Guinea"=>"Guinea", 
			"Guinea-bissau"=>"Guinea-bissau", 
			"Guyana"=>"Guyana", 
			"Haiti"=>"Haiti", 
			"Heard Island and Mcdonald Islands"=>"Heard Island and Mcdonald Islands", 
			"Holy See (Vatican City State)"=>"Holy See (Vatican City State)", 
			"Honduras"=>"Honduras", 
			"Hong Kong"=>"Hong Kong", 
			"Hungary"=>"Hungary", 
			"Iceland"=>"Iceland", 
			"India"=>"India", 
			"Indonesia"=>"Indonesia", 
			"Iran, Islamic Republic of"=>"Iran, Islamic Republic of", 
			"Iraq"=>"Iraq", 
			"Ireland"=>"Ireland", 
			"Israel"=>"Israel",
			"Italy"=>"Italy", 
			"Jamaica"=>"Jamaica", 
			"Japan"=>"Japan", 
			"Jordan"=>"Jordan", 
			"Kazakhstan"=>"Kazakhstan", 
			"Kenya"=>"Kenya", 
			"Kiribati"=>"Kiribati", 
			"Korea, Democratic People's Republic of"=>"Korea, Democratic People's Republic of", 
			"Korea, Republic of"=>"Korea, Republic of", 
			"Kuwait"=>"Kuwait", 
			"Kyrgyzstan"=>"Kyrgyzstan", 
			"Lao People's Democratic Republic"=>"Lao People's Democratic Republic", 
			"Latvia"=>"Latvia", 
			"Lebanon"=>"Lebanon", 
			"Lesotho"=>"Lesotho", 
			"Liberia"=>"Liberia", 
			"Libyan Arab Jamahiriya"=>"Libyan Arab Jamahiriya", 
			"Liechtenstein"=>"Liechtenstein", 
			"Lithuania"=>"Lithuania", 
			"Luxembourg"=>"Luxembourg", 
			"Macao"=>"Macao", 
			"Macedonia, The Former Yugoslav Republic of"=>"Macedonia, The Former Yugoslav Republic of", 
			"Madagascar"=>"Madagascar", 
			"Malawi"=>"Malawi", 
			"Malaysia"=>"Malaysia", 
			"Maldives"=>"Maldives", 
			"Mali"=>"Mali", 
			"Malta"=>"Malta", 
			"Marshall Islands"=>"Marshall Islands", 
			"Martinique"=>"Martinique", 
			"Mauritania"=>"Mauritania", 
			"Mauritius"=>"Mauritius", 
			"Mayotte"=>"Mayotte", 
			"Mexico"=>"Mexico", 
			"Micronesia, Federated States of"=>"Micronesia, Federated States of", 
			"Moldova, Republic of"=>"Moldova, Republic of", 
			"Monaco"=>"Monaco", 
			"Mongolia"=>"Mongolia", 
			"Montserrat"=>"Montserrat",
			"Morocco"=>"Morocco", 
			"Mozambique"=>"Mozambique", 
			"Myanmar"=>"Myanmar", 
			"Namibia"=>"Namibia", 
			"Nauru"=>"Nauru", 
			"Nepal"=>"Nepal", 
			"Netherlands"=>"Netherlands", 
			"Netherlands Antilles"=>"Netherlands Antilles", 
			"New Caledonia"=>"New Caledonia", 
			"New Zealand"=>"New Zealand", 
			"Nicaragua"=>"Nicaragua", 
			"Niger"=>"Niger", 
			"Nigeria"=>"Nigeria", 
			"Niue"=>"Niue", 
			"Norfolk Island"=>"Norfolk Island", 
			"Northern Mariana Islands"=>"Northern Mariana Islands", 
			"Norway"=>"Norway", 
			"Oman"=>"Oman", 
			"Pakistan"=>"Pakistan", 
			"Palau"=>"Palau", 
			"Palestinian Territory, Occupied"=>"Palestinian Territory, Occupied", 
			"Panama"=>"Panama", 
			"Papua New Guinea"=>"Papua New Guinea", 
			"Paraguay"=>"Paraguay", 
			"Peru"=>"Peru", 
			"Philippines"=>"Philippines", 
			"Pitcairn"=>"Pitcairn", 
			"Poland"=>"Poland", 
			"Portugal"=>"Portugal", 
			"Puerto Rico"=>"Puerto Rico", 
			"Qatar"=>"Qatar", 
			"Reunion"=>"Reunion", 
			"Romania"=>"Romania", 
			"Russian Federation"=>"Russian Federation", 
			"Rwanda"=>"Rwanda", 
			"Saint Helena"=>"Saint Helena", 
			"Saint Kitts and Nevis"=>"Saint Kitts and Nevis", 
			"Saint Lucia"=>"Saint Lucia", 
			"Saint Pierre and Miquelon"=>"Saint Pierre and Miquelon", 
			"Saint Vincent and The Grenadines"=>"Saint Vincent and The Grenadines", 
			"Samoa"=>"Samoa", 
			"San Marino"=>"San Marino", 
			"Sao Tome and Principe"=>"Sao Tome and Principe", 
			"Saudi Arabia"=>"Saudi Arabia", 
			"Senegal"=>"Senegal", 
			"Serbia and Montenegro"=>"Serbia and Montenegro", 
			"Seychelles"=>"Seychelles", 
			"Sierra Leone"=>"Sierra Leone", 
			"Singapore"=>"Singapore", 
			"Slovakia"=>"Slovakia", 
			"Slovenia"=>"Slovenia", 
			"Solomon Islands"=>"Solomon Islands", 
			"Somalia"=>"Somalia", 
			"South Africa"=>"South Africa", 
			"South Georgia and The South Sandwich Islands"=>"South Georgia and The South Sandwich Islands", 
			"Spain"=>"Spain", 
			"Sri Lanka"=>"Sri Lanka", 
			"Sudan"=>"Sudan", 
			"Suriname"=>"Suriname", 
			"Svalbard and Jan Mayen"=>"Svalbard and Jan Mayen", 
			"Swaziland"=>"Swaziland", 
			"Sweden"=>"Sweden", 
			"Switzerland"=>"Switzerland", 
			"Syrian Arab Republic"=>"Syrian Arab Republic", 
			"Taiwan, Province of China"=>"Taiwan, Province of China", 
			"Tajikistan"=>"Tajikistan", 
			"Tanzania, United Republic of"=>"Tanzania, United Republic of", 
			"Thailand"=>"Thailand", 
			"Timor-leste"=>"Timor-leste", 
			"Togo"=>"Togo", 
			"Tokelau"=>"Tokelau", 
			"Tonga"=>"Tonga", 
			"Trinidad and Tobago"=>"Trinidad and Tobago", 
			"Tunisia"=>"Tunisia", 
			"Turkey"=>"Turkey", 
			"Turkmenistan"=>"Turkmenistan", 
			"Turks and Caicos Islands"=>"Turks and Caicos Islands", 
			"Tuvalu"=>"Tuvalu", 
			"Uganda"=>"Uganda", 
			"Ukraine"=>"Ukraine", 
			"United Arab Emirates"=>"United Arab Emirates", 
			"United Kingdom"=>"United Kingdom", 
			"United States Minor Outlying Islands"=>"United States Minor Outlying Islands", 
			"Uruguay"=>"Uruguay", 
			"Uzbekistan"=>"Uzbekistan", 
			"Vanuatu"=>"Vanuatu", 
			"Venezuela"=>"Venezuela", 
			"Vietnam"=>"Vietnam",
			"Virgin Islands, British"=>"Virgin Islands, British", 
			"Virgin Islands, U.S."=>"Virgin Islands, U.S.", 
			"Wallis and Futuna"=>"Wallis and Futuna", 
			"Western Sahara"=>"Western Sahara", 
			"Yemen"=>"Yemen", 
			"Zambia"=>"Zambia",
			"Zimbabwe"=>"Zimbabwe",
		);	
		return $countries;	
	}

	public function getDays()
	{
		$days = array('NONE'=>'','01'=>'1','02'=>'2','03'=>'3','04'=>'4','05'=>'5','06'=>'6','07'=>'7','08'=>'8','09'=>'9','10'=>'10',
			'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
			'21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31',
		);	
		return $days;	
	}
	public function getMonths()
	{
		$months = array(
			'NONE'=>'',
			'01'=>'January',
			'02'=>'February',
			'03'=>'March',
			'04'=>'April',
			'05'=>'May',
			'06'=>'June',
			'07'=>'July',
			'08'=>'August',
			'09'=>'September',
			'10'=>'October',
			'11'=>'November',
			'12'=>'December'
		);
		return $months;
	}
	
	public function ferrySummary($data, $group_admin){

		$summary = array();
		$idx = -1;
		foreach ($data as $f) {
			$idx++;
			$trip_type = $f['trip_type'];					
			$depart_port  =$f['depart_port'];
			$depart_time = $f['depart_time'];
			$depart_full_date = $f['depart_full_date'];
			$depart_reserved = $f['depart_reserved'];
			$depart_reservable_units = $f['depart_reservable_units'];
			$depart_total_units = $f['depart_total_units'];
			$depart_holds = $f['depart_holds'];
			$adults = $f['adults'];
			$children = $f['children'];
			$infants = $f['infants'];
			$inventory_id = $f['inventory_id'];
			$reservable = $f['reservable'];
			$total_units = $f['total_units'];
			$online_oneway = $f['online_oneway'];
			$online_roundtrip = $f['online_roundtrip'];
			$phone_oneway = $f['phone_oneway'];
			$phone_roundtrip = $f['phone_roundtrip'];
			$overlength_rate = $f['overlength_rate'];
			$schedule_id1 = $f['schedule_id1'];
			$vehicle_count = $f['vehicle_count'];
			$vehicles = $f['vehicles'];

			switch ($trip_type) {
				case 'roundtrip':
				$return_port = $f['return_port'];
				$return_time = $f['return_time'];
				$return_full_date = $f['return_full_date'];
				$return_reserved = $f['return_reserved'];
				$return_reservable_units = $f['return_reservable_units'];
				$return_total_units = $f['return_total_units'];
				$return_holds = $f['return_holds'];			
				$schedule_id2 = $f['schedule_id2'];	
				break;
				default:
				$return_port = '';
				$return_time = '';
				$return_full_date = '';
				$return_reserved ='';
				$return_reservable_units = '';
				$return_total_units = '';
				$return_holds = '';			
				$schedule_id2 = '';						
				break;
			}
			$driver_id = 18;
			$adult_id = 19;
			$child_id = 20;
			//get inventory data
			$driver_prices = ClassRegistry::init("Inventory_item")->find('all',array('conditions'=>array('id'=>$driver_id)));
			foreach ($driver_prices as $dp) {
				$driver_price = $dp['Inventory_item']['total_price'];
			}
			$adult_prices = ClassRegistry::init("Inventory_item")->find('all',array('conditions'=>array('id'=>$adult_id)));
			foreach ($adult_prices as $ap) {
				$adult_price = $ap['Inventory_item']['total_price'];
			}
			$child_prices = ClassRegistry::init("Inventory_item")->find('all',array('conditions'=>array('id'=>$child_id)));
			foreach ($child_prices as $cp) {
				$child_price = $cp['Inventory_item']['total_price'];
			}
			

			$inventories = ClassRegistry::init("Inventory")->find('all',array('conditions'=>array('id'=>$inventory_id)));
			if(count($inventories)>0){
				foreach ($inventories as $i) {
					$inventory_name = $i['Inventory']['name'];
					$online_oneway = $i['Inventory']['online_oneway'];
					$online_roundtrip = $i['Inventory']['online_roundtrip'];
					$phone_oneway = $i['Inventory']['phone_oneway'];
					$phone_roundtrip = $i['Inventory']['phone_roundtrip'];
					$overlength_feet = $i['Inventory']['overlength_feet'];
					$overlength_rate = $i['Inventory']['overlength_rate'];
					$towed_units = $i['Inventory']['towed_units'];
				}
			}
			
			//multiply fees by number of vehicles
			$online_oneway = sprintf('%.2f',round($online_oneway * $vehicle_count,2));
			$online_roundtrip = sprintf('%.2f',round($online_roundtrip * $vehicle_count,2));
			$phone_oneway = sprintf('%.2f',round($phone_oneway * $vehicle_count,2));
			$phone_roundtrip = sprintf('%.2f',round($phone_roundtrip * $vehicle_count,2));
			
			//get inventory rates
			if($inventory_id == '2'){ //if this is a vehicle inventory do a separate script
				$vrd = array();
				$vrr = array();
				$vdx = -1;

				foreach ($vehicles as $ii_id) {
					$vdx++;
					$item_id = $ii_id['item_id'];
					$length = $ii_id['overlength'];
					$overlength = $length - 18;
					
					//get overlength rate 
					$overlength_rates = ClassRegistry::init("Inventory")->find('all',array('conditions'=>array('id'=>'2')));
					foreach ($overlength_rates as $olr) {
						$overlength_rate = $olr['Inventory']['overlength_rate'];
					}

					
					if($item_id == '23'){
						$overlength = $length - 18;

						//get rates
						$vrsd = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id, 'item_id'=>$item_id)));
						$ovrd[$vdx] = ClassRegistry::init("Inventory_item")->getCurrentRateOverlength($vrsd, $item_id, $overlength, $overlength_rate);
						$vrsr = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id, 'item_id'=>$item_id)));
						$ovrr[$vdx] = ClassRegistry::init("Inventory_item")->getCurrentRateOverlength($vrsr, $item_id, $overlength, $overlength_rate);
													
						
					} else {
						$overlength = 0;
						//get rates
						$vrsd = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id, 'item_id'=>$item_id)));
						$ovrd[$vdx] = ClassRegistry::init("Inventory_item")->getCurrentRateOverlength($vrsd, $item_id, $overlength, $overlength_rate);
						$vrsr = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id, 'item_id'=>$item_id)));
						$ovrr[$vdx] = ClassRegistry::init("Inventory_item")->getCurrentRateOverlength($vrsr, $item_id, $overlength, $overlength_rate);
					}
				}
				
				$new_ovrd = array();
				$depart_array = array();
				$return_array = array();
				$vdx++;
				foreach ($ovrd as $od) {
					foreach ($od as $key => $value) {
						foreach ($od[$key] as $akey => $avalue) {
							$vdx++;
							$oneway = $od[$key][$akey]['oneway'];
							$overlength = $od[$key][$akey]['overlength'];
							$id = $od[$key][$akey]['id'];

							$name = $od[$key][$akey]['name'];
							$overlength_rate = $od[$key][$akey]['overlength_rate'];
							$surcharge = $od[$key][$akey]['surcharge'];
							$total = $od[$key][$akey]['total'];
							$new_ovrd[$name][$vdx] = array(
								'oneway'=>$oneway,
								'overlength'=>$overlength,
								'id'=>$id,
								'name'=>$name,
								'overlength_rate'=>$overlength_rate,
								'surcharge'=>$surcharge,
								'total'=>$total
							);
							
						}
					}
				}
				$new_ovrr = array();
				$vdx = -1;
				foreach ($ovrr as $or) {
					foreach ($or as $key => $value) {
						foreach ($or[$key] as $rkey => $rvalue) {
							$vdx++;
							$oneway = $or[$key][$rkey]['oneway'];
							$overlength = $or[$key][$rkey]['overlength'];
							$id = $or[$key][$rkey]['id'];
							$name = $or[$key][$rkey]['name'];
							$overlength_rate = $or[$key][$rkey]['overlength_rate'];
							$surcharge = $or[$key][$rkey]['surcharge'];
							$total = $or[$key][$rkey]['total'];
							
							$new_ovrr[$key][$vdx] = array(
								'oneway'=>$oneway,
								'overlength'=>$overlength,
								'id'=>$id,
								'name'=>$name,
								'overlength_rate'=>$overlength_rate,
								'surcharge'=>$surcharge,
								'total'=>$total
							);
						}
					}
				}
				$this->set('ovrd', $new_ovrd);
				$this->set('ovrr',$new_ovrr);

			} elseif($inventory_id =='3'){ //if this is a motorcycle
				$mrd = array();
				$mrr = array();
				$mdx = -1;
				foreach ($vehicles as $ii_id) {
					$mdx++;
					$item_id = $ii_id['item_id'];

					//get rates
					$mrsd = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id, 'item_id'=>$item_id)));
					$mrd[$mdx] = ClassRegistry::init("Inventory_item")->getCurrentRate($mrsd, $item_id);
					$mrsr = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id, 'item_id'=>$item_id)));
					$mrr[$mdx] = ClassRegistry::init("Inventory_item")->getCurrentRate($mrsr, $item_id);
				}
				
				$new_mrd = array();
				$depart_array = array();
				$return_array = array();
				$mdx++;
				foreach ($mrd as $od) {
					foreach ($od as $key => $value) {
						$mdx++;
						$oneway = $od[$key]['oneway'];
						$id = $od[$key]['id'];
						$name = $od[$key]['name'];
						$surcharge = $od[$key]['surcharge'];
						$total = $od[$key]['total'];
						$new_mrd[$name][$mdx] = array(
							'oneway'=>$oneway,
							'id'=>$id,
							'name'=>$name,
							'surcharge'=>$surcharge,
							'total'=>$total
						);
					}
				}
				$new_mrr = array();
				$mdx = -1;
				foreach ($mrr as $or) {
					foreach ($or as $key => $value) {
						$mdx++;
						$oneway = $or[$key]['oneway'];
						$id = $or[$key]['id'];
						$name = $or[$key]['name'];
						$surcharge = $or[$key]['surcharge'];
						$total = $or[$key]['total'];
						
						$new_mrr[$key][$mdx] = array(
							'oneway'=>$oneway,
							'id'=>$id,
							'name'=>$name,
							'surcharge'=>$surcharge,
							'total'=>$total
						);
					}
				}
				$this->set('mrd', $new_mrd);
				$this->set('mrr',$new_mrr);						
			} elseif($inventory_id == '4') { //everything bicycle
				$item_id = 28;
				$vehicle_rate_search_depart =ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id, 'item_id'=>$item_id)));
				$vehicle_rate_depart = ClassRegistry::init("Inventory_item")->getCurrentRate($vehicle_rate_search_depart, $item_id);
				$vehicle_rate_search_return = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id, 'item_id'=>$item_id)));
				$vehicle_rate_return = ClassRegistry::init("Inventory_item")->getCurrentRate($vehicle_rate_search_return, $item_id);
				
				
				$this->set('vehicle_rate_depart',$vehicle_rate_depart);
				$this->set('vehicle_rate_return',$vehicle_rate_return);	
				
			
								
			} else {
				$item_id = 19;
			}

			
			
			//adult & child depart rates
			$driver_rate_search_depart = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id,'item_id'=>$driver_id)));
			$adult_rate_search_depart =ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id,'item_id'=>$adult_id)));
			$child_rate_search_depart = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id,'item_id'=>$child_id)));
			
			$driver_rate_depart = ClassRegistry::init("Inventory_item")->getCurrentRate($driver_rate_search_depart, $driver_id);
			$adult_rate_depart= ClassRegistry::init("Inventory_item")->getCurrentRate($adult_rate_search_depart, $adult_id);
			$child_rate_depart = ClassRegistry::init("Inventory_item")->getCurrentRate($child_rate_search_depart, $child_id);
			
			//adult & child return rates
			$driver_rate_search_return = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id,'item_id'=>$driver_id)));
			$adult_rate_search_return = ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id,'item_id'=>$adult_id)));
			$child_rate_search_return =ClassRegistry::init("Schedule_rate")->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id,'item_id'=>$child_id)));				
			
			$driver_rate_return = ClassRegistry::init("Inventory_item")->getCurrentRate($driver_rate_search_return, $driver_id);
			$adult_rate_return= ClassRegistry::init("Inventory_item")->getCurrentRate($adult_rate_search_return, $adult_id);
			$child_rate_return = ClassRegistry::init("Inventory_item")->getCurrentRate($child_rate_search_return, $child_id);					
			if(!empty($vehicles)){
				$inventory_item_name = ClassRegistry::init("Inventory_item")->find('all',array('conditions'=>array('id'=>$item_id)));
				//short variables
				foreach ($inventory_item_name as $iin) {
					$ii_name = $iin['Inventory_item']['name'];
				}
			}
			switch ($trip_type) {
				case 'roundtrip':
					foreach ($adult_rate_depart as $ard) {
						$ar_depart = $ard['total'];
					}
					foreach ($child_rate_depart as $crd) {
						$cr_depart = $crd['total'];
					}
					foreach ($adult_rate_return as $arr) {
						$ar_return = $arr['total'];
					}
					foreach ($child_rate_return as $crr) {
						$cr_return = $crr['total'];
					}
					foreach ($driver_rate_depart as $drd) {
						$dr_depart = $drd['total'];
					}
					foreach ($driver_rate_return as $drr) {
						$dr_return = $drr['total'];
					}
					if(!empty($vehicle_rate_depart)){		
						foreach ($vehicle_rate_depart as $vrd) {
							$vr_depart = $vrd['total'];
						}
					} else {
						$vr_depart = '0.00';
					}
					if(!empty($vehicle_rate_return)){
						foreach ($vehicle_rate_return as $vrr) {
							$vr_return = $vrr['total'];
						}
					} else {
						$vr_return = '0.00';
					}
				
					$adult_rate = sprintf('%.2f',round(($ar_depart+$ar_return)*$adults,2));
					$child_rate = sprintf('%.2f',round(($cr_depart+$cr_return)*$children,2));
					$vehicle_rate = sprintf('%.2f',round(($vr_depart+$vr_return)*$vehicle_count,2));

					switch ($inventory_id) {
						case '1': //passengers
							$subtotal = sprintf('%.2f',$adult_rate+$child_rate);
							$total = $subtotal;
							break;
						case '2': //vehicles
							
							$addtl_adult_rate = sprintf('%.2f',round(($ar_depart+$ar_return)*$adults,2));
							$addtl_child_rate = sprintf('%.2f',round(($cr_depart+$cr_return)*$children,2));
							$addtl_driver_rate= sprintf('%.2f',round(($vehicle_count *($dr_depart+$dr_return)),2));
							
							$vehicle_rate = 0;
							if(!empty($ovrd)){
										
								foreach ($ovrd as $ovd) {
									foreach ($ovd as $key => $value) {
										foreach ($ovd[$key] as $akey => $avalue) {
											$vr_depart_id = $ovd[$key][$akey]['id'];
											$vr_depart = $ovd[$key][$akey]['total'];
											$vehicle_rate = $vehicle_rate + $vr_depart;											
										}

									}
								}
							} 
							if(!empty($ovrr)){
								foreach ($ovrr as $ovr) {
									foreach ($ovr as $key => $value) {
										foreach ($ovr[$key] as $akey => $avalue) {
											$vr_return_id = $ovr[$key][$akey]['id'];
											$vr_return = $ovr[$key][$akey]['total'];
											$vehicle_rate = $vehicle_rate + $vr_return;											
										}
								
									}
								}
							}
				
							$subtotal = sprintf('%.2f',$vehicle_rate+$addtl_driver_rate+$addtl_adult_rate+$addtl_child_rate);
							switch($group_admin){
								case 'Yes':
									$total = sprintf('%.2f',$subtotal+$phone_roundtrip);	
								break;
									
								default:
									$total = sprintf('%.2f',$subtotal+$online_roundtrip);	
								break;
									
							}

							break;
							
						case '3': //motorcycles
							$vehicle_rate = 0;
							if(!empty($mrd)){		
								foreach ($mrd as $md) {
									foreach ($md as $key => $value) {
										$vr_depart_id = $md[$key]['id'];
										$vr_depart = $md[$key]['total'];
										$vehicle_rate = $vehicle_rate + $vr_depart;
									}
		
								}
							} 
							if(!empty($mrr)){
								foreach ($mrr as $mr) {
									foreach ($mr as $key => $value) {
										$vr_return_id = $mr[$key]['id'];
										$vr_return = $mr[$key]['total'];
										$vehicle_rate = $vehicle_rate + $vr_return;		
								
									}
		
								}
							}			
							$subtotal = sprintf('%.2f',$vehicle_rate+$adult_rate+$child_rate);
							switch($group_admin){
								case 'Yes':
									$total = sprintf('%.2f',$subtotal + $phone_roundtrip);
								break;
									
								default:
									$total = sprintf('%.2f',$subtotal + $online_roundtrip);
								break;
							}
							
					
							break;
							
						case '4': //bicycles
							$subtotal = sprintf('%.2f',$vehicle_rate+$adult_rate+$child_rate);
							switch($group_admin){
								case 'Yes':
									$total = sprintf('%.2f',$subtotal + $phone_roundtrip);
								break;
									
								default:
									$total = sprintf('%.2f',$subtotal + $online_roundtrip);
								break;
							}
							
							break;
					}
		
					break;
				
				
				default: //oneway trip
					foreach ($adult_rate_depart as $ard) {
						$ar_depart = $ard['total'];
					}
					foreach ($child_rate_depart as $crd) {
						$cr_depart = $crd['total'];
					}
		
					foreach ($driver_rate_depart as $drd) {
						$dr_depart = $drd['total'];
					}
		
					if(!empty($vehicle_rate_depart)){		
						foreach ($vehicle_rate_depart as $vrd) {
							$vr_depart = $vrd['total'];
						}
					} else {
						$vr_depart = '0.00';
					}
				
					$adult_rate = sprintf('%.2f',round(($ar_depart)*$adults,2));
					$child_rate = sprintf('%.2f',round(($cr_depart)*$children,2));
					$vehicle_rate = sprintf('%.2f',round(($vr_depart)*$vehicle_count,2));
					
					
					
					
					switch ($inventory_id) {
						case '1': //passengers
							$subtotal = sprintf('%.2f',$adult_rate+$child_rate);
							$total = $subtotal;
							break;
						case '2': //vehicles
		
							$addtl_driver_rate= sprintf('%.2f',round(($vehicle_count *($dr_depart)),2));
							$addtl_adult_rate = sprintf('%.2f',round(($ar_depart)*$adults,2));
							$addtl_child_rate = sprintf('%.2f',round(($cr_depart)*$children,2));
		
							$vehicle_rate = 0;
							
							if(!empty($ovrd)){		
								foreach ($ovrd as $ovd) {
									foreach ($ovd as $ov) {
										foreach ($ov as $o) {
											$vr_depart_id = $o['id'];
										
											$vr_depart = $o['total'];
											$vehicle_rate = $vehicle_rate + $vr_depart;											
										}
									

									}
		
								}
							} 
		
		
							$subtotal = sprintf('%.2f',$vehicle_rate+$addtl_adult_rate+$addtl_child_rate+$addtl_driver_rate);
							switch($group_admin){
								case 'Yes':
									$total = sprintf('%.2f',$subtotal+$phone_oneway);	
								break;
									
								default:
									$total = sprintf('%.2f',$subtotal+$online_oneway);	
								break;
									
							}			
						
							break;
							
						case '3': //motorcycles
							$vehicle_rate = 0;
							if(!empty($mrd)){		
								foreach ($mrd as $md) {
									foreach ($md as $key => $value) {
										$vr_depart_id = $md[$key]['id'];
										$vr_depart = $md[$key]['total'];
										$vehicle_rate = $vehicle_rate + $vr_depart;
									}
		
								}
							} 
							if(!empty($mrr)){
								foreach ($mrr as $mr) {
									foreach ($mr as $key => $value) {
										$vr_return_id = $mr[$key]['id'];
										$vr_return = $mr[$key]['total'];
										$vehicle_rate = $vehicle_rate + $vr_return;		
								
									}
		
								}
							}			
							$subtotal = sprintf('%.2f',$vr_depart+$adult_rate+$child_rate);
							switch($group_admin){
								case 'Yes':
									$total = sprintf('%.2f',$subtotal+$phone_oneway);	
								break;
									
								default:
									$total = sprintf('%.2f',$subtotal+$online_oneway);	
								break;
									
							}
	
							break;
							
						case '4': //bicycles
							$subtotal = sprintf('%.2f',$vehicle_rate+$adult_rate+$child_rate);
							switch($group_admin){
								case 'Yes':
									$total = sprintf('%.2f',$subtotal+$phone_oneway);	
								break;
									
								default:
									$total = sprintf('%.2f',$subtotal+$online_oneway);	
								break;
									
							}
		
							break;
					}
			
					break;
			}

			switch($group_admin){
				case 'Yes':
					$depart_roundtrip = sprintf('%.2f',round($phone_roundtrip * $vehicle_count,2));
				break;
					
				default:
					$depart_roundtrip = sprintf('%.2f',round($online_roundtrip * $vehicle_count,2));
				break;
			}

			$summary[$idx] = array(
				'inventory_id'=>$inventory_id,
				'trip_type'=>$trip_type,				
				'depart_port'=>$depart_port,
				'depart_time'=>$depart_time,
				'depart_full_date'=>$depart_full_date,
				'depart_reserved'=>$depart_reserved,
				'depart_reservable_units'=>$depart_reservable_units,
				'depart_total_units'=>$depart_total_units,
				'depart_holds'=>$depart_holds,
				'return_port'=>$return_port,
				'return_time'=>$return_time,
				'return_full_date'=>$return_full_date,
				'return_reserved'=>$return_reserved,
				'return_reservable_units'=>$return_reservable_units,
				'return_total_units'=>$return_total_units,
				'return_holds'=>$return_holds,			
				'schedule_id2'=>$schedule_id2,	
				'adults'=>$adults,
				'adult_price'=>$adult_price,
				'driver_price'=>$driver_price,
				'children'=>$children,
				'child_price'=>$child_price,
				'infants'=>$infants,
				'infant_price'=>'0.00',
				'reservable'=>$reservable,
				'total_units'=>$total_units,
				'online_oneway'=>$online_oneway,
				'online_roundtrip'=>$online_roundtrip,
				'phone_oneway'=>$phone_oneway,
				'phone_roundtrip'=>$phone_roundtrip,
				'depart_roundtrip'=>$depart_roundtrip,
				'overlength_rate'=>$overlength_rate,
				'schedule_id1'=>$schedule_id1,
				'vehicle_count'=>$vehicle_count,
				'vehicles'=>$vehicles,
				'subtotal'=>$subtotal,
				'total'=>$total,
				
			);			
			
		}
		return $summary;					
	}
	public function hotelPackageSummary($data)
	{
		$summary = array();
		$idx = -1;

		foreach ($data as $h) {
			$idx++;
			$hotel_id = $h['hotel_id'];
			$room_id = $h['room_id'];
			$start = $h['start'];
			$end = $h['end'];
			$adults = $h['adults'];
			$children =$h['children'];
			$hotel_name = $h['hotel_name'];
			$country = $h['country'];
			switch($country){
				case '1':
					$country = 'USA';
				break;
				default:
					$country = 'CAN';
				break;
			}
			$room_name = $h['room_name'];
			$room_desc = $h['room_desc'];
			$room_count = $h['room_count'];
			$room_primary_image = $h['room_primary_image'];
			$room_sorted_images = $h['room_sorted_images'];
			$room_base = $h['room_base'];
			$occupancy_base = $h['occupancy_base'];
			$occupancy_max = $h['occupancy_max'];
			$plus_net = $h['plus_net'];
			$plus_fee = $h['plus_fee'];
			$taxes = $h['taxes'];
			
			$total_tax = 0;
			if(count($taxes) >0){
				foreach ($taxes as $key => $value) {
					$tax_code = $key;
					$tax_find = ClassRegistry::init("Tax")->find('all',array('conditions'=>array('id'=>$tax_code)));
					if(count($tax_find)>0){
						foreach ($tax_find as $tax) {
							$total_tax = $total_tax + $tax['Tax']['rate'];
						}
					}
				}
			}
			$total_tax = ($total_tax/ 100);
			$total_rooms= $h['total_rooms'];

			
			$total_occupants = $adults + $children;
			$min_rooms = ceil($total_occupants / $occupancy_base);
			$max_rooms = ceil($total_occupants / $occupancy_max);
			$total_nights = ($end - $start) / 86400;
			$extra_fee_multiplier = ($adults) - ($room_count * $occupancy_base);
			$total_extra_fee = sprintf('%.2f',round(($extra_fee_multiplier * $plus_fee)*$total_nights,2));
			if($total_extra_fee < 0){
				$total_extra_fee = '0.00';
			}			
			
			//get final room sum
			
			
			$total_net_rooms = $h['gross'];
			$total_gross_rooms = $h['aftertax'];

			$total_net_rooms = sprintf('%.2f',($total_net_rooms*$room_count) * $total_nights);
			$total_gross_rooms = sprintf('%.2f',($total_gross_rooms*$room_count) * $total_nights);
			$total_gross = sprintf('%.2f',round(($total_gross_rooms + $total_extra_fee),2));

			$sum_tax = sprintf('%.2f',$total_gross - $total_net_rooms);

			
			$summary[$idx] = array(
				'hotel_id'=>$hotel_id,
				'room_count'=>$room_count,
				'room_id'=>$room_id,
				'start'=>$start,
				'end'=>$end,
				'adults'=>$adults,
				'children'=>$children,
				'hotel_name'=>$hotel_name,
				'country'=>$country,	
				'room_name'=>$room_name,
			 	'room_desc'=>$room_desc,
			 	'room_primary_image'=>$room_primary_image,
				'room_primary_image'=>$room_primary_image,
				'room_sorted_images'=>$room_sorted_images,
				'occupancy_base'=>$occupancy_base,
				'occupancy_max'=>$occupancy_max,
				'plus_net'=>$plus_net,
				'plus_fee'=>$plus_fee,
				'taxes'=>$taxes,
				'total_tax'=>$total_tax,
				'room_count'=>$room_count,
				'total_rooms'=>$total_rooms,	
				'total_occupants'=>$total_occupants,
				'min_rooms'=>$min_rooms,
				'max_rooms'=>$max_rooms,
				'room_base'=>$room_base,
				'extra_fee_multiplier'=>$extra_fee_multiplier,
				'total_extra_fee'=>$total_extra_fee,
				'total_nights'=>$total_nights,
				'total_net'=>$total_net_rooms,
				'total_gross'=>$total_gross,
				'sum_tax'=>$sum_tax,

			);
			
		}

		return $summary;		
	}
	public function hotelSummary($data)
	{
		$summary = array();
		$idx = -1;
		$total_gross_rooms = 0;
		foreach ($data as $h) {
			$idx++;
			$hotel_id = $h['hotel_id'];
			$room_id = $h['room_id'];
			$start = $h['start'];
			$end = $h['end'];
			$adults = $h['adults'];
			$children =$h['children'];
			$hotel_name = $h['hotel_name'];
			$country = $h['country'];
			switch($country){
				case '1':
					$country = 'USA';
				break;
				default:
					$country = 'CAN';
				break;
			}
			$room_name = $h['room_name'];
			$room_desc = $h['room_desc'];
			$room_count = $h['room_count'];
			$room_primary_image = $h['room_primary_image'];
			$room_sorted_images = $h['room_sorted_images'];
			$occupancy_base = $h['occupancy_base'];
			$occupancy_max = $h['occupancy_max'];
			$plus_net = $h['plus_net'];
			$plus_fee = $h['plus_fee'];
			$taxes = $h['taxes'];
			$total_tax = 0;
			if(count($taxes) >0){
				foreach ($taxes as $key => $value) {
					$tax_code = $key;
					$tax_find = ClassRegistry::init("Tax")->find('all',array('conditions'=>array('id'=>$tax_code)));
					if(count($tax_find)>0){
						foreach ($tax_find as $tax) {
							$total_tax = $total_tax + $tax['Tax']['rate'];
						}
					}
				}
			}
			$total_tax = ($total_tax/ 100);
			$total_rooms= $h['total_rooms'];	
			$total_occupants = $adults + $children;
			$min_rooms = ceil($total_occupants / $occupancy_base);
			$max_rooms = ceil($total_occupants / $occupancy_max);
			$total_nights = ceil(($end - $start) / 86400);
			$extra_fee_multiplier = $adults - ($room_count * $occupancy_base);
			$total_extra_fee = sprintf('%.2f',round(($extra_fee_multiplier * $plus_fee)*$total_nights,2));
			if($total_extra_fee < 0){
				$total_extra_fee = '0.00';
			}			
			
			//get final room sum
			
			$total_net_rooms = $h['room_count'];
		
			$data = ClassRegistry::init("Hotel_room")->find('all',array('conditions'=>array('id'=>$room_id)));
			foreach ($data as $r) {
				$inventory = json_decode($r['Hotel_room']['inventory'],true);

				foreach ($inventory as $a) {
					$start_date = strtotime($a['start_date']);
					$end_date =strtotime($a['end_date']);
					$net = $a['net'];
					$gross = $a['gross'];
					$markup = $a['markup'];
					$total_rooms = $a['total'];

					for ($a=0; $a < $total_nights; $a++) { 
						$check_days = $start+($a*(86400));
						for ($i=$start_date; $i <= $end_date; $i+=86400 ) {
							
							if(date('Y-m-d',$check_days) == date('Y-m-d',$i)){
								$total_net_rooms =  $net;
								$total_gross_rooms =$gross;
							}
						}						
					}
				}									
			}
			$total_net_rooms = sprintf('%.2f',round((($total_net_rooms*$room_count)*$total_nights),2));
			$total_gross_rooms = sprintf('%.2f',round((($total_gross_rooms*$room_count)*$total_nights),2));
			$total_gross = sprintf('%.2f',round(($total_gross_rooms + $total_extra_fee)*(1+$total_tax),2));
			$total_net = $total_gross_rooms;
			$sum_tax = sprintf('%.2f',$total_gross - $total_gross_rooms);

			
			$summary[$idx] = array(
				'hotel_id'=>$hotel_id,
				'room_count'=>$room_count,
				'room_id'=>$room_id,
				'start'=>$start,
				'end'=>$end,
				'adults'=>$adults,
				'children'=>$children,
				'hotel_name'=>$hotel_name,
				'country'=>$country,	
				'room_name'=>$room_name,
			 	'room_desc'=>$room_desc,
			 	'room_primary_image'=>$room_primary_image,
				'room_primary_image'=>$room_primary_image,
				'room_sorted_images'=>$room_sorted_images,
				'occupancy_base'=>$occupancy_base,
				'occupancy_max'=>$occupancy_max,
				'plus_net'=>$plus_net,
				'plus_fee'=>$plus_fee,
				'taxes'=>$taxes,
				'total_tax'=>$total_tax,
				'room_count'=>$room_count,
				'total_rooms'=>$total_rooms,	
				'total_occupants'=>$total_occupants,
				'min_rooms'=>$min_rooms,
				'max_rooms'=>$max_rooms,
				'extra_fee_multiplier'=>$extra_fee_multiplier,
				'total_extra_fee'=>$total_extra_fee,
				'total_nights'=>$total_nights,
				'total_net'=>$total_net,
				'total_gross'=>$total_gross,
				'sum_tax'=>$sum_tax,

			);
			
		}

		return $summary;
	}
	public function attractionSummary($data)
	{
		$summary = array();
		$idx = -1;
		if(count($data)>0){
		foreach ($data as $a) {
			$idx++;
			$attraction_id = $a['attraction_id'];
			$tour_id =$a['tour_id'];
			//get special instructions
			$get_instructions = ClassRegistry::init('Attraction_ticket')->read('instructions',$tour_id);
			$get_email = ClassRegistry::init('Attraction')->read('reservation_email',$attraction_id);

			if(!empty($get_instructions)>0){
				foreach ($get_instructions as $gikey =>$givalue) {

					$instructions = $givalue['instructions'];
				}
			} else {
				$instructions = '';
			}
			
			//debug($get_email);
			
			if(isset($get_email['Attraction']['reservation_email'])) {

				$email = $get_email['Attraction']['reservation_email'];
				
			} else {
				$email = '';
			}

			//debug($email);
			if(strtotime($a['start']) == false){
				$start = $a['start'];
			} else {
				$start = strtotime($a['start']);
			}
			//$start = $a['start'];
			$time_tour = $a['time_tour'];
			$time = $a['time'];
			$attraction_name = $a['attraction_name'];
			$country = $a['country'];
			$tour_name = $a['tour_name'];
			$tour_desc = $a['tour_desc'];
			$tour_primary_image = $a['tour_primary_image'];
			$tour_sorted_images = $a['tour_sorted_images'];
			$taxes = $a['taxes'];

			$total_tax = 0;
			if(count($taxes) >0){
				foreach ($taxes as $key => $value) {
					$tax_code = $key;
					$tax_find = ClassRegistry::init("Tax")->find('all',array('conditions'=>array('id'=>$tax_code)));
					if(count($tax_find)>0){
						foreach ($tax_find as $tax) {
							$total_tax = $total_tax + $tax['Tax']['rate'];
						}
					}
				}
			}
			$total_gross = 0;
			$purchase_info = $a['purchase_info'];
			foreach ($purchase_info as $pi) {
				$amount = $pi['amount'];
				$gross =$pi['gross'];
				$total_gross = $total_gross + ($gross * $amount);
			}
			$total_paid = sprintf('%.2f',round($total_gross * (1+($total_tax / 100)),2));
			
			$summary[$idx] = array(
				'attraction_id'=>$attraction_id,
				'tour_id'=>$tour_id,
				'start'=> $start,
				'time_tour'=>$time_tour,
				'time'=>$time,
				'attraction_name'=>$attraction_name,
				'country'=>$country,
				'tour_name'=>$tour_name,
				'tour_desc'=>$tour_desc,
				'tour_primary_image'=>$tour_primary_image,
				'tour_sorted_images'=>$tour_sorted_images,
				'taxes'=>$taxes,
				'total_tax'=>$total_tax,
				'total_gross'=>$total_gross,
				'total_paid'=>$total_paid,
				'instructions'=>$instructions,
				'email'=>$email,
				'purchase_info'=>$purchase_info
			);
			
		}
		}
		return $summary;
	}	

	public function packageSummary($data, $group_admin)
	{
		
		foreach ($data as $key => $value) {


			//ferry
			if(isset($data[$key]['ferries'])){

				$data[$key]['ferries'] = $this->ferrySummary($data[$key]['ferries'], $group_admin);	
			} else {
				$data[$key]['ferries'] = array();
			}
			//hotel
			if(isset($data[$key]['hotels'])){
				$data[$key]['hotels'] = $this->hotelPackageSummary($data[$key]['hotels']);
			} else {
				$data[$key]['hotels'] = array();
			}
			//attraction
			if(isset($data[$key]['attractions'])){
				$data[$key]['attractions'] = $this->attractionSummary($data[$key]['attractions']);
			} else {
				$data[$key]['attractions'] = array();
			}
		}

		return $data;		
	}
	
	//sets the next reservation and returns a reservation_id
	public function setReservation($totals, $travelers,$payments, $reference, $group_string)
	{
		

		//reservation add confirmation code
		$reservation = array();
		$reservation['Reservation']['created_by'] = $group_string;
		//create the travelers data
		foreach ($travelers as $key => $value) {
			$reservation['Reservation']['first_name'] = trim($travelers['first_name']);
			$reservation['Reservation']['middle_initial'] = trim($travelers['middle_initial']);
			$reservation['Reservation']['last_name'] = trim($travelers['last_name']);
			$reservation['Reservation']['birthdate'] = trim($travelers['birthdate']);
			$reservation['Reservation']['citizenship'] = trim($travelers['citizenship']);
			$reservation['Reservation']['doctype'] = trim($travelers['doctype']);
			$reservation['Reservation']['docnumber'] = trim($travelers['docnumber']);
			$reservation['Reservation']['address'] = trim($travelers['contact_address']);
			$reservation['Reservation']['city'] = trim($travelers['contact_city']);
			$reservation['Reservation']['state'] = trim($travelers['contact_state']);
			$reservation['Reservation']['zip'] = trim($travelers['contact_zip']);
			$reservation['Reservation']['email'] = trim($travelers['contact_email']);

			$reservation['Reservation']['phone'] = $this->trim_phone($travelers['contact_phone']); 
		}		
		foreach ($payments as $p) {

			$reservation['Reservation']['card_number'] = substr($p['vdata'],-4);
			$reservation['Reservation']['card_full_name'] = $p['card_full_name'];
			$reservation['Reservation']['cvv'] = $p['card_cvv'];
			$reservation['Reservation']['expires_month'] = $p['card_expires_month'];
			$reservation['Reservation']['expires_year'] = $p['card_expires_year'];
			$reservation['Reservation']['billing_address'] = $p['contact_address'];
			$reservation['Reservation']['billing_city'] = $p['contact_city'];
			$reservation['Reservation']['billing_state'] = $p['contact_state'];
			$reservation['Reservation']['billing_zip'] = $p['contact_zip'];		
			$reservation['Reservation']['reference'] = $reference;		

		}

		foreach ($totals as $key => $value) {
			$count_ferries = $totals['count_ferry'];
			$count_hotels = $totals['count_hotel'];
			$count_attractions = $totals['count_attraction'];
			$count_packages = $totals['count_package'];
			if($count_packages >0 && $count_ferries == 0 && $count_hotels == 0 && $count_attractions == 0){
				$reservation['Reservation']['package_total'] = $totals['total_package'];	
				$reservation['Reservation']['ferry_total'] = 0;
				$reservation['Reservation']['hotel_total'] =0;
				$reservation['Reservation']['attraction_total'] = 0;		
				$reservation['Reservation']['dueAtCheckout'] = $totals['total_package'];
				$reservation['Reservation']['dueAtTravel'] = 0;
				$reservation['Reservation']['total_tax'] = 0;
				$reservation['Reservation']['subtotal'] = $totals['total_package'];
				$reservation['Reservation']['total'] = $totals['total_package'];			
			} else{
				$reservation['Reservation']['package_total'] = $totals['total_package'];	
				$reservation['Reservation']['ferry_total'] = $totals['total_ferry'];
				$reservation['Reservation']['hotel_total'] = $totals['total_hotel'];
				$reservation['Reservation']['attraction_total'] = $totals['total_attraction'];		
				$reservation['Reservation']['dueAtCheckout'] = $totals['total_due'];
				$reservation['Reservation']['dueAtTravel'] = $totals['total_arrival'];
				$reservation['Reservation']['total_tax'] = $totals['total_tax'];
				$reservation['Reservation']['subtotal'] = sprintf('%.2f',round($totals['total_ferry'] + $totals['total_hotel'] + $totals['total_attraction'] + $totals['total_package'],2));
				$reservation['Reservation']['total'] = sprintf('%.2f',round($totals['total_due'] + $totals['total_arrival'],2));			
			}			

		}
		//create the confirmation code
		$begin = $this->query("SELECT * FROM reservations ORDER BY id DESC LIMIT 0,1");
		if(count($begin)>0){
			foreach ($begin as $rb) {
				$last_id = sprintf('%06d',$rb['reservations']['id']+1); //add leading zeros to code
				
			}
		} else {
			$last_id = '000001'; //this is the starting number
		}
		$valid_chars = 'ABCDEFGHIJKLMONPQRSTUVWXYZ'; // valid characters for code creating at the end
		$length = '2'; //2 for back code
		$confirmation_end = $this->get_random_string($valid_chars, $length); 
		
		$confirmation = $last_id.$confirmation_end; //final confirmation code
		//make sure it doesnt match any other confirmation codes
		$count_doubles = $this->find('all',array('conditions'=>array('confirmation'=>$confirmation))); //checks for any duplicates
		if(count($count_doubles) > 0){ //there are duplicates
			$reconfirm = $last_id.$this->get_random_string($valid_chars, $length); //recreate the ending 
			if($reconfirm != $confirmation){ //if they dont match then were good make the new code
				$confirmation = $last_id.$reconfirm;
			} else { //otherwise create a whole new code using numbers (most likely wont happen but just in case)
				$valid_chars = '1A2B3C4D5E6F7G8H9IA1B2C3D4E5F6G7H8I9JAKBLCMDNEPFQGRHSITJUK2V1W2X3Y4Z5';
				$length = '2'; 
				$confirmation = $last_id.$this->get_random_string($valid_chars, $length);				
			}
		}
		$reservation['Reservation']['payment_type'] = 'Credit';
		$reservation['Reservation']['confirmation'] = $confirmation;
		$reservation['Reservation']['status'] = '1';
		
		$this->save($reservation);
		$reservation_id = $this->getLastInsertID();

		return $reservation_id;
	}

	public function reserveHotel($data, $travelers, $reservation_id)
	{
		$confirmations = $this->find('all',array('conditions'=>array('id'=>$reservation_id)));
		foreach ($confirmations as $c) {
			$confirmation_id = $c['Reservation']['confirmation'];
		}		
		$reservation = array();
		$idx = -1;
		foreach ($travelers as $key =>$value) {
			$first_name = $travelers['first_name'];
			$last_name = $travelers['last_name'];
			$middle_initial = $travelers['middle_initial'];
			$birthdate = $travelers['birthdate'];
			$email = $travelers['contact_email'];
			$phone = $this->trim_phone($travelers['contact_phone']); 
			
		}		
		

		foreach ($data as $h) {
			
			$room_count = $h['room_count'];
			$adults = $h['adults'];
			$children = $h['children'];
			
			
			
			for ($i=0; $i < $room_count; $i++) {

				 
				$idx++; //index the data
				
				//splitting occupancy based on room count
				//first get the floored value of the total / rooms
				if($i != ($room_count-1)){
					$adults_in_room = floor($adults/$room_count);
					$children_in_room = floor($children/$room_count);
				} else { //if there is only one room or if this is the last room in the array
					$adults_in_room = floor($adults/$room_count);
					$children_in_room = floor($children/$room_count);
					$remainder_adults = ceil($adults%$room_count);
					$remainder_children = ceil($children%$room_count);
					//get the floored value plus the remainder to get the extra persons (if any). otherwise it will return the base value.
					$adults_in_room = ($adults_in_room + $remainder_adults);
					$children_in_room = ($children_in_room + $remainder_children);
					
				}
				
				$reservation['Hotel_reservation'][$idx]['adults'] = $adults_in_room;
				$reservation['Hotel_reservation'][$idx]['children'] = $children_in_room;						
				$reservation['Hotel_reservation'][$idx]['reservation_id'] = $reservation_id;
				$reservation['Hotel_reservation'][$idx]['hotel_id'] = $h['hotel_id'];
				$reservation['Hotel_reservation'][$idx]['room_id'] = $h['room_id'];
				$reservation['Hotel_reservation'][$idx]['check_in'] = date('Y-m-d H:i:s',$h['start']);
				$reservation['Hotel_reservation'][$idx]['check_out'] = date('Y-m-d H:i:s',$h['end']);
				$reservation['Hotel_reservation'][$idx]['rooms'] = 1;
				$reservation['Hotel_reservation'][$idx]['first_name'] = $first_name;
				$reservation['Hotel_reservation'][$idx]['last_name'] = $last_name;
				$reservation['Hotel_reservation'][$idx]['middle_initial'] = $middle_initial;
				$reservation['Hotel_reservation'][$idx]['birthdate'] = $birthdate;
				$reservation['Hotel_reservation'][$idx]['email'] = $email;
				$reservation['Hotel_reservation'][$idx]['phone'] = $phone;
				$reservation['Hotel_reservation'][$idx]['reserved_date'] = date('Y-m-d H:i:s');
				$reservation['Hotel_reservation'][$idx]['confirmation'] = $confirmation_id;
				$reservation['Hotel_reservation'][$idx]['status'] = '1';	
				$reservation['Hotel_reservation'][$idx]['paid'] = sprintf('%.2f',round($h['total_gross']/$room_count,2));	
				$reservation['Hotel_reservation'][$idx]['package_id'] = '0';		

					
			}		
		}

		
		ClassRegistry::init("Hotel_reservation")->saveAll($reservation['Hotel_reservation']);
		
		
	}
	public function reservePackageHotel($data)
	{
		$idx = -1;
		foreach ($data as $k => $h) {

			$room_count = $h[0]['rooms'];
			$adults = $h[0]['adults'];
			$children = $h[0]['children'];
			if(!empty($h[0]['package_id'])){
				$package_id = $h[0]['package_id'];	
			} else{
				$package_id = '1';
			}
			$reservation = array();
			
			for ($i=0; $i < $room_count; $i++) {
				 
				$idx++; //index the data
				
				//splitting occupancy based on room count
				//first get the floored value of the total / rooms
				if($i != ($room_count-1)){
					$adults_in_room = floor($adults/$room_count);
					$children_in_room = floor($children/$room_count);
					
				} else { //if there is only one room or if this is the last room in the array
					$adults_in_room = floor($adults/$room_count);
					$children_in_room = floor($children/$room_count);
					$remainder_adults = ceil($adults%$room_count);
					$remainder_children = ceil($children%$room_count);
					//get the floored value plus the remainder to get the extra persons (if any). otherwise it will return the base value.
					$adults_in_room = ($adults_in_room + $remainder_adults);
					$children_in_room = ($children_in_room + $remainder_children);
				
					
				}
				
				$reservation['Hotel_reservation'][$idx]['adults'] = $adults_in_room;
				$reservation['Hotel_reservation'][$idx]['children'] = $children_in_room;						
				$reservation['Hotel_reservation'][$idx]['reservation_id'] = $h[0]['reservation_id'];
				$reservation['Hotel_reservation'][$idx]['hotel_id'] = $h[0]['hotel_id'];
				$reservation['Hotel_reservation'][$idx]['room_id'] = $h[0]['room_id'];
				$reservation['Hotel_reservation'][$idx]['check_in'] = $h[0]['check_in'];
				$reservation['Hotel_reservation'][$idx]['check_out'] = $h[0]['check_out'];
				$reservation['Hotel_reservation'][$idx]['rooms'] = 1;
				$reservation['Hotel_reservation'][$idx]['first_name'] = $h[0]['first_name'];
				$reservation['Hotel_reservation'][$idx]['last_name'] = $h[0]['last_name'];
				$reservation['Hotel_reservation'][$idx]['middle_initial'] = $h[0]['middle_initial'];
				$reservation['Hotel_reservation'][$idx]['birthdate'] = $h[0]['birthdate'];
				$reservation['Hotel_reservation'][$idx]['email'] = $h[0]['email'];
				$reservation['Hotel_reservation'][$idx]['phone'] = str_replace(array(' ','-','(',')'), array('','','',')'), $h[0]['phone']);
				$reservation['Hotel_reservation'][$idx]['reserved_date'] = date('Y-m-d H:i:s');
				$reservation['Hotel_reservation'][$idx]['confirmation'] = $h[0]['confirmation'];
				$reservation['Hotel_reservation'][$idx]['status'] = '1';	
				$reservation['Hotel_reservation'][$idx]['paid'] = '0.00';	
				$reservation['Hotel_reservation'][$idx]['package_id'] = $package_id;	

					
			}		
		}
		ClassRegistry::init("Hotel_reservation")->saveAll($reservation['Hotel_reservation']);
		
		
	}

	public function reserveAttraction($data, $travelers, $reservation_id)
	{
		$confirmations = $this->find('all',array('conditions'=>array('id'=>$reservation_id)));
		foreach ($confirmations as $c) {
			$confirmation_id = $c['Reservation']['confirmation'];
		}
		$reservation = array();
		$attraction_ids = array();
		$idx = -1;
		foreach ($travelers as $key =>$value) {
			$first_name = $travelers['first_name'];
			$last_name = $travelers['last_name'];
			$middle_initial = $travelers['middle_initial'];
			$birthdate = $travelers['birthdate'];
			$email = $travelers['contact_email'];
			$phone = $this->trim_phone($travelers['contact_phone']); 
			
		}		

		foreach ($data as $akey =>$avalue) {
			$idx++;
			if($data[$akey]['time'] == 'No'){
				$reservation['Attraction_reservation'][$idx]['time_ticket'] = 'No';		
			} else {
				$reservation['Attraction_reservation'][$idx]['time_ticket'] = 'Yes';
			}
			$reservation['Attraction_reservation'][$idx]['time'] = $data[$akey]['time'];
			$reservation['Attraction_reservation'][$idx]['attraction_id'] = $data[$akey]['attraction_id'];
			$reservation['Attraction_reservation'][$idx]['tour_id'] = $data[$akey]['tour_id'];
			$reservation['Attraction_reservation'][$idx]['reservation_id'] = $reservation_id;
			$purchase_info = $data[$akey]['purchase_info'];
			$date = $data[$akey]['start'];
			$date_reserved = date('Y-m-d H:i:s', $date);	
			
			$quantity = 0;//start with 0 will add in in next method
			
			$reservation['Attraction_reservation'][$idx]['quantity'] = $quantity;
			$reservation['Attraction_reservation'][$idx]['age_range'] = json_encode($purchase_info);
			$reservation['Attraction_reservation'][$idx]['first_name'] = $first_name;
			$reservation['Attraction_reservation'][$idx]['last_name'] = $last_name;
			$reservation['Attraction_reservation'][$idx]['middle_initial'] = $middle_initial;
			$reservation['Attraction_reservation'][$idx]['birthdate'] = $birthdate;
			$reservation['Attraction_reservation'][$idx]['email'] = $email;
			$reservation['Attraction_reservation'][$idx]['phone'] = $phone;
			$reservation['Attraction_reservation'][$idx]['reserved_date'] = $date_reserved;
			$reservation['Attraction_reservation'][$idx]['date_paid'] = date('Y-m-d H:i:s');
			$reservation['Attraction_reservation'][$idx]['paid_amount'] =sprintf('%.2f',$data[$akey]['total_paid']);
			$reservation['Attraction_reservation'][$idx]['status'] = '1';
			$reservation['Attraction_reservation'][$idx]['confirmation'] = $confirmation_id;
			

		}
		ClassRegistry::init("Attraction_reservation")->saveAll($reservation['Attraction_reservation']);

	}

	public function reservePackage($data, $travelers, $reservation_id)
	{
		
		//set variables
		$last_inserted_ferry_id = '';
		$last_inserted_hotel_id = '';
		$last_inserted_attraction_id = '';
	
		$confirmations = $this->find('all',array('conditions'=>array('id'=>$reservation_id)));
		foreach ($confirmations as $c) {
			$confirmation_id = $c['Reservation']['confirmation'];
		}
		$package = array();

		$package_attraction = array();
		$ferry = array();
		$reservation = array();
		$idx = -1;
		$pdx = -1;
		foreach ($travelers as $key =>$value) {
			$first_name = $travelers['first_name'];
			$last_name = $travelers['last_name'];
			$middle_initial = $travelers['middle_initial'];
			$birthdate = $travelers['birthdate'];
			$email = $travelers['contact_email'];
			$phone = $this->trim_phone($travelers['contact_phone']); 
			
		}	
		//get bbfl confirmation number
		$confirm = ClassRegistry::init('Reservation')->find('all',array('conditions'=>array('id'=>$reservation_id)));
		foreach ($confirm as $c) {
			$bbfl_confirmation = $c['Reservation']['confirmation'];
		}
		foreach ($data as $p) {
			$pdx++;
			//package info	

			//$extra_nights = $p['extra_nights'];
			$package = $p['packages'];
			
			foreach ($package as $ps) {
				$package_id = $ps['id'];
				$package_total = $ps['total'];
				$base = $ps['base'];
				$ferry_difference = $ps['ferry'];
				$hotel_difference = $ps['hotel'];
				$attraction_difference = $ps['attraction'];
			}
			
			$ferry = $p['ferries'];
			$hotel = $p['hotels'];
			$attraction = $p['attractions'];			
			
			//ferry info
			foreach ($ferry as $f) {
				$inventory_id = $f['inventory_id'];
				$trip_type = $f['trip_type'];
				$departs = $f['depart_port'];
				$depart_time = $f['depart_time'];
				$depart_date = $f['depart_full_date'];
				$returns = $f['return_port'];
				$return_time = $f['return_time'];
				$return_date = $f['return_full_date'];
				$schedule_id1 = $f['schedule_id1'];
				$schedule_id2 = $f['schedule_id2'];
				$ferry_drivers = $f['vehicle_count'];
				$ferry_adults = $f['adults'];
				$ferry_children = $f['children'];
				$ferry_infants = $f['infants'];
				$vehicle_count = $f['vehicle_count'];

				switch ($trip_type) {
					case 'Yes': //oneway
						$trip_type = 'oneway';
						break;
					
					default:
						$trip_type = 'roundtrip';
						break;
				}
				$depart_check = date('Y-m-d',strtotime($depart_date)).' 00:00:00';
				$return_check = date('Y-m-d', strtotime($return_date)).' 00:00:00';

				$vdx = -1;
				$vehicle = array();
				
				$vehicles = $f['vehicles'];
				foreach ($vehicles as $v) {
					$vdx++;
					$item_id = $v['item_id'];
					$name = $v['name'];
					$overlength = $v['overlength'];
					$inc_unit = $v['inc_unit'];
					$towed_unit = $v['towed_unit'];
					$vehicle[$vdx] = array(
						'inventory_item_id'=>$item_id,
						'overlength'=>$overlength,
						'towed_unit'=>$towed_unit,
					);
				}

				//create ferry array to send to saving
				$fer['Reservation'][0]['vehicle_count'] = $vehicle_count;
				$fer['Reservation'][0]['vehicle'] = $vehicle;
				$fer['Reservation'][0]['drivers'] = $ferry_drivers;
				$fer['Reservation'][0]['adults'] = $ferry_adults;
				$fer['Reservation'][0]['children'] = $ferry_children;
				$fer['Reservation'][0]['infants'] = $ferry_infants;
				$fer['Reservation'][0]['trip_type'] = $trip_type;
				$fer['Reservation'][0]['depart_port'] = $departs;
				$fer['Reservation'][0]['departs'] = $depart_date;
				$fer['Reservation'][0]['returns'] = $return_date;
	 			$fer['Reservation'][0]['schedule_id1'] = $schedule_id1;
				$fer['Reservation'][0]['schedule_id2'] = $schedule_id2;
				$fer['Reservation'][0]['inventory_id'] = $inventory_id;
				//save the ferry trip
				$this->saveData($fer, $reservation_id);	
				
				//get the last inserted id
				$last_inserted_ferry_id = ClassRegistry::init('Ferry_reservation')->getLastInsertID();			
			}


			$res = array();
			if(count($hotel)>0){
				foreach ($hotel as $h) {
					//hotel info
					$hotel_id = $h['hotel_id'];
					$room_id = $h['room_id'];
					$hotel_start_date = $h['start'];
					$hotel_end_date = $h['end'];
					$hotel_room_name = $h['room_name'];
					$hotel_room_count = $h['room_count'];
					$hotel_adults = $h['adults'];
					$hotel_children = $h['children'];
					$hotel_name = $h['hotel_name'];
					$hotel_gross = $h['total_gross'];
					$hotel_taxes = $h['total_tax'];
					$hotel_total_after_tax = sprintf('%.2f',round(($hotel_gross * (1+$hotel_taxes)) * $hotel_room_count,2));	

					$res['Hotel_reservation'][0]['reservation_id'] = $reservation_id;
					$res['Hotel_reservation'][0]['hotel_id'] = $hotel_id;
					$res['Hotel_reservation'][0]['room_id'] = $room_id;
					$res['Hotel_reservation'][0]['check_in'] = date('Y-m-d H:i:s',$hotel_start_date);
					$res['Hotel_reservation'][0]['check_out'] = date('Y-m-d H:i:s',$hotel_end_date);
					$res['Hotel_reservation'][0]['rooms'] = $hotel_room_count;
					$res['Hotel_reservation'][0]['adults'] = $hotel_adults;
					$res['Hotel_reservation'][0]['children'] = $hotel_children;
					$res['Hotel_reservation'][0]['first_name'] = $first_name;
					$res['Hotel_reservation'][0]['last_name'] = $last_name;
					$res['Hotel_reservation'][0]['middle_initial'] = $middle_initial;
					$res['Hotel_reservation'][0]['birthdate'] = $birthdate;
					$res['Hotel_reservation'][0]['email'] = $email;
					$res['Hotel_reservation'][0]['phone'] = $phone;
					$res['Hotel_reservation'][0]['reserved_date'] = date('Y-m-d H:i:s');
					$res['Hotel_reservation'][0]['confirmation'] = $bbfl_confirmation;
					$res['Hotel_reservation'][0]['status'] = '1';	
					$res['Hotel_reservation'][0]['paid'] = $hotel_total_after_tax;
					$res['Hotel_reservation'][0]['package_id'] = $package_id;
					$this->reservePackageHotel($res);	
					
					//get the last inserted id
					$last_inserted_hotel_id = ClassRegistry::init('Hotel_reservation')->getLastInsertID();					
				}
			}
			$adx = -1;
			if(count($attraction)>0){
				foreach ($attraction as $a) {
					$adx++;
					$tour_id = $a['tour_id'];	
					$attraction_id = $a['attraction_id'];
					if(strtotime($a['start'])==false){
						$attraction_date = $a['start'];
					} else {
						$attraction_date = strtotime($a['start']);
					}
					$check_date = date('Y-m-d',$attraction_date);
					$timed_ticket = $a['time_tour'];
					$attraction_time = 'No';
					if($timed_ticket == 'Yes'){
						$attraction_time =  $a['time'];
					}
					$attraction_name = $a['attraction_name'];
					$tour_name = $a['tour_name'];
					$total_paid = $a['total_paid'];
					$purchase_info = $a['purchase_info'];
					

					$package_attraction[$adx] = array(
						'attraction_id' =>$attraction_id,
						'tour_id'=>$tour_id,
						'start'=>$attraction_date,
						'date'=>$attraction_date,
						'time'=>$attraction_time,
						'purchase_info'=>$purchase_info,
						'total_paid'=>$total_paid,
						
					);
					$this->reserveAttraction($package_attraction,$travelers, $reservation_id);	
				}	
				//get the last inserted id
				$last_inserted_attraction_id =ClassRegistry::init('Attraction_reservation')->getLastInsertID();		
			}
			if(count($vehicles)>0){
				$passenger_adults = $ferry_adults;
			
			} else {
				$passenger_adults = $ferry_adults;
			
			}
			
			$passenger_children = $ferry_children + $ferry_infants;

			$package[$pdx] = array(
				'package_id'=>$package_id,
				'reservation_id'=>$reservation_id,
				'first_name'=>$first_name,
				'middle_initial'=>$middle_initial,
				'last_name'=>$last_name,
				'birthdate'=>$birthdate,
				'email'=>$email,
				'phone'=>$phone,
				'start_date'=>$depart_check,
				'adults'=>$passenger_adults,
				'children'=>$passenger_children,
				'date_paid'=>date('Y-m-d H:i:s'),
				'amount_paid'=>$package_total,
				'confirmation'=>$bbfl_confirmation,
				'status'=>'1',
				'ferry_reservation_id'=>$last_inserted_ferry_id,
				'hotel_reservation_id'=>$last_inserted_hotel_id,
				'attraction_reservation_id'=>$last_inserted_attraction_id
			);
		}
		//save the pacakge information
		ClassRegistry::init("Package_reservation")->saveAll($package);
	
	}

/**
 * Creates the random string
 * 
 * This is used for the confirmation code or any other code needed
 * 
 * user must input the valid characters and the length of the string
 * 
 * @return string
 */
	public function get_random_string($valid_chars, $length)
	{
	    // start with an empty random string
	    $random_string = "";
	
	    // count the number of chars in the valid chars string so we know how many choices we have
	    $num_valid_chars = strlen($valid_chars);
	
	    // repeat the steps until we've created a string of the right length
	    for ($i = 0; $i < $length; $i++)
	    {
	        // pick a random number from 1 up to the number of valid chars
	        $random_pick = mt_rand(1, $num_valid_chars);
	
	        // take the random character out of the string of valid chars
	        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
	        $random_char = $valid_chars[$random_pick-1];
	
	        // add the randomly-chosen char onto the end of our string so far
	        $random_string .= $random_char;
	    }
	
	    // return our finished random string
	    return $random_string;
	}

/**
 * Create a html coded string to create a summary for the ferry
 * @return string
 */
	public function createFerryEmailString($data)
	{
		$count_ferry = count($data);
		$ferry_email = '';
		$ferry_count = 0;
		foreach ($data as $f) {
			$ferry_count++;
			$trip_type = $f['trip_type'];								
			$depart_port  =$f['depart_port'];
			$depart_time = $f['depart_time'];
			$depart_full_date = $f['depart_full_date'];
			$title_message = date('D n/d/y',strtotime($depart_full_date)).' '.$depart_time;
			$depart_reserved = $f['depart_reserved'];
			$depart_reservable_units = $f['depart_reservable_units'];
			$depart_total_units = $f['depart_total_units'];
			$depart_holds = $f['depart_holds'];
			$adults = $f['adults'];
			if($adults == ''){
				$adults = 0;
			}
			$adult_price = $f['adult_price'];
			$adult_rate = sprintf('%.2f',round($adults * $adult_price,2));
			$driver_price = $f['driver_price'];
			$driver_rate = sprintf('%.2f',round($driver_price,2));
			$children = $f['children'];
			$child_price = $f['child_price'];
			$children_rate = sprintf('%.2f',round($children * $child_price,2));
			$infants = $f['infants'];
			$infant_rate = '0.00';
			$inventory_id = $f['inventory_id'];
			switch ($inventory_id) {
				case '1':
					$reservation_type = 'Foot Passenger Reservation';
					break;
				case '2':
					$reservation_type = 'Vehicle Reservation';
					break;
				case '3':
					$reservation_type = 'Motorcycle Reservation';
					break;
				default:
					$reservation_type = 'Bicycle Reservation';
					break;
			}
			$reservable = $f['reservable'];
			$total_units = $f['total_units'];
			$online_oneway = $f['online_oneway'];
			$overlength_rate = $f['overlength_rate'];
			$schedule_id1 = $f['schedule_id1'];
			$vehicle_count = $f['vehicle_count'];
			$vehicles = $f['vehicles'];
			$trip_title = '<strong>'.$depart_port.'</strong> (oneway)';
			$return_message = '';
			$ferry_subtotal = $f['subtotal'];
			$ferry_total = $f['total'];
			switch ($trip_type) {
				case 'roundtrip':
				$trips = 2;
				$return_port = $f['return_port'];
				$return_time = $f['return_time'];
				$return_full_date = $f['return_full_date'];
				$return_reserved = $f['return_reserved'];
				$return_reservable_units = $f['return_reservable_units'];
				$return_total_units = $f['return_total_units'];
				$return_holds = $f['return_holds'];			
				$schedule_id2 = $f['schedule_id2'];	
				$trip_title = '<strong>'.$depart_port.' to '.$return_port.'</strong> (roundtrip)';	
				$online_roundtrip = $f['online_roundtrip'];

				$title_message =date('D n/d/y',strtotime($depart_full_date)).' '.$depart_time.' - '.date('D n/d/y',strtotime($return_full_date)).' '.$return_time;	
			

				break;
					
				default:
					$trips = 1;
			
					break;

			}

			
			
		$ferry_email .= 
			'<tr>'.
				'<td><legend>FERRY RESERVATION</legend></td>'.
			'</tr>'.
			'<tr>'.
				'<td colspan="2">('.$ferry_count.') '.$trip_title.' - '.$title_message.'</td>'.						
			'</tr>';	

			switch ($inventory_id) {
				case '1'://passengers
				if($adults > 0){
					$ferry_email .= 
						'<tr>'.
							'<td style="padding-left:10px;">- '.$adults.' Adults (ages +12)</td>'.
							'<td width="20%" style="text-align: right">$'. sprintf('%.2f',round($adult_rate*$trips,2)).'</td>'.
						'</tr>';

				}
				if($children > 0){
					$ferry_email .= 
						'<tr>'.
							'<td style="padding-left:10px;">- '.$children.' Children (5-11)</td>'.
							'<td width="20%" style="text-align: right">$'. sprintf('%.2f',round($children_rate*$trips,2)).'</td>'.
						'</tr>';

				}
				if($infants > 0){
					$ferry_email .= 
						'<tr>'.
							'<td style="padding-left:10px;">- '.$infants.' Children (0-4)</td>'.
							'<td width="20%" style="text-align: right">$'.$infant_rate.'</td>'.
						'</tr>';	
				}
					break;
				case '2'://vehicles
				foreach ($vehicles as $v) {
					$vehicle_name = $v['name'];
					$vehicle_rate = sprintf('%.2f',round($v['oneway']*$trips,2));
					$total_driver_rate = sprintf('%.2f',round($driver_rate*$trips,2));
					$towed_unit = $v['towed_unit'];
					$total_vehicle_rate = sprintf('%.2f',round(($vehicle_rate + $total_driver_rate),2));
					$overlength = $v['overlength'];
					if($overlength == ''){
						$overlength = 0;
					}
					$total_overlength = $overlength - 18;
					$overlength_total = sprintf('%.2f',round(($overlength_rate * ($overlength - 18) * $trips),2));
					
					$ferry_email .=
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- 1 '.$vehicle_name.' @ ($'.$vehicle_rate.' '.$trip_type.') + 1 Driver(s) @ ($'.$total_driver_rate.' '.$trip_type.')</td>'.
							'<td width="20%" style="text-align: right">$'.$total_vehicle_rate.'</td>'.
						'</tr>';								

					if($overlength > 0){
						$ferry_email .=
							'<tr>'.
								'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- Overlength Charge: '.$total_overlength.' total extra feet @ $'.$overlength_rate.' per foot  ('.$trip_type.')</td>'.
								'<td width="20%" style="text-align: right">$'.$overlength_total.'</td>'.
							'</tr>';
					}
				}						
				
				if($adults > 0){
					$ferry_email .= 
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$adults.' Additional Adults (ages +12)</td>'.
							'<td width="20%" style="text-align: right">$'.sprintf('%.2f',round($adult_rate*$trips,2)).'</td>'.
						'</tr>';

				}
				if($children > 0){
					$ferry_email .=							
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$children.' Children (5-11)</td>'.
							'<td width="20%" style="text-align: right">$'.sprintf('%.2f',round($children_rate*$trips,2)).'</td>'.
						'</tr>';

				}
				if($infants > 0){
					$ferry_email .= 
						'<tr>'.
							'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$infants.' Children (0-4)</td>'.
							'<td width="20%" style="text-align: right">$'.$infant_rate.'</td>'.
						'</tr>';
				}
				
					break;
					
				case '3'://motorcycles
				foreach ($vehicles as $v) {
					$vehicle_name = $v['name'];
					$vehicle_rate = sprintf('%.2f',round($v['oneway']*$trips,2));
					$towed_unit = $v['towed_unit'];
					$total_vehicle_rate = sprintf('%.2f',round(($vehicle_rate),2));
					
					$ferry_email .=					
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- 1 '. $vehicle_name.'</td>'.
							'<td width="20%" style="text-align: right">$'. $total_vehicle_rate.'</td>'.
						'</tr>';
				
				}			
				if($adults > 0){
					$ferry_email .=
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$adults.' Adults (ages +12)</td>'.
							'<td width="20%" style="text-align: right">$'.sprintf('%.2f',round($adult_rate*$trips,2)).'</td>'.
						'</tr>';
				
				}
				if($children > 0){
					$ferry_email .=							
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$children.' Children (5-11)</td>'.
							'<td width="20%" style="text-align: right">$'.sprintf('%.2f',round($children_rate*$trips,2)).'</td>'.
						'</tr>';
				}
				if($infants > 0){
					$ferry_email .= 
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$infants.' Children (0-4)</td>'.
							'<td width="20%" style="text-align: right">$'.$infant_rate.'</td>'.
						'</tr>';
				}	
				
					break;
					
				default://bicycles
				foreach ($vehicles as $v) {
					$vehicle_name = $v['name'];
					$vehicle_rate = sprintf('%.2f',round($v['oneway']*$trips,2));
					$towed_unit = $v['towed_unit'];
					$total_vehicle_rate = sprintf('%.2f',round(($vehicle_rate),2));
					$ferry_email .=	
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- 1 '.$vehicle_name.'</td>'.
							'<td width="20%" style="text-align: right">$'.$total_vehicle_rate.'</td>'.
						'</tr>';
			
				}	
				if($adults > 0){
					$ferry_email .=
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$adults.' Adults (ages +12)</td>'.
							'<td width="20%" style="text-align: right">$'.sprintf('%.2f',round($adult_rate*$trips,2)).'</td>'.
						'</tr>';
				
				}
				if($children > 0){
					$ferry_email .=							
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$children.' Children (5-11)</td>'.
							'<td width="20%" style="text-align: right">$'.sprintf('%.2f',round($children_rate*$trips,2)).'</td>'.
						'</tr>';
				}
				if($infants > 0){
					$ferry_email .= 
						'<tr>'.
							'<td style="padding-left:10px;font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$infants.' Children (0-4)</td>'.
							'<td width="20%" style="text-align: right">$'.$infant_rate.'</td>'.
						'</tr>';
				}							
					break;
			}
						
			
		}

				
		return $ferry_email;	
		
	}

	public function createHotelEmailString($data)
	{
		$hotel_email = '';
		if(count($data) >0){
		$hotel_email .= '<tr><td><br/><legend>HOTEL RESERVATION</label></td><td></td></tr>';			
		}

		foreach ($data as $h) {
			$hotel_id = $h['hotel_id'];
			//get hotel address
			$get_hotels = ClassRegistry::init('Hotel')->find('all',array('conditions'=>array('id'=>$hotel_id)));
			if(count($get_hotels)>0){
				foreach ($get_hotels as $gh) {
					$hotel_street = $gh['Hotel']['address'];
					$hotel_city = $gh['Hotel']['city'];
					$hotel_state = $gh['Hotel']['state'];
					$hotel_country = $gh['Hotel']['country'];
					$hotel_zipcode = $gh['Hotel']['zipcode'];
					$hotel_phone = $this->format_phone($gh['Hotel']['phone']);
					switch($hotel_country){
						case '1':
							$hotel_country = 'USA';
						break;
						case '2':
							$hotel_country = 'CAN';
						break;
					}
					
					$hotel_address = $hotel_street.' <br/> '.ucfirst($hotel_city).', '.ucfirst($hotel_state).' '.$hotel_country.' '.$hotel_zipcode.' <br/> '.$hotel_phone; 
				}
			}
			$room_count = $h['room_count'];
			$room_id = $h['room_id'];
			$start = $h['start'];
			$end = $h['end'];
			$adults = $h['adults'];
			$children = $h['children'];
			$hotel_name = $h['hotel_name'];
			$room_name = $h['room_name'];
			$country = $h['country'];
			$room_desc = $h['room_desc'];
			$total_tax = $h['total_tax'];
			$total_rooms = $h['total_rooms'];
			$total_occupants = $h['total_occupants'];
			$min_rooms = $h['min_rooms'];
			$max_rooms = $h['max_rooms'];
			$extra_fee_multiplier = $h['extra_fee_multiplier'];
			$total_extra_fee = $h['total_extra_fee'];
			$total_nights = $h['total_nights'];
			$total_net = $h['total_net'];
			$total_gross = $h['total_gross'];
			$sum_tax = $h['sum_tax'];

			$hotel_title = $hotel_name;
		
		$hotel_email .=

		'<tr>'.
			'<td colspan ="2" width="80%"><strong>'.$hotel_title.'</strong> - '.date('D n/d/Y',$start).' - '.date('D n/d/Y',$end).'</td>'.
		'</tr>'.
		'<tr>'.
			'<td colspan ="2" width="100%"><em>'.$hotel_address.'</em></td>'.
		'</tr>'.
		'<tr>'.
			'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- <span>'.$room_count.' Room(s), '.$total_nights.' Night(s) : '.$room_name.'</span></td>'.
			'<td width="20%" style="text-align: right">$'.$total_net.'</td>'.
		'</tr>'.
		'<tr>'.
			'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$adults.' Adults, '.$children.' Children</td>'.
			'<td width="20%" style="text-align: right">$'.$total_extra_fee.'</td>'.
		'</tr>';

							
		}
		return $hotel_email;
	}
	public function createAttractionEmailString($data)
	{
		$attraction_email = '';
		if(count($data)>0){
			$attraction_email .= '<tr><td><br/><legend>ATTRACTION RESERVATION</label></td><td></td></tr>';
		}
		foreach ($data as $a) {
			$attraction_id = $a['attraction_id'];
			//get hotel address
			$get_attractions = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('id'=>$attraction_id)));
			if(count($get_attractions)>0){
				foreach ($get_attractions as $ga) {
					$attraction_street = $ga['Attraction']['address'];
					$attraction_city = $ga['Attraction']['city'];
					$attraction_state = $ga['Attraction']['state'];
					$attraction_country = $ga['Attraction']['country'];
					$attraction_zipcode = $ga['Attraction']['zipcode'];
					if(!empty($ga['Attraction']['phone'])){
						$attraction_phone =$this->format_phone($ga['Attraction']['phone']);	
					} else {
						$attraction_phone = '';
					}
					
					switch($attraction_country){
						case '1':
							$attraction_country = 'USA';
						break;
						case '2':
							$attraction_country = 'CAN';
						break;
					}
					
					$attraction_address = $attraction_street.' <br/> '.ucfirst($attraction_city).', '.ucfirst($attraction_state).' '.$attraction_country.' '.$attraction_zipcode.' <br/> '.$attraction_phone; 
				}
			}
			$tour_id =$a['tour_id'];
			$start = $a['start'];
			$attraction_date = date('D n/d/Y',$start);
			$attraction_name = $a['attraction_name'];
			$time_tour = $a['time_tour'];
			switch ($time_tour) {
				case 'Yes':
					$time = $a['time'];
					$attraction_title = '<strong>'.$attraction_name.'</strong> - '.$attraction_date.' @ '.$time;
					break;
				
				default:
					$time = '';
					$attraction_title = '<strong>'.$attraction_name.'</strong> - '.$attraction_date;
					break;
			}
			
			$country = $a['country'];
			$tour_name = $a['tour_name'];
			$tour_desc = $a['tour_desc'];
			$instructions = $a['instructions'];
			$tour_primary_image = $a['tour_primary_image'];
			$tour_sorted_images = $a['tour_sorted_images'];
			$total_tax = $a['total_tax'] / 100;
			$purchase_info = $a['purchase_info'];
			$total_gross = $a['total_gross'];
			$attraction_total_gross = sprintf('%.2f',round($total_gross * (1+$total_tax),2));

			if($instructions != ''){
				$attraction_email .= 				
				'<tr>'.
					'<td colspan="2"><strong>* Special instructions for '.$attraction_title.'</strong> : <br/>'.$instructions.'</td>'.
				'</tr>';	
			}
		
			$attraction_email .=
				'<tr>'.
					'<td colspan="2">'.$attraction_title.'</td>'.
				'</tr>'.
				'<tr>'.
					'<td colspan="2">'.$tour_name.'<label></td>'.
				'</tr>';
		
			$attraction_email .=
				'<tr>'.
					'<td colspan="2"><em>'.$attraction_address.'</em></td>'.
				'</tr>';
			
			foreach ($purchase_info as $pi) {
				$amount = $pi['amount'];
				$gross =$pi['gross'];
				$name = $pi['name'];
				$attraction_total_gross = sprintf('%.2f',round($amount * $gross,2)); 
				if($amount > 0){
					$attraction_email .=			
						'<tr>'.
							'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">- '.$amount.' '.$name.'</td>'.
							'<td width="20%" style="text-align: right">$'.$attraction_total_gross.'</td>'.
						'</tr>';
				
				}
			}
					
		}
		return $attraction_email;		
	}

	public function createPackageEmailString($data)
	{
		$voucher_people_count = 0;
		$package_email = '';
		if(count($data) > 0){
			$package_email .= '<tr><td><br/><legend>PACKAGE RESERVATION</label></td><td></td></tr>';
				
		}
		
		foreach ($data as $pkey => $pvalue) {
			$packages = $data[$pkey]['packages'];
			$ferries = $data[$pkey]['ferries'];
			$hotels = $data[$pkey]['hotels'];
			$attractions = $data[$pkey]['attractions'];
			
			if(!empty($packages)){
				foreach ($packages as $p) {
					$package_id = $p['id'];
					$package_name = $p['name'];
					$package_total = $p['total'];
					$package_ferry = $p['ferry'];
					$package_hotel = $p['hotel'];
					$package_attraction = $p['attraction'];
					$package_base = $p['base'];
					$package_add_on_summary = $p['add_on_summary'];
				}
			}
			
			if(!empty($ferries)){
				foreach ($ferries as $f) {
					$trip_type = $f['trip_type'];
					$departs = $f['depart_port'];
					$returns = $f['return_port'];
					$adults = $f['adults'];
					$children = $f['children'];
					$infants = $f['infants'];
					$voucher_people_count = $adults + $children;
					$depart_date = $f['depart_date'];
					$return_date = $f['return_date'];
					$depart_time = $f['depart_time'];
					$return_time = $f['return_time'];
					$start_date = date('D n/d/Y',strtotime($depart_date));
					$inventory_id = $f['inventory_id'];
					switch ($inventory_id) {
						case '1':
							$reservation_type = 'Walk-on';
							break;
						case '2':
							$reservation_type = 'Vehicle';
							break;
						case '3':
							$reservation_type = 'Motorcycle';
							break;
						default:
							$reservation_type = 'Bicycle';
							break;
					}					
				}
			}
			
			if(!empty($hotels)){
				foreach ($hotels as $h) {
					$hotel_check_in = $h['start'];
					$hotel_check_out = $h['end'];	
					$hotel_nights = ceil(($hotel_check_out - $hotel_check_in) / 86400);
					$hotel_adults = $h['adults'];
					$hotel_children = $h['children'];
					$hotel_name = $h['hotel_name'];
					$hotel_room_name = $h['room_name'];
					$hotel_room_count = $h['room_count'];
					$hotel_date_range = date('D n/d/Y',$hotel_check_in).' - '.date('D n/d/Y',$hotel_check_out);
					$hotel_id = $h['hotel_id'];
					$hotel_id = $h['hotel_id'];
					//get hotel address
					$get_hotels = ClassRegistry::init('Hotel')->find('all',array('conditions'=>array('id'=>$hotel_id)));
					if(count($get_hotels)>0){
						foreach ($get_hotels as $gh) {
							$hotel_street = $gh['Hotel']['address'];
							$hotel_city = $gh['Hotel']['city'];
							$hotel_state = $gh['Hotel']['state'];
							$hotel_country = $gh['Hotel']['country'];
							$hotel_zipcode = $gh['Hotel']['zipcode'];
							$hotel_phone = $this->format_phone($gh['Hotel']['phone']);
							switch($hotel_country){
								case '1':
									$hotel_country = 'USA';
								break;
								case '2':
									$hotel_country = 'CAN';
								break;
							}
							
							$hotel_address = $hotel_street.' <br/> '.ucfirst($hotel_city).', '.ucfirst($hotel_state).' '.$hotel_country.' '.$hotel_zipcode.' <br/> '.$hotel_phone; 
						}
					}
							
				}
			}
			
			switch ($trip_type) {
				case 'roundtrip': //roundtrip
					$trip = 'roundtrip';
					$ferry_trip_date_range = date('D n/d/Y',strtotime($depart_date)). ' @ '.$depart_time.' - '.date('D n/d/Y',strtotime($return_date)).' @ '.$return_time;
					$ferry_trip_title = '<strong>'.$departs.' to '.$returns.'</strong> ('.$trip.', '.$reservation_type.') - '.$ferry_trip_date_range;
					break;
				
				default: //oneway
					$trip = 'oneway';
					$ferry_trip_date_range = date('D n/d/Y',strtotime($depart_date)).' @ '.$depart_time;
					$ferry_trip_title = '<strong>'.$departs.'</strong> ('.$trip.', '.$reservation_type.') - '.$ferry_trip_date_range;
					break;
			}

			$package_email .=		
				'<tr>'.
					'<td width="80%">'.
						'<p id="receiptSummary" style="margin-bottom: 0px;"><strong>'.$package_name.'</strong> - '. $start_date.'</p>'.
					'</td>'.
					'<td width="20%" style="text-align: right">$<span id="vehicle_rate">'.sprintf('%.2f',round($package_total,2)).'</span></td>'.	
				'</tr>'.
				'<tr>'.
					'<td colspan="2">Ferry Details</td>'.
				'</tr>'.
				'<tr>'.
					'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 100%; margin-top:5px; display:block;">- '. $ferry_trip_title.'</td>'.
					'<td style="text-align:right">[packaged price]</td>'.
				'</tr>';
		if(count($hotels)>0){
			$package_email .=
				'<tr>'.
					'<td>Hotel Details</td>'.
				'</tr>'.				
				'<tr>'.
					'<td colspan ="2" width="100%" style="font-size: 80%; font-style: italic; line-height: 100%;"><em>'.$hotel_address.'</em></td>'.
				'</tr>'.
				'<tr>'.
					'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 100%; margin-top:5px; display:block;">- <strong>'.$hotel_name.'</strong> : '.$hotel_date_range.'</td>'.
					'<td style="text-align:right">[packaged price]</td>'.
				'</tr>'.
				'<tr>'.
					'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 100%; display:block;" colspan="2">- '. $hotel_room_count.' (rooms), '.$hotel_room_name.'</td>'.
				'</tr>'.
				'<tr>'.
					'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 100%; display:block;" colspan="2">- '. $hotel_adults.' (adults), '.$hotel_children.' (children)</td>'.
				'</tr>';
				
					
		} 

			if(count($attractions) > 0){
				$package_email .=
					'<tr>'.
						'<td>Attraction Details</td>'.
					'</tr>';
		
				foreach ($attractions as $at) {
					$attraction_date = date('D n/d/Y',$at['start']);
					$timed_ticket = $at['time_tour'];
					switch($timed_ticket){
						case 'Yes':
						
						break;
						
						default:
						
						break;
					}
					$parent_name = $at['attraction_name'];
					$name = $at['tour_name'];
					$desc = $at['tour_desc'];
					$attraction_id = $at['attraction_id'];
					//get hotel address
					$get_attractions = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('id'=>$attraction_id)));
					if(count($get_attractions)>0){
						foreach ($get_attractions as $ga) {
							$attraction_street = $ga['Attraction']['address'];
							$attraction_city = $ga['Attraction']['city'];
							$attraction_state = $ga['Attraction']['state'];
							$attraction_country = $ga['Attraction']['country'];
							$attraction_zipcode = $ga['Attraction']['zipcode'];
							if(!empty($ga['Attraction']['phone'])){
								$attraction_phone =$this->format_phone($ga['Attraction']['phone']);	
							} else {
								$attraction_phone = '';
							}
							
							switch($attraction_country){
								case '1':
									$attraction_country = 'USA';
								break;
								case '2':
									$attraction_country = 'CAN';
								break;
							}
							
							$attraction_address = $attraction_street.' <br/> '.ucfirst($attraction_city).', '.ucfirst($attraction_state).' '.$attraction_country.' '.$attraction_zipcode.' <br/> '.$attraction_phone; 
						}
					}
					
					$purchase_info = $at['purchase_info'];
					$purchase_info_string = '';
					foreach ($purchase_info as $purkey => $purvalue) {
						$pur_name = $purvalue['name'];
						$pur_amount = $purvalue['amount'];
						$pur_gross = $purvalue['gross'];
						$purchase_info_string .= $pur_amount.' '.$pur_name.', ';
					}
					$purchase_info_string = rtrim(substr($purchase_info_string,0,-1),',');
					
						
					$package_email .=
						'<tr>'.
							'<td colspan="2" style="font-size: 80%; font-style: italic; line-height: 100%;"><em>'.$attraction_address.'</em></td>'.
						'</tr>';					
					
					
					$package_email .=			
						'<tr>'.
							'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 100%; margin-top:5px; display:block;">- <strong>'. $parent_name.'</strong> : '. $name.' - '. $attraction_date.'</td>'.
							'<td style="text-align:right">[packaged price]</td>'.
						'</tr>'.
						'<tr>'.
							'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 100%; display:block;">- '.$purchase_info_string.'</td>'.
						'</tr>';

				}
			}
		}
		if(!empty($package_add_on_summary)){
			$package_email .=
				'<tr>'.
					'<td>Package Add-on Vouchers</td>'.
				'</tr>';						
			foreach ($package_add_on_summary as $ao) {
				$add_on_name = $ao['name'];
				$add_on_gross = $ao['after_tax'];
				$voucher_people_count -= 2;
				$add_on_total = $voucher_people_count * $add_on_gross;
				if($add_on_total>0){
					$add_on_total_display = '+ '.$voucher_people_count.' people = ($'.sprintf('%.2f',round($add_on_total,2)).')';
				} else {
					$add_on_total_display = 'No additional person(s)';
				}
				
				$package_email .=
					'<tr>'.
						'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 100%; margin-top:5px; display:block;">- <strong>'. $add_on_name.'</strong></td>'.
						'<td style="text-align:right">[packaged price]</td>'.
					'</tr>'.
					'<tr>'.
						'<td style="padding-left:10px; font-size: 80%; font-style: italic; line-height: 100%; display:block;" colspan="2">- '. $add_on_total_display.'</td>'.
					'</tr>';
			}
		}
		return $package_email;		
	}	

	public function createTotalEmailString($data)
	{
		$total_string = '';
		
		foreach ($data as $key =>$value) {
			$count_packages = $data['count_package'];
			$count_ferry = $data['count_ferry'];
			$count_hotels = $data['count_hotel'];
			$count_attraction = $data['count_attraction'];
			$total_ferry = $data['total_ferry'];
			$total_hotel = $data['total_hotel'];
			$total_attraction = $data['total_attraction'];
			$total_package = $data['total_package'];
			$total_due = $data['total_due'];
			$total_arrival = $data['total_arrival'];
			$total_tax = $data['total_tax'];
			$total_fees = $data['total_fees'];
	
			
			
		}
		if($total_tax > 0){
		$total_string .= 
			'<tr>'.
				'<td>Total Tax:</td>'.
				'<td style="text-align: right">$'. sprintf('%.2f',round($total_tax,2)).'</td>'.
			'</tr>';
		
		}

		if($count_hotels > 0 || $count_attraction > 0 || $count_packages > 0){
			$total_string .=
				'<tr>'.
					'<td>Online Reservation Fees:</td>'.
					'<td style="text-align:right">$'. sprintf('%.2f',round($total_fees,2)).'</td>'.
				'</tr>'.
				// '<tr>'.
					// '<td>Estimated due at time of travel:</td>'.
					// '<td style="text-align: right">$<span id="dueAtArrival">'. $total_arrival.'</span></td>'.
				// '</tr>'.
				'<tr style="font-size: 110%;">'.
					'<td><strong>Paid subtotal:</strong></td>'.
					'<td style="text-align: right"><span id="dueAtCheckout"><strong>$'. sprintf('%.2f',$total_due).'</strong></span></td>'.
				'</tr>';			
		} else {
			$total_string .=
				'<tr>'.
					'<td>Online Reservation Fees:</td>'.
					'<td style="text-align:right">$'. sprintf('%.2f',round($total_fees,2)).'</td>'.
				'</tr>'.
				'<tr>'.
					'<td>Estimated due at time of travel:</td>'.
					'<td style="text-align: right">$<span id="dueAtArrival">'. $total_arrival.'</span></td>'.
				'</tr>'.
				'<tr style="font-size: 110%;">'.
					'<td><strong>Paid subtotal:</strong></td>'.
					'<td style="text-align: right"><span id="dueAtCheckout"><strong>$'. sprintf('%.2f',$total_due).'</strong></span></td>'.
				'</tr>';
		}
				
			
			
		return $total_string;

	}
	public function resendTotalEmailString($reservation_id)
	{
		$total_string = '';
		$total_fees = 0;
		$reservations = ClassRegistry::init('Reservation')->find('all',array('conditions'=>array('id'=>$reservation_id)));
		$count_reservations = count($reservations);
		if($count_reservations>0){
			foreach ($reservations as $r) {
				$total_ferry = $r['Reservation']['ferry_total'];
				$total_hotel = $r['Reservation']['hotel_total'];
				$total_attraction = $r['Reservation']['attraction_total'];
				$total_package = $r['Reservation']['package_total'];
				$total_due = $r['Reservation']['dueAtCheckout'];
				$total_arrival = $r["Reservation"]['dueAtTravel'];
				$total_tax = $r['Reservation']['total_tax'];
				
			}
		}
		$packages = ClassRegistry::init('Package_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		$count_packages = count($packages);
	
		
		$ferries = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		$count_ferries = count($ferries);
		if($count_ferries>0){
			foreach ($ferries as $f) {
				$total_fees = $f['Ferry_reservation']['ferry_fee'];
			}
		}
		
		$hotels = ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		$count_hotels = count($hotels);
		
		$attractions = ClassRegistry::init('Attraction_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		$count_attractions = count($attractions);		

		if($total_tax > 0){
		$total_string .= 
			'<tr>'.
				'<td>Total Tax:</td>'.
				'<td style="text-align: right">$'. sprintf('%.2f',round($total_tax,2)).'</td>'.
			'</tr>';
		
		}

		if($count_hotels > 0 || $count_attractions > 0 || $count_packages > 0){
			$total_string .=
				'<tr>'.
					'<td>Online Reservation Fees:</td>'.
					'<td style="text-align:right">$'. sprintf('%.2f',round($total_fees,2)).'</td>'.
				'</tr>'.
				// '<tr>'.
					// '<td>Estimated due at time of travel:</td>'.
					// '<td style="text-align: right">$<span id="dueAtArrival">'. $total_arrival.'</span></td>'.
				// '</tr>'.
				'<tr style="font-size: 110%;">'.
					'<td><strong>Paid subtotal:</strong></td>'.
					'<td style="text-align: right"><span id="dueAtCheckout"><strong>$'. sprintf('%.2f',$total_due).'</strong></span></td>'.
				'</tr>';			
		} else {
			$total_string .=
				'<tr>'.
					'<td>Online Reservation Fees:</td>'.
					'<td style="text-align:right">$'. sprintf('%.2f',round($total_fees,2)).'</td>'.
				'</tr>'.
				'<tr>'.
					'<td>Estimated due at time of travel:</td>'.
					'<td style="text-align: right">$<span id="dueAtArrival">'. $total_arrival.'</span></td>'.
				'</tr>'.
				'<tr style="font-size: 110%;">'.
					'<td><strong>Paid subtotal:</strong></td>'.
					'<td style="text-align: right"><span id="dueAtCheckout"><strong>$'. sprintf('%.2f',$total_due).'</strong></span></td>'.
				'</tr>';
		}
				
			
			
		return $total_string;

	}
	public function setFerryCancelForConfirmation($data)
	{
		$page_content = array();
		foreach ($data as $key => $value) {
			$status_type = $data['status_type'];
			$confirmation = $data['confirmation'];
			$ferry_id = $data['ferry_id'];
			

			//get inventory information from ferry_reservation table
			$reservations = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('id'=>$ferry_id)));
			if(count($reservations)>0){
				foreach ($reservations as $fr) {
					$reservation_id = $fr['Ferry_reservation']['reservation_id'];
					$inventory_id = $fr['Ferry_reservation']['inventory_id'];
					$vehicle_count = $fr['Ferry_reservation']['vehicle_count'];
					$vehicles = $fr['Ferry_reservation']['vehicles'];
					$drivers = $fr['Ferry_reservation']['drivers'];
					$adults = $fr['Ferry_reservation']['adults'];
					$children = $fr['Ferry_reservation']['children'];
					$infants = $fr['Ferry_reservation']['infants'];
					$fees = $fr['Ferry_reservation']['ferry_fee'];
					$ferry_total = $fr['Ferry_reservation']['dueAtCheckout'];
					$trip_type = $fr['Ferry_reservation']['trip_type'];
					$status_depart = $fr['Ferry_reservation']['status_depart'];
					$status_return = $fr['Ferry_reservation']['status_return'];
					
				}
			}
			
			switch ($status_type) {
				case 'depart':
					
					$status = $data['status_depart'];
					$status_second = $status_return;
					$schedule_id = $fr['Ferry_reservation']['schedule_id1'];
					break;
				
				default:
					$status = $data['status_return'];
					$status_second = $status_depart;
					$schedule_id = $fr['Ferry_reservation']['schedule_id2'];
					break;
			}
			
			//get all the schedule_data from the db
			$schedules = ClassRegistry::init('Schedule')->find('all',array('conditions'=>array('id'=>$schedule_id)));
			if(count($schedules)>0){
				foreach ($schedules as $s) {
					$depart_port = $s['Schedule']['departs'];
					$depart_date = date('D n/d/Y',strtotime($s['Schedule']['check_date']));
					$depart_time = $s['Schedule']['depart_time'];
				}
			}
			
			// grab roundtrip and online fees
			switch ($inventory_id) {
				case '1': //foot passengers
					$get = ClassRegistry::init('Inventory')->find('all',array('conditions'=>array('id'=>'1')));

					break;
				case '2': //vehicles
					$get = ClassRegistry::init('Inventory')->find('all',array('conditions'=>array('id'=>'2')));
						
					break;
				
				case '3': //motorcycles
					$get = ClassRegistry::init('Inventory')->find('all',array('conditions'=>array('id'=>'3')));
					
					break;
				
				default: //bicycles
					$get = ClassRegistry::init('Inventory')->find('all',array('conditions'=>array('id'=>'4')));						
					break;
			}
			if(count($get)>0){
				foreach ($get as $i) {
					$online_oneway = $i['Inventory']['online_oneway'];
					$online_roundtrip = $i['Inventory']['online_roundtrip'];
					$phone_oneway = $i['Inventory']['online_oneway'];
					$phone_roundtrip = $i['Inventory']['online_roundtrip'];
				}
			}	

			switch ($status) {
				case '1': //this is paid and awaiting sailing
					//if check to see what the status are
	
					$refund_ferry = '0.00';	
					
					break;
					
				case '2': //paid but contains errors
					//nothing for now
					$refund_ferry = '0.00';	

					break;
				
				case '3': //cancel + no refund
					//get ferry sailing details for confirmation of cancelling
					$refund_ferry = '0.00';	
					break;
				
				case '4': //cancel + refund
					switch ($status_second) {
						case '3':
							if($fees >0){
								$refund_ferry = sprintf('%.2f',round($fees -($online_oneway * $vehicle_count),2));
							} else {
								$refund_ferry = sprintf('%.2f',round($ferry_total/2,2));
							}	
							break;
						case '4':
							if($fees >0){
								$refund_ferry = sprintf('%.2f',round($online_oneway * $vehicle_count,2));
							} else {
								$refund_ferry = sprintf('%.2f',round($ferry_total,2));
							}
							break;
						default:
							if($fees >0){
								$refund_ferry = sprintf('%.2f',round($fees -($online_oneway * $vehicle_count),2));
							} else {
								$refund_ferry = sprintf('%.2f',round($ferry_total/2,2));
							}
							break;
					}

					break;
					
				case '5': //no cancel + refund
					switch ($status_second) {
						case '3':
							if($fees >0){
								$refund_ferry = sprintf('%.2f',round($fees -($online_oneway * $vehicle_count),2));
							} else {
								$refund_ferry = sprintf('%.2f',round($ferry_total/2,2));
							}	
							break;
						case '4':
							if($fees >0){
								$refund_ferry = sprintf('%.2f',round($online_oneway * $vehicle_count,2));
							} else {
								$refund_ferry = sprintf('%.2f',round($ferry_total,2));
							}
							break;
						default:
							if($fees >0){
								$refund_ferry = sprintf('%.2f',round($fees -($online_oneway * $vehicle_count),2));
							} else {
								$refund_ferry = sprintf('%.2f',round($ferry_total/2,2));
							}
							break;
					}			
					break;

				
				default: //finished sailing
					break;
			}
			$page_content[$ferry_id] = array(
				'ferry_total'=>$ferry_total,
				'ferry_refund'=>$refund_ferry,
				'reservation_id'=>$reservation_id,
				'inventory_id'=>$inventory_id,
				'ferry_id'=>$ferry_id,
				'confirmation'=>$confirmation,
				'schedule_id'=>$schedule_id,
				'status'=>$status,
				'adults'=>$adults,
				'children'=>$children,
				'infants'=>$infants,
				'depart_port'=>$depart_port,
				'depart_date'=>$depart_date,
				'depart_time'=>$depart_time,
				'vehicle_count'=>$vehicle_count,
				'vehicles'=>$vehicles
			);
			
		}
		return $page_content;
	}

/**
 * Cancel Ferry Reservation
 * 
 * @return string;
 */
	public function cancelFerry($data, $refund)
	{
		//set the base variables for total count.
		$page_content = array();
		$total_units = 0;
		$total_overlength = 0;
		$total_passengers = 0;
		
		//reindex data 
		$new_data = array();
		//parse through the requested array to get the basic ferry reservation data, and get specific data from other tables
		foreach ($data as $key => $value) {
			$status_type = $data['status_type'];
			$confirmation = $data['confirmation'];
			$reference = $data['reference'];
			$ferry_id = $data['ferry_id'];
			$schedule_id = $data['schedule_id'];
			switch($status_type){
				case 'depart':
				$new_data[0] = array(
					'status_type'=>$status_type,
					'confirmation'=>$confirmation,
					'reference'=>$reference,
					'ferry_id'=>$ferry_id,
					'schedule_id'=>$schedule_id,
					'status_depart'=>$data['status_depart'],
				);					
				break;
				
				default:
				$new_data[0] = array(
					'status_type'=>$status_type,
					'confirmation'=>$confirmation,
					'reference'=>$reference,
					'ferry_id'=>$ferry_id,
					'schedule_id'=>$schedule_id,
					'status_return'=>$data['status_return'],
				);					
				break;
			}

		}		
		
		
		//parse through the requested array to get the basic ferry reservation data, and get specific data from other tables
		foreach ($new_data as $nd) {
			$status_type = $nd['status_type'];
			$confirmation = $nd['confirmation'];
			$reference = $nd['reference'];
			$ferry_id = $nd['ferry_id'];
			$schedule_id = $nd['schedule_id'];
			//set the status based on the type of trip this is
			switch ($status_type) {
				case 'depart':
					$status = $nd['status_depart'];
					break;
				
				default:
					$status = $nd['status_return'];
					break;
			}
			//get inventory information from ferry_reservation table
			$reservations = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('id'=>$ferry_id)));
			if(count($reservations)>0){
				//reset schedule_limits
				ClassRegistry::init('Schedule_limit')->removeScheduleLimit($reservations);
				
				//parse through data and reset status and refunds values
				foreach ($reservations as $fr) {
					$reservation_id = $fr['Ferry_reservation']['reservation_id'];
					$inventory_id = $fr['Ferry_reservation']['inventory_id'];
					$vehicle_count = $fr['Ferry_reservation']['vehicle_count'];
					$vehicles = json_decode($fr['Ferry_reservation']['vehicles'],2);
					$drivers = $fr['Ferry_reservation']['drivers'];
					$adults = $fr['Ferry_reservation']['adults'];
					$children = $fr['Ferry_reservation']['children'];
					$infants = $fr['Ferry_reservation']['infants'];
					$trip_type = $fr['Ferry_reservation']['trip_type'];
					$ferry_total = $fr['Ferry_reservation']['dueAtCheckout'];
					$ferry_travel = $fr['Ferry_reservation']['dueAtTravel'];
					$ferry_fee = $fr['Ferry_reservation']['ferry_fee'];
					$total_passengers = $drivers + $adults + $children+ $infants;
					//get oneway and roundtrip rates
					$online_roundtrip = 0;
					$online_oneway = 0;
					if($vehicle_count > 0){

						foreach ($vehicles as $vkey => $vvalue) {

							$vehicle_item_id =$vehicles[$vkey]['item_id'];

							$inventory_item_search = ClassRegistry::init('Inventory_item')->find('all',array('conditions'=>array('id'=>$vehicle_item_id)));
							if(count($inventory_item_search)>0){
								foreach ($inventory_item_search as $its) {
									$inventory_id = $its['Inventory_item']['inventory_id'];
								}
							} 
							$trip_fees = ClassRegistry::init('Inventory')->find('all',array('conditions'=>array('id'=>$inventory_id)));
							if(count($trip_fees)>0){
								foreach ($trip_fees as $tf) {
									$online_oneway = $tf['Inventory']['online_oneway'];
									$online_roundtrip = $tf['Inventory']['online_roundtrip'];
									$phone_oneway = $tf['Inventory']['phone_oneway'];
									$phone_roundtrip = $tf['Inventory']['phone_roundtrip'];
								}
							}
						}
					}
				}
			}

			//get all the schedule_data from the db
			$schedules = ClassRegistry::init('Schedule')->find('all',array('conditions'=>array('id'=>$schedule_id)));
			if(count($schedules)>0){
				foreach ($schedules as $s) {
					$depart_port = $s['Schedule']['departs'];
					$depart_date = date('D n/d/Y',strtotime($s['Schedule']['check_date']));
					$depart_time = $s['Schedule']['depart_time'];
				}
			}
			
		}
		//switch through status and make changes where required
		$change = array();

		//check the status and set the refund payments if applicable
		switch ($status) {
			case '1': //this is paid and awaiting sailing
				//if by chance you made it here then do nothing
				
				break;
				
			case '2': //paid but contains errors
				//nothing for now
				
				break;
			
			case '3': //cancel + no refund
				switch ($status_type) {
					case 'depart': //change the depart status 
						$change['Ferry_reservation']['status_depart'] = $status;
						
						break;
					case 'return': //change the return status
						$change['Ferry_reservation']['status_return'] = $status;
						break;
					
					default: //roundtrip change
						$change['Ferry_reservation']['status_depart'] = $status;	
						$change['Ferry_reservation']['status_return'] = $status;
						$change['Ferry_reservation']['trip_type'] = 'oneway';			
						break;
				}
				
				break;
			
			case '4': //cancel + refund
				switch ($status_type) {
					case 'depart': //change the depart status 

						$change['Ferry_reservation']['status_depart'] = $status;
						switch ($trip_type) {
							case 'roundtrip':
								
								
	
								if($ferry_fee > 0){
									$dueAtTravel = sprintf('%.2f',round(($ferry_travel / 2),2));
									$change['Ferry_reservation']['ferry_fee'] = sprintf('%.2f',round(($online_oneway * $vehicle_count),2));
									$change['Ferry_reservation']['dueAtCheckout'] = sprintf('%.2f',round($online_oneway * $vehicle_count,2));
									$change['Ferry_reservation']['dueAtTravel'] = $dueAtTravel;
									$change['Ferry_reservation']['total'] = $dueAtTravel;
									
								} else {
									$dueAtCheckout = sprintf('%.2f',round(($ferry_total - $ferry_fee) / 2,2));
									$change['Ferry_reservation']['ferry_fee'] = '0';
									$change['Ferry_reservation']['dueAtCheckout'] = $dueAtCheckout;
									$change['Ferry_reservation']['dueAtTravel'] = '0';
									$change['Ferry_reservation']['total'] = $dueAtCheckout;
								}									
								break;
							
							default:
								$change['Ferry_reservation']['ferry_fee'] = '0.00';
								$change['Ferry_reservation']['dueAtCheckout'] = '0.00';
								$change['Ferry_reservation']['total'] = '0.00';									
								break;
						}
					
				
					
						break;
					case 'return': //change the return status
						
						$change['Ferry_reservation']['status_return'] = $status;
						switch ($trip_type) {
							case 'roundtrip':
	
	
								if($ferry_fee > 0){

									$dueAtTravel = sprintf('%.2f',round(($ferry_travel / 2),2));
									$change['Ferry_reservation']['ferry_fee'] = sprintf('%.2f',round(($online_oneway * $vehicle_count),2));
									$change['Ferry_reservation']['dueAtCheckout'] = sprintf('%.2f',round($online_oneway * $vehicle_count,2));
									$change['Ferry_reservation']['dueAtTravel'] = $dueAtTravel;
									$change['Ferry_reservation']['total'] = $dueAtCheckout;
									
								} else {

									$dueAtCheckout = sprintf('%.2f',round((($ferry_total - $ferry_fee) / 2),2));
									$change['Ferry_reservation']['ferry_fee'] = '0';
									$change['Ferry_reservation']['dueAtCheckout'] = $dueAtCheckout;
									$change['Ferry_reservation']['dueAtTravel'] = '0';
									$change['Ferry_reservation']['total'] = $dueAtCheckout;
								}									
								break;
							
							default:
								$change['Ferry_reservation']['ferry_fee'] = '0.00';
								$change['Ferry_reservation']['dueAtCheckout'] = '0.00';
								$change['Ferry_reservation']['total'] = '0.00';								
								break;
						}
						break;
					
					default: //roundtrip change
						$dueAtCheckout = sprintf('%.2f',round(($ferry_total - $ferry_fee) / 2,2));
						$change['Ferry_reservation']['status_depart'] = $status;	
						$change['Ferry_reservation']['status_return'] = $status;		
						if($ferry_fee > 0){
							$change['Ferry_reservation']['ferry_fee'] = $online_oneway;
							$change['Ferry_reservation']['dueAtCheckout'] = sprintf('%.2f',round($online_oneway * $vehicle_count),2);
							$change['Ferry_reservation']['dueAtTravel'] = $dueAtCheckout;
							$change['Ferry_reservation']['total'] = $dueAtCheckout;
							
						} else {
							$change['Ferry_reservation']['ferry_fee'] = '0';
							$change['Ferry_reservation']['dueAtCheckout'] = $dueAtCheckout;
							$change['Ferry_reservation']['dueAtTravel'] = '0';
							$change['Ferry_reservation']['total'] = $dueAtCheckout;
						}	
						break;
				}			

				$payment_refund = ClassRegistry::init('Payment')->refund($reference, $refund);
				break;
				
			case '5': //no cancel + refund
				switch ($status_type) {
					case 'depart': //change the depart status 

						switch ($trip_type) {
							case 'roundtrip':						
	
								if($ferry_fee > 0){
									$dueAtTravel = sprintf('%.2f',round(($ferry_travel / 2),2));
									$change['Ferry_reservation']['ferry_fee'] = sprintf('%.2f',round(($online_oneway * $vehicle_count),2));
									$change['Ferry_reservation']['dueAtCheckout'] = sprintf('%.2f',round($online_oneway * $vehicle_count,2));
									$change['Ferry_reservation']['dueAtTravel'] = $dueAtTravel;
									$change['Ferry_reservation']['total'] = $dueAtTravel;
									
								} else {
									$dueAtCheckout = sprintf('%.2f',round(($ferry_total - $ferry_fee) / 2,2));
									$change['Ferry_reservation']['ferry_fee'] = '0';
									$change['Ferry_reservation']['dueAtCheckout'] = $dueAtCheckout;
									$change['Ferry_reservation']['dueAtTravel'] = '0';
									$change['Ferry_reservation']['total'] = $dueAtCheckout;
								}									
								break;
							
							default:
								$change['Ferry_reservation']['ferry_fee'] = '0.00';
								$change['Ferry_reservation']['dueAtCheckout'] = '0.00';
								$change['Ferry_reservation']['total'] = '0.00';									
								break;
						}
					
				
					
						break;
					case 'return': //change the return status

						switch ($trip_type) {
							case 'roundtrip':
	
	
								if($ferry_fee > 0){

									$dueAtTravel = sprintf('%.2f',round(($ferry_travel / 2),2));
									$change['Ferry_reservation']['ferry_fee'] = sprintf('%.2f',round(($online_oneway * $vehicle_count),2));
									$change['Ferry_reservation']['dueAtCheckout'] = sprintf('%.2f',round($online_oneway * $vehicle_count,2));
									$change['Ferry_reservation']['dueAtTravel'] = $dueAtTravel;
									$change['Ferry_reservation']['total'] = $dueAtCheckout;
									
								} else {

									$dueAtCheckout = sprintf('%.2f',round((($ferry_total - $ferry_fee) / 2),2));
									$change['Ferry_reservation']['ferry_fee'] = '0';
									$change['Ferry_reservation']['dueAtCheckout'] = $dueAtCheckout;
									$change['Ferry_reservation']['dueAtTravel'] = '0';
									$change['Ferry_reservation']['total'] = $dueAtCheckout;
								}									
								break;
							
							default:
								$change['Ferry_reservation']['ferry_fee'] = '0.00';
								$change['Ferry_reservation']['dueAtCheckout'] = '0.00';
								$change['Ferry_reservation']['total'] = '0.00';								
								break;
						}
						break;
					
					default: //roundtrip change
						$dueAtCheckout = sprintf('%.2f',round(($ferry_total - $ferry_fee) / 2,2));

						if($ferry_fee > 0){
							$change['Ferry_reservation']['ferry_fee'] = $online_oneway;
							$change['Ferry_reservation']['dueAtCheckout'] = sprintf('%.2f',round($online_oneway * $vehicle_count),2);
							$change['Ferry_reservation']['dueAtTravel'] = $dueAtCheckout;
							$change['Ferry_reservation']['total'] = $dueAtCheckout;
							
						} else {
							$change['Ferry_reservation']['ferry_fee'] = '0';
							$change['Ferry_reservation']['dueAtCheckout'] = $dueAtCheckout;
							$change['Ferry_reservation']['dueAtTravel'] = '0';
							$change['Ferry_reservation']['total'] = $dueAtCheckout;
						}	
						break;
				}			

				$payment_refund = ClassRegistry::init('Payment')->refund($reference, $refund);
				break;

			
			default: //finished sailing
				
				break;
		}

		//save statuses in the ferry_reservation table
		ClassRegistry::init('Ferry_reservation')->id = $ferry_id;	
		ClassRegistry::init('Ferry_reservation')->save($change);



		

		return $page_content;
	} 

	public function cancelFerryAll($confirm, $status)
	{
		$new = array();
		$total_due = 0;
		$total_units = 0;
		$total_overlength = 0;
		$total_passengers = 0;
		$ferries = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('confirmation'=>$confirm)));
		
		if(count($ferries)>0){
			foreach ($ferries as $t) {
				$dueAtCheckout = $t['Ferry_reservation']['dueAtCheckout'];
				$total_due = $total_due + $dueAtCheckout;
			}
			
			foreach ($ferries as $f) {
				$id = $f['Ferry_reservation']['id'];
				ClassRegistry::init('Ferry_reservation')->id = $id;
				$new['Ferry_reservation']['status_depart'] = $status;
				$new['Ferry_reservation']['status_return'] = $status;
				$reservation_id = $f['Ferry_reservation']['reservation_id'];
				$inventory_id = $f['Ferry_reservation']['inventory_id'];
				$vehicle_count = $f['Ferry_reservation']['vehicle_count'];
				$vehicles = json_decode($f['Ferry_reservation']['vehicles'],2);
				$drivers = $f['Ferry_reservation']['drivers'];
				$adults = $f['Ferry_reservation']['adults'];
				$children = $f['Ferry_reservation']['children'];
				$infants = $f['Ferry_reservation']['infants'];
				$trip_type = $f['Ferry_reservation']['trip_type'];
				$ferry_total = $f['Ferry_reservation']['dueAtCheckout'];
				$ferry_travel = $f['Ferry_reservation']['dueAtTravel'];
				$ferry_fee = $f['Ferry_reservation']['ferry_fee'];
				$schedule_id1 = $f['Ferry_reservation']['schedule_id1'];
				$schedule_id2 = $f['Ferry_reservation']['schedule_id2'];
				$total_passengers = $drivers + $adults + $children+ $infants;
				//get oneway and roundtrip rates
				$online_roundtrip = 0;
				$online_oneway = 0;
				if($vehicle_count > 0){

					foreach ($vehicles as $vkey => $vvalue) {

						$vehicle_item_id =$vehicles[$vkey]['item_id'];

						$inventory_item_search = ClassRegistry::init('Inventory_item')->find('all',array('conditions'=>array('id'=>$vehicle_item_id)));
						if(count($inventory_item_search)>0){
							foreach ($inventory_item_search as $its) {
								$inventory_id = $its['Inventory_item']['inventory_id'];
							}
						} 
						$trip_fees = ClassRegistry::init('Inventory')->find('all',array('conditions'=>array('id'=>$inventory_id)));
						if(count($trip_fees)>0){
							foreach ($trip_fees as $tf) {
								$online_oneway = $tf['Inventory']['online_oneway'];
								$online_roundtrip = $tf['Inventory']['online_roundtrip'];
								$phone_oneway = $tf['Inventory']['phone_oneway'];
								$phone_roundtrip = $tf['Inventory']['phone_roundtrip'];
							}
						}
					}
						
					
				}				
				//check the status and set the refund payments if applicable
				switch ($status) {
					case '1': //this is paid and awaiting sailing
						//if by chance you made it here then do nothing
						
						break;
						
					case '2': //paid but contains errors
						//nothing for now
						
						break;
					
					case '3': //cancel + no refund
						$change['Ferry_reservation']['status_depart'] = $status;	
						$change['Ferry_reservation']['status_return'] = $status;
						
						break;
					
					case '4': //cancel + refund
						$dueAtCheckout = sprintf('%.2f',round(($ferry_total - $ferry_fee) / 2,2));
						$change['Ferry_reservation']['status_depart'] = $status;	
						$change['Ferry_reservation']['status_return'] = $status;		
						$change['Ferry_reservation']['ferry_fee'] = '0';
						$change['Ferry_reservation']['dueAtCheckout'] = $dueAtCheckout;
						$change['Ferry_reservation']['dueAtTravel'] = '0';
						$change['Ferry_reservation']['total'] = $dueAtCheckout;
		
						$payment_refund = ClassRegistry::init('Payment')->refund($reference, $ferry_total);
						break;
						
					case '5': //no cancel + refund
						$change['Ferry_reservation']['ferry_fee'] = '0';
						$change['Ferry_reservation']['dueAtCheckout'] = $dueAtCheckout;
						$change['Ferry_reservation']['dueAtTravel'] = '0';
						$change['Ferry_reservation']['total'] = $dueAtCheckout;		
		
						$payment_refund = ClassRegistry::init('Payment')->refund($reference, $ferry_total);
						break;
		
					
					default: //finished sailing
						
						break;
				}
				//save statuses in the ferry_reservation table
				ClassRegistry::init('Ferry_reservation')->id = $id;	
				ClassRegistry::init('Ferry_reservation')->save($change);
				
								
				//parse through the vehicles array to collect the total of units and overlength (if any)
				foreach ($vehicles as $v) {
					$item_id = $v['item_id'];
					$vehicle_name = $v['name'];
					$overlength = $v['overlength'];
					$total_overlength = $total_overlength + $overlength; //total overlength
		
					switch ($item_id) {
						case '23': //overlength vehicle
							$inventory_removed = sprintf('%.2f',round($overlength / 18,2));
							break;
						
						default: //every other vehicle
							$inventory_removed = sprintf('%.2f',1);
		
							break;
					}
		
					$total_units = $total_units + $inventory_removed; //total units
				}		
		
				
		
				//switch through what type of ferry inventory we are using. calculate the new inventory totals and overlength, incremental unit totals
				switch ($inventory_id) {
					case '1': //foot passengers
					
						//Change Passenger reserved rates for the departure
						$old_passengers = ClassRegistry::init('Schedule_limit')->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>'1')));
						//if there are passengers on this trip then subtract the total passengers from the count to get the new count
						if(count($old_passengers) >0){
							foreach ($old_passengers as $sl) {
								$old_passengers = $sl["Schedule_limit"]['reserved'];	
							}
							$new_passengers = $old_passengers - $total_passengers;
						} else { //if there are no passengers then set the passenger inventory to 0, there are negative passengers.
							$new_passengers = 0;
						}		
						
						//update passenger limits inside schedule_limits
						ClassRegistry::init('Schedule_limit')->query('update schedule_limits set reserved ="'.$new_passengers.'" where schedule_id="'.$schedule_id1.'" and inventory_id="1"');
						
						//Change Passenger reserved rates for the return
						$old_passengers = ClassRegistry::init('Schedule_limit')->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>'1')));
						//if there are passengers on this trip then subtract the total passengers from the count to get the new count
						if(count($old_passengers) >0){
							foreach ($old_passengers as $sl) {
								$old_passengers = $sl["Schedule_limit"]['reserved'];	
							}
							$new_passengers = $old_passengers - $total_passengers;
						} else { //if there are no passengers then set the passenger inventory to 0, there are negative passengers.
							$new_passengers = 0;
						}		
						
						//update passenger limits inside schedule_limits
						ClassRegistry::init('Schedule_limit')->query('update schedule_limits set reserved ="'.$new_passengers.'" where schedule_id="'.$schedule_id2.'" and inventory_id="1"');			
							
						break;
					default: //everything else
					
						//change the return values for passengers
						$old_passengers = ClassRegistry::init('Schedule_limit')->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>'1')));
						
						if(count($old_passengers) >0){ //if there are more than 0 passengers
							foreach ($old_passengers as $sl) {
								$old_passengers = $sl["Schedule_limit"]['reserved'];	
							}
							$new_passengers = $old_passengers - $total_passengers;
							if($new_passengers < 0){
								$new_passengers = 0;
							}
						} else { //if there are no passengers make sure to set the passenger count to zero as there are no negative passenger counts.
							$new_passengers = 0;
						}
						//get vehicle limits
						$old_vehicles = ClassRegistry::init('Schedule_limit')->find('all',array('conditions'=>array('schedule_id'=>$schedule_id1,'inventory_id'=>$inventory_id)));
		
						if(count($old_vehicles) >0){ //count the rows of the vehicles array
							foreach ($old_vehicles as $sl) {
								$old_reserved = $sl["Schedule_limit"]['reserved'];
								$old_overlength_count = $sl['Schedule_limit']['overlength_count'];
								
							}
							$new_reserved = $old_reserved - $total_units;
							if($new_reserved < 0){
								$new_reserved = 0;
							}
							$new_overlength_count = $old_overlength_count - $total_overlength;
							if($new_overlength_count <0){
								$new_overlength_count = 0;
							}
						} else {
							$new_reserved = 0;
							$new_overlength_count = 0;
						}	
						
						//get new incremental units\
						$inc_calc = $new_overlength_count / 18;
						if($inc_calc > 0){
							$find_conditions = array('Incremental_unit.start <='=>$inc_calc, 'Incremental_unit.end >=' =>$inc_calc);
							$find_inc_units  = ClassRegistry::init('Incremental_unit')->find('all',array('conditions'=>$find_conditions));
							if(count($find_inc_units)>0){
								foreach ($find_inc_units as $inc) {
									$inc_units = $inc['Incremental_unit']['inc_units'];
								}
							} else {
								$inc_units = 0;
							}
						} else {
							$inc_units = 0;
						}					
						//update passengers inside schedule_limits
						ClassRegistry::init('Schedule_limit')->query('update schedule_limits set reserved ="'.$new_passengers.'" where schedule_id="'.$schedule_id1.'" and inventory_id="1"');
						//update vehicles inside schedule_limits
						ClassRegistry::init('Schedule_limit')->query('update schedule_limits set reserved ="'.$new_reserved.'", overlength_count="'.$new_overlength_count.'", inc_units ="'.$inc_units.'" where schedule_id="'.$schedule_id1.'" and inventory_id="'.$inventory_id.'"');	


						//get return schedule limit rates and setup new data
						$old_passengers = ClassRegistry::init('Schedule_limit')->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>'1')));
						
						if(count($old_passengers) >0){ //if there are more than 0 passengers
							foreach ($old_passengers as $sl) {
								$old_passengers = $sl["Schedule_limit"]['reserved'];	
							}
							$new_passengers = $old_passengers - $total_passengers;
							if($new_passengers < 0){
								$new_passengers = 0;
							}
						} else { //if there are no passengers make sure to set the passenger count to zero as there are no negative passenger counts.
							$new_passengers = 0;
						}
						//get vehicle limits
						$old_vehicles = ClassRegistry::init('Schedule_limit')->find('all',array('conditions'=>array('schedule_id'=>$schedule_id2,'inventory_id'=>$inventory_id)));
		
						if(count($old_vehicles) >0){ //count the rows of the vehicles array
							foreach ($old_vehicles as $sl) {
								$old_reserved = $sl["Schedule_limit"]['reserved'];
								$old_overlength_count = $sl['Schedule_limit']['overlength_count'];
								
							}
							$new_reserved = $old_reserved - $total_units;
							if($new_reserved < 0){
								$new_reserved = 0;
							}
							$new_overlength_count = $old_overlength_count - $total_overlength;
							if($new_overlength_count <0){
								$new_overlength_count = 0;
							}
						} else {
							$new_reserved = 0;
							$new_overlength_count = 0;
						}	
						
						//get new incremental units\
						$inc_calc = $new_overlength_count / 18;
						if($inc_calc > 0){
							$find_conditions = array('Incremental_unit.start <='=>$inc_calc, 'Incremental_unit.end >=' =>$inc_calc);
							$find_inc_units  = ClassRegistry::init('Incremental_unit')->find('all',array('conditions'=>$find_conditions));
							if(count($find_inc_units)>0){
								foreach ($find_inc_units as $inc) {
									$inc_units = $inc['Incremental_unit']['inc_units'];
								}
							} else {
								$inc_units = 0;
							}
						} else {
							$inc_units = 0;
						}					
						//update passengers inside schedule_limits
						ClassRegistry::init('Schedule_limit')->query('update schedule_limits set reserved ="'.$new_passengers.'" where schedule_id="'.$schedule_id2.'" and inventory_id="1"');
						//update vehicles inside schedule_limits
						ClassRegistry::init('Schedule_limit')->query('update schedule_limits set reserved ="'.$new_reserved.'", overlength_count="'.$new_overlength_count.'", inc_units ="'.$inc_units.'" where schedule_id="'.$schedule_id2.'" and inventory_id="'.$inventory_id.'"');						
						
						break;
				}
			}
		}
		
	}

	public function setHotelCancelForConfirmation($data)
	{
		$hotels = array();
		
		$total_hotel_refund = 0;
		foreach ($data as $key => $value) {
			$reservation_id = $data['reservation_id'];
			$id = $data['id'];
			$hotel_id = $data['hotel_id'];
			$room_id = $data['room_id'];
			$hotel_confirmation = $data['hotel_confirmation'];
			$status = $data['status'];
			$reservations = ClassRegistry::init('Reservation')->find('all',array('conditions'=>array('id'=>$reservation_id)));

			$hotel_info = ClassRegistry::init('Hotel')->find('all',array('conditions'=>array('id'=>$hotel_id))); 
			if(count($hotel_info)>0){
				foreach ($hotel_info as $ht) {
					$hotel_name = $ht['Hotel']['name'];
				}
			}
			
			$hotel_reservations = ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('id'=>$id)));
			if(count($hotel_reservations)>0){
				$total_hotel_refund = 0;
				foreach ($hotel_reservations as $hr) {
					$hotel_total = $hr['Hotel_reservation']['paid'];
					$check_in = $hr["Hotel_reservation"]['check_in'];
					$check_out = $hr['Hotel_reservation']['check_out'];
					$room_count = $hr['Hotel_reservation']['rooms'];
					$adults = $hr['Hotel_reservation']['adults'];
					$children = $hr['Hotel_reservation']['children'];
				}
			}
			
			$rooms = ClassRegistry::init('Hotel_room')->find('all',array('conditions'=>array('id'=>$room_id)));
			if(count($rooms)>0){
				foreach ($rooms as $r) {
					$room_name = $r['Hotel_room']['name'];
					$inventory = json_decode($r['Hotel_room']['inventory'],true);
				}
			}

			switch ($status) {
				case '1': //paid 
					
					break;
				case '2': //paid and confirmed
					
					break;
				case '3': //cancel + no refund
					$total_hotel_refund = $total_hotel_refund + 0;
					break;
				case '4':
					$total_hotel_refund = $total_hotel_refund + $hotel_total;
					break;
				case '5':
					$total_hotel_refund = $total_hotel_refund + $hotel_total;
					break;				
				default:
					
					break;
			}

			$hotels[$id] = array(
				'hotel_name'=>$hotel_name,
				'hotel_id'=>$hotel_id,
				'room_name'=>$room_name,
				'room_count'=>$room_count,
				'room_id'=>$room_id,
				'hotel_confirmation'=>$hotel_confirmation,
				'total'=>$hotel_total,
				'total_refund'=>$total_hotel_refund,
				'inventory'=>$inventory,
				'status'=>$status,
				'adults'=>$adults,
				'children'=>$children,
				'check_in'=>date('n/d/Y',strtotime($check_in)),
				'check_out'=>date('n/d/Y',strtotime($check_out))
			);
			
		}
		return $hotels;	
	}

	public function setAttractionCancelForConfirmation($data)
	{
		$attractions = array();
		$total_attraction_total = 0;
		$total_attraction_refund = 0;
		foreach ($data as $key => $value) {
			
			$reservation_id = $data['reservation_id'];
			$id = $data['attraction_reservation_id'];
			$attraction_id = $data['attraction_id'];
			$tour_id = $data['tour_id'];
			$status = $data['status'];
			$reservations = ClassRegistry::init('Reservation')->find('all',array('conditions'=>array('id'=>$reservation_id)));
			$attraction_info = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('id'=>$attraction_id))); 
			if(count($attraction_info)>0){
				foreach ($attraction_info as $at) {
					$attraction_name = $at['Attraction']['name'];
				}
			}
			
			$attraction_reservations = ClassRegistry::init('Attraction_reservation')->find('all',array('conditions'=>array('id'=>$id)));
			if(count($attraction_reservations)>0){
				$total_attraction_refund = 0;
				foreach ($attraction_reservations as $ar) {
					$attraction_total = $ar['Attraction_reservation']['paid_amount'];
					$tour_date = $ar['Attraction_reservation']['reserved_date'];
					$age_range = $ar['Attraction_reservation']['age_range'];
					$time_ticket = $ar['Attraction_reservation']['time_ticket'];
					$time = $ar['Attraction_reservation']['time'];
					$total = $ar['Attraction_reservation']['paid_amount'];
					$confirmation = $ar['Attraction_reservation']['confirmation'];
					$total_attraction_total = $total_attraction_total + $attraction_total;
				}
			}
			
			$tours = ClassRegistry::init('Attraction_ticket')->find('all',array('conditions'=>array('id'=>$tour_id)));
			if(count($tours)>0){
				foreach ($tours as $t) {
					$tour_name = $t['Attraction_ticket']['name'];
					
				}
			}

			switch ($status) {
				case '1': //paid 
					
					break;
				case '2': //paid and confirmed
					
					break;
				case '3': //cancel + no refund
					$total_attraction_refund = $total_attraction_refund + 0;
					break;
				case '4':
					$total_attraction_refund = $total_attraction_refund + $total;
					break;
				case '5':
					$total_attraction_refund = $total_attraction_refund + $total;
					break;				
				default:
					
					break;
			}

			$attractions[$id] = array(
				'attraction_name'=>$attraction_name,
				'attraction_id'=>$attraction_id,
				'tour_name'=>$tour_name,
				'tour_id'=>$tour_id,
				'tour_date'=>date('n/d/Y',strtotime($tour_date)),
				'time_ticket'=>$time_ticket,
				'time'=>$time,
				'confirmation'=>$confirmation,
				'total'=>$total,
				'total_attraction_total'=>$total_attraction_total,
				'total_refund'=>$total_attraction_refund,
				'age_range'=>json_decode($age_range,true),
				'status'=>$status
			);
			
		}



		return $attractions;
		
	}

	public function confirmEdit($data)
	{
		$fdx = -1;
	
		unset($data['confirmation']);

		$new_data = array();
		$fdx++;
		if(!empty($data['Ferry_reservation'])){
			foreach ($data['Ferry_reservation'] as $fkey => $fvalue) {
				$ferry_id = $fkey;
				//get old ferry totals
				$ferry_totals = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('id'=>$ferry_id)));
				
				if(count($ferry_totals)>0){
					foreach ($ferry_totals as $ft) {
						$inventory_id = $ft["Ferry_reservation"]['inventory_id'];
						$old_subtotal = $ft['Ferry_reservation']['subtotal'];
						
						$ferry_fee = $ft['Ferry_reservation']['ferry_fee'];
					}
				}
				
				$new_depart_port = $data['Ferry_reservation'][$fkey]['depart_port'];
				$new_depart_time = $data['Ferry_reservation'][$fkey]['depart_time'];
				$new_depart_date = date('Y-m-d H:i:s',strtotime($data['Ferry_reservation'][$fkey]['depart_date']));
				
				if(!empty($data['Ferry_reservation'][$fkey]['depart_vehicles'])){
					$new_depart_vehicles = $data['Ferry_reservation'][$fkey]['depart_vehicles'];
				} else {
					$new_depart_vehicles = 'Passenger';
				}
				
				if(!empty( $data['Ferry_reservation'][$fkey]['depart_drivers'])){
					$new_depart_drivers = $data['Ferry_reservation'][$fkey]['depart_drivers'];
				} else {
					$new_depart_drivers = 0;
				}
				$new_depart_adults = $data['Ferry_reservation'][$fkey]['depart_adults'];
				$new_depart_children = $data['Ferry_reservation'][$fkey]['depart_children'];
				$new_depart_infants = $data['Ferry_reservation'][$fkey]['depart_infants'];
				$nsid1 = ClassRegistry::init('Schedule')->find('all',array('conditions'=>array('departs'=>$new_depart_port,'check_date'=>$new_depart_date,'depart_time'=>$new_depart_time)));
				if(count($nsid1) > 0){
					foreach ($nsid1 as $nsid) {
						$new_schedule_id1 = $nsid['Schedule']['id'];
					}
				} else {
					$new_schedule_id1 = '';
				}
				if(!empty($data['Ferry_reservation'][$fkey]['return_port'])){
					$new_return_port = $data['Ferry_reservation'][$fkey]['return_port'];
				} else {
					$new_return_port = '';
				}
				if(!empty($data['Ferry_reservation'][$fkey]['return_date'])){
					$new_return_date =  date('Y-m-d H:i:s',strtotime($data['Ferry_reservation'][$fkey]['return_date']));
				} else {
					$new_return_date = '';
				}		
				if(!empty($data['Ferry_reservation'][$fkey]['return_time'])){
					$new_return_time = $data['Ferry_reservation'][$fkey]['return_time'];
				} else {
					$new_return_time = '';
				}	
				$nsid2 = ClassRegistry::init('Schedule')->find('all',array('conditions'=>array('departs'=>$new_return_port,'check_date'=>$new_return_date,'depart_time'=>$new_return_time)));
				if(count($nsid2) > 0){
					foreach ($nsid2 as $nsid) {
						$new_schedule_id2 = $nsid['Schedule']['id'];
					}
				} else {
					$new_schedule_id2 = '0';
				}
	
	 
				if(!empty($data['Ferry_reservation'][$fkey]['return_vehicles'])){
					$new_return_vehicles = $data['Ferry_reservation'][$fkey]['return_vehicles'];
				} else {
					$new_return_vehicles = 'Passenger';
				}
				if(!empty($data['Ferry_reservation'][$fkey]['return_drivers'])){
					$new_return_drivers = $data['Ferry_reservation'][$fkey]['return_drivers'];
				} else {
					$new_return_drivers = '0';
				}
				if(!empty($data['Ferry_reservation'][$fkey]['return_adults'])){
					$new_return_adults = $data['Ferry_reservation'][$fkey]['return_adults'];
				} else {
					$new_return_adults = '0';
				}
				if(!empty($data['Ferry_reservation'][$fkey]['return_children'])){
					$new_return_children = $data['Ferry_reservation'][$fkey]['return_children'];
				} else {
					$new_return_children = '0';
				}
				if(!empty($data['Ferry_reservation'][$fkey]['return_infants'])){
					$new_return_infants = $data['Ferry_reservation'][$fkey]['return_infants'];
				} else {
					$new_return_infants = '0';
				}
				//get original data
				$original_ferry = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('id'=>$ferry_id)));
				if(count($original_ferry)>0){
					foreach ($original_ferry as $of) {
						$old_schedule_id1 = $of['Ferry_reservation']['schedule_id1'];
						$old_schedule_id2 = $of['Ferry_reservation']['schedule_id2'];
						$old_depart_status = $of['Ferry_reservation']['status_depart'];
						$old_return_status = $of['Ferry_reservation']['status_return'];
	
						$old_depart_port  = $of['Ferry_reservation']['depart_port'];
						$old_depart_date = $of['Ferry_reservation']['depart_date'];
						$old_vehicles = json_decode($of['Ferry_reservation']['vehicles'],2);
						$old_return_port = $of['Ferry_reservation']['return_port'];
						$old_return_date = $of['Ferry_reservation']['return_date'];
						$old_drivers = $of['Ferry_reservation']['drivers'];
						$old_adults = $of['Ferry_reservation']['adults'];
						$old_children = $of['Ferry_reservation']['children'];
						$old_infants = $of['Ferry_reservation']['infants'];
						$trip_type = $of['Ferry_reservation']['trip_type'];	
						$osid1 = ClassRegistry::init('Schedule')->find('all',array('conditions'=>array('id'=>$old_schedule_id1)));
						if(count($osid1) > 0){
							foreach ($osid1 as $osid) {
								$old_depart_time = $osid['Schedule']['depart_time'];
							}
						} else {
							$old_depart_time = 'NONE';
						}	
						$osid2 = ClassRegistry::init('Schedule')->find('all',array('conditions'=>array('id'=>$old_schedule_id2)));
						if(count($osid2) > 0){
							foreach ($osid2 as $osid) {
								$old_return_time = $osid['Schedule']['depart_time'];
							}
						} else {
							$old_return_time = 'NONE';
						}				
					}
				} else {
					$old_depart_status = '';
					$old_return_status = '';
					$old_depart_port = '';
					$old_depart_date = '';
					$old_depart_time = '';
					$old_return_time = '';
					$old_return_date = '';
					$old_return_port = '';
					$old_vehicles = array();
					$old_drivers = '';
					$old_adults = '';
					$old_children = '';
					$old_infants = '';
				}
				//compare old vehicles with new vehicles
				$old_depart_value = 0;
				$old_vehicles_match = 0;
				$depart_vehicles_match = 0;
				$return_vehicles_match = 0;

				if(count($old_vehicles)>0){
					foreach ($old_vehicles as $key => $value) {
						$old_vehicles_match += $value['item_id'];
					}
				} else { //foot passenger
					$old_vehicles_match = 19;
				}

				if($new_depart_vehicles != 'Passenger'){
					foreach ($new_depart_vehicles as $key => $value) {
						$depart_vehicles_match += $value['item_id'];
					}					
				} else {
					$depart_vehicles_match = 19;
				}
				
				if($new_return_vehicles != 'Passenger'){
					foreach ($new_return_vehicles as $key => $value) {
						$return_vehicles_match += $value['item_id'];
					}					
				} else {
					$return_vehicles_match = 19;
				}
				
				//compare the old data with the new data
				if($old_depart_port == $new_depart_port){
					$depart_port_match = 'Yes';
				} else {
					$depart_port_match = 'No';
				}
				if($old_return_port == $new_return_port){
					
					$return_port_match = 'Yes';
				} else {
					$return_port_match = 'No';
				}
	
				if($old_depart_date == $new_depart_date){
					$depart_date_match = 'Yes';
				} else {
					$depart_date_match = 'No'; 
				}
				if($old_return_date == $new_return_date){
					$return_date_match = 'Yes';
				} else {
					$return_date_match = 'No'; 
				}
				if($old_depart_time == $new_depart_time){
					$depart_time_match = 'Yes';
				} else {
					$depart_time_match = 'No'; 
				}
				if($old_return_time == $new_return_time){
					$return_time_match = 'Yes';
				} else {
					$return_time_match = 'No'; 
				}

				if($depart_vehicles_match  == $old_vehicles_match){
					$depart_vehicles_match = 'Yes';
				} else {
					$depart_vehicles_match = 'No';
				}	
				if($return_vehicles_match == $old_vehicles_match){
					$return_vehicles_match = 'Yes';
				} else {
					$return_vehicles_match = 'No';
				}	
				if($old_drivers == $new_depart_drivers){
					$depart_drivers_match = 'Yes';
				} else {
					$depart_drivers_match = 'No';
				}
				if($old_drivers == $new_return_drivers){
					$return_drivers_match = 'Yes';
				} else {
					$return_drivers_match = 'No';
				}
				if($old_adults == $new_depart_adults){
					$depart_adults_match = 'Yes';
				} else {
					$depart_adults_match = 'No';
				}
				if($old_adults == $new_return_adults){
					$return_adults_match = 'Yes';
				} else {
					$return_adults_match = 'No';
				}
				if($old_children == $new_depart_children){
					$depart_children_match = 'Yes';
				} else {
					$depart_children_match = 'No';
				}
				if($old_children == $new_return_children){
					$return_children_match = 'Yes';
				} else {
					$return_children_match = 'No';
				}
				if($old_infants == $new_depart_infants){
					$depart_infants_match = 'Yes';
				} else {
					$depart_infants_match = 'No';
				}
				if($old_infants == $new_return_infants){
					$return_infants_match = 'Yes';
				} else {
					$return_infants_match = 'No';
				}
				if($old_schedule_id1 == $new_schedule_id1){
					$schedule_id1_match = 'Yes';
				} else {
					$schedule_id1_match = 'No';
				}
				if($old_schedule_id2 == $new_schedule_id2){
					$schedule_id2_match = 'Yes';
				} else {
					$schedule_id2_match = 'No';
				}		
				//determine if inventory has changed between trips
				switch($trip_type){
					case 'roundtrip':
						$vehicles_check = $depart_vehicles_match - $return_vehicles_match;
						$drivers_check = $new_depart_drivers - $new_return_drivers;
						$adults_check = $new_depart_adults - $new_return_adults;
						$children_check = $new_depart_children - $new_return_children;
						$infant_check = $new_depart_infants - $new_return_infants;
						$total_check = $vehicles_check + $drivers_check + $adults_check + $children_check + $infant_check;
						
						if($total_check != 0){
							$inventory_change = 'Yes';
						} else {
							$inventory_change = 'No';
						}
						
					break;
						
					default:
						$inventory_change = 'No';
					break;
				}		
	
				$new_data['Ferry_reservation'][$ferry_id] = array(
					'trip_type'=>$trip_type,
					'subtotal'=>$old_subtotal,
					'ferry_fee'=>$ferry_fee,
					'old_depart_status'=>$old_depart_status,
					'old_return_status'=>$old_return_status,
					'schedule_id1_match'=>$schedule_id1_match,
					'old_schedule_id1'=>$old_schedule_id1,
					'new_schedule_id1'=>$new_schedule_id1,
					'schedule_id2_match'=>$schedule_id2_match,
					'old_schedule_id2'=>$old_schedule_id2,
					'new_schedule_id2'=>$new_schedule_id2,
					'depart_port_match'=>$depart_port_match,
					'old_depart_port'=>$old_depart_port,
					'new_depart_port'=>$new_depart_port,
					'depart_date_match'=>$depart_date_match,
					'old_depart_date'=>$old_depart_date,
					'new_depart_date'=>$new_depart_date,
					'depart_time_match'=>$depart_time_match,
					'old_depart_time'=>$old_depart_time,
					'new_depart_time'=>$new_depart_time,
					'depart_vehicles_match'=>$depart_vehicles_match,
					'old_depart_vehicles'=>$old_vehicles,
					'new_depart_vehicles'=>$new_depart_vehicles,
					'depart_drivers_match'=>$depart_drivers_match,
					'old_depart_drivers'=>$old_drivers,
					'new_depart_drivers'=>$new_depart_drivers,
					'depart_adults_match'=>$depart_adults_match,
					'old_depart_adults'=>$old_adults,
					'new_depart_adults'=>$new_depart_adults,
					'depart_children_match'=>$depart_children_match,
					'old_depart_children'=>$old_children,
					'new_depart_children'=>$new_depart_children,
					'depart_infants_match'=>$depart_infants_match,
					'old_depart_infants'=>$old_infants,
					'new_depart_infants'=>$new_depart_infants,
					'return_port_match'=>$return_port_match,
					'old_return_port'=>$old_return_port,
					'new_return_port'=>$new_return_port,
					'return_date_match'=>$return_date_match,
					'old_return_date'=>$old_return_date,
					'new_return_date'=>$new_return_date,
					'return_time_match'=>$return_time_match,
					'old_return_time'=>$old_return_time,
					'new_return_time'=>$new_return_time,
					'return_vehicles_match'=>$return_vehicles_match,
					'old_return_vehicles'=>$old_vehicles,
					'new_return_vehicles'=>$new_return_vehicles,
					'return_drivers_match'=>$return_drivers_match,
					'old_return_drivers'=>$old_drivers,
					'new_return_drivers'=>$new_return_drivers,
					'return_adults_match'=>$return_adults_match,
					'old_return_adults'=>$old_adults,
					'new_return_adults'=>$new_return_adults,
					'return_children_match'=>$return_children_match,
					'old_return_children'=>$old_children,
					'new_return_children'=>$new_return_children,
					'return_infants_match'=>$return_infants_match,
					'old_return_infants'=>$old_infants,
					'new_return_infants'=>$new_return_infants,
					'inventory_change'=>$inventory_change
					
				);
				
				
		
			}
		
		}

		return $new_data;
	}




/**
 * Cancel Hotel Reservation
 * 
 * @return string;
 */
	public function cancelHotel($data)
	{
		$reference = $data['reference'];
		$id = $data['id'];
		$reservation_id = $data['reservation_id'];
		$hotel_id = $data['hotel_id'];
		$room_id = $data['room_id'];
		$hotel_confirmation = $data['hotel_confirmation'];
		$status = $data['status'];
		
			
		$change = array();
		switch ($status) {
			case '1':
				
				break;
			case '2':
				
				break;
				
			case '3': //cancel + no refund
				$change['Hotel_reservation']['status'] = $status; 
				break;
			
			case '4': // cancel + refund
				$change['Hotel_reservation']['status'] = $status;
				$refund = $data['Refund']['amount'];
				//payment refund scripts go here
				break;
			
			default:
				$refund = $data['Refund']['amount'];
				
				//refund scripts go here
				break;
		}
		
		ClassRegistry::init('Hotel_reservation')->id = $id;
		ClassRegistry::init('Hotel_reservation')->save($change);
	} 
	
	public function cancelHotelAll($confirm, $status)
	{
		$change = array();
		$hotels = ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('confirmation'=>$confirm)));
		if(count($hotels)>0){
			foreach ($hotels as $h) {
				$id = $h['Hotel_reservation']['id'];
				$paid = $h['Hotel_reservation']['paid'];
				
				switch ($status) {
					case '1':
						
						break;
					case '2':
						
						break;
						
					case '3': //cancel + no refund
						$change['Hotel_reservation']['status'] = $status; 
						break;
					
					case '4': // cancel + refund
						$change['Hotel_reservation']['status'] = $status;
						$refund = $paid;
						//payment refund scripts go here
						break;
					
					default:
						$refund = $paid;
						
						//refund scripts go here
						break;
				}
				ClassRegistry::init('Hotel_reservation')->id = $id;
				ClassRegistry::init('Hotel_reservation')->save($change);					
			}
		}
	}	
	
/**
 * Cancel Attraction Reservation
 * 
 * @return string;
 */
	public function cancelAttraction($data)
	{
		$reference = $data['reference'];
		$id = $data['attraction_reservation_id'];
		$tour_id = $data['tour_id'];
		$status = $data['status'];
		$change = array();
		switch ($status) {
			case '1':
				
				break;
			case '2':
				
				break;
				
			case '3': //cancel + no refund
				$change['status'] = $status; 
				break;
			
			case '4': // cancel + refund
				$change['status'] = $status;
				$refund = $data['Refund']['amount'];
				//payment refund scripts go here
				break;
			
			default:
				$refund = $data['Refund']['amount'];
				
				//refund scripts go here
				break;
		}		

		ClassRegistry::init('Attraction_reservation')->id = $id;
		ClassRegistry::init('Attraction_reservation')->save($change);		
	} 

	public function cancelAttractionAll($confirm, $status)
	{

		$change = array();
		$attractions = ClassRegistry::init('Attraction_reservation')->find('all',array('conditions'=>array('confirmation'=>$confirm)));
		if(count($attractions)>0){
			foreach ($attractions as $a) {
				$id = $a['Attraction_reservation']['id'];
				$paid = $a['Attraction_reservation']['paid'];
				
				switch ($status) {
					case '1':
						
						break;
					case '2':
						
						break;
						
					case '3': //cancel + no refund
						$change['Attraction_reservation']['status'] = $status; 
						break;
					
					case '4': // cancel + refund
						$change['Attraction_reservation']['status'] = $status;
						$refund = $paid;
						//payment refund scripts go here
						break;
					
					default:
						$refund = $paid;
						
						//refund scripts go here
						break;
				}
				ClassRegistry::init('Attraction_reservation')->id = $id;
				ClassRegistry::init('Attraction_reservation')->save($change);					
			}
		}		
	}
/**
 * Cancel Package Reservation
 * 
 * @return string;
 */
	public function cancelPackage($data)
	{
		
	} 
	
	public function suggestedFerry($ferry, $hotel, $attractions)
	{
		$count_hotel = count($hotel);
		$count_attraction = count($attractions);
		$suggested_ferry = array();
		if($count_hotel >0 && $count_attraction == 0){

			//find where the hotel is located, check in date, and checkout date
			
			$idx = -1;
			foreach ($hotel as $h) { //loop through to get the check in and check out date
				$idx++;
				$check_in = $h['start'];
				$check_out = $h['end'];
				$country = $h['country'];
				switch($country){
					case '1': //this is a us hotel
						$depart_port = 'Port Angeles';
						$return_port = 'Victoria';
					break;
					
					case '2': //this is a canadian hotel
						$depart_port = 'Victoria';
						$return_port = 'Port Angeles';
					break;
				}	

				$suggested_ferry[$idx] = array(
					'start' => 	$check_in,
					'end'	=>	$check_out,
					'depart_port'=>$depart_port,
					'return_port'=>$return_port
				);			
			}				

		} elseif($count_hotel ==0 && $count_attraction >0){

			//find where the hotel is located, check in date, and checkout date
			$suggested_ferry = array();
			$idx = -1;
			foreach ($attractions as $a) { //loop through to get the check in and check out date
				$idx++;
				$start = $a['start'];
				$end = $start;
// 				
				// switch($country){
					// case '1': //this is a us hotel
						// $depart_port = 'Port Angeles';
						// $return_port = 'Victoria';
					// break;
// 					
					// case '2': //this is a canadian hotel
						// $depart_port = 'Victoria';
						// $return_port = 'Port Angeles';
					// break;
				// }	
				$suggested_ferry[$idx] = array(
					'start' => 	$start,
					'end'	=>	$end,
					//'depart_port'=>$depart_port,
					//'return_port'=>$return_port
				);			
			}				
		} 
		return $suggested_ferry;
	}
	public function suggestedHotel($ferry, $hotel, $attraction)
	{
		$count_ferry = count($ferry);
		$suggested_hotels = array();
		
		if($count_ferry > 0){
			foreach ($ferry as $f) {
					
				$depart_date = $f['depart_full_date'];
				//debug($f['return_full_date']);
				if ($f['return_full_date'] == "") { $return_date = date('Y-m-d H:i:s',strtotime($depart_date) + 86400); } else {
				$return_date = $f['return_full_date']; }
				
				$depart_port = $f['depart_port'];

				//debug($_SESSION['Reservation_dates']);

				$_SESSION['Reservation_dates'] = array(
					'return_date'=> date('n/d/Y',strtotime($return_date)),
					'depart_date'=> date('n/d/Y',strtotime($depart_date))
				);			

				switch($depart_port){
					case 'Port Angeles':
						$location = 'Victoria';
						
					break;
						
					case 'Victoria':
						$location = 'Olympic Peninsula';
					break;
				}
			}	
			
			$get = ClassRegistry::init('Hotel')->find('all',array('conditions'=>array('location'=>$location,'status'=>'6'),'order'=>'RAND()','limit'=>'0,3'));
			if(count($get)>0){
				foreach ($get as $key => $value) {
					$hotel_id = $get[$key]['Hotel']['id'];
					$name = $get[$key]['Hotel']['name'];
					$desc = $get[$key]['Hotel']['hotel_description'];
					$class = $get[$key]['Hotel']['class'];
					$location = $get[$key]['Hotel']['location'];
					$city = $get[$key]['Hotel']['city'];
					$state = $get[$key]['Hotel']['state'];
					$url = $get[$key]['Hotel']['url'];
					$starting_price = $get[$key]['Hotel']['starting_price'];
					$image_address = '/img/hotels/'.$get[$key]['Hotel']['image_main'];
					$suggested_hotels[$hotel_id] = array(
						'hotel_id'=>$hotel_id,
						'name'=>$name,
						'url'=>$url,
						'description'=>$desc,
						'location'=>$location,
						'city'=>$city,
						'state'=>$state,
						'class'=>$class,
						'starting_price'=>$starting_price,
						'image'=>$image_address
						
					);
				}
			}
			
			
		} 
		
		return $suggested_hotels;
	}
	public function suggestedAttraction($ferry, $hotel, $attraction)
	{
		$count_ferry = count($ferry);
		$count_hotel = count($hotel);
		$suggested_attractions = array();
		if($count_ferry >0 ){
			foreach ($ferry as $f) {
				$depart_date = $f['depart_full_date'];
				$return_date = $f['return_full_date'];
				$depart_port = $f['depart_port'];
				switch($depart_port){
					case 'Port Angeles':
						$country = '2';
						
					break;
						
					case 'Victoria':
						$country = '1';
					break;
				}
			}	
			
				if ($country == 2) {
					$get_attractions1 = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('name'=>'The Butchart Gardens')));
					$get_attractions2 = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('country'=>$country),'order'=>'RAND()', 'limit'=>'0,2'));
					$get_attractions = array_merge($get_attractions1,$get_attractions2);
					//debug($get_attractions);
				} else {$get_attractions = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('country'=>$country),'order'=>'RAND()'));}
				
				foreach ($get_attractions as $key => $value) {
				$tickets = $get_attractions[$key]['AttractionTicket'];

				foreach ($tickets as $t) {
					$attraction_id = $t['attraction_id'];
					$inventory = json_decode($t['inventory'],true);
					if(count($inventory)>0){
						foreach ($inventory as $ikey => $ivalue) {
							$start_date = $inventory[$ikey]['start_date'];
							$end_date = $inventory[$ikey]['end_date'];
							
							if(strtotime($depart_date) >=$start_date && strtotime($depart_date) <= $end_date){
								
								$get = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('id'=>$attraction_id)));
								foreach ($get as $key => $value) {
									$name = $get[$key]['Attraction']['name'];
									$desc = $get[$key]['Attraction']['description'];
									$location = $get[$key]['Attraction']['location'];
									$url = $get[$key]['Attraction']['url'];
									$city = $get[$key]['Attraction']['city'];
									$state = $get[$key]['Attraction']['state'];
									$starting_price = $get[$key]['Attraction']['starting_price'];
									$image_address = '/img/attractions/'.$get[$key]['Attraction']['image_main'];
									$suggested_attractions[$attraction_id] = array(
										'name'=>$name,
										'description'=>$desc,
										'location'=>$location,
										'url'=>$url,
										'city'=>$city,
										'state'=>$state,
										'starting_price'=>$starting_price,
										'image'=>$image_address,
									);
								}

							}
						}
					}

				}
			}

			
		} else {
			foreach ($hotel as $h) { //loop through to get the check in and check out date
				$check_in = $h['start'];
				$check_out = $h['end'];
				$country = $h['country'];

				if ($country == 2) {
					$get_attractions1 = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('name'=>'The Butchart Gardens')));
					$get_attractions2 = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('country'=>$country),'order'=>'RAND()', 'limit'=>'0,2'));
					$get_attractions = array_merge($get_attractions1,$get_attractions2);
					//debug($get_attractions);
				} else {$get_attractions = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('country'=>$country),'order'=>'RAND()'));}
				
				foreach ($get_attractions as $key => $value) {
					$tickets = $get_attractions[$key]['AttractionTicket'];

					foreach ($tickets as $t) {
						$attraction_id = $t['attraction_id'];
						$inventory = json_decode($t['inventory'],true);
						if(count($inventory)>0){

							foreach ($inventory as $ikey => $ivalue) {
								$start_date = $inventory[$ikey]['start_date'];
								$end_date = $inventory[$ikey]['end_date'];
								
								if($check_in >=$start_date && $check_in <= $end_date){
									
									$get = ClassRegistry::init('Attraction')->find('all',array('conditions'=>array('id'=>$attraction_id)));
										
										
												
									foreach ($get as $key => $value) {
										$name = $get[$key]['Attraction']['name'];
										$desc = $get[$key]['Attraction']['description'];
										$location = $get[$key]['Attraction']['location'];
										$url = $get[$key]['Attraction']['url'];
										$city = $get[$key]['Attraction']['city'];
										$state = $get[$key]['Attraction']['state'];
										$starting_price = $get[$key]['Attraction']['starting_price'];
										$image_address = '/img/attractions/'.$get[$key]['Attraction']['image_main'];
										$suggested_attractions[$attraction_id] = array(
											'name'=>$name,
											'description'=>$desc,
											'location'=>$location,
											'url'=>$url,
											'city'=>$city,
											'state'=>$state,
											'starting_price'=>$starting_price,
											'image'=>$image_address,
										);
										
									}
									
									
	
								}
							}
						}
	
					}
				}
			
			}							
		} 
		

		//debug($suggested_attractions);
		
		return $suggested_attractions = array_slice($suggested_attractions,0,3);
		
	}

	public function trim_phone($data)
	{
		$phone = preg_replace(array(
			    "/[^a-zA-Z0-9\s]/", // remove all non-space, non-alphanumeric characters
			    '/\s{2,}/', // replace multiple white space occurrences with single 
			), array('',' ',), 
			trim($data)
		);
		return $phone;
	}
	public function viewConfirmEditFerrySummary($data)
	{
		$summary = array();
		if(count($data['Ferry_reservation'])>0){
			foreach ($data['Ferry_reservation'] as $fkey => $fvalue) {
				
			}
		}
		
		return $summary;
	}
	
	public function redoEmailFerrySession($reservation_id)
	{
		$ferry_session = array();
		
		//first check if package exists
		$packages = ClassRegistry::init('Package_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		$count_packages = count($packages);
		
		$fdx = -1;
		
		if($count_packages >0){
			foreach ($packages as $p ) {
				$ferry_id = $p['Package_reservation']['ferry_reservation_id'];
			}			
			
			$ferry = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id,'id !='=>$ferry_id)));
		} else {

			
			$ferry = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		}
		if(count($ferry)>0){
			foreach ($ferry as $f) {
				$fdx++;
				$vehicle_count = $f['Ferry_reservation']['vehicle_count'];
				$vehicles = json_decode($f['Ferry_reservation']['vehicles'],true);
				
				$drivers = $f['Ferry_reservation']['drivers'];
				$adults = $f['Ferry_reservation']['adults'];
				$children = $f['Ferry_reservation']['children'];
				$infants= $f['Ferry_reservation']['infants'];
				$trip_type = $f['Ferry_reservation']['trip_type'];
				$depart_port = $f['Ferry_reservation']['depart_port'];
				$depart_date = $f['Ferry_reservation']['depart_date'];
				$return_date = $f['Ferry_reservation']['return_date'];
				$schedule_id1 = $f["Ferry_reservation"]['schedule_id1'];
				$schedule_id2 = $f['Ferry_reservation']['schedule_id2'];
				$inventory_id = $f['Ferry_reservation']['inventory_id'];
				
				$ferry_session['Reservation'][$fdx] = array(
					'vehicle_count'=>$vehicle_count,
					'vehicle'=>$vehicles,
					'drivers'=>$drivers,
					'adults'=>$adults,
					'children'=>$children,
					'infants'=>$infants,
					'trip_type'=>$trip_type,
					'depart_port'=>$depart_port,
					'departs'=>$depart_date,
					'returns'=>$return_date,
					'schedule_id1'=>$schedule_id1,
					'schedule_id2'=>$schedule_id2,
					'inventory_id'=>$inventory_id						
				);
			}
		}			
		return $ferry_session;
		
		
	}
	public function redoEmailPackageFerrySession($id)
	{
		$ferry_session = array();
		$fdx = -1;
		$ferry = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('id'=>$id)));
		$vehicles = array();
		if(count($ferry)>0){
			foreach ($ferry as $f) {
				$fdx++;
				$vehicle_count = $f['Ferry_reservation']['vehicle_count'];
				$vehicles = json_decode($f['Ferry_reservation']['vehicles'],true);
				$drivers = $f['Ferry_reservation']['drivers'];
				$adults = $f['Ferry_reservation']['adults'];
				$children = $f['Ferry_reservation']['children'];
				$infants= $f['Ferry_reservation']['infants'];
				$trip_type = $f['Ferry_reservation']['trip_type'];
				$depart_port = $f['Ferry_reservation']['depart_port'];
				$depart_date = $f['Ferry_reservation']['depart_date'];
				$return_date = $f['Ferry_reservation']['return_date'];
				$schedule_id1 = $f["Ferry_reservation"]['schedule_id1'];
				$schedule_id2 = $f['Ferry_reservation']['schedule_id2'];
				$inventory_id = $f['Ferry_reservation']['inventory_id'];
			
				$ferry_session['Reservation'][$fdx] = array(
					'vehicle_count'=>$vehicle_count,
					'vehicle'=>$vehicles,
					'drivers'=>$drivers,
					'adults'=>$adults,
					'children'=>$children,
					'infants'=>$infants,
					'trip_type'=>$trip_type,
					'depart_port'=>$depart_port,
					'departs'=>$depart_date,
					'returns'=>$return_date,
					'schedule_id1'=>$schedule_id1,
					'schedule_id2'=>$schedule_id2,
					'inventory_id'=>$inventory_id						
				);
			}
		}
		return $ferry_session;
		
	}	

	public function redoEmailHotelSession($reservation_id)
	{
		//first check if package exists
		$packages = ClassRegistry::init('Package_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		$count_packages = count($packages);
		$hotel_session = array();
		$hdx = -1;
		
		if($count_packages >0){
			foreach ($packages as $p ) {
				$hotel_id = $p['Package_reservation']['hotel_reservation_id'];
			}			
			
			$hotel = ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id,'id !='=>$hotel_id)));
		} else {

			
			$hotel = ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		}

		if(count($hotel)>0){
			foreach ($hotel as $h) {
				$hdx++;
				$hotel_id = $h['Hotel_reservation']['hotel_id'];
				$room_id = $h['Hotel_reservation']['room_id'];
				$start = strtotime($h['Hotel_reservation']['check_in']);
				$end =strtotime($h['Hotel_reservation']['check_out']);
				$rooms = $h['Hotel_reservation']['rooms'];
				$adults = $h['Hotel_reservation']['adults'];
				$children = $h['Hotel_reservation']['children'];
				$total = $h['Hotel_reservation']['paid'];
				
				$hotel_session[$hdx] = array(
					'hotel_id'=>$hotel_id,
					'room_id'=>$room_id,
					'start'=>$start,
					'end'=>$end,
					'rooms'=>$rooms,
					'adults'=>$adults,
					'children'=>$children,
					'total'=>$total				
				);
			}
		}	
		
		return $hotel_session;				
	}
	public function redoEmailHotelSessionById($id)
	{
		//first check if package exists
		$hotel_session = array();
		$hdx = -1;
		
		$hotel = ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('id'=>$id)));

		if(count($hotel)>0){
			foreach ($hotel as $h) {
				$hdx++;
				$hotel_id = $h['Hotel_reservation']['hotel_id'];
				$room_id = $h['Hotel_reservation']['room_id'];
				$start = strtotime($h['Hotel_reservation']['check_in']);
				$end =strtotime($h['Hotel_reservation']['check_out']);
				$rooms = $h['Hotel_reservation']['rooms'];
				$adults = $h['Hotel_reservation']['adults'];
				$children = $h['Hotel_reservation']['children'];
				$total = $h['Hotel_reservation']['paid'];
				
				$hotel_session[$hdx] = array(
					'hotel_id'=>$hotel_id,
					'room_id'=>$room_id,
					'start'=>$start,
					'end'=>$end,
					'rooms'=>$rooms,
					'adults'=>$adults,
					'children'=>$children,
					'total'=>$total				
				);
			}
		}	
		
		return $hotel_session;				
	}
	public function redoEmailPackageHotelSession($id)
	{
		$hotel_session = array();
		$hdx = -1;
		$hotel= ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('id'=>$id)));
		if(count($hotel)>0){
			foreach ($hotel as $h) {
				$hdx++;
				$hotel_id = $h['Hotel_reservation']['hotel_id'];
				$room_id = $h['Hotel_reservation']['room_id'];
				$start = strtotime($h['Hotel_reservation']['check_in']);
				$end =strtotime($h['Hotel_reservation']['check_out']);
				$rooms = $h['Hotel_reservation']['rooms'];
				$adults = $h['Hotel_reservation']['adults'];
				$children = $h['Hotel_reservation']['children'];
				$total = $h['Hotel_reservation']['paid'];
				
				$hotel_session[$hdx] = array(
					'hotel_id'=>$hotel_id,
					'room_id'=>$room_id,
					'start'=>$start,
					'end'=>$end,
					'rooms'=>$rooms,
					'adults'=>$adults,
					'children'=>$children,

					'total'=>$total				
				);
			}
		}	
		
		return $hotel_session;				
	}
	
	public function redoEmailAttractionSession($reservation_id)
	{
		
		//first check if package exists
		$packages = ClassRegistry::init('Package_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		$count_packages = count($packages);
		
		$hdx = -1;
		$attraction_session = array();
		if($count_packages >0){
			foreach ($packages as $p ) {
				$attraction_id = $p['Package_reservation']['attraction_reservation_id'];
			}			
			
			$attraction = ClassRegistry::init('Attraction_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id,'id !='=>$attraction_id)));
		} else {

			
			$attraction = ClassRegistry::init('Attraction_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		}


		if(count($attraction)>0){
			foreach ($attraction as $a) {
				$adx++;
				$attraction_id = $a['Attraction_reservation']['attraction_id'];
				$tour_id = $a['Attraction_reservation']['tour_id'];
				$start = $a['Attraction_reservation']['reserved_date'];
				$time = $a['Attraction_reservation']['time'];
				$purchase_info = json_decode($a['Attraction_reservation']['age_range'],true);
				$attraction_session[$adx] = array(
					'attraction_id'=>$attraction_id,
					'tour_id'=>$tour_id,
					'date'=>false,
					'start'=>strtotime($start),
					'time'=>$time,
					'purchase_info'=>$purchase_info
	
				);
			}
		}	
		
		return $attraction_session;		
	}
	public function redoEmailPackageAttractionSession($id)
	{
		$attraction_session = array();
		$adx = -1;
		$attraction= ClassRegistry::init('Attraction_reservation')->find('all',array('conditions'=>array('id'=>$id)));
		if(count($attraction)>0){
			foreach ($attraction as $a) {
				$adx++;
				$attraction_id = $a['Attraction_reservation']['attraction_id'];
				$tour_id = $a['Attraction_reservation']['tour_id'];
				$start = $a['Attraction_reservation']['reserved_date'];
				$time = $a['Attraction_reservation']['time'];
				$purchase_info = json_decode($a['Attraction_reservation']['age_range'],true);
				$attraction_session[$adx] = array(
					'attraction_id'=>$attraction_id,
					'tour_id'=>$tour_id,
					'date'=>false,
					'start'=>strtotime($start),
					'time'=>$time,
					'purchase_info'=>$purchase_info
	
				);
			}
		}	
		
		return $attraction_session;		
	}	
	public function redoEmailPackageSession($reservation_id)
	{
		$package_session = array();
		$package_array = array();
		$pdx = -1;
		$package = ClassRegistry::init('Package_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
		if(count($package)>0){
			foreach ($package as $p) {
				$pdx++;
				$package_id = $p['Package_reservation']['package_id'];
				$package_search = ClassRegistry::init('Package')->find('all',array('conditions'=>array('id'=>$package_id)));
				if(count($package_search)>0){
					foreach ($package_search as $ps) {
						$package_name = $ps['Package']['name'];
						$package_base = $ps['Package']['rtVehicle'];
						
					}
				}
				$ferry_id = $p['Package_reservation']['ferry_reservation_id'];
				$hotel_id = $p['Package_reservation']['hotel_reservation_id'];
				$attraction_id = $p['Package_reservation']['attraction_reservation_id'];
				$package_paid =$p['Package_reservation']['amount_paid'];
				
				$package_array[$package_id] = array(
					'id'=>$package_id,
					'name'=>$package_name,
					'ferry'=>0,
					'hotel'=>0,
					'attraction'=>0,
					'total'=>$package_paid,
					'base'=>$package_base
				);
				
				$ferry_session = $this->redoEmailPackageFerrySession($ferry_id);
				$hotel_session = $this->redoEmailPackageHotelSession($hotel_id);
				$attraction_session = $this->redoEmailPackageAttractionSession($attraction_id);			
				
				$package_session[$pdx] = array(
					'packages'=>$package_array,
					'ferries'=>$ferry_session,
					'hotels'=>$hotel_session,
					'attractions'=>$attraction_session
				);
				
				
				
			}
		}

		return $package_session;
					
	}
	
	public function format_phone($phone)
	{
	    $phone = preg_replace("/[^0-9]/", "", $phone);
	
	    if(strlen($phone) == 7){
	    	return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
	    } elseif(strlen($phone) == 10){
	    	return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
	    } else {
	    	$phone_number = '+'.substr($phone,0,1);
			$phone_number .= ' ('.substr($phone,1,3).') ';
			$phone_number .= substr($phone,4,3).'-';
			$phone_number .= substr($phone,-4,4);
	    	return $phone_number;
	    }

	}

}