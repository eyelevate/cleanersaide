<?php


App::uses('Component', 'Controller');

Class AuthorizeNetComponent extends Component {
	private $merchant_login;
	private $merchant_transaction_id;
	private $merchant_apihost;
	private $merchant_apipath;
	
	public function __construct()
	{
		
		//test mode
		// $this->merchant_login = '5x2GcpC8RJ';
		// $this->merchant_transaction_id = '5Jb5QWnk65WX7u8u';
		// $this->merchant_apihost = 'apitest.authorize.net';
		// $this->merchant_apipath = "/xml/v1/request.api";
		
		//live mode
		$this->merchant_login = '4a6h9PfeBk';
		$this->merchant_transaction_id = '2kRP3cQ5N298ya7J';
		$this->merchant_apihost = 'api.authorize.net';
		$this->merchant_apipath = "/xml/v1/request.api";		
	}
	
	public function createProfile($data)
	{
		//first create response array
		$profile = array();

		$validation_mode = 'liveMode'; //production mode
		// $validation_mode = 'testMode'; //developmental mode
		$company_id = $data['User']['company_id'];
		$customer_id = $data['User']['id'];
		$first_name = $data['User']['first_name'];
		$last_name = $data['User']['last_name'];
		$address = $data['User']['contact_address'];
		$city = $data['User']['contact_city'];
		$state = $data['User']['contact_state'];
		$zip = $data['User']['contact_zip'];
		$country = 'USA';
		$phone = $data['User']['contact_phone']; //must be ###-###-####

		$email = $data['User']['contact_email'];
		
		$description = '[Customer Id] = '.$customer_id.', [Full Name] = '.$first_name.' '.$last_name.', [Phone] = '.$phone;
		//build xml to post
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<createCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<profile>".
			"<merchantCustomerId>".$customer_id."</merchantCustomerId>". // Your own identifier for the customer.
			"<description>".$description."</description>".
			"<email>" .$email. "</email>".
			"</profile>".
			"</createCustomerProfileRequest>";

		$response = $this->send_xml_request($content);

		$parsedresponse = $this->parse_api_response($response);
		$profile['customerProfileId'] = htmlspecialchars($parsedresponse->customerProfileId);
		$profile['status'] = ("Ok" == $parsedresponse->messages->resultCode) ? 'approved' : 'rejected';
		$profile['response'] = ("Ok" == $parsedresponse->messages->resultCode) ? '' : (string) $parsedresponse->messages->message->text;

		return $profile;
	}
	
	public function createPaymentProfile($data, $id)
	{
		//first create response array
		$profile = array();

		$validation_mode = 'liveMode'; //production mode
		// $validation_mode = 'testMode'; //developmental mode
		$company_id = $data['User']['company_id'];
		$customer_id = $data['User']['id'];
		$first_name = $data['User']['first_name'];
		$last_name = $data['User']['last_name'];
		$address = $data['User']['contact_address'];
		$city = $data['User']['contact_city'];
		$state = $data['User']['contact_state'];
		$zip = $data['User']['contact_zip'];
		$country = 'USA';
		$phone = $data['User']['contact_phone']; //must be ###-###-####
		$cc_num = $data['User']['ccnum'];
		$email = $data['User']['contact_email'];
		$expiration = $data['User']['exp_year'].'-'.$data['User']['exp_month']; //must be YYYY-mm
		$description = '[Customer Id] = '.$customer_id.', [Full Name] = '.$first_name.' '.$last_name.', [Phone] = '.$phone;
		//build xml to post
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<createCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<customerProfileId>".$id."</customerProfileId>".
			"<paymentProfile>".
				"<billTo>".
					"<firstName>".$first_name."</firstName>".
					"<lastName>".$last_name."</lastName>".
					"<company>".$company_id."</company>".
					"<address>".$address."</address>".
					"<city>".$city."</city>".
					"<state>".$state."</state>".
					"<zip>".$zip."</zip>".
					"<country>".$country."</country>".
					"<phoneNumber>".$phone."</phoneNumber>".
					"<faxNumber></faxNumber>".
				"</billTo>".
				"<payment>".
					"<creditCard>".
						"<cardNumber>".$cc_num."</cardNumber>". 
						"<expirationDate>".$expiration."</expirationDate>". //YYYY-mm
					"</creditCard>".
				"</payment>".
			"</paymentProfile>".
			"<validationMode>".$validation_mode."</validationMode>".
			"</createCustomerPaymentProfileRequest>";
		
		// echo "Raw request: " . htmlspecialchars($content) . "<br><br>";
		$response = $this->send_xml_request($content);
		// echo "Raw response: " . htmlspecialchars($response) . "<br><br>";
		$parsedresponse = $this->parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			$profile['status'] = 'approved';
			$profile['customerPaymentProfileId'] = htmlspecialchars($parsedresponse->customerPaymentProfileId);

		} else {
			$profile['status'] = 'rejected';
			debug(htmlspecialchars($parsedresponse->customerPaymentProfileId));
			$profile['field'] = $this->errorField($parsedresponse->messages->message->code);
			$profile['response'] = (string) $parsedresponse->messages->message->text;
		}
		return $profile;
	}
	
	public function deletePaymentProfile($id)
	{
		//first create response array
		$delete_status = 1;
		//key variables
		$merchant_login = ''; //your merchant login id
		$merchant_transaction_id =''; //your transactionkey
		$merchant_apihost = 'apitest.authorize.net';
		$merchant_apipath = "/xml/v1/request.api";

		//build xml to post
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<deleteCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<customerProfileId>" . $id . "</customerProfileId>".
			"</deleteCustomerProfileRequest>";

		$response = $this->send_xml_request($content);

		$parsedresponse = $this->parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			$delete_status = 2;
			// echo "customerProfileId <b>"
				// . htmlspecialchars($_POST["customerProfileId"])
				// . "</b> was successfully deleted.<br><br>";
		}
		
		return $delete_status;
				
	}
	
	public function createTransaction($data){
				
		$status = array();
		$customer_id = $data['Schedule']['customer_id'];
		$amount = $data['Schedule']['total'];
		$name = 'Delivery Completed Transaction';
		$description = '';
		$schedule_id = $data['Schedule']['id'];
		$profile_id = $data['Schedule']['profile_id'];
		$payment_status = $data['Schedule']['payment_status'];
		$payment_id = $data['Schedule']['payment_id'];
		$invoices = $data['Schedule']['invoices'];
		//build xml to post
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<createCustomerProfileTransactionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<transaction>".
			"<profileTransAuthOnly>".
			"<amount>".$amount."</amount>". // should include tax, shipping, and everything.
			"<shipping>".
				"<amount>0.00</amount>".
				"<name></name>".
				"<description></description>".
			"</shipping>";
			
		if(count($invoices)>0){
			foreach ($invoices as $ikey => $ivalue) {
				$invoice_id = $ivalue['invoice_id'];
				$invoice_total = $ivalue['total'];
				$content .=
					"<lineItems>".
						"<itemId>".$invoice_id."</itemId>".
						"<name>Delivery Dropoff Payment</name>".
						"<description>Invoice #".$invoice_id."</description>".
						"<quantity>1</quantity>".
						"<unitPrice>".$invoice_total."</unitPrice>".
						"<taxable>true</taxable>".
					"</lineItems>";
			}
		}

			
		$content .=
			"<customerProfileId>" .$profile_id. "</customerProfileId>".
			"<customerPaymentProfileId>" .$payment_id. "</customerPaymentProfileId>".
			"<order>".
				"<invoiceNumber>".$schedule_id."</invoiceNumber>".
			"</order>".
			"</profileTransAuthOnly>".
			"</transaction>".
			"</createCustomerProfileTransactionRequest>";
		
		//echo "Raw request: " . htmlspecialchars($content) . "<br><br>";
		$response = $this->send_xml_request($content);
		//echo "Raw response: " . htmlspecialchars($response) . "<br><br>";
		$parsedresponse = $this->parse_api_response($response);
		if (isset($parsedresponse->directResponse)) {
			// echo "direct response: <br>"
				// . htmlspecialchars($parsedresponse->directResponse)
				// . "<br><br>";
				
			$directResponseFields = explode(",", $parsedresponse->directResponse);
			$responseCode = $directResponseFields[0]; // 1 = Approved 2 = Declined 3 = Error
			$responseReasonCode = $directResponseFields[2]; // See http://www.authorize.net/support/AIM_guide.pdf
			$responseReasonText = $directResponseFields[3];
			$approvalCode = $directResponseFields[4]; // Authorization code
			$transId = $directResponseFields[6];
			
			
			$status['code'] = htmlspecialchars($responseReasonCode);
			$status['message'] = htmlspecialchars($responseReasonText);
			$status['approvalCode'] = htmlspecialchars($approvalCode);
			$status['transId'] = htmlspecialchars($transId);
						
		}		

		if ("Ok" == $parsedresponse->messages->resultCode) { //if the payment was approved then run these next scripts
			// echo "A transaction was successfully created for customerProfileId <b>"
				// . htmlspecialchars($_POST["customerProfileId"])
				// . "</b>.<br><br>";
				
			$schedules_find = ClassRegistry::init("Schedule")->find('all',array('conditions'=>array('customer_id'=>$customer_id,'status <'=>'3')));
			$schedules_check = (count($schedules_find) >0) ? true : false; // true means schedule exists
			//check payment status, delete from database and authorizeNet if customer wishes to delete
			if($schedules_check == false && $payment_status == 1) {
				$this->deletePaymentProfile($profile_id);
			
				$user_delete = array();
				$user_delete['profile_id'] = null;
				$user_delete['payment_status'] = null;
				$user_delete['payment_id'] = null;
				ClassRegistry::init('User')->id = $customer_id;
				ClassRegistry::init('User')->save($user_delete);				
			}

			//make a transaction entry
			$pre_tax = 0;
			$tax = 0;
			$after_tax = 0;
			
			if(count($invoices)>0){
				foreach ($invoices as $ikey => $ivalue) {
					$invoice_id = $ivalue['invoice_id'];
					$invoice_total = $ivalue['total'];
					$invs = ClassRegistry::init('Invoice')->find('all',array('conditions'=>array('invoice_id'=>$invoice_id,'company_id'=>$_SESSION['company_id'])));
					if(count($invs)>0){
						foreach ($invs as $inv) {
							$inv_id = $inv['Invoice']['id'];
							$pre_tax += $inv['Invoice']['pretax'];
							$tax += $inv['Invoice']['tax'];
							//make invoice status all paid and clear from dashboard
							$inv_status = array();
							$inv_status['status'] = 5;
							ClassRegistry::init('Invoice')->id = $inv_id;
							ClassRegistry::init('Invoice')->save($inv_status);							
						}
					}
				}
			}

			//create the transaction table entry
			$transaction = array();
			$transaction['Transaction'] = array(
				'company_id'=>$_SESSION['company_id'],
				'customer_id'=>$customer_id,
				'pretax'=>sprintf('%.2f',$pre_tax),
				'tax'=>sprintf('%.2f',$tax),
				'total'=>sprintf('%.2f',$amount),
				'invoices'=>json_encode($invoices),
				'type'=>4, //type 4 is for delivery payments
				'tendered'=>0,
				'schedule_id'=>$schedule_id,
				'transaction_id'=>$transId,
				'status'=>1
			);
			ClassRegistry::init('Transaction')->save($transaction);	
		}

		return $status;	
	}

	//function to send xml request to Api.
	//There is more than one way to send https requests in PHP.
	private function send_xml_request($content)
	{
		return $this->send_request_via_fsockopen($this->merchant_apihost,$this->merchant_apipath,$content);
		
		//return $this->send_request_via_curl($this->merchant_apihost, $this->merchant_apipath, $content);
	}
	
	//function to send xml request via fsockopen
	//It is a good idea to check the http status code.
	private function send_request_via_fsockopen($host,$path,$content)
	{
		$posturl = "ssl://" . $host;
		$header = "Host: $host\r\n";
		$header .= "User-Agent: PHP Script\r\n";
		$header .= "Content-Type: text/xml\r\n";
		$header .= "Content-Length: ".strlen($content)."\r\n";
		$header .= "Connection: close\r\n\r\n";
		$fp = fsockopen($posturl, 443, $errno, $errstr, 30);
		if (!$fp)
		{
			$body = false;
		}
		else
		{
			error_reporting(E_ERROR);
			fputs($fp, "POST $path  HTTP/1.1\r\n");
			fputs($fp, $header.$content);
			if(isset($out)){
				fwrite($fp, $out);
			} else {
				fwrite($fp, null);
			}
			$response = "";
			while (!feof($fp))
			{
				$response = $response . fgets($fp, 128);
			}
			fclose($fp);
			error_reporting(E_ALL ^ E_NOTICE);
			
			$len = strlen($response);
			$bodypos = strpos($response, "\r\n\r\n");
			if ($bodypos <= 0)
			{
				$bodypos = strpos($response, "\n\n");
			}
			while ($bodypos < $len && $response[$bodypos] != '<')
			{
				$bodypos++;
			}
			$body = substr($response, $bodypos);
		}
		return $body;
	}	

	//function to send xml request via curl
	private function send_request_via_curl($host,$path,$content)
	{
		$posturl = "https://" . $host . $path;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $posturl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		return $response;
	}
	
	//function to parse the api response
	//The code uses SimpleXML. http://us.php.net/manual/en/book.simplexml.php 
	//There are also other ways to parse xml in PHP depending on the version and what is installed.
	private function parse_api_response($content)
	{
		$parsedresponse = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOWARNING);
		if ("Ok" != $parsedresponse->messages->resultCode) {
			echo "The operation failed with the following errors:<br>";
			foreach ($parsedresponse->messages->message as $msg) {
				echo "[" . htmlspecialchars($msg->code) . "] " . htmlspecialchars($msg->text) . "<br>";
			}
			echo "<br>";
		}
		return $parsedresponse;
	}	

	private function MerchantAuthenticationBlock() {

		return
	        "<merchantAuthentication>".
	        "<name>" . $this->merchant_login . "</name>".
	        "<transactionKey>" . $this->merchant_transaction_id . "</transactionKey>".
	        "</merchantAuthentication>";
	}
	
	static function errorField($code){
		$response = '';
		switch($code){
			case 'E00003':
				$response = 'ccnum';
			break;
			
			case 'E00027':
				$response = 'ccnum';
			break;
		}
		
		return $response;
	}	
	
	static function errorMessages($code){
		$response = '';
		switch($code){
			case 'E00001':
				$response ='';
			break;
			case 'E00002':
				$response ='';
			break;
			case 'E00003':
				$response = 'The credit card number is invalid.';
			break;
			case 'E00004':
				$response ='';
			break;
			case 'E00005':
				$response ='';
			break;
			case 'E00006':
				$response ='';
			break;
			case 'E00007':
				$response ='';
			break;
			case 'E00008':
				$response ='';
			break;
			case 'E00009':
				$response ='';
			break;	
			case 'E00010':
				$response ='';
			break;
			case 'E00011':
				$response ='';
			break;
			case 'E00012':
				$response ='';
			break;
			case 'E00013':
				$response ='';
			break;
			case 'E00014':
				$response ='';
			break;
			case 'E00015':
				$response ='';
			break;
			case 'E00016':
				$response ='';
			break;
			case 'E00017':
				$response ='';
			break;
			case 'E00018':
				$response ='';
			break;
			case 'E00019':
				$response ='';
			break;
			case 'E00020':
				$response ='';
			break;
			case 'E00021':
				$response ='';
			break;	
			case 'E00022':
				$response ='';
			break;
			case 'E00023':
				$response ='';
			break;
			case 'E00024':
				$response ='';
			break;
			case 'E00025':
				$response ='';
			break;
			case 'E00026':
				$response ='';
			break;
			case 'E00027':
				$response = 'The credit card number is invalid.';
			break;
		}
		
		return $response;
	}
}
?>