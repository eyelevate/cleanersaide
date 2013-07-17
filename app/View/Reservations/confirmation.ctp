<?php
//PAGE SPECIFIC
//CSS FILES
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/reservation_ferry',
	'frontend/bootstrap-form',
	'../js/admin/plugins/colorbox/colorbox.css'
	//'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	//'frontend/reservation_ferry',
	),
	'stylesheet',
	array('inline'=>false)
);

//JS FILES
echo $this->Html->script(array(
	//'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui file
	'admin/plugins/colorbox/jquery.colorbox.min.js'
	),
	FALSE
);


if(!empty($_SESSION['Reservation_travelers'])){
	$rt = $_SESSION['Reservation_travelers'];
	$first_name = ucfirst($rt['first_name']);
	$middle_initial = ucfirst($rt['middle_initial']);
	$last_name = ucfirst($rt['last_name']);
	$birthdate = $rt['birthdate'];
	$citizenship = $rt['citizenship'];
	$doctype = $rt['doctype'];
	$docnumber = $rt['docnumber'];
	$contact_address = $rt['contact_address'];
	$contact_city = ucwords($rt['contact_city']);
	$contact_state = $rt['contact_state'];
	$contact_zip = $rt['contact_zip'];
	$contact_email = $rt['contact_email'];
	$contact_phone = $rt['contact_phone'];
} else {
	$first_name = '';
	$middle_initial = '';
	$last_name = '';
	$birthdate = '';
	$citizenship = '';
	$doctype = '';
	$docnumber = '';
	$contact_address = '';
	$contact_city = '';
	$contact_state = '';
	$contact_zip ='';
	$contact_email = '';
	$contact_phone = '';
}

if(!empty($_SESSION['Reservation_payments'])){
	foreach ($_SESSION['Reservation_payments'] as $rp) {
		$payment_method = $rp['payment_method'];
		$vdata =  trim(preg_replace("/[^0-9]/","",$rp['vdata']));
		$card_full_name = ucwords($rp['card_full_name']);
		$card_cvv = $rp['card_cvv'];
		$card_expires_month = $rp['card_expires_month'];
		$card_expires_year = $rp['card_expires_year'];
		$billing_address = $rp['contact_address'];
		$billing_city = ucwords($rp['contact_city']);
		$billing_state = $rp['contact_state'];
		$billing_zip = $rp['contact_zip'];
		
	}
} else {
	$payment_method = '';
	$vdata = '';
	$card_full_name = '';
	$card_cvv = '';
	$card_expires_month = '';
	$card_expires_year = '';
	$ach_routing_number = '';
	$ach_account_number = '';
	$ach_account_type = '';
	$ach_first_name = '';
	$ach_last_name = '';
	$billing_address = '';
	$billing_city = '';
	$billing_state = '';
	$billing_zip = '';
}

//debug($_SESSION);

?>

<div class="container">
	
	<div class="row">
		<div class="sixteen columns">
			<div class="page_heading checkout"><h1>Review Reservation</h1>
				<img src="/img/icons/done.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/review-active.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/payment.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/traveler.png" class="pull-right" style="margin-left: 10px;" />
			</div>
		</div>		
	</div>
	<?php
	echo $this->element('/reservations/billing_complete',array(
		'group_admin'=>$group_admin,
		'ferry_sidebar'=>$ferry_sidebar,
		'hotel_sidebar'=>$hotel_sidebar,
		'attraction_sidebar'=>$attraction_sidebar,
		'package_sidebar'=>$package_sidebar
	));
	?>	


<div class="row">
	<div class="eight columns">
		<div id="receiptSummaryDiv" class="form-actions" style="box-shadow: 0px 1px 2px #999;">
			<div style="background: url(/img/frontend/heading_bgr.png) left top repeat-x;">
				<h3>Traveler Details</h3>
			</div>			
			<p><?php echo $first_name.' '.$middle_initial.' '.$last_name;?><br>
			   <?php echo $contact_address;?><br>
			   <?php echo $contact_city.', '.$contact_state.' '.$contact_zip;?><br>
			   <?php echo $contact_email;?><br>
			   <?php echo $contact_phone;?><br>
			</p>
				
			<p>
			   <?php echo $citizenship;?><br>
			   <?php echo $doctype.' : '. $docnumber;?><br>
			   <?php echo 'Birthdate : '.date('n/d/Y',strtotime($birthdate));?>
			</p>

		</div>
	</div>
	
	<div class="eight columns">
		<div id="receiptSummaryDiv" class="form-actions" style="box-shadow: 0px 1px 2px #999;">
			<div style="background: url(/img/frontend/heading_bgr.png) left top repeat-x;">
				<h3>Billing Details</h3>
			</div>
			
			<p>Credit Card ending in <?php echo substr($vdata,-4);?><br>
				Expires on <?php echo $card_expires_month.'/'.$card_expires_year;?>
			</p>
			<p><?php echo $first_name.' '.$middle_initial.' '.$last_name;?><br>
			   <?php echo $billing_address;?><br>
			   <?php echo $billing_city.', '.$billing_state.' '.$billing_zip;?><br>
			</p>
			
		</div>
	</div>
	
</div>
<form action="/reservations/processing_final" method="post" id="finalcheckout">
	<input name="data[Type]" value="final" type="hidden"/>
		
	<button type="button" class="btn btn-bbfl checkoutbutton">Place Reservation</button>	
</form>	

		<script>
            $(document).ready(function () {
                //$('a.colorbox').colorbox({ opacity:0.5, inline:true, href: "#inline", overlayClose:false, escKey:false });
                
                $('.checkoutbutton').click(function() {
                	
                	$("input[type=button]").attr("disabled", "disabled");
                	$.colorbox({ opacity:0.5, inline:true, href: "#inline", overlayClose:false, escKey:false });
					$('#finalcheckout').submit();
                	
                });
                
            });
        </script>
        <style>#cboxClose{ display:none !important; }</style>


<!-- <a href="#"  class="btn btn-bbfl colorbox">Test Window</a> -->
<div style="display: none;">
	<div id="inline" style="height:120px; width:500px; background: rgba(0,0,0,.5);">
		<h1 style="color: #FFF; text-align: center;">We're booking your reservation!</h1>
		<p style="color: #CCC; text-align: center;">Please do not hit BACK on your browser, or close the window.</p>
		<div class="progress progress-striped active progress-danger">
		  <div class="bar" style="width: 100%;"></div>
		</div>
	</div>
</div>