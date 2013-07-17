$(document).ready(function(){
//multi file upload	
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
			multiupload.createThumbnail(file.id, file.name, '#hotelImageGallery'); 
			//create scripts for deletion and to make primary
			multiupload.scriptCreator(file.id, file.name, '#imagesFormDiv');

          	//if last image was completed
            if (uploader.files.length == (uploader.total.uploaded + uploader.total.failed)) {
            	//restart plupload
            	uploader.start();           	
            	//show list of thumbnails
            	$("#hotelThumbnailsDiv").show();
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
		$(".hotel_room_images").each(function(){
			$(this).append(thumbnail);
		});	
	}, 
	createInput: function(id, name, divClass){
		var filename =  id +'.'+name.split(".").pop();
		var index = $("#hotelImageGallery li").length;
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
			//establish if this is a hotel or a hotel room
			var parent_id = $(this).parent().attr('name');
			var filename =  id +'.'+name.split(".").pop();
			if(parent_id == 'Hotel'){
				var primary_input = '<input type="hidden" hotel="'+parent_id+'" filename="'+id+'" name="data['+parent_id+'][image_main]" value="'+filename+'"/>';
				//remove other instances
				$("#imagesFormDiv input[hotel='"+parent_id+"']").remove();
				//add in new hotel primary image
				$("#imagesFormDiv").append(primary_input);
			}
			if(parent_id == 'Hotel_room'){
				var room = $(this).parent().parent().parent().parent().parent().parent().parent().find('a h4').html();
				var room_id = $(this).parent().attr('id').replace('hotel_room_images-','');
				var primary_input = '<input type="hidden" hotel="'+parent_id+'" room="'+room+'" filename="'+id+'" name="data['+parent_id+']['+room_id+'][image_primary]" value="'+filename+'"/>';
				//remove other instances
				$("#imagesFormDiv input[hotel='"+parent_id+"'][room='"+room+"']").remove();
				//add in new hotel primary image
				$("#imagesFormDiv").append(primary_input);				
			}
			
		});
		$("#removeImage-"+id).click(function(){
			var filename =  id +'.'+name.split(".").pop();
			//remove from dom
			$(this).parent().parent().remove();
			
			//add a remove to inputs
			var removeInput = '<input name="data[Remove]['+filename+']" value="'+name+'"/>';
			$(divClass).append(removeInput);
			//remove the rest of the room pics
			$("#accordion4 .hotel_room_images #thumbnail-"+id).each(function(){
				$(this).remove();
			});
		});

	}
}; 