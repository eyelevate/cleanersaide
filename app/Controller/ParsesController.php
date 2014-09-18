<?php
App::uses('AppController', 'Controller');
/**
 * Parses Controller
 * @property Admin $Admin
 */
class ParsesController extends AppController {

	public $name = 'Parses';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Invoice','Inventory','Inventory_item','Company','Tax','Schedule','Delivery');


	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the default layout
		$this->layout = 'admin';
		//set the navigation menu_id		
		$menu_ids = $this->Menu->find('all',array('conditions'=>array('name'=>'Admin')));
		$menu_id = $menu_ids[0]['Menu']['id'];		
		$this->Session->write('Admin.menu_id',$menu_id);
		//set the authorized pages
		$this->Auth->allow('login','logout','printing');
		//set session max lifetime to 24 hours
		ini_set('session.gc_maxlifetime',24*60*60); //max life 24 hours
		ini_set('session.gc_probability',1);
		ini_set('session.gc_divisor',1);
		$this->requireNonSecure('login','index');
		
		if (!is_null($this->Auth->User()) && $this->name != 'CakeError'&& !$this->Acl->check(array('model' => 'User','foreign_key' => AuthComponent::user('id')),$this->name . '/' . $this->request->params['action'])) {
		    // Optionally log an ACL deny message in auth.log
		    CakeLog::write('auth', 'ACL DENY: ' . AuthComponent::user('username') .
		        ' tried to access ' . $this->name . '/' .
		        $this->request->params['action'] . '.'
		    );
		
		    // Render the forbidden page instead of the current requested page
		    $this->Session->setFlash(__('You are not authorized to view this page. Please log in.'),'default',array(),'error');
		    echo $this->redirect(array('controller'=>'admins','action'=>'index'));
		
		    /**
		     * Make sure we halt here, otherwise the forbidden message
		     * is just shown above the content.
		     */

		
		}	

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
			$validate = $this->Parse->validateSetUserRegistrationData($this->request->data);
		
			if($validate['status'] == true) {
				// Save the user
				$users = $this->Parse->setUserRegistrationDataForDb($this->request->data);
				$this->User->create();
				if ($this->User->save($users)) {
					// Return success status
					return json_encode(array('status'=>true));
				} else {
					// Return fail status
					return json_encode($validate);
				}
				
			} else {
				
				// Return fail status
				return json_encode($validate);
			}
		}
	}
	

}
