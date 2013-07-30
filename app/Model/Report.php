
<?php
App::uses('AppModel', 'Model');
/**
 * 
 */
class Report extends AppModel {
    public $name = 'Report';
    //Models
    public function searchVouchers ($reservations){
       	$vouchers = array();
	   
	    if(count($reservations)>0){
        	foreach ($reservations as $r) {
        		//$ferry_id = $f['Ferry_reservation']['id'];
				$reservation_id = $r['Reservation']['id'];
				//$schedule_id1 = $f['Ferry_reservation']['schedule_id1'];
				
				//get the printed confirmation
				//$reservations = ClassRegistry::init('Reservation')->find('all',array('conditions'=>array('id'=>$reservation_id)));
				if ($r['Reservation']['package_total'] == "0.00" && $r['Reservation']['hotel_total'] == "0.00" && $r['Reservation']['attraction_total'] == "0.00") { continue; }
				
				if(count($reservations)>0){ //probably don't need this
					
						$printed = $r['Reservation']['printed'];
						switch($printed){
							case '1':
								$printed = 'Yes';
							break;
							
							default:
								$printed = 'No';
							break;
						}
						$bbfl_confirmation = $r['Reservation']['confirmation'];
						$name = $r['Reservation']['first_name']." ".$r['Reservation']['last_name'];
						//$time = $f['Ferry_reservation']['depart_port'].": ".date('M d, Y', strtotime($f['Ferry_reservation']['depart_date']));
					
				} else {
					$printed = 'No';
					$bbfl_confirmation = '';
				}
				
				//check if here are any hotels under this reservation
				$hotels = ClassRegistry::init('Hotel_reservation')->find('all',array('conditions'=>array('reservation_id'=>$reservation_id)));
				if(count($hotels)>0){
					foreach ($hotels as $h) {
						$hotel_confirmation = $h['Hotel_reservation']['hotel_confirmation'];	
						if ($hotel_confirmation) {$h_confirmation = "Entered";} else {$h_confirmation = "Not entered"; break;}
					}
				} else { $h_confirmation = "Attraction/Add-on only"; }
				
				$vouchers[$reservation_id] = array(
					'bbfl_confirmation'=>$bbfl_confirmation,
					'reservation_id'=>$reservation_id,
					'hotel_confirmation'=>$h_confirmation,
					'name'=>$name,
					'time'=>"",
					'printed'=>$printed
				);	

			}
        }

		return $vouchers;
    }
}

?>