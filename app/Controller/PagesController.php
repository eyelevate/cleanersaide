<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';
	//components

/**
 * This controller uses these models
 *
 * @var array
 */
	public $uses = array('User','Menu','Menu_item','Page','Page_content','Image','Tax','Inventory','Inventory_item');

	public $components = array(
		'Auth'=>array(
 			'loginAction'=>'/',
          	'loginRedirect'=>'/',
          	'logoutRedirect'=>'/',
          	'authError'=>'You do not have access to this page.',
			'authorize'=>array(
				'Actions'=>array('actionPath'=>'controllers')
			),
			'authenticate' => array(
            	'Form' => array(
                	'userModel' => 'User',
                	'fields'=>array(
                		'username'=>'username',
                		'password'=>'password'
					)
            	)
        	)
		)
		
	);


/**
 * Filter before page load
 * 
 * @return void
 */
	public function beforeFilter() {
	    parent::beforeFilter();
		$this->set('username',AuthComponent::user('username'));
		$this->Auth->allow('home','login','url','test');
		$this->forceSSL();
	}
/**
 * 
 * 
 * @return void
 */
	public function index()
	{
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
		
	}
/**
 * Displays index page (Current Home Page)
 * 
 * @return void
 */
	public function home()
	{
		//choose layout
		$this->layout = 'pages';
		//$this->layout = 'frontend';
		$this->set('title_for_layout','Home');
						
		//Set up Primary navigation -------------------------------------------------------------
		$page_url = '/';
		$primary_nav = $this->Menu_item->arrangeByTiers(4);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);

		$contents = $this->Page_content->find('all',array('conditions'=>array('page_id'=>'1')));
		
		$this->set('contents',$contents);	
		
		//meta keywords
		$meta_keywords = 'dry cleaning, drycleaning,laundry, toxin-free, eco-friendly, seattle, pick-up, delivery, shirt laundry, cleaning, cleaners, roosevelt, alterations';
		$meta_description = 'Free Pick-up and Delivery to your home or office, to local seattle neighborhoods';
		$this->set('meta_keywords',$meta_keywords);
		$this->set('meta_description',$meta_description);		
	    // session_unset();     // unset $_SESSION variable for the run-time 
	    // session_destroy();   // destroy session data in storage		
	}

	public function hotels_attractions($url_city = null)
	{
		$this->layout = 'pages';	
		$this->set('title_for_layout','Hotels-attractions');
		
		//Set up Primary navigation -------------------------------------------------------------
		$page_url = '/hotels-attractions';
		$primary_nav = $this->Menu_item->arrangeByTiers(1);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);
		
		
		
		
		//destroy session if inactive for more than 20 mins -------------------------------------
		if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1200)) {
		    // last request was more than 20 minutes ago
		    session_unset();     // unset $_SESSION variable for the run-time 
		    session_destroy();   // destroy session data in storage
		} 

		//send up url city if selected
		if(!is_null($url_city)){
			$city = str_replace('-',' ',$url_city);
			$city = ucwords($city);
			$this->set('selected_location',$city);
		} else {
			$this->set('selected_location','NO');
		}
		//get locations
		$locations = $this->Location->find('all');
		$this->set('locations',$locations);	
		
		//Get Featured hotels and attractions (bookable and public)

		$featured_hotels = $this->Hotel->find('all',array(
			'conditions'=>array('featured'=>'yes', 'status'=>'6'),

		));
		$featured_attractions = $this->Attraction->find('all',array(
			'conditions'=>array('featured'=>'yes', 'status'=>'6'),

		));

		
		$featured = $this->Page->orderFeatured($featured_hotels, $featured_attractions);
		$this->set('featured',$featured);		
		
		//get non featured hotels and attractions (bookable and public)
		$nonfeatured_hotels = $this->Hotel->find('all',array(
			//'conditions'=>array('featured'=>'no', 'status'=>'6'), //now featured and non-featured are shown together JFD 4/18
			'conditions'=>array('status'=>'6'),
			
		));
		
		$nonfeatured_attractions = $this->Attraction->find('all',array(
			//'conditions'=>array('featured'=>'no', 'status'=>'6'),
			'conditions'=>array('status'=>'6'),
			//'order'=>'starting_price desc',
		));
		
		$nonfeatured = $this->Page->orderFeatured($nonfeatured_hotels, $nonfeatured_attractions);
		$this->set('nonfeatured',$nonfeatured);	
	}



