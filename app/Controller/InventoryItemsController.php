<?php

/**
 * app/Controller/Inventory_itemsController.php
 */
class InventoryItemsController extends AppController {
    //Name (should be same as the class name)
    public $name = 'Inventory_items';

	public $uses = array('Inventory_item','Inventory','Menu','Menu_item','Ferry_inventory', 'Reservation');
/**
 * Parses this code first on all actions in this controller
 */
	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the authorized username
		$this->set('username',AuthComponent::user('username'));
		//deny all public users to this page
		$this->Auth->deny('*');
		// if (!is_null($this->Auth->User()) && $this->name != 'CakeError'&& !$this->Acl->check(array('model' => 'User','foreign_key' => AuthComponent::user('id')),$this->name . '/' . $this->request->params['action'])) {
		    // // Optionally log an ACL deny message in auth.log
		    // CakeLog::write('auth', 'ACL DENY: ' . AuthComponent::user('username') .
		        // ' tried to access ' . $this->name . '/' .
		        // $this->request->params['action'] . '.'
		    // );
// 		
		    // // Render the forbidden page instead of the current requested page
		    // $this->Session->setFlash(__('You do not have access to this page.'),'default',array(),'error');
		    // echo $this->redirect(array('controller'=>'admins','action'=>'index'));
// 		
		    // /**
		     // * Make sure we halt here, otherwise the forbidden message
		     // * is just shown above the content.
		     // */
// 
// 		
		// }	
		//setup the layout on the page
		$this->layout = 'admin';
		
		//set shopping cart
		$ferry_session = $this->Session->read('Reservation_ferry');
		if(!empty($ferry_session['Reservation'])){
			$ferry_sidebar = $this->Reservation->sidebar_ferry($ferry_session);
		} else {
			$ferry_sidebar = array();
		}
		$hotel_session = $this->Session->read('Reservation_hotel');
		if(!empty($hotel_session)){
			$hotel_sidebar = $this->Reservation->sidebar_hotel($hotel_session);
		} else {
			$hotel_sidebar = array();
		}
		$attraction_session = $this->Session->read('Reservation_attraction');
		if(!empty($attraction_session)){
			$attraction_sidebar = $this->Reservation->sidebar_attraction($attraction_session);
		} else {
			$attraction_sidebar = array();
		}
		$package_session = $this->Session->read('Reservation_package');
		if($this->Session->check('Reservation_package')==true){
			$package_sidebar = $this->Reservation->sidebar_package($package_session);
		} else {
			$package_sidebar = array();
		}
		$this->set('package_sidebar',$package_sidebar);
		$this->set('ferry_sidebar',$ferry_sidebar);
		$this->set('hotel_sidebar',$hotel_sidebar);
		$this->set('attraction_sidebar',$attraction_sidebar);
		
	}
    //Actions
	public function index()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/inventory_items/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);	
		//paginate the users and send to view
		$this->paginate = array(
		    'limit' => 100, // this was the option which you forgot to mention
		    'order' => array(
		        'Inventory_item.id' => 'ASC')
		);	
		$inv_items = $this->Inventory_item->fixLargeData($this->paginate('Inventory_item'));	
		$this->Inventory_item->recursive = 0;
		
		$this->set('inventory_items', $inv_items);				
	}
	
	public function add()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/inventory_items/add';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//get inventory types
		$inventories = $this->Inventory->find('all');
		$this->set('inventories',$inventories);
		$images = $this->Inventory_item->createAllImageArray();
		$this->set('images',$images);
		

		if($this->request->is('post')){
			//create the form data
			$this->request->data['Inventory_item']['company_id'] = $_SESSION['company_id'];


			if($this->Inventory_item->save($this->request->data)){
				$this->Session->setFlash('Your inventory item has been saved','default',array(),'success');
				$this->redirect(array('action'=>'index'));
			}
		}	
	}
	
	public function edit($id = null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/inventory_items/edit';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//get inventory types
		$inventories = $this->Inventory->find('all');
		$this->set('inventories',$inventories);
		$inv_items = $this->Inventory_item->find('all',array('conditions'=>array('id'=>$id)));
		$this->set('inv_items',$inv_items);
		
		if($this->request->is('post')){
			
			$this->Inventory_item->id =$id;

			if($this->Inventory_item->save($this->request->data)){
				$this->Session->setFlash('Your inventory item has been saved','default',array(),'success');
				$this->redirect(array('action'=>'index'));
			}
		}	
	}
	
	public function view($id= null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/inventory_items/view';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//if exists
		$this->Inventory_item->id = $id;
		if (!$this->Inventory_item->exists()) {
			throw new NotFoundException(__('Invalid Iventory Item'));
		}
		//get from db
		$inv_items = $this->Inventory_item->fixData($this->Inventory_item->read(null, $id));
		$this->set('inv_items', $inv_items);	

	}
	
	public function delete($id = null)
	{
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Inventory_item->id = $id;
		if (!$this->Inventory_item->exists()) {
			throw new NotFoundException(__('Invalid Passenger'));
		}
		if ($this->Inventory_item->delete()) {
			$this->Session->setFlash(__('Inventory deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Inventory was not deleted'));
		$this->redirect(array('action' => 'index'));		
	}
}


?>