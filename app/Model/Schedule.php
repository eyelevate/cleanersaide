<?php 

/**
 * app/Model/Schedule.php
 */
class Schedule extends AppModel {
    public $name = 'Schedule';

	public function create_pickup_schedule($data,$company_id, $month,$year)
	{
		$first_dom = $year.'-'.$month.'-01 00:00:00';
		$first_dom_string = strtotime($first_dom);
		$last_dom = date('Y-m-t',$first_dom_string).' 00:00:00';
		$last_dom_string = strtotime($last_dom);
		//first restructure the array to fit a schedule array
		$schedule = array();
		$blackouts = array();
		$time = array();
		$days = array();
		$idx = -1;
		if(count($data)>0){
			foreach ($data as $key => $value) {
				$idx++;
				$id = $data[$key]['id'];
				$day = $data[$key]['day'];
				$blackout = $data[$key]['blackouts'];
				foreach ($blackout as $bkey => $bvalue) {
					$blackouts[strtotime($bvalue)] = $bvalue; 
				}
				$schedule[$day][$idx] = $value; 
			}
		}
		
		
		foreach ($schedule as $skey => $svalue) { //loop through first key
			for ($i=$first_dom_string; $i <= $last_dom_string; $i+=86400) { //loop through month
				$dow = date('l',$i);			
				if($dow == $skey){ //if day of week matches the key from array then run this script
					foreach ($schedule[$skey] as $sskey => $ssvalue) { //loop through next dimension of array
						$delivery_id = $schedule[$skey][$sskey]['id'];

						$blackouts = $schedule[$skey][$sskey]['blackouts'];
						foreach ($blackouts as $bkey => $bvalue) { //loop through the blackout dates
							if($i != strtotime($bvalue)){ //if blackout dates do not exist for this day then add to the array
								$find_dropoff = $this->find('all',array('conditions'=>array('dropoff_delivery_id'=>$delivery_id,'company_id'=>$company_id,'dropoff_date'=>date('Y-m-d H:i:s',$i))));
								$find_pickup = $this->find('all',array('conditions'=>array('pickup_delivery_id'=>$delivery_id,'company_id'=>$company_id,'pickup_date'=>date('Y-m-d H:i:s',$i))));
								$delivery_limit = count($find_dropoff) + count($find_pickup); //adds the sum count of all delivery and pickup with the specified date and id
								
								$schedule[$skey][$sskey]['service_days'][$i]['date'] = date('Y-m-d H:i:s',$i);
								$schedule[$skey][$sskey]['service_days'][$i]['limit'] = $delivery_limit;
							
							}
						}
					}
				}
			}
		}

		$final = array();
		foreach ($schedule as $skey => $svalue) {
			foreach ($schedule[$skey] as $sskey => $ssvalue) {
				$delivery_id = $schedule[$skey][$sskey]['id'];
				$start = $schedule[$skey][$sskey]['start'];
				$end = $schedule[$skey][$sskey]['end'];
				$delivery_max_limit = $schedule[$skey][$sskey]['limit'];
				$service_days = $schedule[$skey][$sskey]['service_days'];
				foreach ($service_days as $sdkey => $sdvalue) {
					$date = $service_days[$sdkey]['date'];
					$limit = $service_days[$sdkey]['limit'];
					$final[$sdkey][$start.'-'.$end]['id'] = $delivery_id;
					$final[$sdkey][$start.'-'.$end]['date'] =$date;
					$final[$sdkey][$start.'-'.$end]['limit'] = $limit; 
					$final[$sdkey][$start.'-'.$end]['max'] = $delivery_max_limit;
				}
			}
		}
		
		ksort($final);

		
		return $final;
	
		
		//set the final array to display	

	}