/**
 * shows the form to create the user created page
 * @return void
 */
	public function add()
	{

		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/pages/add';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//select layout
		$this->layout = 'admin';
		//set the title
		$this->set('title_for_layout',__('Create Page'));
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
		} else {
			//find preview parent pages
			$findUrls = $this->Page->find('all',array('order'=>array('Page.url ASC')));

			$this->set('parents',$findUrls);
			
			//find all menus
			$menus = $this->Menu->find('all');
			$this->set('menus',$menus);			
		}

		if($this->request->is('post')){
			
			$data = $this->Page->updatePage($this->request->data);

			if($this->Page->save($data['Page'])){
				$last_id = $this->Page->getLastInsertID();
				$data['Page_content']['page_id'] = $last_id;
				
				if($this->Page_content->save($data['Page_content'])){
					$this->Session->setFlash('You have successfully created a page.','default',array(),'success');
					$this->redirect(array('controller'=>'pages','action'=>'view'));
				}
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
			debug($id);
			
			
			throw new MethodNotAllowedException();
		}
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->Page->delete()) {
			//delete all from the menu_items table where id = id
			$this->Page_content->query('delete from page_contents where page_id = '.$id.'');
			$this->Session->setFlash(__('Page deleted'));
			$this->redirect(array('action' => 'view'));
		}
		$this->Session->setFlash(__('Page was not deleted'));
		$this->redirect(array('action' => 'view'));
	}
