<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form',
	'frontend/bootstrap-toggle-buttons',
	'frontend/mobile_devices_tables'
	),
	'stylesheet',
	array('inline'=>false)
);
$customer_id = $deliveries['User']['id'];
$first_name = $deliveries['User']['first_name'];
$last_name = $deliveries['User']['last_name'];
$phone = $deliveries['User']['contact_phone'];
$email = $deliveries['User']['contact_email'];
$address = $deliveries['User']['contact_address'];
$suite = $deliveries['User']['contact_suite'];
$city = $deliveries['User']['contact_city'];
$state = $deliveries['User']['contact_state'];
$zip = $deliveries['User']['contact_zip'];
$special_instructions = $deliveries['User']['special_instructions'];
$dropoff_date = date('D n/d/Y',strtotime($deliveries['Schedule']['dropoff_date']));
$pickup_date = date('D n/d/Y',strtotime($deliveries['Schedule']['pickup_date']));

?>

<div class="container">
	<div class="well well-small sixteen columns alpha">
		<h2>Delivery Information</h2>
		<table class="table table-bordered">

			<tr >
				<th>Full Name</th>
				<td><?php echo $first_name.' '.$last_name;?></td>	
			</tr>
			<tr>
				<th>Address</th>
				<td><?php echo $address.'</br>'.$city.', '.$state.' '.$zip;?></td>
			</tr>
			<tr>
				<th>Phone</th>
				<td><?php echo $phone;?></td>
			</tr>	
			<tr>
				<th>Email</th>
				<td><?php echo $email;?></td>
			</tr>	
			<tr >
				<th>Pickup Date & Time</th>
				<td><?php echo $pickup_date.' @ '.$pickup_time;?></td>	
			</tr>
			
			<tr >
				<th>Dropoff Date & Time</th>
				<td><?php echo $dropoff_date.' @ '.$dropoff_time;?></td>	
			</tr>	
			<tr>
				<th>Special Instructions</th>
				<td><?php echo $special_instructions;?></td>
			</tr>	

		</table>
		<div class="sixteen columns alpha">
			<a class="btn btn-link" href="/deliveries/restart">Restart Delivery Form</a>	
		</div>
		
	</div>
	
	<!-- customer payment info -->
	<fieldset class="sixteen columns alpha well well-small">
		<h3>Payment Information - <span>required for all deliveries.</span></h3>
		<?php
		$payment_class = '';
		if(isset($_SESSION['payment_error'])){
			$payment_class = 'error';	
			$payment_message = $_SESSION['payment_error']['response'];
			?>
			<div class="alert alert-error">
				<?php
				echo $payment_message;
				?>
			</div>				
			<?php
			
		} else {
		?>
		<div class="alert alert-info">
			Payment Information is required prior to delivery.  Payment Information can be saved securely for future use or deleted at any time.
		</div>		
		<?php
		}
		echo $this->Form->create();
			//echo $this->Form->create('Delivery',array('action'=>'/process_final_delivery_form')); 
		if($display_payment == 'Yes'){ 
			
		?>
			<input type="hidden" name="data[Payment][saved_profile]" value="No"/>
			<div class="row">
			<?php
			echo $this->Form->input('Payment.card_full_name',array(
				'label'=>'Name on Card <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group eight columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'Full name as it appears on your credit card',
				'required'=>'required',
	
			));					
			?>
			</div>
			<div class="row">
			<?php
			echo $this->Form->input('Payment.ccnum',array(
				'label'=>'Credit Card Number <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group eight columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'credit card number as it is shown on your card',
				'required'=>'required',

			));					
			?>
			</div>
			<div class="row">
			<?php
			echo $this->Form->input('Payment.exp_month',array(
				'label'=>'Expired Month <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group two columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'mm',
				'required'=>'required',
				'maxlength'=>2

			));		
			echo $this->Form->input('Payment.exp_year',array(
				'label'=>'Expired Year <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group two columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'yyyy',
				'required'=>'required',
				'maxlength'=>4
	
			));					
			echo $this->Form->input('Payment.cvv',array(
				'label'=>'CVV <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group two columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'ex. 123',
				'required'=>'required',
				'maxlength'=>5
	
			));				
		
			?>
			</div>
			<div class="control-group clearfix">
				<label class="checkbox"><input type="checkbox" value="Yes" name="data[Payment][payment_status]"/> I would like to save my payment information for future visits.</label>
			</div>
		<?php
		} else {
		?>
		<input type="hidden" value="Yes" name="data[Payment][saved_profile]"/>
		<p>Payment information has already been saved. You may make the delivery request. </p>
		<div class="control-group clearfix">
			<label class="checkbox"><input type="checkbox" value="No" name="data[Payment][payment_status]"/> I would like to stop saving my payment information.</label>
		</div>		
		<?php	
		}	
		?>	
			<div class="AuthorizeNetSeal"> 
				<script type="text/javascript" language="javascript">
					var ANS_customer_id="8db8623d-f12e-4284-978d-7eb301be912e";
				</script> 
				<script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> 
				<a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Payment Gateway</a> 
			</div>
			<div class="row">
				<input type="submit" class="btn btn-primary btn-large pull-right" value="Make Delivery"/>
			</div>
		<?php 
			echo $this->Form->end(); 
		?>
	</fieldset>

</div>
<?php
unset($_SESSION['payment_error']);
?>