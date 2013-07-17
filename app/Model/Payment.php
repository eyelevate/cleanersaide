<?php

App::uses('AppModel', 'Model');
/**
 * Payment Model
 * covers all of the payment processing
 */
class Payment extends AppModel {
    public $name = 'Payment';
	public $useTable = false;
	
	//form verification
	public $validate = array(
		'vdata'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'				
			),
			'cc'=>array(
				'rule'    => array('cc', array('visa','mc','disc','amex'), false, null),
				'message' => 'The credit card number you supplied was invalid.'
			)
		),
		'card_full_name'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),

		'card_cvv'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			),
		    'numeric' => array(
		        'rule'    => 'numeric',
		        'message' => 'CVV must be numeric digit'
		    ),
		    'minLength' => array(
		        'rule'    => array('minLength', 3),
		        'message' => 'CVV must be at least 3 digits in length'
		    ),
		    'maxLength'=>array(
				'rule'=>array('maxLength',4),
				'message'=>'CVV must at least 3 to 4 digits in length'
			)
			
		),

		'contact_address'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_city'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_state'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_zip'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_email'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'contact_phone'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'docnumber'=>array(
			'notEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'This field cannot be left blank'
			)
		),
		'password'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			)
		),
		'retypePassword'=>array(
			'notEmpty'=>array(
		        'rule'    => 'notEmpty',
		        'message' => 'This field cannot be left blank'
			), 
			'identicalPasswordCheck'=>array(
				'rule' => array('identicalPasswordCheck','password'),
				'message' => 'Your passwords do not match. Please try again'
			)	
		),
  
	);
	
	
	
