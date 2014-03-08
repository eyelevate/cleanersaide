<?php

//set all variables here

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		//set meta data here SEO
		echo $this->Html->meta('icon');
		if (isset($meta_keywords)) {
			echo $this->Html->meta('keywords',$meta_keywords);
		} 
		if (isset($meta_description)){
			echo $this->Html->meta('description',$meta_description);
		} 
		echo $this->Html->css(array('cake.generic','reset'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="/img/frontend/favicon.ico">
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $title_for_layout;?></h1>
		</div>

		<div id="content">
			<div id="navigation">
				<h1></h1>
				<?php
				if(isset($menus)):
				?>
				<div id="navigationLINK">
					<ul id="menuNavUl">
					<?php
					//show all TIER 1
					foreach ($menus as $menu):
						$tier1_name=$menu['name'];
						$tier1_url = $menu['url'];
						$tier1_id = $menu['id'];
						$tier2 = $menu[2];
						//if there is NO tier 2
						if($tier2 == 'empty'){
							if($tier1_url == 'none'){
							?>
							<li id="menuNavLi-<?php echo $tier1_id;?>" class="menuNavigationLi">
								<?php echo $tier1_name;?>
							</li>	
							<?php						
							} else{
							?>
							<li id="menuNavLi-<?php echo $tier1_id;?>" class="menuNavigationLi">
								<a class="menuNavLink-<?php echo $tier1_id;?>" href="<?php echo $tier1_url;?>"/><?php echo $tier1_name;?></a>
							</li>
							<?php
							}		
						//if there is a Tier 2					
						} else {
							//if there is no link
							if($tier1_url == 'none'){		
							?>
							<li id="menuNavLi-<?php echo $tier1_id;?>" class="menuNavigationLi">
								<?php echo $tier1_name;?>
							</li>
								
							<ul>
								<?php
								debug($menus[$tier1_id][2]);
								foreach ($menus[$tier1_id][2] as $menu2) {
									$tier2_name = $menu2['name'];
									$tier2_id = $menu2['id'];
									$tier2_url = $menu2['url'];
									$tier3 = $menus[$tier1_id][2][3];
									
									//IF there is NO tier3
									if($tier3== 'empty'){
										//if there is no link for tier 2
										if($tier2_url=='none'){
										?>
										<li><?php echo $tier2_name;?></li>
										<?php
										} else {
										?>
										<li>
											<a href="<?php echo $tier2_url;?>"><?php echo $tier2_name;?></a>
										</li>
										<?php
										}
									//IF there IS a tier 3
									} else {
										//if there is no link for tier 2
										if($tier2_url=='none'){
										?>
										<li><?php echo $tier2_name;?></li>
										<ul>
										<?php												
										foreach ($menus[$tier1_id][2] as $menu3) {
											$tier3_name = $menu3['name'];
											$tier3_id = $menu3['id'];
											$tier3_url = $menu3['url'];	
											if($tier3_url=='none'){
											?>
												<li><?php echo $tier3_name;?></li>
											<?php
											} else {
											?>
												<li><a href="<?php echo $tier3_url;?>"><?php echo $tier3_name;?></a></li>
											<?php	
											}
										}
										?>
										</ul>
										<?php
										} else {
										?>
										<li><a href="<?php echo $tier2_url;?>"><?php echo $tier2_name;?></a></li>
										
										<?php
										}											
									}
								}
								?>
							</ul>
							<?php						
							} else{
							?>
							<li id="menuNavLi-<?php echo $tier1_id;?>" class="menuNavigationLi">
								<a class="menuNavLink-<?php echo $tier1_id;?>" href="<?php echo $tier1_url;?>"/><?php echo $tier1_name;?></a>
							</li>
							<?php
							}							
						}

					endforeach;
					?>
					</ul>
				</div>		
				<?php
				endif;
				?>
			</div>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<!-- Footer -->
		<div id="footer">
		  <div class="footer_btm container">
		  	<div class="footer_btm_inner">  
			  	<div id="footer_nav">
			  		<a class="pull-left" href="/Terms-of-Service-and-Privacy" >Terms & Privacy</a>
			  		<a class="pull-left" href="/Contact-Us" >Contact Us</a>
					<a class="pull-right" target="blank"href="http://ssl.comodo.com/"/><img src="/img/frontend/comodo.png"/></a>
			  	</div>
			</div>	  
		  </div>
		</div>
	</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-48780051-1', 'jaysdrycleaners.com');
  ga('send', 'pageview');
</script>
</body>
</html>
