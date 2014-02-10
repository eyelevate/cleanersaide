<option value="none" date="0">Select Pickup Time</option>
<?php
if(count($route_schedule)){
	foreach ($route_schedule as $rkey => $rvalue) {
		$date = date('l n/d/Y',$rkey);
		
		foreach ($rvalue as $rrkey => $rrvalue) {
			$delivery_id = $rvalue[$rrkey]['id'];
			$delivery_limit = $rvalue[$rrkey]['limit'];
			$delivery_max = $rvalue[$rrkey]['max'];
			if($rkey == $pickup_date){
			?>
			<option value="<?php echo $delivery_id;?>" date="<?php echo $rkey;?>"><?php echo $rrkey;?></option>
			<?php
			}

		}
	}
}
?>			
