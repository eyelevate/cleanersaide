<?php 

/**
 * app/Model/Locations.php
 */
class Location extends AppModel {
    public $name = 'Location';
    //Models
    public function fixData($data)
    {
        foreach ($data as $key => $value) {
            if(isset($data[$key]['Location']['created'])){
            	$data[$key]['Location']['created'] = $this->regexDate($data[$key]['Location']['created']);
            }
            if(isset($data[$key]['Tax']['modified'])){
            	$data[$key]['Location']['modified'] = $this->regexDate($data[$key]['Location']['modified']);
            }			
			if(isset($data[$key]['Tax']['country'])){
				$data[$key]['Location']['country'] = $this->countryCode($data[$key]['Location']['country']);
			}
        }
		return $data;
    }
	
	public function regexDate($date)
	{
		$date = date('n/d/Y',strtotime($date));
		return $date;
	}	
	public function countryCode($code)
	{
		switch ($code) {
			case 'CAN':
				$country = 'Canada';
				break;
			
			default:
				$country = 'United States';
				break;
		}
		return $country;
	}
}


?>