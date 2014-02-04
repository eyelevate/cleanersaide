<?php
//add scripts to header
echo $this->Html->script(array(
	'admin/admin_printing.js'
	),
	FALSE
);
?>
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
			archive:'qz-print.jar', width:1, height:1};
		var parameters = {jnlp_href: 'qz-print_jnlp.jnlp', 
			cache_option:'plugin', disable_logging:'false', 
			initial_focus:'false'};
		if (deployJava.versionCheck("1.7+") == true) {}
		else if (deployJava.versionCheck("1.6+") == true) {
			attributes['archive'] = 'jre6/qz-print.jar';
			parameters['jnlp_href'] = 'jre6/qz-print_jnlp.jnlp';
		}
		deployJava.runApplet(attributes, parameters, '1.5');
	}
	</script>
<div class="row-fluid">
	<h1>Printing Setup</h1>
	<div class="alert alert-info">
		<p>You have been logged into the admins section. Please keep this page up for printing capability. If you are not automatically redirected please
			<form id="adminSubmitForm" action="/admins" target="_blank" method="post">
				<input id="adminSubmitButton" type="submit" value="Click here to redirect to admin page" class="btn btn-info"/>
			</form>			
		</p>
	</div>

</div>

