<?php 

/**
 * app/Model/Schedule.php
 */
class Schedule extends AppModel {
    public $name = 'Schedule';

	public function create_schedule($data,$company_id, $month,$year)
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
								$find = $this->find('all',array('conditions'=>array('delivery_id'=>$delivery_id,'company_id'=>$company_id,'deliver_date'=>date('Y-m-d H:i:s',$i))));
								$delivery_limit = count($find);
								
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

	public function setSchedule($data)
	{
		$delivery = array();
		if(count($data)>0){
			$idx = -1;
			foreach ($data as $schedule) {
				$idx++;
				$customer_id = $schedule['Schedule']['customer_id'];
				$delivery_id = $schedule['Schedule']['delivery_id'];
				$delivery[$idx]['customer_id'] = $customer_id;
				$delivery[$idx]['delivery_id'] = $delivery_id;
				
				$delivery[$idx]['day'] = $schedule['Schedule']['day'];
				$delivery[$idx]['delivery_date'] = $schedule['Schedule']['deliver_date'];
				$delivery[$idx]['special_instructions'] = $schedule['Schedule']['special_instructions'];
				$delivery[$idx]['type'] = $schedule['Schedule']['type'];
				$delivery[$idx]['status'] = $schedule['Schedule']['status'];
				//get customer data
				$users = ClassRegistry::init('User')->find('all',array('conditions'=>array('id'=>$customer_id)));	
				if(count($users)>0){
					foreach ($users as $u) {
						$delivery[$idx]['first_name'] = $u['User']['first_name'];
						$delivery[$idx]['last_name'] = $u['User']['last_name'];
						$delivery[$idx]['address'] = $u['User']['contact_address'];
						$delivery[$idx]['suite'] = $u['User']['contact_suite'];
						$delivery[$idx]['city'] = $u['User']['contact_city'];
						$delivery[$idx]['state'] = $u['User']['contact_state'];
						$delivery[$idx]['country'] = $u['User']['contact_country'];
						$delivery[$idx]['email'] = $u['User']['contact_email'];
						$delivery[$idx]['zipcode'] = $u['User']['contact_zip'];
						$delivery[$idx]['phone'] = $u['User']['contact_phone'];
						$delivery[$idx]['default_special_instructions'] = $u['User']['special_instructions'];
						$delivery[$idx]['profile_id'] = $u['User']['profile_id'];
						$delivery[$idx]['payment_id'] = $u['User']['payment_id'];
						$delivery[$idx]['token'] = $u['User']['token'];
						$delivery[$idx]['reward_status'] = $u['User']['reward_status'];
						$delivery[$idx]['reward_points'] = $u['User']['reward_points'];
						$delivery[$idx]['starch'] = $u['User']['starch'];
					}
				}	
				//get delivery data
				$deliveries = ClassRegistry::init('Delivery')->find('all',array('conditions'=>array('id'=>$delivery_id)));
				if(count($deliveries)>0){
					foreach ($deliveries as $d) {
						$delivery[$idx]['route_name'] = $d['Delivery']['route_name'];
						$delivery[$idx]['delivery_day'] = $d['Delivery']['day'];
						$delivery[$idx]['limit'] = $d['Delivery']['limit'];
						$delivery[$idx]['start_time'] = $d['Delivery']['start_time'];
						$delivery[$idx]['end_time'] = $d['Delivery']['end_time'];
						if(is_null($d['Delivery']['zipcode'])){
							$delivery[$idx]['delivery_zipcodes'] = '';
						} else {
							$delivery[$idx]['delivery_zipcodes'] = json_decode($d['Delivery']['zipcode'],true);	
						}
						if(is_null($d['Delivery']['blackout'])){
							$delivery[$idx]['delivery_blackouts'] = '';
						} else {
							$delivery[$idx]['delivery_blackouts']= json_decode($d['Delivery']['blackout'],true);	
						}
						$delivery[$idx]['delivery_status'] = $d['Delivery']['status'];						
						
					}
				}				
				
			}	
			

		}

		return $data;

	}

	
}


?>