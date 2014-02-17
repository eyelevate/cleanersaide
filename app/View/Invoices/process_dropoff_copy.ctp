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
	<?php
		foreach ($create_customer_copy as $ccc) {
			foreach ($ccc as $ckey => $cvalue) {
				switch($ckey){
					case '0':
					?>
					if (qz != null) {
						qz.findPrinter('<?php echo $cvalue;?>');
					}
					<?php						
					break;
						
					default:
					?>
					if (qz != null) {
						qz.append('<?php echo $cvalue;?>');
						
					}
					<?php						
					break;
				}
			
			}			
		}	
		foreach ($create_store_copy as $csc) {
			foreach ($csc as $skey => $svalue) {
				switch($skey){
					case '0':
					?>
					if (qz != null) {
						qz.findPrinter('<?php echo $svalue;?>');
					}
					<?php						
					break;
						
					case 'BARCODE':
					?>
					qz.appendImage("http://www.cleanersaide.com/barcode1.php?invoice_number=<?php echo $svalue;?>", "ESCP", "single");
					<?php
					break;
						
					default:
					?>
					if (qz != null) {
						qz.append('<?php echo $svalue;?>');
						
					}
					<?php						
					break;
				}
			
			}			
		}
		?>
		setTimeout(function(){
			qz.print();
			qz.append("\x1B\x40");
			qz.append("\x1D\x56\x41");
			qz.append("\x1B\x40");
			qz.print();
							
		},3000);	
	</script>
	<?php
	$frames = -1;
	$timer = 3000;
	if(isset($tags)){
		foreach ($tags['Invoice'] as $key => $value) {
			$inventory_id = $value['inventory_id'];
			$invoice_id = $value['invoice_id'];
			$quantity = $value['quantity'];
			if($inventory_id != 2){
				for ($i=1; $i <= $quantity+1; $i++) {
					$frames++;
					$timer += $i * 500;
					if($i == $quantity+1){
					?>
					<iframe style="height:75px; width:350px;" src=""></iframe>		
					<script type="text/javascript">
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
							jsPrintSetup.printWindow(window.frames[<?php echo $frames;?>]);					
						}, <?php echo $timer;?>);	
					</script>	
					<?php								
					} else {
					?>
					<iframe style="height:75px; width:350px;" src="/printers/print_tag1/<?php echo $invoice_id;?>/<?php echo $i;?>"></iframe>		
					<script type="text/javascript">
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
							
							jsPrintSetup.printWindow(window.frames[<?php echo $frames;?>]);					
						}, <?php echo $timer;?>);			
					</script>	
					<?php						
					}

									
				}				
			}	

		}
	}
	?>
	</div>
</div>
