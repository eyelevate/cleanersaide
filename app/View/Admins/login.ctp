<?php
//displays a message bar if the user has not logged in, before accessing. Uses auth->authError variable set in controller


echo $this->Form->create('User');
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->submit('Admin Login');
echo $this->Form->end();


?>