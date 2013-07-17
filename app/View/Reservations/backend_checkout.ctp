<?php
//PAGE SPECIFIC
//CSS FILES
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/reservation_ferry'
	//'frontend/bootstrap-form'
	//'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	//'frontend/reservation_ferry',
	),
	'stylesheet',
	array('inline'=>false)
);

//JS FILES
echo $this->Html->script(array(
	//'admin/plugins/phone_mask/phone_mask.js',
	'frontend/reservation_travelers.js', //jquery-ui file
	'admin/reservations_add_checkout.js'
	),
	FALSE
);

//Traveler's Info ------------------------------------------------------------
//----------------------------------------------------------------------------

	$checkout_type = 'Traveler Information';
	$show_new_user = 'hide';
	$show_div = 'hide';

if(!empty($showUser)){
	if($showUser == 'YES'){
		$show_div ='';
		$show_disabled="false";
		$show_checked = 'checked="checked"';
		$show_value = 'Yes';
	} else {
		$show_div = 'hide';
		$show_disabled="disabled";
		$show_checked = '';
		$show_value = 'No';
	}
} else {
	$show_div = 'hide';
	$show_disabled="false";
	$show_checked = '';
	$show_value = 'No';
}

if(!empty($errorForm)){
	$post_form = 'YES';
} else {
	$post_form = 'NO';
}

//check if a valid user is logged in
if(isset($username) && $username != ''){
	$removeBlock = 'Yes';
} else {
	$removeBlock = 'No';
}


//Payment Info ---------------------------------------------------------------
//----------------------------------------------------------------------------




//FROM BILLING_COMPLETE.CTP ---------------------------------------------------------
//-----------------------------------------------------------------------------------
$total_subtotal = 0; //creates the final subtotal
$total_total = 0; //creates the final total
$total_due = 0; //creates the final due now
$total_due_at_arrival = 0; //creates the final due at arrival
$total_tax_sum = 0; //sums up all of the tax due

$_SESSION['Reservation_totals'] = array();
$total_ferry = 0;
$total_hotel = 0;
$total_attraction = 0;
$total_package = 0;

$count_ferry = count($ferry_sidebar);
$count_hotel = count($hotel_sidebar);
$count_attractions = count($attraction_sidebar);
$count_package = count($package_sidebar);
$ferry_fee = 0;
$first_name = '';
$middle_initial = '';
$last_name = '';
$dobm = '';
$dobd = '';
$doby = '';
$citizenship = '';
$doctype = '';
$docnumber = '';
$contact_address = '';
$contact_city = '';
$contact_state = '';
$contact_zip = '';
$contact_email = '';
$contact_phone = '';
$birthdate = '';	
$payment_method = '';
$vdata = '';
$card_full_name = '';
$card_cvv = '';
$card_expires_month = '';
$card_expires_year = '';
$contact_address = '';
$contact_city = '';
$contact_state = '';
$contact_zip ='';
$terms = '';

