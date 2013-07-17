<?php


/**
 * app/Model/Admin.php
 */
class Admin extends AppModel {
    public $name = 'Admin';
    //Models

    

    //get ferry total sale count 
    public function ferry_count($data)
    {
    	$count = 0;
		if(count($data)>0){
			foreach ($data as $f) {
				$reservation_id = $f['Reservation']['id'];
				
				//get ferry count based on reservation totals
				$ferries = ClassRegistry::init('Ferry_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
				if(count($ferries)>0){
					foreach ($ferries as $fr) {
						$trip_type = $fr['Ferry_reservation']['trip_type'];
						switch ($trip_type) {
							case 'oneway': //oneway trip = 1 trip
								$count = $count + 1;
								break;
							
							default: //roundtrip = 2 trips
								$count = $count + 2;
								break;
						}
					}
				}
			}
		}
		
		
		return $count;
    }
	
	public function hotel_count($data)
	{
    	$count = 0;
		if(count($data)>0){
			foreach ($data as $h) {
				$reservation_id = $h['Reservation']['id'];
				$hotels = ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
				if(count($hotels)>0){
					foreach ($hotels as $hr) {
						$count = $count + 1;
					}
				}
			}
		}		
		
		
		return $count;		
	}
	
	public function attraction_count($data)
	{
    	$count = 0;
		if(count($data)>0){
			foreach ($data as $a) {
				$reservation_id = $a['Reservation']['id'];
				
				$attractions = ClassRegistry::init('Attraction_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
				if(count($attractions)>0){
					foreach ($attractions as $ar) {
						$count = $count +1;
					}
				}
			}
		}		
		
		
		return $count;		
	}
	
	
	//returns the total package count not individual counts within.
	public function package_count($data)
	{
    	$count = 0;
		if(count($data)>0){
			foreach ($data as $p) {
				$reservation_id = $p['Reservation']['id'];
				$packages = ClassRegistry::init('Package_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
				if(count($packages)>0){
					foreach ($packages as $pr) {
						$count = $count + 1;
					}
				}
			}
		}		

		return $count;		
	}
	
	
	//returns an array of week start and end times
	function returnWeekDates()
	{
		$return = array();
		$today = strtotime(date('Y-m-d H:i:s'));
		$start = strtotime(date('Y-m-d',strtotime('Last Sunday', $today)).' 00:00:00');
		
		for ($i=0; $i <= 6; $i++) { 
			$next_day = $start+($i * 86400);
			$return[$i] = array(
				'start'=>date('Y-m-d',$next_day).' 00:00:00',
				'end'=>date('Y-m-d',$next_day).' 23:59:59'
				
			);
		}
		
		return $return;
	}
	
	public function weekly_count($data)
	{
		$week = array();
		foreach ($data as $key =>$value) {
			$start = $data[$key]['start'];
			$end = $data[$key]['end'];
			
			$reservation_today = ClassRegistry::init('Reservation')->find('all',array('conditions'=>array('Reservation.created BETWEEN ? AND ?'=>array($start, $end))));
			$ferry_today = $this->ferry_count($reservation_today);
			$hotel_today = $this->hotel_count($reservation_today);
			$attraction_today = $this->attraction_count($reservation_today);
			$package_today = $this->package_count($reservation_today);	
			$week[$key]	= array(
				'ferry_count' => $ferry_today,
				'hotel_count' => $hotel_today,
				'attraction_count'=>$attraction_today,
				'package_count'=>$package_today
			);
			
		}

		return $week;
	}

}


?>