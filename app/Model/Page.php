<?php

/**
 * app/Model/Page.php
 */
class Page extends AppModel {
    public $name = 'Page';

public $validate = array(

	'depart_date'=>array(
		'notEmpty'=>array(
	        'rule'    => 'notEmpty',
	        'message' => 'This field cannot be left blank'
		)
	)



);


/**
 * Page url redirecting url fix. used to to tell the router to redirect to the url action in the pages Controller
 * 
 * @return variable
 */
    public function fixUrl($first, $second, $third, $fourth, $fifth)
    {
        if ($first != null && $second == null && $third == null && $fourth == null && $fifth ==null) {
            $url = '/'.$first;
        } else if($first != null && $second != null && $third == null && $fourth ==null && $fifth ==null){
        	$url = '/'.$first.'/'.$second;
        } else if($first != null && $second != null && $third != null && $fourth ==null && $fifth ==null){
        	$url = '/'.$first.'/'.$second.'/'.$third;
        } else if($first != null && $second != null && $third != null && $fourth !=null && $fifth ==null){
        	$url = '/'.$first.'/'.$second.'/'.$third.'/'.$fourth;
        } else {
        	$url = '/'.$first.'/'.$second.'/'.$third.'/'.$fourth.'/'.$fifth;
        }
		return $url;
    }

/**
 * after finding the pages alter the data to make user readable
 * @param pages array
 * @return array;
 */
	public function afterFindPage($results)
	{
	    foreach ($results as $key => $val) {
			if (isset($val['Page']['status'])){
				$results[$key]['Page']['status'] = $this->statusConvert($val['Page']['status']);
			}
	    }
	    return $results;		
	}
	public function statusConvert($status)
	{
		
		switch ($status) {
			case 1:
				$status = 'Draft';
				break;
			
			default:
				$status = 'Published';
				break;
		}
		return $status;
	}
/**
 * Publish page to the db change status from 1 to 2
 * 
 * @return void
 */
	public function publishPage($id)
	{
		$this->id = $id;
		$this->saveField('Page.status', 2);		
	}
	
/**
 * Order the featured items on page load
 */
	public function orderFeatured($data1, $data2){
		$mixed = array();	
		$idx = -1;	

		foreach ($data1 as $hkey => $hvalue) {
			$idx++;
			$hotel_id = $data1[$hkey]['Hotel']['id'];
			$hotel_name = $data1[$hkey]['Hotel']['name'];
			$hotel_description = $data1[$hkey]['Hotel']['hotel_description'];
			$hotel_url = $data1[$hkey]['Hotel']['url'];
			$hotel_location = $data1[$hkey]['Hotel']['location'];
			$hotel_starting_price = $data1[$hkey]['Hotel']['starting_price'];
			$hotel_rating = $data1[$hkey]['Hotel']['class'];
			$hotel_main_image = $data1[$hkey]['Hotel']['image_main'];
			$hotel_images = $data1[$hkey]['Hotel']['image_sort'];
			$hotel_city = $data1[$hkey]['Hotel']['city'];
			$hotel_state = $data1[$hkey]['Hotel']['state'];
			$mixed[$idx] = array(
				'id'=>$hotel_id,
				'type'=>'Hotel',
				'name'=>$hotel_name,
				'description'=>$hotel_description,
				'url'=>$hotel_url,
				'location'=> $hotel_location,
				'starting'=>$hotel_starting_price,
				'rating'=>$hotel_rating,
				'image'=>$hotel_main_image,
				'images'=>$hotel_images,
				'city'=>$hotel_city,
				'state'=>$hotel_state
			);
			
		}		
		foreach ($data2 as $akey => $avalue) {
			$idx++;
			$attr_id = $data2[$akey]['Attraction']['id'];
			$attr_name = $data2[$akey]['Attraction']['name'];
			$attr_description = $data2[$akey]['Attraction']['description'];
			$attr_url = $data2[$akey]['Attraction']['url'];
			$attr_location = $data2[$akey]['Attraction']['location'];
			$attr_starting_price = $data2[$akey]['Attraction']['starting_price'];
			$attr_rating = $data2[$akey]['Attraction']['class'];	
			$attr_main_image = $data2[$akey]['Attraction']['image_main'];
			$attr_images = $data2[$akey]['Attraction']['image_sort'];	
			$attr_city = $data2[$akey]['Attraction']['city'];
			$attr_state = $data2[$akey]['Attraction']['state'];
			$mixed[$idx] = array(
				'id'=>$attr_id,
				'type'=>'Attraction',
				'name'=>$attr_name,
				'description'=>$attr_description,
				'url'=>$attr_url,
				'location'=> $attr_location,
				'starting'=>$attr_starting_price,
				'rating'=>$attr_rating,
				'image'=>$attr_main_image,
				'images'=>$attr_images,
				'city'=>$attr_city,
				'state'=>$attr_state
			);	
		}
		//sort by key (alphabetically by name)

		// ksort($mixed);
		// debug($mixed);
		return $mixed;
	}

	public function updatePage($data)
	{

		if(isset($data['Page']['page_name'])){
			
			$url = '/'.$data['Page']['page_name'];
			$url =trim(str_replace(array(' ','%20','%26',"'",'&'),array('-','','','','and'),$url));
			$data['Page']['url'] =$url;
		}
		$data['Page']['relationship'] = '1'; //parent page needs updating later
		$data['Page']['status'] = '1';
		return $data;
	}
	public function updateEditPage($data)
	{
		foreach ($data['Page'] as $key => $value) {
			if(isset($data['Page'][$key]['page_name'])){
				
				$url = '/'.$data['Page'][$key]['page_name'];
				$url =trim(str_replace(array(' ','%20','%26',"'",'&'),array('-','','','','and'),$url));
				$data['Page'][$key]['url'] =$url;
			}
			
			$data['Page'][$key]['relationship'] = '1'; //parent page needs updating later
			$data['Page'][$key]['status'] = '1';			
		}

		return $data;
	}
}


?>