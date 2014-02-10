<?php

echo $this->Html->script(array('admin/plugins/jquery.treeview/lib/jquery.cookie.js','admin/plugins/jquery.treeview/jquery.treeview.js','admin/groups.js'),FALSE);
?>
<div id="main">

	<h4>Sample 1 - default</h4>
	<ul id="browser" class="filetree">
		<li><img src="js/admin/plugins/jquery.treeview/images/folder.gif" /> 123</span>
			<ul>
				<li>blabla <img src="js/admin/plugins/jquery.treeview/images/file.gif" /></li>
			</ul>
		</li>
		<li><img src="js/admin/plugins/jquery.treeview/images/folder.gif" />
			<ul>
				<li><img src="js/admin/plugins/jquery.treeview/images/folder.gif" />
					<ul id="folder21">
						<li><img src="js/admin/plugins/jquery.treeview/images/file.gif" /> more text</li>
						<li>and here, too<img src="js/admin/plugins/jquery.treeview/images/file.gif" /></li>
					</ul>
				</li>
				<li><img src="js/admin/plugins/jquery.treeview/images/file.gif" /></li>
			</ul>
		</li>
		<li class="closed">this is closed! <img src="js/admin/plugins/jquery.treeview/images/folder.gif" />
			<ul>
				<li><img src="js/admin/plugins/jquery.treeview/images/file.gif" /></li>
			</ul>
		</li>
		<li><img src="js/admin/plugins/jquery.treeview/images/file.gif" /></li>
	</ul>

</div>







