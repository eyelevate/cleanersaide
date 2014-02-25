<?php
App::uses('AppController', 'Controller');

App::uses('barcode', 'Vendor');
App::uses('createfdf', 'Vendor');
App::uses('fpdf', 'Vendor');
App::uses('fpdi', 'Vendor');

/**
 * Reports Controller
 *
 * @property Report $Report
 */
class ReportsController extends AppController {
	public $name = 'Reports';

	public $uses = array(
		'User','Group','Menu','Menu_item','Tax','Schedule', 'Inventory','Inventory_item','Report',
		'Invoice','Delivery','Transaction'
	);	

	public $helpers = array('Html', 'Form','Csv'); 
	
/**
 * Parses this code first on all actions in this controller
 */
	public function beforeFilter()
	{
		$this->layout = 'admin';
		parent::beforeFilter();
		//set the authorized username
		$this->set('username',AuthComponent::user('username'));
		//deny all public users to this page
		$this->Auth->deny('*');
		
		//set session max lifetime to 24 hours
		ini_set('session.gc_maxlifetime',24*60*60); //max life 24 hours
		ini_set('session.gc_probability',1);
		ini_set('session.gc_divisor',1);				
		
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
	}	
	
	public function index() 
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/reports/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
	}
	
	public function view($start = null, $end = null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/reports/view';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
	}


}