<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form',
	'frontend/bootstrap-toggle-buttons'
	),
	'stylesheet',
	array('inline'=>false)
);
$customer_id = $deliveries['User']['customer_id'];
$first_name = $deliveries['User']['first_name'];
$last_name = $deliveries['User']['last_name'];
$phone = $deliveries['User']['phone'];
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
		<table class="table table-bordered span8">

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
			<button class="btn btn-link">Restart Delivery Form</button>	
		</div>
		
	</div>
	
	<!-- customer payment info -->
	<fieldset class="sixteen columns alpha well well-small">
		<h3>Payment Information - <span>required for all deliveries.</span></h3>
		<div class="alert alert-info">
			All delivery require payment information...(finish statement)
		</div>
		<?php
		if($display_payment == 'Yes'){ 
			echo $this->Form->create('Delivery'); 
			
		?>
			<div class="row">
			<?php
			echo $this->Form->input('card_full_name',array(
				'label'=>'Name on Card <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group eight columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'Full name as it appears on your credit card',
	
			));					
			?>
			</div>
			<div class="row">
			<?php
			echo $this->Form->input('ccnum',array(
				'label'=>'Credit Card Number <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group eight columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'credit card number as it is shown on your card',

			));					
			?>
			</div>
			<div class="row">
			<?php
			echo $this->Form->input('exp_month',array(
				'label'=>'Expired Month <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group two columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'mm',

			));		
			echo $this->Form->input('exp_year',array(
				'label'=>'Expired Year <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group two columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'yyyy',
	
			));					
			echo $this->Form->input('cvv',array(
				'label'=>'CVV <span class="f_req">*</span>',
				'div'=>array('class'=>'control-group two columns alpha'),
				'after'=>'<span class="help-block"></span>',
				'error'=>array('attributes' => array('class' => 'help-block')),
				'placeholder'=>'ex. 123',
	
			));				
		
			?>
			</div>
			<div class="row">
				<input type="submit" class="btn btn-primary btn-large pull-right" value="Make Delivery"/>
			</div>
		<?php 
			echo $this->Form->end(); 
		} else {
		?>
		Payment information has been saved
		<?php	
		}	
		?>	
	</fieldset>

</div>