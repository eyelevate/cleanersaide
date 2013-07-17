<?php

$this->Html->css(array('admin_content'),'stylesheet', array('inline' => false));
echo $this->Html->script(array('admin/plugins/nested_sortables/jquery.mjs.nestedSortable.js','admin/menu.js'),FALSE);

//set variables
foreach ($menus as $menu) {
	$menu_id = $menu['Menu']['id'];
	$menu_html = $menu['Menu']['edit_menu'];
	$menu_name = $menu['Menu']['name'];
}
?>

<div>
	<h3>Edit Menu Name</h3>
	<div class="form-actions">
		<div id="menuTitleDiv" class="control-group">    		
			<label class="control-label" for="inputError">Menu Name</label>
			<input id="menuTitle" class="span6" type="text" placeholder="Menu Name" value="<?php echo $menu_name;?>"/>
			<span class="help-inline"></span>
		</div>
		<p id="successMessage"></p>
	</div>
	<h3>Edit Menu Navigation</h3>
    <div class="form-actions">
		<div id="menuLabelDiv" class="control-group">    		
			<label class="control-label" for="inputError">Add Label</label>
			<input id="menuLabel" class="span6" type="text"/>
			<span class="help-inline"></span>
		</div>
		<div id="menuUrlDiv" class="control-group">
			<label>Connects To</label>
			<select class="span6" id="selectMenuUrl">
				<option class="createMenuOption"  selected="selected" value="none">Select Here</option>
				<optgroup label="HEADERS">
					<option class="createMenuOption" value="h1">None - Main Group Header</option>
					<option class="createMenuOption" value="h2">None - Sub Group Header</option>
					<option class="createMenuOption" value="br">None - Add Line Break</option>					
				</optgroup>
				<optgroup label="PUBLIC PAGES">
				<?php
				foreach ($pages as $page) {
					$label = $page['label'];
					$url = $page['url'];
					?>
					<option class="createMenuOption" value="<?php echo $url;?>"><?php echo $label;?></option>	
					<?php
				}
				?>
				</optgroup>
				<optgroup label="ADMINISTRATION ONLY">
				<?php
				foreach ($controllers as $key => $value) {
					$controller_name = $key;

					?>
					<optgroup label="<?php echo $controller_name;?>">
					<?php
						foreach ($controllers[$controller_name] as $method) {
							$method_url = '/'.$controller_name.'/'.$method;
						?>
						<option class="createMenuOption" value="<?php echo $method_url;?>"><?php echo $method_url;?></option>	
						<?php
						}
					?>
					</optgroup>
				<?php
				}
				?>		
				</optgroup>	
			</select>	
			<span class="help-inline"></span>				
		</div>
		<div>
			<label>Add Icon Image (optional)</label>
			<label class="radio">
				<input class="iconThemeRadio" name="colors" type="radio" value="white" checked="checked"> Dark Icons
			</label>
			<label class="radio">
				<input class="iconThemeRadio" name="colors" type="radio" value="dark"> White Icons
			</label>	
    		<div id="addMenuRowIconDiv" class="btn-group" name="white">
		    	<a id="icon_chosen" class="btn" data-toggle="dropdown" href="javascript:void(0)" chosen="none"><i class=""></i> <span>Select Icon</span></a>
		    	<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>
			    <ul class="dropdown-menu">
			    		<li class="iconMenuLi" name="No Icon"><a href="javascript:void(0)"><i class=""></i> No Icon</a></li>
			    	<?php
					foreach ($icons['dark'] as $icon_dark) {
						$icon_name = $icon_dark;
						?>
						<li class="iconMenuLi" name="<?php echo $icon_name;?>"><a href="#"><i class="<?php echo $icon_name;?>"></i> - <?php echo $icon_name;?></a></li>
						<?php
					}
					?>
			    </ul>
		    </div>
    		<div id="addMenuRowIconDiv" class="btn-group" name="dark">
		    	<a id="icon_chosen" class="btn btn-inverse" data-toggle="dropdown" href="javascript:void(0)" chosen="none"><i class=""></i> <span>Select Icon</span></a>
		    	<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>
			    <ul id="iconDropDownMenuUl-dark" class="dropdown-menu" >
			    		<li class="iconMenuLi" name="No Icon"><a href="#"><i class=""></i> No Icon</a></li>
			    	<?php
					foreach ($icons['white'] as $icon_dark) {
						$icon_name = $icon_dark;
						?>
						<li class="iconMenuLi" name="<?php echo $icon_name;?>"><a href="javascript:void(0)"><i class="<?php echo $icon_name;?>"></i> - <?php echo $icon_name;?></a></li>
						<?php
					}
					?>
			    </ul>
		    </div>
		</div>
		<div id="addMenuRowActionDiv">
	   		<button id="addNewMenuRow" type="submit" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> Add Row</button>
	  	</div>
    </div>
	<h3>Organize Menu</h3>
	<div id="menuOrganizeDiv" class="form-actions">
		<ol id="menuSortable" class="treeListMenuOL" tier="1">
			<?php
			echo $menu_html;
			?>
		</ol>
	</div>	
	<div id="menuSaveDiv" class="control-group">
		<button id="clearMenuButton">Clear Menu</button>
		<button id="editMenuButton" name="<?php echo $menu_id;?>">Save Changes</button>	
		<div id="menuSaveP" class="control-group"></div>	
	</div>

</div>






