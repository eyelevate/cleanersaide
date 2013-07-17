<?php


/**
 * app/Model/Inventory_item.php
 */
class Inventory_item extends AppModel {
    public $name = 'Inventory_item';

	///Validation array
	public $validate = array(
		'type' =>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		), 
		'name'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),
		'description'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)	
		),
	
	);

	
	public function arrangeInventory($inventories)
	{
		$inv_array = array();
		foreach ($inventories as $inv) {
			$inv_id = $inv['Inventory']['id'];
			$inv_name = $inv['Inventory']['name'];
			$find = $this->find('all',array('conditions'=>array('inventory_id'=>$inv_id)));
			$reservable = $inv['Inventory']['reservable'];
			$total_units = $inv['Inventory']['total_units'];
			foreach ($find as $ii) {
				$item_name= $ii['Inventory_item']['name'];
				$item_desc = $ii['Inventory_item']['description'];
				$item_id= $ii['Inventory_item']['id'];
				$item_type= $ii['Inventory_item']['type'];
				$inc_units = $ii['Inventory_item']['inc_units'];
				$overlength = $ii['Inventory_item']['overlength'];
				$towed_units = $ii['Inventory_item']['towed_units'];
				$oneway = $ii['Inventory_item']['oneway'];
				$surcharge = $ii['Inventory_item']['surcharge'];
				$total = $ii['Inventory_item']['total_price'];

				$inv_array[$inv_name][$item_id] = array(
					'id' =>$item_id,
					'inventory_id'=>$inv_id,
					'type'=>$item_type,
					'desc'=>$item_desc,
					'name'=>$item_name,
					'overlength'=>$overlength,
					'inc_units'=>$inc_units,
					'towed_units'=>$towed_units,
					'oneway'=>$oneway,
					'surcharge'=>$surcharge,
					'total'=>$total,	
				);
			}
		}
		
		return $inv_array;
	}

	public function arrangeInventoryIndividual($schedule_id,$items,$inventories)
	{
		$set_rates = array();
		if(count($items) >0){
			
			foreach ($inventories as $inv) {
				$inv_id = $inv['Inventory']['id'];
				$inv_name = $inv['Inventory']['name'];
				$find = ClassRegistry::init('Schedule_rate')->find('all',array('conditions'=>array('schedule_id'=>$schedule_id,'inventory_id'=>$inv_id)));
				//$find = $this->find('all',array('conditions'=>array('inventory_id'=>$inv_id)));
				$reservable = $inv['Inventory']['reservable'];
				$total_units = $inv['Inventory']['total_units'];			
			

				foreach ($find as $item) {
					$inv_item_id = $item['Schedule_rate']['item_id'];
					$inv_id = $item['Schedule_rate']['inventory_id'];
					$inv_one_way = $item['Schedule_rate']['one_way'];
					$inv_surcharge = $item['Schedule_rate']['surcharge'];
					$inv_total = $item['Schedule_rate']['total_surcharged'];
					$find_inv_name = $this->find('all',array('conditions'=>array('id'=>$inv_item_id)));
					
					foreach ($find_inv_name as $fiv) {
						$item_name= $fiv['Inventory_item']['name'];
						$item_desc = $fiv['Inventory_item']['description'];
						$item_type= $fiv['Inventory_item']['type'];
						$inc_units = $fiv['Inventory_item']['inc_units'];
						$overlength = $fiv['Inventory_item']['overlength'];
						$towed_units = $fiv['Inventory_item']['towed_units'];
					}
					$set_rates[$inv_name][$inv_item_id] = array(
						'id' =>$inv_item_id,
						'inventory_id'=>$inv_id,
						'type'=>$item_type,
						'desc'=>$item_desc,
						'name'=>$item_name,
						'overlength'=>$overlength,
						'inc_units'=>$inc_units,
						'towed_units'=>$towed_units,
						'oneway'=>$inv_one_way,
						'surcharge'=>$inv_surcharge,
						'total'=>$inv_total,	
						'test'=>'schedule_rates'						
					
					);			
				}
			}
		} else {


	
			foreach ($inventories as $inv) {
				$inv_id = $inv['Inventory']['id'];
				$inv_name = $inv['Inventory']['name'];
				$find = $this->find('all',array('conditions'=>array('inventory_id'=>$inv_id)));
				$reservable = $inv['Inventory']['reservable'];
				$total_units = $inv['Inventory']['total_units'];
				foreach ($find as $ii) {
					$item_name= $ii['Inventory_item']['name'];
					$item_desc = $ii['Inventory_item']['description'];
					$item_id= $ii['Inventory_item']['id'];
					$item_type= $ii['Inventory_item']['type'];
					$inc_units = $ii['Inventory_item']['inc_units'];
					$overlength = $ii['Inventory_item']['overlength'];
					$towed_units = $ii['Inventory_item']['towed_units'];
					$oneway = $ii['Inventory_item']['oneway'];
					$surcharge = $ii['Inventory_item']['surcharge'];
					$total = $ii['Inventory_item']['total_price'];
	
					$set_rates[$inv_name][$item_id] = array(	
						'id' =>$item_id,
						'inventory_id'=>$inv_id,
						'type'=>$item_type,
						'desc'=>$item_desc,
						'name'=>$item_name,
						'overlength'=>$overlength,
						'inc_units'=>$inc_units,
						'towed_units'=>$towed_units,
						'oneway'=>$oneway,
						'surcharge'=>$surcharge,
						'total'=>$total,	
						'test'=>'inventory-item'

					);
				}
			}
			
		}
		
		return $set_rates;
	}

