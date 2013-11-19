<?php
 //debug($reservations);
	$line= $delivery[0]['Delivery'];

	$this->CSV->addRow(array_keys($line));
 	foreach ($delivery as $key =>$value)
 	{
 		if(is_numeric($key)){
 			$this->CSV->addRow($delivery[$key]['Delivery']);
 		}


 	}

	$filename = 'Schedule: '.date('D n-d-Y',strtotime($delivery['Date'])).' ['.$delivery['Route'].']';
 	echo  $this->CSV->render($filename);
 
?>