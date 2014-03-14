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

$cakeDescription = __d('Eyelevate', 'Jays Cleaners');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?> |
		<?php echo $title_for_layout; ?> |
		<?php echo ' Expert Toxin-Free Dry Cleaning and Alterations. Free pick up and delivery to Seattle neighborhoods!';?>
	</title>
	
		<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="author" content="Jays Cleaners" />
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
	<link rel="shortcut icon" href="/img/frontend/favicon.ico">
	
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

			<div class="eight columns header_left alpha">
				<a href="/" class="pull-left"><img src="/img/frontend/jaysLogo2.png"/></a>
				<span id="rooseveltName" class="twelve columns alpha"><strong><em>ROOSEVELT</em></strong></span>		
			</div>
			<div class="eight columns">
				<div class="header_right clearfix">
					<a id="image_header_right" href="/deliveries"><img src="/img/frontend/jaysDeliveryTruck.png"/></a>
				    <!-- <a href='http://www.twitter.com/mvcoho' target='_blank' class='icon_tweet' title='Follow Us on Twitter'>Follow Us on Twitter</a>
				    <a href='http://www.facebook.com/mvcoho' target='_blank' class='icon_facebook' title='Follow Us on Facebook'>Follow Us on Facebook</a>
					<a href="/contact-us" class="header_link first">Contact Us</a>
					<a href="/frequently-asked-questions" class="header_link">FAQ</a> -->
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
							<?php
							//set the collapsing id for the view
							$collapse_id = 0;
							foreach ($primary_nav as $key => $value) {
								$mainHeader = $key;
								$name = $primary_nav[$mainHeader]['name'];
								$url = str_replace('/index','',$primary_nav[$mainHeader]['url']);
								
								$icon = $primary_nav[$mainHeader]['icon'];
								$collapse_id = $collapse_id+1;
								
								if($url == 'Home Page'){
									$href="href='/'";
								} else {
									$href="";
								}
								?>
								<li><a <?php echo $href;?> style="cursor:pointer;"><?php echo $name; ?></a>
									<?php
									if($primary_nav[$mainHeader]['next'] != 'empty'){ ?>
										<div>
	          								<ul> 
	          								<?php
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
												//enter in the $url variable for production
												?>
												<li class="<?php echo $selected;?>"><a href="<?php echo str_replace('/index','',$url);?>"><span><i class="<?php $icon;?>"></i><?php echo $name;?></span></a></li>
												<?php
											}
											?>
											</ul>
										</div>
									<?php
									}
									?>
								</li>
							<?php
							}
							?> 
						</ul>
					</div>

				<select id="select_menu" onchange="location = this.value">
					<option>Main Menu</option>
			    <?php
    			foreach ($primary_nav as $key => $value) {
    				
					$mainHeader = $key;
					if($mainHeader=='Home'){
					?>
					<optgroup label="Home">
						<option value="/">Home</option>	
					</optgroup>
					
					<?php
					} else {
					?>
					<optgroup label="<?php echo $mainHeader;?>">
					<?php
					if($primary_nav[$mainHeader]['next'] != 'empty'){ 
						foreach ($primary_nav[$mainHeader]['next'] as $key=>$value) {
							$name = $primary_nav[$mainHeader]['next'][$key]['name'];
							$url = $primary_nav[$mainHeader]['next'][$key]['url'];
							?>
							<option value="<?php echo str_replace('/index','',$url);?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name;?></option>
							<?php
						}
					}					
					?>	
					</optgroup>
					<?php						
					}


				}	
				?>		    
				</select>					
				</div>
			</div>
		<?php 
		} 
		?>
		<!-- Main Navigation::END -->
	</div>


	<!-- <div class="container"> -->

			<!-- any flash messages goes here -->
			<?php
			echo $this->TwitterBootstrap->flashes(array(
			    "auth" => true,
			    "closable"=>true
			    )
			);
			?>

			<?php echo $this->fetch('content'); ?>
		<div class="clear"></div>

	</div>
</div> <!-- Wrapper::END -->

<!-- Footer -->
<div id="footer">
  <div class="footer_btm container">
  	<div class="footer_btm_inner">  
	  	<div id="footer_nav" class="sixteen columns alpha" style="padding-bottom:25px; padding-top:25px;">
	  		<a class="pull-left" href="/Terms-of-Service-and-Privacy" >Terms & Privacy</a>
	  		<a class="pull-left" href="/Contact-Us" >Contact Us</a>
	  		
	  	</div>
	  	<div class="pull-left" style="padding-top:25px;">
			<a style="margin-top:25px;" target="_blank" href="https://www.google.com/maps/place/Jay's+Dry+Cleaners+Roosevelt/@47.6756139,-122.3198324,17z/data=!4m7!1m4!3m3!1s0x5490146eff972b9f:0xfb49846026dc31f2!2s801+NE+65th+St!3b1!3m1!1s0x0:0x930183a6eaae85fe">
				<span>@<?php echo date('Y');?> Jays Dry Cleaners Roosevelt</span> |
				<em>801 NE 65th St., Suite B</em> |
				<em>Seattle, WA 98115</em> |
				<em>(206) 453-5930</em>
			</a>	  		
	  	</div>
	  	<a class="pull-left" target="blank"href="http://ssl.comodo.com/" style="margin:0px; padding:0px;"/><img src="/img/frontend/comodo.png"/></a>
	</div>	  
  </div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-48780051-1', 'jayscleaners.com');
  ga('send', 'pageview');
</script>
</body>
</html>