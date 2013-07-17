$(document).ready(function(){
	edit.onPageLoad();
	edit.events();
	edit.requests();
	
	multiupload.init();
});

/**
 * Functions
 */

//* drag&drop multi-upload
multiupload = {
	init: function() {
		$("#multi_upload").pluploadQueue({
			// General settings
			runtimes : 'html5,flash,silverlight',
			url : '/js/admin/plugins/plupload/examples/upload.php',
			max_file_size : '10mb',
			chunk_size : '1mb',
			unique_names : true,
			browse_button : 'pickfiles',
			
			// Specify what files to browse for
			filters : [
			{title : "Image files", extensions : "jpg,gif,png,svg"},
			{title : "Zip files", extensions : "zip"}
			],
			// Flash settings
			flash_swf_url : '/js/admin/plugins/plupload/js/plupload.flash.swf',
			// Silverlight settings
			silverlight_xap_url : '/js/admin/plugins/plupload/js/plupload.silverlight.xap'
		});
		
        var uploader = $('#multi_upload').pluploadQueue();

		//success callback function
        uploader.bind('FileUploaded', function(up, file, info) {

			//insert into input div
			multiupload.createInput(file.id, file.name, '#imagesFormDiv');    
			//create gallery
			multiupload.createThumbnail(file.id, file.name, '#homeImageGallery'); 
			//create scripts for deletion and to make primary
			multiupload.scriptCreator(file.id, file.name, '#imagesFormDiv');

          	//if last image was completed
            if (uploader.files.length == (uploader.total.uploaded + uploader.total.failed)) {
            	//restart plupload
            	uploader.start();           	
            	//show list of thumbnails
            	$("#homeThumbnailsDiv").show();
				//insert into image folder

            }
           	if(up.total.queued == 0) {
	            multiupload.init();
	        }
	        
        });
        
	    // autostart
	    uploader.bind('FilesAdded', function(up, files) {
	        uploader.start();
	    });


	},
	createThumbnail: function(id, name, gallery){
		//create thumbnail script
		var thumbnail = 
	 		'<li id="thumbnail-'+id+'" class="thumbnail" imageId="'+id+'" style="display: inline-block; cursor:pointer;" name="nonprimary">'+
				'<div style="z-index:1;"class="fileupload-preview thumbnail" title="Image_20 title long title long title long">'+
					'<img style="z-index:0;" src="/img/tmp/'+id+'.jpg"/>'+
				'</div>'+
				'<p>'+
					'<a id="removeImage-'+id+'" class="removeImage" title="Remove" href="javascript:void(0)">'+
						'<i class="icon-trash"></i>'+
					'</a>'+
					'<span>'+name+'</span>'+
				'</p>'+
			'</li>';
		//insert created thumbnail into         
		$(gallery).append(thumbnail);   
		$(".home_ticket_images").each(function(){
			$(this).append(thumbnail);
		});	
	}, 
	createInput: function(id, name, divClass){
		var filename =  id +'.'+name.split(".").pop();
		var index = $("#homeImageGallery li").length;
		var inputCreated = 
			'<input id="imageStatus-'+id+'" class="imageInput" name="data[Images]['+index+'][image_name]" value="'+filename+'"/>';
		$(divClass).append(inputCreated);
	},
	scriptCreator: function(id, name, divClass){
		$(".thumbnail[imageId='"+id+"']").click(function(){		
			$(this).parent().find('li').attr('name','nonprimary');
			$(this).parent().find('li').css({
				'background':'#ffffff'
			});
			$(this).attr('name','primary');	
			$(this).css({
				'background':'#a7ffb8'
			});
			//establish if this is a attraction or a attraction room
			var parent_id = $(this).parent().attr('name');
			var filename =  id +'.'+name.split(".").pop();
			//if(parent_id == 'Attraction'){
				var primary_input = '<input type="hidden" attraction="'+parent_id+'" filename="'+id+'" name="data['+parent_id+'][image_main]" value="'+filename+'"/>';
				//remove other instances
				$("#imagesFormDiv input[attraction='"+parent_id+"']").remove();
				//add in new attraction primary image
				$("#imagesFormDiv").append(primary_input);
			// }
			// if(parent_id == 'Attraction_ticket'){
				// var tour = $(this).parent().parent().parent().parent().parent().parent().parent().find('a h4').html();
				// var tour_id = $(this).parent().attr('id').replace('attraction_ticket_images-','');
				// var primary_input = '<input type="hidden" attraction="'+parent_id+'" tour="'+tour+'" filename="'+id+'" name="data['+parent_id+']['+tour_id+'][image_primary]" value="'+filename+'"/>';
				// //remove other instances
				// $("#imagesFormDiv input[attraction='"+parent_id+"'][tour='"+tour+"']").remove();
				// //add in new attraction primary image
				// $("#imagesFormDiv").append(primary_input);				
			// }
			
		});
		$("#removeImage-"+id).click(function(){
			var filename =  id +'.'+name.split(".").pop();
			//remove from dom
			$(this).parent().parent().remove();
			
			//add a remove to inputs
			var removeInput = '<input name="data[Remove]['+filename+']" value="'+name+'"/>';
			$(divClass).append(removeInput);
			//remove the rest of the room pics
			$("#accordion4 .home_images #thumbnail-"+id).each(function(){
				$(this).remove();
			});
		});

	}
}; 

