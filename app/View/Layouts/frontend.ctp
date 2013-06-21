<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('Eyelevate', 'Jays Cleaners');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//compressed all of the files above to reduce http requests for development.
		echo $this->Html->css(array(
			'compressed_development', 
		));
		echo $this->fetch('css');
		echo $this->fetch('meta');


	?>
	<script>
		// hide all elements & show preloader
		document.documentElement.className += 'js';
	</script>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php
	 echo $this -> Html -> script(array(//a lot of this is more than we need, but I will optimize later JFD 10/9
		'admin/jquery.min.js', //jQuery
		'bootstrap/bootstrap.js', //main Bootstrap JS
		'bootstrap/bootstrap.plugins.js', //Bootstrap Plugins
		'admin/jquery.debouncedresize.min.js', //smart resize event
		'admin/jquery.actual.min.js', //hidden elements
		'admin/jquery.cookie.min.js', //js cookie plugin
		'plugins/qtip2/jquery.qtip.min.js', //tooltips
		'plugins/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js', //breadcrumbs
		'plugins/colorbox/jquery.colorbox.min.js', //lightbox
		'admin/ios-orientationchange-fix.js', //fix for iOS orientation, needed for responsiveness
		'plugins/antiscroll/antiscroll.js', 
		'plugins/antiscroll/jquery-mousewheel.js', //JS scrollbar. ideally I would not like to use this but it is here in case.
		'plugins/UItoTop/jquery.ui.totop.min.js', //"to top of screen" function
		'plugins/jquery-ui/jquery-ui-1.8.23.custom.min.js', //Custom jQuery UI
		'plugins/forms/jquery.ui.touch-punch.min.js', //touch events for jQ UI
		'admin/jquery.imagesloaded.min.js', 
		'admin/jquery.wookmark.js', //multi-column layout
		'admin/jquery.mediaTable.min.js', //responsive table
		'admin/jquery.peity.min.js', //small charts
		//'admin/plugins/flot/jquery.flot.min.js', 'admin/plugins/flot/jquery.flot.resize.min.js', 'admin/plugins/flot/jquery.flot.pie.min.js', //charts
		'plugins/visualize/jquery.visualize.js', //charts
		'plugins/fullcalendar/fullcalendar.min.js', //calendar
		'plugins/list_js/list.min.js', 'admin/plugins/list_js/plugins/paging/list.paging.js', //sortable/filterable lists
		'plugins/tiny_mce/jquery.tinymce.js', //tinymce and the file uploader
		'plugins/plupload/js/plupload.full.js',
		'plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.full.js',
		'plugins/datepicker/bootstrap-datepicker.min.js',
		'plugins/stepy/js/jquery.stepy.min.js', 

	));	
	
	echo $this->fetch('script');
	?>
</body>
</html>
