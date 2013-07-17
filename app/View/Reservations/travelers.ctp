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
	'frontend/reservation_travelers.js', //jquery-ui file
	),
	FALSE
);
if($Logged == 'Yes'){
	$first_name = $users['first_name'];
	$last_name = $users['last_name'];
	$middle_initial = $users['middle_initial'];
	$birthdate = $users['birthdate'];
	$doy = date('Y',strtotime($birthdate));
	$dom = date('n',strtotime($birthdate));
	$dod = date('d',strtotime($birthdate));
	$citizenship = $users['citizenship'];
	$doctype = $users['doctype'];
	$docnumber = $users['docnumber'];
	$contact_address = $users['contact_address'];
	$contact_city = $users['contact_city'];
	$contact_state = $users['contact_state'];
	$contact_email = $users['contact_email'];
	$contact_zip = $users['contact_zip'];
	$contact_phone = $users['contact_phone'];
	$checkout_type = 'Confirm Guest Details';
	$show_new_user = 'hide';
	$show_div = 'hide';
} else {
	$first_name = '';
	$last_name = '';
	$middle_initial = '';
	$birthdate = '';
	$citizenship = '';
	$doctype = '';
	$docnumber = '';
	$contact_address = '';
	$contact_city = '';
	$contact_state = '';
	$contact_email = '';
	$contact_zip = '';
	$contact_phone = '';
	$doy = '';
	$dom = '';
	$dod = '';
	$checkout_type = 'Guest Checkout';
	$show_new_user = '';
	$show_div = 'hide';
}
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


?>

