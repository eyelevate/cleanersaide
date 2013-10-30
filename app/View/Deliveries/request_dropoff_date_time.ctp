
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
$idx = -1;
if(count($route_schedule)){
	foreach ($route_schedule as $rkey => $rvalue) {
		$date = date('l n/d/Y',$rkey);
		
		foreach ($rvalue as $rrkey => $rrvalue) {
			$idx++;
			$delivery_id = $rvalue[$rrkey]['id'];
			$delivery_limit = $rvalue[$rrkey]['limit'];
			$delivery_max = $rvalue[$rrkey]['max'];			
			$delivery_time = $rvalue[$rrkey]['time'];	
			if($idx ==0){ //check the first available day
				if($delivery_time > 16){ //only allow display if after 4pm (scheduled promised time)
					?>
					<option value="<?php echo $delivery_id;?>" date="<?php echo $rkey;?>"><?php echo $rrkey;?></option>
					<?php					
				}				
			} else { //every other day is ok
			?>
			<option value="<?php echo $delivery_id;?>" date="<?php echo $rkey;?>"><?php echo $rrkey;?></option>
			<?php
			}



		}
	}
}
?>			
</div>