<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 * @property Admin $Admin
 */
class DeliveriesController extends AppController {

	public $name = 'Deliveries';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Delivery');


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
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);
	
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
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/deliveries/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//paginate the menus 
		$this->Delivery->recursive = 0;
		$this->set('deliveries', $this->paginate());
		
		//get routes
		$routes = $this->Delivery->arrangeRoutes($this->Delivery->find('all'));
		$this->set('routes',$routes);
		
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/deliveries/view';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
				
		//set the menu_id
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		$menus = $this->Menu->read(null,$id);
		$this->set('menus', $menus);
		//get all menu_items (basic)
		$menu_items = $this->Menu_item->find('all',array('conditions'=>array('menu_id'=>$id),'order'=>array('orders asc')));
		$this->set('menu_items',$menu_items);
		//get all menu_items (by group)
		$menu_item_tiers = $this->Menu_item->arrangeByTiers($id);
		$this->set('mits',$menu_item_tiers);

	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/deliveries/add';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);


		$minutesArray = $this->Delivery->minutesArray();
		
		$this->set('minutesArray',$minutesArray);
		if($this->request->is('post')){
			
			$deliveries = $this->Delivery->arrangeDataForSaving($this->request->data);
			
			if($this->Delivery->saveAll($deliveries['Delivery'])){
				$this->Session->setFlash(__('You have successfully created a new delivery route schedule'),'default',array(),'success');
		
			}
		}		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/deliveries/edit';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//set variables here
		$company_id = $_SESSION['company_id'];
		$minutesArray = $this->Delivery->minutesArray();
		
		$this->set('minutesArray',$minutesArray);		
		//get routes
		$routes = $this->Delivery->find('all',array('conditions'=>array('id'=>$id,'company_id'=>$company_id)));
		$this->set('routes',$routes);
		$this->set('delivery_id',$id);
		
		if($this->request->is('post')){

			$deliveries = $this->Delivery->arrangeEditedDeliveryForSave($this->request->data);
			
			debug($deliveries);
			$this->Delivery->id = $deliveries['Delivery']['id'];
			if($this->Delivery->save($deliveries)){
				$this->Session->setFlash(__('You have successfully edited your route!'),'default',array(),'success');
				$this->redirect(array('action'=>'index'));
			}
		}
		
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Menu->id = $id;
		if (!$this->Delivery->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		if ($this->Delivery->delete()) {
			//delete all from the menu_items table where id = id
			$this->Menu_item->query('delete from menu_items where menu_id = '.$id.'');
			$this->Session->setFlash(__('Menu deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Menu was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

}