if(isset($_SESSION['Reservation_travelers'])){
	$first_name = $_SESSION['Reservation_travelers']['first_name'];
	$middle_initial = $_SESSION['Reservation_travelers']['middle_initial'];
	$last_name = $_SESSION['Reservation_travelers']['last_name'];
	$dobm = $_SESSION['Reservation_travelers']['dobm'];
	$dobd = $_SESSION['Reservation_travelers']['dobd'];
	$doby = $_SESSION['Reservation_travelers']['doby'];
	$citizenship = $_SESSION['Reservation_travelers']['citizenship'];
	$doctype = $_SESSION['Reservation_travelers']['doctype'];
	$docnumber = $_SESSION['Reservation_travelers']['docnumber'];
	$contact_address = $_SESSION['Reservation_travelers']['contact_address'];
	$contact_city = $_SESSION['Reservation_travelers']['contact_city'];
	$contact_state = $_SESSION['Reservation_travelers']['contact_state'];
	$contact_zip = $_SESSION['Reservation_travelers']['contact_zip'];
	$contact_email = $_SESSION['Reservation_travelers']['contact_email'];
	$contact_phone = $_SESSION['Reservation_travelers']['contact_phone'];
	$birthdate = $_SESSION['Reservation_travelers']['birthdate'];
}
if(isset($_SESSION['Reservation_payments'])){
	$payment_method = $_SESSION['Reservation_payments']['Payment']['payment_method'];
	$vdata = $_SESSION['Reservation_payments']['Payment']['vdata'];
	$card_full_name = $_SESSION['Reservation_payments']['Payment']['card_full_name'];
	$card_cvv = $_SESSION['Reservation_payments']['Payment']['card_cvv'];
	$card_expires_month = $_SESSION['Reservation_payments']['Payment']['card_expires_month'];
	$card_expires_year = $_SESSION['Reservation_payments']['Payment']['card_expires_year'];
	$contact_address = $_SESSION['Reservation_payments']['Payment']['contact_address'];
	$contact_city = $_SESSION['Reservation_payments']['Payment']['contact_city'];
	$contact_state = $_SESSION['Reservation_payments']['Payment']['contact_state'];
	$contact_zip = $_SESSION['Reservation_payments']['Payment']['contact_zip'];
	$terms = $_SESSION['Reservation_payments']['Payment']['terms'];
}

?>

