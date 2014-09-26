<?php
App::uses('AppController', 'Controller');
/**
 * Apis Controller
 * @property Admin $Admin
 */
class ApisController extends AppController {

	public $name = 'Apis';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Invoice','Inventory','Inventory_item','Company','Tax','Schedule','Delivery','Api');


	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the default layout
		//$this->layout = 'admin';
		//set the navigation menu_id		
		$menu_ids = $this->Menu->find('all',array('conditions'=>array('name'=>'Admin')));
		$menu_id = $menu_ids[0]['Menu']['id'];		
		$this->Session->write('Admin.menu_id',$menu_id);
		//set the authorized pages
		$this->Auth->allow('login','logout','printing','set_user_registration');
		//set session max lifetime to 24 hours
		ini_set('session.gc_maxlifetime',24*60*60); //max life 24 hours
		ini_set('session.gc_probability',1);
		ini_set('session.gc_divisor',1);
		$this->requireNonSecure('login','index','set_user_registration');
		
		// if (!is_null($this->Auth->User()) && $this->name != 'CakeError'&& !$this->Acl->check(array('model' => 'User','foreign_key' => AuthComponent::user('id')),$this->name . '/' . $this->request->params['action'])) {
		    // // Optionally log an ACL deny message in auth.log
		    // CakeLog::write('auth', 'ACL DENY: ' . AuthComponent::user('username') .
		        // ' tried to access ' . $this->name . '/' .
		        // $this->request->params['action'] . '.'
		    // );
// 		
		    // // Render the forbidden page instead of the current requested page
		    // $this->Session->setFlash(__('You are not authorized to view this page. Please log in.'),'default',array(),'error');
		    // echo $this->redirect(array('controller'=>'admins','action'=>'index'));
// 		
		    // /**
		     // * Make sure we halt here, otherwise the forbidden message
		     // * is just shown above the content.
		     // */
// 
// 		
		// }	

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
	}
	public function set_user_registration()
	{
		if($this->request->is('post')) {
			// Save the user
			$api_data = file_get_contents('php://input');
			$api_string = json_decode($api_data,true);
			$api_key = $api_string['api_key'];
			$users = $this->Api->setUserRegistrationDataForDb($api_string['params']);
			$validate_users = $this->Api->validateSetUserRegistrationData($users);
			$check_validation = false;
			foreach ($validate_users as $key => $value) {
				$errors = $validate_users[$key]['errors'];
				if($errors == true) {
					$check_validation = true;
					break;
				}
			}
			
			if($check_validation == false) {
				$this->User->create();
				if ($this->User->save($users)) {
					// Return success status
					return new CakeResponse(array('body' => json_encode(array('status'=>true,'description'=>null, 'validation'=>null))));
				} else {
					// Return fail status
					return new CakeResponse(array('body' => json_encode(array('status'=>false,'reason'=>'Error saving.','validation'=>null))));
				}				
			} else {
				return new CakeResponse(array(
					'body' => json_encode(array(
						'status'=>false,
						'reason'=>'Validation errors.',
						'validation'=>$validate_users
						)
					)
				));	
			}
		}
	}

	public function login($api_key=null)
	{
		
	}
	

}
