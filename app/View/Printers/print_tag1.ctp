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
	<style>
@CHARSET "UTF-8";
/* @group general styles 
-------------------------------------------------------------------------------------------- */
/*  Body
  Resets - Eric Meyer Reset used.
  Links
  Headings
  Other elements
-------------------------------------------------------------------------------------------- */
/* line 13, ../sass/reset.scss */
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var, dl, dt, dd, ol, ul, li, fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
  margin: 0;
  padding: 0;
  border: 0;
  outline: 0;
  font-weight: inherit;
  font-style: inherit;
  font-size: 100%;
  font-family: inherit;
  vertical-align: baseline;
}

/* remember to define focus styles! */
/* line 25, ../sass/reset.scss */
:focus {
  outline: 0;
}

/* line 26, ../sass/reset.scss */
body {
  line-height: 1;
  color: black;
}

/* line 27, ../sass/reset.scss */
ol, ul {
  list-style: none;
}

/* tables still need 'cellspacing="0"' in the markup */
/* line 29, ../sass/reset.scss */
table {
  border-collapse: separate;
  border-spacing: 0;
}

/* line 31, ../sass/reset.scss */
caption, th, td {
  text-align: left;
  font-weight: normal;
}

/* line 33, ../sass/reset.scss */
blockquote:before, blockquote:after, q:before, q:after {
  content: "";
}

/* line 35, ../sass/reset.scss */
blockquote, q {
  quotes: "" "";
}

/* line 36, ../sass/reset.scss */
textarea {
  resize: none;
}

/*background image and color*/
/*
 * Colors
 */
/*
 * Mixins
 */
/* line 4, ../sass/printtag.scss */
html {
  position: absolute;
  top: 0px;
  height: 75px;
}

/* line 10, ../sass/printtag.scss */
body {
  line-height: 1;
  color: black;
  background: none repeat scroll 0 0;
  margin: auto;
  position: relative;
  width: 325px;
}

/* PRINT REPORTS PAGE */
/* line 20, ../sass/printtag.scss */
#printbodyreport {
  width: 345px;
}

/* line 24, ../sass/printtag.scss */
#tagbody {
  margin-bottom: 0px;
}

/* line 28, ../sass/printtag.scss */
h1 {
  line-height: 25px;
  font-size: 23px;
  padding-top: 0px;
  padding-bottom: 3px;
}

/* line 36, ../sass/printtag.scss */
#row1invnum1 {
  margin-right: 15px;
}

/* line 40, ../sass/printtag.scss */
#sec1h1-2 {
  position: absolute;
  top: 0px;
  right: 0px;
}

/* line 46, ../sass/printtag.scss */
#row1date1 {
  margin-right: 20px;
}

/* line 50, ../sass/printtag.scss */
#row1date2 {
  margin-right: 15px;
}

/* line 54, ../sass/printtag.scss */
h3 {
  font-size: 15px;
}

/* line 57, ../sass/printtag.scss */
#row2name1 {
  font-size: 17px;
  margin-right: 7px;
}

/* line 62, ../sass/printtag.scss */
#row2phone {
  position: absolute;
  right: 40px;
}

/* line 67, ../sass/printtag.scss */
h2 {
  font-size: 18px;
  margin-top: 2px;
}
#div1{
	float:left;
	margin:bottom:5px;
}
#div2{
	float:right;
	margin:bottom:5px;
}

/* line 72, ../sass/printtag.scss */
.pagebreakhere {
  page-break-before: always;
}

	</style>
</head>

	<div id="tagbody">
		<section>
			<h1>
				<div id="div1">
					<span id="row1invnum1"><?php echo $invoice_id;?></span> 
					<span id="row1date1"><?php echo @strtoupper($due_day);?></span> 
				</div>
				<div id="div2">
					<span id="row1date2"><?php echo @strtoupper($due_day);?></span> 
					<span id="row1invnum2"><?php echo $invoice_id;?></span>					
				</div>
			</h1>
		</section>
		
		<section style="clear:both;">
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