/**
 * alter data for display
 * 
 * @return array
 */
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
	public function fixData($find)
	{
		foreach ($find as $key => $value) {
			if(isset($find[$key]['created'])){
				$find[$key]['created'] = $this->arrangeDate($find[$key]['created']);
			}
			if(isset($find[$key]['modified'])){
				$find[$key]['modified'] = $this->arrangeDate($find[$key]['created']);
			}
		}
		return $find;
	}
	public function arrangeDate($date)
	{
		$date = date('n/d/Y g:i:sa',strtotime($date));
		return $date;
	}
/**
 * /Reservations request controller coming from /reservations/ferry 
 * 
 * this script checks for the most current rate based off schedule_id and inventory item id
 */
	public function getCurrentRate($data, $item_id)
	{
		$rates = array();
		$name = $this->getInventoryItemName($this->find('all',array('conditions'=>array('id'=>$item_id))));
		if(count($data) > 0){
			foreach ($data as $key => $value) {
				$oneway = $data[$key]['Schedule_rate']['one_way'];
				$surcharge = $data[$key]['Schedule_rate']['surcharge'];
				$total = $data[$key]['Schedule_rate']['total_surcharged'];
				$rates[$key] = array(
					'oneway'=>$oneway,
					'id'=>$item_id,
					'surcharge'=>$surcharge,
					'total'=>$total,
					'name'=>$name
				);  
			}
		} else {
			$default = $this->find('all',array('conditions'=>array('id'=>$item_id)));
			if(count($default)>0){
				foreach ($default as $key => $value) {
					$oneway = $default[$key]['Inventory_item']['oneway'];
					$surcharge = $default[$key]['Inventory_item']['surcharge'];
					$total = $default[$key]['Inventory_item']['total_price'];
					
					$rates[$key] = array(
						'oneway'=>$oneway,
						'id'=>$item_id,
						'surcharge'=>$surcharge,
						'total'=>$total,
						'name'=>$name
					);  
				}
			} 
		}
		
		return $rates;
	}
	public function getCurrentRateOverlength($data, $item_id, $overlength, $overlength_rate)
	{
		$rates = array();
		
		
		
		//get the inventory item name by the id
		$name = $this->getInventoryItemName($this->find('all',array('conditions'=>array('id'=>$item_id))));

		//if there is a return
		if(count($data) > 0){
			foreach ($data as $key => $value) {
				$oneway = $data[$key]['Schedule_rate']['one_way'];
				$surcharge = $data[$key]['Schedule_rate']['surcharge'];
				$total = sprintf('%.2f',round($data[$key]['Schedule_rate']['total_surcharged'] + ($overlength*$overlength_rate),2));
				$rates[$name][$key] = array(
					'oneway'=>$oneway,
					'id'=>$item_id,
					'name'=>$name,
					'overlength'=>$overlength,
					'overlength_rate'=>$overlength_rate,
					'surcharge'=>$surcharge,
					'total'=>$total
				);  
			}
		} else {
			$default = $this->find('all',array('conditions'=>array('id'=>$item_id)));
			if(count($default)>0){
				foreach ($default as $key => $value) {
					$oneway = $default[$key]['Inventory_item']['oneway'];
					$surcharge = $default[$key]['Inventory_item']['surcharge'];
					$total = sprintf('%.2f',round($default[$key]['Inventory_item']['total_price'] + ($overlength*$overlength_rate),2));
					$rates[$name][$key] = array(
						'oneway'=>$oneway,
						'overlength'=>$overlength,
						'id'=>$item_id,
						'name'=>$name,
						'overlength_rate'=>$overlength_rate,
						'surcharge'=>$surcharge,
						'total'=>$total
					);  
				}
			} 
		}
		
		return $rates;
	}
	public function getInventoryItemName($data)
	{
		if(!empty($data)){
		foreach ($data as $key => $value) {
			$name = $data[$key]['Inventory_item']['name'];
		}
		} else {
			$name = '';
		}
		
		
		return $name;
	}
}


?>