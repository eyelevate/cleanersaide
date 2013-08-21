<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'home', 'home'));

/**
 * Connect the rest of the routes to the proper controllers
 */
 	//Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
 	/**no shortcuts allowed**/
 	//Pages Controller 
 	Router::connect('/hotels-attractions',array('controller'=>'pages','action'=>'hotels_attractions'));
	Router::connect('/hotels-attractions/*',array('controller'=>'pages','action'=>'hotels_attractions'));
	Router::connect('/pages/view',array('controller'=>'pages','action'=>'view'));
	Router::connect('/pages/view/*',array('controller'=>'pages','action'=>'view'));
	Router::connect('/pages/add',array('controller'=>'pages','action'=>'add'));
	Router::connect('/pages/delete/*',array('controller'=>'pages','action'=>'delete'));
	Router::connect('/pages/edit/*',array('controller'=>'pages','action'=>'edit'));
	Router::connect('/pages/edit/*',array('controller'=>'pages','action'=>'edit'));
	Router::connect('/pages/edit',array('controller'=>'pages','action'=>'edit'));
	Router::connect('/pages/edit_home',array('controller'=>'pages','action'=>'edit_home'));
	Router::connect('/pages/edit/*',array('controller'=>'pages','action'=>'edit'));
	Router::connect('/pages/publish',array('controller'=>'pages','action'=>'publish'));
	Router::connect('/pages/publish/*',array('controller'=>'pages','action'=>'publish'));
	Router::connect('/pages/preview/*',array('controller'=>'pages','action'=>'preview'));
	Router::connect('/pages/preview/**',array('controller'=>'pages','action'=>'preview'));
	Router::connect('/pages/preview/*/*',array('controller'=>'pages','action'=>'preview'));
	Router::connect('/pages/preview/**/**',array('controller'=>'pages','action'=>'preview'));
	Router::connect('/pages/preview/*/*/*',array('controller'=>'pages','action'=>'preview'));
	Router::connect('/pages/preview/**/**/**',array('controller'=>'pages','action'=>'preview'));
	Router::connect('/pages/validate_form',array('controller'=>'pages','action'=>'validate_form'));
	Router::connect('/pages/validate_form/*',array('controller'=>'pages','action'=>'validate_form'));
	Router::connect('/pages/validate_form/**',array('controller'=>'pages','action'=>'validate_form'));
	Router::connect('/pages/validate_images',array('controller'=>'pages','action'=>'validate_images'));
	Router::connect('/pages/validate_images/*',array('controller'=>'pages','action'=>'validate_images'));
	Router::connect('/pages/validate_images/**',array('controller'=>'pages','action'=>'validate_images'));
	Router::connect('/pages/validate_content',array('controller'=>'pages','action'=>'validate_content'));
	Router::connect('/pages/validate_content/*',array('controller'=>'pages','action'=>'validate_content'));
	Router::connect('/pages/validate_content/**',array('controller'=>'pages','action'=>'validate_content'));
	Router::connect('/pages/logout',array('controller'=>'pages','action'=>'logout'));
	

	/**shortcuts allowed**/
	//Users Controller 
	Router::connect('/users',array('controller'=>'users','action'=>'index'));
	Router::connect('/users/:action',array('controller'=>'users'));
	Router::connect('/users/:action/*',array('controller'=>'users'));
	
	//Groups Controller
	Router::connect('/groups',array('controller'=>'groups','action'=>'index'));
	Router::connect('/groups/:action',array('controller'=>'groups'));
	Router::connect('/groups/:action/*',array('controller'=>'groups'));

	
	//Location pages
	Router::connect('/locations',array('controller'=>'locations','action'=>'index'));
	Router::connect('/locations/:action',array('controller'=>'locations'));
	Router::connect('/locations/:action/*',array('controller'=>'locations'));

	//Tax pages
	Router::connect('/taxes',array('controller'=>'taxes','action'=>'index'));
	Router::connect('/taxes/:action',array('controller'=>'taxes'));
	Router::connect('/taxes/:action/*',array('controller'=>'taxes'));
	
	//Menus Controller
	Router::connect('/menus',array('controller'=>'menus','action'=>'index'));
	Router::connect('/menus/:action',array('controller'=>'menus'));
	Router::connect('/menus/:action/*',array('controller'=>'menus'));
	
	//admins Controller
	Router::connect('/admins',array('controller'=>'admins','action'=>'index'));
	Router::connect('/admins/:action',array('controller'=>'admins'));
	Router::connect('/admins/:action/*',array('controller'=>'admins'));
	
	//access controller
	Router::connect('/access',array('controller'=>'access','action'=>'index'));
	
	//deliveries controller
	Router::connect('/deliveries',array('controller'=>'deliveries','action'=>'index'));
	Router::connect('/deliveries/:action',array('controller'=>'deliveries'));
	Router::connect('/deliveries/:action/*',array('controller'=>'deliveries'));
	
	//groups Controller
	Router::connect('/groups',array('controller'=>'groups','action'=>'index'));
	Router::connect('/groups/:action',array('controller'=>'groups'));
	Router::connect('/groups/:action/*',array('controller'=>'groups'));	
	
	//inventories controller
	Router::connect('/inventories',array('controller'=>'inventories','action'=>'index'));
	Router::connect('/inventories/:action',array('controller'=>'inventories'));
	Router::connect('/inventories/:action/*',array('controller'=>'inventories'));	
	
	//inventories_item controller
	Router::connect('/inventory_items',array('controller'=>'inventory_items','action'=>'index'));
	Router::connect('/inventory_items/:action',array('controller'=>'inventory_items'));
	Router::connect('/inventory_items/:action/*',array('controller'=>'inventory_items'));				

	
	//inventories_item controller
	Router::connect('/invoices',array('controller'=>'invoices','action'=>'index'));
	Router::connect('/invoices/:action',array('controller'=>'invoices'));
	Router::connect('/invoices/:action/*',array('controller'=>'invoices'));			

	Router::connect('/main',array('controller' => 'pages', 'action' => 'home', 'home'));
	Router::connect('/main/*',array('controller' => 'pages', 'action' => 'home', 'home'));




	/** MUST BE AT END **/

 	//Router::connect('/*', array('controller' => 'pages','action'=>'url'));
	Router::connect('/*', array('controller' => 'pages','action'=>'url'));
	Router::connect('/**', array('controller' => 'pages','action'=>'url'));
	//Router::connect('/**/**', array('controller' => 'pages','action'=>'url'),array('pass' => 'slug'));	
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
