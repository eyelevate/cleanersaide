<?php
App::uses('AppModel', 'Model');
/**
 * app/Model/Admin.php
 */
class Delivery extends AppModel {
    public $name = 'Delivery';
	

	
	public function hashPasswords($password)
	{
		$hashedPasswords = Security::hash($password, NULL, true);
		
		return $hashedPasswords;
	}	
	public function arrangeDataForSaving($data)
	{
		$route_name = $data['route_name'];
		$delivery = $data['Delivery'];
		
		$company_id = $_SESSION['company_id'];
		
		//check to see if name is unique
		$names = $this->find('all',array('conditions'=>array('route_name'=>$route_name,'company_id'=>$company_id)));
		if(count($names)>0){
			$route_name = $route_name.' '.date('Y-m-d H:i:s');
		} 
		
		if($route_name == ''){
			$route_name = 'Route '.date('Y-m-d H:i:s');
		}
		
		
		foreach ($data['Delivery'] as $key => $value) {
			
			switch($key){
				case 0: //monday
					$day = 'Monday';					
				break;
				
				case 1:
					$day = 'Tuesday';
				break;
					
				case 2:
					$day = 'Wednesday';
				break;
					
				case 3:
					$day = 'Thursday';
				break;
				
				case 4:
					$day = 'Friday';
				break;
				
				case 5:
					$day = 'Saturday';
				break;
				
				case 6:
					$day = 'Sunday';
				break;
			}

			$data['Delivery'][$key]['route_name'] = $route_name;
			$data['Delivery'][$key]['company_id'] = $company_id;	
			$data['Delivery'][$key]['status'] = 1;	
			$data['Delivery'][$key]['day'] = $day;	
			if(!empty($data['Delivery'][$key]['zipcode'])){
				$data['Delivery'][$key]['zipcode'] = json_encode($data['Delivery'][$key]['zipcode']);
			}
			if(!empty($data['Delivery'][$key]['blackout'])){
				$blackout_date = array();
				$idx = -1;
				foreach ($data['Delivery'][$key]['blackout'] as $bkey => $bvalue) {
					$idx++;
					$blackout_date[$idx] = date('Y-m-d',strtotime($bvalue)).' 00:00:00';
				}
				$data['Delivery'][$key]['blackout'] = json_encode($blackout_date);
			}			
		}
		
		return $data;
	}

	public function arrangeEditedDeliveryForSave($data)
	{
		$route_name = $data['Delivery']['route_name'];
		$delivery = $data['Delivery'];
		
		$company_id = $_SESSION['company_id'];
		
		//check to see if name is unique

		$data['Delivery']['route_name'] = $route_name;

		$data['Delivery']['status'] = 1;	
		if(!empty($data['Delivery']['zipcode'])){
			$data['Delivery']['zipcode'] = json_encode($data['Delivery']['zipcode']);
		}
		if(!empty($data['Delivery']['blackout'])){
			$blackout_date = array();
			$idx = -1;
			foreach ($data['Delivery']['blackout'] as $bkey => $bvalue) {
				$idx++;
				$blackout_date[$idx] = date('Y-m-d',strtotime($bvalue)).' 00:00:00';
			}
			$data['Delivery']['blackout'] = json_encode($blackout_date);
		}	
		
		return $data;		
	}

		
	public function minutesArray()
	{
		//get all the minutes in a day
	    $secondsDay = 86400;
		$minuteSeconds = 60;
		$minutesDay = 1440;
		$todayStart = strtotime(date('Y-m-d 00:00:00'));
		$todayEnd = $todayStart+$secondsDay;
		$minutesArray = array();
	    //get all minutes in the day
	    for ($i = 0; $i < 1440; $i++)
	    {
	    	$nextMinute = $todayStart+($minuteSeconds*$i);
			$nextMinute = date('g:ia', $nextMinute);
			$minutesArray[$i] = $nextMinute;
	    }
		
		return $minutesArray;
		
	}	

	public function arrangeRoutes($data)
	{
		$routes = array();
		$idx = -1;
		foreach ($data as $d) {
			$idx++;
			$id = $d['Delivery']['id'];
			$name = $d['Delivery']['route_name'];
			$day = $d['Delivery']['day'];
			$limit = $d['Delivery']['limit'];
			$start_time = $d['Delivery']['start_time'];
			$end_time = $d['Delivery']['end_time'];
			$zipcode = json_decode($d['Delivery']['zipcode'], true);
			$blackout = json_decode($d['Delivery']['blackout'], true);
			$status = $d['Delivery']['status'];
			$routes[$name][$idx]['id'] = $id;
			$routes[$name][$idx]['name'] = $name;
			$routes[$name][$idx]['day'] = $day;
			$routes[$name][$idx]['limit'] = $limit;
			$routes[$name][$idx]['start_time'] = $start_time;
			$routes[$name][$idx]['end_time'] = $end_time;
			$routes[$name][$idx]['zipcode'] = $zipcode;
			$routes[$name][$idx]['blackout'] = $blackout;
			$routes[$name][$idx]['status'] = $status;
			
		}
		
		return $routes;
	}
	
