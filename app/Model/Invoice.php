<?php
App::uses('AppModel', 'Model');
/**
 * app/Model/Admin.php
 */
class Invoice extends AppModel {
    public $name = 'Invoice';
	
	
	public function colors()
	{
		$colors = array(
			'Black' => '#000000',
			'White' => '#ffffff',
			'Gray' =>'gray',
			'Multi' => 'multi',
			'Red' => 'red',
			'Green' => 'green',
			'Yellow' => 'yellow',
			'Blue' => 'blue',
			'Tan' => 'tan',
			'Pink' =>'pink',
			'Purple'=>'purple',
			'Brown'=>'brown'
			
		);
		return $colors;
	}
	
	public function invoice_complete($data)
	{
		$company_id = $_SESSION['company_id'];
		//get last invoice_id 
		
		$order = array('order'=>'id desc');
		$limit = array('limit'=>'0,1');
		$last_invoice = $this->find('all',array($order, $limit));
		$new_id = 1;
		if(count($last_invoice)>0){
			foreach ($last_invoice as $li) {
				$last_id = $li['Invoice']['invoice_id'];
				
				$new_id += $last_id;

			}
			
		} 
		$new_id = sprintf('%06d', $new_id); //add leading zeroes

		if(count($data)>0){
			foreach ($data as $key => $value) {
				$data[$key]['company_id'] = $company_id;
				$data[$key]['invoice_id'] = $new_id;
				$data[$key]['status'] = '1';
				$data[$key]['items'] = json_encode($data[$key]['items']);
			}
		}
		
		return $data;
	}
	
	public function invoice_split($items, $customer_id, $due_date, $memo)
	{

		$company_id = $_SESSION['company_id'];
		$last_id = 0;
		$idx = -1;
		$data = array();
		
		$taxes = ClassRegistry::init('Tax')->find('all',array('conditions'=>array('company_id'=>$company_id)));
		$tax_rate  = 0;
		if(!empty($taxes)){
			foreach ($taxes as $t) {
				$tax_rate = 1+($t['Tax']['rate'] / 100);
			}
		}
	
		$conditions = array('Invoice.company_id'=>$company_id);
		$order = array('Invoice.id'=>'desc');
		$limit = array('limit'=>'0,1');
		$last_invoice = $this->find('all',array('conditions'=>$conditions,'order'=>$order, 'limit'=>$limit));
	
		if(count($last_invoice)>0){
			foreach ($last_invoice as $li) {
				$last_id = $li['Invoice']['invoice_id'];

			}
		} 
	
			
		if(count($items)>0){
			foreach ($items as $key => $value) {
				$idx++;
				$last_id++;
				$inventory_id = $key;
				$new_id = sprintf('%06d', $last_id); //add leading zeroes	
				
				//get totals for each inventory_type
				$sum_before_tax = 0;
				$sum_quantity = 0;
				$items = array();
				foreach ($value as $ikey => $ivalue) {
					$sum_quantity += $ivalue['quantity'];
					$sum_before_tax += $ivalue['before_tax'];
					$items[$ikey] = $ivalue;
				}
				
				
				$sum_after_tax = sprintf('%.2f',round($tax_rate * $sum_before_tax,2));
				$sum_tax = sprintf('%.2f',$sum_after_tax - $sum_before_tax);

				$data['Invoice'][$idx]['items'] = json_encode($items);
				$data['Invoice'][$idx]['inventory_id'] = $inventory_id;
				$data['Invoice'][$idx]['pretax'] = sprintf('%.2f',$sum_before_tax);
				$data['Invoice'][$idx]['tax'] = $sum_tax;
				$data['Invoice'][$idx]['total'] = $sum_after_tax;
				$data['Invoice'][$idx]['quantity'] = $sum_quantity;
				$data['Invoice'][$idx]['invoice_id'] = $new_id;
				$data['Invoice'][$idx]['customer_id'] = $customer_id;
				$data['Invoice'][$idx]['company_id'] = $company_id;
				$data['Invoice'][$idx]['status'] = 1;
				$data['Invoice'][$idx]['due_date'] = $due_date;
				$data['Invoice'][$idx]['memo'] = $memo;
				

			}
		}

		return $data;
	}

