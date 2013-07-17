<?php
 $line= $reservations[0]['Reservation'];
 $this->CSV->addRow(array_keys($line));
 foreach ($reservations as $reservation)
 {
      $line = $reservation['Reservation'];
       $this->CSV->addRow($line);
 }
 $filename='reservation';
 echo  $this->CSV->render($filename);
?>