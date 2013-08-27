<?php
App::uses('AppModel', 'Model');
/**
 * app/Model/Admin.php
 */
class Company extends AppModel {
    public $name = 'Company';
	
	
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
				//set cookie
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
	
}
?>