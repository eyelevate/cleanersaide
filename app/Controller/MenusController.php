<?php
App::uses('AppController', 'Controller');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController {
	public $name = 'Menus';
	public $uses = array('Menu','Menu_item','Page');
	
	
	
/**
 * Filter before page load
 * 
 * @return void
 */
	public function beforeFilter() {
	    parent::beforeFilter();
		$this->set('username',AuthComponent::user('username'));
		//deny all public users to this controller
		$this->Auth->deny('*');
		if (!is_null($this->Auth->User()) && $this->name != 'CakeError'&& !$this->Acl->check(array('model' => 'User','foreign_key' => AuthComponent::user('id')),$this->name . '/' . $this->request->params['action'])) {
		    // Optionally log an ACL deny message in auth.log
		    CakeLog::write('auth', 'ACL DENY: ' . AuthComponent::user('username') .
		        ' tried to access ' . $this->name . '/' .
		        $this->request->params['action'] . '.'
		    );
		
		    // Render the forbidden page instead of the current requested page
		    $this->Session->setFlash(__('You do not have access to this page.'),'default',array(),'error');
		    echo $this->redirect(array('controller'=>'admins','action'=>'index'));
		
		    /**
		     * Make sure we halt here, otherwise the forbidden message
		     * is just shown above the content.
		     */

		
		}		
		//set the default layout
		$this->layout='admin';

	}	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/menus/index';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//paginate the menus 
		$this->Menu->recursive = 0;
		$this->set('menus', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/menus/view';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
				
		//set the menu_id
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		$menus = $this->Menu->read(null,$id);
		$this->set('menus', $menus);
		//get all menu_items (basic)
		$menu_items = $this->Menu_item->find('all',array('conditions'=>array('menu_id'=>$id),'order'=>array('orders asc')));
		$this->set('menu_items',$menu_items);
		//get all menu_items (by group)
		$menu_item_tiers = $this->Menu_item->arrangeByTiers($id);
		$this->set('mits',$menu_item_tiers);

	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/menus/add';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//get icons
		$icons = $this->Menu->getIcons();
		$this->set('icons',$icons);
		
		//get all user created pages that are published
		$pages = $this->Page->find('all',array('conditions'=>array('status'=>'2'),'Order'=>'Page.page_name asc'));
		$pages = $this->Menu->getPublicPages($pages);
		$this->set('pages',$pages);
		
		//get all admin content
		$controllers = $this->Menu->getAllMethods();
		$this->set('controllers',$controllers);
		if ($this->request->is('post')) {
			$this->Menu->create();
			if ($this->Menu->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.'));
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
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/menus/edit';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		
		//set the menu_id
		$this->Menu->id = $id;
		$find = $this->Menu->find('all',array('conditions'=>array('id'=>$id)));
		$this->set('menus',$find);
		//get icons
		$icons = $this->Menu->getIcons();
		$this->set('icons',$icons);
		
		//get all user created pages that are published
		$pages = $this->Page->find('all',array('conditions'=>array('status'=>'2'),'Order'=>'Page.page_name asc'));
		$pages = $this->Menu->getPublicPages($pages);
		$this->set('pages',$pages);
		
		//get all admin content
		$controllers = $this->Menu->getAllMethods();
		$this->set('controllers',$controllers);
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
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		if ($this->Menu->delete()) {
			//delete all from the menu_items table where id = id
			$this->Menu_item->query('delete from menu_items where menu_id = '.$id.'');
			$this->Session->setFlash(__('Menu deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Menu was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * request method
 * 
 * 1. Sends data to add.ctp to create new tr's 
 * 2. checks and sends data to the db to create the new menus
 * 
 * @return script
 */
	public function request()
	{
		//set the layout
		$this->layout = '';
		//if this request is an ajax call
		if($this->request->is('ajax')){
			//set variables
			$type = $this->data['type'];
			if($type == 'NEW_MENU'){
				//this is a form submission request to menus table
				//set variables
				$this->request->data['Menu']['name'] = $this->data['menuTitle'];
				$this->request->data['Menu']['edit_menu'] = $this->data['menuHtml'];
				//check to see if the name is already taken
				$find = $this->Menu->find('all',array('conditions'=>array('name'=>$this->data['menuTitle'])));
				$find_count = count($find);
				if($find_count >0){
					//already taken
					$this->set('menu_id','TAKEN');
				} else {
					//save data
					$this->Menu->save($this->data);
					//set the success variable
					$menu_id = $this->Menu->id;
					$this->set('menu_id',$menu_id);
				}
			} elseif($type =='NEW_MENU_ITEMS'){
				$this->request->data['Menu_item']['tier'] = $this->data['tier'];
				$this->request->data['Menu_item']['menu_id'] = $this->data['menu_id'];
				$this->request->data['Menu_item']['name'] = $this->data['label'];
				$this->request->data['Menu_item']['url'] = $this->data['url'];
				$this->request->data['Menu_item']['orders'] = $this->data['order'];
				$this->request->data['Menu_item']['icon'] = $this->data['icon'];
			
				$this->Menu_item->save($this->data);		

			} elseif ($type == 'EDIT_MENU'){
				//set variables
				$this->Menu->id = $this->data['menu_id'];
				$this->request->data['Menu']['name'] = $this->data['menuTitle'];
				$this->request->data['Menu']['edit_menu'] = $this->data['menuHtml'];
				//check to see if there are any other menu names with the same edited name
				$find = $this->Menu->find('all',array('conditions'=>array('Menu.name'=>$this->data['menuTitle'],'id !='=>$this->Menu->id)));
				$find_count = count($find);
				if($find_count >0){
					//already taken		
					$this->set('menu_id','TAKEN');
				} else {
					//update the db
					$this->Menu->save($this->data);
					//set the success variable
					$menu_id = $this->Menu->id;
					$this->set('menu_id',$menu_id);
					//deleting old data
					$this->Menu_item->query("DELETE FROM menu_items WHERE menu_id =".$menu_id.";");
			
				}
				
			} elseif ($type == 'EDIT_MENU_ITEMS'){
				
				$this->request->data['Menu_item']['tier'] = $this->data['tier'];
				$this->request->data['Menu_item']['menu_id'] = $this->data['menu_id'];
				$this->request->data['Menu_item']['name'] = $this->data['label'];
				$this->request->data['Menu_item']['url'] = $this->data['url'];
				$this->request->data['Menu_item']['orders'] = $this->data['order'];
				$this->request->data['Menu_item']['icon'] = $this->data['icon'];
				
				//save new data
				$this->Menu_item->save($this->data);				
			} else {
				//get all user pages
				$pages = $this->Page->find('all',array('conditions'=>array('status'=>'2'),'Order'=>'Page.page_name asc'));
				$pages = $this->Menu->getAllNonAdminActions($pages);
				$this->set('pages',$pages);		
			}

		}
	}
}