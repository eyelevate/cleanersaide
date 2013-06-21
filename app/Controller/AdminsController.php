<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 * @property Admin $Admin
 */
class AdminsController extends AppController {

	public $name = 'Admins';
	public $uses = array('User','Group','Page','Menu','Menu_item','Attraction_ticket', 'Reservation','Admin');


	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the default layout
		$this->layout = 'admin';

		//set the authorized pages
		$this->Auth->allow('login','logout');
		
		$username = $this->Auth->user('username');
		if(is_null($this->Auth->user('username'))){
			$username = 'You are not logged in';
		} else {
			$username = $this->Auth->user('username');
		}
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
 * Displays login
 * 
 * @return void
 */
	public function login()
	{
		//No admin navigation here
		
		//set autherror to page
		$this->set('authError',$this->Auth->authError);
		
		
		//set the title
 		if ($this->request->is('post')) {
	    	//check to see if the username, company_id, password bring back a row
	    	$username = $this->request->data['User']['username'];
			//login User with auth component
	        if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirect());
	        } else {
	        //the password is incorrect 
	            $this->Session->setFlash(__('Password is incorrect'));  
			}
		}		
	}
/**
 * logsout and sends back to PagesContoller=>index
 * 
 * @return void
 */
	public function logout()
	{
		$this->Session->setFlash(__('You have successfully logged out.'));
		$this->redirect($this->Auth->logout());
	}


/**
 * index method
 *
 * @return void
 */
	public function index() {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/admins/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);
		//set the action levels
		$group_id = $this->Auth->user('group_id');
		
//paginate the users and send to view
		$this->paginate = array(
		    'limit' => 10, // this was the option which you forgot to mention
		    'order' => array(
		        'Reservation.created' => 'DESC')
		);	

		$reservations = $this->Reservation->fixLargeData($this->paginate('Reservation'));	
		$this->Reservation->recursive = 0;
		$this->set('reservations', $reservations);	
		
		
			//get special instructions
			$get_instructions = $this->Attraction_ticket->read('instructions',52);
			if(!empty($get_instructions)>0){
				foreach ($get_instructions as $gi) {
					$instructions = $gi['instructions'];
				}
			} else {
				$instructions = '';
			}	
		
		
		//date ranges
		$today_start = date('Y-m-d').' 00:00:00';
		$today_end = date('Y-m-d').' 23:59:59';
		$this_week = $this->Admin->returnWeekDates();
		
		//search queries
		$reservation_today = $this->Reservation->find('all',array('conditions'=>array('Reservation.created BETWEEN ? AND ?'=>array($today_start, $today_end))));
		
		//get total count for today
		$ferry_today = $this->Admin->ferry_count($reservation_today);
		$hotel_today = $this->Admin->hotel_count($reservation_today);
		$attraction_today = $this->Admin->attraction_count($reservation_today);
		$package_today = $this->Admin->package_count($reservation_today);
		
		/**
		 * return weekly values
		 * @return array
		 */

		$weekly_count = $this->Admin->weekly_count($this_week);
		
		//render values to view
		$this->set('ferry_today',$ferry_today);
		$this->set('hotel_today',$hotel_today);
		$this->set('attraction_today',$attraction_today);
		$this->set('package_today',$package_today);
		$this->set('weekly_count',$weekly_count);

	}


}
