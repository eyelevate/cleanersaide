<?php

/**
 * app/Model/Menu_item.php
 */
class Menu_item extends AppModel {
    public $name = 'Menu_item';
    //Models
	public function arrangeMenus($menu_id)
	{
		$newArray = array();
		//arrangethe menus
		$tier1_find = $this->find('all',array('conditions'=>array('menu_id'=>$menu_id, 'tier'=>1)));
		foreach ($tier1_find as $tier1) {
			$tier1_id = $tier1['Menu_item']['id'];
			$tier1_name = $tier1['Menu_item']['name'];
			$tier1_url = $tier1['Menu_item']['url'];

			//check to see if this tier has any children
			$tier2_find = $this->find('all',array('conditions'=>array('menu_id'=>$menu_id,'tier'=>2,'parent_id'=>$tier1_id)));
			$countTier2 = count($tier2_find);
			if($countTier2>0){
				$newArray[$tier1_id] = array(
					'id'=>$tier1_id,
					'name'=>$tier1_name,
					'url'=>$tier1_url,
					2=>array()
				); 				
			} else {
				$newArray[$tier1_id] = array(
					'id'=>$tier1_id,
					'name'=>$tier1_name,
					'url'=>$tier1_url,
					2=>'empty'
				); 				
			}

			foreach ($tier2_find as $tier2) {
				$tier2_id = $tier2['Menu_item']['id'];
				$tier2_name = $tier2['Menu_item']['name'];
				$tier2_url = $tier2['Menu_item']['url'];
				$tier3_find = $this->find('all',array('conditions'=>array('menu_id'=>$menu_id,'tier'=>3,'parent_id'=>$tier2_id)));
				$countTier3 = count($tier3_find);
				if($countTier3>0){
					$newArray[$tier1_id][2] = array(
						'id'=>$tier2_id,
						'name'=>$tier2_name,
						'url'=>$tier2_url,
						3=>array()
					); 				
				} else {
					$newArray[$tier1_id][2] = array(
						'id'=>$tier2_id,
						'name'=>$tier2_name,
						'url'=>$tier2_url,
						3=>'empty'
					); 				
				}
				foreach ($tier3_find as $tier3) {
					$tier3_id = $tier3['Menu_item']['id'];
					$tier3_name = $tier3['Menu_item']['name'];
					$tier3_url = $tier3['Menu_item']['url'];
					$newArray[$tier1_id][2][3]= array(
						'id'=>$tier3_id,
						'name'=>$tier3_name,
						'url'=>$tier3_url
					); 
				}
				
			}
		}

		return $newArray;
	}
/**
 * arrange the table by tiers
 */
	public function arrangeByTiers($menu_id)
	{
		//count all
		$final_count = count($this->find('all',array('conditions'=>array('menu_id'=>$menu_id))));
		//tier 1
		$findTier1 = $this->find('all',array('conditions'=>array('tier'=>1, 'menu_id'=>$menu_id),'order'=>'orders asc'));

		$findTier1_count = count($findTier1);
		$tier_array= array();
		for ($i=0; $i < $findTier1_count; $i++) {
			$tier1_order = $findTier1[$i]['Menu_item']['orders'];
			$tier1_name = $findTier1[$i]['Menu_item']['name'];
			$tier1_url = $findTier1[$i]['Menu_item']['url'];
			$tier1_icon = $findTier1[$i]['Menu_item']['icon'];
			$tier1_tier = $findTier1[$i]['Menu_item']['tier']; 
			$start = $findTier1[$i]['Menu_item']['orders'];
			$next = $i+1;
			if($i == $findTier1_count-1){
				$tier2 = $this->query("select * from menu_items where menu_id ='".$menu_id."' and orders between '".($start+1)."' and '".$final_count."' order by orders asc");	

			} else {
				$end = $findTier1[$next]['Menu_item']['orders'];
				$tier2 = $this->query("select * from menu_items where menu_id ='".$menu_id."' and orders between '".($start+1)."' and '".($end-1)."' order by orders asc");			
			}
			$tier2_count = count($tier2);
						
			if ($tier2_count>0) {
				$tier2_array = array();
				foreach ($tier2 as $t2) {
					$tier2_name = $t2['menu_items']['name'];
					$tier2_url = $t2['menu_items']['url'];
					$tier2_icon = $t2['menu_items']['icon'];
					$tier2_order = $t2['menu_items']['orders'];
					$tier2_tier = $t2['menu_items']['tier'];
					$tier2_array[$tier2_name] = array(
						'url'=>$tier2_url,
						'order'=>$tier2_order,
						'icon'=>$tier2_icon,
						'tier'=>$tier2_tier,	
						'name'=>$tier2_name				
					);
				}
			} else {
				//no tier 2
				$tier2_array = 'empty';
			}
			$tier_array[$tier1_name] = array(
				'url'=>$tier1_url,
				'order'=>$tier1_order,
				'icon'=>$tier1_icon,
				'tier'=>$tier1_tier,
				'name'=>$tier1_name,
				'next'=>$tier2_array
			);
			
		}

		return $tier_array;
	}
/**
 * checks to see if this page is in main header array
 * @return string
 */
	function menuActiveHeaderCheck($needle, $haystack)
	{
		foreach ($haystack as $key => $value) {
			$mainHeader = $key;
			$name = $haystack[$mainHeader]['name'];
			$url = $haystack[$mainHeader]['url'];
			$icon = $haystack[$mainHeader]['icon'];
			if($haystack[$mainHeader]['next'] != 'empty'){
				foreach ($haystack[$mainHeader]['next'] as $key => $value) {
					if(in_array($needle, $haystack[$mainHeader]['next'][$key])){
						//returns the main header name to match with the name in admin.ctp layout
						return $name;
					} 
					
				}
			}

		}

		return 'NULL';
	}

 
}


?>