	public function create_dropoff_schedule($data,$company_id, $month,$year, $date, $time)
	{
		//set first available day make it a 90 day range
		$date_zero_hour = strtotime(date('Y-m-d',$date).' 00:00:00');
		$day_of_week = date('w',$date_zero_hour);
		//get dropoff schedule
		
		//set days
		switch($day_of_week){
			case '0': //sunday
				$day_due = $date_zero_hour + (86400 * 3); //wed
			break;
			case '1': //monday
				$day_due = $date_zero_hour + (86400 * 2); //wed
			break;
			case '2': //tuesday
				$day_due = $date_zero_hour + (86400 * 2); //thur
			break;
			case '3': //wednesday
				$day_due = $date_zero_hour + (86400 * 2); //fri
			break;
			case '4': //thursday
				$day_due = $date_zero_hour + (86400 * 4); //mon
			break;
			case '5': //friday
				$day_due = $date_zero_hour + (86400 * 4); //tues
			break;
			case '6': //saturday
				$day_due = $date_zero_hour + (86400 * 4); //wed
			break;
		}
		
		$day_last = $day_due + (86400 * 90);

		
		$first_dom = $year.'-'.$month.'-01 00:00:00';
		$first_dom_string = strtotime($first_dom);
		$last_dom = date('Y-m-t',$first_dom_string).' 00:00:00';
		$last_dom_string = strtotime($last_dom);
		//first restructure the array to fit a schedule array
		$schedule = array();
		$blackouts = array();
		$time = array();
		$days = array();
		$idx = -1;
		if(count($data)>0){
			foreach ($data as $key => $value) {
				$idx++;
				$id = $data[$key]['id'];
				$day = $data[$key]['day'];
				$blackout = $data[$key]['blackouts'];
				foreach ($blackout as $bkey => $bvalue) {
					$blackouts[strtotime($bvalue)] = $bvalue; 
				}
				$schedule[$day][$idx] = $value; 
			}
		}

		foreach ($schedule as $skey => $svalue) { //loop through first key
			for ($i=$day_due; $i <= $day_last; $i+=86400) { //loop through month
				$dow = date('l',$i);			
				if($dow == $skey){ //if day of week matches the key from array then run this script
					foreach ($schedule[$skey] as $sskey => $ssvalue) { //loop through next dimension of array
						$delivery_id = $schedule[$skey][$sskey]['id'];
						$delivery_start = date('G',strtotime(date('Y-m-d ',$i).$schedule[$skey][$sskey]['start']));
						$blackouts = $schedule[$skey][$sskey]['blackouts'];
						foreach ($blackouts as $bkey => $bvalue) { //loop through the blackout dates
							if($i != strtotime($bvalue)){ //if blackout dates do not exist for this day then add to the array
								$find_dropoff = $this->find('all',array('conditions'=>array('dropoff_delivery_id'=>$delivery_id,'company_id'=>$company_id,'dropoff_date'=>date('Y-m-d H:i:s',$i))));
								$find_pickup = $this->find('all',array('conditions'=>array('pickup_delivery_id'=>$delivery_id,'company_id'=>$company_id,'pickup_date'=>date('Y-m-d H:i:s',$i))));
								$delivery_limit = count($find_dropoff) + count($find_pickup); //adds the sum count of all delivery and pickup with the specified date and id
								
								
								$schedule[$skey][$sskey]['service_days'][$i]['date'] = date('Y-m-d H:i:s',$i);
								$schedule[$skey][$sskey]['service_days'][$i]['limit'] = $delivery_limit;
								$schedule[$skey][$sskey]['service_days'][$i]['time'] = $delivery_start;
							}
						}	

					}
				}
			}
		}

		$final = array();
		foreach ($schedule as $skey => $svalue) {
			foreach ($schedule[$skey] as $sskey => $ssvalue) {
				$delivery_id = $schedule[$skey][$sskey]['id'];
				$start = $schedule[$skey][$sskey]['start'];
				$end = $schedule[$skey][$sskey]['end'];
				$delivery_max_limit = $schedule[$skey][$sskey]['limit'];
				$service_days = $schedule[$skey][$sskey]['service_days'];
				foreach ($service_days as $sdkey => $sdvalue) {
					$date = $service_days[$sdkey]['date'];
					$limit = $service_days[$sdkey]['limit'];
					$time = $service_days[$sdkey]['time'];
					$final[$sdkey][$start.'-'.$end]['id'] = $delivery_id;
					$final[$sdkey][$start.'-'.$end]['date'] =$date;
					$final[$sdkey][$start.'-'.$end]['time'] = $time;
					$final[$sdkey][$start.'-'.$end]['limit'] = $limit; 
					$final[$sdkey][$start.'-'.$end]['max'] = $delivery_max_limit;
				}
			}
		}
		
		ksort($final);

		return $final;
	
		
		//set the final array to display	

	}

