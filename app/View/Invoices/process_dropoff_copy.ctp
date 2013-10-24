<?php

//add scripts to header
echo $this->Html->script(array(
	'admin/printing_functions.js',
	'admin/invoices_process_dropoff_copy.js'
	),
	FALSE
);


?>

<div class="row-fluid">
	<applet id="qz" name="QZ Print Plugin" code="qz.PrintApplet.class" archive="/files/qz-print/dist/qz-print.jar" width="100" height="100">
	      <param name="printer" value="epson">
	</applet>
	<p id="countdown"></p>
	<!-- set tag printing -->
	<div class="formRow">
		
	</div>
	<!-- set customer copy -->
	<div class="formRow">
		<script type="text/javascript">
			var qz = document.getElementById('qz');
			<?php
			foreach ($create_store_copy as $csc) {
				foreach ($csc as $skey => $svalue) {
					if($skey==0){ //set the printer initiate printing
						?>
						if (qz != null) {
							qz.findPrinter('<?php echo $svalue;?>');
						}
						<?php
					} else { //setup the reste of the printing
						?>
						if (qz != null) {
							qz.append('<?php echo $svalue;?>');
						}
						<?php
					}				
				}			
			}
			?>
			qz.print();				
		</script>
	</div>	
	<!-- set store copy -->
	<div class="formRow">
		<script type="text/javascript">
			var qz = document.getElementById('qz');
			<?php
			foreach ($create_store_copy as $csc) {
				foreach ($csc as $skey => $svalue) {
					if($skey==0){ //set the printer initiate printing
						?>
						if (qz != null) {
							qz.findPrinter('<?php echo $svalue;?>');
						}
						<?php
					} else { //setup the reste of the printing
						?>
						if (qz != null) {
							qz.append('<?php echo $svalue;?>');
						}
						<?php
					}				
				}			
			}
			?>
			qz.print();				
		</script>
		


	</div>
	
	
	<!-- printing script -->
	<div class="formRow span6">
		
		<!-- <ol>
			<li id="step1" class="font-bold">Initializing printer settings... <span id="step1-success" class="hide pull-right badge badge-success">Success</span><span id="step1-fail" class="pull-right badge badge-error hide">Failed</span></li>
			<li id="step2" class="">Gathering invoice information... <span id="step2-success" class="pull-right badge badge-success hide">Success</span><span id="step2-fail" class="pull-right badge badge-error hide">Failed</span></li>
			<li id="step3" class="">Sending data to printer... <span id="step3-success" class="pull-right badge badge-success hide">Success</span><span id="step3-fail" class="pull-right badge badge-error hide">Failed</span></li>
			<li id="step4" class="">Printing invoice tags... <span id="step4-success" class="pull-right badge badge-success hide">Success</span><span id="step4-fail" class="pull-right badge badge-error hide">Failed</span></li>
			<li id="step5" class="">Printing store copy... <span id="step5-success" class="pull-right badge badge-success hide">Success</span><span id="step5-fail" class="pull-right badge badge-error hide">Failed</span></li>
			<li id="step6" class="">Printing customer copy... <span id="step6-success" class="pull-right badge badge-success hide">Success</span><span id="step6-fail" class="pull-right badge badge-error hide">Failed</span></li>			
			<li id="step7" class="">Redirecting page...</li>

		</ol> -->
		
	</div>
	<div id="redirect-alert" class="alert alert-success"></div>
	<div class="formRow">
		<a href="/invoices/index/<?php echo $customer_id;?>" class="btn btn-large btn-danger">Cancel + Redirect</a>
	</div>
	<div class="hide">
		<input id="customer_id" type="hidden" value="<?php echo $customer_id;?>"/>
	</div>
</div>
