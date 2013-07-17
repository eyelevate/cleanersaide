<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 * @property User $User
 */
class Group extends AppModel {

	public $name = 'Group';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        return null;
    }
    public function arrangeAco($find){
        $aco_array = array();
		foreach ($find as $parent) {
			$parent_id = $parent['Aco']['id'];
			$name = $parent['Aco']['alias'];

			$find_children = $this->Aco->find('all',array('conditions'=>array('parent_id'=>$parent_id),'order'=>'id asc'));
			$children = array();
			if(count($find_children)>0){
				foreach ($find_children as $child) {
					$child_id = $child['Aco']['id'];
					$child_name = $child['Aco']['alias'];
					$children[$child_name]= array(
						'id'=>$child_id,
						'alias'=>$child_name
					);
					
				}	
				$aco_array[$name]= array(
					'id'=>$parent_id,
					'alias'=>$name,
					'next'=>$children
				);				
			} else {
				$aco_array[$name]= array(
					'id'=>$parent_id,
					'alias'=>$name,
					'next'=>'empty'
				);				
			}

		}
    	return $aco_array;
	}

}
