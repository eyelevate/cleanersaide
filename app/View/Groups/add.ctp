<?php

echo $this->Html->script(array(
	'admin/plugins/jquery.treeview/lib/jquery.cookie.js',
	'admin/plugins/jquery.treeview/jquery.treeview.js',
	'admin/groups.js'),
	FALSE
);


?>

<div class="groups form">
	<legend><?php echo __('Add Group'); ?></legend>
<?php echo $this->Form->create('Group'); ?>
	<div class="w-box">
		<h3 class="w-box-header">Create Group Name</h3>
		<div class="w-box-content cnt_a">
			<?php
			echo $this->Form->input('name',array(
				'div'=>array('class'=>'control-group'),
				'class'=>'span6'
			));
			?>	
			<div class="formSep">
				<label>Administrator Access?</label>
				<label class="radio">
					<input type="radio" class="accessRadio" name="data[Group][admin]" id="optionsRadios1" value="No"/>
					No
				</label>
				<label class="radio">
					<input type="radio" class="accessRadio" name="data[Group][admin]" id="optionsRadios2" value="Yes" checked="checked"/>
					Yes
				</label>
				
			</div>
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
						?>
						<li><label class="checkbox"><input type="checkbox" checked="checked" id="<?php echo $controller;?>" class="controller" name="data[Aco][<?php echo $controller_name;?>]" value="<?php echo $controller_name;?>"/> <?php echo $controller_alias;?></label>
							<ul>
								<?php
								foreach ($acos[$key]['next'] as $ckey => $cvalue) {
									$action = $ckey;
									$action_name = 'controllers/'.$controller.'/'.$action;
								?>
								<li><label class="checkbox"><input type="checkbox" checked="checked" disabled="disabled" id="<?php echo $controller.'-'.$action;?>" controller="<?php echo $controller;?>" class="action" name="data[Aco][<?php echo $action_name;?>]" value="<?php echo $action_name;?>"/><?php echo $action;?></li>
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
		<div class="w-box-footer">
			<?php 
			echo $this->Form->submit('Create Group',array('class'=>'btn btn-primary'));
			echo $this->Form->end(); 			
			?>			
		</div>
	</div>
</div>


