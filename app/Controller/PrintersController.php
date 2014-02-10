<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'WebclientPrint/WebclientPrint');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class PrintersController extends AppController {
	public $name = 'Printers';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Invoice','Invoice_item','Company','Tax','Inventory','Inventory_item','Delivery');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the default layout
		$this->layout = 'ajax';
		//set the navigation menu_id		
		$menu_ids = $this->Menu->find('all',array('conditions'=>array('name'=>'Admin')));
		$menu_id = $menu_ids[0]['Menu']['id'];		
		$this->Session->write('Admin.menu_id',$menu_id);
		//set the authorized pages
		$this->Auth->allow('home','index','print_commands_process','print_commands','print_file','print_file_process','template');
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
		$this->layout = 'ajax';
		$wcp = new Neodynamic\SDK\Web\WebClientPrint();
		$head = $wcp->getWcppDetectionMetaTag();
		$detection_script = $wcp->createWcppDetectionScript();
		$this->set('head',$head);
	}
	
	public function home()
	{
		
	}
	
	public function print_tag1($id = null, $number = null)
	{
		$invoices = $this->Invoice->find('all',array('conditions'=>array('invoice_id'=>$id,'company_id'=>$_SESSION['company_id'])));
		$invoice_data = array();
		if(count($invoices)>0){
			foreach ($invoices as $inv) {
				$customer_id = $inv['Invoice']['customer_id'];
				
				//get customer_date
				$custs = $this->User->find('all',array('conditions'=>array('User.id'=>$customer_id)));
				if(count($custs)>0){
					foreach ($custs as $c) {
						$first_name = $c['User']['first_name'];
						$last_name = $c['User']['last_name'];
						$phone = $this->Delivery->formatPhoneNumber($c['User']['contact_phone']);
					}
				}
				$inventory_id = '';
				$items = json_decode($inv['Invoice']['items'],true);
				if(count($items)>0){
					foreach ($items as $ikey => $ivalue) {
						$item_id = $items[$ikey]['item_id'];
					}
				}
				$inventories = $this->Inventory_item->find('all',array('conditions'=>array('id'=>$item_id)));
				if(count($inventories)>0){
					foreach ($inventories as $ii) {
						$inventory_id = $ii['Inventory_item']['inventory_id'];
					}
				}
				$quantity = $inv['Invoice']['quantity'];
				$invoice_id = $inv['Invoice']['invoice_id'];
				$due_date = date('n/d',strtotime($inv['Invoice']['due_date']));
				$due_day = date('D',strtotime($inv['Invoice']['due_date']));
				$invoice_data= array(
					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'phone'=>$phone,
					'quantity'=>$quantity,
					'invoice_id'=>$invoice_id,
					'due_date'=>$due_date,
					'due_day'=>$due_day,
					'inventory_id'=>$inventory_id
					
				);
			}
		}
		$this->set('number',$number);
		$this->set('invs',$invoice_data);
	}
	
	public function print_tag2($id = null)
	{
		
	}

}