/**
 * Page Validation Pages
 * 
 * @return void
 */
	public function validate_form()
	{
		//use no layout
		$this->layout = '';
		
		//save data
		if($this->request->is('ajax')){
			
			$split = $this->data['split'];
		
			switch ($split) {
				case 'Page':
					//sent to PAGE db
					//set variables
					$this->request->data['Page']['url'] = $this->data['url'];
					$this->request->data['Page']['relationship'] = $this->data['relationship'];
					$this->request->data['Page']['parent_id'] = $this->data['parent_id'];
					$this->request->data['Page']['page_name'] = $this->data['page_name'];
					$this->request->data['Page']['title'] = $this->data['title'];
					$this->request->data['Page']['keywords'] = $this->data['keywords'];
					$this->request->data['Page']['description'] = $this->data['description'];
					$this->request->data['Page']['layout']= $this->data['layout'];
					//$this->request->data['Page']['menu_id'] = $this->data['menu'];
					$this->request->data['Page']['status'] = 1; //this is the save as draft code					
					
					if ($this->data['Page']['url'] == 'NULL') {
						//if the message does not validate then display errors
						$error = 'Error: You must have a url set before saving. Please enter a url.';
						$this->set('error',$error);
						$this->set('page_id','error');
					} else {
						//check to see if the url has already been taken
						$checkUrl = $this->Page->find('all',array('conditions'=>array('url'=>$this->data['url'])));
						$checkUrl_count = count($checkUrl);
						if($checkUrl_count >0){
							$error = 'Error: This url name has already been taken. Please change your url.';
							$this->set('error',$error);
							$this->set('page_id','error');
						} else {
							//save data and get page id
							$this->Page->save($this->data);	
				
							//create new page_id
							$page_id = $this->Page->id;
							$this->Session->write('Page.last_saved_id',$page_id);
							$success = 'Success: You have successfully saved a new page as a draft.';
							$this->Session->setFlash($success, 'default', '', array(),'success');
							$this->set('error',$success);
							$this->set('page_id',$page_id);
						}
					}

					break;
				case 'Image':
					$page_id = $this->Session->read('Page.last_saved_id');
					//set the variables for Image model
					$this->request->data['Image']['page_id'] = $this->Page->id;
					$this->request->data['Image']['name'] = $this->data['image'];	
					$this->request->data['Image']['location'] = 'img/'.$this->data['image'];
					
					//check to see if images have been uploaded. if not then move on
					if ($this->request->data['Image']['name'] !='NULL'){
						$this->Image->save($this->data);
						$error = 'Success: Successfully saved images!';
						$this->Session->setFlash($success, 'default', '', array(),'success');
						$this->set('error', $error);
					} else {
						$error = 'Notice: No images to save';
						$this->Session->setFlash($success, 'default', '', array(),'error');
						$this->set('error', $error);				
					}				
					break;
				case 'Content':
					//now sending data to the PAGE_CONTENT model 
					//set the variables for page_content
					$page_id = $this->Session->read('Page.last_saved_id');
					$this->request->data['Page_content']['page_id'] = $page_id;
					$this->request->data['Page_content']['html'] = $this->data['content'];
					if($this->data['content'] != 'NULL'){
						$this->Page_content->save($this->data);
						$success = 'Success: Successfully saved page content!';
						$this->Session->setFlash($success, 'default', '', array(),'success');
						$this->set('error', $error);
					} else {
						$error = 'Notice: No content to save.';
						$this->Session->setFlash($error, 'default', '', array(),'error');
						$this->set('error', $error);
						$this->set('page_id',$page_id);
					}					
					break;
				case 'Page_edit':
					//set variables here
					$this->Page->id = $this->data['page_id'];
					$this->request->data['Page']['url'] = $this->data['url'];
					$this->request->data['Page']['relationship'] = $this->data['relationship'];
					$this->request->data['Page']['parent_id'] = $this->data['parent_id'];
					$this->request->data['Page']['page_name'] = $this->data['page_name'];
					$this->request->data['Page']['title'] = $this->data['title'];
					$this->request->data['Page']['keywords'] = $this->data['keywords'];
					$this->request->data['Page']['description'] = $this->data['description'];
					$this->request->data['Page']['layout']= $this->data['layout'];
					$this->request->data['Page']['menu_id'] = $this->data['menu'];
					$this->request->data['Page']['status'] = 1; //this is the save as draft code					
					
					if ($this->data['Page']['url'] == 'NULL') {
						//if the message does not validate then display errors
						$error = 'Error: You must have a url set before saving. Please enter a url.';
						$this->set('error',$error);
						$this->set('page_id','error');
					} else {
						//check to see if the url has already been taken
						$checkUrl = $this->Page->find('all',array('conditions'=>array('url'=>$this->data['url'],'id !='=>$this->Page->id)));
						$checkUrl_count = count($checkUrl);
						if($checkUrl_count >0){
							$error = 'Error: This url name has already been taken. Please change your url.';
							$this->set('error',$error);
							$this->set('page_id','error');
						} else {
							//update your data
							$this->Page->save($this->data);	
							$success = 'Success: You have successfully updated your page.';
							$this->Session->setFlash($success, 'default', '', array(),'success');
							$this->set('error',$success);
							$this->set('page_id',$this->Page->id);
						}
					}					
					break;
					
				case 'Image_edit':
					//set variables here
					$this->Image->id = $this->data['image_id'];
					$this->request->data['Image']['page_id'] = $this->Page->id;
					$this->request->data['Image']['name'] = $this->data['image'];	
					$this->request->data['Image']['location'] = 'img/'.$this->data['image'];
					
					//check to see if images have been uploaded. if not then move on
					if ($this->request->data['Image']['name'] !='NULL'){
						$this->Image->save($this->data);
						$error = 'Success: Successfully updated your images!';
						$this->Session->setFlash($success, 'default', '', array(),'success');
						$this->set('error', $error);
					} else {
						$error = 'Notice: No images to update';
						$this->Session->setFlash($error, 'default', '', array(),'success');
						$this->set('error', $error);				
					}					
					break;
					
				default:
					//set variables here
					$this->Page_content->id = $this->data['content_id'];
					$this->request->data['Page_content']['page_id'] = $this->data['page_id'];
					$this->request->data['Page_content']['html'] = $this->data['content'];
					if($this->data['content'] != 'NULL'){
						$this->Page_content->save($this->data);
						$success = 'Success: Successfully saved page content!';
						$this->Session->setFlash($success, 'default', '', array(),'success');
						$this->set('error', $error);
					} else {
						$error = 'Notice: No content to save.';
						$this->Session->setFlash($error, 'default', '', array(),'success');
						$this->set('error', $error);
						$this->set('page_id',$page_id);
					}						
					break;
			}
		}
	}


