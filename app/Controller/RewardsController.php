<?php
App::uses('AppController', 'Controller');
/**
 * Rewards Controller
 *
 * @property User $Reward
 */
class RewardsController extends AppController {
	public $name = 'Rewards';
	
	public $uses = array('User','Page','Menu_item','Discount','Transaction','Invoice','Reward','RewardTransaction');
/**
 * Parse code before page load
 */
	public function beforeFilter() {
	    parent::beforeFilter();
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);	
		//deny all public users to this controller
		$this->Auth->deny('*');
		//$this->Auth->allow('forgot','reset','convert_users','new_customers','process_frontend_new_user','redirect_new_frontend_customer','frontend_logout');
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
		$this->layout='admin';
	
		
	
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//set the admin navigation
		$page_url = '/rewards/index';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//paginate the users and send to view
		$this->paginate = array(
		    'limit' => 10, // this was the option which you forgot to mention
		    'order' => array(
		        'User.username' => 'ASC')
		);		
		$this->Reward->recursive = 0;
		$this->set('users', $this->paginate('User'));
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
		$page_url = '/rewards/view';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//select layout
		$this->layout = 'admin';		

	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//set the admin navigation
		$page_url = '/rewards/add';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		if($this->request->is('post')){
			$this->request->data['Reward']['company_id'] = $_SESSION['company_id'];
			
			if($this->Reward->save($this->request->data)){
				$this->Session->setFlash(__('You have successfully created a new reward program!'),'default',array(),'success');
				$this->redirect(array('action'=>'index'));
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
		$page_url = '/rewards/edit';
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function activate($id = null)
	{
		if(!is_null($id)){
			$this->User->id = $id;	
			//set status for activation
			$activate_status = 2;
			$users = array(); //create array for updating model
			$users['User']['reward_status'] = $activate_status; //set status to array
			
			//update array
			if($this->User->save($users)){
				$this->Session->setFlash(__('You save successfully activated your rewards program.'),'default',array(),'success');
				
			} else {
				$this->Session->setFlash(__('There was an error activating the rewards program. Please try again.'),'default',array(),'error');
			}
			
			
		} else { //there is no id set so you cannot activate. send back with error message
			$this->Session->setFlash(__('You cannot activate a non customer account. Please select a customer then try again.'),'default',array(),'error');
		}
		
		$this->redirect(array('controller'=>'invoices','action'=>'index',$id));

	}
	public function deactivate($id = null)
	{
		if(!is_null($id)){
			$this->User->id = $id;	
			//set status for activation
			$deactivate_status = 1;
			$users = array(); //create array for updating model
			$users['User']['reward_status'] = $deactivate_status; //set status to array
			
			//update array
			if($this->User->save($users)){
				$this->Session->setFlash(__('You save successfully de-activated your rewards program.'),'default',array(),'success');
				
			} else {
				$this->Session->setFlash(__('There was an error deactivating the rewards program. Please try again.'),'default',array(),'error');
			}
			
			
		} else { //there is no id set so you cannot activate. send back with error message
			$this->Session->setFlash(__('You cannot deactivate a non customer account. Please select a customer then try again.'),'default',array(),'error');
		}
		
		$this->redirect(array('controller'=>'invoices','action'=>'index',$id));

	}
}