	public function date_due()
	{
		$today = date('Y-m-d H:i:s');
		$day = date('D',strtotime($today));
		switch($day){
			case 'Mon':
				$due = 2; //wed
			break;
			
			case 'Tue':
				$due = 2; //thur
			break;
				
			case 'Wed':
				$due = 2; //fri
			break;
			
			case 'Thu':
				$due = 4; //mon
			break;
				
			case 'Fri':
				$due = 4; //tue
			break;
				
			case 'Sat':
				$due = 4; //wed
			break;
				
			case 'Sun':
				$due = 3; //wed
			break;
		}
		
		$due_date = date('Y-m-d',strtotime($today) + ($due * 86400)).' 16:00:00';
		return $due_date;
	}
	
	public function rackEmailData($email,$invoice_id, $company_id)
	{
		$invoice = $this->find('all',array('conditions'=>array('invoice_id'=>$invoice_id,'company_id'=>$company_id)));
		$idx = -1;
		if(count($invoice)>0){
			foreach ($invoice as $inv) {
				$idx++;
				$customer_id = $inv['Invoice']['customer_id'];



				$email[$customer_id]['Invoice'][$invoice_id]['due_date'] = date('D n/d/y',strtotime($inv['Invoice']['due_date']));
				$email[$customer_id]['Invoice'][$invoice_id]['pretax'] = $inv['Invoice']['pretax'];
				$email[$customer_id]['Invoice'][$invoice_id]['tax'] = $inv['Invoice']['tax'];
				$email[$customer_id]['Invoice'][$invoice_id]['total'] = $inv['Invoice']['total'];
				$email[$customer_id]['Invoice'][$invoice_id]['items'] = json_decode($inv['Invoice']['items'],true);
				$customers = ClassRegistry::init('User')->find('all',array('conditions'=>array('User.id'=>$customer_id)));
				if(count($customers)>0){
					foreach ($customers as $cust) {
						$contact_email = $cust['User']['contact_email'];
						$first_name = $cust['User']['first_name'];
						$last_name = $cust['User']['last_name'];
						$email[$customer_id]['email'] = $contact_email;
						$email[$customer_id]['first_name'] = $first_name;
						$email[$customer_id]['last_name'] = $last_name;
						
					}
				}
				
			}
		}

		return $email;
	}

