<?php

if(isset($page_id)):
?>
<p id="messageP-<?php echo $page_id;?>" class="messageP"><?php echo $error;?></p>
<?php
else:
?>
<p class="messageP"><?php echo $error;?></p>	
<?php	
endif;
?>