	public function setSchedule($pickup, $dropoff)
	{
		$delivery = array();
		if(count($pickup)>0){
			$idx = -1;
			foreach ($pickup as $p) {
				$idx++;
				$customer_id = $p['Schedule']['customer_id'];
				$delivery_id = $p['Schedule']['pickup_delivery_id'];
				$delivery['Pickup'][$idx]['customer_id'] = $customer_id;
				$delivery['Pickup'][$idx]['delivery_id'] = $delivery_id;
				
				$delivery['Pickup'][$idx]['day'] = date('D',strtotime($p['Schedule']['pickup_date']));
				$delivery['Pickup'][$idx]['pickup_date'] = $p['Schedule']['pickup_date'];
				$delivery['Pickup'][$idx]['special_instructions'] = $p['Schedule']['special_instructions'];
				$delivery['Pickup'][$idx]['type'] = $p['Schedule']['type'];
				$delivery['Pickup'][$idx]['status'] = $p['Schedule']['status'];
				//get customer data
				$users = ClassRegistry::init('User')->find('all',array('conditions'=>array('User.id'=>$customer_id,'User.company_id'=>$_SESSION['company_id'])));	
				if(count($users)>0){
					foreach ($users as $u) {
						$delivery['Pickup'][$idx]['first_name'] = $u['User']['first_name'];
						$delivery['Pickup'][$idx]['last_name'] = $u['User']['last_name'];
						$delivery['Pickup'][$idx]['address'] = $u['User']['contact_address'];
						$delivery['Pickup'][$idx]['suite'] = $u['User']['contact_suite'];
						$delivery['Pickup'][$idx]['city'] = $u['User']['contact_city'];
						$delivery['Pickup'][$idx]['state'] = $u['User']['contact_state'];
						$delivery['Pickup'][$idx]['country'] = $u['User']['contact_country'];
						$delivery['Pickup'][$idx]['email'] = $u['User']['contact_email'];
						$delivery['Pickup'][$idx]['zipcode'] = $u['User']['contact_zip'];
						$delivery['Pickup'][$idx]['phone'] = $u['User']['contact_phone'];
						$delivery['Pickup'][$idx]['default_special_instructions'] = $u['User']['special_instructions'];
						$delivery['Pickup'][$idx]['profile_id'] = $u['User']['profile_id'];
						$delivery['Pickup'][$idx]['payment_id'] = $u['User']['payment_id'];
						$delivery['Pickup'][$idx]['token'] = $u['User']['token'];
						$delivery['Pickup'][$idx]['reward_status'] = $u['User']['reward_status'];
						$delivery['Pickup'][$idx]['reward_points'] = $u['User']['reward_points'];
						$delivery['Pickup'][$idx]['starch'] = $u['User']['starch'];
					}
				}	
				//get delivery data
				$deliveries = ClassRegistry::init('Delivery')->find('all',array('conditions'=>array('id'=>$delivery_id)));
				if(count($deliveries)>0){
					foreach ($deliveries as $d) {
						$delivery['Pickup'][$idx]['route_name'] = $d['Delivery']['route_name'];
						$delivery['Pickup'][$idx]['delivery_day'] = $d['Delivery']['day'];
						$delivery['Pickup'][$idx]['limit'] = $d['Delivery']['limit'];
						$delivery['Pickup'][$idx]['start_time'] = $d['Delivery']['start_time'];
						$delivery['Pickup'][$idx]['end_time'] = $d['Delivery']['end_time'];
						if(is_null($d['Delivery']['zipcode'])){
							$delivery['Pickup'][$idx]['delivery_zipcodes'] = '';
						} else {
							$delivery['Pickup'][$idx]['delivery_zipcodes'] = json_decode($d['Delivery']['zipcode'],true);	
						}
						if(is_null($d['Delivery']['blackout'])){
							$delivery['Pickup'][$idx]['delivery_blackouts'] = '';
						} else {
							$delivery['Pickup'][$idx]['delivery_blackouts']= json_decode($d['Delivery']['blackout'],true);	
						}
						$delivery['Pickup'][$idx]['delivery_status'] = $d['Delivery']['status'];						
						
					}
				}				
				
			}	


			$idx = -1;
			foreach ($dropoff as $dp) {
				$idx++;
				$customer_id = $dp['Schedule']['customer_id'];
				$delivery_id = $dp['Schedule']['dropoff_delivery_id'];
				$delivery['Dropoff'][$idx]['customer_id'] = $customer_id;
				$delivery['Dropoff'][$idx]['delivery_id'] = $delivery_id;
				
				$delivery['Dropoff'][$idx]['day'] = date('D',strtotime($p['Schedule']['dropoff_date']));
				$delivery['Dropoff'][$idx]['dropoff_date'] = $p['Schedule']['dropoff_date'];
				$delivery['Dropoff'][$idx]['special_instructions'] = $p['Schedule']['special_instructions'];
				$delivery['Dropoff'][$idx]['type'] = $p['Schedule']['type'];
				$delivery['Dropoff'][$idx]['status'] = $p['Schedule']['status'];
				//get customer data
				$users = ClassRegistry::init('User')->find('all',array('conditions'=>array('User.id'=>$customer_id,'User.company_id'=>$_SESSION['company_id'])));	
				if(count($users)>0){
					foreach ($users as $u) {
						$delivery['Dropoff'][$idx]['first_name'] = $u['User']['first_name'];
						$delivery['Dropoff'][$idx]['last_name'] = $u['User']['last_name'];
						$delivery['Dropoff'][$idx]['address'] = $u['User']['contact_address'];
						$delivery['Dropoff'][$idx]['suite'] = $u['User']['contact_suite'];
						$delivery['Dropoff'][$idx]['city'] = $u['User']['contact_city'];
						$delivery['Dropoff'][$idx]['state'] = $u['User']['contact_state'];
						$delivery['Dropoff'][$idx]['country'] = $u['User']['contact_country'];
						$delivery['Dropoff'][$idx]['email'] = $u['User']['contact_email'];
						$delivery['Dropoff'][$idx]['zipcode'] = $u['User']['contact_zip'];
						$delivery['Dropoff'][$idx]['phone'] = $u['User']['contact_phone'];
						$delivery['Dropoff'][$idx]['default_special_instructions'] = $u['User']['special_instructions'];
						$delivery['Dropoff'][$idx]['profile_id'] = $u['User']['profile_id'];
						$delivery['Dropoff'][$idx]['payment_id'] = $u['User']['payment_id'];
						$delivery['Dropoff'][$idx]['token'] = $u['User']['token'];
						$delivery['Dropoff'][$idx]['reward_status'] = $u['User']['reward_status'];
						$delivery['Dropoff'][$idx]['reward_points'] = $u['User']['reward_points'];
						$delivery['Dropoff'][$idx]['starch'] = $u['User']['starch'];
					}
				}	
				//get delivery data
				$deliveries = ClassRegistry::init('Delivery')->find('all',array('conditions'=>array('id'=>$delivery_id)));
				if(count($deliveries)>0){
					foreach ($deliveries as $d) {
						$delivery['Dropoff'][$idx]['route_name'] = $d['Delivery']['route_name'];
						$delivery['Dropoff'][$idx]['delivery_day'] = $d['Delivery']['day'];
						$delivery['Dropoff'][$idx]['limit'] = $d['Delivery']['limit'];
						$delivery['Dropoff'][$idx]['start_time'] = $d['Delivery']['start_time'];
						$delivery['Dropoff'][$idx]['end_time'] = $d['Delivery']['end_time'];
						if(is_null($d['Delivery']['zipcode'])){
							$delivery['Dropoff'][$idx]['delivery_zipcodes'] = '';
						} else {
							$delivery['Dropoff'][$idx]['delivery_zipcodes'] = json_decode($d['Delivery']['zipcode'],true);	
						}
						if(is_null($d['Delivery']['blackout'])){
							$delivery['Dropoff'][$idx]['delivery_blackouts'] = '';
						} else {
							$delivery['Dropoff'][$idx]['delivery_blackouts']= json_decode($d['Delivery']['blackout'],true);	
						}
						$delivery['Dropoff'][$idx]['delivery_status'] = $d['Delivery']['status'];						
						
					}
				}				
				
			}				

		}

		return $delivery;

	}

	public function addSchedule($company_id, $customer_id, $data, $special_instructions)
	{
		$schedules = array();
		$schedules['Schedule'] = array(
			'company_id'=>$company_id,
			'customer_id'=>$customer_id,
			'pickup_date'=>$data['pickup_date'],
			'pickup_delivery_id'=>$data['pickup_delivery_id'],
			'dropoff_date'=>$data['dropoff_date'],
			'dropoff_delivery_id'=>$data['dropoff_delivery_id'],
			'special_instructions'=>$special_instructions,
			'type'=>$data['type'],
			'status'=>1,
		);
		$this->save($schedules);		
	}

	
}


?>