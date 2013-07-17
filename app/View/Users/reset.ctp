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
			<div class="page_heading"><h1>Reset Password Page</h1></div>
		</div>		
	</div>



	<div class="row">
		<p>Please complete the form below to change your password.</p>
		<div class="twelve columns alpha">
			<?php
			echo $this->Form->create();
			echo $this->Form->input('password',array(
				'div'=>array('class'=>'control-group'),
				'label'=>'New Password',
				'error'=>array('attributes' => array('class' => 'help-block')),
			));
			?>
			<br/>
			<?php
			echo $this->Form->input('retypePassword',array(
				'div'=>array('class'=>'control-group'),
				'label'=>'Re-enter Password',
				'type'=>'password',
				'error'=>array('attributes' => array('class' => 'help-block')),
			));
			echo $this->Form->submit('Change Password');
			echo $this->Form->end();
			?>
		</div>
	</div>

