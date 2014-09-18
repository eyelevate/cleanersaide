<?php

App::uses('AppModel', 'Model');
/**
 * app/Model/Admin.php
 */
class Admin extends AppModel {
    public $name = 'Parse';
    //Models
	public function validateSetUserRegistrationData($data)
	{
		if(isset($data['name'])) {
			
		}
		if(isset($data['phone'])) {
			
		}
		if(isset($data['password'])) {
			
		}
		if(isset($data['email'])) {
			
		}
		if(isset($data['street'])) {
			
		}
		if(isset($data['first_name'])) {
			
		}
		if(isset($data['last_name'])) {
			
		}

		if(isset($data['city'])) {
			
		}
		if(isset($data['state'])) {
			
		}
		if(isset($data['zipcode'])) {
			
		}
		
		return $data;
	}
	
	public function setUserRegistrationDataForDb($data)
	{
		$users = array();
		if(isset($data['name'])) {
			$users['User']['name'] = $data['name'];
		}
		if(isset($data['phone'])) {
			$users['User']['phone'] = $data['phone'];
		}
		if(isset($data['password'])) {
			$users['User']['password'] = $data['password'];
		}
		if(isset($data['email'])) {
			$users['User']['email'] = $data['email'];
		}

		if(isset($data['first_name'])) {
			$users['User']['first_name'] = $data['first_name'];
		}
		if(isset($data['last_name'])) {
			$users['User']['last_name'] = $data['last_name'];
		}
		if(isset($data['street'])) {
			$users['User']['street'] = $data['street'];
		}
		if(isset($data['city'])) {
			$users['User']['city'] = $data['city'];
		}
		if(isset($data['state'])) {
			$users['User']['state'] = $data['state'];
		}
		if(isset($data['zipcode'])) {
			$users['User']['zipcode'] = $data['zipcode'];
		}
		return $users;
	}

}


?>