<?php



?>
<div class="row-fluid">
	<?php
	echo $this->Form->create('Company');
	echo $this->Form->input('start');
	echo $this->Form->input('end');
	echo $this->Form->submit();
	echo $this->Form->end();
	?>
</div>