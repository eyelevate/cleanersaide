<?php
//add scripts to header
echo $this->Html->script(array('admin/pages_edit.js'),FALSE);
echo $this->Html->css(array('/js/admin/plugins/plupload/js/jquery.plupload.queue/css/plupload-gebo.css'),'stylesheet',array('inline',false));

//set page variables here
foreach ($pages as $page) {
	$url = $page['Page']['url'];
	$title = $page['Page']['title'];
	$description = $page['Page']['description'];
	$keywords = $page['Page']['keywords'];
	$status = $page['Page']['status'];
	$parent_id_selected = $page['Page']['parent_id'];	
	$page_name = $page['Page']['page_name'];
	$layout = $page['Page']['layout'];
	$menu_id_selected = $page['Page']['menu_id'];
	$created_url = trim(str_replace(array(' ','%20','%26',"'",'&'),array('-','','','','and'),$page_name));
}
if(isset($parents)){
	foreach ($parents as $parent){
		$parent_id = $parent['Page']['id'];
		$parentName = $parent['Page']['page_name'];
		if($parent_id_selected == $parent_id){
			$parentName_selected = $parentName;
		} else {
			$parentName_selected = '';
		}
	}
}
switch ($status) {
	case 'Draft':
		$visible = 'Administrators';
		break;
	default:
		$visible = 'Public';
		break;
}
//body content
?>

<script type="text/javascript" src="/js/admin/plugins/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea#wysiwg_full",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor moxiemanager"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    // templates: [
        // {title: 'Test template 1', content: 'Test 1'},
        // {title: 'Test template 2', content: 'Test 2'}
    // ],

});
</script>

<h1 class="heading">Edit Page</h1>
<?php
echo $this->Form->create();
?>
<!-- Form sending response div -->
<div class="row-fluid">
	<div class="span8">
		<?php
		echo $this->Form->input('Page.'.$page_id.'.page_name', array(	
			'div'=>array('class'=>'control-group'),
			'type'=>'text',
			'size'=>'100',
			'maxlength'=>'100',
			'class'=>'span12 pageCreationInput input-xxlarge',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'value'=>$page_name
		));
		?>
		<div id="createUrlDiv">
			<h5 id="createUrlH4">Link:</h5>
			<p id="createUrlA" name="<?php echo $url;?>">http://www.webupons.com<span id="createParentSpan"><?php echo $parentName_selected;?></span><span id="createUrlSpan"><?php echo '/'.$created_url;?></span></p>
		</div>
		<button id="createUrlClear">Clear URL</button>

		<?php
		if(!empty($contents)){
		foreach ($contents as $content):
			$content_id = $content['Page_content']['id'];
			$page_class = $content['Page_content']['class_name'];
			$html = $content['Page_content']['html'];	
		?>		
		<div id="pageContentContainer-<?php echo $content_id;?>" class="pageContentContainer">
			<textarea class="pageContentTextarea" id="wysiwg_full" rows="20"  name="data[Page_content][<?php echo $page_id;?>][html]"><?php echo $html;?></textarea>

		</div>
		<?php
		endforeach;
		} else {
		?>		
		<div id="pageContentContainer-0" class="pageContentContainer">
			<textarea class="pageContentTextarea" id="wysiwg_full" rows="20" name="data[Page_content][<?php echo $page_id;?>][html]"></textarea>

		</div>
		<?php			
		}
		?>

		<div id="multi_upload"></div>

		<h3 class="heading" style="margin-top:20px;">Search Engine Optimization</h3>
		<?php
		echo $this->Form->input('Page.'.$page_id.'.title', array(	
			'div'=>array('class'=>'control-group'),
			'type'=>'text',
			'id'=>'PageUrl',
			'size'=>'100',
			'maxlength'=>'100',
			'class'=>'span12 pageSEOinputs input-xxlarge',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'value'=>$title
		));			
		echo $this->Form->input('Page.'.$page_id.'.keywords', array(	
			'div'=>array('class'=>'control-group controls'),
			'type'=>'textarea',

			'class'=>'span12 pageSEOtextarea',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'value'=>$keywords,
		));	
		echo $this->Form->input('Page.'.$page_id.'.description', array(	
			'div'=>array('class'=>'control-group'),
			'type'=>'textarea',

			'class'=>'span12 pageSEOtextarea',
			'error'=>array('attributes' => array('class' => 'help-block')),
			'value'=>$description
		));
			
		?>


	</div>

	<div class="span4 well">
		<div>
			<h2>Publish Status</h2>
			<ul>
				<li>Status: <span><?php echo $status;?></span></li>
				<li>Visible: <span><?php echo $visible;?></span></li>
			</ul>
			<a href="/pages/preview<?php echo $url;?>" id="previewPage-<?php echo $page_id;?>" class="previewPage" target="_blank">Preview</a>
			<br/>
			<div class="pull-left" >
			<?php 
			echo $this->Form->submit('Save As Draft',array('class'=>'btn btn-primary'));	
			?>				
			</div>
			<div class="pull-left" style="margin-left:10px;">
			<?php 
			echo $this->Html->link('Publish',array('controller'=>'pages','action'=>'publish', $page_id), array('id'=>'publishPage','class'=>'btn btn-success'));	
			?>				
			</div>
		</div>				
	</div>
	
	<div class="span4 well">
		<div>
			<h4 class="heading">Page Layout</h4>
			<select id="pageLayoutSelect" name="data[Page][<?php echo $page_id;?>][layout]">
				<?php
				
				if($layout == 'pages'){
				?>
				<option class="pageLayoutOption" value="pages" selected='selected'>Default</option>
				<option class="pageLayoutOption" value="pages_sidebar">Default w/ Sidebar</option>
				<?php	
				} else {
				?>
				<option class="pageLayoutOption" value="pages">Default</option>
				<option class="pageLayoutOption" value="pages_sidebar" selected='selected'>Default w/ Sidebar</option>
				<?php	
				}
				?>
			</select>
		</div>
		<div>
			<h4 class="heading">Select Parent Page</h4>
			<select id="parentUrlSelect"  name="data[Page][<?php echo $page_id;?>][parent_id]">
				<option id="parentUrlOption-none" class="parentUrlOption" value="none" >No Parent</option>
				<?php
				foreach ($parents as $parent):
					$parentName = $parent['Page']['url'];
					$parent_id = $parent['Page']['id'];
					if($parent_id_selected == $parent_id){
						$parentName_selected = $parentName;
					?>
					<option id="parentUrlOption-<?php echo $parent_id;?>" class="parentUrlOption" value="<?php echo $parentName;?>" selected="selected"><?php echo $parentName;?></option>
					<?php	
					} else {
						$parentName_selected = '';
					?>
					<option id="parentUrlOption-<?php echo $parent_id;?>" class="parentUrlOption" value="<?php echo $parentName;?>"><?php echo $parentName;?></option>
					<?php
					}
	
				endforeach;
				?>
			</select>
		</div>


		
	</div>
	


</div>
<?php
echo $this->Form->end();
?>
<div id="requestMessage"></div>