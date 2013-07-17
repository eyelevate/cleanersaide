<?php
/**
 * returns to javascript if name is taken or not
 */
if ($_REQUEST['type']=='Check_Url' && $_REQUEST['url']) {
	echo $taken;
}
/**
 * returns country code
 */
if($_REQUEST['type']=='Get_Country' && $_REQUEST['state']){
	echo $country;
}

if($_REQUEST['type']=='BOOK_ATTRACTION_TOUR' && $_REQUEST['attraction_id'] && $_REQUEST['tour_id'] && $_REQUEST['start'] && $_REQUEST['time'] && $_REQUEST['purchase_info']){
	
}
 
?>