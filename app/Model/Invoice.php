<?php
App::uses('AppModel', 'Model');
/**
 * app/Model/Admin.php
 */
class Invoice extends AppModel {
    public $name = 'Invoice';
	
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
	
	public function invoice_split($items, $customer_id, $due_date)
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
				$data['Invoice'][$idx]['pretax'] = sprintf('%.2f',$sum_before_tax);
				$data['Invoice'][$idx]['tax'] = $sum_tax;
				$data['Invoice'][$idx]['total'] = $sum_after_tax;
				$data['Invoice'][$idx]['quantity'] = $sum_quantity;
				$data['Invoice'][$idx]['invoice_id'] = $new_id;
				$data['Invoice'][$idx]['customer_id'] = $customer_id;
				$data['Invoice'][$idx]['company_id'] = $company_id;
				$data['Invoice'][$idx]['status'] = 1;
				$data['Invoice'][$idx]['due_date'] = $due_date;
				

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
				$due = 2;
			break;
			
			case 'Tue':
				$due = 2;
			break;
				
			case 'Wed':
				$due = 2;
			break;
			
			case 'Thu':
				$due = 2;
			break;
				
			case 'Fri':
				$due = 3;
			break;
				
			case 'Sat':
				$due = 4;
			break;
				
			case 'Sun':
				$due = 3;
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
}
?>