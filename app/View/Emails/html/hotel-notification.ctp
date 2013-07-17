<?php
$total_subtotal = 0; //creates the final subtotal
$total_total = 0; //creates the final total
$total_due = 0; //creates the final due now
$total_due_at_arrival = 0; //creates the final due at arrival
$total_tax_sum = 0; //sums up all of the tax due

$online_fee = 0;
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
  <title><?php echo $title_for_layout;?></title>
</head>
<body style="background-color: #A5D9C9; margin: 0; padding: 0;">

<table cellpadding="30" bgcolor="#A5D9C9" width="100%" cellspacing="0">
  <tr>
    <td style="color: #000000; font-family: arial; font-size: 12px; line-height: 150%;" valign="top" align="center">
      <table cellpadding="0" width="600" cellspacing="0" style="border: 1px solid #AAA;">
        <tr>
          <td class="headerBar" style="background-color: #EFEFEF; border-bottom: 1px solid #aaa; color: #000000; font-family: arial; font-size: 12px; line-height: 150%; text-align: center;">
            <table cellpadding="15" width="600" cellspacing="0">
              <tr>
                <td style="color: #000000; font-family: arial; font-size: 12px; line-height: 150%;"><h1 style="color: #333333; font-family: arial,sans-serif; font-size: 36px; font-weight: bold; line-height: 1; margin: 0; text-align: left;">Booking Notification</h1></td>
                <td style="color: #000000; font-family: arial; font-size: 12px; line-height: 150%;"><h2 style="color: #EE3A4A; font-family: arial; font-size: 14px; font-weight: bold; line-height: 120%; margin: 0; padding: 12px 0 0 0; text-align: right;">Black Ball Ferry Line</h2></td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td class="main" style="background-color: #ffffff;  color: #000000; font-family: arial; font-size: 12px; line-height: 150%; padding: 2px 18px;" bgcolor="#ffffff" valign="top" align="left">
			<p style="color: #333333; font-family: arial,sans-serif; font-size: 15px; line-height: 150%; margin: 0 0 25px;"><?php echo $full_name;?> has made a reservation for your hotel with Black Ball Ferry Line. Their BBFL confirmation is:<br>
 			 <span style="font-size: 22px; display: block; margin:10px;"><b><?php echo $confirmation_id;?></b> </p>

          </td>
        </tr>
        <tr>
          <td class="main" style="background-color: #ffffff;  color: #000000; font-family: arial; font-size: 12px; line-height: 150%; padding: 2px 18px;" bgcolor="#ffffff" valign="top" align="left">

			<table id="receiptSummaryTable" width="100%" style="font-size:14px; border-top: 1px dashed #BBB; margin-bottom:30px;">		
				<!-- hotel data -->
				<tbody style="margin-bottom:10px;">
				<?php echo $hotel_string;?>
				</tbody>
				

			</table>

		Once you've entered this reservation into your system, please enter your confirmation code <a href="http://www.cohoferry.com/hotels/update-confirmation/<?php echo $confirmation_id;?>">HERE</a>.

		  </td>
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