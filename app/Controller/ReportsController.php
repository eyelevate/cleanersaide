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
		'Hotel','Hotel_room','Reservation','Package','Package_reservation','PackageAddOn','Attraction',
		'Attraction_ticket','User','Menu','Menu_item','Ferry', 'Ferry_reservation', 'Page','Location',
		'Exchange','Tax','Exchange_pricing','Schedule','Schedule_limit','Schedule_rate',
		'Hotel_reservation', 'Attraction_reservation', 'Inventory','Inventory_item','Incremental_unit','Report'
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
	

/**
 * Reports Controller
 * - public page viewable by all
 * @return void
 */
 
 	public function daily_accounting($date =NULL)
	{
	    $this->set('reservations', $this->Reservation->find('all'));
	    $this->layout = null;
	   	$this->autoLayout = false;
	  	Configure::write('debug', '2');
	}
 
	public function download()
	{
	    $this->set('reservations', $this->Reservation->find('all'));
	    $this->layout = null;
	   	$this->autoLayout = false;
	  	Configure::write('debug', '0');
	}
 
	public function vouchers()
	{
		//setup the layout on the page
		$this->layout = 'admin';
		//set the admin navigation
		$page_url = '/reports/vouchers';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check); 
		
		
	}
	
	public function request_voucher_list()
	{
		
		if ($this->request->is('ajax')){
			$start = date('Y-m-d',strtotime($this->data['start'])).' 00:00:00';	
			$end = date('Y-m-d',strtotime($this->data['end'])).' 23:59:59';
	

			//first search through the ferry reservations
			$reservations = $this->Reservation->find('all',array('conditions'=>array('created between ? and ?'=>array($start, $end))));

			//get ferry reservations
			$vouchers = $this->Report->searchVouchers($reservations);
			
			
			//count hotels
			// $hotel_count = 0;
			// $attraction_count = 0;
			// foreach ($vouchers as $key => $value) {
				// foreach ($vouchers[$key]['hotel'] as $ht) {
					// $hotel_count++;
				// }
				// foreach ($vouchers[$key]['attraction'] as $at) {
					// $attraction_count++;
				// }
			// }
			//count attraction
			$this->set('vouchers',$vouchers);
			//$this->set('hotel_count',$hotel_count);
			//$this->set('attraction_count',$attraction_count);
		}
		
	}
	
	public function request_voucher_pdf($reservation = null)
	{
	
	    $this->layout = null;
	   	$this->autoLayout = false;

		App::import('Vendor', 'barcode');
		App::import('Vendor', 'createfdf');
		App::import('Vendor', 'fpdf');
		App::import('Vendor', 'fpdi');
			
		$this->Reservation->query('update reservations set printed = TRUE where id ="'.$reservation.'"');

			
			//debug($reservation);

			$actual_reservation = $this->Reservation->find('all',array('conditions'=>array('id'=>$reservation)));
			$hotel_reservations = $this->Hotel_reservation->find('all',array('conditions'=>array('reservation_id'=>$reservation)));
			$attraction_reservations = $this->Attraction_reservation->find('all',array('conditions'=>array('reservation_id'=>$reservation)));
			$ferry_reservations = $this->Ferry_reservation->find('all',array('conditions'=>array('reservation_id'=>$reservation)));
			$package_reservations = $this->Package_reservation->find('all',array('conditions'=>array('reservation_id'=>$reservation)));
			
			//set the defaults first
			$rand_id = $reservation;
			$fdf_file=$rand_id.'.fdf';
			$fdf_dir='/home/bbfl/public/cohoferry.com/public/app/webroot/vouchers/results/'.$rand_id;
			
			mkdir($fdf_dir);
			$pagecount = 0;
			
			//Add-ons first			
			foreach ($package_reservations as $pr) {
				
				//Get the details of this particular package
				$package_detail = $this->Package->find('all',array('conditions'=>array('id'=>$pr['Package_reservation']['package_id'])));
				
				//continue if there's a valid add-on for this package
				if ($package_detail[0]['Package']['add_ons']) {
					
					//if so, let's nab this package's add-on detail(s)
					$addon_reservation = json_decode($package_detail[0]['Package']['add_ons'], TRUE);
					//and then create vouchers for each add-on in this package
					foreach ($addon_reservation as $ar) {
						//grab the marketing specifics for this add-on
						$addon_detail = $this->PackageAddOn->find('all',array('conditions'=>array('id'=>$ar['id'])));
						$vouchers = json_decode($addon_detail[0]['PackageAddOn']['vouchers'], true);
						
						//now let's create all of the vouchers for this add-on
						foreach($vouchers as $v){
						    $name = $v['name'];
						    $description = $v['description'];
							
							//finally, vouchers can have multiple printings, which is determined by type (person or night)
							if ($addon_detail[0]['PackageAddOn']['type'] == 'person'){								
								for ($i=1; $i <= $pr['Package_reservation']['adults'] + $pr['Package_reservation']['children']; $i++) {
									//echo $i;
									
									$pagecount++;
									$person_count = $pr['Package_reservation']['adults'] + $pr['Package_reservation']['children'];
									
									$pdf_doc='/home/bbfl/public/cohoferry.com/public/app/webroot/vouchers/addon-template.pdf';
									
									$pdf_data = array(
										'addon-name' => strtoupper($v['name']), 
										'bbfl-confirmation' => 'BBFL CONFIRMATION '. $actual_reservation[0]['Reservation']['confirmation'],  
										'vcount' => 'VOUCHER '. $i. ' OF '. $person_count,  
										'description' => $v['description'], 
										'package' => strtoupper($package_detail[0]['Package']['name'])
									);
									
									$fdf_data=createFDF($pdf_doc, $pdf_data);
					
									//Create the FDF file - should probably save both just to be safe.
						            if($fp=fopen($fdf_dir.'/'.$fdf_file,'w')){
						                fwrite($fp,$fdf_data,strlen($fdf_data));
						                //echo $fdf_file,' written successfully.';
						            }else{
						            	//debug ($fp);
						                die('Unable to create file: '.$fdf_dir.'/'.$fdf_file);
						            }
						            fclose($fp);
									
									//Merge the FDF and the PDF file, and then flatten them so they can't be edited
									passthru("pdftk ".$pdf_doc." fill_form ".$fdf_dir.'/'.$rand_id.".fdf output ".$fdf_dir.'/'.$rand_id.".pdf flatten", $returnval);
									//echo $returnval;
									
									// set hotel barcode
									$bc = new Barcode39($actual_reservation[0]['Reservation']['confirmation']); 
									$bc->draw($fdf_dir.'/'.$rand_id.".gif");
				
									$pdf = new FPDI();
									
									$pdf->AddPage();
									$pdf->setSourceFile($fdf_dir.'/'.$rand_id.".pdf");
									$importedpage = $pdf->importPage(1);
									$pdf->useTemplate($importedpage, 0, 0, 0, 0, true);
									
									$pdf->Image($fdf_dir.'/'.$rand_id.".gif",17,113);
									$pdf->Output($fdf_dir.'/'.$rand_id.'-page-'.$pagecount.'.pdf', 'F');
									
									unlink($fdf_dir.'/'.$rand_id.".pdf");
									unlink($fdf_dir.'/'.$rand_id.".fdf");
									unlink($fdf_dir.'/'.$rand_id.".gif");
								}
							}
							
						}
												
					}
					//var_dump($addon_detail);	
				}
				//exit();				
			}			
			
			
			$voucher_reservations = array_merge($hotel_reservations, $attraction_reservations);
			

			//--------------------------------------------------------------
			// The following used to be Linda's receipt code, but she doesn't use it and has asked 
			// for it to be taken out altogether. JFD 6/27/13
			//--------------------------------------------------------------
			
						
			// if ($ferry_reservations[0]['Ferry_reservation']['status_return'] == "1"){
				// $return_string = $ferry_reservations[0]['Ferry_reservation']['return_port'].": ".$ferry_reservations[0]['Ferry_reservation']['return_date'];
			// } else { $return_string = "N/A";}
// 			
// 			
			// $pdf_doc='/home/bbfl/public/cohoferry.com/public/app/webroot/vouchers/receipt.pdf';	
			// $pdf_data = array(
				// 'name' => strtoupper( $actual_reservation[0]['Reservation']['first_name']." ".$actual_reservation[0]['Reservation']['last_name'] ), 
				// 'depart' => strtoupper( $ferry_reservations[0]['Ferry_reservation']['depart_port'].": ".$ferry_reservations[0]['Ferry_reservation']['depart_date'] ), 
				// 'return' => strtoupper( $return_string), 
				// 'confirmation' => $actual_reservation[0]['Reservation']['confirmation'], 
				// 'paid' => "$".$actual_reservation[0]['Reservation']['dueAtCheckout'] 
			// );
// 			
// 			
			// $fdf_data=createFDF($pdf_doc, $pdf_data);
// 					
			// //Create the FDF file - should probably save both just to be safe.
            // if($fp=fopen($fdf_dir.'/'.$fdf_file,'w')){
                // fwrite($fp,$fdf_data,strlen($fdf_data));
                // //echo $fdf_file,' written successfully.';
            // }else{
            	// //debug ($fp);
                // die('Unable to create file: '.$fdf_dir.'/'.$fdf_file);
            // }
            // fclose($fp);
// 			
			// //Merge the FDF and the PDF file, and then flatten them so they can't be edited
			// passthru("pdftk ".$pdf_doc." fill_form ".$fdf_dir.'/'.$rand_id.".fdf output ".$fdf_dir.'/'.$rand_id."-front.pdf flatten", $returnval);
// 			
			// unlink($fdf_dir.'/'.$rand_id.".fdf");
			
			
			foreach ($voucher_reservations as $key => $value) {
				
				foreach ($voucher_reservations[$key] as $hr) {
					
					$pagecount++;
					
					if (array_key_exists('hotel_id', $hr)) {
							
						$pdf_doc='/home/bbfl/public/cohoferry.com/public/app/webroot/vouchers/hotel-template.pdf';
            	
						$hotel = $this->Hotel->find('all',array('conditions'=>array('id'=>$hr['hotel_id'])));
						$room = $this->Hotel_room->find('all',array('conditions'=>array('id'=>$hr['room_id'])));
						
						//debug($hotel);
						//debug($room);
				
						$pdf_data = array(
							'hotel-name' => strtoupper($hotel[0]['Hotel']['name']), 
							'name' => strtoupper( $actual_reservation[0]['Reservation']['first_name']." ".$actual_reservation[0]['Reservation']['last_name'] ), 
							'bbfl-confirmation' => 'BBFL CONFIRMATION '. $actual_reservation[0]['Reservation']['confirmation'],  
							'hotel-confirmation' => 'HOTEL CONFIRMATION '. $hr['hotel_confirmation'],  
							'room-type' => $room[0]['Hotel_room']['name'], 
							'check-in' =>  date('M d, Y', strtotime($hr['check_in'])), 
							'check-out' => date('M d, Y', strtotime($hr['check_out'])), 
							'occupancy' => $hr['adults'].' adults & '. $hr['children']." children", 
							'purchased' => '', 
							//'package' => 'JOHN\'S TEST'
						);
						
						
						
						//debug($pdf_data);
						
						
					} else {

					//debug($hr);
					//exit();
						
						$pdf_doc='/home/bbfl/public/cohoferry.com/public/app/webroot/vouchers/attraction-template.pdf';
            	
						$attraction = $this->Attraction->find('all',array('conditions'=>array('id'=>$hr['attraction_id'])));
						$ticket = $this->Attraction_ticket->find('all',array('conditions'=>array('id'=>$hr['tour_id'])));
						
						$agerange = array_values(json_decode($hr['age_range'],true));
									
						$newagerange = Array();
						for ($i=0; $i <= 3; $i++) {
							if (isset($agerange[$i]['name'])) { $newagerange[$i]['name'] = $agerange[$i]['name'];  $newagerange[$i]['amount'] = $agerange[$i]['amount']; }
							else { $newagerange[$i]['name'] = '';  $newagerange[$i]['amount'] = ''; }
							//$newagerange[$i]
						}
						
						//debug($attraction[0]['Attraction']);
						//exit();
						if(strtotime($hr['reserved_date']) == false){
							$attrvalid = date('M d, Y', $hr['reserved_date']);
						} else {
							$attrvalid = date('M d, Y', strtotime($hr['reserved_date']));
						}
						
						if ($hr['time_ticket'] == "Yes") { $attrvalid .= " at ".$hr['time']; }
				
						$pdf_data = array(
							'attraction-name' => strtoupper($attraction[0]['Attraction']['name']), 
							'tour-name' => strtoupper($ticket[0]['Attraction_ticket']['name']), 
							'name' => strtoupper( $actual_reservation[0]['Reservation']['first_name']." ".$actual_reservation[0]['Reservation']['last_name'] ), 
							'bbfl-confirmation' => 'BBFL CONFIRMATION '. $actual_reservation[0]['Reservation']['confirmation'],  
							'valid' => 'VALID ON:', 
							'age-1' => $newagerange[0]['name'], 
							'age-2' => $newagerange[1]['name'], 
							'age-3' => $newagerange[2]['name'], 
							'age-4' => $newagerange[3]['name'], 
							'valid-text' => $attrvalid, 
							'age-1-text' => $newagerange[0]['amount'], 
							'age-2-text' => $newagerange[1]['amount'], 
							'age-3-text' => $newagerange[2]['amount'], 
							'age-4-text' => $newagerange[3]['amount'], 
							//'package' => 'JOHN\'S TEST'
						);
						
						//debug($pdf_data);
						
					}
					

					
					$fdf_data=createFDF($pdf_doc, $pdf_data);
					
					//Create the FDF file - should probably save both just to be safe.
		            if($fp=fopen($fdf_dir.'/'.$fdf_file,'w')){
		                fwrite($fp,$fdf_data,strlen($fdf_data));
		                //echo $fdf_file,' written successfully.';
		            }else{
		            	//debug ($fp);
		                die('Unable to create file: '.$fdf_dir.'/'.$fdf_file);
		            }
		            fclose($fp);
					
					//Merge the FDF and the PDF file, and then flatten them so they can't be edited
					passthru("pdftk ".$pdf_doc." fill_form ".$fdf_dir.'/'.$rand_id.".fdf output ".$fdf_dir.'/'.$rand_id.".pdf flatten", $returnval);
					//echo $returnval;
					
					// set hotel barcode
					$bc = new Barcode39($actual_reservation[0]['Reservation']['confirmation']); 
					$bc->draw($fdf_dir.'/'.$rand_id.".gif");

					$pdf = new FPDI();
					
					$pdf->AddPage();
					$pdf->setSourceFile($fdf_dir.'/'.$rand_id.".pdf");
					$importedpage = $pdf->importPage(1);
					$pdf->useTemplate($importedpage, 0, 0, 0, 0, true);
					
					$pdf->Image($fdf_dir.'/'.$rand_id.".gif",17,113);
					$pdf->Output($fdf_dir.'/'.$rand_id.'-page-'.$pagecount.'.pdf', 'F');
					
					unlink($fdf_dir.'/'.$rand_id.".pdf");
					unlink($fdf_dir.'/'.$rand_id.".fdf");
					unlink($fdf_dir.'/'.$rand_id.".gif");
					
					//exit();
					
				}

			}

			//exit();

			passthru('pdftk '.$fdf_dir.'/*.pdf cat output '.$fdf_dir.'/'.$rand_id.'-final.pdf', $returnval);
			

			$file = $fdf_dir.'/'.$rand_id."-final.pdf";
			
			header('Content-type: application/pdf');
			header('Content-Length: '. filesize($file));
			header('Content-Disposition: attachment; filename='.$rand_id.'-final.pdf');
			
		    ob_clean();
		    flush();
			
			readfile($file);
			
			ignore_user_abort(true);		
			
			passthru('rm -rf '.$fdf_dir);
 
	
	}

	/**
	 * Room Nights Report
	 */
	public function room_nights_report()
	{
		//setup the layout on the page
		$this->layout = 'admin';
		//set the admin navigation
		$page_url = '/reports/room_nights_report';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check); 	
		
		//grab all hotels
		$hotels = $this->Hotel->find('all');
		$hotels_array = array();
		$hotels_array[''] = 'Select Hotel';
		
		foreach ($hotels as $key => $value) {
			$hotel_id = $hotels[$key]['Hotel']['id'];
			$hotel_name = $hotels[$key]['Hotel']['name'];
			$hotels_array[$hotel_id] = $hotel_name;
		}
		
		$this->set('hotels',$hotels_array);
			
	}
	
	public function booking_report()
	{
		//setup the layout on the page
		$this->layout = 'admin';
		//set the admin navigation
		$page_url = '/reports/booking_report';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check); 	
		
		//grab all hotels
		$hotels = $this->Hotel->find('all');
		$hotels_array = array();
		$hotels_array[''] = 'Select Hotel';
		
		foreach ($hotels as $key => $value) {
			$hotel_id = $hotels[$key]['Hotel']['id'];
			$hotel_name = $hotels[$key]['Hotel']['name'];
			$hotels_array[$hotel_id] = $hotel_name;
		}
		
		$this->set('hotels',$hotels_array);
			
	}


