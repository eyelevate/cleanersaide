<?php
App::uses('AppModel', 'Model');

/**
 * app/Model/Inventory_item.php
 */
class Inventory extends AppModel {
    public $name = 'Inventory';
    //Models
	///Validation array
	public $validate = array(
		'name'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),
		'online_oneway'=>array(
			'notEmpty'=>array(
				'rule'	=>	'notEmpty',
				'message'=>	'This field cannot be left blank'
			)
		),
		'online_roundtrip'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),
		'phone_oneway'=>array(
			'notEmpty'=>array(
				'rule'	=>	'notEmpty',
				'message'=>	'This field cannot be left blank'
			)
		),
		'phone_roundtrip'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),
		'reservable'=>array(
			'notEmpty'=>array(
				'rule'	=>	'notEmpty',
				'message'=>	'This field cannot be left blank'
			)
		),
		'total_units'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),	

	
	);
	
	public function switchInventory($inventories)
	{
		$switch = array();
		foreach ($inventories as $inventory) {
			$inventory_id = $inventory['Inventory']['id'];
			$inventory_name = $inventory['Inventory']['name'];
			$switch[$inventory_name] = $inventory_id;
		}
		
		return $switch;
	}
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
	public function oneway_passengers()
	{
		$fee = $this->find('all',array('conditions'=>array('id'=>'1')));
		
		if(count($fee)>0){
			foreach ($fee as $p) {
				$oneway = $p['Inventory']['online_oneway'];
			}			
		} else {
			$oneway = '0.00';
		}
		
		return $oneway;

	}
	public function oneway_vehicles()
	{
		$fee = $this->find('all',array('conditions'=>array('id'=>'2')));
		
		if(count($fee)>0){
			foreach ($fee as $p) {
				$oneway = $p['Inventory']['online_oneway'];
			}			
		} else {
			$oneway = '0.00';
		}
		
		return $oneway;

	}
	public function oneway_motorcycles()
	{
		$fee = $this->find('all',array('conditions'=>array('id'=>'3')));
		
		if(count($fee)>0){
			foreach ($fee as $p) {
				$oneway = $p['Inventory']['online_oneway'];
			}			
		} else {
			$oneway = '0.00';
		}
		
		return $oneway;

	}
	public function oneway_bicycles()
	{
		$fee = $this->find('all',array('conditions'=>array('id'=>'4')));
		
		if(count($fee)>0){
			foreach ($fee as $p) {
				$oneway = $p['Inventory']['online_oneway'];
			}			
		} else {
			$oneway = '0.00';
		}
		
		return $oneway;

	}
	public function round_passengers()
	{
		$fee = $this->find('all',array('conditions'=>array('id'=>'1')));
		
		if(count($fee)>0){
			foreach ($fee as $p) {
				$round = $p['Inventory']['online_roundtrip'];
			}			
		} else {
			$round = '0.00';
		}
		
		return $round;

	}
	public function round_vehicles()
	{
		$fee = $this->find('all',array('conditions'=>array('id'=>'2')));
		
		if(count($fee)>0){
			foreach ($fee as $p) {
				$round = $p['Inventory']['online_roundtrip'];
			}			
		} else {
			$round = '0.00';
		}
		
		return $round;

	}
	public function round_motorcycles()
	{
		$fee = $this->find('all',array('conditions'=>array('id'=>'3')));
		
		if(count($fee)>0){
			foreach ($fee as $p) {
				$round = $p['Inventory']['online_roundtrip'];
			}			
		} else {
			$round = '0.00';
		}
		
		return $round;

	}
	public function round_bicycles()
	{
		$fee = $this->find('all',array('conditions'=>array('id'=>'4')));
		
		if(count($fee)>0){
			foreach ($fee as $p) {
				$round = $p['Inventory']['online_roundtrip'];
			}			
		} else {
			$round = '0.00';
		}
		
		return $round;

	}
	
	public function getName($id)
	{
		$inventories = $this->find('all',array('conditions'=>array('id'=>$inventory_id)));
		if(count($inventories) > 0){
			foreach ($inventories as $i) {
				$name = $i['Inventory']['name'];
			}
		} else {
			$name = '';
		}

		return $name;
	}

/**
 * This creates opt groups and options for inventory and inventory items 
 * /reservations/view
 * 
 * @return array
 */
	public function createSelectOptions($data)
	{
		$new_options = array();
		foreach ($data as $key => $value) {
			$inventory_id = $data[$key]['Inventory']['id'];
			$inventory_name = $data[$key]['Inventory']['name'];
			
			if($inventory_id == '1'){
				$new_options[$inventory_name]['FootPassengers'] = 'Foot Passengers';
			} else {
				$inv_items = ClassRegistry::init('Inventory_item')->find('all',array('conditions'=>array('inventory_id'=>$inventory_id)));
				foreach ($inv_items as $ii) {
					$inv_id = $ii['Inventory_item']['id'];
					$inv_name = $ii['Inventory_item']['name'];
					$new_options[$inventory_name][$inv_id] = $inv_name; 
					
				}				
			}

		}
		
		return $new_options;
	}
}


?>