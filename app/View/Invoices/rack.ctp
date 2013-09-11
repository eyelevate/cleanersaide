<?php
$this->Html->css(array('admin/invoices_rack'),'stylesheet', array('inline' => false)); 
//add scripts to header
echo $this->Html->script(array('admin/invoices_rack.js'),FALSE);


?>
<div class="row-fluid">
	<h1 class="heading">Rack Invoice(s)</h1>

	<div class="formRow" style="margin-left:0px">
		<legend>Enter Invoice</legend>
		<div class="control-group">
			<div class="input-prepend input-append">
				<span class="add-on">#</span>
				<input id="rackInput" type="text"/>
				<a id="submitRack" class="add-on">Submit</a>
			</div>
		</div>
		<form action="/invoices/process_rack" method="post">
			
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Invoice</th>
						<th>Rack</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody id="rackTbody">
				
				</tbody>
				<tfoot>
					<tr>
						<td style="border-top:2px solid #5e5e5e;"></td>
						<th style="border-top:2px solid #5e5e5e;">Quantity</th>
						<td id="total_quantity" style="border-top:2px solid #5e5e5e;">0</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
	<div class="clearfix">
		<button id="cancelDropOffButton" class="btn btn-danger pull-left">Cancel</button>
		  <!-- Button trigger modal -->
		<a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg pull-right">Finish</a>

	</div>	
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      <h4 class="modal-title">Finish Invoice</h4>
	    </div>
	    <div class="modal-body">
	     	<h3>Select Due Date</h3>
	     	<div class="control-group">
	     		<div class="input-append">
	     			<input id="due_date" type="text" value="<?php echo $due_date;?>"/>
	     			<span class="add-on"><i class="icon-calendar"></i></span>
	     		</div>
	     	</div>
	     	<br/><br/>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	      <button id="editButton" type="button" class="btn btn-primary pull-right">Edit Invoice</button>
	    </div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->