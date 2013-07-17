<?php

 //debug($reservations);
 $line= $reservations[0]['Reservation'];
 $this->CSV->addRow(array_keys($line));
 foreach ($reservations as $reservation)
 {
      $line = $reservation['Reservation'];
       $this->CSV->addRow($line);
 }


$fullfilename = 'csv/'.$filename.'.csv';

$this->CSV->save($fullfilename);
  
$sendTo = array('john@brevica.com');
$subject = 'Daily BBFL vehicle manifests';
$Email = new CakeEmail('gmail');
$Email->template('customs')
    ->emailFormat('text')
	//->viewVars(compact('confirmation_id','full_name','ferry_string','hotel_string','attraction_string','package_string','total_string'))
    ->to($sendTo)
    ->from($from)
	->subject($subject)
	->attachments(array( ($filename.'.csv') => $fullfilename ))
    ->send();	


unlink ($fullfilename);
 

?>