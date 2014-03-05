<?php
//PAGE SPECIFIC
//CSS FILES
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form'
	),
	'stylesheet',
	array('inline'=>false)
);

//JS FILES
echo $this->Html->script(array(
	//'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui file
	),
	FALSE
);

//displays a message bar if the user has not logged in, before accessing. Uses auth->authError variable set in controller
echo $this->TwitterBootstrap->flashes(array(
    "auth" => true,
    "closable"=>false
    )
);


?>

<div class="container">
	
	<div class="row">
		<div class="sixteen columns alpha">
			<div class="page_heading"><h1>Forgot Password Page</h1></div>
		</div>		
	</div>



	<div class="row">
		<p>To reset your password please submit in your email address you used to create the account. An email with instructions will be sent to for further instructions.</p>
		<div class="twelve columns alpha">
			<?php
			echo $this->Form->create();
			echo $this->Form->input('email');
			echo $this->Form->submit('Reset Password',array('class'=>'btn btn-primary'));
			echo $this->Form->end();
			?>
		</div>
	</div>