public function request_bookings()
	{
		
		if ($this->request->is('ajax')){
			
			$start = date('Y-m-d',strtotime($this->data['start'])).' 00:00:00';	
			//$startend = date('Y-m-d',strtotime($this->data['end'])).' 00:00:00';
			$end = date('Y-m-d',strtotime($this->data['end'])).' 23:59:59';
			$type = $this->data['criteria'];
			
			$hotels_array = Array();
			$attractions_array = Array();
			
			$hdebug = Array();
			
			if ($this->data['type'] == 'both' || $this->data['type'] == 'hotel') {
			
				$hotels = $this->Hotel->find('all');
		
				foreach ($hotels as $key => $value) {
					$hotel_id = $hotels[$key]['Hotel']['id'];
					$hotel_name = $hotels[$key]['Hotel']['name'];
					//$hotels_array[$hotel_id] = $hotel_name;
					
					if ($type == "checkin"){
						$hotel_reservations = $this->Hotel_reservation->find('all',array(
							'conditions'=>
							array('OR' => array(
							    array('check_in >='=>$start,'check_in <='=>$end, 'hotel_id'=>$hotel_id),
							    array('check_out >='=>$start,'check_out <='=>$end, 'hotel_id'=>$hotel_id)
							))
						));
					} else {
						$hotel_reservations = $this->Hotel_reservation->find('all',array(
							'conditions'=>
							array('OR' => array(
							    array('created >='=>$start,'created <='=>$end, 'hotel_id'=>$hotel_id),
							    array('created >='=>$start,'created <='=>$end, 'hotel_id'=>$hotel_id)
							))
						));
					}
					
					$night_count = 0;
					$booking_count = 0;
					
					
					foreach ($hotel_reservations as $hr) {
						
						//active ones only
						if ($hr['Hotel_reservation']['status'] != "1") {continue;}
						
						if ($type == "created") {$booking_count++; continue;}
						
						$check_in = strtotime($hr['Hotel_reservation']['check_in']);
						$check_out = strtotime($hr['Hotel_reservation']['check_out']);	
						
						$new_start = strtotime($start);
						$new_end = strtotime($end);
						
						$seconds = 86400;
						
						//get room name	
						$room_name = '';
						
						if ($check_in < $new_start) { $check_in = $new_start; }
						if ($check_out > $new_end) { $check_out = $new_end; }
						
						//count room nights
						$night_count = $night_count + ceil(($check_out - $check_in) / $seconds);	
						
						if (ceil(($check_out - $check_in) / $seconds) > 0) {$booking_count++;}
						
					}
					
					$hotels_array[$hotel_id]['name'] = $hotel_name;
					$hotels_array[$hotel_id]['night_count'] = $night_count;
					$hotels_array[$hotel_id]['booking_count'] = $booking_count;
					
					$hdebug[$hotel_name] = $hotel_reservations;
					
					
				}

			}

			if ($this->data['type'] == 'both' || $this->data['type'] == 'attraction') {
			
				$attractions = $this->Attraction->find('all');
				//debug ($attractions);
				foreach ($attractions as $key => $value) {
					$attraction_id = $attractions[$key]['Attraction']['id'];
					$attraction_name = $attractions[$key]['Attraction']['name'];
					//$hotels_array[$hotel_id] = $hotel_name;
					
					$attraction_reservations = $this->Attraction_reservation->find('all',array(
						'conditions'=>
						array('OR' => array(
						    array('created >='=>$start,'created <='=>$end, 'attraction_id'=>$attraction_id),
						    array('created >='=>$start,'created <='=>$end, 'attraction_id'=>$attraction_id)
						))
					));
					
					$night_count = 0;
					$booking_count = 0;
					
					
					foreach ($attraction_reservations as $ar) {
						
						//active ones only
						if ($ar['Attraction_reservation']['status'] != "1") {continue;}
						$booking_count++;		
					
						// $check_in = strtotime($hr['Hotel_reservation']['check_in']);
						// $check_out = strtotime($hr['Hotel_reservation']['check_out']);	
// 						
						// $new_start = strtotime($start);
						// $new_end = strtotime($end);
// 						
						// $seconds = 86400;
// 						
						// //get room name	
						// $room_name = '';
// 						
						// if ($check_in < $new_start) { $check_in = $new_start; }
						// if ($check_out > $new_end) { $check_out = $new_end; }
// 						
						// //count room nights
						// $night_count = $night_count + ceil(($check_out - $check_in) / $seconds);	
// 						
						// if (ceil(($check_out - $check_in) / $seconds) > 0) {$booking_count++;}
						
					}
					
					$attractions_array[$attraction_id]['name'] = $attraction_name;
					$attractions_array[$attraction_id]['booking_count'] = $booking_count;
					
					//$hdebug[$hotel_name] = $hotel_reservations;
					
					
				}

			}
			
			//$bookings_array = array_merge($hotels_array, $attractions_array);
			
			//$this->set('hdebug',$hdebug);
			
			$this->set('hotels_overview',$hotels_array);
			$this->set('attractions_overview',$attractions_array);
			
		}
		
	}
	
	/**
	 * Accounting
	 */
	public function accounting()
	{
		$yesterday_start = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 8, date("Y"))).' 00:00:00';
		$yesterday_end = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y"))).' 23:59:59';
		
		$previous_reservations = $this->Reservation->find('all',array('conditions'=>array('Reservation.created BETWEEN ? AND ?'=>array($yesterday_start, $yesterday_end))));
				//create a new array
		$master = array();
		
		//debug($previous_reservations);
		
		//exit();
		
		
		//search for all schedule_ids with the id from the url parameter order by last name asc
	    // $ferry = $this->Ferry_reservation->find('all',array(
	    	// 'conditions'=>array('vehicle_count >'=>'0',
	    	// 'OR'=>array('schedule_id1'=>$id, 'schedule_id2'=>$id))),
	    	// 'order',array('last_name'=>'asc')
		// );
		
		$idx = -1; //create an index to start from 0
		
		
		
		
		if(count($previous_reservations)>0){
			foreach ($previous_reservations as $prKey =>$prValue) {
				
				$ferries = $this->Ferry_reservation->find('all',array('conditions'=>array('reservation_id >'=>$previous_reservations[$prKey]['Reservation']['id'])));
				$hotels = $this->Hotel_reservation->find('all',array('conditions'=>array('reservation_id >'=>$previous_reservations[$prKey]['Reservation']['id'])));
				$attractions = $this->Attraction_reservation->find('all',array('conditions'=>array('reservation_id >'=>$previous_reservations[$prKey]['Reservation']['id'])));
				//$packages = $this->Ferry_reservation->find('all',array('conditions'=>array('reservation_id >'=>$previous_reservations[$prKey])));
				
				if(count($hotels)>0){
					foreach($hotels as $hotel) {
						$idx++;
						$hotel_info = $this->Hotel->read('', $hotel['Hotel_reservation']['hotel_id']);
						
						debug($hotel_info);
						//debug($hotel);
						//exit();
						
						if ($hotel_info['Hotel']['accounting_code'] == "1") { $ap_account = "202--1"; } elseif ($hotel_info['Hotel']['accounting_code'] == "2"){ $ap_account = "202--2"; } else { $ap_account = "Country Code Error"; }
						
						while (true) {
						
							// $master[$idx] = array(
								// 'Vendor ID' => $hotel_info['Hotel']['accounting_code'],
								// 'Invoice' => $previous_reservations[$prKey]['Reservation']['confirmation'],
								// 'Date' => date('n/j/y', strtotime($previous_reservations[$prKey]['Reservation']['created'])),
								// 'Date Due' => date('n/j/y', strtotime($previous_reservations[$prKey]['Reservation']['created'])),
								// 'Accounts Payable Account' => $ap_account,
								// 'Number of Distributions' => 
								// 'Invoice/CM Distribution' =>
								// 'G/L Account' =>
								// 'Amount' =>			
							// );
						// END NEW EDITS BY JFD -----------------------------------------------------------------------------------------------
						
						}
						
					}		
				}
				
				//get reservation id and calculate total passengers
				

			}
		} else {
			
			
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

				$date = date('mdy',strtotime($d['Schedule']['check_date']));
				$time = date('gi',strtotime($d['Schedule']['service_date']));
				
				$filename = $destination.'-'.$date.'-'.$time;

			}
		} 
		$this->set('filename',$filename);
		//$this->set('send',$send);
		
	    $this->layout = null;
	   	$this->autoLayout = false;
	  	Configure::write('debug', '2');
			
	}
	
	public function request_room_nights()
	{
		
		if ($this->request->is('ajax')){
			
			$start = date('Y-m-d',strtotime($this->data['start'])).' 00:00:00';	
			//$startend = date('Y-m-d',strtotime($this->data['end'])).' 00:00:00';
			$end = date('Y-m-d',strtotime($this->data['end'])).' 23:59:59';
			
			$hotel = $this->data['hotel'];

			//first... get all of the rooms for this hotel
			$rooms = $this->Hotel_room->find('all',array('conditions'=>array('hotel_id'=>$hotel)));
			
			//echo "start:". $start . " | | " ."end:". $end . " | ";
			
			//parse through and count 'em up
			$room_nights = array();
			$room_number = -1;
			foreach ($rooms as $room) {
				$room_number++;
				$hotel_reservations = $this->Hotel_reservation->find('all',array(
					//'conditions'=>array('check_in >='=>$start,'check_in <='=>$end, 'room_id'=>$room['Hotel_room']['id'], 
					//'or'=>array('check_out >='=>$start,'check_out <='=>$end, 'room_id'=>$room['Hotel_room']['id']))
					'conditions'=>
					array('OR' => array(
					    array('check_in >='=>$start,'check_in <='=>$end, 'room_id'=>$room['Hotel_room']['id']),
					    array('check_out >='=>$start,'check_out <='=>$end, 'room_id'=>$room['Hotel_room']['id'])
					))
					//'room_id'=>$room['Hotel_room']['id']),
					//'or'=>array('check_out between ? and ?'=>array($start, $end),'room_id'=>$room['Hotel_room']['id'])
				));
				
				$night_count = 0;
				foreach ($hotel_reservations as $hr) {
					
					//debug($hr);
					
					//variables
					$check_in = strtotime($hr['Hotel_reservation']['check_in']);
					$check_out = strtotime($hr['Hotel_reservation']['check_out']);	
					
					$new_start = strtotime($start);
					$new_end = strtotime($end);
					
					$seconds = 86400;
					
					//get room name	
					$room_name = '';
					
					if ($check_in < $new_start) { $check_in = $new_start; }
					if ($check_out > $new_end) { $check_out = $new_end; }
					
					//count room nights
					$night_count = $night_count + ceil(($check_out - $check_in) / $seconds);	
					
				}
				
				$room_nights[$room_number]['name'] = $room['Hotel_room']['name'];
				$room_nights[$room_number]['count'] = $night_count;
					
			}
			//count attraction
			$this->set('rooms',$room_nights);
		}
		
	}
	
	public function index() 
	{

	}
	
	public function add()
	{
		
	}
	
	public function edit()
	{
		
	}
	
	public function delete($id = null)
	{
		
	}
	
	public function view()
	{
		
	}

}