<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 * @property Admin $Admin
 */
class AdminsController extends AppController {

	public $name = 'Admins';
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
		unset($_SESSION['customer_id']);
		unset($_SESSION['customers']);
		unset($_SESSION['login']);
		unset($_SESSION['error']);

	}



/**
 * Displays login
 * 
 * @return void
 */
	public function login()
	{
		//No admin navigation here
		$this->layout = 'admin_login';
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
		            return $this->redirect(array('controller'=>'admins','action'=>'index'));
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
		
		//get invoice dropoff data
		$today_beginning = date('Y-m-d ').'00:00:00';
		$today_end = date('Y-m-d ').'23:59:59';
		$today_conditions = array('created BETWEEN ? AND ?' =>array($today_beginning, $today_end));
		$today = $this->Invoice->find('all',array('conditions'=>$today_conditions));
		$split_invoices = $this->Inventory_item->today_invoices($today);
		$this->set('split_invoices',$split_invoices);
		$pickup_conditions = array('modified BETWEEN ? AND ?' =>array($today_beginning, $today_end),'status'=>'3');
		$pickup = $this->Invoice->find('all',array('conditions'=>$pickup_conditions));
		$pickup_invoices = $this->Inventory_item->today_invoices($pickup);

		$this->set('pickup_invoices',$pickup_invoices);
		//get delivery data
		$schedules = $this->Schedule->regexDisplay($this->Schedule->find('all',array('conditions'=>$today_conditions)));
		$this->set('schedules',$schedules);
		$this->set('date_label', date('D n/d/Y'));
		$this->set('start_date',date('n/d/Y'));
		$this->set('end_date',date('n/d/Y'));
		

		if($this->request->is('post')){
			
			//get invoice dropoff data
			$today_beginning = date('Y-m-d ', strtotime($this->request->data['date']['start_date'])).'00:00:00';
			$today_end = date('Y-m-d ', strtotime($this->request->data['date']['end_date'])).'23:59:59';
			$today_conditions = array('created BETWEEN ? AND ?' =>array($today_beginning, $today_end));
			$today = $this->Invoice->find('all',array('conditions'=>$today_conditions));
			$split_invoices = $this->Inventory_item->today_invoices($today);
			$this->set('split_invoices',$split_invoices);
			$pickup_conditions = array('modified BETWEEN ? AND ?' =>array($today_beginning, $today_end),'status'=>'3');
			$pickup = $this->Invoice->find('all',array('conditions'=>$pickup_conditions));
			$pickup_invoices = $this->Inventory_item->today_invoices($pickup);
			$this->set('pickup_invoices',$pickup_invoices);
			//get delivery data
			$schedules = $this->Schedule->regexDisplay($this->Schedule->find('all',array('conditions'=>$today_conditions)));
			$this->set('schedules',$schedules);			
			$this->set('date_label', date('D n/d/Y',strtotime($this->request->data['date']['start_date'])).' - '.date('D n/d/Y',strtotime($this->request->data['date']['end_date'])));
			$this->set('start_date',date('n/d/Y', strtotime($this->request->data['date']['start_date'])));
			$this->set('end_date',date('n/d/Y', strtotime($this->request->data['date']['end_date'])));		
		}
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
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);
		if($this->request->is('post')){
			$query = $this->request->data['query'];
			if(is_numeric($query)){
				$length = strlen($query);
				switch($length){
					case '4': //this is a customer id
						$users = $this->User->find('all',array('conditions'=>array('User.id'=>$query)));
					break;
					case '6':
						$invoices = $this->Invoice->find('all',array('conditions'=>array('invoice_id'=>$query)));
						if(count($invoices)>0){
							foreach ($invoices as $inv) {
								$customer_id = $inv['Invoice']['customer_id'];
							}
						} else {
							$customer_id = '';
						}
						$users = $this->User->find('all',array('conditions'=>array('User.id'=>$customer_id)));
						
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