	public function createCustomerCopyInvoice($data, $username, $printer, $customer, $company)
	{
		$invoice = array();	
		//create needed variables

		$drop_date = date('n/d/Y g:ia');
		
		if(count($company)>0){
			foreach ($company as $c) {
				$company_name = $c['Company']['name'];
				$company_street = $c['Company']['street'];
				$company_city = $c['Company']['city'];
				$company_state = $c['Company']['state'];
				$company_zip = $c['Company']['zip'];
				$company_phone = $c['Company']['phone'];				
			}
		}
		if(count($customer)>0){
			foreach ($customer as $cu) {
				$first_name = $cu['User']['first_name'];
				$middle_initial = $cu['User']['middle_initial'];
				$last_name = $cu['User']['last_name'];
				$customer_phone = $cu['User']['contact_phone'];
				$customer_id = $cu['User']['id'];
				if(is_null($middle_initial)){
					$full_name = ucfirst($first_name).' '.ucfirst($last_name);	
				} else {
					$full_name = ucfirst($first_name).' '.ucfirst($middle_initial).' '.ucfirst($last_name);
				}
				if(!is_null($cu['User']['starch'])){
					$starch = $cu['User']['starch'];
				} else {
					$starch = 'L';
				}
				$starch_code = substr(ucfirst($last_name),0,1).$customer_id.substr(ucfirst($starch),0,1);
				
			
			}
		}
		
		foreach ($data as $key => $value) {
			$items = json_decode($value['items'],true);
			$pretax = $value['pretax'];
			$tax = $value['tax'];
			$total = $value['total'];
			$quantity = $value['quantity'];
			$invoice_id = $value['invoice_id'];
			$customer_id = $value['customer_id'];
			$due_date = date('D n/d g:ia',strtotime($value['due_date']));

			$invoice[$key][0] = $printer; //set printer
			$invoice[$key][1] = $this->_ResetStyles(); //reset
			$invoice[$key][3] = '\x1b\x4d\1'; //font
			$invoice[$key][5] = $this->_CenterBody(); //center text
			$invoice[$key][6] = $company_name;
			$invoice[$key][7] = $this->_NewLine(); //newline

			$invoice[$key][9] = $this->_CenterBody(); //center
			$invoice[$key][10] = '\x1b\x4d\1'; //font
			$invoice[$key][11] = $company_street;
			$invoice[$key][12] = $this->_NewLine(); //newline
			$invoice[$key][13] = $company_city.', '.$company_state.' '.$company_zip;
			$invoice[$key][14] = $this->_NewLine(); //newline
			$invoice[$key][15] = $company_phone;
			$invoice[$key][16] = $this->_NewLine(); //newline

			$invoice[$key][18] = $this->_CenterBody(); //center
			$invoice[$key][19] = $drop_date;
			$invoice[$key][20] = $this->_NewLine();
			$invoice[$key][21] = 'READY BY: '.$due_date;
			$invoice[$key][22] = $this->_NewLine();
			$invoice[$key][28] = $this->_CenterBody(); //center
			$invoice[$key][29] = $invoice_id;
			$invoice[$key][30] = $this->_NewLine();
			$invoice[$key][31] = $full_name.' \x1b\x44\35\17 \x09 \x1b\x61\x02 '.$starch_code;
			$invoice[$key][32] = $this->_NewLine();
			$invoice[$key][33] = '\x1b\x4d\1'; //font
			$invoice[$key][34] = $customer_phone.'\x1b\x44\47\17 \x09 \x1b\x61\x02'.$username;
			$invoice[$key][35] = $this->_NewLine();

			$invoice[$key][37] = '-----------------------------------------------';
			$invoice[$key][38] = $this->_NewLine();

			$invoice[$key][40] = 'ITEM          COLOR                     QTY ';
			$invoice[$key][41] = $this->_NewLine();

			$invoice[$key][43] = '-----------------------------------------------';
			$invoice[$key][44] = $this->_NewLine();

			$invoice[$key][46] = '\x1b\x4d\1';
			
			$idx = 46;
			foreach ($items as $ikey => $ivalue) {
				if(isset($items[$ikey]['colors'])){
					$item_colors = $items[$ikey]['colors'];	
				} else {
					$item_colors = array();
				}
				
				$item_color = '';
				if(count($item_colors)>0){
					foreach ($item_colors as $item) {
						$color = $item['color'];
						$qty = $item['quantity'];
						if($qty > 1){
							$item_color .= '('.$qty.'x) '.$color.',';
						} else {
							$item_color .= $color.',';
						}
					}
					
					$item_color = substr($item_color,0,-1);
				}
				
				$item_qty = $items[$ikey]['quantity'];
				$item_name = $items[$ikey]['name'];
				$item_before_tax = $items[$ikey]['before_tax'];
				$item_id = $items[$ikey]['item_id'];
				$idx++;
				$invoice[$key][$idx] = $item_name.':\x1b\x44\43\17 \x09 \x1b\x61\x02'.$item_qty;
				$idx++;
				$invoice[$key][$idx] = $this->_NewLine().' \x1b\x4d\1';
				$idx++;
				$invoice[$key][$idx] = '      '.$item_color.' '.$this->_NewLine();
				//insert memo data here
				
			}
			$idx++;			
			$invoice[$key][$idx] = '-----------------------------------------------';
			$idx++;
			$invoice[$key][$idx] = '               Total Pieces: '.$quantity.' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = '\x1b\x4d\1 '.$this->_CenterBody().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = 'Thank you for your business. All work done on premises.'.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = $this->_CenterBody();
			$idx++;
			$invoice[$key][$idx] = '['.$quantity.' PCS]['.strtoupper(date('D',strtotime($value['due_date']))).']'.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = $this->_NewLine().' '.$this->_NewLine().' '.$this->_NewLine().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = '\x1D\x56\x01 ';
			$idx++;
			$invoice[$key][$idx] = '\x1D\x56\x01 '.$this->_MakeCut('partial');

			
		}
		
		
		
		return $invoice;		
	}

