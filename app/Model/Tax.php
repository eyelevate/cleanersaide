<?php

/**
 * app/model/Tax.php
 */
class Tax extends AppModel {
    public $name = 'Tax';
    //Models
    public function fixData($data)
    {
        foreach ($data as $key => $value) {
            if(isset($data[$key]['Tax']['created'])){
            	$data[$key]['Tax']['created'] = $this->regexDate($data[$key]['Tax']['created']);
            }
            if(isset($data[$key]['Tax']['modified'])){
            	$data[$key]['Tax']['modified'] = $this->regexDate($data[$key]['Tax']['modified']);
            }			
			if(isset($data[$key]['Tax']['country'])){
				$data[$key]['Tax']['country'] = $this->countryCode($data[$key]['Tax']['country']);
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