<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'WebclientPrint/WebclientPrint');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class PrintersController extends AppController {
	public $name = 'Printers';
	public $uses = array(
		'User','Group','Page','Menu','Menu_item','Admin',
		'Invoice','Invoice_item','Company','Tax',
		'Inventory','Inventory_item','Delivery',
		'Invoicesummary','RewardTransaction'
	);
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		//set the default layout
		$this->layout = 'ajax';

		//set the authorized pages
		$this->Auth->allow('*');


	}

	public function index()
	{
		$this->layout = 'ajax';
		$inx = -1;
		$new_invoice = array();

		// $invs = $this->Invoice->find('all',array('order'=>'id desc','limit'=>'10'));
		// if(count($invs)>0){
			// foreach ($invs as $i) {
				// $items = json_decode($i['Invoice']['items'],true);
				// debug($items);
			// }
		// }
		// $invs_conditions = array(
			// 'conditions'=>array('InvoiceNumber BETWEEN ? AND ?' => array(0,5000))
		// );
// 		
		// $invoices = $this->Invoicesummary->find('all', array('conditions'=>array('InvoiceNumber >'=> 15117)));
		// debug(count($invoices));		
		// if(count($invoices)>0){
			// foreach ($invoices as $inv) {
				// $inx++;
				// $idx = -1;
				// $new_items = array();
				// $invoice_id = $inv['Invoicesummary']['InvoiceNumber'];
				// $company_id = 1;
				// $drop_date = $inv['Invoicesummary']['dropdate'];
				// $due_date = $inv['Invoicesummary']['duedate'];
				// $items_chosen = json_decode($inv['Invoicesummary']['itemschosen'],true);
				// $colors_array = json_decode($inv['Invoicesummary']['colorsarray'],true);
				// if(count($items_chosen)>0){
					// foreach ($items_chosen as $ikey => $ivalue) {
						// $idx++;
						// $cdx=-1;
						// $colors = array();
						// $item_name = $ivalue[0];
						// $item_id = $ivalue[1];
						// $item_qty = $ivalue[2];
// 						
						// //get beforetax value
						// $inv_items = $this->Inventory_item->find('all',array('conditions'=>array('name'=>$item_name,'company_id'=>$company_id)));
						// if(count($inv_items)>0){
							// foreach ($inv_items as $ii) {
								// $new_item_id = $ii['Inventory_item']['id'];
								// $item_base = $ii['Inventory_item']['price'];
							// }
						// }	
						// if(isset($colors_array)){				
							// if(count($colors_array)>0 && isset($colors_array[$ikey])){
								// $cdx++;
								// $color_name = $colors_array[$ikey][0];
								// $color_qty = $colors_array[$ikey][1];
								// $colors[$cdx] = array(
									// 'quantity'=>$color_qty,
									// 'color'=>$color_name
								// );
							// }	
						// }	
						// $new_items[$new_item_id] = array(
							// 'colors'=>$colors,
							// 'quantity'=>$item_qty,
							// 'name'=>$item_name,
							// 'before_tax'=>$item_base,
							// 'item_id'=>$new_item_id
// 							
						// );				
					// }
				// }
				// $customer_id = $inv['Invoicesummary']['customerid'];
// 
				// $quantity = $inv['Invoicesummary']['totalpieces'];
				// $pre_tax = sprintf('%.2f',$inv['Invoicesummary']['totalprice']);
				// $after_tax = sprintf('%.2f',$inv['Invoicesummary']['after_taxprice']);
				// $tax = sprintf('%.2f',$after_tax - $pre_tax);
				// $rack = $inv['Invoicesummary']['Rack'];
				// $rack_date = $inv['Invoicesummary']['Rack_Date'];
				// $status = $inv['Invoicesummary']['Status'];
				// switch($status){
					// case 'PickedUpPaid': //
						// $new_status = 3;
					// break;
// 						
					// case 'ReadyToPickup': //
						// $new_status = 2;
					// break;
// 						
					// case 'InProcess':
						// $new_status = 1;
					// break;
// 				
					// case 'acct':
						// $new_status = 4;
					// break;					
				// }
// 				
				// $memo = $inv['Invoicesummary']['invoice_memo'];
// 				
				// $new_invoice['Invoice'][$inx] = array(
					// 'invoice_id' => $invoice_id,
					// 'company_id' => $company_id,
					// 'customer_id'=> $customer_id,
					// 'items' => json_encode($new_items),
					// 'quantity' => $quantity,
					// 'pretax' => $pre_tax,
					// 'tax' => $tax,
					// 'reward_id' => null,
					// 'discount_id' => null,
					// 'total' => $after_tax,
					// 'rack' => $rack,
					// 'rack_date' => $rack_date,
					// 'memo' => $memo,
					// 'status' => $new_status,
					// 'due_date' =>$due_date
// 				
				// );
// 				
			// }	
			// debug($new_invoice);
			// if($this->Invoice->saveAll($new_invoice['Invoice'])){
				// $this->redirect(array('controller'=>'printers','action'=>'home'));
			// }
		// }
		
		/**
		 * Users to find all reward points then get the last value
		 *  saves into users table
		 */
		 //first find users
		 // $users = $this->User->find('all');
// 		
		 // if(count($users)>0){
		 	// foreach ($users as $u) {
				 // $customer_id = $u['User']['id'];
// 				
				 // $this->request->data = array();
				// //find the last reward transaction if exists change status and enter into db
				// $rewards = $this->RewardTransaction->find('all',array('conditions'=>array('customer_id'=>$customer_id),'order'=>'id desc','limit'=>'1'));
				// if(count($rewards)>0){
					// foreach ($rewards as $r) {
						// $total = $r['RewardTransaction']['running_total'];
						// $this->request->data['User']['reward_status'] = 2;
						// $this->request->data['User']['reward_points'] = $total;
				// $this->User->id = $customer_id;
				// if($this->User->save($this->request->data)){
// 					
				// }
					// }
				// }
			 // }
		 // }

		
	}
	
	public function home()
	{
		
	}
	
	public function print_tag1($id = null, $number = null)
	{

		$invoices = $this->Invoice->find('all',array('conditions'=>array('Invoice.invoice_id'=>$id,'company_id'=>$_SESSION['company_id'])));
		$invoice_data = array();
		if(count($invoices)>0){
			foreach ($invoices as $inv) {
				$customer_id = $inv['Invoice']['customer_id'];
				
				//get customer_date
				$custs = $this->User->find('all',array('conditions'=>array('User.id'=>$customer_id)));
				if(count($custs)>0){
					foreach ($custs as $c) {
						$first_name = $c['User']['first_name'];
						$last_name = $c['User']['last_name'];
						$phone = $this->Delivery->formatPhoneNumber($c['User']['contact_phone']);
					}
				}
				$inventory_id = '';
				$items = json_decode($inv['Invoice']['items'],true);
				if(count($items)>0){
					foreach ($items as $ikey => $ivalue) {
						$item_id = $items[$ikey]['item_id'];
						$item_name = $items[$ikey]['name'];
					}
				}
				$inventories = $this->Inventory_item->find('all',array('conditions'=>array('name'=>$item_name)));
				if(count($inventories)>0){
					foreach ($inventories as $ii) {
						$inventory_id = $ii['Inventory_item']['inventory_id'];
					}
				}
				$quantity = $inv['Invoice']['quantity'];
				$invoice_id = $inv['Invoice']['invoice_id'];
				$due_date = date('n/d',strtotime($inv['Invoice']['due_date']));
				$due_day = date('D',strtotime($inv['Invoice']['due_date']));
				$invoice_data= array(
					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'phone'=>$phone,
					'quantity'=>$quantity,
					'invoice_id'=>$invoice_id,
					'due_date'=>$due_date,
					'due_day'=>$due_day,
					'inventory_id'=>$inventory_id
					
				);
			}
		}
		$this->set('number',$number);
		$this->set('invs',$invoice_data);
	}
	
	public function print_tag2($id = null)
	{
		
	}

}