<div class="container">

	<?php
	echo $this->element('/reservations/billing_complete',array(
		'group_admin'=>$group_admin,
		'ferry_sidebar'=>$ferry_sidebar,
		'hotel_sidebar'=>$hotel_sidebar,
		'attraction_sidebar'=>$attraction_sidebar,
		'package_sidebar'=>$package_sidebar
	));
	?>

	<?php echo $this->Form->create('User', array('url'=>$this->Html->url(array('controller'=>'reservations', 'action'=>'backend_processing')))); ?>
	<div class="row-fluid backend-checkout">
		<div class="span6 well">		
			<h2><?php echo $checkout_type;?></h2>
			<?php
			

				//check to see if this is a post validated form or a non post validated form. 
				//if the form is post validated remove all the values from the form else keep the values
				if($post_form == 'NO'){
				?>
					
					<div class="row-fluid">
					<?php
					echo $this->Form->input('User.first_name',array(
						'div'=>array('class'=>'control-group span5'),
						'label'=>'First Name *',
						'class'=>'span12',
						'style'=>'margin-left:0px;',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'value'=>$first_name,

					));	
	
					echo $this->Form->input('User.middle_initial',array(
					
						'div'=>array('class'=>'control-group span1'),
						'label'=>'Init',
						'before'=>'<div class="controls">',
						'after'=>'</div>',
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',
						'value'=>$middle_initial

					));	
					echo $this->Form->input('User.last_name',array(
						'div'=>array('class'=>'control-group span5'),
						'label'=>'Last Name *',
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',
						'value'=>$last_name

					));				
					?>
				    </div>
					
					<div class="row-fluid">
						<div class="span12"><label class="control-label" for="TravelerDOB">Date of Birth *</label> </div>
				    </div> 
					
					<div class="row-fluid" style="margin-top:0 !important;">
				    <?php
	
					echo $this->Form->input('User.dobm',array(
						'div'=>array('class'=>'control-group span4 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'id'=>'TravelerDOBM',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',
						'options'=>$months,
						'default'=>$dobm,

					));	
	
					echo $this->Form->input('User.dobd',array(
						'div'=>array('class'=>'control-group span2 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'id'=>'TravelerDOBD',
						'options'=>$days,
						'default'=>$dobd

					));	
					$years = array('NONE'=>'');
					for ($i=date('Y'); $i >= (date('Y')-100) ; $i--) { 
						$years[$i] = $i;
					}
					echo $this->Form->input('User.doby',array(
						'div'=>array('class'=>'control-group span3 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'id'=>'TravelerDOBY',
						'options'=>$years,
						'default'=>$doby
	
					));
				    ?>
				    </div>
	
					
					<div class="row-fluid">
					<?php
	
					echo $this->Form->input('User.citizenship',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Citizenship *',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'class'=>'req span12',
						'options'=>$countries,
						'default'=>$citizenship

					));				
					
					$documents = array(
						'NONE'=>'',
						'Passport'=>'Passport',
						'Permanent Resident Card'=>'Permanent Resident Card',
						'Enchanced Drivers License'=>'Enhanced Drivers License',
						'Other'=>'Other'
					);
					echo $this->Form->input('User.doctype',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Document Type *',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'class'=>'req span12',
						'options'=>$documents,
						'default'=>$doctype,

					));		
					echo $this->Form->input('User.docnumber',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Document Number',
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'value'=>$docnumber,
					));				
					?>
	
				    </div>
				    
				<div class="row-fluid" style="margin-top: 15px;">
				<?php
				echo $this->Form->input('User.contact_address',array(
					'div'=>array('class'=>'control-group span12'),
					'label'=>'Address *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',
					'value'=>$contact_address

				));		
				?>
				</div>
				<div class="row-fluid">
				<?php
	
				echo $this->Form->input('User.contact_city',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'City *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',
					'value'=>$contact_city

				));	
				echo $this->Form->input('User.contact_state',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'State/Province *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'value'=>$contact_state

				));		
				echo $this->Form->input('User.contact_zip',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'ZIP/Postal Code *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'value'=>$contact_zip
				));	
				?>
	
			    </div>
			    
			    <div class="row-fluid">
			  	<?php
			  	echo $this->Form->input('User.contact_email',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Email *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',
					'value'=>$contact_email
				));	
			  	echo $this->Form->input('User.contact_phone',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Phone Number *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',
					'value'=>$contact_phone
				));	
			} else {
				?>
					
				<div class="row-fluid">
				<?php
				echo $this->Form->input('User.first_name',array(
					'div'=>array('class'=>'control-group span5'),
					'class'=>'span12',
					'style'=>'margin-left:0px;',
					'error'=>array('attributes' => array('class' => 'help-block'))
				));	

				echo $this->Form->input('User.middle_initial',array(
				
					'div'=>array('class'=>'control-group span1'),
					'label'=>'Init',
					'before'=>'<div class="controls">',
					'after'=>'</div>',
					'class'=>'span12',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'style'=>'margin-left:0px;'
				));	
				echo $this->Form->input('User.last_name',array(
					'div'=>array('class'=>'control-group span5'),
					'class'=>'span12',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'style'=>'margin-left:0px;'
				));				
				?>
			    </div>
				
				<div class="row-fluid">
					<div class="span12"><label class="control-label" for="TravelerDOB">Date of Birth*</label> </div>
			    </div> 
				
				<div class="row-fluid">
			    <?php

				echo $this->Form->input('User.dobm',array(
					'div'=>array('class'=>'control-group span4 pull-left'),
					'label'=>false,
					'class'=>'span12',
					'id'=>'TravelerDOBM',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'style'=>'margin-left:0px;',
					'options'=>$months
				));	

				echo $this->Form->input('User.dobd',array(
					'div'=>array('class'=>'control-group span2 pull-left'),
					'label'=>false,
					'class'=>'span12',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'id'=>'TravelerDOBD',
					'options'=>$days
				));	
				$years = array('NONE'=>'');
				for ($i=date('Y'); $i >= (date('Y')-100) ; $i--) { 
					$years[$i] = $i;
				}
				echo $this->Form->input('User.doby',array(
					'div'=>array('class'=>'control-group span3 pull-left'),
					'label'=>false,
					'class'=>'span12',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'id'=>'TravelerDOBY',
					'options'=>$years
				));
			    ?>
			    </div>

				
				<div class="row-fluid">
				<?php

				echo $this->Form->input('User.citizenship',array(
					'div'=>array('class'=>'control-group span4'),
					'label'=>'Citizenship',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'req span12',
					'options'=>$countries
				));				
				
				$documents = array(
					'NONE'=>'',
					'Passport'=>'Passport',
					'Permanent Resident Card'=>'Permanent Resident Card',
					'Enchanced Drivers License'=>'Enhanced Drivers License',
					'Other'=>'Other'
				);
				echo $this->Form->input('User.doctype',array(
					'div'=>array('class'=>'control-group span4'),
					'label'=>'Document Type',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'req span12',
					'options'=>$documents
				));		
				echo $this->Form->input('User.docnumber',array(
					'div'=>array('class'=>'control-group span4'),
					'label'=>'Document Number',
					'class'=>'span12',
					'error'=>array('attributes' => array('class' => 'help-block'))
				));				
				?>

			    </div>
			    
				<div class="row-fluid" style="margin-top: 15px;">
				<?php
				echo $this->Form->input('User.contact_address',array(
					'div'=>array('class'=>'control-group span12'),
					'label'=>'Address',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));		
				?>
				</div>
				<div class="row-fluid">
				<?php
	
				echo $this->Form->input('User.contact_city',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'City',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));	
				echo $this->Form->input('User.contact_state',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'State',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12'
				));		
				echo $this->Form->input('User.contact_zip',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'Postal Code',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12'
				));	
				?>
	
			    </div>
		    
		   		<div class="row-fluid">
			  	<?php
			  	echo $this->Form->input('User.contact_email',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Email',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));	
			  	echo $this->Form->input('User.contact_phone',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Phone Number',
				
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));			
			}		  	
			  	?>
			  	<span style="font-style: italic; font-size: 12px; color: #999; float: right;">* denotes a required field.</span>

				</div>
					<input id="new_user" type="hidden" value="<?php echo $show_value;?>" name="data[NEW_USER]"/>

				
				</div>
		
			<?php				
			
			?>
			
			
			<? //---------------------------------------------------------------------------------------------------------- ?>
			
			<div class="span6 well">
				<!-- 
		<?php
		//send payments to payment processing method
		echo $this->Form->create('Payment', array('url'=>$this->Html->url(array('controller'=>'reservations', 'action'=>'payments'))));
		?> -->
		<div class="card method-type">
		<?php
		echo $this->Form->input('Payment.payment_method',array('type'=>'hidden','value'=>'card-not-present'));
		?>
		  <h2>Credit Card Information <img src="/img/frontend/cc.png" style="margin-left: 15px;"></h2>
		  <div class="billing simple">
		
		    <div class="row-fluid">
		    <?php
			echo $this->Form->input('Payment.vdata', array(
				'div'=>array('class'=>'span6 control-group'),
				'label'=>'Card Number *',
				'style'=>'margin-left:0px;',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'value'=>$vdata
			));
			echo $this->Form->input('Payment.card_full_name', array(
				'div'=>array('class'=>'span6 control-group'),
				'label'=>'Name on Card *',
				'style'=>'margin-left:0px;',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'value'=>$card_full_name
			));
		    ?>
		    </div>
		
		    <div class="row-fluid">
		    <?php
			echo $this->Form->input('Payment.card_cvv', array(
				'div'=>array('class'=>'span4 control-group'),
				'label'=>'CVV *',
				'style'=>'margin-left:0px;',
				'placeholder'=>'3 or 4 digit code',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'value'=>$card_cvv
			));	
				    
		    ?>
		      <div class="span4"> 
		        <label class="control-label" for="card_expires">Expiration date *</label>
		        <div class="row-fluid">
		        <?php
		        $card_months = array(
		        	'01'=>'1 - Jan',
		        	'02'=>'2 - Feb',
		        	'03'=>'3 - Mar',
		        	'04'=>'4 - Apr',
		        	'05'=>'5 - May',
		        	'06'=>'6 - Jun',
		        	'07'=>'7 - Jul',
		        	'08'=>'8 - Aug',
		        	'09'=>'9 - Sep',
		        	'10'=>'10 - Oct',
		        	'11'=>'11 - Nov',
		        	'12'=>'12 - Dec',					
				);
				echo $this->Form->input('Payment.card_expires_month', array(
					'div'=>array('class'=>'span6 control-group'),
					'label'=>false,
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'options'=>$card_months,
					'value'=>date('m'),
					'default'=>$card_expires_month,
				));	
				$card_years = array();	
				for ($i=date('Y'); $i <= (date('Y')+10); $i++) { 
					$card_years[substr($i,-2)] = $i;
				}
				echo $this->Form->input('Payment.card_expires_year', array(
					'div'=>array('class'=>'span6 control-group'),
					'label'=>false,
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'options'=>$card_years,
					'value'=>substr(date('Y'),-2),
					'default'=>$card_expires_year
				));				        
		        ?>

		        </div> 
		      </div>  
		    </div>
		
		  </div><!-- End of "billing" -->
		</div><!-- End of "end card" -->
				
		
		<h2 style="margin-top: 50px;">
			<span style="float: left;">Billing Information </span>
			
			<label class="checkbox" style="font-family: arial, serif;
				font-weight: normal;
				text-transform: none;
				font-style: italic;
				color: #999;
				display: inline-block;
				margin-left: 15px;">
			<input id="oldValuesCheckbox" type="checkbox" > Same address as previous page
			</label>
			<span style="clear: both;"></span>
		</h2>  
		<div id="billingContactDiv" class="contact simple">
		<?php
		

		
		?>
		
		    <div class="row-fluid">
			<?php
			echo $this->Form->input('contact_address', array(
				'div'=>array('class'=>'span12 control-group'),
				'label'=>false,
				'before'=>'<label class="control-label">Billing Address *</label><div class="controls">',
				'after'=>'</div>',
				'value'=>$contact_address,
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'style'=>'margin-left:0'
			));				
			
			?>
		    </div>    
		    <div class="row-fluid">
			<?php
			echo $this->Form->input('contact_city', array(
				'div'=>array('class'=>'span6 control-group'),
				'label'=>false,
				'before'=>'<label class="control-label">City *</label><div class="controls">',
				'after'=>'</div>',
				'value'=>$contact_city,
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'style'=>'margin-left:0'
			));				
			echo $this->Form->input('contact_state', array(
				'div'=>array('class'=>'span3 control-group'),
				'label'=>false,
				'before'=>'<label class="control-label">State/Province *</label><div class="controls">',
				'after'=>'</div>',
				'value'=>$contact_state,
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'style'=>'margin-left:0'
			));
			echo $this->Form->input('contact_zip', array(
				'div'=>array('class'=>'span3 control-group'),
				'label'=>false,
				'before'=>'<label class="control-label">ZIP/Postal Code *</label><div class="controls">',
				'after'=>'</div>',
				'value'=>$contact_zip,
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'style'=>'margin-left:0'
			));						
			?>
		    </div>
		
		</div><!-- End of "contact" -->
		<?	if($group_id != 0 && $group_id !=3) { ?>

			<div class="control-group">
			    <label class="checkbox">
			      <input id="terms" type="hidden" name="data[Payment][terms]" value="Yes" checked="checked">
			    </label>  
			    <span class="help-block"></span>					
			</div>
			<br/>
	  		<div class="control-group">
	 		    <label class="checkbox">
			      <input id="newsletter" type="checkbox"> Yes! I'd like to sign up for the e-mail newsletter.
			    </label> 	
			    <span class="help-block"></span>		
	  		</div>
  		
  		<? } else { ?>
			<div class="control-group">
			    <label class="checkbox">
			      <input id="terms" type="checkbox" name="data[Payment][terms]" value="Yes"> I agree to the <a href="/terms-and-conditions" target="_blank">Terms and Conditions</a>
			    </label>  
			    <span class="help-block"></span>					
			</div>
			<br/>
	  		<div class="control-group">
	 		    <label class="checkbox">
			      <input id="newsletter" type="checkbox" checked="checked"> Yes! I'd like to sign up for the e-mail newsletter.
			    </label> 	
			    <span class="help-block"></span>		
	  		</div>		
  		<? } ?>


<?php
echo $this->Form->submit('Submit Reservation', array('class'=>'submitForm btn btn-success pull-right','style'=>'margin-top:30px;'));
?>
	
				
			</div>			
			
	</div>
	<div>
		<button id="removeTravelerSession" type="button" class="btn btn-danger">Clear Form</button>
	</div>
</div>
	<?echo $this->Form->end(); ?>
