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
	
	public $uses = array('User','Page','Menu_item','Location', 'Reservation','Aro');
/**
 * Parse code before page load
 */
	public function beforeFilter() {
	    parent::beforeFilter();
		$this->set('username',AuthComponent::user('username'));
		//deny all public users to this controller

		$this->Auth->allow('*');
		//$this->Auth->allow('forgot','reset','convert_users');

		$this->layout='admin';
		

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
		    'limit' => 10, // this was the option which you forgot to mention
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
}
