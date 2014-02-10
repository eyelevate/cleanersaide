<?php
/**
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
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
//set variables here
if (!isset($username)) {
	$username = 'You are not logged in.';
} 

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Black Ball Ferry Line</title>	

		<?php 
		echo $this->fetch('meta');
		//echo $this->fetch('css');
		echo $this->Html->css(array(
			// 'bootstrap/bootstrap', 
			// 'bootstrap/bootstrap-responsive', 
			// 'admin/red', 
			// 'admin/style', 
			// 'js/admin/plugins/jBreadcrumbs/css/BreadCrumb', //breadcrumbs
			// 'js/admin/plugins/qtip2/jquery.qtip.min', //tooltips
			// 'js/admin/plugins/colorbox/colorbox', //lightbox
			// 'js/admin/plugins/google-code-prettify/prettify', //code prettifier
			// 'js/admin/plugins/sticky/sticky', //notifications
			// 'js/admin/plugins/splashy/splashy', //splashy icons **NO SUCH FILE**
			// 'js/admin/plugins/datepicker/datepicker', //flags **NO SUCH FILE**
			// 'js/admin/plugins/fullcalendar/fullcalendar_gebo', //calendar
			// 'js/admin/plugins/datepicker/datepicker', //datepicker
			// 'js/admin/plugins/fullcalendar/fullcalendar_gebo' //full calendar
			// 'js/admin/plugins/jquery.treeview/jquery.treeview.css
			
		));
		
		//compressed all of the files above to reduce http requests for development.
		echo $this->Html->css(array(
			'compressed_development', 
		));
		echo $this->fetch('css');
		?>
		
		<!-- John's CSS for test Admin functions -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />

	</head>
	<body>
		<div style="width: 960px; margin: 0px auto;">
			<?php echo $this -> fetch('content'); ?>
			<script>window.print();</script>
		</div>
		<?php //echo $this->element('sql_dump'); ?>
	</body>
</html>