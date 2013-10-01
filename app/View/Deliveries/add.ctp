<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/deliveries_add.js'),FALSE);

echo $this->Form->create();
?>
<div class="row-fluid">
	<h1 class="heading">Add Delivery Route</h1>
	<div class="control-group">
		<label>Delivery Name</label>
		<input type="text" name="data[route_name]" value=""/>
	</div>
	<div id="accordion_delivery" class="accordion">

		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-monday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Monday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-monday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Delivery.0.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						'type'=>'text',
						
					));
					echo $this->Form->input('Delivery.0.start_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					echo $this->Form->input('Delivery.0.end_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Delivery.0.zipcode',array(
						'class'=>'zipcodeInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="zipcodeButton add-on" index="0" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						<ol id="zipcodeList-0" class="zipcodeList"></ol>
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Delivery.0.blackout',array(
						'class'=>'blackoutInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="blackoutButton add-on" index="0" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						<ol id="blackoutList-0" class="blackoutList"></ol>
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
					echo $this->Form->input('Delivery.1.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						'type'=>'text',
						
					));
					echo $this->Form->input('Delivery.1.start_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					echo $this->Form->input('Delivery.1.end_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Delivery.1.zipcode',array(
						'class'=>'zipcodeInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="zipcodeButton add-on" index="1" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						<ol id="zipcodeList-1" class="zipcodeList"></ol>
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Delivery.1.blackout',array(
						'class'=>'blackoutInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="blackoutButton add-on" index="1" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						<ol id="blackoutList-1" class="blackoutList"></ol>
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
					echo $this->Form->input('Delivery.2.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						'type'=>'text',
						
					));
					echo $this->Form->input('Delivery.2.start_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					echo $this->Form->input('Delivery.2.end_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Delivery.2.zipcode',array(
						'class'=>'zipcodeInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="zipcodeButton add-on" index="2" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						<ol id="zipcodeList-2" class="zipcodeList"></ol>
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Delivery.2.blackout',array(
						'class'=>'blackoutInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="blackoutButton add-on" index="2" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						<ol id="blackoutList-2" class="blackoutList"></ol>
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
					echo $this->Form->input('Delivery.3.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						'type'=>'text',
						
					));
					echo $this->Form->input('Delivery.3.start_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					echo $this->Form->input('Delivery.3.end_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Delivery.3.zipcode',array(
						'class'=>'zipcodeInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="zipcodeButton add-on" index="3" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						<ol id="zipcodeList-3" class="zipcodeList"></ol>
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Delivery.3.blackout',array(
						'class'=>'blackoutInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="blackoutButton add-on" index="3" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						<ol id="blackoutList-3" class="blackoutList"></ol>
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
					echo $this->Form->input('Delivery.4.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						'type'=>'text',
						
					));
					echo $this->Form->input('Delivery.4.start_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					echo $this->Form->input('Delivery.4.end_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Delivery.4.zipcode',array(
						'class'=>'zipcodeInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="zipcodeButton add-on" index="4" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						<ol id="zipcodeList-4" class="zipcodeList"></ol>
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Delivery.4.blackout',array(
						'class'=>'blackoutInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="blackoutButton add-on" index="4" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						<ol id="blackoutList-4" class="blackoutList"></ol>
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
					echo $this->Form->input('Delivery.5.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						'type'=>'text',
						
					));
					echo $this->Form->input('Delivery.5.start_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					echo $this->Form->input('Delivery.5.end_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Delivery.5.zipcode',array(
						'class'=>'zipcodeInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="zipcodeButton add-on" index="5" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						<ol id="zipcodeList-5" class="zipcodeList"></ol>
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Delivery.5.blackout',array(
						'class'=>'blackoutInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="blackoutButton add-on" index="5" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						<ol id="blackoutList-5" class="blackoutList"></ol>
					</div>					
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-sunday" data-parent="#accordion_delivery" data-toggle="collapse" class="accordion-toggle collapsed">Sunday</a>
			</div>
			<div class="accordion-body collapse" id="collapse-sunday">
				<div class="accordion-inner">
					<legend>Setup Time & Limits</legend>
					<?php
					echo $this->Form->input('Delivery.6.limit',array(
						'label'=>'Delivery Limit (How many stops per day)',
						'type'=>'text',
						
					));
					echo $this->Form->input('Delivery.6.start_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					echo $this->Form->input('Delivery.6.end_time',array(
						'data-source'=>json_encode($minutesArray),
						'data-provide'=>'typeahead',
						'type'=>'search',
					));
					?>
					<legend>Setup Zipcodes and Blackout Dates</legend>
					<?php
					echo $this->Form->input('Delivery.6.zipcode',array(
						'class'=>'zipcodeInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="zipcodeButton add-on" index="6" style="cursor:pointer">Add Zipcode</a></div>'	
					));
					?>
					<div class="well well-small">
						<ol id="zipcodeList-6" class="zipcodeList"></ol>
					</div>
					<hr/>
					<?php
					echo $this->Form->input('Delivery.6.blackout',array(
						'class'=>'blackoutInput',
						'type'=>'text',
						'before'=>'<div class="input-append">',
						'after'=>'<a class="blackoutButton add-on" index="6" style="cursor:pointer">Add Blackout</a></div>'
					));
					?>
					<div class="well well-small">
						<ol id="blackoutList-6" class="blackoutList"></ol>
					</div>					
				</div>
			</div>
		</div>
		<hr/>
		<div class="formRow" style="margin-top:10px;">
			<button class="cancelDelivery" class="pull-left btn btn-danger" type="button">Cancel</button>
			<button id="submitDelivery" class="pull-right btn btn-primary" type="button">Submit</button>
		</div>
</div>
<?php

echo $this->Form->end();
?>