/* [ ---- extended form elements ---- ] */

	$(document).ready(function() {
		//* WYSIWG editor
        //bbfl_wysiwg.init();
        //* multiupload
        //bbfl_multiupload.init();
        
                  // tinymce.init({
    				// selector: "textarea#wysiwg_full",
                    // plugins: [
				        // "advlist autolink lists link image charmap print preview anchor",
				        // "searchreplace visualblocks code fullscreen",
				        // "insertdatetime media table contextmenu paste moxiemanager"
				    // ],
				    // toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            	  // });

	});
	
    //* TinyMce
	bbfl_wysiwg = {
		init: function(){
			// File Browser
            //function openKCFinder(field_name, url, type, win) {
            //    alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing
            //    tinyMCE.activeEditor.windowManager.open({
            //        file: 'admin/plugins/file-manager/browse.php?opener=tinymce&type=' + type,
            //        title: 'KCFinder',
            //        width: 700,
            //        height: 500,
            //        resizable: "yes",
            //        inline: true,
            //        close_previous: "no",
            //        popup_css: false
            //    }, {
            //        window: win,
            //       input: field_name
            //    });
            //    return false;
            //};
            //$('textarea#wysiwg_full').tinymce({
                // Location of TinyMCE script
                //script_url 							: '/js/admin/plugins/tiny_mce/jquery.tinymce.js',

		}
	};
    
	//* drag&drop multi-upload
    bbfl_multiupload = {
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
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip"}
                ],
        
			// Flash settings
			flash_swf_url : '/js/admin/plugins/plupload/js/plupload.flash.swf',
			// Silverlight settings
			silverlight_xap_url : '/js/admin/plugins/plupload/js/plupload.silverlight.xap'
            });
        }
    };
	
	
	