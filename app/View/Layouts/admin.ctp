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
			'bootstrap/bootstrap.min', 
			'bootstrap/bootstrap-responsive.min', 
			'admin/red',
			'compressed_stylesheet'
		));
		
		echo $this->fetch('css');
		echo $this->fetch('meta');


	?>
</head>
<body>
		<div id="loading_layer" style="display:none"><img src="/img/admin/ajax_loader.gif" alt="" />
		</div>

		<div id="maincontainer" class="clearfix">
			<!-- header -->
			<header>
				<div class="navbar navbar-fixed-top">
					<div class="navbar-inner">
						<div class="container-fluid">
							<a class="brand" href="/admins" style="line-height: 40px;">Jays Cleaners</a>
							<ul class="nav user_menu pull-right">
								<li class="hidden-phone hidden-tablet">
									<div class="nb_boxes clearfix"></div>
								</li>
								<li class="divider-vertical hidden-phone hidden-tablet"></li>

								<li class="divider-vertical hidden-phone hidden-tablet"></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $username;?> <? if ($username != "You are not logged in.") {echo '<b class="caret"></b>';} ?></a>
									<ul class="dropdown-menu">
										<li>
											<a href="/admins/logout">Log Out</a>
										</li>
									</ul>
								</li>
							</ul>
							<a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu"> <span class="icon-align-justify icon-white"></span> </a>

						</div>
					</div>
				</div>

			</header>

			<!-- main content -->
			<div id="contentwrapper">
				<div class="main_content">
					<!-- any flash messages goes here -->
					<?php
					echo $this->TwitterBootstrap->flashes(array(
					    "auth" => true,
					    "closable"=>true
					    )
					);
					?>
					<?php echo $this -> fetch('content'); ?>

				</div>
			</div>

			<!-- sidebar -->
			<a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
			<div class="sidebar">
				<div class="antiScroll">
					<div class="antiscroll-inner">
						<div class="antiscroll-content">
							<div class="sidebar_inner">
								
							</div>
							<div class="push"></div>
						</div>
					</div>
				</div>
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
		'plugins/list_js/list.min.js', 
		'plugins/list_js/plugins/paging/list.paging.js', //sortable/filterable lists
		'plugins/tiny_mce/jquery.tinymce.js', //tinymce and the file uploader
		'plugins/plupload/js/plupload.full.js',
		'plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.full.js',
		'plugins/datepicker/bootstrap-datepicker.min.js',
		'plugins/stepy/js/jquery.stepy.min.js', 

	));	
	
	echo $this->fetch('script');
	?>
	<script>
		$(document).ready(function() {
			//* show all elements & remove preloader
			setTimeout('$("html").removeClass("js")', 250);
		});
	</script>

</body>
</html>
