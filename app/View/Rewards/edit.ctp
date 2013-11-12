<?php

?>
<div class="row-fluid">
	<h1 class="heading">Edit a reward program</h1>
	<?php
	echo $this->Form->create();
	echo $this->Form->input('name');
	echo $this->Form->input('points');
	echo $this->Form->input('discount');
	echo $this->Form->submit('Create');
	echo $this->Form->end();
	?>
</div>