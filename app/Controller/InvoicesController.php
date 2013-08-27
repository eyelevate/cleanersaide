<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 * @property Admin $Admin
 */
class InvoicesController extends AppController {

	public $name = 'Invoices';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Invoice', 'Inventory_item','Inventory','Inventory_item');


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

	public function index($id = null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/invoices/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//get data from db
		$users = $this->User->find('all',array('conditions'=>array('User.id'=>$id)));
		$invoices = $this->Invoice->find('all',array('conditions'=>array('customer_id'=>$id,'status'=>'1')));
		
		
		
		//push data to view page
		$this->set('users',$users);
		$this->set('customer_id',$id);		
	}

/**
 * Displays dropoff page
 * 
 * @return void
 */
	public function dropoff($id = null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/invoices/dropoff';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);
	
		$company_id = $_SESSION['company_id'];

		// //get inventory group_data
		$inv_groups = $this->Inventory->find('all',array('conditions'=>array('company_id'=>$company_id)));
		$inv_items = $this->Inventory_item->find('all',array('conditions'=>array('company_id'=>$company_id)));

// 		
		// //get colors
		// $colors = $this->Color->find('all',array('conditions'=>array('company_id'=>$company_id)));
		
		$this->set('inv_groups',$inv_groups);
		$this->set('inv_items',$inv_items);
		
			
	}

/**
 * pickup method
 *
 * @return void
 */
	public function pickup() {
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
	public function process_dropoff()
	{

	}

	public function process_pickup()
	{

	}


}