	public function routes($zipcode,$company_id)
	{
		$routes = array();
		$status = 1;
		//first pull all routes with this company_id and a stataus of 1;
		$find = $this->find('all',array('conditions'=>array('company_id'=>$company_id,'status'=>$status)));

		if(count($find)>0){
			$idx = -1;
			foreach ($find as $d) {
				$delivery_id = $d['Delivery']['id'];
				$route_name = $d['Delivery']['route_name'];
				$day = $d['Delivery']['day'];
				$limit = $d['Delivery']['limit'];
				$start_time = $d['Delivery']['start_time'];
				$end_time = $d['Delivery']['end_time'];
				$blackouts = json_decode($d['Delivery']['blackout'],true);
				
				$zipcodes = json_decode($d['Delivery']['zipcode'],true);
				if(count($zipcodes)>0){
					foreach ($zipcodes as $key => $value) {
						if($value == $zipcode){
							$idx++;
							$routes[$idx] = array(
								'id'=>$delivery_id,
								'name'=>$route_name,
								'day'=>$day,
								'limit'=>$limit,
								'start'=>$start_time,
								'end'=>$end_time,
								'zipcodes'=>$zipcodes,
								'blackouts'=>$blackouts,
							);
						}
					}
				}
			}
		}
		return $routes;
	}

	public function view_schedule($data)
	{

		$schedule = array();
		if(count($data)>0){
			foreach ($data as $key => $value) {
				$route_id = $data[$key]['id'];
				$route_name = $data[$key]['name'];
				$day = $data[$key]['day'];
				$limit = $data[$key]['limit'];
				$start = $data[$key]['start'];
				$end = $data[$key]['end'];	
				$schedule[$day][$key] = $value;			
			}
		}
		return $schedule;
	}
	
	public function deliveryString($customer_id, $data, $token)
	{
		$string = '';
		
		$reschedule_link = 'https://www.jayscleaners.com/deliveries/reschedule/'.$token;
		if(isset($data)){
			if(empty($customer_id)){
				$customer_id = $data['User']['customer_id'];	
			}
			
			$first_name = ucfirst($data['User']['first_name']);
			$last_name = ucfirst($data['User']['last_name']);
			$phone = $data['User']['contact_phone'];
			$email = $data['User']['contact_email'];
			$address = $data['User']['contact_address'];
			$suite = $data['User']['contact_suite'];
			$city = $data['User']['contact_city'];
			$state = $data['User']['contact_state'];
			$zip = $data['User']['contact_zip'];
			$special_instructions = $data['User']['special_instructions'];
			$dropoff_date = date('D n/d/Y',strtotime($data['Schedule']['dropoff_date']));
			$pickup_date = date('D n/d/Y',strtotime($data['Schedule']['pickup_date']));	
			$string .= '<tr><td><legend>'.$first_name.' '.$last_name.'</td></tr>';	
			$string .= '<tr><td><p>Thank you for making a delivery request with us. You have requested a pickup on '.$pickup_date.' and a dropoff on '.$dropoff_date.'. '.
				'If these dates are not accurate or you would like to request a change in the pickup/dropoff dates you may <a href="'.$reschedule_link.'" style="color:blue;">Click Here</a>, or contact us at (206) 453-5930. <br/><strong>(**Note** Date changes must be made before 7am of the date requested.)</strong>'.
				'Thank you!';	
		}

		return $string;
	}
	function get_random_string($valid_chars, $length)
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

	function formatPhoneNumber($phoneNumber) {
	    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);
	
	    if(strlen($phoneNumber) > 10) {
	        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
	        $areaCode = substr($phoneNumber, -10, 3);
	        $nextThree = substr($phoneNumber, -7, 3);
	        $lastFour = substr($phoneNumber, -4, 4);
	
	        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
	    }
	    else if(strlen($phoneNumber) == 10) {
	        $areaCode = substr($phoneNumber, 0, 3);
	        $nextThree = substr($phoneNumber, 3, 3);
	        $lastFour = substr($phoneNumber, 6, 4);
	
	        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
	    }
	    else if(strlen($phoneNumber) == 7) {
	        $nextThree = substr($phoneNumber, 0, 3);
	        $lastFour = substr($phoneNumber, 3, 4);
	
	        $phoneNumber = $nextThree.'-'.$lastFour;
	    }
	
	    return $phoneNumber;
	}
		
	public function final_processing()
	{
		
	}
	
}
?>