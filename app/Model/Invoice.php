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
}
?>