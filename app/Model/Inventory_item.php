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
				if(isset($find[$key1][$key2]['inventory_id'])){
					$invs = ClassRegistry::init('Inventory')->find('all',array('conditions'=>array('id'=>$find[$key1][$key2]['inventory_id'])));
					if(count($invs)>0){
						foreach ($invs as $inv) {
							$inventory_name = $inv['Inventory']['name'];
							$find[$key1][$key2]['inventory_name'] = $inventory_name;
						}
							
					}
				}
				
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
	
	public function createAllImageArray()
	{
		$images = array(
			'bedsheets-blue'=>'/img/inventory/bedSheets_blue.png',
			'bedsheets-green'=>'/img/inventory/bedSheets_green.png',
			'bedsheets-red'=>'/img/inventory/bedSheets_red.png',
			'bedskirt-blue'=>'/img/inventory/bedSkirt_blue.png',
			'bedskirt-green'=>'/img/inventory/bedSkirt_green.png',
			'bedskirt-red'=>'/img/inventory/bedSkirt_red.png',
			'bedspread-blue'=>'/img/inventory/bedSpread_blue.png',
			'bedspread-green'=>'/img/inventory/bedSpread_green.png',
			'bedspread-red'=>'/img/inventory/bedSpread_red.png',
			'belt'=>'/img/inventory/belt.png',
			'blanket-blue'=>'/img/inventory/blanket_blue.png',
			'blanket-green'=>'/img/inventory/blanket_green.png',
			'blanket-red'=>'/img/inventory/blanket_red.png',
			'blouse-purple'=>'/img/inventory/blouse_purple.png',
			'coatlong-brown'=>'/img/inventory/coatLong_brown.png',
			'coatshort-gray'=>'/img/inventory/coatShort_gray.png',
			'comforter-blue'=>'/img/inventory/comforter_blue.png',
			'comforter-green'=>'/img/inventory/comforter_green.png',
			'comforter-red'=>'/img/inventory/comforter_red.png',
			'comforterdown-blue'=>'/img/inventory/comforterDown_blue.png',
			'comforterdown-green'=>'/img/inventory/comforterDown_green.png',
			'comforterdown-red'=>'/img/inventory/comforterDown_red.png',
			'curtain-blue'=>'/img/inventory/curtain_blue.png',
			'curtain-green'=>'/img/inventory/curtain_green.png',
			'curtain-red'=>'/img/inventory/curtain_red.png',
			'cushion-blue'=>'/img/inventory/cushion_blue.png',
			'cushion-green'=>'/img/inventory/cushion_green.png',
			'cushion-red'=>'/img/inventory/cushion_red.png',
			'dresslong-red'=>'/img/inventory/dressLong_red.png',
			'dressshort-pink'=>'/img/inventory/dressShort_pink.png',
			'dresssuit-gray'=>'/img/inventory/dressSuit_gray.png',
			'duvetcover-blue'=>'/img/inventory/duvetCover_blue.png',
			'duvercover-green'=>'/img/inventory/duvetCover_green.png',
			'duvetcover-red'=>'/img/inventory/duvetCover_red.png',
			'hat'=>'/img/inventory/hat.png',
			'jacket-brown'=>'/img/inventory/jacket_brown.png',
			'jacket-gray'=>'/img/inventory/jacket_gray.png',
			'jeans'=>'/img/inventory/jeans.png',
			'labcoat-white'=>'/img/inventory/labcoat_white.png',
			'laundryshirt-white'=>'/img/inventory/laundryShirt_white.png',
			'napkin-blue'=>'/img/inventory/napkin_blue.png',
			'napkin-green'=>'/img/inventory/napkin_green.png',
			'napkin-red'=>'/img/inventory/napkin_red.png',			
			'pants-tan'=>'/img/inventory/pants_tan.png',
			'pantsHem-blue'=>'/img/inventory/pantsHem_blue.png',
			'pillow-blue'=>'/img/inventory/pillow_blue.png',
			'pillow-green'=>'/img/inventory/pillow_green.png',
			'pillow-red'=>'/img/inventory/pillow_red.png',
			'pillowCase-blue'=>'/img/inventory/pillowCase_blue.png',
			'pillowCase-green'=>'/img/inventory/pillowCase_green.png',
			'pillowCase-red'=>'/img/inventory/pillowCase_red.png',
			'pillowDown-blue'=>'/img/inventory/pillowDown_blue.png',
			'pillowDown-green'=>'/img/inventory/pillowDown_green.png',
			'pillowDown-red'=>'/img/inventory/pillowDown_red.png',
			'placemat-blue'=>'/img/inventory/placemat_blue.png',
			'placemat-green'=>'/img/inventory/placemat_green.png',
			'placemat-red'=>'/img/inventory/placemat_red.png',
			'polo-red'=>'/img/inventory/polo_red.png',
			'question'=>'/img/inventory/question.png',
			'robe-brown'=>'/img/inventory/robe_brown.png',
			'rug-blue'=>'/img/inventory/rug_blue.png',
			'rug-green'=>'/img/inventory/rug_green.png',
			'rug-red'=>'/img/inventory/rug_red.png',
			'runner-blue'=>'/img/inventory/runner_blue.png',
			'runner-green'=>'/img/inventory/runner_green.png',
			'runner-red'=>'/img/inventory/runner_red.png',	
			'scarf-green'=>'/img/inventory/scarf_green.png',
			'scarf-purple'=>'/img/inventory/scarf_purple.png',
			'scissors'=>'/img/inventory/scissors.png',
			'sewingmachine'=>'/img/inventory/sewingMachine.png',
			'shirtbox-blue'=>'/img/inventory/shirtBox_blue.png',
			'shirtKids-green'=>'/img/inventory/shirtKids_green.png',
			'shirtDc-black'=>'/img/inventory/shirtsDC_black.png',
			'shorts-gray'=>'/img/inventory/shorts_gray.png',
			'silkBlouse-red'=>'/img/inventory/silkBlouse_red.png',
			'skirt-green'=>'/img/inventory/skirt_green.png',
			'sleepingbag-blue'=>'/img/inventory/sleepingBag_blue.png',
			'sleepingbag-green'=>'/img/inventory/sleepingBag_green.png',
			'sleepingbag-red'=>'/img/inventory/sleepingBag_red.png',	
			'sportsjacket'=>'/img/inventory/sportsJacket_blue.png',
			'suit_black'=>'/img/inventory/suit_black.png',
			'sweater-orange'=>'/img/inventory/sweater_orange.png',
			'sweaterBrush_brown'=>'/img/inventory/sweaterBrush_brown.png',
			'sweaterBrushed'=>'/img/inventory/sweaterBrushed.png',
			'sweatersew'=>'/img/inventory/sweaterSew_pink.png',
			'tablecloth-blue'=>'/img/inventory/tableCloth_blue.png',
			'tablecloth-green'=>'/img/inventory/tableCloth_green.png',
			'tablecloth-red'=>'/img/inventory/tableCloth_red.png',	
			'tie-black'=>'/img/inventory/tie_black.png',
			'tshirt-pink'=>'/img/inventory/tshirt_pink.png',
			'tuxshirt-white'=>'/img/inventory/tuxShirt_white.png',
			'twoPieceWomens'=>'/img/inventory/twoPieceWomens.png',
			'vest-gray'=>'/img/inventory/vest_gray.png',
			'weddingbox'=>'/img/inventory/weddingBox.png',
			'weddinggown'=>'/img/inventory/weddingGown.png',
			'womensblouse'=>'/img/inventory/womensBlouse.png',
			'womensPants'=>'/img/inventory/womensPants.png',
			'womensTop'=>'/img/inventory/womensTop_green.png'
		);
		return $images;
	}

	public function reorganizeByInventory($data){
		$reorder = array();
		$idx = -1;
		if(count($data)>0){
			foreach ($data as $ikey => $ivalue) {
				$idx++;
				$item_id = $ikey;
				$item_name = $data[$ikey]['name'];
				//get inventory_id
				$inventories = $this->find('all',array('conditions'=>array('name'=>$item_name,'company_id'=>$_SESSION['company_id'])));
				if(count($inventories) >0){
					foreach ($inventories as $inv) {
						$inventory_id = $inv['Inventory_item']['inventory_id'];

					}

					$reorder[$inventory_id][$ikey] = $ivalue;	
				} 
				
			}
		}
		return $reorder;
	

	}
	public function redoInventoryItemsByInventory($data)
	{
		$inv_items = array();
		if(count($data)>0){
			foreach ($data as $inv) {
				$inventory_id = $inv['Inventory']['id'];
				$inv_items[$inventory_id] = $this->find('all',array('conditions'=>array('inventory_id'=>$inventory_id),'order'=>'name asc'));
			}
		}
		return $inv_items;
	}

}


?>