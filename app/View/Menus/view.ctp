<?php

//set variables
foreach ($menus as $menu) {
	$menu_name = $menu['name']; 
}
?>
<h2>Themed Navigation</h2>
<div>
	<h4><?php echo $menu_name;?> Themed Navigation</h4>
	<div class="navbar">
	    <div class="navbar-inner navbar">
	    	<div class="container">     
		    	<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
		    	<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
		    		<span class="icon-bar"></span>
		    		<span class="icon-bar"></span>
		    	</a>
		     
		    	<!-- Be sure to leave the brand out there if you want it shown -->
		    	<a class="brand" href="#">Your Company Name</a>
		     
		    	<!-- Everything you want hidden at 940px or less, place within here -->
		    	<div class="nav-collapse">
			    	<!-- .nav, .navbar-search, .navbar-form, etc -->
			    	<ul class="nav">
			    		<li class="divider-vertical hidden-phone hidden-tablet"></li>
			    	<?php		    	
					foreach ($mits as $key => $value) {
						$mainHeader = $key;
						$name = $mits[$key]['name'];
						$url = $mits[$key]['url'];
						$icon = $mits[$key]['icon'];
						switch ($url) {
							case 'Main Header':
								?>
								
								<li class="dropdown">
									<a href="#" class="dropdown-toggle nav_condensed" data-toggle="dropdown"><i class="<?php echo $icon;?>"></i> <?php echo $name;?> <b class="caret"></b></a>
									
									<ul class="dropdown-menu">
									<?php
									if($mits[$mainHeader]['next'] != 'empty'){				
										foreach ($mits[$mainHeader]['next'] as $key=>$value) {
											$name = $mits[$mainHeader]['next'][$key]['name'];
											$url = $mits[$mainHeader]['next'][$key]['url'];
											$icon = $mits[$mainHeader]['next'][$key]['icon'];
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
												<li><a href="javascript:void(0)"><i class="<?php $icon;?>"></i><?php echo $name;?></a></li>
												<?php
												break;
											}
										}
									}
									?>
									</ul>
								</li>
								<li class="divider-vertical hidden-phone hidden-tablet"></li>
								<?php							
								break;
								
							case 'Sub Header':
								?>
								<li class="nav-header"><i class="<?php $icon;?>"></i><?php echo $name;?></li>
								<?php							
								break;
							case 'Line Break':
								?>
								<li class="divider-vertical hidden-phone hidden-tablet"></li>
								<?php	
								break;
							
							default:
								?>
								<li><a href="javascript:void(0)"><i class="<?php echo $icon;?>"></i><?php echo $name;?></a></li>
								<?php							
								break;
						}
	
					}
					?>	 

 
			    	</ul>
					    <form class="navbar-search pull-right">
					   		<input type="text" class="search-query" placeholder="Search">
					    </form> 			 
		    	</div>
	    	</div>
	    </div>
	</div>	
</div>


<h2>List Style Navigation</h2>
<div>
	<h4>Vertical Navigation List</h4>
	<ul class="nav nav-list">
		<?php
		foreach ($menu_items as $menu_item) {
			$menu_item_name = $menu_item['Menu_item']['name'];
			$menu_item_icon = $menu_item['Menu_item']['icon'];
			$menu_item_url = $menu_item['Menu_item']['url'];
			$menu_item_id = $menu_item['Menu_item']['menu_id'];
			switch ($menu_item_url) {
				case 'Main Header':
					?>
					<li class="nav-header"><i class="<?php echo $menu_item_icon;?>"></i><?php echo $menu_item_name;?></li>
					<?php
					break;
				case 'Sub Header':
					?>
					<li class="nav-header"><i class="<?php echo $menu_item_icon;?>"></i><?php echo $menu_item_name;?></li>
					<?php					
					break;
					
				case 'Line Break':
					?>
					<li class="divider"></li>
					<?php					
					break;
				default:
					//url would go in here
					?>
					<li><a href="javascript:void(0)"><?php echo $menu_item_name;?></a></li>
					<?php
					break;
			}
		}
		?>
	</ul>	