<div class="container">
	
	<div class="row">
		<div class="sixteen columns alpha">
			<div class="page_heading checkout"><h1>Traveler Information</h1>
				<img src="/img/icons/done.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/review.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/payment.png" class="pull-right" style="margin-left: 10px;" />
				<img src="/img/icons/traveler-active.png" class="pull-right" style="margin-left: 10px;" />
			</div>
		</div>		
	</div>

	<div class="row">
		<div class="eight columns alpha">
		<?php
		//if the group id is not a guest or a customer show the employee form
		if($group_id != 0 && $group_id !=3){
			?>
			<h3>Logged in as an Admin/Employee</h3>
			<p>Employee Username: <strong><?php echo $employee_username;?></strong></p>
			<p>Employee Type: <strong><?php echo $group_name;?></strong></p>
			<?php
		} else { //this is either a customer or a guest
			if($Logged == 'No'):
			?>
			
			<h2>Login to your account</h2>
			<p style="font-size: 12px;font-style: italic;padding-right: 100px;display: block;line-height: 16px;color: #888;">
				<strong>Note:</strong> :  If you have already created an account on this new system, you may log in in here.  If you had an account on our old system, those login credentials will unfortunately not be valid on this new system.  We apologize for the inconvenience.  If you wish to create an account on this new system for future use, you may do so by inputting your information in the Guest Checkout area to the right, and checking the “Click here to save as a new user” checkbox at the bottom.
			</p>
			<?php
			echo $this->Form->create('User', array('url'=>$this->Html->url(array('controller'=>'reservations', 'action'=>'login'))));
			?>
				<div class="row-fluid">
				<?php
				echo $this->Form->input('username_log',array(
					'div'=>array('class'=>'span6 control-group'),
					'label'=>array('class'=>'control-label'),
					'before'=>'<div class="controls">',
					'after'=>'</div>',
					'class'=>'span12',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'style'=>'margin-left:0px;'
				));
				?>
				</div>
				<div class="row-fluid">
				<?php
				echo $this->Form->input('password_log',array(
					'div'=>array('class'=>'span6 control-group'),
					'type'=>'password',
					'label'=>array('class'=>'control-label'),
					'before'=>'<div class="controls">',
					'after'=>'</div>',
					'class'=>'span12',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'style'=>'margin-left:0px;'
				));
				?>

			   	</div> 
				
			
				<input type="submit" class="btn btn-bbfl" value="Login" style="margin-top:10px"/>				
			<?php
			//end the login form
			echo $this->Form->end();
			?>
			<div>
				<?php
				echo $this->Html->link('Forgot password?',array('controller'=>'users','action'=>'forgot'));
				?>
			</div>
			<?php
			else:
			?>
			<h2>Welcome Back, <? echo $first_name; ?>!</h2>
			<p>Logged in as: <strong><?php echo $username;?></strong></p>
			<p><a href="/reservations/logout" class="btn btn-bbfl">Logout</a></p>
			<?php
			endif;			
				
		}
		?>
		</div>
		<div class="eight columns omega">
		
			<h2><?php echo $checkout_type;?></h2>
			<?php
			echo $this->Form->create('User', array('url'=>$this->Html->url(array('controller'=>'reservations', 'action'=>'travelers'))));
			
			if($group_id != 0 && $group_id != 3){
				//check to see if this is a post validated form or a non post validated form. 
				//if the form is post validated remove all the values from the form else keep the values
				if($post_form == 'NO'){
				?>
					
					<div class="row-fluid">
					<?php
					echo $this->Form->input('first_name',array(
						'div'=>array('class'=>'control-group span5'),
						'label'=>'First Name *',
						'class'=>'span12',
						'style'=>'margin-left:0px;',
						'error'=>array('attributes' => array('class' => 'help-block')),

					));	
	
					echo $this->Form->input('middle_initial',array(
					
						'div'=>array('class'=>'control-group span1'),
						'label'=>'Init',
						'before'=>'<div class="controls">',
						'after'=>'</div>',
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',

					));	
					echo $this->Form->input('last_name',array(
						'div'=>array('class'=>'control-group span5'),
						'label'=>'Last Name *',
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',

					));				
					?>
				    </div>
					
					<div class="row-fluid">
						<div class="span12"><label class="control-label" for="TravelerDOB">Date of Birth *</label> </div>
				    </div> 
					
					<div class="row-fluid">
				    <?php
	
					echo $this->Form->input('dobm',array(
						'div'=>array('class'=>'control-group span4 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'id'=>'TravelerDOBM',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',
						'options'=>$months,

					));	
	
					echo $this->Form->input('dobd',array(
						'div'=>array('class'=>'control-group span2 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'id'=>'TravelerDOBD',
						'options'=>$days,

					));	
					$years = array('NONE'=>'');
					for ($i=date('Y'); $i >= (date('Y')-100) ; $i--) { 
						$years[$i] = $i;
					}
					echo $this->Form->input('doby',array(
						'div'=>array('class'=>'control-group span3 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'id'=>'TravelerDOBY',
						'options'=>$years,
	
					));
				    ?>
				    </div>
	
					
					<div class="row-fluid">
					<?php
	
					echo $this->Form->input('citizenship',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Citizenship *',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'class'=>'req',
						'options'=>$countries,

					));				
					
					$documents = array(
						'NONE'=>'',
						'Passport'=>'Passport',
						'Permanent Resident Card'=>'Permanent Resident Card',
						'Enchanced Drivers License'=>'Enhanced Drivers License',
						'Other'=>'Other'
					);
					echo $this->Form->input('doctype',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Document Type *',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'class'=>'req',
						'options'=>$documents,

					));		
					echo $this->Form->input('docnumber',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Document Number',
						'error'=>array('attributes' => array('class' => 'help-block')),

					));				
					?>
	
				    </div>
				    
				<div class="row-fluid" style="margin-top: 15px;">
				<?php
				echo $this->Form->input('contact_address',array(
					'div'=>array('class'=>'control-group span12'),
					'label'=>'Address *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',

				));		
				?>
				</div>
				<div class="row-fluid">
				<?php
	
				echo $this->Form->input('contact_city',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'City *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',

				));	
				echo $this->Form->input('contact_state',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'State/Province *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',

				));		
				echo $this->Form->input('contact_zip',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'ZIP/Postal Code *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',

				));	
				?>
	
			    </div>
			    
			    <div class="row-fluid">
			  	<?php
			  	echo $this->Form->input('contact_email',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Email *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',

				));	
			  	echo $this->Form->input('contact_phone',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Phone Number *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',

				));	
			} else {
				?>
					
				<div class="row-fluid">
				<?php
				echo $this->Form->input('first_name',array(
					'div'=>array('class'=>'control-group span5'),
					'class'=>'span12',
					'style'=>'margin-left:0px;',
					'error'=>array('attributes' => array('class' => 'help-block'))
				));	

				echo $this->Form->input('middle_initial',array(
				
					'div'=>array('class'=>'control-group span1'),
					'label'=>'Init',
					'before'=>'<div class="controls">',
					'after'=>'</div>',
					'class'=>'span12',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'style'=>'margin-left:0px;'
				));	
				echo $this->Form->input('last_name',array(
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

				echo $this->Form->input('dobm',array(
					'div'=>array('class'=>'control-group span4 pull-left'),
					'label'=>false,
					'class'=>'span12',
					'id'=>'TravelerDOBM',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'style'=>'margin-left:0px;',
					'options'=>$months
				));	

				echo $this->Form->input('dobd',array(
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
				echo $this->Form->input('doby',array(
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

				echo $this->Form->input('citizenship',array(
					'div'=>array('class'=>'control-group span4'),
					'label'=>'Citizenship',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'req',
					'options'=>$countries
				));				
				
				$documents = array(
					'NONE'=>'',
					'Passport'=>'Passport',
					'Permanent Resident Card'=>'Permanent Resident Card',
					'Enchanced Drivers License'=>'Enhanced Drivers License',
					'Other'=>'Other'
				);
				echo $this->Form->input('doctype',array(
					'div'=>array('class'=>'control-group span4'),
					'label'=>'Document Type',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'req',
					'options'=>$documents
				));		
				echo $this->Form->input('docnumber',array(
					'div'=>array('class'=>'control-group span4'),
					'label'=>'Document Number',
					'error'=>array('attributes' => array('class' => 'help-block'))
				));				
				?>

			    </div>
			    
				<div class="row-fluid" style="margin-top: 15px;">
				<?php
				echo $this->Form->input('contact_address',array(
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
	
				echo $this->Form->input('contact_city',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'City',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));	
				echo $this->Form->input('contact_state',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'State',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12'
				));		
				echo $this->Form->input('contact_zip',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'Postal Code',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12'
				));	
				?>
	
			    </div>
		    
		   		<div class="row-fluid">
			  	<?php
			  	echo $this->Form->input('contact_email',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Email',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));	
			  	echo $this->Form->input('contact_phone',array(
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
					<input type="submit" value="Continue Booking" style="margin-top:30px" class="btn btn-bbfl"/>			
				<?php					
			} else {
				//check to see if this is a post validated form or a non post validated form. 
				//if the form is post validated remove all the values from the form else keep the values
				if($post_form == 'NO'){
				?>
					
					<div class="row-fluid">
					<?php
					echo $this->Form->input('first_name',array(
						'div'=>array('class'=>'control-group span5'),
						'label'=>'First Name *',
						'class'=>'span12',
						'style'=>'margin-left:0px;',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'value'=>$first_name
					));	
	
					echo $this->Form->input('middle_initial',array(
					
						'div'=>array('class'=>'control-group span1'),
						'label'=>'Init',
						'before'=>'<div class="controls">',
						'after'=>'</div>',
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',
						'value'=>$middle_initial
					));	
					echo $this->Form->input('last_name',array(
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
					
					<div class="row-fluid">
				    <?php
	
					echo $this->Form->input('dobm',array(
						'div'=>array('class'=>'control-group span4 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'id'=>'TravelerDOBM',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',
						'options'=>$months,
						'value'=>$dom
					));	
	
					echo $this->Form->input('dobd',array(
						'div'=>array('class'=>'control-group span2 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'id'=>'TravelerDOBD',
						'options'=>$days,
						'value'=>$dod
					));	
					$years = array('NONE'=>'');
					for ($i=date('Y'); $i >= (date('Y')-100) ; $i--) { 
						$years[$i] = $i;
					}
					echo $this->Form->input('doby',array(
						'div'=>array('class'=>'control-group span3 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'id'=>'TravelerDOBY',
						'options'=>$years,
						'value'=>$doy
					));
				    ?>
				    </div>
	
					
					<div class="row-fluid">
					<?php
	
					echo $this->Form->input('citizenship',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Citizenship *',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'class'=>'req',
						'options'=>$countries,
						'value'=>$citizenship
					));				
					
					$documents = array(
						'NONE'=>'',
						'Passport'=>'Passport',
						'Permanent Resident Card'=>'Permanent Resident Card',
						'Enchanced Drivers License'=>'Enhanced Drivers License',
						'Other'=>'Other'
					);
					echo $this->Form->input('doctype',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Document Type *',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'class'=>'req',
						'options'=>$documents,
						'value'=>$doctype
					));		
					echo $this->Form->input('docnumber',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Document Number',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'value'=>$docnumber
					));				
					?>
	
				    </div>
				    
				<div class="row-fluid" style="margin-top: 15px;">
				<?php
				echo $this->Form->input('contact_address',array(
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
	
				echo $this->Form->input('contact_city',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'City *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',
					'value'=>$contact_city
				));	
				echo $this->Form->input('contact_state',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'State/Province *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'value'=>$contact_state
				));		
				echo $this->Form->input('contact_zip',array(
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
			  	echo $this->Form->input('contact_email',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Email *',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px',
					'value'=>$contact_email
				));	
			  	echo $this->Form->input('contact_phone',array(
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
					echo $this->Form->input('first_name',array(
						'div'=>array('class'=>'control-group span5'),
						'class'=>'span12',
						'style'=>'margin-left:0px;',
						'error'=>array('attributes' => array('class' => 'help-block'))
					));	
	
					echo $this->Form->input('middle_initial',array(
					
						'div'=>array('class'=>'control-group span1'),
						'label'=>'Init',
						'before'=>'<div class="controls">',
						'after'=>'</div>',
						'class'=>'span12',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;'
					));	
					echo $this->Form->input('last_name',array(
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
	
					echo $this->Form->input('dobm',array(
						'div'=>array('class'=>'control-group span4 pull-left'),
						'label'=>false,
						'class'=>'span12',
						'id'=>'TravelerDOBM',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px;',
						'options'=>$months
					));	
	
					echo $this->Form->input('dobd',array(
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
					echo $this->Form->input('doby',array(
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
	
					echo $this->Form->input('citizenship',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Citizenship',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'class'=>'req',
						'options'=>$countries
					));				
					
					$documents = array(
						'NONE'=>'',
						'Passport'=>'Passport',
						'Permanent Resident Card'=>'Permanent Resident Card',
						'Enchanced Drivers License'=>'Enhanced Drivers License',
						'Other'=>'Other'
					);
					echo $this->Form->input('doctype',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Document Type',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'class'=>'req',
						'options'=>$documents
					));		
					echo $this->Form->input('docnumber',array(
						'div'=>array('class'=>'control-group span4'),
						'label'=>'Document Number',
						'error'=>array('attributes' => array('class' => 'help-block'))
					));				
					?>
	
				    </div>
				    
				<div class="row-fluid" style="margin-top: 15px;">
				<?php
				echo $this->Form->input('contact_address',array(
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
	
				echo $this->Form->input('contact_city',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'City',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));	
				echo $this->Form->input('contact_state',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'State',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12'
				));		
				echo $this->Form->input('contact_zip',array(
					'div'=>array('class'=>'control-group span3'),
					'label'=>'Postal Code',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12'
				));	
				?>
	
			    </div>
			    
			    <div class="row-fluid">
			  	<?php
			  	echo $this->Form->input('contact_email',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Email',
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));	
			  	echo $this->Form->input('contact_phone',array(
					'div'=>array('class'=>'control-group span6'),
					'label'=>'Phone Number',
				
					'error'=>array('attributes' => array('class' => 'help-block')),
					'class'=>'span12',
					'style'=>'margin-left:0px'
				));			
			}		  	
			  	?>
			  	<span style="font-style: italic; font-size: 12px; color: #999; float: right;">* denotes a required field.</span>
			     <div class="control-group <?php echo $show_new_user;?>">
			     	<label class="checkbox"><input id="showNewUser" type="checkbox" value="yes" <?php echo $show_checked;?>/> Click here to save as a new user</label>
			     </div>
				<?php
				if($removeBlock == 'No'){
				?>
			     <div class="newUserDiv form-actions <?php echo $show_div;?>">
			     	
			     	<h3>New User Setup</h3>
			     	<?php
					echo $this->Form->input('username',array(
						'div'=>array('class'=>'span12 control-group'),
						'label'=>'Enter Username',
						'class'=>'span12 userInputUsername',
						'disabled'=>'disabled',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px'
					));
					echo $this->Form->input('password',array(
						'div'=>array('class'=>'span12 control-group'),
						'label'=>'Enter Password',
						'class'=>'span12 userInputPassword',
						'disabled'=>'disabled',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px'
					));
					echo $this->Form->input('retypePassword',array(
						'div'=>array('class'=>'span12 control-group'),
						'label'=>'Re-enter Password',
						'type'=>'password',
						'class'=>'span12 userInputRetypePassword',
						'disabled'=>'disabled',
						'error'=>array('attributes' => array('class' => 'help-block')),
						'style'=>'margin-left:0px'
					));
			     	?>
	
			     </div>
				<?php
				}
				?>
				</div>
					<input id="new_user" type="hidden" value="<?php echo $show_value;?>" name="data[NEW_USER]"/>
					<input type="submit" value="Continue Booking" style="margin-top:30px" class="btn btn-bbfl"/>			
			<?php				
			}
	
			echo $this->Form->end();
			?>
			</div>
	</div>
