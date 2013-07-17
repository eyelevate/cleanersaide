<?php
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 * @property Page $Page
 */
class Menu extends AppModel {
	public $name = 'Menu';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'page_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'order' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed


// ACTIONS
/**
 * Gets a list of all the non administrator pages 
 * 
 * @return array
 */
	public function getPublicPages($pages)
	{
		$return = array();
		$return[0]= array(
			'label'=>'Home Page',
			'url'=>'/'
		);
		$count_pages = count($pages);
		
		for ($i=1; $i <= $count_pages; $i++) { 
			$url = $pages[$i-1]['Page']['url'];
			$label = $pages[$i-1]['Page']['page_name'];
			$return[$i] = array(
				'label'=>$label,
				'url'=>$url
			);
		}
		return $return;
	}
	
    /**
     * Return an array of user Controllers and their methods.
     * The function will exclude ApplicationController methods
     * @return array
     */
	
    public function getAllMethods() {
 
        $aCtrlClasses = App::objects('controller');
        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));
 
                // Load its methods / actions
                $aMethods = get_class_methods($controller);
 
                // foreach ($aMethods as $idx => $method) {
//  
                    // if ($method{0} == '_') {
                        // unset($aMethods[$idx]);
                    // }
                // }
 
                // Load the ApplicationController (if there is one)
                App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');
				$controller = str_replace('Controller', '', $controller);
				$controller = preg_replace('/\B([A-Z])/', '_$1', $controller);
 				$controller_name = strtolower($controller);
				if(empty($aMethods)){
					$aMethods = array();
				}

                $controllers[$controller_name] = array_diff($aMethods, $parentActions);
            }
        }
 
        return $controllers;
    }	
	public function getIcons()
	{
		$icons = array();
		$icons['white'] = array(
			'icon-glass icon-white','icon-music icon-white','icon-search icon-white','icon-envelope icon-white','icon-heart icon-white',
			'icon-star icon-white','icon-star-empty icon-white','icon-user icon-white','icon-film icon-white','icon-th-large icon-white',
			'icon-th icon-white','icon-th-list icon-white','icon-ok icon-white','icon-remove icon-white','icon-zoom-in icon-white','icon-zoom-out icon-white',
			'icon-off icon-white','icon-signal icon-white','icon-cog icon-white','icon-trash icon-white','icon-home icon-white','icon-file icon-white',
			'icon-time icon-white','icon-road icon-white','icon-download-alt icon-white','icon-download icon-white','icon-upload icon-white',
			'icon-inbox icon-white','icon-play-circle icon-white','icon-repeat icon-white','icon-refresh icon-white','icon-list-alt icon-white',
			'icon-lock icon-white','icon-flag icon-white','icon-headphones icon-white','icon-volume-off icon-white','icon-volume-down icon-white',
			'icon-volume-up icon-white','icon-qrcode icon-white','icon-barcode icon-white','icon-tag icon-white','icon-tags icon-white','icon-book icon-white',
			'icon-bookmark icon-white','icon-print icon-white','icon-camera icon-white','icon-font icon-white','icon-bold icon-white','icon-italic icon-white',
			'icon-text-height icon-white','icon-text-width icon-white','icon-align-left icon-white','icon-align-center icon-white','icon-align-right icon-white',
			'icon-align-justify icon-white','icon-list icon-white','icon-indent-left icon-white','icon-indent-right icon-white','icon-facetime-video icon-white',
			'icon-picture icon-white','icon-pencil icon-white','icon-map-marker icon-white','icon-adjust icon-white','icon-tint icon-white',
			'icon-edit icon-white','icon-share icon-white','icon-check icon-white','icon-move icon-white','icon-step-backward icon-white',
			'icon-fast-backward icon-white','icon-backward icon-white','icon-play icon-white','icon-pause icon-white','icon-stop icon-white',
			'icon-forward icon-white','icon-fast-forward icon-white','icon-step-forward icon-white','icon-eject icon-white','icon-chevron-left icon-white',
			'icon-chevron-right icon-white','icon-plus-sign icon-white','icon-minus-sign icon-white','icon-remove-sign icon-white','icon-ok-sign icon-white',
			'icon-question-sign icon-white','icon-info-sign icon-white','icon-screenshot icon-white','icon-remove-circle icon-white','icon-ok-circle icon-white',
			'icon-ban-circle icon-white','icon-arrow-left icon-white','icon-arrow-right icon-white','icon-arrow-up icon-white','icon-arrow-down icon-white',
			'icon-share-alt icon-white','icon-resize-full icon-white','icon-resize-small icon-white','icon-plus icon-white','icon-minus icon-white',
			'icon-asterisk icon-white','icon-exclamation-sign icon-white','icon-gift icon-white','icon-leaf icon-white','icon-fire icon-white',
			'icon-eye-open icon-white','icon-eye-close icon-white','icon-warning-sign icon-white','icon-plane icon-white','icon-calendar icon-white',
			'icon-random icon-white','icon-comment icon-white','icon-magnet icon-white','icon-chevron-up icon-white','icon-chevron-down icon-white',
			'icon-retweet icon-white','icon-shopping-cart icon-white','icon-folder-close icon-white','icon-folder-open icon-white','icon-resize-vertical icon-white',
			'icon-resize-horizontal icon-white','icon-hdd icon-white','icon-bullhorn icon-white','icon-bell icon-white','icon-certificate icon-white',
			'icon-thumbs-up icon-white','icon-thumbs-down icon-white','icon-hand-right icon-white','icon-hand-left icon-white','icon-hand-up icon-white',
			'icon-hand-down icon-white','icon-circle-arrow-right icon-white','icon-circle-arrow-left icon-white','icon-circle-arrow-up icon-white','icon-circle-arrow-down icon-white',
			'icon-globe icon-white','icon-wrench icon-white','icon-tasks icon-white','icon-filter icon-white','icon-briefcase icon-white',
			'icon-fullscreen icon-white'
		);
		$icons['dark'] = array(
			'icon-glass','icon-music','icon-search','icon-envelope','icon-heart','icon-star','icon-star-empty','icon-user',
			'icon-film','icon-th-large','icon-th','icon-th-list','icon-ok','icon-remove','icon-zoom-in','icon-zoom-out',
			'icon-off','icon-signal','icon-cog','icon-trash','icon-home','icon-file','icon-time','icon-road','icon-download-alt',
			'icon-download','icon-upload','icon-inbox','icon-play-circle','icon-repeat','icon-refresh','icon-list-alt','icon-lock',
			'icon-flag','icon-headphones','icon-volume-off','icon-volume-down','icon-volume-up','icon-qrcode','icon-barcode',
			'icon-tag','icon-tags','icon-book','icon-bookmark','icon-print','icon-camera','icon-font','icon-bold','icon-italic',
			'icon-text-height','icon-text-width','icon-align-left','icon-align-center','icon-align-right','icon-align-justify',
			'icon-list','icon-indent-left','icon-indent-right','icon-facetime-video','icon-picture','icon-pencil','icon-map-marker',
			'icon-adjust','icon-tint','icon-edit','icon-share','icon-check','icon-move','icon-step-backward','icon-fast-backward',
			'icon-backward','icon-play','icon-pause','icon-stop','icon-forward','icon-fast-forward','icon-step-forward','icon-eject',
			'icon-chevron-left','icon-chevron-right','icon-plus-sign','icon-minus-sign','icon-remove-sign','icon-ok-sign','icon-question-sign',
			'icon-info-sign','icon-screenshot','icon-remove-circle','icon-ok-circle','icon-ban-circle','icon-arrow-left','icon-arrow-right',
			'icon-arrow-up','icon-arrow-down','icon-share-alt','icon-resize-full','icon-resize-small','icon-plus','icon-minus',
			'icon-asterisk','icon-exclamation-sign','icon-gift','icon-leaf','icon-fire','icon-eye-open','icon-eye-close','icon-warning-sign',
			'icon-plane','icon-calendar','icon-random','icon-comment','icon-magnet','icon-chevron-up','icon-chevron-down','icon-retweet',
			'icon-shopping-cart','icon-folder-close','icon-folder-open','icon-resize-vertical','icon-resize-horizontal','icon-hdd',
			'icon-bullhorn','icon-bell','icon-certificate','icon-thumbs-up','icon-thumbs-down','icon-hand-right','icon-hand-left',
			'icon-hand-up','icon-hand-down','icon-circle-arrow-right','icon-circle-arrow-left','icon-circle-arrow-up','icon-circle-arrow-down',
			'icon-globe','icon-wrench','icon-tasks','icon-filter','icon-briefcase','icon-fullscreen'
		);
	
		return $icons;

	}
	
	
}
