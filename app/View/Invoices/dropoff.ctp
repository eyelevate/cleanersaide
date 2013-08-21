<?php
//add scripts to header
echo $this->Html->script(array('admin/invoices_dropoff.js'),FALSE);

?>
<div class="row-fluid">
	<h1 class="heading">Drop Off</h1>
	<div class="formRow">
		<div class="pull-left span6 well well-small">
			
		</div>
		<div class="pull-left span6 well well-small">
			
		</div>
	</div>
	<div class="formRow clearfix">
		
	</div>
	<div class="formRow ">
		<div class="formSep"></div>
		<form action="/invoices/process_dropoff/"></form>
		<div class="clearfix">
			<button class="btn btn-danger pull-left">Cancel</button>
			<button class="btn btn-primary pull-right">Finish</button>
		</div>
	</div>
</div>