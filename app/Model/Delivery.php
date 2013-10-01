<?php
App::uses('AppModel', 'Model');
/**
 * app/Model/Admin.php
 */
class Delivery extends AppModel {
    public $name = 'Delivery';
	
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
				case '0': //monday
					$day = 'Monday';					
				break;
				
				case '1':
					$day = 'Tuesday';
				break;
					
				case '2':
					$day = 'Wednesday';
				break;
					
				case '3':
					$day = 'Thursday';
				break;
				
				case '4':
					$day = 'Friday';
				break;
				
				case '5':
					$day = 'Saturday';
				break;
				
				default:
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
	
	
}
?>