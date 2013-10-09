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

	
}


?>