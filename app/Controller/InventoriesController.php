<?php

/**
 * app/Controller/InventoriesController.php
 */
class InventoriesController extends AppController {
    //Name (should be same as the class name)
    public $name = 'Inventories';

	public $uses = array('Inventory','Inventory_item','Menu','Menu_item','Incremental_unit', 'Reservation');
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
		if (!is_null($this->Auth->User()) && $this->name != 'CakeError'&& !$this->Acl->check(array('model' => 'User','foreign_key' => AuthComponent::user('id')),$this->name . '/' . $this->request->params['action'])) {
		    // Optionally log an ACL deny message in auth.log
		    CakeLog::write('auth', 'ACL DENY: ' . AuthComponent::user('username') .
		        ' tried to access ' . $this->name . '/' .
		        $this->request->params['action'] . '.'
		    );
		
		    // Render the forbidden page instead of the current requested page
		    $this->Session->setFlash(__('You do not have access to this page.'),'default',array(),'error');
		    echo $this->redirect(array('controller'=>'admins','action'=>'index'));
		
		    /**
		     * Make sure we halt here, otherwise the forbidden message
		     * is just shown above the content.
		     */

		
		}	
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
		$page_url = '/inventories/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);	
		
		//paginate the users and send to view
		$this->paginate = array(
		    'limit' => 10, // this was the option which you forgot to mention
		    'order' => array(
		        'Inventory.id' => 'ASC')
		);		

		$inventories = $this->Inventory->fixLargeData($this->paginate('Inventory'));
		$this->Inventory->recursive = 0;
		$this->set('inventories', $inventories);		
		
		//count the amount of inventory items 		
	}
/**	
 * Creating a new inventory type
 * 
 * @return void
 */
	public function add($id = null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/inventories/add';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);	
		
		if($this->request->is('post')){
			$this->request->data['Inventory']['ferry_id'] = 1;
			if(!empty($this->request->data['Inventory']['towed_units'])){
				$this->request->data['Inventory']['towed_units'] = json_encode($this->data['Inventory']['towed_units']);
			}
			if($this->Inventory->save($this->request->data)){
				$this->Session->setFlash(__('Successfully added a new Inventory'),'default',array(),'success');
				$this->redirect(array('action'=>'index'));
			}
		}	
	}
	
	public function edit($id = null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/inventories/edit';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);	
		
		$inventories = $this->Inventory->find('all',array('conditions'=>array('id'=>$id)));
		$this->set('inventories',$inventories);
		
		if($this->request->is('post')){
			$this->Inventory->id = $id;
			$this->request->data['Inventory']['ferry_id'] = 1;
			if(!empty($this->data['Inventory']['towed_units'])){
				$this->request->data['Inventory']['towed_units'] = json_encode($this->data['Inventory']['towed_units']);
			}
			if($this->Inventory->save($this->request->data)){
				$this->Session->setFlash(__('Successfully added a new Inventory'),'default',array(),'success');
				$this->redirect(array('action'=>'index'));
			}
		}	
	}

	
	public function view($id= null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/inventories/view';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);	
		//if exists
		$this->Inventory->id = $id;
		if (!$this->Inventory->exists()) {
			throw new NotFoundException(__('Invalid Vehicle Type'));
		}
		$inventory = $this->Inventory->fixData($this->Inventory->read(null,$id));
		$this->set('inventory', $inventory);	

		//add the inventory items 
		//paginate the users and send to view
		$this->paginate = array(
			'conditions'=>array('inventory_id'=>$id),
		    'limit' => 10, // this was the option which you forgot to mention
		    'order' => array(
		        'Inventory_item.id' => 'ASC')
		);		
		$this->Inventory_item->recursive = 0;
		$inv_items = $this->Inventory_item->fixLargeData($this->paginate('Inventory_item'));
		$this->set('inventory_items',$inv_items);	
	}
	
	public function delete($id = null)
	{
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Inventory->id = $id;
		if (!$this->Inventory->exists()) {
			throw new NotFoundException(__('Invalid Passenger'));
		}

		//check to see if iventory has inventory items inside of it
		$find = $this->Inventory_item->find('all',array('conditions'=>array('inventory_id'=>$id)));
		
		if(count($find)>0){
			$this->Session->setFlash(__('Inventory cannot be deleted. Please delete all inventory items before deleting inventory.'));
			$this->redirect(array('action'=>'index'));
		} else {
			if ($this->Inventory->delete()) {
				$this->Session->setFlash(__('Inventory deleted'));
				$this->redirect(array('action' => 'index'));
			}	
		}
		
		$this->Session->setFlash(__('Inventory was not deleted'));
		$this->redirect(array('action' => 'index'));		
	}
}


?>