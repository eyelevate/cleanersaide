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

$cakeDescription = __d('Brevica', 'Black Ball Ferry Line');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?> |
		<?php echo $title_for_layout; ?> |
		<?php echo 'Daily Departures to Victoria and Port Angeles';?>
	</title>
	
		<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	if (isset($meta_keywords)) {
		echo $this->Html->meta('keywords',$meta_keywords);
	} 
	if (isset($meta_description)){
		echo $this->Html->meta('description',$meta_description);
	} 	
	?>
	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="/css/frontend/skeleton.css">
	<link rel="stylesheet" href="/css/frontend/style.css">

	<link href='//fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>

	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" media="screen" href="stylesheets/sequencejs-theme.sliding-horizontal-parallax-ie.css" /><![endif]-->

	<link rel="stylesheet" href="/css/frontend/flexslider.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/css/frontend/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="/css/frontend/carousel.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/js/frontend/plugins/jReject/jquery.reject.css" type="text/css" media="screen" />
	<?php
	//gathering page specific css
	echo $this->fetch('css');
	?>	
	<!-- JS
  ================================================== -->	
	<script type="text/javascript" src="/js/frontend/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/js/frontend/jquery.easing.1.3.js"></script>
	
	<script type="text/javascript" src="/js/frontend/sequence.jquery-min.js"></script>	
	<!-- <script type="text/javascript" src="/js/frontend/jquery.quicksand.js"></script> -->

	<script type="text/javascript" src="/js/frontend/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="/js/frontend/jquery.jcarousel.min.js"></script>
	<script type="text/javascript" src="/js/frontend/jquery.reject.min.js"></script>
	<script type="text/javascript" src="/js/frontend/common.js"></script>
	<?php
	//gathering page specific js files
	echo $this->fetch('script');
	?>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="/img/frontend/favicon.png">
	
	<?php
		//echo $this->Html->meta('icon');

		//echo $this->Html->css(array('cake.generic','reset'));

		//echo $this->fetch('meta');
		//echo $this->fetch('css');
		//echo $this->fetch('script');
	?>
