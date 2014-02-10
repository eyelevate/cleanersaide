<?php
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form',
	'../js/frontend/plugins/popovers/css/bootstrap.min.css'
	),
	'stylesheet',
	array('inline'=>false)
);



//determine which layout you are using
if($layout == 'pages'){
	//if this is the default layout then
	$columns = 'sixteen columns';
} else {
	$columns = 'twelve columns';
}
?>

<div class="container">
	<div class="row">
		<div class="page_heading"><h1><?php echo $title_view;?></h1></div>
		<div class="<?php echo $columns;?> alpha" style="margin-top:20px;">
		<?php
		
		//set the content variables here
		foreach ($pageContents as $content) {
			$content_id = $content['Page_content']['id'];
			$className = $content['Page_content']['class_name'];
			$html = $content['Page_content']['html'];
			
			echo $html;
			
		}
		?>
		</div>		
	</div>
