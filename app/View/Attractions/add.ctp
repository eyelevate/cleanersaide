<?php 

//a new default form
if($form == '0'){
 
//load scripts to layout
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/attractions.js'),FALSE);
//start form
echo $this->Form->create('Attraction',array('id'=>'attraction_basic_form')); 
?>

<div class="row-fluid">
	<h2 class="heading"><?php echo __('Add Attraction'); ?></h2>
	<?php
	echo $this->element('/attractions/add/basic_information',array(
		'locations'=>$locations
	));
	?>
</div>
<?php	
echo $this->Form->end();


//Form 2 Manual Form
} elseif($form == '1'){
	//load styles & scripts to layout
	echo $this->Html->css(array(
		'/js/admin/plugins/stepy/css/jquery.stepy',
		'/js/admin/plugins/plupload/js/jquery.plupload.queue/css/plupload-gebo.css',
		'/js/admin/plugins/datepicker/datepicker.css',	
		'attractions.css',
		),'stylesheet',array('inline',false)
	);
	echo $this->Html->script(array(
		'admin/plugins/validation/jquery.validate.min.js',
		'admin/plugins/plupload/js/plupload.full.js',
		'admin/plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.full.js',
		'admin/plugins/phone_mask/phone_mask.js',
		'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
		'admin/attractions.js',
		//'admin/attraction_add.js',
		'admin/attraction_tours.js'
		),
		FALSE
	);	

echo $this->Form->input('exchange', array('type'=>'hidden','class'=>'exchange','value'=>$exchange));
?>

<div class='row-fluid'>
	<div class="span12">
		<div id="attractionAddTitle" class="well well-small">
		<?php
		foreach ($attractions as $attraction) {
			$attraction_name = $attraction['Attraction']['name'];
			$attraction_url = $attraction['Attraction']['url'];
		}
		?>
			<h3><?php echo $attraction_name;?></h3>
		</div>
		<?php
		
		echo $this->Form->create('Attraction',array('id'=>'attraction','class'=>'stepy-wizzard form-horizontal', 'novalidate'=>'novalidate')); 	
		
		?>
		<fieldset id="attraction-step-0" class="step" title="Attraction Information">
		<?php
		echo $this->element('/attractions/add/attraction_information',array(
			'location_selected'=>$location_selected
		));
		?>
		</fieldset>
		<fieldset id="attraction-step-1" class="step" title="Attraction Details" class="hide">
		<?php
		echo $this->element('/attractions/add/attraction_details',array(
			'country'=>$country
		));
		?>
		</fieldset>
		<fieldset id="attraction-step-2" class="step" title="Attraction Tour(s)" class="hide">		
		<?php
		echo $this->element('/attractions/add/attraction_tours',array(
			'taxes'=>$taxes
		));
		?>
		</fieldset>
		<fieldset id="attraction-step-3" class="step" title="Attraction Marketing" class="hide">
		<?php
		echo $this->element('/attractions/add/attraction_marketing');
		?>
		</fieldset>
			
		<?php
		echo $this->Form->end();
		//special minutesarray hidden input *NOT IN FORM* 
		echo $this->Form->input('minutes',array('type'=>'hidden','id'=>'minutes','value'=>json_encode($minutesArray)));
		?>
	</div>	
</div>
<!-- A special div to manipulate attraction tickets -->
<div id="attractionTicketManipulate" class="hide"></div>
<?php

}else {
//this is the open travel form	
}
?>


