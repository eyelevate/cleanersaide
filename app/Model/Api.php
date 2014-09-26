<?php

App::uses('AppModel', 'Model');
/**
 * app/Model/Api.php
 */
class Api extends AppModel {
    public $name = 'Api';
    //Models
	public function validateSetUserRegistrationData($data)
	{
		$users = array();
		if(isset($data)){
			foreach ($data as $u) {
				$username = $u['username'];
				$phone = $u['contact_phone'];
				$email = $u['contact_email'];
				$fields = array('username');
				$check_username = ClassRegistry::init('User')->find('all',array('conditions'=>array('User.username'=>$username)));
				$check_email = ClassRegistry::init('User')->find('all',array('conditions'=>array('User.contact_email'=>$email)));
				$check_phone = ClassRegistry::init('User')->find('all',array('conditions'=>array('User.contact_phone'=>$phone)));
				$users['username'] = array(
					'errors'=>(count($check_username) >0) ? true : false,
					'reason'=>'Error: Username already exists!'
				);
				$users['email'] = array(
					'errors'=>(count($check_email)>0) ? true : false,
					'reason'=>'Error: Email already exists!'
				);
				$users['phone'] = array(
					'errors'=>(count($check_phone)>0) ? true : false,
					'reason'=>'Error: Phone number already exists!'
				);
			}
		}
		
		return $users;
	}
	
	public function setUserRegistrationDataForDb($data)
	{
		$users = array();
		if(isset($data['company_id'])) {
			$users['User']['company_id'] = 1;
		}
		if(isset($data['group_id'])) {
			$users['User']['group_id'] = 5;
		}

		if(isset($data['username'])) {
			$users['User']['username'] = $data['username'];
		}
		if(isset($data['phone'])) {
			$users['User']['contact_phone'] = $data['phone'];
		}
		if(isset($data['intercom'])) {
			$users['User']['intercom'] = $data['intercom'];
		}
		if(isset($data['password'])) {
			$users['User']['password'] = $data['password'];
		}
		if(isset($data['email'])) {
			$users['User']['email'] = $data['email'];
			$users['User']['contact_email'] = $data['email'];
		}
		if(isset($data['first_name'])) {
			$users['User']['first_name'] = $data['first_name'];
		}
		if(isset($data['last_name'])) {
			$users['User']['last_name'] = $data['last_name'];
		}
		if(isset($data['street'])) {
			$users['User']['contact_address'] = $data['street'];
		}
		if(isset($data['apt'])) {
			$users['User']['contact_suite'] = $data['apt'];
		}
		if(isset($data['city'])) {
			$users['User']['contact_city'] = $data['city'];
		}
		if(isset($data['state'])) {
			$users['User']['contact_state'] = $data['state'];
		}
		if(isset($data['zipcode'])) {
			$users['User']['contact_zip'] = $data['zipcode'];
		}
		if(isset($data['shirt_preference'])) {
			switch($data['shirt_preference']) {
				case 0:
					$preference = 'hanger';
					break;
				case 1:
					$preference = 'box';
					break;
				case 2:
					$preference = 'fold';
					break;
			}
			$users['User']['shirt'] = $preference;
		}
		if(isset($data['shirt_starch'])) {
			switch($data['shirt_starch']) {
				case 0:
					$starch = 'none';
					break;
				case 1:
					$starch = 'light';
					break;
				case 2:
					$starch = 'medium';
					break;
				case 3:
					$starch = 'heavy';
					break;
			}
			$users['User']['starch'] = $starch;
			
		}
		if(isset($data['special_instructions'])) {
			$users['User']['special_instructions'] = $data['special_instructions'];
		}
		$users['User']['contact_country'] = "USA";

		return $users;
	}

}


?>