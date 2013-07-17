<?php
//PAGE SPECIFIC
//CSS FILES
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/reservation_ferry',
	'frontend/bootstrap-form'
	//'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	//'frontend/reservation_ferry',
	),
	'stylesheet',
	array('inline'=>false)
);

//JS FILES
echo $this->Html->script(array(
	//'admin/plugins/phone_mask/phone_mask.js',
	//'frontend/reservation_travelers.js', //jquery-ui file
	),
	FALSE
);

?>

<div class="container">
	
	<div class="row">
		<div class="sixteen columns">
			<div class="page_heading checkout"><h1>Completed Reservation</h1>
				<img src="/img/icons/done-active.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/review.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/payment.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/traveler.png" class="pull-right" style="margin-left: 10px;" />
			</div>
		</div>		
	</div>
	<div class="row">
		<div class="sixteen columns">

			<h1 style="text-align:center; margin:40px;">Thank you! Your reservation has been made.</h1>
			<h2 style="text-align:center; margin-bottom:20px;">Your confirmation number: <span style="color:#ee3a43">#<?php echo $confirmation;?></span></h2>
			You will receive an email receipt shortly. Please save this email for your records. 
		
		</div>
	</div>
	<?php
	if($group_admin == 'Yes'){ //admin users can go back to admin page
	?>
	<div class="row">
		<a class="btn btn-success" href="/reservations/admin">Go Back to Admin Page</a>
	</div>	
	<?php	
	}
	?>
</div>
