<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Group $Group
 */
class User extends AppModel {
	public $name = 'User';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	
	
	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }
	public function bindNode($user) {
	    return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}
/**
 * Before save method
 * 
 */
	public function beforeSave($options = array())
	{
		if(!empty($this->data['User']['password'])){
	   		$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
	    return true;
	}
/**
 * Permissions
 */
	///Validation array
	public $validate = array(
		'group_id'=>array(
			'rule'=>'notEmpty',
			'message'=>'This field cannot be left blank'
		),
		'username' =>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			),
			'unique'=>array(
				'rule'=>'isUnique',
				'message'=>'This username has already been taken. Enter in a new username.'
			)
		), 

		'contact_email'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),
		'first_name'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'				
			)
		),
		'last_name'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),


		'contact_address'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_city'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_state'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_zip'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_email'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			),
			'email'=>array(
				'rule'=>'email',
				'message'=>'This is not a valid email'
			)
		),
		'phone'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_phone'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			),
			'unique'=>array(
				'rule'=>'isUnique',
				'message'=>'This phone number has already been taken. Enter in a new phone number.'
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
		'card_full_name'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'ccnum'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'				
			),
			'cc'=>array(
				'rule'    => array('cc', array('visa','mc','disc','amex'), false, null),
				'message' => 'The credit card number you supplied was invalid.'
			)
		),
		'cvv'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			),
		    'numeric' => array(
		        'rule'    => 'numeric',
		        'message' => 'CVV must be numeric digit'
		    ),
		    'minLength' => array(
		        'rule'    => array('minLength', 3),
		        'message' => 'CVV must be at least 3 digits in length'
		    ),
		    'maxLength'=>array(
				'rule'=>array('maxLength',4),
				'message'=>'CVV must at least 3 to 4 digits in length'
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
	public function equals($field = array(),$check)
	{
		
		
		foreach ($field as $key => $value) {
			$v1 = $value;
			if($v1 == $check){
				return FALSE;
			}
		}
		
		return TRUE;
	}
	public function saveNewCustomer($data)
	{
		$data['User']['group_id'] = '3';
		$this->save($data);
	}

	public function emailForgottenPassword($email, $id)
	{
		//first create a token	
		$valid_chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
		$length = '8';
		$random_token = $this->get_random_string($valid_chars, $length);
		
		//next update teh database with the new token
		$update = array();
		$update['User']['token'] = $random_token;
		$this->id = $id;
		$this->save($update);
		
		return $random_token;		
		
	}
	
/**
 * Creates the random string
 * 
 * This is used for the confirmation code or any other code needed
 * 
 * user must input the valid characters and the length of the string
 * 
 * @return string
 */
	public function get_random_string($valid_chars, $length)
	{
	    // start with an empty random string
	    $random_string = "";
	
	    // count the number of chars in the valid chars string so we know how many choices we have
	    $num_valid_chars = strlen($valid_chars);
	
	    // repeat the steps until we've created a string of the right length
	    for ($i = 0; $i < $length; $i++)
	    {
	        // pick a random number from 1 up to the number of valid chars
	        $random_pick = mt_rand(1, $num_valid_chars);
	
	        // take the random character out of the string of valid chars
	        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
	        $random_char = $valid_chars[$random_pick-1];
	
	        // add the randomly-chosen char onto the end of our string so far
	        $random_string .= $random_char;
	    }
	
	    // return our finished random string
	    return $random_string;
	}
		
	
	// public function convertOldUserToNew()
	// {
		// //first get old user
// 		
		// $old = ClassRegistry::init('User')->find('all',array('conditions'=>array('User.id >='=>100, 'User.id <'=>1000)));
		// $lft = 74;
		// $rht = 75;
// 		
		// $new = array();
		// if(count($old)>0){
			// foreach ($old as $key => $value) {
				// $lft = $lft + 2;
				// $rht = $rht +2;
				// $new_id = $old[$key]['User']['id'];
				// $new[$new_id]['parent_id'] = 6;
				// $new[$new_id]['model'] = 'User';
				// $new[$new_id]['foreign_key'] = $new_id;
				// $new[$new_id]['lft'] = $lft;
				// $new[$new_id]['rght'] = $rht;
// 				
// 
			// }
		// }
// 
		// return $new;
// 		
	// }
	// public function cleanPhone($phone)
	// {
		// $phone = preg_replace("/[^0-9]/","",$phone);
		// $phone = str_replace(' ', '', $phone);
		// $phone = trim($phone);
// 		
		// return $phone;
	// }
	
}
