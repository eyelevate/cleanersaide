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
	<script type="text/javascript" src="/files/qz-print/dist/js/deployJava.js"></script>
	<script>
	deployQZ();
	
	/**
	* Deploys different versions of the applet depending on Java version.
	* Useful for removing warning dialogs for Java 6.  This function is optional
	* however, if used, should replace the <applet> method.  Needed to address 
	* MANIFEST.MF TrustedLibrary=true discrepency between JRE6 and JRE7.
	*/
	function deployQZ() {
		var attributes = {id: "qz", code:'qz.PrintApplet.class', 
			archive:'/files/qz-print/dist/qz-print.jar', width:1, height:1};
		var parameters = {jnlp_href: '/files/qz-print/dist/qz-print_jnlp.jnlp', 
			cache_option:'plugin', disable_logging:'false', 
			initial_focus:'false'};
		if (deployJava.versionCheck("1.7+") == true) {}
		else if (deployJava.versionCheck("1.6+") == true) {
			attributes['archive'] = '/files/qz-print/dist/jre6/qz-print.jar';
			parameters['jnlp_href'] = '/files/qz-print/dist/jre6/qz-print_jnlp.jnlp';
		}
		deployJava.runApplet(attributes, parameters, '1.5');
	}

	</script>
	<p id="countdown"></p>
	<!-- set tag printing -->
	<div class="formRow">
		
	</div>
	<!-- set customer copy -->
	<div class="formRow">
		<script type="text/javascript">
	/**
	* Returns whether or not the applet is not ready to print.
	* Displays an alert if not ready.
	*/


		    function monitorAppending() {
		    	
		    	var qz = document.getElementById('qz');
				if (qz != null) {
					if (!qz.isDoneAppending()) {
				    	window.setTimeout('monitorAppending()', 100);
				    } else {
				    	qz.print(); // Don't print until all of the data has been appended
				    	//qz.printHTML();
				   	}
				} else {
			       alert("Applet not loaded!");
		        }
		    }	
	
			<?php
			foreach ($create_customer_copy as $ccc) {
				foreach ($ccc as $ckey => $cvalue) {
					
					if($ckey==0){ //set the printer initiate printing
						?>
						if (qz != null) {
							qz.findPrinter('<?php echo $cvalue;?>');
						}
						<?php
					} else {
						?>
						if (qz != null) {
							qz.append('<?php echo $cvalue;?>');       
						
						}
						<?php						
					}				
				}			
			}

			$total_rows = count($create_store_copy);
			for ($i=0; $i < $total_rows; $i++) {
				$total_column_rows = count($create_store_copy[$i]);
				foreach ($create_store_copy[$i] as $skey => $svalue) {
					if($skey >= 1 && $skey<=$total_column_rows){ //set the printer initiate printing

						?>
						qz.append('<?php echo $svalue;?>');       
						
						<?php							
				
					}	
					?>
					monitorAppending();
					<?php
					if($skey==26){ //set the printer initiate printing
					?>
					 	qz.appendHTML(
					 		'<html>'+
					 		'<table>'+
					 			'<tr>'+
					 				'<td width="30"></td>'+
					 				'<td><img src="http://www.cleanersaide.com/barcode1.php?invoice_number=<?php echo $svalue;?>"/></td>'+
					 			'</tr>'+
					 		'</table>'+
					 		'</html>'
					 	);
						qz.printHTML(); // Don't print until all of the data has been appended						
					<?php
					}						
					
				}			
			}			
			
			?>

					setTimeout(function(){

					   qz.printHTML(); // Don't print until all of the data has been appended						
					},2000);
		</script>
	</div>	

	
	
	<!-- printing script -->
	<div class="formRow span6">

	</div>
	<div id="redirect-alert" class="alert alert-success"></div>
	<div class="formRow">
		<a href="/invoices/index/<?php echo $customer_id;?>" class="btn btn-large btn-danger">Cancel + Redirect</a>
	</div>
	<div class="hide">
		<input id="customer_id" type="hidden" value="<?php echo $customer_id;?>"/>
	</div>
</div>
