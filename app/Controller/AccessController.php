<?php

/**
 * app/Controller/AccessController.php
 */
class AccessController extends AppController {
    //Name (should be same as the class name)
    public $name = 'Access';
	public $uses = array('Aco','Menu_item','Menu','Group');
	

/**
 * Filter before page load
 * 
 * @return void
 */
	public function beforeFilter() {
	    parent::beforeFilter();
		$this->set('username',AuthComponent::user('username'));
		//AuthComponent::loginRedirect(array('controller'=>'admins','action'=>'login'));
		//deny all public users to this controller
		$this->Auth->deny('*');
		$this->Auth->loginAction = array('controller' => 'admins', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'admins', 'action' => 'login');
		$this->Auth->authError = 'You do not have access to this page.';
		//set the default layout
		$this->layout='admin';

		
	}	
/**
 * sets permissions on global scale
 * 
 * @return void
 */
	public function index()
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/access/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//get your current group_id
		$current_group_id = AuthComponent::user('group_id');
		
		if($current_group_id == '1' || $current_group_id=='2'){ //this is the Super Administrator
			//allow complete access to all groups
		} else { //this is everyone else
			
		}
		
		
		
		
		
		
		//get all the groups from the page
		$groups = $this->Group->find('all',array('conditions'=>array('id >='=>1)));
		$this->set('groups',$groups);
		
		//set the aco data on the page
		$find = $this->Aco->find('all',array('conditions'=>array('parent_id'=>1),'order'=>'id asc'));
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
		$this->set('acos',$aco_array);

		
	}	
/**
 * This action sets which group has access to which pages
 * @return void
 */
	public function initializeAccessControl() {
	    $group = $this->User->Group;
	    //Allow developers the top access
	    $group->id = 1; //Developers
	    $this->Acl->allow($group, 'controllers');
	
	    //allow super administrator to all
	    $group->id = 2; //Super Administrator
	    $this->Acl->allow($group, 'controllers');

	
	    //allow managers to all within the company
	    $group->id = 3;//Website Administrator
	    $this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/admins/index');
		$this->Acl->allow($group, 'controllers/menus/index');
		$this->Acl->allow($group, 'controllers/menus/add');
		$this->Acl->allow($group, 'controllers/menus/edit');
		$this->Acl->allow($group, 'controllers/menus/view');
		$this->Acl->allow($group, 'controllers/menus/request');
		$this->Acl->allow($group, 'controllers/pages/index');
		$this->Acl->allow($group, 'controllers/pages/url');
		$this->Acl->allow($group, 'controllers/pages/add');
		$this->Acl->allow($group, 'controllers/pages/edit');
		$this->Acl->allow($group, 'controllers/pages/view');
		$this->Acl->allow($group, 'controllers/pages/preview');
		$this->Acl->allow($group, 'controllers/pages/validate_form');


	    //we add an exit to avoid an ugly "missing views" error message
	    echo "all done";
	    exit;
		
	}
}

?>