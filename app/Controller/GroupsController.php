<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {
	public $name = 'Groups';
	public $uses = array('Group','Aro','Aco','Aros_aco','Acl_permission','User','Menu','Menu_item','Page','Tax',
		'Inventory','Inventory_item','Payment','Invoice','Invoice_lineitem'
	);

/**
 * Filter before page load
 * 
 * @return void
 */
	public function beforeFilter() {
	    parent::beforeFilter();
		$this->set('username',AuthComponent::user('username'));
		//
		$this->Auth->allow();		
		$this->Auth->authError = 'You do not have access to this page.';
		
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		//setup the layout on the page
		$this->layout = 'admin';
		//set the admin navigation
		$page_url = '/groups/index';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);  			
		//set variables
		$group_id = AuthComponent::user('group_id');
		if($group_id <3){	
			$group_main = $this->Group->find('all',array('conditions'=>array('id'=>1)));
			$group_below = $this->Group->find('all',array('conditions'=>array('id >='=>1)));	
			$this->set('admin_id',$group_id);
			$this->set('group_main',$group_main);
			$this->set('group_below',$group_below);		
		} else {
			$this->Session->setFlash('You do not have access to this page.');
			$this->redirect(array('controller'=>'admins','action'=>'index'));
		}


	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->layout = 'admin';
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$this->set('group', $this->Group->read(null, $id));
	}
/**
 * set aros_acos
 * This is the access control permissions level function
 * @return void
 */
	public function initializeAcl()
	{
		$this->layout = 'admin';
		//get all the groups from the users and groups table
		$group = $this->User->Group;	
		
		$groups = $this->Group->find('all');
		//truncate aros_acos
		$this->Aros_aco->query('truncate table aros_acos');
		
		foreach ($groups as $key => $value) {
			$group_id = $groups[$key]['Group']['id'];
			$acl_permissions = $this->Acl_permission->find('all',array('conditions'=>array('group_id'=>$group_id)));

			$group->id = $group_id;
			$this->Acl->deny($group,'controllers');
			if(count($acl_permissions) >0){
				foreach ($acl_permissions as $akey => $avalue) {
					$allowed = $acl_permissions[$akey]['Acl_permission']['url'];
	
	
					$this->Acl->allow($group,$allowed);
				}	
			}
		}
		
		$this->Session->setFlash(__('Successfully saved new group'),'default',array(),'success');
		$this->redirect(array('controller'=>'groups','action'=>'index'));
		exit;
	}