/**
 * shows all of the pages in a table
 * @param page id
 * @return void
 */
	public function view($id = null)
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/pages/view';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//select layout
		$this->layout = 'admin';
		//set the title
		$this->set('title_for_layout',__('View Page'));

		
		//set pagination
		$this->paginate = array(
		    'limit' => 25, 
		    'order' => array(
		        'Page.url' => 'ASC')
		);
		$this->User->recursive = 0;
		$find = $this->paginate('Page');
		$find = $this->Page->afterFindPage($find);
		$this->set('pages',$find);
	}
/**
 * shows the edit page
 * @param page id
 * @return void
 */
	public function edit($id = null) 
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/pages/edit';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//select layout
		$this->layout = 'admin';
		//set the title
		$this->set('title_for_layout',__('Edit Page'));
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
		} else {
			//set variables here
			$page_id = $id;
			$this->set('page_id',$id);
			//get from pages table
			$findPage = $this->Page->find('all',array('conditions'=>array('id'=>$id)));
			$pages = $this->Page->afterFindPage($findPage);
			$this->set('pages',$pages);
			//get from page_contents table
			$pageContents = $this->Page_content->find('all',array('conditions'=>array('page_id'=>$id)));
			$this->set('contents',$pageContents);
			//get all from images
			$images = $this->Image->find('all',array('conditions'=>array('page_id',$id)));
			$this->set('images',$images);
			//find preview parent pages
			$findUrls = $this->Page->find('all',array('order'=>array('Page.url ASC')));
			$this->set('parents',$findUrls);
			//find all menus
			$menus = $this->Menu->find('all');
			$this->set('menus',$menus);
			
			if($this->request->is('ajax')){
				$this->Page->id = $id;
				
			}			
		}
		if($this->request->is('post')){
			//debug($this->request->data);
			$data = $this->Page->updateEditPage($this->request->data);
			foreach ($data['Page'] as $pkey => $pvalue) {
				$page_id = $pkey;
				$this->Page->id = $page_id;
				if($this->Page->save($data['Page'][$pkey])){
					//get page content id
					$pcontent = $this->Page_content->find('all',array('conditions'=>array('page_id'=>$page_id)));
					if(count($pcontent)>0){
						foreach ($pcontent as $pc) {
							$page_content_id = $pc['Page_content']['id'];
							$this->Page_content->id = $page_content_id;
							$data['Page_content'][$pkey]['page_id'] = $pkey;
							if($this->Page_content->save($data['Page_content'][$pkey])){
								$this->Session->setFlash('You have successfully edited a page.','default',array(),'success');
								$this->redirect(array('controller'=>'pages','action'=>'view'));								
							}
						}
					}
				}
			}

		}
	
		
	}/**
 * shows the edit page
 * @param page id
 * @return void
 */
	public function edit_home() 
	{
		//set the admin navigation
		$admin_nav = $this->Menu_item->arrangeByTiers($this->Session->read('Admin.menu_id'));	
		$page_url = '/pages/edit_home';
		$admin_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $admin_nav);
		$this->set('admin_nav',$admin_nav);
		$this->set('admin_pages',$page_url);
		$this->set('admin_check',$admin_check);
		//select layout
		$this->layout = 'admin';
		//set the title
		$this->set('title_for_layout',__('Edit Homepage'));
		
		
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
		} else {
			//set variables here
			$page_id = 1;
			$id = 1;
			$this->set('page_id',$id);
			//get from pages table
			$findPage = $this->Page->find('all',array('conditions'=>array('id'=>$id)));
			$pages = $this->Page->afterFindPage($findPage);
			$this->set('pages',$pages);
			//get from page_contents table
			$pageContents = $this->Page_content->find('all',array('conditions'=>array('page_id'=>$id)));
			$this->set('contents',$pageContents);
			//get all from images
			// $images = $this->Image->find('all',array('conditions'=>array('page_id',$id)));
			// $this->set('images',$images);		
			if($this->request->is('ajax')){
				$this->Page->id = $id;
				
			}			
		}
		
		if($this->request->is('post')){
			
			$final_array = $this->data["Page_content"][1];
			$final_array = str_replace('"', "''", $final_array);
			$final_array = str_replace(array("\n","\r","\r\n"), '', $final_array);
	
			$final_array = json_encode($final_array, FALSE);
	
			//var_dump($final_array);
			//echo "update page_contents set html ='".$final_array."' where page_id ='1'";
			
			//exit();
			
			$this->Page_content->query("update page_contents set html ='".$final_array."' where page_id ='1'");
			//exit();
			$this->Session->setFlash('You have successfully edited the homepage.','default',array(),'success');
			$this->redirect(array('controller'=>'pages','action'=>'edit_home'));
		
		}
	
		
	}
