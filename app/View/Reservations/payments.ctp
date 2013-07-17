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
	'frontend/reservation_payments', //jquery-ui file
	),
	FALSE
);


//displays a message bar if the user has not logged in, before accessing. Uses auth->authError variable set in controller
echo $this->TwitterBootstrap->flashes(array(
    "auth" => true,
    "closable"=>false
    )
);

?>

<div class="container">

	<div class="row">
		<div class="sixteen columns">
			<div class="page_heading checkout"><h1>Payment Information</h1>
				<img src="/img/icons/done.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/review.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/payment-active.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/traveler.png" class="pull-right" style="margin-left: 10px;" />
			</div>
		</div>		
	</div>

<div class="row">
	<div class="ten columns">
		<?php
//send payments to payment processing method
echo $this->Form->create('Payment', array('url'=>$this->Html->url(array('controller'=>'reservations', 'action'=>'payments'))));
?>
		<div class="card method-type">
		<?php
		echo $this->Form->input('payment_method',array('type'=>'hidden','value'=>'card-not-present'));
		?>
		  <h2>Credit Card Information <img src="/img/frontend/cc.png" style="margin-left: 15px;"></h2>
		  <div class="billing simple">
		
		    <div class="row-fluid">
		    <?php
			echo $this->Form->input('vdata', array(
				'div'=>array('class'=>'span6 control-group'),
				'label'=>'Card Number *',
				'style'=>'margin-left:0px;',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
			));
			echo $this->Form->input('card_full_name', array(
				'div'=>array('class'=>'span6 control-group'),
				'label'=>'Name on Card *',
				'style'=>'margin-left:0px;',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
			));
		    ?>
		    </div>
		
		    <div class="row-fluid">
		    <?php
			echo $this->Form->input('card_cvv', array(
				'div'=>array('class'=>'span4 control-group'),
				'label'=>'CVV *',
				'style'=>'margin-left:0px;',
				'placeholder'=>'3 or 4 digit code',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
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
				echo $this->Form->input('card_expires_month', array(
					'div'=>array('class'=>'span6 control-group'),
					'label'=>false,
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'options'=>$card_months,
					'value'=>date('m')
				));	
				$card_years = array();	
				for ($i=date('Y'); $i <= (date('Y')+10); $i++) { 
					$card_years[substr($i,-2)] = $i;
				}
				echo $this->Form->input('card_expires_year', array(
					'div'=>array('class'=>'span6 control-group'),
					'label'=>false,
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'options'=>$card_years,
					'value'=>substr(date('Y'),-2),
				));				        
		        ?>

		        </div> 
		      </div>  
		    </div>
		
		  </div><!-- End of "billing" -->
		</div><!-- End of "end card" -->
		
		<div class="check method-type" style="display:none;" >
		  <h2>Check/ACH Information</h2>
		  <div class="billing">
		
		
		    <div class="row-fluid">
		      <div class="span4"> 
		        <label class="control-label" for="ach_routing_number">Routing Number</label> 
		        <div class="controls"> 
		          <input class="span12" id="ach_routing_number" name="data[Payment][ach_routing_number]" type="text" />
		          <span class="help-block">Usually a 9 digit number.</span>
		        </div> 
		      </div> 
		      <div class="span4"> 
		        <label class="control-label" for="ach_account_number">Account number</label> 
		        <div class="controls"> 
		          <input class="span12" id="ach_account_number" name="data[Payment][ach_account_number]" type="text" />
		          <span class="help-block">Usually a 12 digit number.</span>
		        </div> 
		      </div>  
		      <div class="span4"> 
		        <label class="control-label" for="ach_account_type">Account type</label> 
		        <div class="controls"> 
		          <select class="span12" id="ach_account_type" name="data[Payment][ach_account_type]">
		            <option value="checking">Checking</option>
		            <option value="savings">Savings</option>
		          </select>
		        </div> 
		      </div> 
		    </div>
		
		    <div class="row-fluid">
		      <div class="span6"> 
		        <label class="control-label" for="ach_first_name">First Name on Account</label> 
		        <div class="controls"> 
		          <input class="span12" id="ach_first_name" name="data[Payment][ach_first_name]" type="text" />
		        </div> 
		      </div> 
		      <div class="span6"> 
		        <label class="control-label" for="ach_last_name">Last Name on Account</label> 
		        <div class="controls"> 
		          <input class="span12" id="ach_last_name" name="data[Payment][ach_last_name]" type="text" />
		        </div> 
		      </div> 
		    </div>
		
		  </div><!-- End of "billing" -->
		</div><!-- End of "check" -->
		
		
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
		
		if(!empty($_SESSION['Reservation_travelers'])){
			$rt = $_SESSION['Reservation_travelers'];
			$billing_address = $rt['contact_address'];
			$billing_city = $rt['contact_city'];
			$billing_state = $rt['contact_state'];
			$billing_zip = $rt['contact_zip'];
		} else {
			$billing_address = '';
			$billing_city = '';
			$billing_state = '';
			$billing_zip = '';			
		}
		
		?>
		
		    <div class="row-fluid">
			<?php
			echo $this->Form->input('contact_address', array(
				'div'=>array('class'=>'span12 control-group'),
				'label'=>false,
				'before'=>'<label class="control-label">Billing Address *</label><div class="controls">',
				'after'=>'</div>',
				'old'=>$billing_address,
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
				'old'=>$billing_city,
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'style'=>'margin-left:0'
			));				
			echo $this->Form->input('contact_state', array(
				'div'=>array('class'=>'span3 control-group'),
				'label'=>false,
				'before'=>'<label class="control-label">State/Province *</label><div class="controls">',
				'after'=>'</div>',
				'old'=>$billing_state,
				'error'=>array('attributes' => array('class' => 'help-block')),
				'class'=>'span12',
				'style'=>'margin-left:0'
			));
			echo $this->Form->input('contact_zip', array(
				'div'=>array('class'=>'span3 control-group'),
				'label'=>false,
				'before'=>'<label class="control-label">ZIP/Postal Code *</label><div class="controls">',
				'after'=>'</div>',
				'old'=>$billing_zip,
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
			      <input id="newsletter" type="checkbox" value="Yes" name="data[Payment][newsletter]"> Yes! I'd like to sign up for the e-mail newsletter.
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
			      <input id="newsletter" type="checkbox" value="Yes" name="data[Payment][newsletter]" checked="checked"> Yes! I'd like to sign up for the e-mail newsletter.
			    </label> 	
			    <span class="help-block"></span>		
	  		</div>		
  		<? } ?>


<?php
if($group_id != 0 && $group_id !=3) {echo $this->Form->submit('Review Booking', array('class'=>'submitForm btn btn-bbfl','style'=>'margin-top:30px;'));}
else {echo $this->Form->submit('Review Booking', array('disabled'=>'disabled','class'=>'submitForm btn btn-bbfl','style'=>'margin-top:30px;'));}
echo $this->Form->end();
?>
	</div>

<?php
echo $this->element('/reservations/billing_summary',array(
	'group_admin'=>$group_admin,
	'ferry_sidebar'=>$ferry_sidebar,
	'hotel_sidebar'=>$hotel_sidebar,
	'attraction_sidebar'=>$attraction_sidebar,
	'package_sidebar'=>$package_sidebar
));
?>

</div>

