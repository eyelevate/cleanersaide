<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail','Network/Email'); //cakes email class
/**
 * Ferries Controller
 *
 * @property Ferry $Ferry
 */
/**
 * app/Controller/FerriesController.php
 */
class SchedulesController extends AppController {
    //Name (should be same as the class name)
    public $name = 'Schedules';

	public $uses = array(
		'Schedule','Delivery','User','Group'
	); // add the models this controller uses here

	
	public $helpers = array('Html', 'Form', 'Csv'); 
	
/**
 * Parses this code first on all actions in this controller
 */
	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the authorized username
		$this->set('username',AuthComponent::user('username'));
		//deny all public users to this page
		//$this->Auth->allow('request','request_edit_check');
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
		//setup the layout on the page
		$this->layout = 'admin';
		
		//set variables for page
		$group_id = $this->Auth->user('Group.id');
		//$grps = $this->Group->find('all',array('conditions'=>array('id'=>$group_id)));
		$this->set('group_id',$group_id);		
		
		
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
		$page_url = '/schedules/index';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);   
		
		$inventories = $this->Schedule->reorderInventory($this->Inventory->find('all'));
		$this->set('inventories',$inventories);

    }

/**	
 * creates a new ferry schedule
 * @return void
 */
	public function add()
	{
		//select menu
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/schedules/add';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
		
		$inventories = $this->Inventory->find('all');
		$this->set('inventories',$inventories);
		$inv_items = $this->Inventory_item->arrangeInventory($inventories);
		$this->set('inv_items',$inv_items);
		
		//get ferry data 
		$ferry_inv = $this->Ferry_inventory->getRatesById($this->Inventory_item->find('all'));
		$this->set('ferry_inv',$ferry_inv);
		
		//get ferry limits
		$limits = $this->Ferry_limit->getLimitById($inventories);
		$this->set('limits',$limits);
		
		//if post
		if($this->request->is('post')){

			if(isset($this->request->data['type']) && $this->request->data['type'] == 'NIS'){ //if this is a NIS request
				$start = $this->request->data['startDate'];
				$end = $this->request->data['endDate'];
				$startMonth = substr($start,0,2);
				$startDay = substr($start,3,2);
				$startYear = substr($start,-4);
				$endMonth = substr($end,0,2);
				$endDay = substr($end,3,2);
				$endYear = substr($end,-4);
				$startDate = strtotime($startYear.'-'.$startMonth.'-'.$startDay.' 00:00:00');
				$endDate = strtotime($endYear.'-'.$endMonth.'-'.$endDay.' 00:00:00');
				$total_days = ($endDate-$startDate)/86400;
				for ($i=0; $i <= $total_days; $i++) {
					$this->request->data['Schedule'][$i]['nis_description'] =$this->request->data['nis'];
					$this->request->data['Schedule'][$i]['status'] = '2';
					$this->request->data['Schedule'][$i]['service_date']= date('Y-m-d',($startDate+($i*86400))).' 00:00:00'; 
					$this->request->data['Schedule'][$i]['check_date'] = date('Y-m-d',($startDate+($i*86400))).' 00:00:00'; 
					$service_date = $this->request->data['Schedule'][$i]['service_date'];

					$change = $this->Schedule->find('all',array('conditions'=>array('check_date'=>$service_date,'status'=>1)));
					if(count($change)>0){
						foreach ($change as $ckey => $cvalue) {
							$change_id = $change[$ckey]['Schedule']['id'];
							$this->Schedule->id = $change_id;
							
							$data = array('id'=>$change_id,'status'=>3);

							$this->Schedule->save($data);
						}
					}
				}

				$this->Schedule->saveAll($this->request->data['Schedule']);
				//empty the array
				unset($this->request->data);
				//redirect to index page
				$this->Session->setFlash(__('Success! You have successfully added a new schedule to the master calendar'), "default", array(), "success");
				$this->redirect(array('action'=>'index'));
			}
			
		}	

		
	}
