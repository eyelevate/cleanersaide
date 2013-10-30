<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 * @property Admin $Admin
 */
class DeliveriesController extends AppController {

	public $name = 'Deliveries';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Delivery','Schedule');

	public $helpers = array('Csv'); 

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
		$this->Auth->allow('login','logout','index','form','confirmation','process_sad','process_login','request_pickup_date_time','request_dropoff_date_time');
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
		//choose layout
		$this->layout = 'pages';
		//Set up Primary navigation -------------------------------------------------------------
		$page_url = '/deliveries';
		$primary_nav = $this->Menu_item->arrangeByTiers(4);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);		
		
		
		$company_id = 1; //jays cleaners
		
		// unset($_SESSION['customers']);
		// unset($_SESSION['login']);
		// unset($_SESSION['success']);
		// unset($_SESSION['customer_id']);
		
		if(isset($_SESSION['guest_form'])){ //processed in process_sad from home page
			$this->set('guest_form',$_SESSION['guest_form']);
			
			unset($_SESSION['guest_form']); //remove session
		}
		
		if(isset($_SESSION['login'])){
			$login = $_SESSION['login'];
		} else {
			$login = 'No';
		}
		if(isset($_SESSION['success'])){
			$success = $_SESSION['success'];
		} else {
			$success = 'Not Set';
		}
		if(isset($_SESSION['customers'])){
			$customers = $_SESSION['customers'];
		} else {
			$customers = '';
		}
		if(isset($_SESSION['customer_id'])){
			$customer_id = $_SESSION['customer_id'];
		} else {
			$customer_id = '';
		}
		$this->set('login',$login);
		$this->set('success',$success);
		$this->set('customers',$customers);
		$this->set('customer_id',$customer_id);		
		
		if($this->request->is('post')){
			$_SESSION['Delivery'] = $this->request->data;  
		
			$this->User->set($this->request->data);

			if ($this->User->validates()){ //form has validated move on
				$customer_id = $this->request->data['User']['customer_id'];
				$_SESSION['customer_id'] = $customer_id;
				$phone = preg_replace('/\D/', '', $this->request->data['User']['phone']);
				$this->request->data['User']['contact_phone'] = $phone;
				$this->request->data['User']['company_id'] = 1;
				$this->request->data['User']['group_id'] = 5;
				if(!empty($customer_id)){ //this is a returning customer
					//just update the user
					$this->User->id = $customer_id;
					if($this->User->save($this->request->data['User'])){
						$_SESSION['message'] = 'You have successfully updated your information. Please fill out the form below to select your delivery time and date.';
						
					}
					
				} else { //this is a guest
					//lookup by phone number
					$lookup = $this->User->find('all',array('conditions'=>array('contact_phone'=>$phone,'company_id'=>$company_id)));
					
					if(count($lookup)>0){ //this is already a customer move on to next page
						$_SESSION['message'] = 'Thank you returning Guest. Please fill out the form below to set a date and time for delivery.';	
						
					} else { //create a new customer
						$this->User->create();
						if($this->User->save($this->request->data)){
							$_SESSION['message'] = 'Thank you new Guest. Please fill out the form below to set a date and time for delivery.';							
						}
					}

					
				}
				$this->redirect(array('action'=>'form'));	
			} else { //form has not validated refill form and errors
				$customers = $this->request->data;
				$this->set('customers',$customers);
				$errors = $this->User->validationErrors;
				$this->set('form_errors',$errors);
			}

		}
		
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
		
		//paginate the menus 
		$this->Delivery->recursive = 0;
		$this->set('deliveries', $this->paginate());
		
		//get routes
		$routes = $this->Delivery->arrangeRoutes($this->Delivery->find('all'));
		$this->set('routes',$routes);

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
				$this->redirect(array('action'=>'view'));
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

			$this->Delivery->id = $deliveries['Delivery']['id'];
			if($this->Delivery->save($deliveries)){
				$this->Session->setFlash(__('You have successfully edited your route!'),'default',array(),'success');
				$this->redirect(array('action'=>'view'));
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
	
	public function schedule()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/deliveries/schedule';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
		
		$start = date('Y-m-d').' 00:00:00';
		$end = date('Y-m-d').' 23:59:59';
		$conditions = array('Schedule.deliver_date BETWEEN ? AND ?' => array($start,$end));
		$today_schedule = $this->Schedule->find('all',array('conditions'=>$conditions));
		$prepare_schedule = $this->Schedule->setSchedule($today_schedule);
		$this->set('date',date('n/d/Y'));
		$this->set('today',$prepare_schedule);
		
		if($this->request->is('post')){
			$delivery_start = date('Y-m-d',strtotime($this->request->data['Delivery']['date'])).' 00:00:00';
			$delivery_end = date('Y-m-d',strtotime($this->request->data['Delivery']['date'])).' 23:59:59';
			$conditions = array('Schedule.deliver_date BETWEEN ? AND ?' => array($delivery_start,$delivery_end));
			$selected_schedule = $this->Schedule->find('all',array('conditions'=>$conditions));
			$prepare_schedule = $this->Schedule->setSchedule($selected_schedule);
			$this->set('date',date('n/d/Y',strtotime($this->request->data['Delivery']['date'])));
			$this->set('today',$prepare_schedule);
			
			// //prepare csv
			// $csv = new csvHelper();
// 			
			// //$csv->addRow($a);
			// $date = date('mdy');
			// $filename = 'delivery-'.$date;
			// $fullfilename = '/tmp/'.$filename.'.csv';
			// $csv->save($fullfilename);
// 			
			// $sendTo = array('onedough83@gmail.com');
// 	
			// $subject = 'delivery schedule ('.date('n/d/Y',strtotime($this->request->data['Delivery']['date'])).'): '.$filename;
// 			
			// $Email = new CakeEmail('gmail');
// 						
			// //primary email settings
// 			
			// $Email->template('customs')
			   	// ->emailFormat('text')
			    // ->to($sendTo)
				// //->bcc(array('bbtpackage@seanet.com','john@treenumbertwo.com'))
				// ->attachments(array( ($filename.'.csv') => $fullfilename ))
				// ->subject($subject);
// 			
			// //backup email settings
			// $Backup = new CakeEmail('default');
			// //$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
			// $Backup->template('customs')
			    // ->emailFormat('text')
			    // ->to($sendTo)
				// //->bcc(array('bbtpackage@seanet.com','john@treenumbertwo.com'))
				// ->attachments(array( ($filename.'.csv') => $fullfilename ))
				// ->subject($subject);
// 			
// 			
			// //simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
			// try
			// {
				// $Email->send();
			// } 
			// catch (SocketException $e)
			// {
				// $Backup->send();	
			// }	
// 	
			// unlink ($fullfilename);
// 		
			// exit();
		}
	}
	
	public function process_sad()
	{
		if($this->request->is('post')){
			$_SESSION['guest_form'] = $this->request->data;
			
			$this->redirect(array('action'=>'index'));
		}
	}
	
	public function process_login()
	{
		if($this->request->is('post')){
			$username = $this->request->data['User']['username'];
			$password = $this->Delivery->hashPasswords($this->request->data['User']['password']);
			$group_id = 5;
			$customers = $this->User->find('all',array('conditions'=>array('username'=>$username,'password'=>$password,'group_id'=>$group_id)));
			if(count($customers)>0){
				foreach ($customers as $c) {
					$_SESSION['customer_id'] = $c['User']['id'];
				}
				$_SESSION['customers'] = $customers;
				$_SESSION['login'] = 'Yes';
			} else {
				$_SESSION['login'] = 'No';
				$_SESSION['success'] = 'error';
							
			}

			$this->redirect(array('action'=>'index'));			
		}
	}
	
	public function form()
	{
		$this->layout = 'pages';
		$customer_id = $_SESSION['Delivery']['User']['customer_id'];

		$company_id = 1;

		$zipcode = $_SESSION['Delivery']['User']['contact_zip'];
		$this->set('zipcode',$zipcode);

		$find_routes = $this->Delivery->routes($zipcode,$company_id);
		$month = date('m');
		$year = date('Y');
		$route_schedule = $this->Schedule->create_pickup_schedule($find_routes,$company_id,$month, $year);
		
		if(count($find_routes)>0){
			$this->set('route_status','1');
			$this->set('routes',$find_routes);
		} else {
			$this->set('route_status','0');
			$this->set('routes',array());
		}
		$this->set('route_schedule',$route_schedule);

		if($this->request->is('post')){
			$customer_id = $_SESSION['Delivery']['User']['customer_id'];
			$dropoff_date = $this->request->data['Schedule']['dropoff_date'];
			$dropoff_time = $this->request->data['Schedule']['dropoff_time'];
			$pickup_date = $this->request->data['Schedule']['pickup_date'];
			$pickup_time = $this->request->data['Schedule']['pickup_time'];
			
			
			$_SESSION['Delivery']['Schedule']['customer_id'] = $customer_id;
			$_SESSION['Delivery']['Schedule']['pickup_date'] = date('Y-m-d H:i:s',$pickup_date);
			$_SESSION['Delivery']['Schedule']['pickup_delivery_id'] = $pickup_time;
			$_SESSION['Delivery']['Schedule']['dropoff_date'] = date('Y-m-d H:i:s',$dropoff_date);
			$_SESSION['Delivery']['Schedule']['dropoff_delivery_id'] = $dropoff_time;
			$_SESSION['Delivery']['Schedule']['company_id'] = 1;
			$_SESSION['Delivery']['Schedule']['status'] = 1;
			$_SESSION['Delivery']['Schedule']['type'] = 'frontend';
			$_SESSION['message'] = 'You have successfully selected your delivery date and time. Please confirm all the information below and submit your payment information';
			$this->redirect(array('action'=>'confirmation'));
		}
	}

	
	public function request_pickup_date_time()
	{
		if($this->request->is('ajax')){
			$month = $this->data['month'];
			$year = $this->data['year'];
			$customer_id = $_SESSION['Delivery']['User']['customer_id'];
			$company_id = 1;
	
			$zipcode = $_SESSION['Delivery']['User']['contact_zip'];
			$this->set('zipcode',$zipcode);
	
			$find_routes = $this->Delivery->routes($zipcode,$company_id);
			$route_schedule = $this->Schedule->create_pickup_schedule($find_routes,$company_id,$month, $year);
			$this->set('route_schedule',$route_schedule);
		}
	}
	public function request_dropoff_date_time()
	{
		if($this->request->is('ajax')){
			$month = $this->data['pickup_month'];
			$year = $this->data['pickup_year'];
			$date = $this->data['pickup_date'];
			$time = $this->data['pickup_time'];
			$customer_id = $_SESSION['Delivery']['User']['customer_id'];
			$company_id = 1;
	
			$zipcode = $_SESSION['Delivery']['User']['contact_zip'];
			$this->set('zipcode',$zipcode);
	
			$find_routes = $this->Delivery->routes($zipcode,$company_id);
			$route_schedule = $this->Schedule->create_dropoff_schedule($find_routes,$company_id,$month, $year, $date, $time);
			$this->set('route_schedule',$route_schedule);
		}
	}
	public function confirmation()
	{
		$this->layout = 'pages';
		$this->set('deliveries',$_SESSION['Delivery']);
		//get pickup time 
		$delivery_pickup_data = $this->Delivery->find('all',array('conditions'=>array('id'=>$_SESSION['Delivery']['Schedule']['pickup_delivery_id'])));
		if(count($delivery_pickup_data)>0){
			foreach ($delivery_pickup_data as $d) {
				$pickup_start_time = $d["Delivery"]['start_time'];
				$pickup_end_time = $d['Delivery']['end_time'];
			}
			$this->set('pickup_time',$pickup_start_time.' - '.$pickup_end_time);
		} else {
			$this->set('pickup_time','Not Set');
		}
		//get dropoff time 
		$delivery_dropoff_data = $this->Delivery->find('all',array('conditions'=>array('id'=>$_SESSION['Delivery']['Schedule']['dropoff_delivery_id'])));
		if(count($delivery_dropoff_data)>0){
			foreach ($delivery_dropoff_data as $d) {
				$dropoff_start_time = $d["Delivery"]['start_time'];
				$dropoff_end_time = $d['Delivery']['end_time'];
			}
			$this->set('dropoff_time',$dropoff_start_time.' - '.$dropoff_end_time);
		} else {
			$this->set('dropoff_time','Not Set');
		}
		if(!empty($_SESSION['Delivery']['User']['customer_id'])){
			//get payment info
			$customer_id = $_SESSION['Delivery']['User']['customer_id'];
			$users = $this->User->find('all',array('conditions'=>array('User.id'=>$customer_id)));
			$profile_id = '';
			$payment_id = '';
			if(count($users)>0){
				foreach ($users as $u) {
					$profile_id = $u['User']['profile_id'];
					$payment_id = $u['User']['payment_id'];
				}
			}
			if(is_null($payment_id)){
				$this->set('display_payment','Yes');
			} else {
				$this->set('display_payment','No');
			}
			
		} else {
			$this->set('display_payment','Yes');
		}
		
		if($this->request->is('post')){
			debug($_SESSION['Delivery']);
			debug($this->request->data);
			
			//get payment info
		}
		
		
	}
}
