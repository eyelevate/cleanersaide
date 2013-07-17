<?

//debug($_POST);

?>

<div class="container">
	
			<h1 style="text-align:center; margin:40px;">The reservation has been made.</h1>
			<h2 style="text-align:center; margin-bottom:20px;">The confirmation number: <span style="color:#ee3a43">#<?php echo $confirmation;?></span></h2>
			<a href="/reservations/processing_print_reservation_email/<? echo $confirmation; ?>" class="btn btn-mini pull-right"><i class="icon-print"></i> Print Receipt</a>