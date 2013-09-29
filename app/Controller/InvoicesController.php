<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 * @property Admin $Admin
 */
class InvoicesController extends AppController {

	public $name = 'Invoices';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Invoice', 'Inventory_item','Inventory','Tax');


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
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);		
		//setup variables
		$company_id = $_SESSION['company_id'];
		
		//get data from db
		$users = $this->User->find('all',array('conditions'=>array('User.id'=>$id)));
		$invoices = $this->Invoice->find('all',array('conditions'=>array('customer_id'=>$id,'status <'=>'4','company_id'=>$company_id)));
		
		
		
		//push data to view page
		$this->set('users',$users);
		$this->set('customer_id',$id);		
		$this->set('invoices',$invoices);
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

		//tax
		$taxes = $this->Tax->find('all',array('conditions'=>array('company_id'=>$company_id)));
		
				
		// //get colors
		// $colors = $this->Color->find('all',array('conditions'=>array('company_id'=>$company_id)));
		
		//get basic due date
		$due = date('n/d/Y',strtotime($this->Invoice->date_due()));
		
		$this->set('inv_groups',$inv_groups);
		$this->set('inv_items',$inv_items);
		$this->set('taxes',$taxes);
		$this->set('customer_id',$id);
		$this->set('due_date',$due);
		
			
	}
	public function edit($invoice_id = null)
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

		//tax
		$taxes = $this->Tax->find('all',array('conditions'=>array('company_id'=>$company_id)));
		
				
		// //get colors
		// $colors = $this->Color->find('all',array('conditions'=>array('company_id'=>$company_id)));
		
		//get invoice information
		$invoices = $this->Invoice->find('all',array('conditions'=>array('invoice_id'=>$invoice_id,'company_id'=>$company_id)));
		

		
		$this->set('inv_groups',$inv_groups);
		$this->set('inv_items',$inv_items);
		$this->set('taxes',$taxes);
		$this->set('invoice_id',$invoice_id);
		$this->set('invoices',$invoices);
				
	}
	
	public function rack()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/invoices/rack';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);
		//set the action levels
		$group_id = $this->Auth->user('group_id');
		
		//setup variables
		$company_id = $_SESSION['company_id'];

		
				
	}