</head>
<body>
  <div id="wrapper">
  	<div id="header" class="container">

	  <div class="header clearfix row">
			<div class="eight columns header_left">
				<a href="/"><img src="/img/frontend/logo.png"/></a>
			</div>
			<div class="eight columns">
				<div class="header_right clearfix">
				    <a href='http://www.twitter.com/mvcoho' target='_blank' class='icon_tweet' title='Follow Us on Twitter'>Follow Us on Twitter</a>
				    <a href='http://www.facebook.com/mvcoho' target='_blank' class='icon_facebook' title='Follow Us on Facebook'>Follow Us on Facebook</a>
					<a href="/contact-us" class="header_link first">Contact Us</a>
					<a href="/frequently-asked-questions" class="header_link">FAQ</a>
				</div>
			</div>
		</div>
		
		<?php
		//creates the admin navigation and selects the page

		if(isset($primary_nav)){ ?>
			<div class="row no_bm">
				<div class="light_menu">
					<div id="menu">
						<ul>
							<?
							//set the collapsing id for the view
							$collapse_id = 0;
							
							foreach ($primary_nav as $key => $value) {
								$mainHeader = $key;
								$name = $primary_nav[$mainHeader]['name'];
								$url = str_replace('/index','',$primary_nav[$mainHeader]['url']);
								$icon = $primary_nav[$mainHeader]['icon'];
								$collapse_id = $collapse_id+1;
	
								switch ($url) {
									case '/pages/hotels_attractions':
										?>
									    <li><a href="/hotels-attractions">Hotels + Attractions</a>
									       <div>	
									          	<ul>
									          		<?php
									          		foreach ($ha_locations as $h) {
														$name = $h['Location']['name'];
														$city = $h['Location']['city'];
														$url_city = str_replace(' ','-',strtolower($city));
														$state = $h['Location']['state'];
														$location = $city.', '.$state;
														
														?>
														<li>
														<?php
														//echo $this->Html->link($city,array('controller'=>'pages','action'=>'hotels_attractions',$url_city));
														echo $this->Html->link($this->Html->tag('span',__($city,true)) ,array('controller'=>'pages','action'=>'hotels_attractions',$url_city),array('escape'=>false));
				
														?>
														</li>
														<?php
													}
									          		?>
												</ul>
									       </div>
									    </li>
										<?
										break;
									case '/packages/home':
										?>
										<li><a href="/packages/home">Package Deals</a>
									       <div>
									          	<ul>
									          		<?php
									          		foreach ($ha_locations as $h) {
														$name = $h['Location']['name'];
														$city = $h['Location']['city'];
														$url_city = str_replace(' ','-',strtolower($city));
														$state = $h['Location']['state'];
														$location = $city.', '.$state;
														
														?>
														<li>
														<?php
														echo $this->Html->link($this->Html->tag('span',__($city.' Packages',true)) ,array('controller'=>'packages','action'=>'home',$url_city),array('escape'=>false));
														//echo $this->Html->link($this->Html->tag('span',__('News',true)),array('controller'=>'news','action'=>'index'),array('escape'=>false,'class'=>'news'));
														
														?>
														</li>
														<?php
													}
									          		?>
												</ul>
									       </div>
									    </li>
									    <?
										break;
									
									default:
										?>
										<li><a href="<? echo $url; ?>"><? echo $name; ?></a>
											<?php
											if($primary_nav[$mainHeader]['next'] != 'empty'){ ?>
												<div>
			          								<ul> <?
												foreach ($primary_nav[$mainHeader]['next'] as $key=>$value) {
													$name = $primary_nav[$mainHeader]['next'][$key]['name'];
													$url = $primary_nav[$mainHeader]['next'][$key]['url'];
											
													$icon = $primary_nav[$mainHeader]['next'][$key]['icon'];
													if(isset($primary_pages)){
														if($url == $primary_pages){
															$selected = 'active';	
														} else {
															$selected = 'notactive';
														}
													} else {
														$selected = 'notactive';
													}
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
														<li class="<?php echo $selected;?>"><a href="<?php echo str_replace('/index','',$url);?>"><span><i class="<?php $icon;?>"></i><?php echo $name;?></span></a></li>
														<?php
														break;
													}
												}
												?>
												</ul>
											</div>
												<?
											}
											?></li><?
										break;
								}
							}
?> 
			</ul>
		</div>
		
<!-- 				<select id="select_menu" onchange="location = this.value">
			  		<option value="">Select Page</option>
			        <option value="/reservations/ferry">Fares + Schedule</option>
			        <option value="/packages">Package Deals</option>
			        <option value="/hotels-attractions">Hotels + Attractions</option>
			        <option value="#">The Ship</option>        
			        <option value="#">Travel Info</option>  
			        <option value="#">&nbsp;&nbsp;&nbsp;&nbsp;Test</option>
			        <option value="#">&nbsp;&nbsp;&nbsp;&nbsp;Test</option>
			        <option value="#">&nbsp;&nbsp;&nbsp;&nbsp;Test Test Longer Item</option>
			    </select> -->
				
				<select id="select_menu" onchange="location = this.value">
			    <?
    			foreach ($primary_nav as $key => $value) {
					$mainHeader = $key;
					$name = $primary_nav[$mainHeader]['name'];
					$url = str_replace('/index','',$primary_nav[$mainHeader]['url']);
					$icon = $primary_nav[$mainHeader]['icon'];
					$collapse_id = $collapse_id+1;
					?>
					<option value="<? echo $url; ?>"><? echo $name; ?></option>
					<?php
					if($primary_nav[$mainHeader]['next'] != 'empty'){ ?>
						<?
						foreach ($primary_nav[$mainHeader]['next'] as $key=>$value) {
							$name = $primary_nav[$mainHeader]['next'][$key]['name'];
							$url = $primary_nav[$mainHeader]['next'][$key]['url'];
							?>
							<option value="<?php echo str_replace('/index','',$url);?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name;?></option>
							<?php
							}
						}
					}	?>			    
				</select>

		
	</div>
