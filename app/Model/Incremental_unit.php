<?php


/**
 * app/Model/Incremental_unit.php
 */
class Incremental_unit extends AppModel {
    public $name = 'Incremental_unit';


/**
 * Find all incremental Units based on ferry_id, and inventory_id
 * 
 * @return array
 */
	public function arrangeInventoryType($data, $ferry_id)
	{
		foreach ($data as $key => $value) {
			$inventory_id = $data[$key]['Inventory']['id'];
			
			$incremental_units = $this->find('all',array('conditions'=>array('ferry_id'=>$ferry_id,'inventory_id'=>$inventory_id)));
			if(count($incremental_units)>0){
				$data[$key]['Inventory']['incremental_units'] = $incremental_units;
			}
		}
		
		return $data;
	}

}


?>