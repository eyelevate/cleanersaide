<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 * @property Admin $Admin
 */
class AdminsController extends AppController {

	public $name = 'Admins';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Invoice','Invoice_item','Company');


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
		$this->Auth->allow('login','logout');
	
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
 * Displays login
 * 
 * @return void
 */
	public function login()
	{
		//No admin navigation here
		
		//set autherror to page
		$this->set('authError',$this->Auth->authError);

		//check to see if the company has been logged in 
		if(isset($_COOKIE['company_id']) && !empty($_COOKIE['company_id'])){ //company has been logged in now show the employee login
			$this->Session->write('company_id',$_COOKIE['company_id']);
			//set the title
	 		if ($this->request->is('post')) {
		    	//check to see if the username, company_id, password bring back a row
		    	$username = $this->request->data['User']['username'];
				//login User with auth component
		        if ($this->Auth->login()) {
		            return $this->redirect($this->Auth->redirect());
		        } else {
		        //the password is incorrect 
		            $this->Session->setFlash(__('Password is incorrect'));  
				}
			}			
		} else { //company has not been logged
			
			
			if($this->request->is('post')){
				$username = $this->request->data['Company']['owner'];
				$password = $this->Company->hashPasswords($this->request->data['Company']['password']);
				$search_company = $this->Company->company_login($username, $password);
				if($search_company == true){
					$this->Session->setFlash('You have successfully logged in. Your session will expire in 24 hours.','default',array(),'success');
					
					$this->redirect(array('controller'=>'admins','action'=>'login'));
					
				} else {
					$this->Session->setFlash('Your company username and password do not match. Please try again','default',array(),'error');
				}
				
			} 
		}
//setcookie('company_id', "", time()-3600);
				
	}
/**
 * logsout and sends back to PagesContoller=>index
 * 
 * @return void
 */
	public function logout()
	{
		$this->Session->setFlash(__('You have successfully logged out.'));
		$this->redirect($this->Auth->logout());
	}


/**
 * index method
 *
 * @return void
 */
	public function index() {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/admins/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);
		//set the action levels
		$group_id = $this->Auth->user('group_id');
		


	}
	public function search_customers()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/admins/search_customers';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		if($this->request->is('post')){
			$query = $this->request->data['query'];
			if(is_numeric($query)){
				$length = strlen($query);
				switch($length){
					case '4': //this is a customer id
						$users = $this->User->find('all',array('conditions'=>array('User.id'=>$query)));
					break;
						
					case '7': //this is a phone
						$users = $this->User->find('all',array('conditions'=>array('User.contact_phone LIKE'=>'%'.$query.'%')));
					break;
						
					case '10': //this is a 10 digit phone
						$users = $this->User->find('all',array('conditions'=>array('User.contact_phone LIKE'=>'%'.$query.'%')));
					break;
					
					default:
						$users = $this->User->find('all',array('conditions'=>array('User.contact_phone LIKE'=>'%'.$query.'%')));
					break;
				}
			} else {
				$users = $this->User->find('all',array('conditions'=>array('User.last_name LIKE'=>'%'.$query.'%')));
			}
			
			if(count($users) == 1){
				foreach ($users as $u) {
					$id = $u['User']['id'];
				}
				
				
				$this->redirect(array('controller'=>'invoices','action'=>'index',$id));
			} elseif (count($users)>1) {
				$this->set('users',$users);
			} else {
				$this->Session->setFlash(__('No such customer. Please try your search again'),'default',array(),'error');
				$this->redirect(array('controller'=>'invoices','action'=>'index'));
			}
		}
	}




}