	//set script for printing invoices
	public function createStoreCopyInvoice($data,$username,$printer,$customer,$company)
	{
		$invoice = array();	
		//create needed variables

		$drop_date = date('n/d/Y g:ia');
		
		if(count($company)>0){
			foreach ($company as $c) {
				$company_name = $c['Company']['name'];
				$company_street = $c['Company']['street'];
				$company_city = $c['Company']['city'];
				$company_state = $c['Company']['state'];
				$company_zip = $c['Company']['zip'];
				$company_phone = $c['Company']['phone'];				
			}
		}
		if(count($customer)>0){
			foreach ($customer as $cu) {
				$first_name = $cu['User']['first_name'];
				$middle_initial = $cu['User']['middle_initial'];
				$last_name = $cu['User']['last_name'];
				$customer_phone = $cu['User']['contact_phone'];
				$customer_id = $cu['User']['id'];
				if(is_null($middle_initial)){
					$full_name = ucfirst($first_name).' '.ucfirst($last_name);	
				} else {
					$full_name = ucfirst($first_name).' '.ucfirst($middle_initial).' '.ucfirst($last_name);
				}
				if(!is_null($cu['User']['starch'])){
					$starch = $cu['User']['starch'];
				} else {
					$starch = 'L';
				}
				$starch_code = substr(ucfirst($last_name),0,1).$customer_id.substr(ucfirst($starch),0,1);
				
			
			}
		}
		
		foreach ($data['Invoice'] as $key => $value) {
			$items = json_decode($value['items'],true);
			$pretax = $value['pretax'];
			$tax = $value['tax'];
			$total = $value['total'];
			$quantity = $value['quantity'];
			$invoice_id = $value['invoice_id'];
			$customer_id = $value['customer_id'];
			$due_date = date('D n/d g:ia',strtotime($value['due_date']));

			
			$invoice[$key][0] = $printer; //set printer
			$invoice[$key][1] = $this->_ResetStyles(); //reset
			$invoice[$key][2] = $this->_CenterBody(); //center text
			$invoice[$key][3] = '::STORE COPY::';
			$invoice[$key][4] = $this->_NewLine(); //newline
			$invoice[$key][6] = '\x1b\x4d\1'; //font
			$invoice[$key][7] = $this->_CenterBody(); //center text
			$invoice[$key][8] = $company_name;
			$invoice[$key][9] = $this->_NewLine(); //newline
			$invoice[$key][11] = $this->_CenterBody(); //center
			$invoice[$key][13] = $company_street;
			$invoice[$key][14] = $this->_NewLine(); //newline
			$invoice[$key][15] = $company_city.', '.$company_state.' '.$company_zip;
			$invoice[$key][16] = $this->_NewLine(); //newline
			$invoice[$key][17] = $company_phone;
			$invoice[$key][18] = $this->_NewLine(); //newline
			$invoice[$key][20] = $this->_CenterBody(); //center
			$invoice[$key][21] = $drop_date;
			$invoice[$key][22] = $this->_NewLine();
			$invoice[$key][23] = 'READY BY: '.$due_date;
			$invoice[$key][24] = $this->_NewLine();
			$invoice[$key][25] = $this->_CenterBody(); //center
			$invoice[$key]['BARCODE'] = $invoice_id;
			$invoice[$key][30] = $invoice_id;
			$invoice[$key][31] = $this->_NewLine();
			$invoice[$key][32] = $full_name.' \x1b\x44\35\17 \x09 \x1b\x61\x02 '.$starch_code;
			$invoice[$key][33] = $this->_NewLine();
			$invoice[$key][35] = $customer_phone.'\x1b\x44\47\17 \x09 \x1b\x61\x02'.$username;
			$invoice[$key][36] = $this->_NewLine();
			$invoice[$key][38] = '-----------------------------------------------';
			$invoice[$key][39] = $this->_NewLine();
			$invoice[$key][41] = 'ITEM     COLOR                 QTY     PRICE';
			$invoice[$key][42] = $this->_NewLine();
			$invoice[$key][44] = '-----------------------------------------------';
			$invoice[$key][45] = $this->_NewLine();
			$idx = 47;
			$item_colors = array();
			foreach ($items as $ikey => $ivalue) {
				if(isset($items[$ikey]['colors'])){
					
					$item_colors = $items[$ikey]['colors'];
				}
				$item_color = '';

				if(count($item_colors)>0){
					foreach ($item_colors as $item) {
						if(isset($item['color_name'])){
							$color = $item['color_name'];
						} else {
							$color = '';
						}
						if(isset($item['quantity'])){
							$qty = $item['quantity'];	
						} else {
							$qty = 0;
						}
						
						if($qty > 1){
							$item_color .= '('.$qty.'x) '.$color.',';
						} else {
							$item_color .= $color.',';
						}
					}
					
					$item_color = substr($item_color,0,-1);
				}
				
				$item_qty = $items[$ikey]['quantity'];
				$item_name = $items[$ikey]['name'];
				$item_before_tax = $items[$ikey]['before_tax'];
				$item_id = $items[$ikey]['item_id'];
				$idx++;
				$invoice[$key][$idx] = $item_name.':\x1b\x44\43\17 \x09 \x1b\x61\x02'.$item_qty.'\x09 \x09 \x09 \x09 \x09 \x09 \x09 \x09 $'.$item_before_tax;
				$idx++;
				$invoice[$key][$idx] = $this->_NewLine().' \x1b\x4d\1';
				$idx++;
				$invoice[$key][$idx] = '      '.$item_color.' '.$this->_NewLine();
				//insert memo data here
				
			}
			$idx++;			
			$invoice[$key][$idx] = '-----------------------------------------------'.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = '                    Total Pretax: $'.$pretax.' '.$this->_NewLine().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = '                       Total Tax: $'.$tax.' '.$this->_NewLine().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = '                     Total Price: $'.$total.' '.$this->_NewLine().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = '                    Total Pieces: '.$quantity.' '.$this->_NewLine().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = '\x1b\x4d\1 '.$this->_CenterBody().' '.$this->_NewLine().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = 'Thank you for your business. All work done on premises.'.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = $this->_CenterBody().' '.$this->_NewLine().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = '['.$quantity.' PCS]['.strtoupper(date('D',strtotime($value['due_date']))).']'.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = $this->_NewLine().' '.$this->_NewLine().' '.$this->_NewLine().' '.$this->_NewLine();
			$idx++;
			$invoice[$key][$idx] = $this->_MakeCut('partial');			
		}

		
		return $invoice;
	}
	