</div>
<div>
	<h4>Accordion Styled Vertical Navigation</h4>
	<div id="side_accordion" class="accordion">
	<?php
	//set for menu viewing only. for view change this value to 0
	$collapse_id = 1000;
	foreach ($mits as $key => $value) {
		$mainHeader = $key;
		$name = $mits[$key]['name'];
		$url = $mits[$key]['url'];
		$icon = $mits[$key]['icon'];
		$collapse_id = $collapse_id+1;

		?>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapse-<?php echo $collapse_id;?>" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle"> <i class="<?php echo $icon;?>"></i> <?php echo $name;?></a>
			</div>
			<div class="accordion-body collapse" id="collapse-<?php echo $collapse_id;?>">
				<div class="accordion-inner">
					<ul class="nav nav-list">
					<?php
					if($mits[$mainHeader]['next'] != 'empty'){				
						foreach ($mits[$mainHeader]['next'] as $key=>$value) {
							$name = $mits[$mainHeader]['next'][$key]['name'];
							$url = $mits[$mainHeader]['next'][$key]['url'];
							$icon = $mits[$mainHeader]['next'][$key]['icon'];
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
								<li><a href="javascript:void(0)"><i class="<?php $icon;?>"></i><?php echo $name;?></a></li>
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
	?>
	</div>
</div>
<h2>Tabbed Navigation</h2>
<div>
	<h4>Tabbed Navigation with sub divider</h4>
	<div class="tabbable"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">Section 1</a></li>
			<li><a href="#tab2" data-toggle="tab">Section 2</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<p>I'm in Section 1.</p>
			</div>
			<div class="tab-pane" id="tab2">
				<p>Howdy, I'm in Section 2.</p>
			</div>
		</div>
	</div>	
</div>
<div>
	<h4>Horizontal tabbed drop down navigation</h4>
	<ul class="nav nav-tabs">
	<?php		    	
	foreach ($mits as $key => $value) {
		$mainHeader = $key;
		$name = $mits[$key]['name'];
		$url = $mits[$key]['url'];
		$icon = $mits[$key]['icon'];
		switch ($url) {
			case 'Main Header':
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle nav_condensed" data-toggle="dropdown"><i class="<?php echo $icon;?>"></i> <?php echo $name;?> <b class="caret"></b></a>
					
					<ul class="dropdown-menu">
					<?php
					if($mits[$mainHeader]['next'] != 'empty'){				
						foreach ($mits[$mainHeader]['next'] as $key=>$value) {
							$name = $mits[$mainHeader]['next'][$key]['name'];
							$url = $mits[$mainHeader]['next'][$key]['url'];
							$icon = $mits[$mainHeader]['next'][$key]['icon'];
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
								<li><a href="javascript:void(0)"><i class="<?php $icon;?>"></i><?php echo $name;?></a></li>
								<?php
								break;
							}
						}
					}
					?>
					</ul>
				</li>
				<?php							
				break;
				
			case 'Sub Header':
				?>
				<li class="nav-header"><i class="<?php $icon;?>"></i><?php echo $name;?></li>
				<?php							
				break;
			case 'Line Break':
				?>
				<li class="divider-vertical hidden-phone hidden-tablet"></li>
				<?php	
				break;
			
			default:
				?>
				<li><a href="javascript:void(0)"><i class="<?php echo $icon;?>"></i><?php echo $name;?></a></li>
				<?php							
				break;
		}

	}
	?>	    
	</ul>	
</div>
<div>
	<h4>Horizontal pilled drop down navigation</h4>
	<ul class="nav nav-pills">
	<?php		    	
	foreach ($mits as $key => $value) {
		$mainHeader = $key;
		$name = $mits[$key]['name'];
		$url = $mits[$key]['url'];
		$icon = $mits[$key]['icon'];
		switch ($url) {
			case 'Main Header':
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle nav_condensed" data-toggle="dropdown"><i class="<?php echo $icon;?>"></i> <?php echo $name;?> <b class="caret"></b></a>
					
					<ul class="dropdown-menu">
					<?php
					if($mits[$mainHeader]['next'] != 'empty'){				
						foreach ($mits[$mainHeader]['next'] as $key=>$value) {
							$name = $mits[$mainHeader]['next'][$key]['name'];
							$url = $mits[$mainHeader]['next'][$key]['url'];
							$icon = $mits[$mainHeader]['next'][$key]['icon'];
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
								<li><a href="javascript:void(0)"><i class="<?php $icon;?>"></i><?php echo $name;?></a></li>
								<?php
								break;
							}
						}
					}
					?>
					</ul>
				</li>
				<?php							
				break;
				
			case 'Sub Header':
				?>
				<li class="nav-header"><i class="<?php $icon;?>"></i><?php echo $name;?></li>
				<?php							
				break;
			case 'Line Break':
				?>
				<li class="divider-vertical hidden-phone hidden-tablet"></li>
				<?php	
				break;
			
			default:
				?>
				<li><a href="javascript:void(0)"><i class="<?php echo $icon;?>"></i><?php echo $name;?></a></li>
				<?php							
				break;
		}

	}
	?>	
	</ul>	
</div>

<div>
	<h4>Tabs Below Navigation</h4>
	<div class="tabbable tabs-below">
	    <div class="tab-content">
	    ...
	    </div>
	    <ul class="nav nav-tabs">
	    ...
	    </ul>
	</div>	
</div>
<div>
	<h4>Tabs Left Navigation</h4>
	<div class="tabbable tabs-left">
	    <ul class="nav nav-tabs">
	    ...
	    </ul>
	    <div class="tab-content">
	    ...
	    </div>
	</div>	
</div>

<div>
	<h4>Tabs Right Navigation</h4>
	<div class="tabbable tabs-right">
	    <ul class="nav nav-tabs">
	    ...
	    </ul>
	    <div class="tab-content">
	    ...
	    </div>
	</div>	
</div>

