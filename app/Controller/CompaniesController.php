<?php
App::uses('AppController', 'Controller');
/**
 * Company Controller
 * @property Admin $Admin
 */
class CompaniesController extends AppController {

	public $name = 'Companies';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Invoice','Invoice_item','Company','Invoicesummary');


	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the default layout
		$this->layout = 'admin';
		$this->set('username',AuthComponent::user('username'));
		//set the navigation menu_id		
		$menu_ids = $this->Menu->find('all',array('conditions'=>array('name'=>'Admin')));
		$menu_id = $menu_ids[0]['Menu']['id'];		
		$this->Session->write('Admin.menu_id',$menu_id);
		//set the authorized pages
		$this->Auth->deny('*');
	
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

	public function index()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/companies/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
		
		if($this->request->is('post')){
			$invoice_start = $this->request->data['Company']['start'];
			$invoice_end = $this->request->data['Company']['end'];
			$conditions = array('Invoicesummary.InvoiceNumber BETWEEN ? AND ?' => array($invoice_start,$invoice_end));
			$invoices = $this->Invoicesummary->find('all',array('conditions'=>$conditions));
			$idx = -1;
			$new_invoices = array();
			if(count($invoices)>0){
				foreach ($invoices as $inv) {
					$idx++;
					$invoice_id = $inv['Invoicesummary']['InvoiceNumber'];
					$drop_date = $inv['Invoicesummary']['dropdate'];
					$due_date = $inv['Invoicesummary']['duedate'];
					$items = json_decode($inv['Invoicesummary']['itemschosen'],true);
					$customer_id = $inv['Invoicesummary']['customerid'];
					$colors = json_decode($inv['Invoicesummary']['colorsarray'],true);
					$new_items = $this->Company->new_items($items, $colors);
					$before_tax = $inv['Invoicesummary']['totalprice'];
					$quantity = $inv['Invoicesummary']['totalpieces'];
					$total = $inv['Invoicesummary']['after_taxprice'];
					$pickupdate = $inv['Invoicesummary']['pickedupdate'];
					$rack = $inv['Invoicesummary']['Rack'];
					$rack_date = $inv['Invoicesummary']['Rack_Date'];
					$process = $inv['Invoicesummary']['CleaningProcess'];
					$memo = json_decode($inv['Invoicesummary']['invoice_memo'].true);
					$company_id = 1;
					$cash = $inv['Invoicesummary']['Cash'];
					$credit = $inv['Invoicesummary']['CreditCard'];
					$check = $inv['Invoicesummary']['Checkval'];
					$status = $inv['Invoicesummary']['Status'];
					
					switch($status){
						case 'InProcess':
							$new_status = 1;
						break;
						case 'acct':
							$new_status = 1;
						break;
						case 'ReadyToPickup':
							$new_status = 2;
						break;
						case 'PickedUpPaid':
							$new_status = 5;
						break;
						
					}
					
					$new_invoices[$idx] = array(
						'invoice_id'=>$invoice_id,
						'company_id'=>$company_id,
						'customer_id'=>$customer_id,
						'items'=>json_encode($new_items),
						'quantity'=>$quantity,
						'pretax'=>$before_tax,
						'tax'=>sprintf('%.2f',$total-$before_tax),
						'total'=>$total,
						'reward_id'=>null,
						'discount_id'=>null,
						'rack'=>$rack,
						'rack_date'=>$rack_date,
						'memo'=>$memo,
						'status'=>$new_status,
						'due_date'=>$due_date
						
					
					);
					
				}
			}
			$this->Invoice->saveAll($new_invoices);
		}
		//get invoicesummary data
		
	}
	
	public function add()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/companies/add';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
		if ($this->request->is('post')) {
			if ($this->Company->save($this->request->data)) {
				$this->Session->setFlash(__('The company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'));
			}
		}		
		
	}
	public function edit()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/companies/edit';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);			
	}
	public function view()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/companies/view';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);			
	}
	public function delete()
	{
		
	}
}
