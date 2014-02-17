<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail','Network/Email'); //cakes email class
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
	public $name = 'Users';
	
	public $uses = array('User','Page','Menu_item','Aro');
/**
 * Parse code before page load
 */
	public function beforeFilter() {
	    parent::beforeFilter();
		$this->set('username',AuthComponent::user('username'));
		//deny all public users to this controller
		//$this->Auth->deny('*');
		$this->Auth->allow('add','forgot','reset','convert_users','new_customers','process_frontend_new_user','redirect_new_frontend_customer','frontend_logout','process_delete_profile');
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
		
		// //layout setup
		// $ha_locations = $this->Location->find('all');
		// $this->set('ha_locations',$ha_locations);
		
	
	}
	// public function convert_users()
	// {
		// //set the admin navigation
		// $page_url = '/users/convert_users';
		// $admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		// $admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		// $this->set('admin_nav',$admin_nav);
		// $this->set('admin_pages',$page_url);
		// $this->set('admin_check',$admin_check);		
// 		
// 		
		// $old = $this->User->convertOldUserToNew();
// 
		// $this->Aro->saveAll($old);
		// // foreach ($old as $okey => $ovalue) {
// // 			
			// // if($this->Aro->save($old[$okey])){
// // 				
			// // }
		// // }
	// }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		//set the admin navigation
		$page_url = '/users/index';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//paginate the users and send to view
		$this->paginate = array(
			'conditions' =>array('group_id'=>5,'company_id'=>$_SESSION['company_id']),
		    'limit' => 50, // this was the option which you forgot to mention
		    'order' => array(
		        'User.username' => 'ASC')
		);		
		$this->User->recursive = 0;
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
		$page_url = '/users/view';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//select layout
		$this->layout = 'admin';		
		//if exists
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//set the admin navigation
		$page_url = '/users/add';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//select layout
		$this->layout = 'admin';		
		//if saving
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
		$page_url = '/users/edit';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//select layout
		$this->layout = 'admin';


		//set user id
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'),'default',array(),'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'default',array(),'error');
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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

