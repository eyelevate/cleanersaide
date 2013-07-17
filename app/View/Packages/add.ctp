<?php
/**
 * Add Packages Page
 * 
 */
//load styles & scripts to layout
echo $this->Html->css(array(
	'/js/admin/plugins/stepy/css/jquery.stepy',
	'/js/admin/plugins/plupload/js/jquery.plupload.queue/css/plupload-gebo.css',
	'/js/admin/plugins/datepicker/datepicker.css',	
	'packages.css',
	),'stylesheet',array('inline',false)
);
echo $this->Html->script(array(
	'admin/plugins/validation/jquery.validate.min.js',
	'admin/plugins/plupload/js/plupload.full.js',
	'admin/plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.full.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/packages_add_image.js',
	'admin/packages.js'),
	FALSE
);	
?>

<div class="row-fluid">
	<?php
	echo $this->Form->create('Package',array('id'=>'PackageForm','class'=>'stepy-wizzard', 'novalidate'=>'novalidate')); 	
	?>
	<fieldset id="package-step-title" class="step" title="Marketing">
		<?php
		//found in View/elements/packages/package_marketing
		echo $this->element('packages/package_marketing',array(
			'locations'=>$locations,	
		));
		?>		
	</fieldset>
	
	<fieldset id="package-step-title" class="step" title="Setup">
		<?php
		//found in View/elements/packages/package_setup
		echo $this->element('packages/package_setup',array(
			'inventory'=>$inventories,
			'inventory_items'=>$inventory_items,
			'hotels'=>$hotels,
			'exchange'=>$exchange,
			'paos'=>$paos,
			'type'=>$type,
			'transportations'=>$transportations,
			'roundtrip_vehicle'=>$roundtrip_vehicle,
			'roundtrip_passenger'=>$roundtrip_passenger,
		));
		echo $this->Form->submit('Save Package',array('class'=>'btn btn-large btn-primary pull-right'));
		?>			
	</fieldset>
	<div id="imagesFormDiv" class="hide"></div>
	<?php
	echo $this->Form->end();
	?>
</div>