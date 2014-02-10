<?php
//CSS Files
$this->Html->css(array(
	'admin/print_tag'
	),
	'stylesheet',
	array('inline'=>false)
);
if(count($invs)>0){
	$first_name = $invs['first_name'];
	$last_name = $invs['last_name'];
	$phone = $invs['phone'];
	$invoice_id = $invs['invoice_id'];
	$quantity = $invs['quantity'];
	$due_date = $invs['due_date'];
	$due_day = $invs['due_day'];
	$inventory_id = $invs['inventory_id'];
	switch($inventory_id){
		case '1':
			$inventory_type = 'Dry Clean';
		break;
			
		case '3':
			$inventory_type = 'Household';
		break;
			
		case '4':
			$inventory_type = 'Alteration';
		break;
			
		default:
			$inventory_type = 'Other';
		break;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="utf-8" />
 	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
		Remove this if you use the .htaccess -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Print Tag</title>
	<meta name="description" content="" />
	<meta name="author" content="wondo choung" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
	<link rel="shortcut icon" href="/favicon.ico" />
	<link href="sasscss/stylesheets/printtag.css" media="all" rel="stylesheet"/>
	
</head>

	<div id="tagbody">
		<section>
			<h1><span id="row1invnum1"><?php echo $invoice_id;?></span> <span id="row1date1"><?php echo @strtoupper($due_day);?></span> 
				<span id="row1date2"><?php echo @strtoupper($due_day);?></span> <span id="row1invnum2"><?php echo $invoice_id;?></span>
			</h1>
		</section>
		
		<section>
			<h3>
				<span id="row2name1"><?php echo ucfirst($last_name);?>,</span> <span id="row2name2"> <?php echo ucfirst($first_name);?></span> <span id="row2phone"><?php echo $phone;?></span>
			</h3>
		</section>
		
		<section>
			<h2>
				<span id="row3cp"><?php echo $inventory_type;?></span> <span id="row3total">[<?php echo $number;?>/<?php echo $quantity;?>]</span> <span id="row3datedue"><?php echo $due_date;?></span>
			</h2>
		</section>
	</div>
</html>