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
		<?php
		$title_for_layout = (!isset($title_for_layout)) ? 'Cleanersaide' : $title_for_layout;

		?>
		<title><?php echo $title_for_layout;?></title>	

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
		<!-- Favicons
		================================================== -->
		<link rel="shortcut icon" href="/img/frontend/favicon.ico">	
		<!-- John's CSS for test Admin functions -->
		
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans" />

		<!--[if lte IE 8]>
		<link rel="stylesheet" href="css/ie.css" />
		<script src="js/ie/html5.js"></script>
		<script src="js/ie/respond.min.js"></script>
		<script src="lib/flot/excanvas.min.js"></script>
		<![endif]-->

		<script>
			// hide all elements & show preloader
			document.documentElement.className += 'js';
					
		</script>
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
							<a class="brand" href="/admins" style="line-height: 40px;">Cleanersaide</a>
							<ul class="nav user_menu pull-right">
								<li class="hidden-phone hidden-tablet">
									<div class="nb_boxes clearfix"></div>
								</li>
								<?php
								
								if(isset($rewards_display)){
									$reward_title = ($reward_status == 2) ? 'Reward Points <span class="label label-inverse" style="font-size:larger;">'.$reward_points.'</span> <b class="caret"></b>' : 'Reward Program Not Activated <b class="caret"></b>';
								?>
								<li class="divider-vertical hidden-phone hidden-tablet"></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $reward_title;?> </a>
									<ul class="dropdown-menu">
										<?php
										if($reward_status == 1){
										?>
										<li>
											<a href="/rewards/activate/<?php echo $customer_id;?>">Activate Reward Program</a>
										</li>
										<?php
										} else {
										?>
										<li>
											<a href="/rewards/view/<?php echo $customer_id;?>">Rewards History</a>
										</li>
										<li>
											<a href="/rewards/deactivate/<?php echo $customer_id;?>">De-activate Rewards Program</a>
										</li>
										<?php	
										}
										?>
										
									</ul>
								</li>
								<?php	
								}
								?>
								
								
								<li class="divider-vertical hidden-phone hidden-tablet"></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $username;?> 
									<?php if ($username != "You are not logged in.") { echo '<b class="caret"></b>';} ?>
									</a>
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
								<? if(isset($admin_nav)){ ?>
								<form id="searchForm" action="/admins/search_customers" class="input-append" method="post" >
									<input id="searchCustomerInput" name="query" placeholder="Phone / Last Name / ID" class="input-medium" size="16" type="text" placeholder="Search..." />
									<button id="searchButton" type="submit" class="btn">
										<i class="icon-search"></i>
									</button>
								</form> <? } ?>
								<div id="side_accordion" class="accordion">
								<?php
								//creates the admin navigation and selects the page
								if(isset($admin_nav)){
									//set the collapsing id for the view
									$collapse_id = 0;
									//loop the values and create the necessary variables
									foreach ($admin_nav as $key => $value) {
										$mainHeader = $key;
										$name = $admin_nav[$mainHeader]['name'];
										$url = str_replace('/index','',$admin_nav[$mainHeader]['url']);
										$icon = $admin_nav[$mainHeader]['icon'];
										$collapse_id++;
										$firstClass =($admin_check == $name) ? 'accordion-toggle' : 'accordion-toggle collapsed';
										$secondClass = ($admin_check == $name) ?  'accordion-body in collapse' : 'accordion-body collapse';
										?>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a href="#collapse-<?php echo $collapse_id;?>" data-parent="#side_accordion" data-toggle="collapse" class="<?php echo $firstClass;?>"> <i class="<?php echo $icon;?>"></i> <?php echo $name;?></a>
											</div>
											<div class="<?php echo $secondClass;?>" id="collapse-<?php echo $collapse_id;?>">
												<div class="accordion-inner">
													<ul class="nav nav-list">
													<?php
													if($admin_nav[$mainHeader]['next'] != 'empty'){
														foreach ($admin_nav[$mainHeader]['next'] as $key=>$value) {
															$name = $admin_nav[$mainHeader]['next'][$key]['name'];
															$url = $admin_nav[$mainHeader]['next'][$key]['url'];
															$icon = $admin_nav[$mainHeader]['next'][$key]['icon'];
															$selected = (isset($admin_pages) && $url == $admin_pages) ? 'active' : 'notactive';	
		
															switch ($url) {
																case 'Sub Header':
																?>
																<li class="nav-header"><i class="<?php $icon;?>"></i><?php echo $name;?></li>
																<?php								
																break;
																case 'Line Break';
																?>
																<li class="divider"></li>
																<?php
																break;
																default:
																//enter in the $url variable for production
																?>
																<li class="<?php echo $selected;?>"><a href="<?php echo str_replace('/index','',$url);?>"><i class="<?php $icon;?>"></i><?php echo $name;?></a></li>
																<?php
																break;
															}
														}
													}
													?>
													</ul>
												</div>
											</div>
										</div>		
										<?php
									}
								}
								?>
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
	'admin/plugins/qtip2/jquery.qtip.min.js', //tooltips
	'admin/plugins/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js', //breadcrumbs
	'admin/plugins/colorbox/jquery.colorbox.min.js', //lightbox
	'admin/ios-orientationchange-fix.js', //fix for iOS orientation, needed for responsiveness
	'admin/plugins/antiscroll/antiscroll.js', 
	'admin/plugins/antiscroll/jquery-mousewheel.js', //JS scrollbar. ideally I would not like to use this but it is here in case.
	'admin/plugins/UItoTop/jquery.ui.totop.min.js', //"to top of screen" function
	'admin/plugins/jquery-ui/jquery-ui-1.8.23.custom.min.js', //Custom jQuery UI
	'admin/plugins/forms/jquery.ui.touch-punch.min.js', //touch events for jQ UI
	'admin/jquery.imagesloaded.min.js', 'admin/jquery.wookmark.js', //multi-column layout
	'admin/jquery.mediaTable.min.js', //responsive table
	'admin/jquery.peity.min.js', //small charts
	'admin/plugins/visualize/jquery.visualize.js', //charts
	'admin/plugins/fullcalendar/fullcalendar.min.js', //calendar
	'admin/plugins/list_js/list.min.js', 'admin/plugins/list_js/plugins/paging/list.paging.js', //sortable/filterable lists
	'admin/plugins/tiny_mce/jquery.tinymce.js', //tinymce and the file uploader
	'admin/plugins/plupload/js/plupload.full.js',
	'admin/plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.full.js',
	//'admin/plugins/datepicker/bootstrap-datepicker.min.js',
	
	'admin/plugins/stepy/js/jquery.stepy.min.js', 
	'admin/dashboard.js', //global JS functions	
	'admin/forms.js', //global JS functions
	'admin/common.js' //global JS functions
	));	
	
	echo $this->fetch('script');
 ?>

		<script type="text/javascript">
			$(document).ready(function() {
				//* show all elements & remove preloader
				setTimeout('$("html").removeClass("js")', 250);
				setTimeout(function(){
					$("#searchCustomerInput").focus();	
				}, 1000)
			});
		</script>

		</div>
		<?php //echo $this->element('sql_dump'); ?>
	</body>
</html>