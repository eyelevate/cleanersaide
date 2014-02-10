<?php
//add scripts to header
echo $this->Html->script(array('admin/pages_edit_home.js'),FALSE);
echo $this->Html->css(array('/js/admin/plugins/plupload/js/jquery.plupload.queue/css/plupload-gebo.css'),'stylesheet',array('inline',false));

$image_sort = array();

//set page variables here
foreach ($pages as $page) {
	$url = $page['Page']['url'];
	$title = $page['Page']['title'];
	$description = $page['Page']['description'];
	$keywords = $page['Page']['keywords'];
	//$status = $page['Page']['status'];
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

//var_dump(addslashes($contents[0]['Page_content']['html']));

$contents = json_decode($contents[0]['Page_content']['html'], TRUE);


// switch ($status) {
	// case 'Draft':
		// $visible = 'Administrators';
		// break;
	// default:
		// $visible = 'Public';
		// break;
// }
//body content
?>

<script type="text/javascript" src="/js/admin/plugins/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: ".wysiwyg",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor moxiemanager"
    ],
    toolbar1: "insertfile link image code",
    image_advtab: true,
    menubar : false
    // templates: [
        // {title: 'Test template 1', content: 'Test 1'},
        // {title: 'Test template 2', content: 'Test 2'}
    // ],

});
</script>

<h1 class="heading">Edit Homepage</h1>
<?php
echo $this->Form->create();
?>
<!-- Form sending response div -->
<div class="row-fluid">
	<div class="span12">
		
		<h4>Slider Photos</h4>
		
		<div id="mixed_grid" class="wmk_grid well well-large" >
			<ul id="homeImageGallery" style="position: relative;" name="Home">
			<?php
			$count_images = count($image_sort);
			if($count_images>0){
				foreach ($image_sort as $key =>$value) {
					$image_name = $image_sort[$key]['image_name'];
					if($image_name == $image_main){
					?>
			 		<li id="thumbnail-<?php echo $image_name;?>" class="thumbnail" imageId="<?php echo $image_name;?>" style="display: inline-block; cursor: pointer; background: none repeat scroll 0% 0% rgb(167, 255, 184);" name="primary">
						<div style="z-index:1;"class="fileupload-preview thumbnail" title="Image_20 title long title long title long">
							<img style="z-index:0;" src="/img/home/<?php echo $image_name;?>"/>
						</div>
						<p>
							<a id="removeImage-" class="removeImage" title="Remove" href="javascript:void(0)">
								<i class="icon-trash"></i>
							</a>
							<span><?php echo $image_name;?></span>
						</p>
					</li>
					<?php								
					} else {
					?>
			 		<li id="thumbnail-<?php echo $image_name;?>" class="thumbnail" imageId="<?php echo $image_name;?>" style="display: inline-block; cursor:pointer;" name="nonprimary">
						<div style="z-index:1;"class="fileupload-preview thumbnail" title="Image_20 title long title long title long">
							<img style="z-index:0;" src="/img/home/<?php echo $image_name;?>"/>
						</div>
						<p>
							<a id="removeImage-'+id+'" class="removeImage" title="Remove" href="javascript:void(0)">
								<i class="icon-trash"></i>
							</a>
							<span><?php echo $image_name;?></span>
						</p>
					</li>
					<?php								
					}
				}	
			}
			?>
			</ul>
		</div>

		<div id="multi_upload"></div>
	</div>
</div>

<hr>

<div class="row-fluid">
	<div class="span7">
	<h4>Secondary Promo Box</h4>
		<textarea class="pageContentTextarea wysiwyg span12" name="data[Page_content][1][secondary_promo]" style="height: 275px;"><? echo $contents['secondary_promo']; ?></textarea>
	</div>
	<div class="span5">
	<h4>Secondary Info Boxes</h4>
		<textarea class="pageContentTextarea wysiwyg span12" name="data[Page_content][1][secondary_info_1]" style="margin-bottom: 10px;" ><? echo $contents['secondary_info_1']; ?></textarea>
		<textarea class="pageContentTextarea wysiwyg span12" name="data[Page_content][1][secondary_info_2]" ><? echo $contents['secondary_info_2']; ?></textarea>
	</div>
</div>

<hr>

<div class="row-fluid">
	<div class="span4">
		<h4>Tertiary Box 1</h4>
		<textarea class="pageContentTextarea span12 wysiwyg" name="data[Page_content][1][tertiary_1]" ><? echo $contents['tertiary_1']; ?></textarea>
	</div>
	<div class="span4">
		<h4>Tertiary Box 2</h4>
		<textarea class="pageContentTextarea span12 wysiwyg" name="data[Page_content][1][tertiary_2]" ><? echo $contents['tertiary_2']; ?></textarea>
	</div>
	<div class="span4">
		<h4>Tertiary Box 3</h4>
		<textarea class="pageContentTextarea span12 wysiwyg" name="data[Page_content][1][tertiary_3]" ><? echo $contents['tertiary_3']; ?></textarea>
	</div>
</div>

<hr>

<div class="row-fluid">
	<div class="span4">
		<div>
			<div class="pull-left" >
			<?php 
			echo $this->Form->submit('Save',array('class'=>'btn btn-primary'));	
			?>				
			</div>
		</div>				
	</div>
</div>

<?php
echo $this->Form->end();
?>
<div id="requestMessage"></div>