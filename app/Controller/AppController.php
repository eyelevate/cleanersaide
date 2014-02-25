<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    //Helpers
    public $helpers = array(
        'Form',
        'Html',
        'Js'=>array("Jquery"), 
        'Session',
        'Number',
    	'TB' => array(
        	"className" => "TwitterBootstrap.TwitterBootstrap"
    	)
    );
	
	//components
	public $components = array(
		'Acl',
		'Session',
		'Cookie',
		'RequestHandler',
		'AuthorizeNet',
		'Auth'=>array(
 			'loginAction'=>array('controller'=>'admins','action'=>'login'),
          	'loginRedirect'=>array('controller'=>'admins','action'=>'index'),
          	'logoutRedirect'=>array('controller'=>'admins','action'=>'login'),
          	'authError'=>'You have been logged out. Please log in again.',
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
	public function isAuthorized($user)
	{
		return true;
	}
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		
		// //REDIRECT TO HTTPS IF REQUEST IS NOT HTTPS
		// if($_SERVER['HTTPS']!="on")
		// {
		// $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		// header( "HTTP/1.1 301 Moved Permanently" );
		// header("Location:$redirect");
		// exit;
		// }
	}

}