/**	
 * Edits the chosen ferry
 * @return void
 */
	public function edit($id = null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/schedules/edit';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);

		if (!$this->request->is('post')) {
			$this->Session->setFlash(__('Error: The form was reset. Please set edit dates before viewing page.'),'default',array(),'error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->request->is('post')) {
			//debug($this->request->data);
			$type = $this->request->data['form_type'];
			switch ($type) {
				case 'Edit_Schedule_Incoming':
					$start = $this->request->data['start'];
					$end = $this->request->data['end'];
					$startMonth = substr($start,0,2);
					$startDay = substr($start,3,2);
					$startYear = substr($start,-4);
					$endMonth = substr($end,0,2);
					$endDay = substr($end,3,2);
					$endYear = substr($end,-4);
					$startDate = date('Y-m-d H:i:s',strtotime($startYear.'-'.$startMonth.'-'.$startDay.' 00:00:00'));
					$endDate = date('Y-m-d H:i:s',strtotime($endYear.'-'.$endMonth.'-'.$endDay.' 23:59:59'));	
					$startTrip = strtotime($startYear.'-'.$startMonth.'-'.$startDay.' 00:00:00');
					$endTrip = strtotime($endYear.'-'.$endMonth.'-'.$endDay.' 00:00:00');
					$total_trips = ($endTrip-$startTrip)/86400;
					//find all thats editable and status = 1
					$edit_array = array();
					$nis_array = array();
					$avg_trip_count = 0;
					for ($i=0; $i <= $total_trips; $i++) { 
						$newStart = date('Y-m-d',($startTrip+($i*86400))).' 00:00:00';
						$newEnd = date('Y-m-d',($startTrip+($i*86400))).' 23:59:59';
						
						$find = $this->Schedule->query('select * from schedules 
														where status = "1"
														and check_date between "'.$newStart.'" and "'.$newEnd.'" 
														order by check_date asc');
						
						if(count($find)>0){
							foreach ($find as $key=>$value) {
								$id = $find[$key]['schedules']['id'];
								$departs = $find[$key]['schedules']['departs'];
								$trip = $find[$key]['schedules']['trip'];
								$service = $find[$key]['schedules']['service_date'];
								$depart_time = $find[$key]['schedules']['depart_time'];
								$rates_id = $find[$key]['schedules']['rates_id'];
								$status = $find[$key]['schedules']['status'];
								
								$edit_array[$newStart][$key] = array(
									'id'=>$id,
									'departs'=>$departs,
									'trip'=>$trip,
									'date'=>$service,
									'time'=>$depart_time,
									'rates_id'=>$rates_id,
									'status'=>$status
								);
							}
							$avg_trip_count = $avg_trip_count + count($find);
						}
						$nis = $this->Schedule->query('select * from schedules 
														where status = "2"
														and check_date between "'.$newStart.'" and "'.$newEnd.'" 
														order by check_date asc');
			
						if(count($nis)>0){
							foreach ($nis as $key=>$value) {
								$id = $nis[$key]['schedules']['id'];
								$departs = $nis[$key]['schedules']['departs'];
								$trip = $nis[$key]['schedules']['trip'];
								$service = $nis[$key]['schedules']['service_date'];
								$depart_time = $nis[$key]['schedules']['depart_time'];
								$rates_id = $nis[$key]['schedules']['rates_id'];
								$status = $nis[$key]['schedules']['status'];
								
								$nis_array[$id] = array(
									'id'=>$id,
									'newStart'=>$newStart,
									'departs'=>$departs,
									'trip'=>$trip,
									'date'=>$service,
									'time'=>$depart_time,
									'rates_id'=>$rates_id,
									'status'=>$status
								);
							}
						}
					}
					if($total_trips ==0){
						$avgTrips = 0;
					} else {
						$avgTrips = ceil(($avg_trip_count/$total_trips)/2);
					
					}
					$this->set('avg_trips',$avgTrips);	
					//find all thats editable and status < 3
					$edit = $this->Schedule->editScheduleParse($edit_array);
					
					$this->set('edit',$edit);

					$this->set('nis',$nis_array);
					$inventories = $this->Inventory->find('all');
					$this->set('inventories',$inventories);
					$inv_items = $this->Inventory_item->arrangeInventory($inventories);
					$this->set('inv_items',$inv_items);
					
					//get ferry data 
					$ferry_inv = $this->Ferry_inventory->getRatesById($this->Inventory_item->find('all'));
					$this->set('ferry_inv',$ferry_inv);
					
					//get ferry limits
					$ferry_limit = $this->Ferry_limit->getLimitById($this->Inventory->find('all'));
					$this->set('ferry_limit',$ferry_limit);
				
					//get minutes array
					$minutesArray = $this->Schedule->minutesArray();
					$this->set('minutesArray',$minutesArray);
					break;
				
				case 'Edit_Schedule_Incoming2':
					$start = $this->request->data['Date'];
					$dates = '';
					foreach ($start as $key => $value) {
						$startMonth = substr($start[$key],0,2);
						$startDay = substr($start[$key],3,2);
						$startYear = substr($start[$key],-4);
						$startDate = strtotime($startYear.'-'.$startMonth.'-'.$startDay.' 00:00:00');
						$dates = $dates.', '.$startDate;
					}
					$dates = substr($dates, 1);
					$datesArray = explode(',', $dates);

					sort($datesArray);

					$total_trips = count($datesArray);
					$dates = implode(',', $datesArray);


					//find all thats editable and status = 1
					$edit_array = array();
					$nis_array = array();
					$avg_trip_count = 0;
					foreach ($datesArray as $key => $value) {
						$newStart = date('Y-m-d',$datesArray[$key]).' 00:00:00';
						$newEnd = date('Y-m-d',$datesArray[$key]).' 23:59:59';	
						$find = $this->Schedule->query('select * from schedules 
														where status = "1"
														and check_date between "'.$newStart.'" and "'.$newEnd.'" 
														order by check_date asc');	
						if(count($find)>0){
							foreach ($find as $key=>$value) {
								$id = $find[$key]['schedules']['id'];
								$departs = $find[$key]['schedules']['departs'];
								$trip = $find[$key]['schedules']['trip'];
								$service = $find[$key]['schedules']['service_date'];
								$depart_time = $find[$key]['schedules']['depart_time'];
								$rates_id = $find[$key]['schedules']['rates_id'];
								$status = $find[$key]['schedules']['status'];
								
								$edit_array[$newStart][$key] = array(
									'id'=>$id,
									'departs'=>$departs,
									'trip'=>$trip,
									'date'=>$service,
									'time'=>$depart_time,
									'rates_id'=>$rates_id,
									'status'=>$status
								);
							}
							$avg_trip_count = $avg_trip_count + count($find);
						}
						$nis = $this->Schedule->query('select * from schedules 
														where status = "2"
														and check_date between "'.$newStart.'" and "'.$newEnd.'" 
														order by check_date asc');
			
						if(count($nis)>0){
							foreach ($nis as $key=>$value) {
								$id = $nis[$key]['schedules']['id'];
								$departs = $nis[$key]['schedules']['departs'];
								$trip = $nis[$key]['schedules']['trip'];
								$service = $nis[$key]['schedules']['service_date'];
								$depart_time = $nis[$key]['schedules']['depart_time'];
								$rates_id = $nis[$key]['schedules']['rates_id'];
								$status = $nis[$key]['schedules']['status'];
								
								$nis_array[$id] = array(
									'id'=>$id,
									'newStart'=>$newStart,
									'departs'=>$departs,
									'trip'=>$trip,
									'date'=>$service,
									'time'=>$depart_time,
									'rates_id'=>$rates_id,
									'status'=>$status
								);
							}
						}				
					}
					if($total_trips ==0){
						$avgTrips = 0;
					} else {
						$avgTrips = ceil(($avg_trip_count/$total_trips)/2);
					
					}
					$this->set('avg_trips',$avgTrips);	
					//find all thats editable and status < 3
					$edit = $this->Schedule->editScheduleParse($edit_array);
					$this->set('edit',$edit);

					$this->set('nis',$nis_array);
					$inventories = $this->Inventory->find('all');
					$this->set('inventories',$inventories);
					$inv_items = $this->Inventory_item->arrangeInventory($inventories);
					$this->set('inv_items',$inv_items);
					
					//get ferry data 
					$ferry_inv = $this->Ferry_inventory->getRatesById($this->Inventory_item->find('all'));
					$this->set('ferry_inv',$ferry_inv);
					
					//get ferry limits
					$ferry_limit = $this->Ferry_limit->getLimitById($this->Inventory->find('all'));
					$this->set('ferry_limit',$ferry_limit);
				
					//get minutes array
					$minutesArray = $this->Schedule->minutesArray();
					$this->set('minutesArray',$minutesArray);

					break;
				case 'Edit_Final':
					//save all edited data
					
					//save the changes to schedule table
					if(!empty($this->request->data['Schedule'])){
						foreach ($this->request->data['Schedule'] as $key => $value) {
							$this->Schedule->id = $key;
							//delete all from the schedule rate table under this schedule_id.
							$this->Schedule_rate->query('delete from schedule_rates where schedule_id ="'.$key.'"');
							//set the current time to fit timestamp
							$time = $this->request->data['Schedule'][$key]['depart_time'];
							$time_split = substr($time,0,-2);
							$time_code = strtoupper(substr($time,-2));
							$time_case = $time_split.' '.$time_code;

							$old_service_date = $this->request->data['Schedule'][$key]['service_date'];
							$old_service_date = $old_service_date.' '.$time_case;
							$this->request->data['Schedule'][$key]['service_date'] = date('Y-m-d H:i:s',strtotime($old_service_date));
							//debug($this->request->data['Schedule'][$key]);

							$this->Schedule->save($this->request->data['Schedule'][$key]);
							if(!empty($this->request->data['Schedule_rate'])){
								foreach ($this->request->data['Schedule_rate'] as $rkey => $rvalue) {
									$this->request->data['Schedule_rate'][$rkey]['schedule_id'] = $key;
									//$this->request->data['Schedule_rate'][$rkey]['inventory_id'] = $rkey;
									//delete any previous scheduled rates
									$this->Schedule_rate->query('delete from schedule_rates where schedule_id ="'.$key.'"');

								}


							$this->Schedule_rate->saveAll($this->request->data['Schedule_rate']);
							}

							
							if(!empty($this->request->data['Schedule_limit'])){
								foreach ($this->request->data['Schedule_limit'] as $pkey => $pvalue) {
									//$this->request->data['Schedule_limit'][$pkey]['schedule_id'] = $key;
									//$this->request->data['Schedule_limit'][$pkey]['inventory_id'] = $pkey;
									
									
									$this->Schedule_rate->query('update schedule_limits set reservableUnits ="'.$this->request->data['Schedule_limit'][$pkey]['reservableUnits'].'" where schedule_id ="'.$key.'" and inventory_id ="'.$pkey.'"');
									
									//delete any previous scheduled limits
									//$this->Schedule_rate->query('delete from schedule_limits where schedule_id ="'.$key.'"');
																		
								}
							//debug($this->request->data['Schedule_limit']);
							//$this->Schedule_limit->updateAll($this->request->data['Schedule_limit']);
							
							//$this->Schedule_rate->query('update schedule_limits set where schedule_id ="'.$key.'" AND inventory_id');
							
							
							}

						}

					}
					//first check to see where the edit is coming from, either edit page or view page
					if(!empty($this->request->data['View'])){ // this is the view page
						//delete any deleted ferry schedules
						if(!empty($this->request->data['Delete'])){
							foreach ($this->request->data['Delete'] as $key => $value) {
								$this->Schedule->id = $key;
								$this->Schedule->delete($this->request->data['Delete'][$key]);
								$this->Schedule_limit->query('delete from schedule_limits where schedule_id ='.$key.'');
								$this->Schedule_rate->query('delete from schedule_rates where schedule_id ='.$key.'');
							}
							$this->Session->setFlash(__('Successfully Deleted Trip'),'default',array(),'success');
							$this->redirect(array('action'=>'index'));	
						} else { //redirect back to the view page to show it was edited
							$this->Session->setFlash(__('Successfully Edited Ferry Schedule'),'default',array(),'success');
							$this->redirect(array('action'=>'view',$this->request->data['View']));							
						}
						
					} else {
						//delete any deleted ferry schedules
						if(!empty($this->request->data['Delete'])){
							foreach ($this->request->data['Delete'] as $key => $value) {
								$this->Schedule->id = $key;
								$this->Schedule->delete($this->request->data['Delete'][$key]);
								$this->Schedule_limit->query('delete from schedule_limits where schedule_id ='.$key.'');
								$this->Schedule_rate->query('delete from schedule_rates where schedule_id ='.$key.'');
							}
						}
						$this->Session->setFlash(__('Successfully Edited Ferry Schedule'),'default',array(),'success');
						$this->redirect(array('action'=>'index'));						
					}
				
					break;
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
		$this->Ferry->id = $id;
		if (!$this->Ferry->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		if ($this->Ferry->delete()) {
			//delete all from the menu_items table where id = id
			$this->Ferry_region->query('delete from ferry_regions where ferries_id = '.$id.'');
			$this->Session->setFlash(__('Ferry deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ferry was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	public function view($id =null)
	{
		//select menu
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/schedules/view';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
	
	
		//first find all of the schedule information for this id
		$find = $this->Schedule->read(null,$id);
		$this->set('schedules',$find); //set the schedule data to view page
		
		//next get all of the schedule limits from the db
		$capacity = $this->Schedule_limit->find('all',array('conditions'=>array('schedule_id'=>$id)));
		$capacity = $this->Ferry_limit->arrangeLimits($capacity); //arrange the limits so that its easy to render on the view page
		$this->set('limits',$capacity); //set the capacity array as limits on the view page
		$this->set('trip_id',$id); // set trip_id to the view page
		
		//get all the inventory data from the database
		$inventories = $this->Inventory->find('all');
		$this->set('inventories',$inventories); //set it to the page
		
		//get all of the inventory item data from the database
		$inv_items = $this->Inventory_item->arrangeInventoryIndividual($id,$this->Schedule_rate->find('all',array('conditions'=>array('schedule_id'=>$id))),$inventories);
		$this->set('inv_items',$inv_items); //set it to the view page
		
		//inventory item data to be arranged by id in the model then send to view page
		// $ferry_inv = $this->Inventory_item->getRatesByIdIndividual($this->Schedule_rate->find('all',array('conditions'=>array('schedule_id'=>$id))));
		// $this->set('ferry_inv',$ferry_inv);
		
		//get ferry limits
		$ferry_limit = $this->Ferry_limit->getLimitByIdIndividual($this->Schedule_limit->find('all',array('conditions'=>array('schedule_id'=>$id))));
		$this->set('ferry_limit',$ferry_limit);
	
		//get minutes array
		$minutesArray = $this->Schedule->minutesArray();
		$this->set('minutesArray',$minutesArray);
		
		$this->set('ferry_id',$id);
		
		
		//ferry_reservations
		
		//paginate the users and send to view
		$this->paginate = array(
			'conditions'=>array('OR'=>array('schedule_id1'=>$id,'schedule_id2'=>$id)),
		    'limit' => 20, // this was the option which you forgot to mention
		    'order' => array(
		        'last_name' => 'ASC')
		);	
		$reservations = $this->Ferry_reservation->fixLargeData($this->paginate('Ferry_reservation'));	
		$this->Ferry_reservation->recursive = 0;	
		
		$this->set('reservations',$reservations);
		//start form processing
		if($this->request->is('post')){
		}
	}
	public function preview()
	{
			if(empty($_POST)){
				$this->Session->setFlash('Your schedule data was not set. Please fill out schedule form.');
				$this->redirect(array('action'=>'add'));
			}
		//select menu
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/schedules/add';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);		
		
		$inventories = $this->Inventory->find('all');
		$switchInventory = $this->Inventory->switchInventory($inventories);
		$this->set('inventories',$inventories);
		$this->set('switchInv',$switchInventory);
		
		$inv_items = $this->Inventory_item->arrangeInventory($inventories);
		$this->set('inv_items',$inv_items);
		
		//get ferry data 
		$ferry_inv = $this->Ferry_inventory->getRatesById($this->Inventory_item->find('all'));
		$this->set('ferry_inv',$ferry_inv);
		
		//get ferry limits
		$ferry_limit = $this->Ferry_limit->getLimitById($this->Inventory->find('all'));
		$this->set('ferry_limit',$ferry_limit);
		
		if($this->request->is('post')){

		}

	}
/**
 * Request ajax action
 * 
 * 
 * @return void
 */
  	public function print_vmanifest($id =null)
	{
		$this->layout = 'print';
		
		// $ferry = $this->Ferry_reservation->find('all',
			// array('conditions'=>array('OR'=>array('schedule_id1'=>$id, 'schedule_id2'=>$id))),
	    	// 'order',array('last_name'=>'asc')
		// );
		
		$ferry = $this->Ferry_reservation->find('all',array(
	    	'conditions'=>array('vehicle_count >'=>'0',
	    	'OR'=>array('schedule_id1'=>$id, 'schedule_id2'=>$id))),
	    	'order',array('last_name'=>'asc')
		);
		$schedule = $this->Schedule->find('all',array('conditions'=>array('id'=>$id)));
		
		foreach ($ferry as $fkey => $fvalue){
			$reservation_id = $ferry[$fkey]['Ferry_reservation']['reservation_id'];
			$ferry[$fkey]['Ferry_reservation']['contents'] = "";
			$master = $this->Reservation->find('all',array('conditions'=>array('id'=>$reservation_id)));
			
			$ferry[$fkey]['Ferry_reservation']['first_name'] = ucfirst($ferry[$fkey]['Ferry_reservation']['first_name']);
			$ferry[$fkey]['Ferry_reservation']['last_name'] = ucfirst($ferry[$fkey]['Ferry_reservation']['last_name']);
			
			if ($master[0]['Reservation']['hotel_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "H ";} 
			if ($master[0]['Reservation']['attraction_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "A ";} 
			if ($master[0]['Reservation']['package_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "P";} 
		}
				
usort($ferry, function ($elem1, $elem2) {
     return strcmp($elem1['Ferry_reservation']['last_name'], $elem2['Ferry_reservation']['last_name']);
});
				
		$this->set('ferry',$ferry);
		$this->set('schedule',$schedule);

	}
	
  	public function print_pmanifest($id =null)
	{		
		$this->layout = 'print';	
		
		$ferry = $this->Ferry_reservation->find('all',array('conditions'=>array('OR'=>array('schedule_id1'=>$id, 'schedule_id2'=>$id))),
	    	'order',array('Ferry_reservation.last_name'=>'DESC')
		);
		$schedule = $this->Schedule->find('all',array('conditions'=>array('id'=>$id)));
		
		foreach ($ferry as $fkey => $fvalue){
			$reservation_id = $ferry[$fkey]['Ferry_reservation']['reservation_id'];
			$ferry[$fkey]['Ferry_reservation']['contents'] = "";
			$master = $this->Reservation->find('all',array('conditions'=>array('id'=>$reservation_id)));
			
			$ferry[$fkey]['Ferry_reservation']['first_name'] = ucfirst($ferry[$fkey]['Ferry_reservation']['first_name']);
			$ferry[$fkey]['Ferry_reservation']['last_name'] = ucfirst($ferry[$fkey]['Ferry_reservation']['last_name']);
			
			if ($master[0]['Reservation']['hotel_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "H ";} 
			if ($master[0]['Reservation']['attraction_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "A ";} 
			if ($master[0]['Reservation']['package_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "P";} 
			
			if ($ferry[$fkey]['Ferry_reservation']['schedule_id1'] == $id) { $ferry[$fkey]['Ferry_reservation']['leg'] = "Departing"; }
			elseif ($ferry[$fkey]['Ferry_reservation']['schedule_id2'] == $id) { $ferry[$fkey]['Ferry_reservation']['leg'] = "Returning"; }
			else { $ferry[$fkey]['Ferry_reservation']['leg'] = "Error"; }
		}
		
usort($ferry, function ($elem1, $elem2) {
     return strcmp($elem1['Ferry_reservation']['last_name'], $elem2['Ferry_reservation']['last_name']);
});
		
		$this->set('ferry',$ferry);
		$this->set('schedule',$schedule);
		
	}
	
  	public function print_hap_report($id =null)
	{		
		$this->layout = 'print';	
		
		$ferry = $this->Ferry_reservation->find('all',array('conditions'=>array('OR'=>array('schedule_id1'=>$id, 'schedule_id2'=>$id))));
		$schedule = $this->Schedule->find('all',array('conditions'=>array('id'=>$id)));
		
		foreach ($ferry as $fkey => $fvalue){
			$reservation_id = $ferry[$fkey]['Ferry_reservation']['reservation_id'];
			$ferry[$fkey]['Ferry_reservation']['contents'] = "";
			$master = $this->Reservation->find('all',array('conditions'=>array('id'=>$reservation_id)));
			if ($master[0]['Reservation']['hotel_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "H ";} 
			if ($master[0]['Reservation']['attraction_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "A ";} 
			if ($master[0]['Reservation']['package_total'] > 0) { $ferry[$fkey]['Ferry_reservation']['contents'] .= "P";} 
		}
		
		$this->set('ferry',$ferry);
		$this->set('schedule',$schedule);
		
	}
	
 
 	public function download_customs($id =null)
	{
		//create a new array
		$reservations = array();
		
		//search for all schedule_ids with the id from the url parameter order by last name asc
	    $ferry = $this->Ferry_reservation->find('all',array(
	    	'conditions'=>array('vehicle_count >'=>'0',
	    	'OR'=>array('schedule_id1'=>$id, 'schedule_id2'=>$id))),
	    	'order',array('last_name'=>'asc')
		);
		
		$idx = -1; //create an index to start from 0
		
		if(count($ferry)>0){
			foreach ($ferry as $fdKey =>$fdValue) {
				//get reservation id and calculate total passengers
				
				if ($ferry[$fdKey]['Ferry_reservation']['inventory_id'] == "1" || $ferry[$fdKey]['Ferry_reservation']['inventory_id'] == "4") {continue;}
				
				$reservation_id = $ferry[$fdKey]['Ferry_reservation']['reservation_id'];
				
				$drivers = $ferry[$fdKey]['Ferry_reservation']['drivers'];
				$adults = $ferry[$fdKey]['Ferry_reservation']['adults'];
				$children = $ferry[$fdKey]['Ferry_reservation']['children'];
				$infants = $ferry[$fdKey]['Ferry_reservation']['infants'];
				$total_passengers = $drivers + $adults + $children + $infants;
				//search theh reservation id table for travelers information
				$search = $this->Reservation->find('all',array('conditions'=>array('id'=>$reservation_id)));
				if(count($search)>0){		
					foreach ($search as $s) {
						
						if ($ferry[$fdKey]['Ferry_reservation']['schedule_id1'] == $id ) {
							if ($ferry[$fdKey]['Ferry_reservation']['status_depart'] != "1") {continue;}
						} elseif ($ferry[$fdKey]['Ferry_reservation']['schedule_id2'] == $id) {
							if ($ferry[$fdKey]['Ferry_reservation']['status_return'] != "1") {continue;}
						}
						
						$idx++; //increase index by 1 if search is successful
						//finish array by getting the data we need to render 
						$reservations[$idx]['Reservation'] = array(
							'Confirmation'=>$s['Reservation']['confirmation'],
							'Last Name'=>$s['Reservation']['last_name'],
							'First Name'=>$s['Reservation']['first_name'],
							'Middle Initial'=>$s['Reservation']['middle_initial'],
							'Citizenship'=>$s['Reservation']['citizenship'],
							'Birthdate'=>date('Y-m-d',strtotime($s['Reservation']['birthdate'])),
							'Document'=>$s['Reservation']['doctype'],
							'Document Number'=>$s['Reservation']['docnumber'],
							'Total Passengers'=>$total_passengers
							
						);
					}
				} else {
							$idx++; //increase index by 1 if search is successful
							//finish array by getting the data we need to render 
							$reservations[$idx]['Reservation'] = array(
								'Confirmation'=>$ferry[$fdKey]['Ferry_reservation']['confirmation'],
								'Last Name'=>$ferry[$fdKey]['Ferry_reservation']['last_name'],
								'First Name'=>$ferry[$fdKey]['Ferry_reservation']['first_name'],
								'Middle Initial'=>$ferry[$fdKey]['Ferry_reservation']['middle_initial'],
								'Citizenship'=>'',
								'Birthdate'=>'',
								'Document'=>'',
								'Document Number'=>'',
								'Total Passengers'=>$total_passengers
								
							);						
					}
			}
		}
		
		//render array to view page
	    $this->set('reservations',$reservations);
		$this->set('id',$id);
		
		//get port departure data
		$destinations = $this->Schedule->find('all',array('conditions'=>array('id'=>$id)));
		$filename = 'Error';
		if(count($destinations)>0){
			foreach ($destinations as $d) {
				$departure = $d['Schedule']['departs'];
				switch ($departure) {
					case 'Port Angeles':
						$destination = 'PA';
						break;
					
					default:
						$destination = 'VIC';
						break;
				}

				$date = date('dmy',strtotime($d['Schedule']['check_date']));
				$time = date('gi',strtotime($d['Schedule']['service_date']));
				
				$filename = $destination.'-'.$date.'-'.$time;

			}
		} 
		$this->set('filename',$filename);
		//$this->set('send',$send);
		
	    $this->layout = null;
	   	$this->autoLayout = false;
	  	//Configure::write('debug', '2');
	}

/**
 * Creates a one-time email list based on a sailing’s customers.
 */
	public function download_emails()
	{
		//get data from db and create an array for csv display. 
		$emails = array(); //create first array
		
		
		$this->set('emails',$emails); //send data to view
	}

 	public function send_customs()
	{
		
		App::import('Helper','csv');

		
		//debug ($csv);
		//exit();
		//$this->Auth->allow('*');
			
		//if ($send != 'Z9C4IV') {exit();} //basic key to start the script
		
		
		$today_start = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") + 2, date("Y"))).' 00:00:00';
		$today_end = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") + 2, date("Y"))).' 23:59:59';
		
		//$upcoming_reservation = $this->Reservation->find('all',array('conditions'=>array('Reservation.created BETWEEN ? AND ?'=>array($today_start, $today_end))));

		$upcoming_schedule = $this->Schedule->find('all',array('conditions'=>array('Schedule.service_date BETWEEN ? AND ?'=>array($today_start, $today_end))));

		//debug($upcoming_schedule);
		//exit();
		
		//search for all schedule_ids with the id from the url parameter order by last name asc
		foreach ($upcoming_schedule as $schedule) {

			//create a new array
			$reservations = array();
			
			$csv = new csvHelper();

		    $ferry = $this->Ferry_reservation->find('all',array(
		    	'conditions'=>array('vehicle_count >'=>'0',
		    	'OR'=>array('schedule_id1'=>$schedule['Schedule']['id'], 'schedule_id2'=>$schedule['Schedule']['id']))),
		    	'order',array('last_name'=>'asc')
			);
			
			$idx = -1; //create an index to start from 0
			
			if(count($ferry)>0){
				foreach ($ferry as $fdKey =>$fdValue) {
					
					if ($ferry[$fdKey]['Ferry_reservation']['inventory_id'] == "1" || $ferry[$fdKey]['Ferry_reservation']['inventory_id'] == "4") {continue;}
					
					
					//get reservation id and calculate total passengers
					$reservation_id = $ferry[$fdKey]['Ferry_reservation']['reservation_id'];
					
					$drivers = $ferry[$fdKey]['Ferry_reservation']['drivers'];
					$adults = $ferry[$fdKey]['Ferry_reservation']['adults'];
					$children = $ferry[$fdKey]['Ferry_reservation']['children'];
					$infants = $ferry[$fdKey]['Ferry_reservation']['infants'];
					$total_passengers = $drivers + $adults + $children + $infants;
					//search theh reservation id table for travelers information
					$search = $this->Reservation->find('all',array('conditions'=>array('id'=>$reservation_id)));
					if(count($search)>0){		
						foreach ($search as $s) {
							
							if ($ferry[$fdKey]['Ferry_reservation']['schedule_id1'] == $schedule['Schedule']['id']) {
								if ($ferry[$fdKey]['Ferry_reservation']['status_depart'] != "1") {continue;}
							} elseif ($ferry[$fdKey]['Ferry_reservation']['schedule_id2'] == $schedule['Schedule']['id']) {
								if ($ferry[$fdKey]['Ferry_reservation']['status_return'] != "1") {continue;}
							}
							
							$idx++; //increase index by 1 if search is successful
							//finish array by getting the data we need to render 
							$reservations[$idx]['Reservation'] = array(
								'Confirmation'=>$s['Reservation']['confirmation'],
								'Last Name'=>$s['Reservation']['last_name'],
								'First Name'=>$s['Reservation']['first_name'],
								'Middle Initial'=>$s['Reservation']['middle_initial'],
								'Citizenship'=>$s['Reservation']['citizenship'],
								'Birthdate'=>date('Y-m-d',strtotime($s['Reservation']['birthdate'])),
								'Document'=>$s['Reservation']['doctype'],
								'Document Number'=>$s['Reservation']['docnumber'],
								'Total Passengers'=>$total_passengers
								
							);
						}
					}else {
							$idx++; //increase index by 1 if search is successful
							//finish array by getting the data we need to render 
							$reservations[$idx]['Reservation'] = array(
								'Confirmation'=>$ferry[$fdKey]['Ferry_reservation']['confirmation'],
								'Last Name'=>$ferry[$fdKey]['Ferry_reservation']['last_name'],
								'First Name'=>$ferry[$fdKey]['Ferry_reservation']['first_name'],
								'Middle Initial'=>$ferry[$fdKey]['Ferry_reservation']['middle_initial'],
								'Citizenship'=>'',
								'Birthdate'=>'',
								'Document'=>'',
								'Document Number'=>'',
								'Total Passengers'=>$total_passengers
								
							);						
					}
				}
			}
			
			//render array to view page
		    //$this->set('reservations',$reservations);
			//$this->set('id',$id);
			
			//get port departure data
			//$destinations = $this->Schedule->find('all',array('conditions'=>array('id'=>$schedule['Schedule']['id'])));
			$filename = 'Error';
			//if(count($destinations)>0){
				//foreach ($destinations as $d) {
					$departure = $schedule['Schedule']['departs'];
					switch ($departure) {
						case 'Port Angeles':
							$destination = 'PA';
							break;
						
						default:
							$destination = 'VIC';
							break;
					}
	
					$date = date('dmy',strtotime($schedule['Schedule']['check_date']));
					$time = date('gi',strtotime($schedule['Schedule']['service_date']));
					
					$filename = $destination.'-'.$date.'-'.$time;
	
				//}
			//} 
			//$this->set('filename',$filename);
			//$this->set('send',$send);
			
		    //$this->layout = null;
		   	//$this->autoLayout = false;
		  	//Configure::write('debug', '2');
 
 debug($filename);
			
 debug($reservations);
 
 $line= $reservations[0]['Reservation'];
 
 //debug(array_keys($line));
 
 //exit();
 
 $csv->addRow(array_keys($line));
 foreach ($reservations as $reservation)
 {
      $line = $reservation['Reservation'];
       $csv->addRow($line);
 }


$fullfilename = '/tmp/'.$filename.'.csv';

$csv->save($fullfilename);
  
	//if ($destination == 'PA') {$sendTo = array('john@brevica.com');} elseif ($destination == 'VIC') {$sendTo = array('john@treenumbertwo.com');} else {$sendTo = array('john@givingfire.com');}
	if ($destination == 'VIC') {$sendTo = array('victoriapau@cbp.dhs.gov');} elseif ($destination == 'PA') {$sendTo = array('pac-dist_victoria_superintendents@cbsa-asfc.gc.ca');} else {$sendTo = array('john@brevica.com');}

		$subject = 'BBFL manifest: '.$filename;
		
		$Email = new CakeEmail('gmail');
					
		//primary email settings
		
		$Email->template('customs')
		   	->emailFormat('text')
		    ->to($sendTo)
			->bcc(array('bbtpackage@seanet.com','john@treenumbertwo.com'))
			->attachments(array( ($filename.'.csv') => $fullfilename ))
			->subject($subject);
		
		//backup email settings
		$Backup = new CakeEmail('default');
		//$singlehotelstring = $this->Reservation->createHotelEmailString($hotel_session);
		$Backup->template('customs')
		    ->emailFormat('text')
		    ->to($sendTo)
			->bcc(array('bbtpackage@seanet.com','john@treenumbertwo.com'))
			->attachments(array( ($filename.'.csv') => $fullfilename ))
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
	
	// $Email->template('customs')
	    // ->emailFormat('text')
		// //->viewVars(compact('confirmation_id','full_name','ferry_string','hotel_string','attraction_string','package_string','total_string'))
	    // ->to($sendTo)
	    // //->from($from)
		// ->subject($subject)
		// ->bcc(array('bbtpackage@seanet.com','john@treenumbertwo.com'))
		// ->attachments(array( ($filename.'.csv') => $fullfilename ))
	    // ->send();	


		unlink ($fullfilename);
		
		}

		exit();

	}
 
 	public function request_edit_check()
	{
		if($this->request->is('ajax')){
			//set the incoming variables 
			$port = $this->data['port'];
			$date = date('Y-m-d',$this->data['date']). ' 00:00:00';
			$time = $this->data['time'];
			$inventory = $this->data['inventory'];
			$old_passengers = $this->data['old_passengers'];
			$new_passengers = $this->data['new_passengers'];
			$reservation_id = $this->data['reservation_id'];
			$old_schedule_id = $this->data['schedule_id'];
			
			//get schedule_id

			$schedules = $this->Schedule->find('all',array('conditions'=>array('departs'=>$port,'check_date'=>$date,'depart_time'=>$time)));

			if(count($schedules)>0){
				foreach ($schedules as $s) {
					$schedule_id = $s['Schedule']['id'];
				}
			} else {
				$schedule_id = '';
			}

			//check schedule_id with inventory_id for both vehicles and total passengers
			$schedule_passengers = $this->Schedule_limit->find('all',array('conditions'=>array('schedule_id'=>$schedule_id,'inventory_id'=>'1')));

			//set overlength feet and total units
			$new_overlength_feet = 0;
			$new_units = 0;
			
			//get old units
			$find_old_units = $this->Ferry_reservation->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
			$old_units = 0;
			if(count($find_old_units) > 0){
				foreach ($find_old_units as $fou) {
					$old_vehicles = json_decode($fou['Ferry_reservation']['vehicles'],2);
				}
				if(!empty($old_vehicles)){
					foreach ($old_vehicles as $ovkey => $ovvalue) {
						$old_item_id = $old_vehicles[$ovkey]['item_id'];
						$old_overlength = $old_vehicles[$ovkey]['overlength'];
						if($old_overlength > 0){
							$old_units = $old_units + sprintf('%.2f',round(($old_overlength / 18),2));
						} else {
							$old_units = $old_units + 1;
						}
					}
				} else {
					$old_units = 0;
				}
			} else {
				$old_units = 0;
			}
			
			//get new units
			if($inventory != 'Passenger'){
				foreach ($inventory as $key => $value) {
					$inventory_id = $inventory[$key]['inventory_id'];
					$item_id = $inventory[$key]['item_id'];
					$overlength = $inventory[$key]['overlength'];
					$overlength_feet = $inventory[$key]['overlength_feet'];
					switch ($overlength) {
						case 'Yes':
							$new_units = $new_units + ($overlength_feet / 18);		
							$new_overlength_feet = $new_overlength_feet + $overlength_feet;
							break;
						
						default:
							$new_units = $new_units + 1;
							break;
					}
					
				}
				$schedule_vehicles = $this->Schedule_limit->find('all',array('conditions'=>array('schedule_id'=>$schedule_id,'inventory_id'=>$inventory_id)));	

			
				$status_passengers = $this->Schedule_limit->getStatusPassengers($schedule_passengers, $old_passengers, $new_passengers, $old_schedule_id, $schedule_id); 
				$status_vehicles = $this->Schedule_limit->getStatusVehicles($schedule_vehicles,$old_units, $new_units, $new_overlength_feet, $old_schedule_id, $schedule_id);
			} else {

				$status_passengers = $this->Schedule_limit->getStatusPassengers($schedule_passengers, $old_passengers, $new_passengers, $old_schedule_id, $schedule_id); 
				$status_vehicles = '1';
			}

			/**
			 * Calculate status
			 * 1. inventory and passengers ok
			 * 2. inventory ok passengers over
			 * 3. inventory over passengers ok
			 * 4. inventory over passengers over
			 */

			
			if($status_passengers ==1 && $status_vehicles == 1){
				$status = 1;
			} else if($status_passengers > 1 && $status_vehicles ==1){
				$status = 2;
			} else if($status_passengers ==1 && $status_vehicles >1){
				$status = 3;
			} else {
				$status = 4;
			}

			//return status

			$this->set('status',$status);
		}	 
	}
 
	public function request()
	{
		if($this->request->is('ajax')){
			$type = $this->data['type'];
			switch ($type) {
				case 'Create_Form':
					$start = $this->data['start_date'];
					$end = $this->data['end_date'];
					$startMonth = substr($start,0,2);
					$startDay = substr($start,3,2);
					$startYear = substr($start,-4);
					$endMonth = substr($end,0,2);
					$endDay = substr($end,3,2);
					$endYear = substr($end,-4);
					$startDate = date('Y-m-d H:i:s',strtotime($startYear.'-'.$startMonth.'-'.$startDay.' 00:00:00'));
					$endDate = date('Y-m-d H:i:s',strtotime($endYear.'-'.$endMonth.'-'.$endDay.' 23:59:59'));						
					
					//check the dates if there are any pre existing dates
					$exists = $this->Schedule->query("select * from schedules where
													  service_date between '".$startDate."' and '".$endDate."'
													  and status < 3");						  
					
					$exists_count = count($exists);
					
					if($exists_count >0){
						$this->set('prexists_error','prexists');
						$this->set("exists",$exists);
					} else{
						$this->set('prexists_error',$exists);
						$this->set("exists",$exists);
					}		
					//get minutes array
					$minutesArray = $this->Schedule->minutesArray();
					$this->set('minutesArray',$minutesArray);	
					break;
				case 'Check_Time':
					$start = $this->data['start_date'];
					$end = $this->data['end_date'];
					$time = $this->data['time'];
					
					
					//check the dates if there are any pre existing dates
					$exists = $this->Schedule->query("select * from schedules where
													  service_date between '".$start."' and '".$end."'
													  and status < 3
													  and depart_time ='".$time."'");						  
					
					$exists_count = count($exists);
					
					if($exists_count >0){
						$this->set('prexists_error','Yes');

					} else{
						$this->set('prexists_error','No');
					}		
					//get minutes array
					$minutesArray = $this->Schedule->minutesArray();
					$this->set('minutesArray',$minutesArray);					
					
					break;	
				case 'Schedule_Time':
					
					//sends time, date, departs, and trip number to schedule table in the db
					$this->request->data['Schedule']['trip'] = $this->data['trip'];
					$this->request->data['Schedule']['departs'] = $this->data['depart'];
					$this->request->data['Schedule']['service_date'] = $this->data['date'];
					$this->request->data['Schedule']['time'] = $this->data['time'];
					
					$this->Schedule->save($this->data);
					$this->set('schedule_id',$this->Schedule->id);
					break;
				case 'Schedule_Limits':
					
					break;
				
				case 'NEW_SCHEDULE':
					$params = array();
					parse_str($this->data['form_data'],$params);
					
					// $this->Schedule->saveAll($params['data']['Schedule']);
					// $this->Schedule_limit->saveAll($params['data']['Schedule_limit']);
					if(isset($params['data']['type']) && $params['data']['type'] == 'NIS'){ //if this is a NIS request
						$start = $params['data']['startDate'];
						$end = $params['data']['endDate'];
						$startMonth = substr($start,0,2);
						$startDay = substr($start,3,2);
						$startYear = substr($start,-4);
						$endMonth = substr($end,0,2);
						$endDay = substr($end,3,2);
						$endYear = substr($end,-4);
						$startDate = strtotime($startYear.'-'.$startMonth.'-'.$startDay.' 00:00:00');
						$endDate = strtotime($endYear.'-'.$endMonth.'-'.$endDay.' 00:00:00');
						$total_days = ($endDate-$startDate)/86400;
						for ($i=0; $i <= $total_days; $i++) {
							$params['Schedule'][$i]['nis_description'] =$params['data']['nis'];
							$params['Schedule'][$i]['status'] = '2';
							$params['Schedule'][$i]['service_date']= date('Y-m-d',($startDate+($i*86400))).' 00:00:00'; 
							$params['Schedule'][$i]['check_date'] = date('Y-m-d',($startDate+($i*86400))).' 00:00:00'; 
							$service_date = $params['Schedule'][$i]['service_date'];
		
							$change = $this->Schedule->find('all',array('conditions'=>array('check_date'=>$service_date,'status'=>1)));
							if(count($change)>0){
								foreach ($change as $ckey => $cvalue) {
									$change_id = $change[$ckey]['Schedule']['id'];
									$this->Schedule->id = $change_id;
									
									$data = array('id'=>$change_id,'status'=>3);
		
									$this->Schedule->save($data);
								}
							}
						}
		
						$this->Schedule->saveAll($params['Schedule']);

					} else { //save as a regular 
						//rates_id set
						$schedules = $params['data']['Schedule'];
						foreach ($schedules as $key => $value) {
							$rates = $schedules[$key];
							
							foreach ($schedules[$key] as $rkey => $rvalue) {
								$rates_id = $schedules[$key][$rkey]['rates_id'];
								
							}
						}
		
					 	$this->Schedule->saveAll($params['data']['Schedule']);
			
						$schedule_ids =$this->Schedule->inserted_ids;
						//finish the arrays with the new schedule _id
						$countSaved = count($schedule_ids);
						$save_rates_array = array();
						$save_limit_array = array();
						if(!empty($params['data']['Schedule_limit'])){
							for ($i=0; $i < $countSaved; $i++) { 
								$save_limit_array['Schedule_limit'][$i] = $params['data']['Schedule_limit'];
								if($rates_id=='2'){
									$save_rates_array['Schedule_rate'][$i] = $params['data']['Schedule_rate'];		
								}
								
							}
						}
						
						//add in the schedule_id to the arrays
						foreach ($schedule_ids as $key=>$value) {
							$schedule_id[$key] = $value;	
							if(!empty($save_limit_array)){
								//limit array
								foreach ($save_limit_array['Schedule_limit'][$key] as $limit_key => $limit_value) {
									$save_limit_array['Schedule_limit'][$key][$limit_key]['schedule_id'] = $schedule_id[$key];
								}
							}
							if(!empty($save_rates_array)){
								if($rates_id =='2'){
									//rates array
									foreach ($save_rates_array['Schedule_rate'][$key] as $rate_key => $rate_value) {
										$save_rates_array['Schedule_rate'][$key][$rate_key]['schedule_id'] = $schedule_id[$key];
									}
								}
							}
						}
						//save the limit array
						if(!empty($save_limit_array)){
							foreach ($save_limit_array['Schedule_limit'] as $key => $value) {
		
								$this->Schedule_limit->saveAll($save_limit_array['Schedule_limit'][$key],array('deep'=>true,'validate'=>true));
							}
						}
						if(!empty($save_rates_array)){
							if($rates_id=='2'){
								foreach ($save_rates_array['Schedule_rate'] as $key => $value) {
		
									$this->Schedule_rate->saveAll($save_rates_array['Schedule_rate'][$key],array('deep'=>true,'validate'=>true));
								}			
							}
						}	
					}					
					$this->set('result','success');			
					break;	
				
				default:
					
					break;
			}
		}
	}
/**
 * Json Feed from controller
 * 
 */
	public function getJson()
	{
		//schedule listed here
		if($this->request->is('ajax')){
			$inventory_id = $this->request->data['inventory_id'];
			$start = $this->request->data['start'];
			$end = $this->request->data['end'];	
			$startDate = date('Y-m-d',$start).' 00:00:00';
			$endDate = date('Y-m-d',$end).' 23:59:59';
			//find all the not in service 
			$nis = $this->Schedule->query('select * from schedules 
											where service_date between "'.$startDate.'" and "'.$endDate.'"
											and status = "2"
											order by service_date asc');


			//find all regular service
			$schedules = $this->Schedule->query('select * from schedules 
												where service_date between "'.$startDate.'" and "'.$endDate.'"
												and status = "1"
												order by service_date asc');


			//$schedules = $this->Schedule->find('all',array('order'=>'service_date asc'));
			$calendar = $this->Schedule->calendarize($schedules,$nis, $startDate, $endDate, $inventory_id);
			
			return new CakeResponse(array('body' => json_encode($calendar)));			
			
			
		}


	}

}


?>