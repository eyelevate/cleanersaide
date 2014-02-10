<?php

echo $this->Html->script(array(
	'admin/plugins/jquery.treeview/lib/jquery.cookie.js',
	'admin/plugins/jquery.treeview/jquery.treeview.js',
	'admin/groups.js'
	),
	FALSE
);



?>
<div id="main">
	<h2 class="heading">Groups</h2>
	<ul id="groupsUl" class="filetree">
		<?php
		foreach ($group_main as $super) {
			$group_id = $super['Group']['id'];
			$group_name = $super['Group']['name'];
			 
			if($group_id ==1){
			?>
			<li><img src="../js/admin/plugins/jquery.treeview/images/folder.gif" /><?php echo $group_name;?>
				<ul>
					<?php
					foreach ($group_below as $admin) {
						$group_name = $admin['Group']['name'];
						$group_id = $admin['Group']['id'];
					?>
					<li><?php echo $this->Html->link($group_name,array('controller'=>'groups','action'=>'edit',$group_id));?><img src="../js/admin/plugins/jquery.treeview/images/file.gif" /></li>
					<?php
					}
					?>
					
				</ul>
			</li>		
			<?php	
			}
		}
		?>
	</ul>
</div>