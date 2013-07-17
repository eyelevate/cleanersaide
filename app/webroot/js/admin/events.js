$(document).ready(function(){
//REMOVE success or flash messages after 5 seconds
if($('.message').is(':visible')){
	setTimeout(function() {
	    $('.message').fadeOut('fast');
	}, 5000); // <-- time in milliseconds

} 
/**
 * Admin Controller
 */
	/***********Admin Index**************/
	$("#navigationUl-admin li").click(function(){
		//get section name
		var clicked = $(this).attr('id').replace('navigationLiAdmin-','');
		
		//make all li notactive & make clicked selected active
		$("#navigationUl-admin li").attr('class','notactive');
		$(this).attr('class','active');

		//hide all the subcontent li & show the active subcontent li 
		$("#navigationUlContent-admin li").attr('name','notactive');
		$("#navigationUlContent-admin #navigationLiContent-"+clicked).attr('name','active');
	});
/**
 * Pages Controller
 */	
	/**************add.ctp*****************/
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
	


});

