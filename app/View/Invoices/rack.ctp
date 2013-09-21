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
		<form id="finalRackForm" action="/invoices/process_rack" method="post">
			
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
			<div class="clearfix">
				<button id="cancelDropOffButton" class="btn btn-danger pull-left">Cancel</button>
				  <!-- Button trigger modal -->
				<a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg pull-right">Next</a>
		
			</div>	
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
				  <div class="modal-content">
				    <div class="modal-header">
				      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				      <h4 class="modal-title">Finish Rack</h4>
				    </div>
				    <div class="modal-body">
				     	<h3>Send Email Notification?</h3>
				     	<div class="control-group">
				     		<label class="radio"><input type="radio" value="No" name="data[Email]" checked="checked"/> No</label>
				     	</div>
				     
				     	<div class="control-group">
							<label class="radio"><input type="radio" value="Yes" name="data[Email]"/> Yes</label>
				     	</div>
				     	<br/><br/>
				    </div>
				    <div class="modal-footer">
				      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				      <button id="rackButton" type="button" class="btn btn-primary pull-right">Finish</button>
				    </div>
				  </div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->	
		</form>	
	</div>

</div>


