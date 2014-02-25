<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail','Network/Email'); //cakes email class
/**
 * Admins Controller
 * @property Admin $Admin
 */
class DeliveriesController extends AppController {

	public $name = 'Deliveries';
	public $uses = array('User','Group','Page','Menu','Menu_item','Admin','Delivery','Schedule','Payment','Transaction');

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
		$this->Auth->allow('login','logout','index','form','confirmation','process_sad','process_login','request_pickup_date_time','request_dropoff_date_time','process_final_delivery_form','process_resend_delivery_form','restart','thank_you','reschedule');
		//set username
		$username = $this->Auth->user('username');
		$this->set('username',$username);

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
			$this->request->data['User']['contact_phone'] = preg_replace('/\D/', '', $this->request->data['User']['contact_phone']);
			$this->User->set($this->request->data);

			if ($this->User->validates()){ //form has validated move on
				$customer_id = $this->request->data['User']['customer_id'];
				$_SESSION['Delivery']['User']['id'] = $customer_id;

				$_SESSION['customer_id'] = $customer_id;
				// $phone = preg_replace('/\D/', '', $this->request->data['User']['contact_phone']);
				// $this->request->data['User']['contact_phone'] = $phone;
				$this->request->data['User']['company_id'] = 1;
				$this->request->data['User']['group_id'] = 5;
				if(!empty($customer_id)){ //this is a returning customer
					//just update the user
					$this->User->id = $customer_id;
					if($this->User->save($this->request->data['User'])){
			
						$this->Session->setFlash(__('You have successfully updated your information. Please fill out the form below to select your delivery time and date.'),'default',array(),'success');
					}
					
				} else { //this is a guest
					//lookup by phone number
					$lookup = $this->User->find('all',array('conditions'=>array('contact_phone'=>$this->request->data['User']['contact_phone'],'company_id'=>$company_id)));
					
					if(count($lookup)>0){ //this is already a customer move on to next page
						$this->Session->setFlash(__('Thank you returning Guest. Please fill out the form below to set a date and time for delivery.'),'default',array(),'success');
					} else { //create a new customer
						$this->User->create();
						if($this->User->save($this->request->data)){							
							$this->Session->setFlash(__('Thank you new Guest. Please fill out the form below to set a date and time for delivery.'),'default',array(),'success');
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
		$conditions_pickup= array('Schedule.pickup_date BETWEEN ? AND ?' => array($start,$end));
		$day_pickup = $this->Schedule->find('all',array('conditions'=>$conditions_pickup));
		$conditions_dropoff= array('Schedule.dropoff_date BETWEEN ? AND ?' => array($start,$end));
		$day_dropoff = $this->Schedule->find('all',array('conditions'=>$conditions_dropoff));
		$prepare_schedule_today = $this->Schedule->setSchedule($day_pickup, $day_dropoff);
		$this->set('date',date('n/d/Y'));
		$this->set('today',$prepare_schedule_today);
		unset($_SESSION['finish_date']);
		if($this->request->is('post')){
			$delivery_start = date('Y-m-d',strtotime($this->request->data['Delivery']['date'])).' 00:00:00';
			$delivery_end = date('Y-m-d',strtotime($this->request->data['Delivery']['date'])).' 23:59:59';
			$conditions_pickup= array('Schedule.pickup_date BETWEEN ? AND ?' => array($delivery_start,$delivery_end));
			$day_pickup = $this->Schedule->find('all',array('conditions'=>$conditions_pickup));
			$conditions_dropoff= array('Schedule.dropoff_date BETWEEN ? AND ?' => array($delivery_start,$delivery_end));
			$day_dropoff = $this->Schedule->find('all',array('conditions'=>$conditions_dropoff));

			$prepare_schedule_date = $this->Schedule->setSchedule($day_pickup, $day_dropoff);

			$this->set('date',date('n/d/Y',strtotime($this->request->data['Delivery']['date'])));
			$this->set('today',$prepare_schedule_date);
			unset($_SESSION['finish_date']);
		}
	}

	public function create_delivery_csv(){
		if($this->request->is('post')){
		    $this->layout = null;
		   	$this->autoLayout = false;		

			$this->set('delivery',$this->request->data);
			
		}
	}
	
	public function process_sad()
	{
		if($this->request->is('post')){
			$_SESSION['guest_form'] = $this->request->data;
			unset($_SESSION['Delivery']);
			unset($_SESSION['reschedule']);
			unset($_SESSION['customer_id']);
			unset($_SESSION['login']);
			unset($_SESSION['customers']);
			
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
		if(isset($_SESSION['Delivery']['User']['id'])){
			$customer_id = $_SESSION['Delivery']['User']['id'];
		}
	
		$page_url = '/deliveries/form';
		$primary_nav = $this->Menu_item->arrangeByTiers(4);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);	
		$company_id = 1;
		if(isset($_SESSION["Delivery"]['User']['contact_zip'])){
			$zipcode = $_SESSION['Delivery']['User']['contact_zip'];
		}
		$this->set('zipcode',$zipcode);
		$base_routes = $this->Delivery->routes($zipcode,$company_id);
		$find_routes = $this->Delivery->view_schedule($this->Delivery->routes($zipcode,$company_id));
		$month = date('m');
		$year = date('Y');
		$route_schedule = $this->Schedule->create_pickup_schedule($base_routes,$company_id,$month, $year);
		
		if(count($find_routes)>0){
			$this->set('route_status','1');
			$this->set('routes',$find_routes);
		} else {
			$this->set('route_status','0');
			$this->set('routes',array());
		}
		$this->set('route_schedule',$route_schedule);
		if($this->request->is('post')){
			$customer_id = $_SESSION['Delivery']['User']['id'];
			$dropoff_date = $this->request->data['Schedule']['dropoff_date'];
			$dropoff_time = $this->request->data['Schedule']['dropoff_time'];
			$pickup_date = $this->request->data['Schedule']['pickup_date'];
			$pickup_time = $this->request->data['Schedule']['pickup_time'];
			
			
			$_SESSION['Delivery']['Schedule']['customer_id'] = $customer_id;
			$_SESSION['Delivery']['Schedule']['pickup_date'] = date('Y-m-d H:i:s',strtotime($pickup_date));
			$_SESSION['Delivery']['Schedule']['pickup_delivery_id'] = $pickup_time;
			$_SESSION['Delivery']['Schedule']['dropoff_date'] = date('Y-m-d H:i:s',strtotime($dropoff_date));
			$_SESSION['Delivery']['Schedule']['dropoff_delivery_id'] = $dropoff_time;
			$_SESSION['Delivery']['Schedule']['company_id'] = 1;
			$_SESSION['Delivery']['Schedule']['status'] = 1;
			$_SESSION['Delivery']['Schedule']['type'] = 'frontend';
			$this->Session->setFlash(__('You have successfully selected your delivery date and time. Please confirm all the information below and submit your payment information'),'default',array(),'success');
			$this->redirect(array('controller'=>'deliveries','action'=>'confirmation'));
		}
	}

	
	public function request_pickup_date_time()
	{
		if($this->request->is('ajax')){
			$pickup_date = strtotime(date('Y-m-d ',$this->data['pickup_date']).'00:00:00');
			$customer_id = $_SESSION['Delivery']['User']['id'];
			$company_id = 1;
	
			$zipcode = $_SESSION['Delivery']['User']['contact_zip'];
			$this->set('zipcode',$zipcode);
	
			$find_routes = $this->Delivery->routes($zipcode,$company_id);
			$route_schedule = $this->Schedule->create_pickup_schedule($find_routes,$company_id, $pickup_date);
			$this->set('route_schedule',$route_schedule);
			$this->set('pickup_date',$pickup_date);
		}
	}
	public function request_dropoff_date_time()
	{
		if($this->request->is('ajax')){
			$date = $this->data['pickup_date'];
			$time = $this->data['pickup_time'];
			$customer_id = $_SESSION['Delivery']['User']['customer_id'];
			$company_id = 1;
	
			$zipcode = $_SESSION['Delivery']['User']['contact_zip'];
			$this->set('zipcode',$zipcode);
	
			$find_routes = $this->Delivery->routes($zipcode,$company_id);
			$route_schedule = $this->Schedule->create_dropoff_schedule($find_routes,$company_id, $date, $time);
			$this->set('route_schedule',$route_schedule);
		}
	}
	public function confirmation()
	{
		$this->layout = 'pages';
		$page_url = '/deliveries/form';
		$primary_nav = $this->Menu_item->arrangeByTiers(4);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);			
		
		if(isset($_SESSION['Delivery'])){
			$this->set('deliveries',$_SESSION['Delivery']);	
		} else {
			$this->set('deliveries',array());
		}

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
		if(!empty($_SESSION['Delivery']['User']['id'])){
			//get payment info
			$customer_id = $_SESSION['Delivery']['User']['id'];
			$users = $this->User->find('all',array('conditions'=>array('User.id'=>$customer_id)));
			$profile_id = '';
			$payment_id = '';
			if(count($users)>0){
				foreach ($users as $u) {
					$profile_id = $u['User']['profile_id'];
					$payment_id = $u['User']['payment_id'];
				}
			}

			if(is_null($payment_id) || empty($payment_id)){
				$this->set('display_payment','Yes');
			} else {
				$this->set('display_payment','No');
			}
			
		} else {
			$this->set('display_payment','Yes');
		}
		
		/**
		 * post data for initial form validation
		 */
		if($this->request->is('post')){
			$this->Payment->set($this->request->data);
			//$this->Payment->validate($this->request->data);
			if ($this->Payment->validates()) {
			    // it validated logic
	
			    //$_SESSION['Delivery_data'] = $this->request->data;
			    if(isset($_SESSION['reschedule']) && $_SESSION['reschedule'] == 'Yes'){
			    	return $this->process_resend_delivery_form($this->request->data);
			    } else {
			    	return $this->process_final_delivery_form($this->request->data);	
			    }

			} else {
			    // didn't validate logic
			    $errors = $this->Payment->validationErrors;
			}
		}
	
	}
	/**
	 * Delivery form processing
	 * - includes saving delivery data, customer data, and payment data with authorize.net
	 */
	public function process_final_delivery_form()
	{
		if($this->request->is('post')){ //form handling from /delivery/confirmation
		
			//create the base for emails 
			$sendTo = $_SESSION['Delivery']['User']['contact_email'];
			$bcc = array('jayscleaners@gmail.com');
			$subject = 'Jays Cleaners Delivery Requested';
			
			//create token to save
			$original_string = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
			$token = $this->Delivery->get_random_string($original_string, 8);
		
			unset($_SESSION['payment_error']); //automatically unset the payment error array
			//set variables
			$user_update = array(); //create the new user data to update user table
			$user_update['User']['token'] = $token; //add the token
			$company_id = 1; //set to 1 for now change if we have multiple stores
			$saved_payment_profile = $this->request->data['Payment']['saved_profile'];
			if(isset($this->request->data['Payment']['payment_status'])){
				$payment_status = $this->request->data['Payment']['payment_status'];	
			} else {
				$payment_status = 'No';
			}
			
			switch($payment_status){
				case 'Yes': //we will keep the payment id and payment profile
				$user_update['User']['payment_status'] = 2;
				
				break;
					
				case 'No': //we will delete the payment id and payment profile after delivery completion
				$user_update['User']['payment_status'] = 1;
				break;
					
			}		

			$phone = preg_replace("/[^0-9]/","",$_SESSION['Delivery']['User']['contact_phone']); //strip phone to just numbers
			if(!empty($_SESSION['Delivery']['User']['id'])){
				$customer_id = $_SESSION['Delivery']['User']['id'];
				$users = $this->User->find('all',array('conditions'=>array('User.id'=>$customer_id)));
				$profile_id = '';
				$payment_id = '';
				
				if(count($users)>0){
					foreach ($users as $u) {
						$profile_id = $u['User']['profile_id'];
						$payment_id = $u['User']['payment_id'];
					}
				}	
				if($profile_id != null && $profile_id != 0 && $profile_id != ''){

					//check payment
					if($payment_id != null && $payment_id != 0 && $payment_id != ''){ //there is a payment id and a profile id just save and send email 

						$delivery_string = $this->Delivery->deliveryString($customer_id, $_SESSION['Delivery'], $token);
						//create delivery schedule
						$schedules = $this->Schedule->addSchedule($company_id, $customer_id, $_SESSION['Delivery']['Schedule'],$_SESSION['Delivery']['User']['special_instructions'], $token);
						//update the user table with the new data
						$this->User->id = $customer_id;
						$this->User->save($user_update);
		
						//primary email settings
						$Email = new CakeEmail('gmail');
						$Email->template('delivery-notification','delivery-notification')
						    ->emailFormat('html')
							->viewVars(compact('delivery_string'))
							//->to('onedough83@gmail.com')
						    ->to($sendTo)
							->bcc($bcc)
							->subject($subject);
						
						//backup email settings
						$Backup = new CakeEmail('default');
						//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
						$Backup->template('delivery-notification','delivery-notification')
						    ->emailFormat('html')
							->viewVars(compact(''))
							//->to('onedough83@gmail.com')
						    ->to($sendTo)
							->bcc($bcc)
							->subject($subject);
		
		
						//simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
						try
						{
							$Email->send();
						} 
						catch (SocketException $e)
						{
							$Backup->send();	
						}		
						unset($_SESSION['Delivery']);
						unset($_SESSION['reschedule']);
						$this->Session->setFlash(__('Thank you for making a reservation with us. We have sent you an email with all of the delivery information.','default',array(),'success'));
						$this->redirect(array('controller'=>'deliveries','action'=>'thank_you'));						
					} else { //there is a profile id but no payment_id

						//create a payment_id
						$users[0]['User']['ccnum'] =preg_replace("/[^0-9]/","",$this->request->data['Payment']['ccnum']);
						$users[0]['User']['exp_month'] = preg_replace("/[^0-9]/","",$this->request->data['Payment']['exp_month']);
						$users[0]['User']['exp_year'] = preg_replace("/[^0-9]/","",$this->request->data['Payment']['exp_year']);
						$users[0]['User']['token'] = $token;
		
						$create_payment_id = $this->AuthorizeNet->createPaymentProfile($users[0],$profile_id);
						$user_update['User']['payment_id'] = $create_payment_id['customerPaymentProfileId'];		
						
						switch($create_payment_id['status']){
							case 'approved':
						
								$delivery_string = $this->Delivery->deliveryString($customer_id, $_SESSION['Delivery'], $token);
								//create delivery schedule
								$schedules = $this->Schedule->addSchedule($company_id, $customer_id, $_SESSION['Delivery']['Schedule'],$_SESSION['Delivery']['User']['special_instructions'], $token);
								//update the user table with the new data
								$this->User->id = $customer_id;
								$this->User->save($user_update);
			
								//primary email settings
								$Email = new CakeEmail('gmail');
								$Email->template('delivery-notification','delivery-notification')
								    ->emailFormat('html')
									->viewVars(compact('delivery_string'))
									//->to('onedough83@gmail.com')
								    ->to($sendTo)
									->bcc($bcc)
									->subject($subject);
								
								//backup email settings
								$Backup = new CakeEmail('default');
								//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
								$Backup->template('delivery-notification','delivery-notification')
								    ->emailFormat('html')
									->viewVars(compact(''))
									//->to('onedough83@gmail.com')
								    ->to($sendTo)
									->bcc($bcc)
									->subject($subject);
			
			
								//simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
								try
								{
									$Email->send();
								} 
								catch (SocketException $e)
								{
									$Backup->send();	
								}		
								unset($_SESSION['Delivery']);
								unset($_SESSION['reschedule']);
								$this->Session->setFlash(__('Thank you for making a reservation with us. We have sent you an email with all of the delivery information.','default',array(),'success'));
								$this->redirect(array('controller'=>'deliveries','action'=>'thank_you'));								
							break;
								
							default:
								//debug($user_update);
								$this->Session->setFlash(__('Error: '.$create_payment_id['response']),'default',array(),'error');
								$_SESSION['payment_error'] = $create_payment_id; 
								$this->redirect(array('controller'=>'deliveries','action'=>'confirmation'));								
							break;
								
						}											
						
					}
				} else { //there is no profile id 

					//create a profile id
					$profiles = $this->AuthorizeNet->createProfile($users[0]);

					//save profile id
					switch($profiles['status']){
						case 'approved':
							
							$profile_id = $profiles['customerProfileId'];
							$user_update['User']['profile_id'] = $profile_id;
							if($payment_id != null && $payment_id != 0 && $payment_id != ''){ //there is a payment id and a profile id just save and send email 
								$delivery_string = $this->Delivery->deliveryString($customer_id, $_SESSION['Delivery'], $token);
								//create delivery schedule
								$schedules = $this->Schedule->addSchedule($company_id, $customer_id, $_SESSION['Delivery']['Schedule'],$_SESSION['Delivery']['User']['special_instructions'], $token);
								//update the user table with the new data
								$this->User->id = $customer_id;
								$this->User->save($user_update);
								//primary email settings
								$Email = new CakeEmail('gmail');
								$Email->template('delivery-notification','delivery-notification')
								    ->emailFormat('html')
									->viewVars(compact('delivery_string'))
									//->to('onedough83@gmail.com')
								    ->to($sendTo)
									->bcc($bcc)
									->subject($subject);
								
								//backup email settings
								$Backup = new CakeEmail('default');
								//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
								$Backup->template('delivery-notification','delivery-notification')
								    ->emailFormat('html')
									->viewVars(compact(''))
									//->to('onedough83@gmail.com')
								    ->to($sendTo)
									->bcc($bcc)
									->subject($subject);
			
			
								//simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
								try
								{
									$Email->send();
								} 
								catch (SocketException $e)
								{
									$Backup->send();	
								}		
								unset($_SESSION['Delivery']);
								unset($_SESSION['reschedule']);
								$this->Session->setFlash(__('Thank you for making a reservation with us. We have sent you an email with all of the delivery information.','default',array(),'success'));
								$this->redirect(array('controller'=>'deliveries','action'=>'thank_you'));								
							} else { //there is no poyment id then make one

								//create a payment_id
								$users[0]['User']['ccnum'] =preg_replace("/[^0-9]/","",$this->request->data['Payment']['ccnum']);
								$users[0]['User']['exp_month'] = preg_replace("/[^0-9]/","",$this->request->data['Payment']['exp_month']);
								$users[0]['User']['exp_year'] = preg_replace("/[^0-9]/","",$this->request->data['Payment']['exp_year']);
								$users[0]['User']['token'] = $token;
								$create_payment_id = $this->AuthorizeNet->createPaymentProfile($users[0],$profile_id);
								
								switch($create_payment_id['status']){
									case 'approved':

										$user_update['User']['payment_id'] = $create_payment_id['customerPaymentProfileId'];										
										$delivery_string = $this->Delivery->deliveryString($customer_id, $_SESSION['Delivery'], $token);
										//create delivery schedule
										$schedules = $this->Schedule->addSchedule($company_id, $customer_id, $_SESSION['Delivery']['Schedule'],$_SESSION['Delivery']['User']['special_instructions'], $token);
										//update the user table with the new data
										$this->User->id = $customer_id;
										$this->User->save($user_update);
					
										//primary email settings
										$Email = new CakeEmail('gmail');
										$Email->template('delivery-notification','delivery-notification')
										    ->emailFormat('html')
											->viewVars(compact('delivery_string'))
											//->to('onedough83@gmail.com')
										    ->to($sendTo)
											->bcc($bcc)
											->subject($subject);
										
										//backup email settings
										$Backup = new CakeEmail('default');
										//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
										$Backup->template('delivery-notification','delivery-notification')
										    ->emailFormat('html')
											->viewVars(compact(''))
											//->to('onedough83@gmail.com')
										    ->to($sendTo)
											->bcc($bcc)
											->subject($subject);
					
					
										//simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
										try
										{
											$Email->send();
										} 
										catch (SocketException $e)
										{
											$Backup->send();	
										}		
										unset($_SESSION['Delivery']);
										unset($_SESSION['reschedule']);
										$this->Session->setFlash(__('Thank you for making a reservation with us. We have sent you an email with all of the delivery information.','default',array(),'success'));
										$this->redirect(array('controller'=>'deliveries','action'=>'thank_you'));								
									break;
										
									default:
										//debug($user_update);
										$this->Session->setFlash(__('Error: '.$create_payment_id['response']),'default',array(),'error');

										$this->redirect(array('controller'=>'deliveries','action'=>'confirmation'));								
									break;
										
								}									
							}	
								
						break;
							
						case 'rejected': //profile creation has been rejected please try again
							$this->Session->setFlash(__('Error: '.$create_payment_id['response']),'default',array(),'error');

							$this->redirect(array('controller'=>'deliveries','action'=>'confirmation'));									
						break;
					}			

			
				}
							
			} else {

				//lookup customer by phone number
				$ccnum = preg_replace("/[^0-9]/","",$this->request->data['Payment']['ccnum']);
				$exp_month = preg_replace("/[^0-9]/","",$this->request->data['Payment']['exp_month']);
				$exp_year = preg_replace("/[^0-9]/","",$this->request->data['Payment']['exp_year']);
				$cvv = preg_replace("/[^0-9]/","",$this->request->data['Payment']['cvv']);

				$customer_search_conditions = array('User.contact_phone'=>$phone);
				$customer_search = $this->User->find('all',array('conditions'=>$customer_search_conditions));	

				if(count($customer_search)>0){ //this is a returning guest

					foreach ($customer_search as $cs) {
						$customer_id = $cs['User']['id'];
						$profile_id = $cs['User']['profile_id'];
						$payment_id = $cs['User']['payment_id'];
						
						if(is_null($profile_id) || $profile_id ==0 || $profile_id == ''){ //this is a new member with no profile id
							//create a profile id
							$profiles = $this->AuthorizeNet->createProfile($customer_search[0]);
							//save profile id
							switch($profiles['status']){
								case 'approved':
									$profile_id = $profiles['customerProfileId'];
									$user_update['User']['profile_id'] = $profile_id;
											
								break;
									
								case 'rejected':
									$user_update['User']['profile_id'] = $profile_id;
								break;
							}
							
						}
						
						if(is_null($payment_id) || $payment_id == 0 || $payment_id == ''){ //we will delete the payment id and payment profile
							//create a payment_id
							$customer_search[0]['User']['ccnum'] = $ccnum;
							$customer_search[0]['User']['exp_month'] = $exp_month;
							$customer_search[0]['User']['exp_year'] = $exp_year;
							$create_payment_id = $this->AuthorizeNet->createPaymentProfile($customer_search[0],$profile_id);
							switch($create_payment_id['status']){
								case 'approved':
									$user_update['User']['payment_id'] = $create_payment_id['customerPaymentProfileId'];		
									//debug($user_update);
									$this->User->id = $customer_id;
									$this->User->save($user_update);
									//update the schedules table with the new delivery data
									$schedules = $this->Schedule->addSchedule($company_id, $customer_id, $_SESSION['Delivery']['Schedule'],$_SESSION['Delivery']['User']['special_instructions'], $token);

									$delivery_string = $this->Delivery->deliveryString($customer_id, $_SESSION['Delivery'], $token);

									//update the user table with the new data
									$this->User->id = $customer_id;
									$this->User->save($user_update);
				
									//primary email settings
									$Email = new CakeEmail('gmail');
									$Email->template('delivery-notification','delivery-notification')
									    ->emailFormat('html')
										->viewVars(compact('delivery_string'))
										//->to('onedough83@gmail.com')
									    ->to($sendTo)
										->bcc($bcc)
										->subject($subject);
									
									//backup email settings
									$Backup = new CakeEmail('default');
									//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
									$Backup->template('delivery-notification','delivery-notification')
									    ->emailFormat('html')
										->viewVars(compact(''))
										//->to('onedough83@gmail.com')
									    ->to($sendTo)
										->bcc($bcc)
										->subject($subject);
				
				
									//simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
									try
									{
										$Email->send();
									} 
									catch (SocketException $e)
									{
										$Backup->send();	
									}												
									unset($_SESSION['Delivery']);
									unset($_SESSION['reschedule']);
									$this->Session->setFlash(__('Thank you for making a reservation with us. We have sent you an email with all of the delivery information.','default',array(),'success'));
									$this->redirect(array('controller'=>'deliveries','action'=>'thank_you'));								
								break;
									
								case 'rejected': //rejected create session and redirect now
									//debug($user_update);
									$this->Session->setFlash(__('Error: '.$create_payment_id['response']),'default',array(),'error');
									$_SESSION['payment_error'] = $create_payment_id; 
									$this->redirect(array('controller'=>'deliveries','action'=>'confirmation'));
								break;
							}
				

						} else {
							//create delivery schedule
							$schedules = $this->Schedule->addSchedule($company_id, $customer_id, $_SESSION['Delivery']['Schedule'],$_SESSION['Delivery']['User']['special_instructions'], $token);
					
							//update user data
							$this->User->id = $customer_id;
							$this->User->save($user_update);
							
							//send email to customer
							$delivery_string = $this->Delivery->deliveryString($customer_id, $_SESSION['Delivery'], $token);

							//update the user table with the new data
							$this->User->id = $customer_id;
							$this->User->save($user_update);
		
							//primary email settings
							$Email = new CakeEmail('gmail');
							$Email->template('delivery-notification','delivery-notification')
							    ->emailFormat('html')
								->viewVars(compact('delivery_string'))
							    ->to($sendTo)
								->bcc($bcc)
								->subject($subject);
							
							//backup email settings
							$Backup = new CakeEmail('default');
							//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
							$Backup->template('delivery-notification','delivery-notification')
							    ->emailFormat('html')
								->viewVars(compact(''))
							    ->to($sendTo)
								->bcc($bcc)
								->subject($subject);
		
		
							//simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
							try
							{
								$Email->send();
							} 
							catch (SocketException $e)
							{
								$Backup->send();	
							}										
							unset($_SESSION['Delivery']);
							unset($_SESSION['reschedule']);
							$this->Session->setFlash(__('Thank you for making a reservation with us. We have sent you an email with all of the delivery information.','default',array(),'success'));
							$this->redirect(array('controller'=>'deliveries','action'=>'thank_you'));									
						}

					}
				} else { //this is a new guest
					$profile_id = '';
					$user_update['User']['group_id'] = 5;
					$user_update['User']['company_id'] = 1;
					$user_update['User']['email'] = $_SESSION['Delivery']['User']['contact_email'];
					$user_update['User']['first_name'] = $_SESSION['Delivery']['User']['first_name'];
					$user_update['User']['last_name'] = $_SESSION['Delivery']['User']['last_name'];
					$user_update['User']['contact_address'] = $_SESSION['Delivery']['User']['contact_address'];
					$user_update['User']['contact_suite'] = $_SESSION['Delivery']['User']['contact_suite'];
					$user_update['User']['contact_city'] = $_SESSION['Delivery']['User']['contact_city'];
					$user_update['User']['contact_state'] = $_SESSION['Delivery']['User']['contact_state'];
					$user_update['User']['contact_country'] = 'USA';
					$user_update['User']['first_name'] = $_SESSION['Delivery']['User']['first_name'];
					$user_update['User']['contact_email'] = $_SESSION['Delivery']['User']['contact_email'];
					$user_update['User']['contact_zip'] = $_SESSION['Delivery']['User']['contact_zip'];
					$user_update['User']['contact_phone'] = $_SESSION['Delivery']['User']['phone'];
					$user_update['User']['special_instructions'] = $_SESSION['Delivery']['User']['special_instructions'];
					
					$profiles = $this->AuthorizeNet->createProfile($user_update);
					//save profile id
					switch($profiles['status']){
						case 'approved':
							$profile_id = $profiles['customerProfileId'];
							$user_update['User']['profile_id'] = $profile_id;
						break;
							
						case 'rejected':
							$user_update['User']['profile_id'] = $profile_id;
						break;
					}
					$user_update['User']['profile_id'] = $profile_id['customerProfileId'];
					$user_update['User']['ccnum'] = $ccnum;
					$user_update['User']['exp_num'] = $exp_num;
					$user_update['User']['exp_year'] = $exp_year;
					$create_payment_id = $this->AuthorizeNet->createPaymentProfile($user_update,$profile_id);
					switch($create_payment_id['status']){
						case 'approved':

							$user_update['User']['payment_id'] = $create_payment_id['customerPaymentProfileId'];		
							switch($payment_status){
								case 'Yes': //we will delete the payment id and payment profile
								$user_update['User']['payment_status'] = 2;
								break;
									
								default: //we will delete the payment id and payment profile after delivery completion
								$user_update['User']['payment_status'] = 1;
								break;
							}			
							//create delivery schedule
							$schedules = $this->Schedule->addSchedule($company_id, $customer_id, $_SESSION['Delivery']['Schedule'],$_SESSION['Delivery']['User']['special_instructions'], $token);			
							
							$this->User->id = $customer_id;
							$this->User->save($user_update);
							
							$delivery_string = $this->Delivery->deliveryString($customer_id, $_SESSION['Delivery'], $token);

							//update the user table with the new data
							$this->User->id = $customer_id;
							$this->User->save($user_update);
		
							//primary email settings
							$Email = new CakeEmail('gmail');
							$Email->template('delivery-notification','delivery-notification')
							    ->emailFormat('html')
								->viewVars(compact('delivery_string'))
								//->to('onedough83@gmail.com')
							    ->to($sendTo)
								->bcc($bcc)
								->subject($subject);
							
							//backup email settings
							$Backup = new CakeEmail('default');
							//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
							$Backup->template('delivery-notification','delivery-notification')
							    ->emailFormat('html')
								->viewVars(compact('delivery_string'))
								//->to('onedough83@gmail.com')
							    ->to($sendTo)
								->bcc($bcc)
								->subject($subject);
		
		
							//simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
							try
							{
								$Email->send();
							} 
							catch (SocketException $e)
							{
								$Backup->send();	
							}										
										
							unset($_SESSION['Delivery']);
							unset($_SESSION['reschedule']);
							$this->Session->setFlash(__('Thank you for making a reservation with us. We have sent you an email with all of the delivery information.','default',array(),'success'));
							$this->redirect(array('controller'=>'deliveries','action'=>'thank_you'));									
						break;
							
						case 'rejected': //rejected create session and redirect now
							//$this->Session->setFlash(__('Error: '.$create_payment_id['response']),'default',array(),'error');
							$_SESSION['payment_error'] = $create_payment_id; 
							$this->redirect(array('controller'=>'deliveries','action'=>'confirmation'));
						break;
					}
				
				}
			} //end if no customer_id	

		}		
	}

	/**
	 * Delivery resend form processing
	 * - includes saving delivery data, customer data, and payment data with authorize.net
	 */
	public function process_resend_delivery_form()
	{
		if($this->request->is('post')){ //form handling from /delivery/confirmation
			//create the base for emails 
			$sendTo = $_SESSION['Delivery']['User']['contact_email'];
			$bcc = array('jayscleaners@gmail.com');
			$subject = 'Jays Cleaners Delivery Change Requested';
			
			//create token to save
			$old_token = $_SESSION['old_token'];
			$customer_id = $_SESSION['Delivery']['User']['id'];
			$company_id = 1;
		
			unset($_SESSION['payment_error']); //automatically unset the payment error array
			
			$user_update = array(); //start user array
			
			$delivery_string = $this->Delivery->deliveryString($customer_id, $_SESSION['Delivery'], $old_token);
			//create delivery schedule
			$schedules = $this->Schedule->editSchedule($company_id, $customer_id, $_SESSION['Delivery']['Schedule'],$_SESSION['Delivery']['User']['special_instructions'], $old_token);
			//update the user table with the new data


			//primary email settings
			$Email = new CakeEmail('gmail');
			$Email->template('delivery-notification','delivery-notification')
			    ->emailFormat('html')
				->viewVars(compact('delivery_string'))
				//->to('onedough83@gmail.com')
			    ->to($sendTo)
				->bcc($bcc)
				->subject($subject);
			
			//backup email settings
			$Backup = new CakeEmail('default');
			//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
			$Backup->template('delivery-notification','delivery-notification')
			    ->emailFormat('html')
				->viewVars(compact('delivery_string'))
				//->to('onedough83@gmail.com')
			    ->to($sendTo)
				->bcc($bcc)
				->subject($subject);


			//simple try and cach. cakeemail throws and exception if there is an error. If caught run the backup server.
			try
			{
				$Email->send();
			} 
			catch (SocketException $e)
			{
				$Backup->send();	
			}		
			unset($_SESSION['Delivery']);
			unset($_SESSION['reschedule']);
			unset($_SESSION['old_token']);
			
			$this->Session->setFlash(__('Your delivery has been edited and a new email has been sent to your email address. Please review your delivery.'),'default',array(),'success');
			$this->redirect(array('action'=>'thank_you'));
		}		
	}


	public function restart()
	{
		unset($_SESSION['Delivery']);
		$this->Session->setFlash(__('Your delivery session has been reset'),'default',array(),'success');
		$this->redirect('/');
	}
	
	public function reschedule($token = null)
	{
		$this->layout = 'pages';
		$page_url = '/deliveries/reschedule';
		$primary_nav = $this->Menu_item->arrangeByTiers(4);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);		
		$_SESSION['reschedule'] = 'Yes';
		$_SESSION['old_token'] = $token;
		if(is_null($token)){
			$this->Session->setFlash(__('You do not have any delivery to reschedule. Please try again'),'default',array(),'error');
		}
			
		$users = $this->User->find('all',array('conditions'=>array('token'=>$token)));
		if(count($users)>0){
			foreach ($users as $user) {
				$zipcode = $user['User']['contact_zip'];
				$customer_id = $user['User']['id'];
				$_SESSION['Delivery']['User']['id'] = $customer_id;
				$_SESSION['Delivery']['User']['contact_zip'] = $zipcode;
				$_SESSION['Delivery']['User']['first_name'] = $user['User']['first_name'];
				$_SESSION['Delivery']['User']['last_name'] = $user['User']['last_name'];
				$_SESSION['Delivery']['User']['contact_phone'] = $user['User']['contact_phone'];
				$_SESSION['Delivery']['User']['contact_email'] = $user['User']['contact_email'];
				$_SESSION['Delivery']['User']['contact_address'] = $user['User']['contact_address'];
				$_SESSION['Delivery']['User']['contact_suite'] = $user['User']['contact_suite'];
				$_SESSION['Delivery']['User']['contact_city'] = $user['User']['contact_city'];
				$_SESSION['Delivery']['User']['contact_state'] = $user['User']['contact_state'];
				$_SESSION['Delivery']['User']['contact_zip'] = $user['User']['contact_zip'];
				$_SESSION['Delivery']['User']['special_instructions'] = $user['User']['special_instructions'];
			}
			$company_id = 1;
			
			$this->set('zipcode',$zipcode);
			$base_routes = $this->Delivery->routes($zipcode,$company_id);
			$find_routes = $this->Delivery->view_schedule($this->Delivery->routes($zipcode,$company_id));
			$month = date('m');
			$year = date('Y');
			$route_schedule = $this->Schedule->create_pickup_schedule($base_routes,$company_id,$month, $year);
			
			if(count($find_routes)>0){
				$this->set('route_status','1');
				$this->set('routes',$find_routes);
			} else {
				$this->set('route_status','0');
				$this->set('routes',array());
			}
			$this->set('route_schedule',$route_schedule);
			if($this->request->is('post')){
				$customer_id = $_SESSION['Delivery']['User']['id'];
				$dropoff_date = $this->request->data['Schedule']['dropoff_date'];
				$dropoff_time = $this->request->data['Schedule']['dropoff_time'];
				$pickup_date = $this->request->data['Schedule']['pickup_date'];
				$pickup_time = $this->request->data['Schedule']['pickup_time'];
				
				
				$_SESSION['Delivery']['Schedule']['customer_id'] = $customer_id;
				$_SESSION['Delivery']['Schedule']['pickup_date'] = date('Y-m-d H:i:s',strtotime($pickup_date));
				$_SESSION['Delivery']['Schedule']['pickup_delivery_id'] = $pickup_time;
				$_SESSION['Delivery']['Schedule']['dropoff_date'] = date('Y-m-d H:i:s',strtotime($dropoff_date));
				$_SESSION['Delivery']['Schedule']['dropoff_delivery_id'] = $dropoff_time;
				$_SESSION['Delivery']['Schedule']['company_id'] = 1;
				$_SESSION['Delivery']['Schedule']['status'] = 1;
				$_SESSION['Delivery']['Schedule']['type'] = 'frontend';
				$_SESSION['message'] = 'You have successfully selected your delivery date and time. Please confirm all the information below and submit your payment information';
				$this->redirect(array('controller'=>'deliveries','action'=>'confirmation'));
			}			
		}
		
		
		
	}
	
	public function thank_you()
	{
		$this->layout = 'pages';
		$page_url = '/deliveries/thank_you';
		$primary_nav = $this->Menu_item->arrangeByTiers(4);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);	
	
	}
	