/**
 * add method
 *
 * @return void
 */
	public function add() {
		//setup the layout on the page
		$this->layout = 'admin';
		//set the admin navigation
		$page_url = '/groups/add';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);  
		
		//get all the groups from the page
		$groups = $this->Group->find('all',array('conditions'=>array('id !='=>1)));
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
		//if saving 
		if ($this->request->is('post')) {
			$group_type = $this->request->data['adminAccess'];
			$this->Group->create();
			if ($this->Group->save($this->request->data['Group'])) {
				$last_insert_id = $this->Group->getLastInsertID();
				$idx = -1;
				foreach ($this->request->data['Aco'] as $akey => $avalue) {
					$idx = $idx +1;
					$this->request->data['Acl_permission'][$idx]['url']= $this->request->data['Aco'][$akey];
					$this->request->data['Acl_permission'][$idx]['group_id'] = $last_insert_id;
				}
				if($this->Acl_permission->saveAll($this->request->data['Acl_permission'])){
					$this->redirect(array('action'=>'initializeAcl'));			
				}	
				
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}	

		}
	}

 
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		//setup the layout on the page
		$this->layout = 'admin';
		//set the admin navigation
		$page_url = '/groups/edit';
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);  
		$this->Group->id = $id;
		$group_id = AuthComponent::user('group_id');
		
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
		
		//get group information
		$group_find = $this->Group->find('all',array('conditions'=>array('id'=>$id)));
		$this->set('groups',$group_find);
		
		//get acl permissions
		$acl_permissions = $this->Acl_permission->find('all',array('conditions'=>array('group_id'=>$id)));
		$this->set('acl_permissions',$acl_permissions);


		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		//if saving 
		if ($this->request->is('post')) {

			$id = $this->request->data['Group']['id'];
			
			//first update the group data
			$this->Group->id = $id;
			
			$this->Group->save($this->request->data['Group']);
			
			//remove all previous versions of acl
			$this->Acl_permission->query('delete from acl_permissions where group_id ='.$id.'');
			
			$acl = array();
			$adx = -1;
			foreach ($this->request->data['Aco'] as $akey => $avalue) {
				$adx++;
				$acl[$adx]['group_id'] = $id;
				$acl[$adx]['url'] = $avalue;
			}

			
			if($this->Acl_permission->saveAll($acl)){
				//debug($this->request->data['Aco']);
				$this->redirect(array('action'=>'initializeAcl'));		
			}
			

		}	
		

	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('Group deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Group was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * Builds Aco sync automatically loads all controllers, methods, plugins into acos table
 * 
 * @return void
 */	
	public function build_acl($id= null) {
		$this->layout = 'admin';
		//get the count of how much is in the aco table
		$this->Aco->query('TRUNCATE TABLE acos');
		//set the auto_increment to 1
		$this->Aco->query('ALTER TABLE acos auto_increment = 1');
		
		// do the work
	    if (!Configure::read('debug')) {
	        return $this->_stop();
	    }
	    $log = array();
	
	    $aco = & $this->Acl->Aco;
	    $root = $aco->node('controllers');
	    if (!$root) {
	        $aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
	        $root = $aco->save();
	        $root['Aco']['id'] = $aco->id;
	        $log[] = 'Created Aco node for controllers';
	    } else {
	        $root = $root[0];
	    }
	
	    App::uses('File', 'Utility');
	    $ControllersFresh = App::objects('Controller');
	
	    foreach ($ControllersFresh as $cnt) {
	        $Controllers[] = str_replace('Controller', '', $cnt);
	    }
	    $appIndex = array_search('App', $Controllers);
	    if ($appIndex !== false) {
	        unset($Controllers[$appIndex]);
	    }
	    $baseMethods = get_class_methods('Controller');
	    $baseMethods[] = 'build_acl';
	
	    $appcontr = get_class_methods('AppController');
	
	    foreach ($appcontr as $appc) {
	        $baseMethods[] = $appc;
	    }
	
	    $baseMethods = array_unique($baseMethods);
	
	    $Plugins = $this->_getPluginControllerNames();
	    $Controllers = array_merge($Controllers, $Plugins);
	
	    // look at each controller in app/controllers
	    foreach ($Controllers as $ctrlName) {
	        $methods = $this->_getClassMethods($this->_getPluginControllerPath($ctrlName));
	
	        // Do all Plugins First
	        if ($this->_isPlugin($ctrlName)) {
	            $pluginNode = $aco->node('controllers/' . $this->_getPluginName($ctrlName));
	            if (!$pluginNode) {
	                $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginName($ctrlName)));
	                $pluginNode = $aco->save();
	                $pluginNode['Aco']['id'] = $aco->id;
	                $log[] = 'Created Aco node for ' . $this->_getPluginName($ctrlName) . ' Plugin';
	            }
	        }
	        // find / make controller node
	        $controllerNode = $aco->node('controllers/' . $ctrlName);
	        if (!$controllerNode) {
	            if ($this->_isPlugin($ctrlName)) {
	                $pluginNode = $aco->node('controllers/' . $this->_getPluginName($ctrlName));
	                $aco->create(array('parent_id' => $pluginNode['0']['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginControllerName($ctrlName)));
	                $controllerNode = $aco->save();
	                $controllerNode['Aco']['id'] = $aco->id;
	                $log[] = 'Created Aco node for ' . $this->_getPluginControllerName($ctrlName) . ' ' . $this->_getPluginName($ctrlName) . ' Plugin Controller';
	            } else {
	                $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
	                $controllerNode = $aco->save();
	                $controllerNode['Aco']['id'] = $aco->id;
	                $log[] = 'Created Aco node for ' . $ctrlName;
	            }
	        } else {
	            $controllerNode = $controllerNode[0];
	        }
	
	        //clean the methods. to remove those in Controller and private actions.
	        foreach ($methods as $k => $method) {
	            if (strpos($method, '_', 0) === 0) {
	                unset($methods[$k]);
	                continue;
	            }
	            if (in_array($method, $baseMethods)) {
	                unset($methods[$k]);
	                continue;
	            }
	            $methodNode = $aco->node('controllers/' . $ctrlName . '/' . $method);
	            if (!$methodNode) {
	                $aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
	                $methodNode = $aco->save();
	                $log[] = 'Created Aco node for ' . $method;
	            }
	        }
	    }
	    if (count($log) > 0) {
			foreach ($log as $l) {
				echo '<p>'.$l.'</p>';
			}
	    } 
		echo '<p>All Done</p>';
		$this->redirect(array('action'=>'index'));
	    exit;
	}
	
	protected function _getClassMethods($ctrlName = null) {
	    if($this->_isPlugin($ctrlName)){
	        App::uses($this->_getPluginControllerName ($ctrlName), $this->_getPluginName ($ctrlName). 'Controller');
	    }
	    else
	        App::uses($ctrlName . 'Controller', 'Controller');
	
	
	    if (strlen(strstr($ctrlName, '.')) > 0) {
	        // plugin's controller
	        $ctrlName = str_replace('Controller', '', $this->_getPluginControllerName ($ctrlName));
	    }
	    $ctrlclass = $ctrlName . 'Controller';
	    $methods = get_class_methods($ctrlclass);
	
	    // Add scaffold defaults if scaffolds are being used
	    $properties = get_class_vars($ctrlclass);
	    if (array_key_exists('scaffold', $properties)) {
	        if ($properties['scaffold'] == 'admin') {
	            $methods = array_merge($methods, array('admin_add', 'admin_edit', 'admin_index', 'admin_view', 'admin_delete'));
	        } else {
	            $methods = array_merge($methods, array('add', 'edit', 'index', 'view', 'delete'));
	        }
	    }
	    return $methods;
	}
	
	protected function _isPlugin($ctrlName = null) {
	    $arr = String::tokenize($ctrlName, '.');
	    if (count($arr) > 1) {
	        return true;
	    } else {
	        return false;
	    }
	}
	
	protected function _getPluginControllerPath($ctrlName = null) {
	    $arr = String::tokenize($ctrlName, '/');
	    if (count($arr) == 2) {
	        return $arr[0] . '.' . $arr[1];
	    } else {
	        return $arr[0];
	    }
	}
	
	protected function _getPluginName($ctrlName = null) {
	    $arr = String::tokenize($ctrlName, '.');
	    if (count($arr) == 2) {
	        return $arr[0];
	    } else {
	        return false;
	    }
	}
	
	protected function _getPluginControllerName($ctrlName = null) {
	    $arr = String::tokenize($ctrlName, '/');
	    if (count($arr) == 2) {
	        return $arr[1];
	    } else {
	        return false;
	    }
	}
	
	/**
	 * Get the names of the plugin controllers ...
	 *
	 * This function will get an array of the plugin controller names, and
	 * also makes sure the controllers are available for us to get the
	 * method names by doing an App::import for each plugin controller.
	 *
	 * @return array of plugin names.
	 *
	 *
	 */
	protected function _getPluginControllerNames() {
	    App::uses('Folder', 'Utility');
	    $folder = & new Folder();
	    $folder->cd(APP . 'Plugin');
	
	    // Get the list of plugins
	    $Plugins = $folder->read();
	    $Plugins = $Plugins[0];
	    $arr = array();
	
	    // Loop through the plugins
	    foreach ($Plugins as $pluginName) {
	        // Change directory to the plugin
	        $didCD = $folder->cd(APP . 'Plugin' . DS . $pluginName . DS . 'Controller');
	        if ($didCD) {
	            // Get a list of the files that have a file name that ends
	            // with controller.php
	            $files = $folder->findRecursive('.*Controller\.php');
	
	            // Loop through the controllers we found in the plugins directory
	            foreach ($files as $fileName) {
	                // Get the base file name
	                $file = basename($fileName);
	
	                // Get the controller name
	                //$file = Inflector::camelize(substr($file, 0, strlen($file) - strlen('Controller.php')));
	                if (!preg_match('/^' . Inflector::humanize($pluginName) . 'App/', $file)) {
	                    $file = str_replace('.php', '', $file);
	
	                    /// Now prepend the Plugin name ...
	                    // This is required to allow us to fetch the method names.
	                    $arr[] = Inflector::humanize($pluginName) . "." . $file;
	                }
	
	            }
	        }
	    }
	    return $arr;
	}

}
