<?php

//displays a message bar if the user has not logged in, before accessing. Uses auth->authError variable set in controller

if(isset($_COOKIE['company_id']) && !empty($_COOKIE['company_id'])){
	?>
	<h1 class="header">Employee Login</h1>
	<?php
	echo $this->Form->create('User');
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->submit('Admin Login');
	echo $this->Form->end();

} else {
	?>
	<h1 class="header">Company Login</h1>
	<?php
	echo $this->Form->create('Company');
	echo $this->Form->input('owner',array('type'=>'text'));
	echo $this->Form->input('password');
	echo $this->Form->submit('Company Login');
	echo $this->Form->end();
}


?>