/**
 * Payment processing method
 * 
 * takes in the sessions from the controller, parses them for payment, returns a response
 * 
 * 
 * @return array
 */
    
    public function paymentProcessing ($data, $data2, $data3){

		//Initialize the payment instance
		$payment = array();
		
		//Initialize the response 
		$response = array();

		foreach ($data as $p) {
			//Initialize the payment method first
			$payment['method'] = isset($p['payment_method']) ? $p['payment_method'] : null;
			
			//Now we grab data from the POST for the appropriate payment method
			//card-present:
			if ($payment['method'] == "card-present") {
				$payment['card_cardholder'] = isset($p['txtCardHolder']) ? $p['txtCardHolder'] : null;
				$payment['card_magstripe'] = isset($p['txtCardData']) ? $p['txtCardData'] : null;
			}
			
			
			//card-not-present
			if ($payment['method'] == "card-not-present") {
				$payment['card_number'] = isset($p['vdata']) ? $p['vdata'] : null; //Can't have spaces or dashes, so these need to be stripped out.
				$payment['card_full_name'] = isset($p['card_full_name']) ? $p['card_full_name'] : null;
				$payment['card_cvv'] = isset($p['card_cvv']) ? $p['card_cvv'] : null;
				$payment['card_expires_month'] = isset($p['card_expires_month']) ? $p['card_expires_month'] : null;
				$payment['card_expires_year'] = isset($p['card_expires_year']) ? $p['card_expires_year'] : null;
				$payment['card_zip'] = isset($p['card_zip']) ? $p['card_zip'] : null;
			}
			
			//ACH
			if ($payment['method'] == "ach") {
				$payment['ach_routing_number'] = isset($p['ach_routing_number']) ? $p['ach_routing_number'] : null;
				$payment['ach_account_number'] = isset($p['ach_account_number']) ?$p['ach_account_number'] : null;
				$payment['ach_account_type'] = isset($p['ach_account_type']) ? $p['ach_account_type'] : null;
				$payment['ach_first_name'] = isset($p['ach_first_name']) ? $p['ach_first_name'] : null;
				$payment['ach_last_name'] = isset($p['ach_last_name']) ? $p['ach_last_name'] : null;
			}
			//payment information:
			//$payment['payment_amount'] = isset($p['payment_amount']) ? $p['payment_amount'] : null;
			$payment['payment_amount'] = $data3['total_due'];
			//contact information:
			$payment['contact_first_name'] = isset($data2['first_name']) ? $data2['first_name'] : null;
			$payment['contact_last_name'] = isset($data2['last_name']) ? $data2['last_name'] : null;
			$payment['contact_email'] = isset($data2['contact_email']) ? $data2['contact_email'] : null;
			$payment['contact_phone'] = isset($data2['contact_phone']) ? $data2['contact_phone'] : null;
			//$payment['contact_type'] = isset($p['contact_type']) ? $p['contact_type'] : null;
			$payment['contact_type'] = 'full';
			if ($payment['contact_type'] == "full") {
				$payment['contact_street'] = isset($p['contact_address']) ? $p['contact_address'] : null;
				$payment['contact_city'] = isset($p['contact_city']) ? $p['contact_city'] : null;
				$payment['contact_state'] = isset($p['contact_state']) ? $p['contact_state'] : null;
				$payment['contact_zip'] = isset($data2['contact_zip']) ? $data2['contact_zip'] : null;
				$payment['contact_country'] = isset($p['contact_country']) ? $p['contact_country'] : null;
			}

		}

		
		//transaction/transmission settings
		
		// The gateway command settings are below. This needs to be set dynamically by the app. Here's the list of valid commands:
		// 
		// Credit Card Only
		// cc:sale      Credit Card Sale (Authorization & Capture) The main one.
		// cc:authonly  Credit Card Authorization.  This is to check and see if a customer can perform the transaction, and that's it.
		// cc:capture   Credit Card Capture. Make a sale without checking first, for use after an auth-only.
		// cc:adjust    Credit Card Adjust. IF AND ONLY IF the trans has not batched out, it can be modified
		// cc:postauth  CC Post-auth verification. When the bank requires a voice confirmation. We don't use this.
		// cc:credit    "Open Credit" or we push money to a card. It does not require a pre-existing sale, so safer to use the refund command.
		//
		// ACH Only
		// check:sale   ACH sale. The main one.
		// check:credit ACH "open credit" like cc:credit. NOT refunds, but for making payments to vendors, etc.
		//
		// General Commands
		// void         Cancels a pending transaction - UNSETTLED transactions only. If it's been batched, issue a refund.
		// refund       Refunds some or all of a transaction.
		
		if ($payment['method'] == "card-not-present" || $payment['method'] == "card-present") {
			$payment['settings_command'] = "cc:sale";
		} elseif ($payment['method'] == "ach") {
			$payment['settings_command'] = "check:sale";
		}
		
		//$payment['settings_key'] = "xI2L4K3Vf1HX5w7659HLrZGW8N78E228"; // ***LIVE KEY FOR TESTING***, nathanrules
		$payment['settings_key'] = "Z4A5qw9aJJxoB9xU8tDooGnEeHPoI8Tg"; // ***LIVE KEY***, BlackBallFerry
		$payment['settings_ip'] = $_SERVER["REMOTE_ADDR"]; //IP address of client
		$payment['settings_customer_receipt'] = "no"; //We're sending our own receipts.
		$payment['settings_version'] = "BBFL Reservation CMS 0.9 BETA"; //CMS software version
		$payment['settings_source'] = "E-Commerce: Guest"; //Two types: E-Commerce (with Guest or Username) or Backend (with Username)
		$payment['settings_currency'] = "USD"; //CAD is Canadian, if their account is set up for MCP
		$payment['settings_id'] = "1"; //Unique ID for the transaction. This is used for refunds and status updates, so ensure it is correct.
		$payment['settings_reference_number'] = null; //This is the refnum required for Void and Refund, if applicable. 
		//var_dump($payment);
		
		//hard STOP ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//exit();

		//have a killswitch somewhere here in case of incorrect/missing server-side payment data
		//START USAePay Transmission -----------------------------------------------------------------------------

		$_ = array(); 
		
		// Options
		//$_['usesandbox']		= $this->settings['testmode']; // Set "TRUE" while testing on Sandbox account
		$_['UMkey'] 				= $payment['settings_key']; 
		$_['UMcommand'] 			= $payment['settings_command'];
		$_['UMamount']				= $payment['payment_amount'];
		$_['UMinvoice']				= $payment['settings_id'];
		$_['UMip']					= $payment['settings_ip'];
		$_['UMcurrency']			= $payment['settings_currency'];
		$_['UMcustreceipt']			= $payment['settings_customer_receipt'];
		$_['UMsoftware']			= $payment['settings_version'];
		$_['UMclerk']				= $payment['settings_source'];
		
		
		//Reference Number, for Void/Refund
		if ($payment['settings_command'] == "void" || $payment['settings_command'] == "refund" || $payment['settings_command'] == "cc:capture" || $payment['settings_command'] == "cc:adjust") {
			$_['UMrefNum']			= $payment['settings_reference_number']; //figure out where this comes in and have it set into the res db. this needs to be saved.
			
		}
		
		// Payment Method
		if ($payment['method'] == "card-present") { //Card Present (through kiosks)
			$_['UMcardpresent']			= "true";
			$_['UMmagstripe']			= "enc://" . $payment['card_magstripe'];  //You need the enc:// prepend for the E2E encryption on the USAePay clip.
			$_['UMtermtype']			= "StandAlone";
			$_['UMmagsupport']			= "yes";	
		} elseif ($payment['method'] == "card-not-present") { //Card Not Present (standard e-commerce)
			$_['UMname']				= $payment['card_full_name'];
			$_['UMcard']				= $payment['card_number'];
			$_['UMexpir']				= $payment['card_expires_month'] . $payment['card_expires_year'];
			$_['UMcvv2']				= $payment['card_cvv'];
			$_['UMzip']					= $payment['card_zip'];
			if ($payment['contact_type'] == "full") { $_['UMstreet'] = $payment['contact_street']; }//If there's a full Billing Contact section, we'll also pass the address through.
		} elseif ($payment['method'] == "ACH") { //ACH (checking)
			$_['UMrouting']				= $payment['ach_routing_number'];
			$_['UMaccount']				= $payment['ach_account_number'];
			$_['UMaccounttype']			= $payment['ach_account_type'];
			$_['UMname']				= $payment['ach_first_name'] . " " . $payment['ach_last_name'];
		} else {echo "Payment method error."; exit();} //replace with error handling
		
		//Contact & Billing Information
		$_['UMcustemail']			= $payment['contact_email'];
		$_['UMemail']				= $payment['contact_email'];
		$_['UMbillfname']			= $payment['contact_first_name'];
		$_['UMbilllname']			= $payment['contact_last_name'];
		$_['UMbillphone']			= $payment['contact_phone'];
		if ($payment['contact_type'] == "full") {
			$_['UMbillstreet']			= $payment['contact_street'];
			$_['UMbillcity']			= $payment['contact_city'];
			$_['UMbillstate']			= $payment['contact_state'];
			$_['UMbillzip']				= $payment['contact_zip'];
		}
		
		// Line Items
		// In the future, we could add a line-by-line report to the gateway, i.e., Hotels were this much, Ferry Res was that much.
		// This is a basic implementation we can add to later, if BBFL wants. 
		// $i = 1;		
		// foreach($cart_products as $product) {
		// 	$product_settings = $query->query('SELECT * FROM products WHERE id="'. $product['id'] .'"');
		// 	$_['UMline'.$i.'sku']			= $product['id'];
		// 	$_['UMline'.$i.'name']			= $product_settings[0]['name'];
		// 	$_['UMline'.$i.'cost']			= $product_settings[0]['price'];
		// 	$_['UMline'.$i.'qty']			= $product['quantity'];
		// 	$i++;
		// }
		
		//parses the array into a string we can pass to usaepay
		$transaction = "";
		foreach($_ as $key => $value) {
			if (is_array($value)) {
				foreach($value as $item) {
					if (strlen($transaction) > 0) $transaction .= "&";
					$transaction .= "$key=".urlencode($item);
				}
			} else {
				if (strlen($transaction) > 0) $transaction .= "&";
				$transaction .= "$key=".urlencode($value);
			}
		}
		
		$connection = curl_init();
		//curl_setopt($connection, CURLOPT_URL,'https://sandbox.usaepay.com/gate'); <-- For the sandbox mode
		curl_setopt($connection, CURLOPT_URL,'https://www.usaepay.com/gate');
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($connection, CURLOPT_NOPROGRESS, 1); 
		curl_setopt($connection, CURLOPT_VERBOSE, 1); 
		curl_setopt($connection, CURLOPT_FOLLOWLOCATION,0); 
		curl_setopt($connection, CURLOPT_POST, 1); 
		curl_setopt($connection, CURLOPT_POSTFIELDS, $transaction); 
		curl_setopt($connection, CURLOPT_TIMEOUT, 60); 
		//curl_setopt($connection, CURLOPT_USERAGENT, SHOPP_GATEWAY_USERAGENT); 
		curl_setopt($connection, CURLOPT_REFERER, "https://".$_SERVER['SERVER_NAME']); 
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($connection);
		//if ($error = curl_error($connection)) 
		//	new ShoppError($error,'usaepay_connection',SHOPP_COMM_ERR);
		
		curl_close($connection);
		
		$final = new stdClass();
		$final->rawresult=$result;
		parse_str($result,$tmp);
		
		//Result Parsing Here -----------------------------------------		
		if(!strlen($result))
		{
		
			$final->result="Error";
			$final->resultcode="E";
			$final->error="Error reading from card processing gateway.";
			$final->errorcode=10132;
			$final->blank=1;
			$final->transporterror=$this->curlerror=curl_error($ch);
		
			echo "Error: !strlen($result) /n";
			//var_dump($final);
		
			return false;
		}
		elseif(!$result) {
			$final->result="Error";
			$final->resultcode="E";
			$final->error="Blank response from card processing gateway.";
			$final->errorcode=10132;
		
			echo "Error: !$result /n";
			//var_dump($final);
		
			return false;
		}
		else {
			$final->result=(isset($tmp["UMstatus"])?$tmp["UMstatus"]:"Error");	
			$final->resultcode=(isset($tmp["UMresult"])?$tmp["UMresult"]:"E");	
			$final->authcode=(isset($tmp["UMauthCode"])?$tmp["UMauthCode"]:"");
			$final->refnum=(isset($tmp["UMrefNum"])?$tmp["UMrefNum"]:"");
			$final->batch=(isset($tmp["UMbatch"])?$tmp["UMbatch"]:"");
			$final->avs_result=(isset($tmp["UMavsResult"])?$tmp["UMavsResult"]:"");
			$final->avs_result_code=(isset($tmp["UMavsResultCode"])?$tmp["UMavsResultCode"]:"");
			$final->cvv2_result=(isset($tmp["UMcvv2Result"])?$tmp["UMcvv2Result"]:"");
			$final->cvv2_result_code=(isset($tmp["UMcvv2ResultCode"])?$tmp["UMcvv2ResultCode"]:"");
			$final->vpas_result_code=(isset($tmp["UMvpasResultCode"])?$tmp["UMvpasResultCode"]:"");
			$final->convertedamount=(isset($tmp["UMconvertedAmount"])?$tmp["UMconvertedAmount"]:"");
			$final->convertedamountcurrency=(isset($tmp["UMconvertedAmountCurrency"])?$tmp["UMconvertedAmountCurrency"]:"");
			$final->conversionrate=(isset($tmp["UMconversionRate"])?$tmp["UMconversionRate"]:"");
			$final->error=(isset($tmp["UMerror"])?$tmp["UMerror"]:"");
			$final->errorcode=(isset($tmp["UMerrorcode"])?$tmp["UMerrorcode"]:"10132");
			$final->custnum=(isset($tmp["UMcustnum"])?$tmp["UMcustnum"]:"");
		
			// Obsolete variable (for backward compatibility) At some point they will no longer be set.
			$final->avs=(isset($tmp["UMavsResult"])?$tmp["UMavsResult"]:"");
			$final->cvv2=(isset($tmp["UMcvv2Result"])?$tmp["UMcvv2Result"]:"");
		
			if(isset($tmp["UMcctransid"])) $final->cctransid=$tmp["UMcctransid"];
			if(isset($tmp["UMacsurl"])) $final->acsurl=$tmp["UMacsurl"];
			if(isset($tmp["UMpayload"])) $final->pareq=$tmp["UMpayload"];
			
			$response['reference'] = $tmp['UMrefNum'];
			if ($final->resultcode = "A") {
				//Response went through and was valid - this does NOT mean the transaction is approved, but it did execute correctly.
				switch ($final->result) {
					case 'Approved':
						$response['approved'] = 'Yes';	
						break;
					case 'Declined':
						$response['approved'] = 'No';
						$response['message'] = 'This card was declined. Please check your information or try another card.<br>Error message: ';
						$response['message'] .= $final->error;
						$response['message'] .= (isset($final->avs_result)?" - ".$final->avs_result:"");
						break;
					case 'Verification':
						$response['approved'] = 'No';
						$response['message'] = 'This card requires additional verification. Please try another card or contact your bank.<br>Error message: ';
						$response['message'] .= $final->error;
						break;
					case 'Error':
						$response['approved'] = 'No';
						$response['message'] = 'There was an error with the card processing. Please re-check your data entry or try another card.<br>Error message: ';
						$response['message'] .= $final->error;						
						break;
					default:
						$response['approved'] = 'No';
						$response['message'] = 'There was a unexpected server error. Please try another card, or try again later.<br>Error message: ';
						$response['message'] .= $final->error;		
						break;
				}
							
				// echo "Recieved A response from gateway.<br><br>";
				// //var_dump($tmp);
				// //echo "<br><br>";
				// var_dump($final);
// 				
				// echo "<br><br>";
// 				
				// echo $final->error;
				// echo "<br><br>";				
				// echo $final->errorcode;
				// echo "<br><br>";			
				// echo $final->result;
				// echo "<br><br>";
// 				
				// exit();
// 				
				// //response was approved return a Yes value
				// $response['approved'] = 'Yes';
				
				
			} else {
				//Response from gateway, but transaction did NOT execute correctly.
		
				// echo "Recieved non-A response from gateway. \n \n $tmp: \n";
				// var_dump($tmp);
				// echo "\n \n";
				// var_dump($final);
// 				
// 				
				// exit();
				
				//response was not apprive return a No vlue
				$response['approved'] = 'No';
				$response['message'] = 'Your bank could not be reached to verify your card information. Please try again in a few minutes.<br>Error message: ';
				$response['message'] .= $final->error;	
			}
			
		
		} 
		
		return $response;     			
    }
    
/**	
 * Refund method
 * @return void
 */
	public function refund($reference, $refund)
	{
		debug('you are returning something');
	}
	
/**
 * Before save method
 * 
 */
	public function beforeSave($options = array())
	{
	    return true;
	}
}

?>