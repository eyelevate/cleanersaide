<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/.js'),FALSE);

echo $this->Form->create();
?>
<div class="row-fluid">
	<h1 class="heading">Add Delivery Route</h1>
	<div id="accordion_delivery" class="accordion">

		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-monday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Monday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-monday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Deliveries.0.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						
					));
					echo $this->Form->input('Deliveries.0.start_time');
					echo $this->Form->input('Deliveries.0.end_time');
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Deliveries.0.zipcode',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Deliveries.0.blackout',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						
					</div>
			
				</div>
			</div>
		</div>		
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-tuesday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Tuesday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-tuesday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Deliveries.1.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						
					));
					echo $this->Form->input('Deliveries.1.start_time');
					echo $this->Form->input('Deliveries.1.end_time');
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Deliveries.1.zipcode',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Deliveries.1.blackout',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						
					</div>				
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-wednesday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Wednesday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-wednesday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Deliveries.2.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						
					));
					echo $this->Form->input('Deliveries.2.start_time');
					echo $this->Form->input('Deliveries.2.end_time');
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Delivery.2.zipcode',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Deliveries.2.blackout',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						
					</div>				
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-thursday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Thursday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-thursday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Deliveries.3.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						
					));
					echo $this->Form->input('Deliveries.3.start_time');
					echo $this->Form->input('Deliveries.3.end_time');
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Deliveries.3.zipcode',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Deliveries.3.blackout',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						
					</div>					
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-friday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Friday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-friday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Deliveries.4.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						
					));
					echo $this->Form->input('Deliveries.4.start_time');
					echo $this->Form->input('Deliveries.4.end_time');
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Deliveries.4.zipcode',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Deliveries.4.blackout',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						
					</div>				
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-saturday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Saturday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-saturday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Deliveries.5.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						
					));
					echo $this->Form->input('Deliveries.5.start_time');
					echo $this->Form->input('Deliveries.5.end_time');
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Deliveries.5.zipcode',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Deliveries.5.blackout',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						
					</div>					
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-sunday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Saturday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-sunday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Deliveries.6.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						
					));
					echo $this->Form->input('Deliveries.6.start_time');
					echo $this->Form->input('Deliveries.6.end_time');
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Deliveries.6.zipcode',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Deliveries.6.blackout',array(
						'before'=>'<div class="input-append">',
						'after'=>'<a class="add-on" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						
					</div>					
				</div>
			</div>
		</div>

</div>
<?php

echo $this->Form->end();
?>