	//set script for printing invoices
	public function createCustomerCopyPickup($data, $quantity, $total_bt, $total_tax,$reward_selected, $total_discount,$total_at,$username, $printer,$customer, $company)
	{
		$invoice = array();	
		//create needed variables

		$drop_date = date('n/d/Y g:ia');
		
		if(count($company)>0){
			foreach ($company as $c) {
				$company_name = $c['Company']['name'];
				$company_street = $c['Company']['street'];
				$company_city = $c['Company']['city'];
				$company_state = $c['Company']['state'];
				$company_zip = $c['Company']['zip'];
				$company_phone = $c['Company']['phone'];				
			}
		}
		if(count($customer)>0){
			foreach ($customer as $cu) {
				$first_name = $cu['User']['first_name'];
				$middle_initial = $cu['User']['middle_initial'];
				$last_name = $cu['User']['last_name'];
				$customer_phone = $cu['User']['contact_phone'];
				$customer_id = $cu['User']['id'];
				if(is_null($middle_initial)){
					$full_name = ucfirst($first_name).' '.ucfirst($last_name);	
				} else {
					$full_name = ucfirst($first_name).' '.ucfirst($middle_initial).' '.ucfirst($last_name);
				}
				if(!is_null($cu['User']['starch'])){
					$starch = $cu['User']['starch'];
				} else {
					$starch = 'L';
				}
				$starch_code = substr(ucfirst($last_name),0,1).$customer_id.substr(ucfirst($starch),0,1);
				
			
			}
		}
		$invoice[0] = $printer; //set printer
		$invoice[2] = $this->_CenterBody(); //center text
		$invoice[3] = '\x1b\x4d\1'; //font
		$invoice[5] = $this->_CenterBody(); //center text
		$invoice[6] = $company_name;
		$invoice[7] = $this->_NewLine(); //newline
		$invoice[9] = $this->_CenterBody(); //center
		$invoice[10] = '\x1b\x4d\1'; //font
		$invoice[11] = $company_street;
		$invoice[12] = $this->_NewLine(); //newline
		$invoice[13] = $company_city.', '.$company_state.' '.$company_zip;
		$invoice[14] = $this->_NewLine(); //newline
		$invoice[15] = $company_phone;
		$invoice[16] = $this->_NewLine(); //newline
		$invoice[18] = $this->_CenterBody(); //center
		$invoice[19] = 'PICKED UP: '. date('D n/d/Y H:i:s');
		$invoice[20] = $this->_NewLine();
		$invoice[22] = $this->_CenterBody(); //center
		$invoice[23] = $full_name.' \x1b\x44\35\17 \x09 \x1b\x61\x02 '.$starch_code;
		$invoice[24] = $this->_NewLine();
		$invoice[25] = '\x1b\x4d\1'; //font
		$invoice[26] = $customer_phone.'\x1b\x44\47\17 \x09 \x1b\x61\x02'.$username;
		$invoice[27] = $this->_NewLine();
		$invoice[29] = '-----------------------------------------------';
		$invoice[30] = $this->_NewLine();
		$invoice[32] = 'ITEM          COLOR                    QTY ';
		$invoice[33] = $this->_NewLine();	
		$invoice[35] = '-----------------------------------------------';
		$invoice[36] = $this->_NewLine();
		$invoice[38] = '\x1b\x4d\1';
		$idx = 38;
		foreach ($data as $key => $value) {
			$item_colors = array();
			foreach ($value as $pkey => $pvalue) {
				$item_qty = $value[$pkey]['quantity'];
				$item_name = $value[$pkey]['name'];
				$item_before_tax = $value[$pkey]['before_tax'];
				$item_id = $value[$pkey]['item_id'];
				if(isset($value[$pkey]['colors'])){
					$item_colors = $value[$pkey]['colors'];
				}
				$item_color = '';
				if(count($item_colors)>0){
					foreach ($item_colors as $item) {
						$color = $item['color'];
						$qty = $item['quantity'];
						if($qty > 1){
							$item_color .= '('.$qty.'x) '.$color.',';
						} else {
							$item_color .= $color.',';
						}
					}
					
					$item_color = substr($item_color,0,-1);
				}
				$idx++;
				$invoice[$idx] = $item_name.':\x1b\x44\43\17 \x09 \x1b\x61\x02'.$item_qty.'\x09 \x09 \x09 \x09 \x09 \x09 \x09 \x09 $'.$item_before_tax;
				$idx++;
				$invoice[$idx] = $this->_NewLine().' \x1b\x4d\1';
				$idx++;
				$invoice[$idx] = $this->_MakeTab().' '.$item_color.' '.$this->_NewLine();
			}
			
		}
		$idx++;			
		$invoice[$idx] ='------------------------------------------';

		$invoice[$idx] = '               Total Pieces: '.$quantity.' '.$this->_NewLine();
		$idx++;
		$invoice[$idx] = '\x1b\x4d\1 '.$this->_CenterBody().' '.$this->_NewLine();
		$idx++;
		$invoice[$idx] = 'Thank you for your business. All work done on premises.'.$this->_NewLine();
		$idx++;
		$invoice[$idx] = $this->_CenterBody();
		$idx++;
		$invoice[$idx] = '['.$quantity.' PCS]'.$this->_NewLine();
		$idx++;
		$invoice[$idx] = $this->_NewLine().' '.$this->_NewLine().' '.$this->_NewLine().' '.$this->_NewLine();
		$idx++;
		$invoice[$idx] = $this->_MakeCut('partial');	
		
		
		return $invoice;		
	}

	
	static function _Init()
	{
		return '\x1B\x40';
	}

