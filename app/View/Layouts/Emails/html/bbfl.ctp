<?php
$total_subtotal = 0; //creates the final subtotal
$total_total = 0; //creates the final total
$total_due = 0; //creates the final due now
$total_due_at_arrival = 0; //creates the final due at arrival
$total_tax_sum = 0; //sums up all of the tax due
$count_ferry = count($ferry);
$count_hotel = count($hotels);
$count_attractions = count($attractions);
$count_package = count($packages);
$online_fee = 0;
if(empty($group_admin)){
	$group_admin = 'No';
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
  <title><?php echo $title_for_layout;?></title>
</head>
<body style="background-color: #A5D9C9; margin: 0; padding: 0;">
<?php echo $content_for_layout;?>
<table cellpadding="30" bgcolor="#A5D9C9" width="100%" cellspacing="0">
  <tr>
    <td style="color: #000000; font-family: arial; font-size: 12px; line-height: 150%;" valign="top" align="center">
      <table cellpadding="0" width="600" cellspacing="0" style="border: 1px solid #AAA;">
        <tr>
          <td class="headerBar" style="background-color: #EFEFEF; border-bottom: 1px solid #aaa; color: #000000; font-family: arial; font-size: 12px; line-height: 150%; text-align: center;">
            <table cellpadding="15" width="600" cellspacing="0">
              <tr>
                <td style="color: #000000; font-family: arial; font-size: 12px; line-height: 150%;"><h1 style="color: #333333; font-family: arial,sans-serif; font-size: 36px; font-weight: bold; line-height: 1; margin: 0; text-align: left;">Purchase Receipt</h1></td>
                <td style="color: #000000; font-family: arial; font-size: 12px; line-height: 150%;"><h2 style="color: #EE3A4A; font-family: arial; font-size: 14px; font-weight: bold; line-height: 120%; margin: 0; padding: 12px 0 0 0; text-align: right;">Black Ball Ferry Line</h2></td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td class="main" style="background-color: #ffffff;  color: #000000; font-family: arial; font-size: 12px; line-height: 150%; padding: 2px 18px;" bgcolor="#ffffff" valign="top" align="left">

			<p style="color: #333333; font-family: arial,sans-serif; font-size: 18px; line-height: 150%; margin: 20px 0 0;"><strong>Thanks for booking with us!</strong></p>
			<p style="color: #333333; font-family: arial,sans-serif; font-size: 15px; line-height: 150%; margin: 0 0 25px;">Your reservation has been made successfully and you're ready to go! Your confirmation number is:<br>
 			 <span style="font-size: 22px; display: block; margin:10px;"><b><?php echo $confirmation_id;?></b> 	</p>
      <!-- <table id="receiptSummaryTable" width="100%" style="font-size:14px; border-top: 1px dashed #BBB; margin-bottom:30px;">         
        <tbody>
          <tr>
            <td width="80%">
              <p id="receiptSummary" style=""><b>Port Angeles to Victoria</b><br>
                <span id="receiptDetails" style="font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">1 Standard Vehicle + driver, 1 addtl. adult</span>
                <span id="receiptDetails" style="font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">Friday 03/29/2013, 2:00PM</span>
              </p>
            </td>
            <td width="20%" style="text-align: right; vertical-align:top;">$<span id="vehicle_rate">72.50</span></td>                
          </tr> 
          <tr>
            <td width="80%">
              <p id="receiptSummary" style=""><b>Victoria to Port Angeles</b><br>
                <span id="receiptDetails" style="font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">1 Standard Vehicle + driver, 1 addtl. adult</span>
              <span id="receiptDetails" style="font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">Saturday 03/30/2013, 2:00PM</span></p>
            </td>
            <td width="20%" style="text-align: right; vertical-align:top;">$<span id="vehicle_rate">72.50</span></td>                
          </tr> 
          <tr>
            <td width="80%">
              <p id="receiptSummary" style=""><b>Red Lion Hotel</b><br>
                <span id="receiptDetails" style="font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">Standard Room - 2 Queens</span>
              <span id="receiptDetails" style="font-size: 80%; font-style: italic; line-height: 80%; margin-top:5px; display:block;">03/29/2013 - 03/30/2013, 2 Adults</span></p>
            </td>
            <td width="20%" style="text-align: right; vertical-align:top;">$<span id="vehicle_rate">123.60</span></td>                
          </tr> 
        </tbody>
        <tfoot>
          <tr>
            <td style="border-top: 1px #bbb solid;">Estimated due at time of travel:</td>
            <td style="text-align: right; border-top: 1px #bbb solid;">$<span id="dueAtArrival">145.00</span></td>
          </tr>
          <tr style="font-size: 110%;">
            <td><strong>Paid subtotal:</strong></td>
            <td style="text-align: right"><span id="dueAtCheckout"><strong>$139.60</strong></span></td>
          </tr>
        </tfoot>
      </table> -->
          </td>
        </tr>
        <tr>
          <td>
			<?php
			echo $this->element('/reservations/billing_complete',array(
				'group_admin'=>$group_admin,
				'ferry_sidebar'=>$ferry_sidebar,
				'hotel_sidebar'=>$hotel_sidebar,
				'attraction_sidebar'=>$attraction_sidebar,
				'package_sidebar'=>$package_sidebar
			));
			?>	
		  </td>
		 </tr>
         <tr>
          <td class="footerBar" style="background-color: #231F20; color: #000000; font-family: arial; font-size: 12px; line-height: 150%; padding: 30px;" valign="top" align="left">
            <p class="footer" style="color: #A5D9C9; font-family: verdana; font-size: 10px; line-height: 150%; margin: 10px 0; text-align: center;">
              &copy; Copyright <?php echo date('Y');?> Black Ball Ferry Line. All rights reserved.<br />
            </p>
          </td>
        </tr>
      </table>   
      
      
      
      
    </td>
  </tr>
</table>

</body>
</html>