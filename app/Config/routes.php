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
	//Attractions Controller
	
	// Router::connect('/attractions/:action',array('controller'=>'attractions'));
	// Router::connect('/attractions/:action/*',array('controller'=>'attractions'));

	Router::connect('/attractions/admin',array('controller'=>'attractions','action'=>'admin'));
	Router::connect('/attractions/add',array('controller'=>'attractions','action'=>'add'));
	Router::connect('/attractions/add/*',array('controller'=>'attractions','action'=>'add'));
	Router::connect('/attractions/add/*/*',array('controller'=>'attractions','action'=>'add'));
	Router::connect('/attractions/delete/*',array('controller'=>'attractions','action'=>'delete'));
	Router::connect('/attractions/draft/*',array('controller'=>'attractions','action'=>'draft'));
	Router::connect('/attractions/edit',array('controller'=>'attractions','action'=>'edit'));
	Router::connect('/attractions/edit/*',array('controller'=>'attractions','action'=>'edit'));
	Router::connect('/attractions/request',array('controller'=>'attractions','action'=>'request'));
	Router::connect('/attractions/getCities',array('controller'=>'attractions','action'=>'getCities'));
	Router::connect('/attractions/getJson',array('controller'=>'attractions','action'=>'getJson'));
	Router::connect('/attractions/get_us_tour',array('controller'=>'attractions','action'=>'get_us_tour'));
	Router::connect('/attractions/getCanTour',array('controller'=>'attractions','action'=>'getCanTour'));
	Router::connect('/attractions/processing_frontend_attractions',array('controller'=>'attractions','action'=>'processing_frontend_attractions'));
	Router::connect('/attractions/request_edit_check',array('controller'=>'attractions','action'=>'request_edit_check'));
	Router::connect('/attractions/request_attraction_tours',array('controller'=>'attractions','action'=>'request_attraction_tours'));
	Router::connect('/attractions/request_backend_attraction_tours',array('controller'=>'attractions','action'=>'request_backend_attraction_tours'));
	Router::connect('/attractions/request_backend_age_range',array('controller'=>'attractions','action'=>'request_backend_age_range'));
	Router::connect('/attractions/imageUpload/*',array('controller'=>'attractions','action'=>'imageUpload'));
	Router::connect('/attractions/publish/*',array('controller'=>'attractions','action'=>'publish'));
	Router::connect('/attractions/preview/*',array('controller'=>'attractions','action'=>'preview'));	
	Router::connect('/attractions',array('controller'=>'attractions','action'=>'attraction_pages'));
	Router::connect('/attractions/*',array('controller'=>'attractions','action'=>'attraction_pages'));
	Router::connect('/attractions/*/*',array('controller'=>'attractions','action'=>'attraction_pages'));	
	//Hotels Controller
	Router::connect('/hotels/admin',array('controller'=>'hotels','action'=>'admin'));	
	Router::connect('/hotels/view',array('controller'=>'hotels','action'=>'view'));
	Router::connect('/hotels/view/*',array('controller'=>'hotels','action'=>'view'));
	Router::connect('/hotels/add',array('controller'=>'hotels','action'=>'add'));
	Router::connect('/hotels/add/*',array('controller'=>'hotels','action'=>'add'));
	Router::connect('/hotels/add/*/*',array('controller'=>'hotels','action'=>'add'));
	Router::connect('/hotels/delete/*',array('controller'=>'hotels','action'=>'delete'));
	Router::connect('/hotels/details',array('controller'=>'hotels','action'=>'details'));
	Router::connect('/hotels/details/*',array('controller'=>'hotels','action'=>'details'));
	Router::connect('/hotels/draft/*',array('controller'=>'hotels','action'=>'draft'));	
	Router::connect('/hotels/edit',array('controller'=>'hotels','action'=>'edit'));
	Router::connect('/hotels/edit/*',array('controller'=>'hotels','action'=>'edit'));
	Router::connect('/hotels/request',array('controller'=>'hotels','action'=>'request'));
	Router::connect('/hotels/request_edit_check',array('controller'=>'hotels','action'=>'request_edit_check'));
	Router::connect('/hotels/getCities',array('controller'=>'hotels','action'=>'getCities'));
	Router::connect('/hotels/getJson',array('controller'=>'hotels','action'=>'getJson'));
	Router::connect('/hotels/imageUpload/*',array('controller'=>'hotels','action'=>'imageUpload'));
	Router::connect('/hotels/publish/*',array('controller'=>'hotels','action'=>'publish'));
	Router::connect('/hotels/preview/*',array('controller'=>'hotels','action'=>'preview'));
	
	Router::connect('/hotels/update_confirmation',array('controller'=>'hotels','action'=>'update_confirmation'));
	Router::connect('/hotels/update_confirmation/*',array('controller'=>'hotels','action'=>'update_confirmation'));	Router::connect('/hotels/update_confirmation/*/*',array('controller'=>'hotels','action'=>'update_confirmation'));
	Router::connect('/hotels/update_confirmation/*/*/*',array('controller'=>'hotels','action'=>'update_confirmation'));
	
	Router::connect('/hotels/print_hsummary',array('controller'=>'hotels','action'=>'print_hsummary'));
	Router::connect('/hotels/print_hsummary/*',array('controller'=>'hotels','action'=>'print_hsummary'));
	Router::connect('/hotels/print_hsummary/*/*',array('controller'=>'hotels','action'=>'print_hsummary'));
	Router::connect('/hotels/print_hsummary/*/*/*',array('controller'=>'hotels','action'=>'print_hsummary'));

	Router::connect('/hotels',array('controller'=>'hotels','action'=>'hotel_pages'));
	Router::connect('/hotels/*',array('controller'=>'hotels','action'=>'hotel_pages'));
	Router::connect('/hotels/*/*',array('controller'=>'hotels','action'=>'hotel_pages'));
	
	
	Router::connect('/hotels/:action',array('controller'=>'hotels'));
	Router::connect('/hotels/:action/*',array('controller'=>'hotels'));

	
	

		
	//Exchange Rate pages
	Router::connect('/exchanges',array('controller'=>'exchanges','action'=>'index'));
	Router::connect('/exchanges/:action',array('controller'=>'exchanges'));
	Router::connect('/exchanges/:action/*',array('controller'=>'exchanges'));
	

	
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
	
	//ferries controller
	Router::connect('/ferries',array('controller'=>'ferries','action'=>'index'));
	Router::connect('/ferries/:action',array('controller'=>'ferries'));
	Router::connect('/ferries/:action/*',array('controller'=>'ferries'));	
	
	//groups Controller
	Router::connect('/groups',array('controller'=>'groups','action'=>'index'));
	Router::connect('/groups/:action',array('controller'=>'groups'));
	Router::connect('/groups/:action/*',array('controller'=>'groups'));	
	
	//inventories controller
	Router::connect('/inventories',array('controller'=>'inventories','action'=>'index'));
	Router::connect('/inventories/:action',array('controller'=>'inventories'));
	Router::connect('/inventories/:action/*',array('controller'=>'inventories'));	
	
	//incremental units controller
	Router::connect('/incremental_units',array('controller'=>'incremental_units','action'=>'index'));
	Router::connect('/incremental_units/:action',array('controller'=>'incremental_units'));
	Router::connect('/incremental_units/:action/*',array('controller'=>'incremental_units'));
	//inventories_item controller
	Router::connect('/inventory_items',array('controller'=>'inventory_items','action'=>'index'));
	Router::connect('/inventory_items/:action',array('controller'=>'inventory_items'));
	Router::connect('/inventory_items/:action/*',array('controller'=>'inventory_items'));				

	//packages Controller
	Router::connect('/packages',array('controller'=>'packages','action'=>'details'));
	Router::connect('/packages/:action',array('controller'=>'packages'));
	Router::connect('/packages/:action/*',array('controller'=>'packages'));

	//packages Controller
	Router::connect('/package_add_ons',array('controller'=>'PackageAddOns','action'=>'index'));
	Router::connect('/package_add_ons/:action',array('controller'=>'PackageAddOns'));
	Router::connect('/package_add_ons/:action/*',array('controller'=>'PackageAddOns'));

	
	//Payment pages
	Router::connect('/payments/processing',array('controller'=>'payments','action'=>'processing'));
	Router::connect('/payments/:action',array('controller'=>'payments'));
	Router::connect('/payments/:action/*',array('controller'=>'payments'));	

	//Reports Controller
	Router::connect('/reports',array('controller'=>'reports','action'=>'index'));
	Router::connect('/reports/:action',array('controller'=>'reports'));
	Router::connect('/reports/:action/*',array('controller'=>'reports'));		
		
	//reservations Controller
	Router::connect('/reservations/thank-you',array('controller'=>'reservations','action'=>'thank_you'));
	Router::connect('/reservations/confirmed/thank-you',array('controller'=>'reservations','action'=>'post_thank_you'));
	Router::connect('/reservations',array('controller'=>'reservations','action'=>'index'));
	Router::connect('/reservations/add/checkout',array('controller'=>'reservations','action'=>'backend_checkout'));
	Router::connect('/reservations/add/done',array('controller'=>'reservations','action'=>'backend_done'));	
	Router::connect('/reservations/:action',array('controller'=>'reservations'));
	Router::connect('/reservations/:action/*',array('controller'=>'reservations'));	
		
	
	//schedules controller
	Router::connect('/schedules',array('controller'=>'schedules','action'=>'index'));
	Router::connect('/schedules/:action',array('controller'=>'schedules'));
	Router::connect('/schedules/:action/*',array('controller'=>'schedules'));	

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