/**
 * forgot password method
 * 
 * @return void
 */
	public function forgot()
	{
		$this->layout = 'pages';	
			
		//Set up Primary navigation -------------------------------------------------------------
		$page_url = '/hotels-attractions';
		$primary_nav = $this->Menu_item->arrangeByTiers(1);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);
		
		
		if($this->request->is('post')){
			$username = $this->request->data['User']['username'];
			
			//find the users email address
			$find = $this->User->find('all',array('conditions'=>array('username'=>$username)));
			if(count($find)>0){
				//parse through the array to get the necessary data
				foreach ($find as $f) {
					$user_id = $f['User']['id'];
					$email = $f['User']['contact_email'];
					//send the data to be processed for a valid email
					$random_token = $this->User->emailForgottenPassword($email, $user_id);
					//start the email process	
					$link = 'http://www.cohoferry.com/users/reset/'.$random_token;	//this must be changed when pushed to the server		
					$sendTo = $email;
					$from = array('info@mpaengine.com'=>'admin'); //must change this 
					$subject = 'Forgotten Password';
					$Email = new CakeEmail('gmail');
					$Email->emailFormat('html')
						->template('forgot','forgot')
						->viewVars(compact('link'))
					    ->to($sendTo)
					    ->from($from)
						->subject($subject)
					    ->send();
				}
				$this->Session->setFlash(__('An email has been sent to your email address. Please follow the instructions inside your email to reset your password.'),'default',array(),'success');
			} else {
				$this->Session->setFlash(__('There is no such user. Please try again.'),'default',array(),'error');
			}
		}
	}

	public function reset($token=nil)
	{
		$this->layout = 'pages';	
			
		//Set up Primary navigation -------------------------------------------------------------
		$page_url = '/hotels-attractions';
		$primary_nav = $this->Menu_item->arrangeByTiers(1);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);
		
		//if the user made it here without any token then redirect them out
		if($token == null || $token == '' || !isset($token)){
			$this->Session->setFlash(__('You do not have access to this page.'),'default',array(),'error');
			$this->redirect('/');			
			
		} else { //if they have a proper token look in the database for their account info then get the id.
			$find_token = $this->User->find('all',array('conditions'=>array('token'=>$token)));
			if(count($find_token) > 0){
				foreach ($find_token as $t) {
					$id = $t['User']['id'];
				}		
			} else { //send them back with an expired token
				$this->Session->setFlash(__('Your token has expired. In order to reset your password please try again.'),'default',array(),'error');
				$this->redirect('/');
			}			
		}
		

		//if successful and user is able to post data. then run the script and reset their token and also their password
		if($this->request->is('post')){
			$this->User->id = $id;
			$this->request->data['User']['token'] = '';
			if($this->User->save($this->request->data)){
				$this->Session->setFlash(__('Your password has successfully been updated!'),'default',array(),'success');
				$this->redirect('/');				
			}
		}		
	}

	public function new_customers()
	{
		//set the admin navigation
		$page_url = '/users/new_customers';

		$primary_nav = $this->Menu_item->arrangeByTiers(4);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);		
		//select layout
		$this->layout = 'pages';	
		if(isset($_SESSION['users'])){	
			$users = $_SESSION['users'];
			
			$this->set('users',$users);
			unset($_SESSION['users']);
		}
		
		
		//if saving
		if ($this->request->is('post')) {
			//set variables
			$this->request->data['User']['group_id'] = 5;
			$phone = preg_replace('/\D/', '', $this->request->data['User']['contact_phone']);
			$company_id = 1;
			$username = $this->request->data['User']['username'];
			$this->request->data['User']['contact_phone'] = $phone;
			$this->request->data['User']['company_id'] = $company_id;
			$this->request->data['User']['reward'] = '1';
			$this->request->data['User']['account'] = '1';
			$_SESSION['Delivery']['User']['contact_zip'] = $this->request->data['User']['contact_zip'];
			
			//lookup by phone number
			$lookup = $this->User->find('all',array('conditions'=>array('contact_phone'=>$phone,'company_id'=>$company_id)));
			
			if(count($lookup)>0){ //this is already a customer move on to next page
				foreach ($lookup as $cust) {
					$customer_id = $cust['User']['id'];
					$lookup_username = $cust['User']['username'];
				}

				if(!is_null($lookup_username)){
					$this->Session->setFlash(__('The account with this phone number already contains a username. Please use another phone number.'),'default',array(),'error');
				} else {
					$this->request->data['User']['id'] = $customer_id;
					$this->request->data['User']['company_id'] = '1';
					$store_credit_data = $this->request->data['User']['store_credit_data'];
					switch($store_credit_data){
						case 'Yes':
							$profile = $this->AuthorizeNet->createProfile($this->request->data);
							$payment_profile = $this->AuthorizeNet->createPaymentProfile($this->request->data, $profile['customerProfileId']);
								
							//set variables to save
							$this->request->data['User']['profile_id'] = $profile['customerProfileId'];
							$this->request->data['User']['payment_id'] = $payment_profile['customerPaymentProfileId'];	
						break;
							
						case 'No':
							$profile_id = $this->AuthorizeNet->createProfile($this->request->data);
							//set variables to save
							$this->request->data['User']['profile_id'] = $profile['customerProfileId'];
						break;
					}
				
					$this->User->id = $customer_id;
					if($this->User->save($this->request->data)){
						$this->Session->setFlash(__('Thank you '.$this->request->data['User']['username'].'! Please fill out form below to request a delivery pickup.'),'default',array(),'success');
						$this->redirect(array('controller'=>'deliveries','action' => 'form'));						
					}						
				}
			
				
			} else { //create a new customer
				$this->User->create();

				if($this->User->save($this->request->data)){
					$last_id = $this->User->getLastInsertId();
					$new_customers = $this->User->find('all',array('conditions'=>array('User.id'=>$last_id)));

					if(count($new_customers)>0){
						foreach ($new_customers as $cust) {
							$_SESSION['Delivery']['User'] = $cust['User'];
							$new_customer_id = $cust['User']['id'];
							$new_customer_zip = $cust['User']['contact_zip'];
							//login user
							$_SESSION['customer_id'] = $cust;
							$_SESSION['customers'] = $customers;
							$_SESSION['login'] = 'Yes';
						}
						$this->request->data['User']['id'] = $new_customer_id;
						$this->request->data['User']['company_id'] = '1';
						$store_credit_data = $this->request->data['User']['store_credit_data'];
						switch($store_credit_data){
							case 'Yes':
								$profile = $this->AuthorizeNet->createProfile($this->request->data);
								$payment_profile = $this->AuthorizeNet->createPaymentProfile($this->request->data, $profile['customerProfileId']);
									
								//set variables to save
								$new['User']['profile_id'] = $profile['customerProfileId'];
								$new['User']['payment_id'] = $payment_profile['customerPaymentProfileId'];	
									
							break;
								
							case 'No':
								$profile = $this->AuthorizeNet->createProfile($this->request->data);
									
								//set variables to save
								$new['User']['profile_id'] = $profile['customerProfileId'];
							break;
						}	
						$this->User->id = $new_customer_id;
						$this->User->save($new);					
						
					}
					
					
					$this->Session->setFlash('Thank you '.$this->request->data['User']['username'].'! Please fill out form below to request a delivery pickup.','default',array(),'success');
					$this->redirect(array('controller'=>'deliveries','action' => 'form'));						
				}
			}

		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));		
	}

	public function process_delete_profile($id)
	{
		$delete_status = $this->AuthorizeNet->deletePaymentProfile($id);
		switch($delete_status){
			case 1:
				$this->Session->setFlash(__('There was an error deleting your profile, please contact us for assistance.'),'default',array(),'error');
			break;
				
			case 2:
				$this->Session->setFlash(__('Successfully deleted profile.'),'default',array(),'success');		
			break;
		}
		
		$this->redirect('/');
		
	}
	
	public function redirect_new_frontend_customer()
	{
		if($this->request->is('post')){
			$users = $this->request->data;
			$_SESSION['users'] = $users;
			$this->redirect(array('action'=>'new_customers'));
		}
	}
	
	public function frontend_logout()
	{
		unset($_SESSION['customers']);
		unset($_SESSION['login']);
		unset($_SESSION['success']);
		unset($_SESSION['customer_id']);	
		
		$this->redirect('/');	
	}
	
	public function process_frontend_new_user()
	{

	}
}