edit = {
	onPageLoad: function(){
		//REMOVE success or flash messages after 5 seconds
		if($('.message').is(':visible')){
			setTimeout(function() {
			    $('.message').fadeOut('fast');
			}, 5000); // <-- time in milliseconds
		
		} 		
	},
	events: function(){
		//Url Creation parent selection
		$("#parentUrlSelect").change(function(){
			var parent = $("#parentUrlSelect option:selected").attr('value');
			
			//add this into the permanent link for the viewer to see
			switch (parent){
				case 'none':
					$("#createParentSpan").html('');			
				break;
				
				default:
					$("#createParentSpan").html(parent);		
				break;
			}		
		});
		//Url creation new page input box
		$("#PageUrl").keyup(function(){
			var parent = $("#parentUrlSelect option:selected").attr('value');
			var url = $(this).val();
			//replaces all special characters with a space, space bar is replaced with a -
			var url = url.replace(/[^\w\s]/gi, '').replace(/ /g,"-");
			var fullUrl = 'http://www.cohoferry.com/'+url;
			
			switch (parent){
				case 'none':
					$("#createUrlA").attr('name',fullUrl);
					$("#createUrlSpan").html('/'+url);			
				break;
				
				default:
					$("#createUrlA").attr('name',parent+'/'+fullUrl);
					$("#createUrlSpan").html('/'+url);		
				break;
			}
		});
		//clear url creation form
		$("#createUrlClear").click(function(){
			//set parent selection to default
			$("#parentUrlSelect option[value='none']").attr('selected', 'selected');
			//erase the url input form
			$("#PageUrl").val('');
			//set the permanent link back to null
			$("#createParentSpan").html('');
			$("#createUrlA").attr('name','');
			$("#createUrlSpan").html('');
		});
			
	},
	requests: function(){
		//ajax saving page to pages controller add method -> db 
		$("#saveDraft-edit").click(function(){
			//set variables
			var url1 = $("#parentUrlSelect option:selected").val();
			var url2 = $("#createUrlSpan").html();
			var parent_id = $("#parentUrlSelect option:selected").attr('id').replace('parentUrlOption-','');
			var title = $("#pageTitle").val();
			var page_name = $("#PageUrl").val();
			var keywords = $("#pageKeywords").val();
			var description = $("#pageDescription").val();
			var layout = $("#pageLayoutSelect option:selected").val();
			var sendType = $(this).attr('id').replace('saveDraft-','');
			if(sendType =='add'){
				var split = 'Page';
				var page_id = 'NULL';
			} else {
				//This is an edit
				var page_id = $('.previewPage').attr('id').replace('previewPage-','');
				var split = 'Page_edit';
			}
	
			//parse the variables to make sure its data ready
			switch (url1){
				case 'none':
					if(url2 == '/'){
						var url = 'NULL';
						var relationship = 'NULL';					
					} else {
						var url = url2;
						var relationship = 1;	
					}
				break;
				
				default:
					if(url2 =='/'){
						var url = 'NULL';
						var relationship = 'NULL';
					} else {
						var url = url1+url2;
						var relationship = 2;	
					}
				break;
			}
			$.post(
				'/pages/validate_form',
				{
					url:url,
					relationship:relationship,
					page_name:page_name,
					parent_id:parent_id,
					title:title,
					keywords:keywords, 
					description:description,
					layout:layout,
					split:split,
					page_id:page_id
				},	function(error){
					if(error.length>0){
						$("#requestMessage").append(error);
					} 
					
					//set image variables here
					var pageCheck = $("#requestMessage .messageP").attr('id').replace('messageP-','');
	
					if(sendType =='add'){
						var split = 'Image';
						var page_id = 'NULL';
					} else {
						//This is an edit
						var page_id = $('.previewPage').attr('id').replace('previewPage-','');
						var split = 'Image_edit';
					}
	
					//if a for loop is needed for multiple images do here
					//send the next set of data to save images saved
					
					if(pageCheck != 'error'){			
						//set variables for page content here
						var element = $("#pageContentSelect option:selected").val();
						var content = $(".pageContentTextarea").val();						
						switch(content){
							case '':
								var content = 'NULL';
							break;
							
							default:
								var content = content;
							break;
						}
						if(sendType =='add'){
							var split = 'Content';
							var page_id = 'NULL';
							var content_id = 'NULL';
							//save data from page_content
							$.post(
								'/pages/validate_form',
								{
									content_id:content_id,
									element:element,
									content:content,
									split:split,
									page_id:page_id
								},	function(error){
									
									if(error.length>0){
										$("#requestMessage").append(error);
									} 
									var page_id = $("#requestMessage .messageP").attr('id').replace('messageP-','');
									window.location.href = "/pages/view";
								}
							);
						} else {
							//This is an edit
							var split = 'Content_edit';
							var page_id = $('.previewPage').attr('id').replace('previewPage-','');
							$(".pageContentContainer").each(function(){
								var content_id = $(this).attr('id').replace('pageContentContainer-','');
								//if multiple rows are created then put a for loop here
								$.post(
									'/pages/validate_form',
									{
										content_id:content_id,
										element:element,
										content:content,
										split:split,
										page_id:page_id
									},	function(error){
										
										if(error.length>0){
											$("#requestMessage").append(error);
										} 
										var page_id = $("#requestMessage .messageP").attr('id').replace('messageP-','');
										window.location.href = "/pages/view";
	
									}
								);								
							});
						}
	
					} 	
				}
			);	
		});		
	}
}

