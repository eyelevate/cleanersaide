<?php
switch ($status) {
	case '1':
		$title = 'No Cancel + No Refund All Ferry Trips For Reservation';
		break;
	case '2':
		$title = 'No Cancel + No Refund';
		break;
		
	case '3':
		$title = 'Cancel + No Refund';
		break;
		
	case '4':
		$title = 'Cancel + Refund';
		
		break;
	default:
		$title = 'No Cancel + Refund';
		break;
}
?>
<h1 class="heading"><?php echo $title;?></h1>
<div class="formRow">
	<table>
		
	</table>
</div>
<form method="post" action="/reservations/cancel_order">
	<input type="hidden" name="data[type]" value="Attraction_all"/>
	<input type="hidden" name="data[confirm]" value="<?php echo $confirmation;?>"/>
	<input type="hidden" name="data[status]" value="<?php echo $status;?>"/>
	<button class="btn btn-danger" type="button">Cancel</button>
	<button class="btn btn-primary" type="submit">Confirm <?php echo $title;?></button>
</form>
