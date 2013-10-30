
<div id="dateFieldsDiv">
<?php
$today = strtotime(date('Y-m-d H:i:s'));
if(count($route_schedule)){
	foreach ($route_schedule as $rkey => $rvalue) {
		$date = date('l n/d/Y',$rkey);
		if($today < $rkey){
		?>
		<option value="<?php echo $rkey;?>"><?php echo $date;?></option>
		<?php
		}
	}
}
?>		
</div>
<div id="timeFieldsDiv">
<?php
if(count($route_schedule)){
	foreach ($route_schedule as $rkey => $rvalue) {
		$date = date('l n/d/Y',$rkey);
		
		foreach ($rvalue as $rrkey => $rrvalue) {
			$delivery_id = $rvalue[$rrkey]['id'];
			$delivery_limit = $rvalue[$rrkey]['limit'];
			$delivery_max = $rvalue[$rrkey]['max'];
			?>
			<option value="<?php echo $delivery_id;?>" date="<?php echo $rkey;?>"><?php echo $rrkey;?></option>
			<?php

		}
	}
}
?>			
</div>