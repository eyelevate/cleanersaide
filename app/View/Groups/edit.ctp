<?php

echo $this->Html->script(array(
	'admin/plugins/jquery.treeview/lib/jquery.cookie.js',
	'admin/plugins/jquery.treeview/jquery.treeview.js',
	'admin/groups_edit.js'),
	FALSE
);


if(count($groups)>0){
	foreach ($groups as $g) {
		$group_name = $g['Group']['name'];
		$group_id = $g['Group']['id'];
		switch($group_id){
			case '1':
				$group_admin = 'Yes';		
			break;
			
			default:
				$group_admin = 'No';
			break;
		}
		

	}
}

?>


<div class="groups form">
		<legend><?php echo __('Edit Group'); ?></legend>
<?php echo $this->Form->create('Group'); ?>
	<div class="w-box">
		<h3 class="w-box-header">Edit Group Name</h3>
		<div class="w-box-content cnt_a">
		
			<fieldset>
			<?php
				echo $this->Form->input('id',array(
					'value'=>$group_id
				));
				echo $this->Form->input('name',array(
					'value'=>$group_name
				));
			?>
			<div class="formSep">
				<label>Administrator Access?</label>
				<?php
				switch($group_admin){
					case 'Yes':
					?>
					<label class="radio">
						<input type="radio" class="accessRadio" name="data[Group][admin]" id="optionsRadios1" value="No"/>
						No
					</label>
					<label class="radio">
						<input type="radio" class="accessRadio" name="data[Group][admin]" id="optionsRadios2" value="Yes" checked="checked"/>
						Yes
					</label>
					<?php						
					break;
						
					default:
					?>
					<label class="radio">
						<input type="radio" class="accessRadio" name="data[Group][admin]" id="optionsRadios1" value="No" checked="checked"/>
						No
					</label>
					<label class="radio">
						<input type="radio" class="accessRadio" name="data[Group][admin]" id="optionsRadios2" value="Yes" />
						Yes
					</label>
					<?php						
					break;
				}
				?>
				
			</div>			
		<?php //echo $this->Form->end(__('Submit')); ?>
		</div>
		<h3 class="w-box-header">Access Controls</h3>
		<div class="w-box-content cnt_a">
			<label class="checkbox"><input id="accessDisplay" type="checkbox"/> Show Access Controls</label>	
			<div id="acoDiv" class="formSep">
				<label>Select Page Access</label>
				<div>
					<ul id="groupsUl" class="filetree">
					<?php
			
					foreach ($acos as $key => $value) {
						$controller = $key;
						$controller_id = $acos[$key]['id'];
						$controller_alias = $acos[$key]['alias'];
						$controller_name = 'controllers/'.$controller;
						$checked_controller = '';
						$checked_controller_status = 'No';
						foreach ($acl_permissions as $aclp) {
							$controller_method = $aclp['Acl_permission']['url'];
							if($controller_method == $controller_name){
								$checked_controller = 'checked="checked"';
								$checked_controller_status = 'Yes';
								break;
							}
						}
						

						?>
						<li><label class="checkbox"><input type="checkbox" id="<?php echo $controller;?>" class="controller" name="data[Aco][<?php echo $controller_id;?>]" value="<?php echo $controller_name;?>" <?php echo $checked_controller;?>/> <?php echo $controller_alias;?></label>
							<ul>
								<?php

								foreach ($acos[$key]['next'] as $ckey => $cvalue) {
									$base_checked ='';
									$action = $ckey;
									$action_id = $acos[$key]['next'][$ckey]['id'];
									$action_name = 'controllers/'.$controller.'/'.$action;
									foreach ($acl_permissions as $aclp) {
										$controller_method = $aclp['Acl_permission']['url'];
										
										if($action_name == $controller_method){
											$base_checked = 'checked="checked"';

											break;
										}
									}
									if($checked_controller_status=='Yes'){
										$base_checked = 'checked="checked" disabled="disabled"';
									
									}
									
									?>
									<li><label class="checkbox"><input type="checkbox" id="<?php echo $controller.'-'.$action;?>" controller="<?php echo $controller;?>" class="action" name="data[Aco][<?php echo $action_id;?>]" value="<?php echo $action_name;?>" <?php echo $base_checked;?>/><?php echo $action;?></li>
									<?php										

								}
								?>
								
							</ul>
						</li>						
						<?php
					}
					
					?>
					</ul>
				</div>
	
			</div>
		</div>
		<div class="w-box-footer clearfix">
			<?php 			
			echo $this->Form->submit('Edit Group',array('class'=>'btn btn-primary pull-left'));
			?>
			<button id="deleteGroupButton" type="button" class="btn btn-danger pull-right">Delete Group</button>
			<?php
			echo $this->Form->end(); 	
			
			echo $this->Form->postLink(__('Delete Group'), array('controller'=>'groups','action' => 'delete',$group_id), array('class' => 'deleteGroupButton2 hide btn btn-danger pull-left'), __('Are you ABSOLUTELY sure you want to delete this group? It can not be reversed.', $group_id));		
			?>			
		</div>

		</fieldset>
	</div>
</div>
