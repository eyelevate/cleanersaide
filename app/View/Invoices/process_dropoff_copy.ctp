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
			var qz = document.getElementById('qz');
	
			<?php
			//start time
			
			foreach ($create_customer_copy as $ccc) {
				foreach ($ccc as $ckey => $cvalue) {
					
					if($ckey==0){ //set the printer initiate printing
						?>
						if (qz != null) {

						}
						<?php
					} else {
						?>
						if (qz != null) {
     
							console.log('CCopy :: <?php echo $cvalue;?>');
						}
						<?php						
					}				
				}			
			}

			$total_rows = count($create_store_copy);

			for ($i=0; $i < $total_rows; $i++) {
				$time = $i * 3000;
				?>
				setTimeout(function(){
				<?php
				foreach ($create_store_copy[$i] as $skey => $svalue) {

					switch($skey){
						case '0':
							
						break;
						case 'BARCODE':
						//print
						// qz.print();
						//time
						?>
						barcode_html = 	 		
							'<html>'+
					 		'<table>'+
					 			'<tr>'+
					 				'<td width="30"></td>'+
					 				'<td><img src="http://www.cleanersaide.com/barcode1.php?invoice_number=<?php echo $svalue;?>"/></td>'+
					 			'</tr>'+
					 		'</table>'+
					 		'</html>';
					 	// qz.appendHTML();	
						setTimeout(function(){
						 	//append and print
						 	//qz.printHTML();
							console.log(barcode_html);		
							setTimeout(function(){
								console.log('cut and print')
								// qz.append('\x1D\x56\x01');
								// qz.print();		
								<?php
								if($i == ($total_rows -1)){
									//redirect back
									
								}
								?>						
							}, 1000);					
						}, 1000);

						<?php
						break;
							
						default:
						?>
						console.log('SCopy :: <?php echo $svalue;?>');
						<?php	
						break;
					}     						

				}							
				?>	
				},<?php echo $time;?>);
				<?php			

			}			
			
			?>

		</script>
	</div>	

	
	
	<!-- printing script -->
	<div class="formRow span6">
	<?php
	$time = 0;
	if(isset($tags)){
		foreach ($tags['Invoice'] as $key => $value) {
			$inventory_id = $value['inventory_id'];
			$invoice_id = $value['invoice_id'];
			$quantity = $value['quantity'];
			if($inventory_id != 2){
				for ($i=1; $i <= $quantity; $i++) {
					$time = ($i-1) * 500; 
					?>
					<iframe id="tag_frame-<?php echo $invoice_id;?>" src="/printers/print_tag1/<?php echo $invoice_id;?>/<?php echo $i;?>"></iframe>		
					<script type="text/javascript">
						$(document).ready(fuction(){
							setTimeout(function(){
								jsPrintSetup.setPrinter('BIXOLON SRP-270');
								jsPrintSetup.setSilentPrint(true);
								jsPrintSetup.setOption('marginTop',0);
								jsPrintSetup.setOption('marginBottom',0);
								jsPrintSetup.setOption('marginLeft',0);
								jsPrintSetup.setOption('marginRight',0);
								jsPrintSetup.setOption('footerStrLeft','');
								jsPrintSetup.setOption('footerStrCenter','');
								jsPrintSetup.setOption('footerStrRight','');
								jsPrintSetup.setShowPrintProgress(false);
								
								jsPrintSetup.printWindow($("#tag_frame-<?php echo $invoice_id;?>"));	
								console.log('Tag Print :: <?php echo $invoice_id.' '.$i.'/'.$quantity;?>')						
							}, <?php echo $time;?>);							
						});


					</script>	
					<?php					
				}				
			}	

		}
	}
	?>

	</div>
	<div id="redirect-alert" class="alert alert-success"></div>
	<!-- <div class="formRow">
		<a href="/invoices/index/<?php echo $customer_id;?>" class="btn btn-large btn-danger">Cancel + Redirect</a>
	</div> -->
	<!-- <div class="hide">
		<input id="customer_id" type="hidden" value="<?php echo $customer_id;?>"/>
	</div> -->
</div>
