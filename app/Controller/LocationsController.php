<?php

/**
 * app/controller/LocationsController
 */
class LocationsController extends AppController {
    //Name (should be same as the class name)
    public $name = 'Locations';
	public $uses = array('Location','Menu_item', 'Reservation');
	public function beforeFilter()
	{
		parent::beforeFilter();	
		$this->layout = 'admin';	
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
    public function index() {
		//set the admin navigation
		$page_url = '/locations/index';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check); 
		//paginate the users and send to view
		$this->paginate = array(
		    'limit' => 10, // this was the option which you forgot to mention
		    'order' => array(
		        'Location.name' => 'ASC')
		);	
		$locations = $this->Location->fixData($this->paginate('Location'));	
		$this->Location->recursive = 0;
		$this->set('locations', $locations);	          
    }
	
	public function add()
	{
		//set the admin navigation
		$page_url = '/locations/edit';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);   	
		
		if($this->request->is('post')){
			if($this->Location->save($this->request->data)){
				$this->Session->setFlash(__('Successfully Added New Location'),'default',array(),'success');
				$this->redirect(array('action'=>'index'));
			}
		}	
	}
	public function edit($id = null)
	{
		//set the admin navigation
		$page_url = '/locations/edit';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);   	
		
		$find = $this->Location->find('all',array('conditions'=>array('id'=>$id)));
		$this->set('locations',$find);
		if($this->request->is('post')){
			$this->Location->id = $id;
			if($this->Location->save($this->request->data)){
				$this->Session->setFlash(__('Successfully Saved Location'),'default',array(),'success');
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
		$this->Location->id = $id;
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		if ($this->Location->delete()) {
			$this->Session->setFlash(__('Location deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Location was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}


?>