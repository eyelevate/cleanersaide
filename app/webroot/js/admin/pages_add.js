$(document).ready(function(){
	add.onPageLoad();
	add.events();
	add.requests();
});

/**
 * Functions
 */
add = {
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
		$("#saveDraft-add").click(function(){
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