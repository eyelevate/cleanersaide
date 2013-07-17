<?php
//add scripts to header
echo $this->Html->script(array('admin/pages_add.js'),FALSE);

echo $this->Html->css(array('/js/admin/plugins/plupload/js/jquery.plupload.queue/css/plupload-gebo.css'),'stylesheet',array('inline',false));

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

<h1 class="heading">Add New Page</h1>

<!-- Form sending response div -->
<?php
echo $this->Form->create();
?>
<div class="row-fluid">
	<div class="span8">
		<?php
		echo $this->Form->input('Page.page_name', array(	
			'div'=>array('class'=>'control-group'),
			'type'=>'text',
			'id'=>'PageUrl',
			'size'=>'100',
			'maxlength'=>'100',
			'class'=>'span12 pageCreationInput input-xxlarge',
			'error'=>array('attributes' => array('class' => 'help-block')),
		));
	
		?>
		<!-- <div id="urlCreation">
			<label>Title</label>
			<input id="PageUrl" class="pageCreationInput input-xxlarge" type="text" size="100" maxlength="100"/>
		</div> -->
		
		<div id="createUrlDiv">
			<h5 id="createUrlH4">Link:</h5>
			<p id="createUrlA" name="">http://www.cohoferry.com<span id="createParentSpan"></span><span id="createUrlSpan"></span></p>
		</div>
		<button id="createUrlClear">Clear URL</button>
		
		<div>
			<textarea class="pageContentTextarea" id="wysiwg_full" rows="20" name="data[Page_content][html]"></textarea>
		</div>
		
		<div id="multi_upload"></div>
		
		<h3 class="heading" style="margin-top:20px;">Search Engine Optimization</h3>
		<?php
		echo $this->Form->input('Page.title', array(	
			'div'=>array('class'=>'control-group'),
			'type'=>'text',
			'size'=>'100',
			'maxlength'=>'100',
			'class'=>'span12 pageSEOinputs input-xxlarge',
			'error'=>array('attributes' => array('class' => 'help-block')),
		));			
		echo $this->Form->input('Page.keywords', array(	
			'div'=>array('class'=>'control-group controls'),
			'type'=>'textarea',

			'class'=>'span12 pageSEOtextarea',
			'error'=>array('attributes' => array('class' => 'help-block')),
		));	
		echo $this->Form->input('Page.description', array(	
			'div'=>array('class'=>'control-group'),
			'type'=>'textarea',

			'class'=>'span12 pageSEOtextarea',
			'error'=>array('attributes' => array('class' => 'help-block')),
		));
			
		?>
		<!-- <div id="titleTagDiv">
			<label>Page Title</label>
			<input type="text" class="pageSEOinputs input-xxlarge" id="pageTitle"/>
		</div>
		<div id="metaKeywordsDiv">
			<label>Keywords</label>
			<textarea class="pageSEOtextarea span12" id="pageKeywords" name="data[Page][keywords]"></textarea>
		</div>
		<div id="metaDescriptionDiv">
			<label>Description</label>
			<textarea class="pageSEOtextarea span12" id="pageDescription" name=></textarea>
		</div> -->

	</div>

	<div class="span4 well">
		
		<div>
			<h3 class="heading">Page Status</h3>
			<ul>
				<li>Status: <span>Not Saved</span></li>
				<li>Visible: <span>Administrators</span></li>
			</ul>
			
			<?php 
			//echo $this->Html->tag('button','Save As Draft',array('id'=>'saveDraft-add','class'=>'btn btn-primary'));
			echo $this->Form->submit('Save As Draft',array('class'=>'btn btn-primary'));
			?>
		</div>
		
	</div>
	
	<div class="span4 well">
		<div>
			<h4 class="heading">Page Layout</h4>
			<select id="pageLayoutSelect" name="data[Page][layout]">
				<option class="pageLayoutOption" value="pages">Default</option>
				<option class="pageLayoutOption" value="pages_sidebar">Default w/ Sidebar</option>
			</select>
		</div>

		<div>
			<h4 class="heading">Select Parent Page</h4>
			<select id="parentUrlSelect" name="data[Page][parent_id]">
				<option id="parentUrlOption-none" class="parentUrlOption" value="0">No Parent</option>
				<?php
				foreach ($parents as $parent):
					$parentName = $parent['Page']['url'];
					$parent_id = $parent['Page']['id'];
				?>
				<option id="parentUrlOption-<?php echo $parent_id;?>" class="parentUrlOption" value="<?php echo $parentName;?>"><?php echo $parentName;?></option>
				<?php	
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