/**
 * logsout customer
 * @param page id
 * @return void
 */
	public function logout() {
		$this->Session->setFlash(__('You have successfully logged out.'));
		$this->redirect($this->Auth->logout());
	}
/**
 * Preview Newly created page
 * 
 * @return void
 */
 
	public function preview($url1 = null, $url2 = null, $url3 = null, $url4 = null, $url5 = null)
	{
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
		} else {
			//set the url name to fit the db name
			$url = $this->Page->fixUrl($url1, $url2, $url3, $url4, $url5);
			//All necessary variables from db
			$pageFind = $this->Page->find('all',array('conditions'=>array('url'=>$url)));
			foreach ($pageFind as $page) {
				$page_id = $page['Page']['id'];
				$title = $page['Page']['title'];
				$description = $page['Page']['description'];
				$layout = $page['Page']['layout'];
				$keywords = $page['Page']['keywords'];
				$menu_id = $page['Page']['menu_id'];
				
			}			
			//Set up Primary navigation -------------------------------------------------------------
			$page_url = '/hotels-attractions';
			$primary_nav = $this->Menu_item->arrangeByTiers(1);	
			$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
			$this->set('primary_nav',$primary_nav);
			
			
			
			//set the layout
			if($layout == 'pages'){
				//setup layout to be the main default	
				$this->layout = 'pages';
			} else { //this layout has a sidebar
				//layout is a special sidebar layout
				$this->layout = $layout;
				//setup sidebar
				$form_session = $this->Session->read('Reservation_ferry');
				$hotel_session = $this->Session->read('Reservation_hotel');
				$attraction_session = $this->Session->read('Reservation_attraction');
				$package_session = $this->Session->read('Reservation_package');
				if(!empty($form_session)){
					$ferry_sidebar = $this->Reservation->sidebar_ferry($form_session);
				} else {
					$ferry_sidebar = array();
				}	
				$this->set('ferry_sidebar',$ferry_sidebar);		
				if($this->Session->check('Reservation_hotel')== true){
					$hotel_sidebar = $this->Reservation->sidebar_hotel($hotel_session);
				} else {
					$hotel_sidebar = array();
				}
				$this->set('hotel_sidebar',$hotel_sidebar);
				if($this->Session->check('Reservation_attraction')== true){
					$attraction_sidebar = $this->Reservation->sidebar_attraction($attraction_session);
				} else {
					$attraction_sidebar = array();
				}
				$this->set('attraction_sidebar',$attraction_sidebar);
				
				if($this->Session->check('Reservation_package')==true){
					$package_sidebar = $this->Reservation->sidebar_package($package_session);
				} else {
					$package_sidebar = array();
				}
				$this->set('package_sidebar',$package_sidebar);		
			}
			//send which type of layout we are using to the view page. 
			$this->set('layout',$layout);
	
	
			//set the title -->sent to layout
			$this->set('title_for_layout',$title);
			//set the title to render on the view page
			$this->set('title_view', $title);
			
			//set the keywords -->sent to layout
			$this->set('meta_keywords',$keywords);
			//set the description -->sent to layout
			$this->set('meta_description',$description);
	
	
			//set the body content -->sent to preview.ctp
			$contents = $this->Page_content->find('all',array('conditions'=>array('page_id'=>$page_id)));
			$this->set('pageContents',$contents);			
		}		
		
		
		
	}