	static function _ResetStyles()
	{
		return '\x1b\x40';
	}
	
	static function _MakeStyle($font = false,$bold = false,$underline = false, $double_width = false, $double_height = false)
	{
        $hex = 0;
        if ($font) {
            $hex += $font;
        }
        if ($bold) {
            $hex += 8;
        }
		
        if ($underline) {
            $hex += 80;
        }
        if ($double_width) {
            $hex += 20;
        }
        if ($double_height) {
            $hex += 10;
        }
        if ($hex < 10) {
            $hex = '0'.$hex; 
		}
        
        return '\x1B\x21\x'.$hex;
	}

	static function _NewLine(){
		return '\r\n';
	}
	static function _CenterBody(){
		return '\x1b\x61\x01';
	}
	static function _MakeTab(){
		return '\x09';
	}
	static function _MakeCut($type)
	{
		switch($type){
			case 'partial':
				$cut = '\x1D\x56\x01';
			break;
			
			case 'complete':
				$cut = '\x1D\x56\x41';
			break;
		}
		return $cut;
	}	

	static function _EndOfDocument(){
		return 'P1\n';
	}
	
	static function _SetupBarcode($length, $height)
	{

		$special_character = '7B';
		$type_of_barcode = '41'; //code-128
		return '\x1D\x77\x'.$length.'\x1D\x68\x'.$height;

	}	
	
	static function _CreateBarcode($value)
	{
		
		return '\x1D\x6B\x73\x10\x123\x66\x78\x111\x46\x123\x67\x'.substr($value,0,2).'\x'.substr($value,2,2).'\x'.substr($value,-2);
	}


}
?>