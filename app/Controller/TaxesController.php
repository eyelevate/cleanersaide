<?php

/**
 * app/controller/TaxesController
 */
class TaxesController extends AppController {
    //Name (should be same as the class name)
    public $name = 'Taxes';
	public $uses = array('Tax','Menu_item','Reservation');
	public function beforeFilter()
	{
		parent::beforeFilter();	
		$this->layout = 'admin';	
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);			
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
		$page_url = '/taxes/index';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check); 
		//paginate the users and send to view
		$this->paginate = array(
		    'limit' => 10, // this was the option which you forgot to mention
		    'order' => array(
		        'Tax.id' => 'ASC')
		);	
		$taxes = $this->Tax->fixData($this->paginate('Tax'));	
		$this->Tax->recursive = 0;
		$this->set('taxes', $taxes);	          
    }
	
	public function add()
	{
		//set the admin navigation
		$page_url = '/taxes/add';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);   	
	
		if($this->request->is('post')){
			$this->request->data['Tax']['company_id'] = $this->Session->read('company_id');
			//debug($this->Session->read('company_id'));
			if($this->Tax->save($this->request->data)){
				$this->Session->setFlash(__('Successfully Added New Tax Rate'),'default',array(),'success');
				$this->redirect(array('action'=>'index'));
			}
		}	
	}
	public function edit($id = null)
	{
		//set the admin navigation
		$page_url = '/taxes/add';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);   	
		
		$find = $this->Tax->find('all',array('conditions'=>array('id'=>$id)));
		$this->set('taxes',$find);
		if($this->request->is('post')){
			$this->Tax->id = $id;
			if($this->Tax->save($this->request->data)){
				$this->Session->setFlash(__('Successfully Saved Tax Rate'),'default',array(),'success');
				$this->redirect(array('action'=>'index'));
			}
		}	
	}	
	public function view($id= null)
	{
		//set the admin navigation
		$page_url = '/taxes/view';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);   		
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
		$this->Tax->id = $id;
		if (!$this->Tax->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		if ($this->Tax->delete()) {
			$this->Session->setFlash(__('Tax deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tax was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}


?>