/**
 * Displays User created Pages
 * @param url name and url sub name
 * @return void
 */
	public function url($urlFirst = null,$urlSecond = null, $urlThird = null, $urlFourth = null, $urlFifth = null)
	{
		//set the url parameters to match db url names
		$url = $this->Page->fixUrl($urlFirst, $urlSecond, $urlThird, $urlFourth, $urlFifth);

		//get all the data from the urlName
		$pageInfo = $this->Page->find('all',array('conditions'=>array('url'=>$url,'status'=>'2')));

		if (count($pageInfo)>0) {
			//All necessary variables from db
			$pageFind = $this->Page->find('all',array('conditions'=>array('url'=>$url)));
			foreach ($pageFind as $page) {
				$page_url = $page['Page']['url'];
				$page_id = $page['Page']['id'];
				$title = $page['Page']['title'];
				$description = $page['Page']['description'];
				$layout = $page['Page']['layout'];
				$keywords = $page['Page']['keywords'];
				$menu_id = $page['Page']['menu_id'];
				
			}		
			if(is_null($menu_id)){
				$menu_id = 4;
			}

			
		//Set up Primary navigation -------------------------------------------------------------
		$primary_nav = $this->Menu_item->arrangeByTiers($menu_id);	
		$primary_check = $this->Menu_item->menuActiveHeaderCheck($page_url, $primary_nav);
		$this->set('primary_nav',$primary_nav);
		
		
		
			//set the layout
			if($layout == 'pages'){ //this is the default layout with no sidebar
				//setup layout to be the main default	
				$this->layout = 'pages';
				//send which type of layout we are using to the view page. 
				$this->set('layout','pages');
			} else { //this layout has a sidebar
				//layout is a special sidebar layout
				$this->layout = $layout;
				//send which type of layout we are using to the view page. 
				$this->set('layout',$layout);
	
			}



			//set the title -->sent to layout
			$this->set('title_for_layout',$title);
			//set the title to render on the view page
			$this->set('title_view', $title);
			//set the keywords -->sent to layout
			$this->set('meta_keywords',$keywords);
			//set the description -->sent to layout
			$this->set('meta_description',$description);

			//set the body content -->sent to preview.ctp
			$contents = $this->Page_content->find('all',array('conditions'=>array('page_id'=>$page_id)));
			$this->set('pageContents',$contents);
			
			
		}
		
	}

/**
 * Publish Page
 * 
 * @return void
 */
	public function publish($id = null)
	{
			$this->Page->id = $id;
			$this->request->data['Page']['status'] = '2';
			
			if($this->Page->save($this->data)){
				$this->Session->setFlash(__('Success: You have successfully made your page public!'));
				$this->redirect(array('action'=>'view'));	
			}

	}
	
	public function test()
	{
		//choose layout
		$this->layout = 'pages';
	
	}
	

 


}
