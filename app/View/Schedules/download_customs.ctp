<?php
 //debug($reservations);
 $line= $reservations[0]['Reservation'];
 $this->CSV->addRow(array_keys($line));
 foreach ($reservations as $reservation)
 {
      $line = $reservation['Reservation'];
       $this->CSV->addRow($line);
 }


 echo  $this->CSV->render($filename);
 
?>