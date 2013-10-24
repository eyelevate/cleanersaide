<?php
App::uses('AppModel', 'Model');
/**
 * app/Model/Admin.php
 */
class Company extends AppModel {
    public $name = 'Company';



/**
 * Permissions
 */
	///Validation array
	public $validate = array(

		'owner' =>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			),
			'unique'=>array(
				'rule'=>'isUnique',
				'message'=>'This username has already been taken. Enter in a new username.'
			)
		), 

		'name'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'				
			)
		),
		'street'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),


		'city'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'state'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'zip'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'phone'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'email'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			),
			'email'=>array(
				'rule'=>'email',
				'message'=>'This is not a valid email'
			)
		),


		'password'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),
		'password2'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			), 
			'identicalPasswordCheck'=>array(
				'rule' => array('identicalPasswordCheck','password'),
				'message' => 'Your passwords do not match. Please try again'
			)	
		),

	
	);
/**
 * validation custom functions
 */
	public function identicalPasswordCheck($field = array(),$field_name)
	{
		foreach ($field as $key => $value) {
			$v1 = $value;
			$v2 = $this->data[$this->name][$field_name];
			if($v1 !== $v2 ){
				return FALSE;
			} else {
				continue;
			}
		}
		
		return TRUE;
	}	
	
	public function hashPasswords($password)
	{
		$hashedPasswords = Security::hash($password, NULL, true);
		
		return $hashedPasswords;
	}
	
	public function company_login($username, $password)
	{
		//search the company db
		$search = $this->find('all',array('conditions'=>array('owner'=>$username,'password'=>$password)));

		if(count($search)>0){
			foreach ($search as $s) {
				$company_id = $s['Company']['id'];
				$company_name = $s['Company']['name'];
				//set cookie 24 hours
				setcookie('company_id',$company_id,time()+3600*24);
			}
			return true;
		
		} else {
			return false;
			
			
		}
	
	}
	public function beforeSave($options = array())
	{
		if(!empty($this->data['Company']['password'])){
	   		$this->data['Company']['password'] = AuthComponent::password($this->data['Company']['password']);
		}
	    return true;
	}	
	
	public function new_items($items, $colors)
	{
		$new = array();
		//debug($items);
		//debug($colors);
		$idx= -1;
		if(count($items)>0){
			foreach ($items as $key => $value) {
				$idx++;
				$item_name = $items[$key][0];
				$item_id = $items[$key][1];				//get before_tax price of item_id
				$item_data = ClassRegistry::init('Inventory_item')->find('all',array('conditions'=>array('id'=>$item_id)));
				if(count($item_data)>0){
					foreach ($item_data as $id) {
						$before_tax = $id['Inventory_item']['price'];
					}
				} else {
					$before_tax = '0.00';
				}
				
				$qty = $items[$key][2];
				if(count($colors)>0){
					//debug($colors[$key][2].' '.$colors[$key][0]);
					$new_colors = array();
					if(!empty($colors[$key])){
						$new_colors[0] = array(
							'quantity' => $colors[$key][1],
							'color'=>$colors[$key][0]
							
						);
					}

					

				} else {
					$new_colors = array();
				}
				$new[$idx] = array(
					'colors'=>$new_colors,
					'quantity'=>$qty,
					'name'=>$item_name,
					'before_tax'=>$before_tax,
					'item_id'=>$item_id
				);
			}
		}
		
		return $new;
	}
	
}
?>