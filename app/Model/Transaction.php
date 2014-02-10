<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 * @property User $User
 */
class Transaction extends AppModel {

	public $name = 'Transaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed


	public function revertDeliveryPayment($data)
	{
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
						$inv_status['status'] = 1;
						ClassRegistry::init('Invoice')->id = $inv_id;
						ClassRegistry::init('Invoice')->save($inv_status);							
					}
				}
			}
		}		
	}
}