	public function finish()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/deliveries/finish';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
		$company_id = 1;	
		if(isset($_SESSION['finish_date'])){
			$start = date('Y-m-d',strtotime($_SESSION['finish_date'])).' 00:00:00';
			$end = date('Y-m-d', strtotime($_SESSION['finish_date'])).' 23:59:59';	
			$date = $_SESSION['finish_date'];			
		} else {
			$start = date('Y-m-d').' 00:00:00';
			$end = date('Y-m-d').' 23:59:59';	
			$date = date('n/d/Y');
		}

		$conditions_pickup= array('Schedule.pickup_date BETWEEN ? AND ?' => array($start,$end));
		$day_pickup = $this->Schedule->find('all',array('conditions'=>$conditions_pickup));
		$conditions_dropoff= array('Schedule.dropoff_date BETWEEN ? AND ?' => array($start,$end));
		$day_dropoff = $this->Schedule->find('all',array('conditions'=>$conditions_dropoff));
		$prepare_schedule_today = $this->Schedule->setSchedule($day_pickup, $day_dropoff);
		$this->set('date',$date);
		$this->set('today',$prepare_schedule_today);
		unset($_SESSION['finish_date']);

		if($this->request->is('post')){
			$delivery_start = date('Y-m-d',strtotime($this->request->data['Delivery']['date'])).' 00:00:00';
			$delivery_end = date('Y-m-d',strtotime($this->request->data['Delivery']['date'])).' 23:59:59';
			$date = date('n/d/Y',strtotime($this->request->data['Delivery']['date']));
			$conditions_pickup= array('Schedule.pickup_date BETWEEN ? AND ?' => array($delivery_start,$delivery_end));
			$day_pickup = $this->Schedule->find('all',array('conditions'=>$conditions_pickup));
			$conditions_dropoff= array('Schedule.dropoff_date BETWEEN ? AND ?' => array($delivery_start,$delivery_end));
			$day_dropoff = $this->Schedule->find('all',array('conditions'=>$conditions_dropoff));

			$prepare_schedule_date = $this->Schedule->setSchedule($day_pickup, $day_dropoff);
			
			$this->set('date',$date);
			$this->set('today',$prepare_schedule_date);	

			

		}
	}


	/**
	 * Drop off delivery order and make payment
	 * 
	 */
	public function dropoff_order()
	{
		if($this->request->is('post')){
			$date = $this->request->data['Schedule']['date'];
			$schedule_id = $this->request->data['Schedule']['id'];
			$profile_id = $this->request->data['Schedule']['profile_id'];
			$payment_id = $this->request->data['Schedule']['payment_id'];
			$payment_status = $this->request->data['Schedule']['payment_status'];
			$total = $this->request->data['Schedule']['total'];
			$new_status = $this->request->data['Schedule']['status'];
			$this->request->data['Schedule']['invoices'] = json_decode($this->request->data['Schedule']['invoices'],true);
			$payment_data = $this->request->data;
			unset($this->request->data['Schedule']);
			$schedule = array();
			$schedule['Schedule']['status'] = $new_status;
			$this->Schedule->id = $schedule_id;
			if($this->Schedule->save($schedule)){
				//make payment
				$this->Session->setFlash(__('Successfully finished and received payment for schedule id #'.$schedule_id),'default',array(),'success');
				$payment_status = $this->AuthorizeNet->createTransaction($payment_data);
				$_SESSION['finish_date'] = $date;
				$this->redirect(array('controller'=>'deliveries','action'=>'finish'));
		
			}

		}
	}
	public function dropoff_revert_order()
	{
		if($this->request->is('post')){
			$date = $this->request->data['Schedule']['date'];
			$schedule_id = $this->request->data['Schedule']['id'];
			
			$get_trans = $this->Transaction->find('all',array('conditions'=>array('schedule_id'=>$schedule_id)));
			if(count($get_trans)>0){
				foreach ($get_trans as $t) {
					$this->request->data['Schedule']['invoices'] = json_decode($t['Transaction']['invoices'],true);
				}
			} else {
				$this->request->data['Schedule']['invoices'] = array();
			}
			$profile_id = $this->request->data['Schedule']['profile_id'];
			$payment_id = $this->request->data['Schedule']['payment_id'];
			$payment_status = $this->request->data['Schedule']['payment_status'];
			$total = $this->request->data['Schedule']['total'];
			$new_status = $this->request->data['Schedule']['status'];
			$payment_data = $this->request->data;
			unset($this->request->data['Schedule']);
	
			$schedule = array();
			$schedule['Schedule']['status'] = $new_status;
			$this->Schedule->id = $schedule_id;
			if($this->Schedule->save($schedule)){
				$this->Session->setFlash(__('Successfully reverted order for schedule id #'.$schedule_id),'default',array(),'success');
				//make revert payment and invoice data
				$this->Transaction->revertDeliveryPayment($payment_data);
				//send email reciept
				$_SESSION['finish_date'] = $date;
				$this->redirect(array('controller'=>'deliveries','action'=>'finish'));
				// $this->request->data['Delivery']['date'] = $date;	
				// return $this->finish($this->request->data);		
			}
		}
	}
	public function pickup_order()
	{
		if($this->request->is('post')){
			$date = $this->request->data['Schedule']['date'];
			$schedule_id = $this->request->data['Schedule']['id'];
			$profile_id = $this->request->data['Schedule']['profile_id'];
			$payment_id = $this->request->data['Schedule']['payment_id'];
			$payment_status = $this->request->data['Schedule']['payment_status'];
			$total = $this->request->data['Schedule']['total'];
			$new_status = $this->request->data['Schedule']['status'];
			$this->Session->write('date',$date);
			unset($this->request->data['Schedule']);
	
			$schedule = array();
			$schedule['Schedule']['status'] = $new_status;
			$this->Schedule->id = $schedule_id;
			if($this->Schedule->save($schedule)){
				$_SESSION['finish_date'] = $date;
				$this->Session->setFlash(__('Successfully picked up for schedule id #'.$schedule_id),'default',array(),'success');
				$this->redirect(array('controller'=>'deliveries','action'=>'finish'));
				// $this->request->data['Delivery']['date'] = $date;	
				// return $this->finish($this->request->data);		
			}
		}
	}
	public function pickup_revert_order()
	{
		if($this->request->is('post')){
			$date = $this->request->data['Schedule']['date'];
			$schedule_id = $this->request->data['Schedule']['id'];
			$profile_id = $this->request->data['Schedule']['profile_id'];
			$payment_id = $this->request->data['Schedule']['payment_id'];
			$payment_status = $this->request->data['Schedule']['payment_status'];
			$total = $this->request->data['Schedule']['total'];
			$new_status = $this->request->data['Schedule']['status'];
			$this->Session->write('date',$date);
			unset($this->request->data['Schedule']);
	
			$schedule = array();
			$schedule['Schedule']['status'] = $new_status;
			$this->Schedule->id = $schedule_id;
			if($this->Schedule->save($schedule)){
				$_SESSION['finish_date'] = $date;
				$this->Session->setFlash(__('Successfully reverted pickup order for schedule id #'.$schedule_id),'default',array(),'success');
				$this->redirect(array('controller'=>'deliveries','action'=>'finish'));
				// $this->request->data['Delivery']['date'] = $date;	
				// return $this->finish($this->request->data);			
			}
		}
	}
}