/**
 * pickup method
 *
 * @return void
 */
	public function pickup($id = null) {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/invoices/pickup';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);
		//set the action levels
		$group_id = $this->Auth->user('group_id');
		
		//setup variables
		$company_id = $_SESSION['company_id'];
		
		//get data from db
		$users = $this->User->find('all',array('conditions'=>array('User.id'=>$id)));
		$invoices = $this->Invoice->find('all',array('conditions'=>array('customer_id'=>$id,'status <'=>'4','company_id'=>$company_id)));
		
		//push data to view page
		$this->set('users',$users);
		$this->set('customer_id',$id);		
		$this->set('invoices',$invoices);
		


	}
	
	function process_pickup()
	{
		$print = $this->request->data['Invoice']['print'];
		$customer_id = $this->request->data['Invoice']['customer_id'];
		$company_id = $_SESSION['company_id'];
		$total_bt = $this->request->data['Invoice']['total_bt'];
		$quantity = $this->request->data['Invoice']['quantity'];
		$total_tax = $this->request->data['Invoice']['total_tax'];
		foreach ($this->request->data['Invoice']['picked_up'] as $key => $value) {
			$invoice_id = $value['invoice_id'];

			$this->Invoice->query('update invoices set status = 5 where invoice_id ='.$invoice_id.' and company_id ='.$company_id.'');
		}
		
		switch($print){
			case 'Yes':
				//place printing code here
			break;
				
			default:
				$this->Session->setFlash(__('You have successfully finished a pickup reservation session.'),'default',array(),'success');
				$this->redirect(array('controller'=>'invoices','action'=>'dropoff',$customer_id));
			break;
		}
	}
	
	public function process_dropoff_no_copy()
	{
		if($this->request->is('post')){

			$customer_id = $this->request->data['Invoice']['customer_id'];
			$this->request->data['Invoice']['due_date'] = date('Y-m-d',strtotime($this->request->data['Invoice']['due_date'])).' 16:00:00';
			$due_date = $this->request->data['Invoice']['due_date'];
			//add in special variables
			$invoice_complete = $this->Invoice->invoice_complete($this->request->data);	
			//reorganize inventory by type and save into invoices table
					
			$items = $this->request->data['Invoice']['items'];	
			$store_copy = $this->Inventory_item->reorganizeByInventory($items);	
			
			$invoice_split = $this->Invoice->invoice_split($store_copy, $customer_id, $due_date);

			if($this->Invoice->saveAll($invoice_split['Invoice'])){
				
				$this->set('store',$store_copy);		

			}

		}
	}
	
	public function process_dropoff_copy()
	{
		if($this->request->is('post')){

			$customer_id = $this->request->data['Invoice']['customer_id'];
			$this->request->data['Invoice']['due_date'] = date('Y-m-d',strtotime($this->request->data['Invoice']['due_date'])).' 16:00:00';
			$due_date = $this->request->data['Invoice']['due_date'];
			//add in special variables
			$invoice_complete = $this->Invoice->invoice_complete($this->request->data);	
			//reorganize inventory by type and save into invoices table
					
			$items = $this->request->data['Invoice']['items'];	
			$store_copy = $this->Inventory_item->reorganizeByInventory($items);	
			
			$invoice_split = $this->Invoice->invoice_split($store_copy, $customer_id, $due_date);

			if($this->Invoice->saveAll($invoice_split['Invoice'])){
	
				
				$this->set('customer',$this->request->data);
				$this->set('store',$store_copy);			
			}
		}
	}
	
	public function process_edit()
	{
		if($this->request->is('post')){

			//get unique id of invoice
			$company_id = $_SESSION['company_id'];
			$invoice_id = $this->request->data['Invoice']['invoice_id'];
			$invoices = $this->Invoice->find('all',array('conditions'=>array('invoice_id'=>$invoice_id,'company_id'=>$company_id)));
			$this->request->data['Invoice']['due_date'] = date('Y-m-d',strtotime($this->request->data['Invoice']['due_date'])).' 16:00:00';
			$this->request->data['Invoice']['items'] = json_encode($this->request->data['Invoice']['items']);
			
			if(count($invoices)>0){
				foreach ($invoices as $invoice) {
					$id = $invoice['Invoice']['id'];
					$customer_id = $invoice['Invoice']['customer_id'];
				}
				$this->Invoice->id = $id;

				if($this->Invoice->save($this->request->data)){
					$this->Session->setFlash(__('Invoice #'.$invoice_id.' has been successfully edited.'),'default',array(),'success');
					$this->redirect(array('controller'=>'invoices','action'=>'index',$customer_id));
				}
				
			} else {
				$this->Session->setFlash(__('No such invoice was created. Please search again.'),'default',array(),'error');
				$this->redirect(array('controller'=>'admin','action'=>'index'));				
			}


		}		
	}

	public function process_rack()
	{
		$company_id = $_SESSION['company_id'];
		
		if($this->request->is('post')){

			//first determine if we are sending out emails
			$emails = $this->request->data['Email'];
			switch($emails){
				case 'Yes':
					$emailData = array(); //start email data array

					foreach ($this->request->data['Invoice'] as $invoice) {
						$invoice_id = $invoice['invoice_id'];
						$emailData = $this->Invoice->rackEmailData($emailData,$invoice_id, $company_id);

					}
					
					//$emailScript =$this->Invoice->rackEmailScript($emailData);

				break;
					

			}
			//next save the racked data
			foreach ($this->request->data['Invoice'] as $rack) {

				$this->Invoice->query('update invoices set rack="'.$rack['rack'].'", status="3" where invoice_id="'.$rack['invoice_id'].'" and company_id ="'.$company_id.'"');
			}
			$this->Session->setFlash(__('You have successfully racked '.count($this->request->data['Invoice']).' invoices!'),'default',array(),'success');
			$this->redirect(array('controller'=>'invoices','action'=>'rack'));
		}
	}



}
