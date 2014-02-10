<?php
//load styles & scripts to layout
echo $this->Html->script(array(
	'admin/plugins/validation/jquery.validate.min.js',
	'admin/plugins/phone_mask/phone_mask.js',
	'admin/plugins/jquerypriceformat/jquery.price_format.1.7.min.js',
	'admin/inventories.js'),
	FALSE
);

?>
<div class="row-fluid">
	<?php
	echo $this->Form->create();
	?>

	<div class="controls">
		<div id="extraIncUnitsForm" class="form-horizontal">
			<div class="formSep">
			<h5 class="heading">Incremental Units Creation</h5>
				<?php
				echo $this->Form->input('NULL.incUnitStart',
			    	array(
			        	'div' => array('class' => 'control-group'),
			        	'label'=>false,
			        	'before' => '<label class="control-label">Overlength Start</label><div class="controls">',
			        	'after'=>'<span class="help-block"></span></div>',
			        	'class' => 'inc_unit_start',
			        	'placeholder'=>'Overlength Start Value'
					)	
				);
				echo $this->Form->input('NULL.incUnitEnd',
			    	array(
			        	'div' => array('class' => 'control-group'),
			        	'label'=>false,
			        	'before' => '<label class="control-label">Overlength End</label><div class="controls">',
			        	'after'=>'<span class="help-block"></span></div>',
			        	'class' => 'inc_unit_end',
			        	'placeholder'=>'Overlength End Value'
					)	
				);
				echo $this->Form->input('NULL.incUnitAdd',
			    	array(
			        	'div' => array('class' => 'control-group'),
			        	'label'=>false,
			        	'before' => '<label class="control-label">Incremental Units</label><div class="controls">',
			        	'after'=>'<span class="help-block"></span></div>',
			        	'class' => 'inc_unit_add',
			        	'placeholder'=>'Incremental Unit Value'
					)	
				);
				?>	
				<div class="control-group">
					<div class="controls">
						<button id="createIncUnitButton" class="btn btn-info btn-small" type="button">Create Incremental Unit</button>
					</div>
				</div>
			</div>
			<div class="formSep">
				<h5 class="heading">Created Incremental Units</h5>
				<table id="createdIncUnitsTable" class="table table-bordered table-condensed table-hover">
		
					<thead>
						<tr>
							<th>Overlength Start</th>
							<th>Overlength End</th>
							<th>Incremental Units</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="inc_unitsTbody">
						
					</tbody>
		
				</table>
			</div>		
		</div>					
	<div class="formRow">
		<?php
		echo $this->Form->submit('Save Incremental Units',array('class'=>'btn btn-large btn-primary pull-right'));
		?>
	</div>
	</div> 
</div>