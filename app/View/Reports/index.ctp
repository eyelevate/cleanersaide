<?php
echo $this->Html->link('Download CSV of all Reservations',array('controller'=>'reports','action'=>'download'), array('target'=>'_blank'));

//echo $this->Html->link('Download CSV of all Reservations',array('controller'=>'reports','action'=>'daily_accounting'), array('target'=>'_blank'));
?>
<br>
<a href="/reports/daily_accounting">Download Daily Accounting CSV</a>