</div>
<?
								} else {
								?>
		
		
		<!-- Main Navigation -->
		<div class="row no_bm">
			<div class="light_menu">
				<div id="menu">
					<ul>
					  	<li><a href="/reservations/ferry">Fares + Schedule</a></li>
					    <li><a href="/packages">Package Deals</a>
					       <div>
					          	<ul>
					          		<?php
					          		foreach ($ha_locations as $h) {
										$name = $h['Location']['name'];
										$city = $h['Location']['city'];
										$url_city = str_replace(' ','-',strtolower($city));
										$state = $h['Location']['state'];
										$location = $city.', '.$state;
										?>
										<li>
										<?php
										echo $this->Html->link($this->Html->tag('span',__($city.' Packages',true)) ,array('controller'=>'packages','action'=>'home',$url_city),array('escape'=>false));
								
										?>
										</li>
										<?php
									}
					          		?>
								</ul>
					       </div>
					    </li>
					    <li><a href="/hotels-attractions">Hotels + Attractions</a>
					       <div>	
					          	<ul>
					          		<?php
					          		foreach ($ha_locations as $h) {
										$name = $h['Location']['name'];
										$city = $h['Location']['city'];
										$url_city = str_replace(' ','-',strtolower($city));
										$state = $h['Location']['state'];
										$location = $city.', '.$state;
										
										?>
										<li>
										<?php
										//echo $this->Html->link($city,array('controller'=>'pages','action'=>'hotels_attractions',$url_city));
										echo $this->Html->link($this->Html->tag('span',__($city,true)) ,array('controller'=>'pages','action'=>'hotels_attractions',$url_city),array('escape'=>false));

										?>
										</li>
										<?php
									}
					          		?>
								</ul>
					       </div>
					    </li>
					    <li><a href="#">The Ship</a></li>
					    <li><a href="#">Travel Info</a>
					       <div style="right:-56px;">
					          	<ul>
							  		<li><a href="#"><span>Test</span></a></li>
							  		<li><a href="#"><span>Test</span></a></li>
							  		<li><a href="#" class="last_submenu_item"><span>Test Test Longer Item</span></a></li>
								</ul>
					       </div>
					    </li>
					</ul>
				</div>
				
				
				<select id="select_menu" onchange="location = this.value">
			  		<option value="">Select Page</option>
			        <option value="/reservations/ferry">Fares + Schedule</option>
			        <option value="/packages">Package Deals</option>
			        <option value="/hotels-attractions">Hotels + Attractions</option>
			        <option value="#">The Ship</option>        
			        <option value="#">Travel Info</option>  
			        <option value="#">&nbsp;&nbsp;&nbsp;&nbsp;Test</option>
			        <option value="#">&nbsp;&nbsp;&nbsp;&nbsp;Test</option>
			        <option value="#">&nbsp;&nbsp;&nbsp;&nbsp;Test Test Longer Item</option>
			    </select>
						
			</div>
		</div> <? } //end else ?>
		<!-- Main Navigation::END -->
	</div>


	<!-- <div class="container"> -->

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		<div class="clear"></div>
	</div>
</div> <!-- Wrapper::END -->

<!-- Footer -->
<div id="footer">
  <div class="footer_btm container">
  	<div class="footer_btm_inner">  
	  	<div id="footer_nav">
	  		<a href="/reservations/ferry" >Fares + Schedules</a>
	  		<a href="/packages/home" >Package Deals</a>
	  		<a href="/hotels-attractions" >Hotels + Attractions</a>
	  		<a href="/MV-Coho" >The Ship</a>
	  		<a href="/Frequently-Asked-Questions" >Travel Info</a>
	  	</div>
	</div>	  
  </div>
</div>
<!-- Footer::END -->
	
<!-- <script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	try {
		var pageTracker = _gat._getTracker("UA-2746845-29");
		pageTracker._trackPageview();
	} 
	catch(err) {}
</script> -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41469718-1', 'cohoferry.com');
  ga('send', 'pageview');

</script>
<?php
if(!empty($_SESSION['GA_tracking'])){
	echo $this->Html->scriptBlock($_SESSION['GA_tracking'], array('inline'=>true));
	//echo $_SESSION['post_message'];
	unset($_SESSION['GA_tracking']);	
}

?>
</body>
</html>
