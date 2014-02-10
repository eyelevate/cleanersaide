<?php
echo $this->Html->script(array(
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/deliveries_edit.js'),FALSE);
	
	
foreach ($routes as $r) {
	$route_name = $r['Delivery']['route_name'];
	$weekday = $r['Delivery']['day'];
	$limit = $r['Delivery']['limit'];
	$start_time = $r['Delivery']['start_time'];
	$end_time = $r['Delivery']['end_time'];
	$zipcodes = json_decode($r['Delivery']['zipcode']);
	$blackout = json_decode($r['Delivery']['blackout']);
}

echo $this->Form->create();
echo $this->Form->input('Delivery.id',array('type'=>'hidden','value'=>$delivery_id));
?>

<div class="row-fluid">
	<legend>Delivery Edit - <?php echo $route_name;?></legend>
	<div class="well" style="text-align:center; font-size:larger; font-weight: bold; text-decoration: underline;"><?php echo $weekday;?></div>
	<div class="control-group">
		<label>Delivery Name</label>
		<input type="text" value="<?php echo $route_name;?>" name="data[Delivery][route_name]"/>
	</div>
	<?php
	echo $this->Form->input('Delivery.limit',array(
		'label'=>'Delivery Limit (How many stops per day)',
		'type'=>'text',
		'value'=>$limit
	));
	echo $this->Form->input('Delivery.start_time',array(
		'data-source'=>json_encode($minutesArray),
		'data-provide'=>'typeahead',
		'type'=>'search',
		'value'=>$start_time
	));
	echo $this->Form->input('Delivery.end_time',array(
		'data-source'=>json_encode($minutesArray),
		'data-provide'=>'typeahead',
		'type'=>'search',
		'value'=>$end_time
	));
	?>
	<legend>Setup Zipcodes</legend>
	<div class="control-group">
		<label>Zipcode</label>
		<div class="input-append">
			<input class="zipcodeInput" type="text" value=""/>
			<a class="zipcodeButton add-on" index="0" style="cursor:pointer">Add Zipcode</a></div>
		</div>
	</div>

	<div class="well well-small">
		<ol id="zipcodeList-0" class="zipcodeList">
			<?php
			$idx = -1;
			if(count($zipcodes)>0){
				foreach ($zipcodes as $key => $value) {
					$idx++;
					echo '<li class="alert alert-info">'.$value.'<button type="button" class="close" data-dismiss="alert">&times;</button><input type="hidden" name="data[Delivery][zipcode]['.$idx.']" value="'.$value.'"/></li>';
				}
			}
			?>
		</ol>
	</div>	
	<hr/>
	<legend>Setup Blackout Dates</legend>
	<div class="control-group">
		<label>Blackout</label>
		<div class="input-append">
			<input class="blackoutInput" type="text" value=""/>
			<a class="blackoutButton add-on" index="0" style="cursor:pointer">Add Blackout</a>
		</div>
	</div>	
	
	<div class="well well-small">
		<ol id="blackoutList-0" class="blackoutList">
			<?php
			$idx = -1;
			if(count($blackout)>0){
				foreach ($blackout as $key => $value) {
					$idx++;
					$date = date('n/d/Y',strtotime($value));
					echo '<li class="alert alert-error">'.$date.'<button type="button" class="close" data-dismiss="alert">&times;</button><input type="hidden" name="data[Delivery][blackout]['.$idx.']" value="'.$date.'"/></li>';
				}
			}
			?>			
		</ol>
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
