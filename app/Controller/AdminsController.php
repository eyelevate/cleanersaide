<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 * @property Admin $Admin
 */
class AdminsController extends AppController {

	public $name = 'Admins';
	public $uses = array('User','Group','Page','Menu','Menu_item','Attraction_ticket', 'Reservation','Admin');


	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the default layout
		$this->layout = 'admin';
		//set the navigation menu_id		
		$menu_ids = $this->Menu->find('all',array('conditions'=>array('name'=>'Admin')));
		if(count($menu_ids)>0){
			$menu_id = $menu_ids[0]['Menu']['id'];	
		} else {
			$menu_id = null;
		}	
		$this->Session->write('Admin.menu_id',$menu_id);
		//set the authorized pages
		$this->Auth->allow('logout','login');

	}



/**
 * Displays login
 * 
 * @return void
 */
	public function login()
	{

		$this->layout = 'admin';
		//No admin navigation here

		//set autherror to page
		$this->set('authError',$this->Auth->authError);
		
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

	public function dropoff()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/admins/dropoff';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
		
		//if no customer phone number was entered
		
		
		//if customer phone number was entered
		if($this->request->is('post')){
			
		}
	}
}
