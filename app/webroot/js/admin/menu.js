$(document).ready(function(){
	
	$("#menuSortable").nestedSortable({
		maxLevels: '3', //max level set right now is tier 3
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        stop: function(event, ui) {
        	var icon_theme = $('.iconThemeRadio:checked').val();
        	
        	switch(icon_theme){
        		case 'dark':
		        	//set the primary color Tier 1
		        	if($("#menuSortable div").length >0){
		        		$("#menuSortable div").attr('class','btn btn-large btn-block btn-primary');
		        	}
		        	//set Tier 2 colors
		        	if($("#menuSortable ol div").length >0){
		        		$("#menuSortable ol div").attr('class','btn btn-large btn-block btn btn-success');
		        	}
		        	//set Tier 3 colors
		        	if($("#menuSortable ol ol div").length >0){
		        		$("#menuSortable ol ol div").attr('class',' btn btn-large btn-block btn btn-danger');	
		        	}        		
        		
        		break;
        		
        		default:
		        	//set the primary color Tier 1
		        	if($("#menuSortable div").length >0){
		        		$("#menuSortable div").attr('class','btn btn-large btn-block btn');
		        	}
		        	//set Tier 2 colors
		        	if($("#menuSortable ol div").length >0){
		        		$("#menuSortable ol div").attr('class','btn btn-large btn-block btn-warning');
		        	}
		        	//set Tier 3 colors
		        	if($("#menuSortable ol ol div").length >0){
		        		$("#menuSortable ol ol div").attr('class','btn btn-large btn-block btn btn-info');	
		        	}        		
        		break;
        	}

			
			//only going to tier 3
			$("#menuSortable ol").attr('tier','2');
			$("#menuSortable ol ol").attr('tier','3');
   	 	}

    });
	$("#menuTitle").keyup(function(){
		//clear error messages
		$("#menuTitleDiv").attr('class','control-group');
		$("#menuTitleDiv .help-inline").html('');
		$("#menuSaveP p").remove();
	});
    $("#menuLabel").keyup(function(){
    	var label = $(this).val();
    	
    	if(label != ''){
    		$('#menuLabelDiv').attr('class','control-group');		
			$("#menuLabelDiv .help-inline").html(''); 	
    	}
		  	
    });
    $("#selectMenuUrl").change(function(){
    	var url = $("#selectMenuUrl option:selected").val();
    	if(url != 'none'){
			$('#menuUrlDiv').attr('class','control-group');
			$("#menuUrlDiv .help-inline").html('');	    		
    	}
    });

	//menu navigation controls
	//Row Creation
	$("#addNewMenuRow").click(function(){
		var label = $("#menuLabel").val();
		var url = $("#selectMenuUrl option:selected").val();		
		//validate the fields
		if(url == 'none' && label == ''){
			//error
			$('#menuLabelDiv').attr('class','control-group error');
			$("#menuLabelDiv .help-inline").html('Please provide a value for the label field');
			$('#menuUrlDiv').attr('class','control-group error');
			$("#menuUrlDiv .help-inline").html('Please select a connection type');	
		} else if(label ==''){
			//errpr
			$('#menuLabelDiv').attr('class','control-group error');
			$("#menuLabelDiv .help-inline").html('Please provide a value for the label field');		
		} else if(url =='none'){
			//error
			$('#menuUrlDiv').attr('class','control-group error');
			$("#menuUrlDiv .help-inline").html('Please select a connection type');				
		} else {
			//reset error messages and move on
			$('#menuLabelDiv').attr('class','control-group');		
			$("#menuLabelDiv .help-inline").html('');
			$('#menuUrlDiv').attr('class','control-group');
			$("#menuUrlDiv .help-inline").html('');	
			switch(url){
				case 'h1':
					url = 'Main Header';
				break;
				
				case 'h2':
					url = 'Sub Header';
				break;
				
				case 'br':
					url = 'Line Break';
				break;
				
				case '/':
					url = 'Home Page';
				break;
				default:
					url = url;
				break;
			}
			
			var icon_theme = $(".iconThemeRadio:checked").val();
			switch(icon_theme){
				case 'white':
					var icon = $('#addMenuRowIconDiv[name="white"] #icon_chosen').attr('chosen');
				break;
				
				case'dark':
					var icon = $("#addMenuRowIconDiv[name='dark'] #icon_chosen").attr('chosen');
				break;
			}
			switch(icon){
				case 'none':
				var	icon = '';
				break;
				
				default:
				var icon = icon;
				break;
			}	
			if(icon_theme == 'white'){
				var createRow = '<li label="'+label+'" icon="'+icon+'" url="'+url+'">'+
						'<div class="btn btn-large btn-block btn" style="text-align:left;">'+
							'<span> <i id="icon_move_menu" class="icon-move"></i><span class="divisionUp"><i class="'+icon+'" chosen="'+icon+'"></i> '+label+' - '+url+'</span></span>'+
							'<button id="removeMenuRow" name="'+label+'" style="position:absolute;right:75px;"><i class="icon-trash"></i></button>'+
						'</div>'+
					'</li>';
			
			} else {
				var createRow = '<li label="'+label+'" icon="'+icon+'" url="'+url+'">'+
						'<div class="btn btn-large btn-block btn-primary" style="text-align:left;">'+
							'<span> <i id="icon_move_menu" class="icon-move icon-white"></i><span class="divisionUp"><i class="'+icon+'" chosen="'+icon+'"></i> '+label+' - '+url+'</span></span>'+
							'<button id="removeMenuRow" name="'+label+'" style="position:absolute;right:75px;"><i class="icon-trash"></i></button>'+
						'</div>'+
					'</li>';
		
			}
			//append the row into the ordering div
			$(createRow).appendTo($("#menuSortable"));
			//add the remove script
			$("#removeMenuRow[name='"+label+"']").click(function(){
				$(this).parent().parent().remove();
			});	
			//reset the values in the creating div
			$('#menuLabel').val('');
			$("#selectMenuUrl option[value='none']").attr('selected','selected');
			$("#addMenuRowIconDiv[name='white'] #icon_chosen").attr('chosen','none');
			$("#addMenuRowIconDiv[name='white'] #icon_chosen i").attr('class','none');
			$("#addMenuRowIconDiv[name='white'] #icon_chosen span").html('Select Icon');
			$("#addMenuRowIconDiv[name='dark'] #icon_chosen").attr('chosen','none');
			$("#addMenuRowIconDiv[name='dark'] #icon_chosen i").attr('class','none');
			$("#addMenuRowIconDiv[name='dark'] #icon_chosen span").html('Select Icon');
		}
	});
	//icon theme selection
	$(".iconThemeRadio").click(function(){
		//start fresh
		$("#menuSortable li, #menuSortable ol").remove();
		//set variables
		var theme = $(this).val();
		switch(theme){
			case 'white':
				$("#addMenuRowIconDiv[name='dark']").hide();
				$("#addMenuRowIconDiv[name='white']").show();
			break;
			
			case 'dark':
				$("#addMenuRowIconDiv[name='white']").hide();
				$("#addMenuRowIconDiv[name='dark']").show();			
			break;
		}
	});
	//remove edit buttons works only in edit.ctp ->MenuControllers
	$("#menuSortable button").click(function(){
		//delete item
		$(this).parent().parent().remove();
	});
	//add icons
	$(".iconMenuLi").click(function(){
		var icon = $(this).attr('name');
		var icon_theme = $('.iconThemeRadio:checked').val();
		switch(icon_theme){
			case 'white':
				//send to main a
				$("#addMenuRowIconDiv[name='white'] #icon_chosen i").attr('class',icon);
				$("#addMenuRowIconDiv[name='white'] #icon_chosen span").html(icon);
				$("#addMenuRowIconDiv[name='white'] #icon_chosen").attr('chosen',icon);	
			break;
			
			case 'dark':
				//send to main a
				$("#addMenuRowIconDiv[name='dark'] #icon_chosen i").attr('class',icon);
				$("#addMenuRowIconDiv[name='dark'] #icon_chosen span").html(icon);
				$("#addMenuRowIconDiv[name='dark'] #icon_chosen").attr('chosen',icon);

			break;
		}
	});
/**
 * Clear out the Menu Creation Table and Start Fresh
 */
	$("#clearMenuButton").click(function(){
		$("#menuSortable ol, #menuSortable li").remove();
		$('#menuLabelDiv').attr('class','control-group');		
		$("#menuLabelDiv .help-inline").html('');
		$('#menuUrlDiv').attr('class','control-group');
		$("#menuUrlDiv .help-inline").html('');	
		$('#menuLabel').val('');
		$("#selectMenuUrl option[value='none']").attr('selected','selected');
		$("#addMenuRowIconDiv[name='white'] #icon_chosen").attr('chosen','none');
		$("#addMenuRowIconDiv[name='white'] #icon_chosen i").attr('class','none');
		$("#addMenuRowIconDiv[name='white'] #icon_chosen span").html('Select Icon');
		$("#addMenuRowIconDiv[name='black'] #icon_chosen").attr('chosen','none');
		$("#addMenuRowIconDiv[name='black'] #icon_chosen i").attr('class','none');
		$("#addMenuRowIconDiv[name='black'] #icon_chosen span").html('Select Icon');
		
	});
/**	
 * Submit the Menu Creation to the db
 */
	$("#createMenuButton").click(function(){	
		var menuTitle = $("#menuTitle").val();
		var menuHtml = $("#menuSortable").html();
		var menu_items_length = $("#menuSortable li").length;
		if(menu_items_length >0){
		
			if(menuTitle == ''){
				$('#menuTitleDiv').attr('class','control-group error');
				$('#menuTitleDiv .help-inline').html('You must have a menu name created before saving');
			} else {
				//reset any error messages
				$('#menuTitleDiv').attr('class','control-group');
				$('#menuTitleDiv .help-inline').html('');
				//place first message in the menuSaveDiv
				$("#menuSaveP").append('<p class="muted">Status: Checking menu name for duplicates or errors.</p>');
				
				//send the menu name to the db		
				$.post(
					'/menus/request',
					{
						type:'NEW_MENU',
						menuTitle:menuTitle,
						menuHtml:menuHtml
					}, function(result){
						var menu_id = result;	
						if(result == 'TAKEN'){
							$("#menuSaveP").append('<p class="text-error">Error: This menu name has already been taken. Please try again.</p>');
							$('#menuTitleDiv').attr('class','control-group error');
							$('#menuTitleDiv .help-inline').html('This menu name has already been taken. Please choose another menu name.');
							$("#toTopHover").click();	
						} else {
							//the menu has successfully been saved and we now have a menu_id
							//send the rest of the menu items to the db
							$("#menuSaveP").append('<p class="text-success">Success: Menu name has been successfully saved.</p>');
							$("#menuSaveP").append('<p class="muted">Status: saving created navigational menu items. Please wait.</p>');
							
							var menuLiCount = $("#menuSortable li").length;
							$("#menuSortable li").each(function(index){
								//set the variables
								var label = $(this).attr('label');
								var url = $(this).attr('url');
								var icon = $(this).attr('icon');
								switch(icon){
									case '':
										icon = 'NULL';
									break;
									default:
										icon = icon;
									break;
								}
								var order = index+1;
								var tier = $(this).parent().attr('tier');
								
								$.post(
									'/menus/request',
									{
										type:'NEW_MENU_ITEMS',
										label:label,
										url:url,
										icon:icon,
										order:order,
										tier:tier,
										menu_id:menu_id
									}, function(){
										//this is the last row
										if(index == menuLiCount-1){
											$("#menuSaveP").append('<p class="muted">Success: Menu saved!</p>');
											window.location.href = "/menus";
	
										}
									}
								);							
							});
							
						}
					}
				);
			}
		} else {
			$("#menuSaveP").append('<p class="text-error">Error: You must have at least 1 menu navigation before saving.</p>');
		}
	});
	/**
	 * edit.ctp
	 */
	$("#editMenuButton").click(function(){	
		var menuTitle = $("#menuTitle").val();
		var menuHtml = $("#menuSortable").html();
		var menu_id = $(this).attr('name');
		var menu_items_length = $("#menuSortable li").length;
		if(menu_items_length >0){
			//check to see if the menu name is empty
			if(menuTitle == ''){
				$('#menuTitleDiv').attr('class','control-group error');
				$('#menuTitleDiv .help-inline').html('You must have a menu name created before saving');
			} else {
				//reset any error messages
				$('#menuTitleDiv').attr('class','control-group');
				$('#menuTitleDiv .help-inline').html('');
				//place first message in the menuSaveDiv
				$("#menuSaveP").append('<p class="muted">Status: Checking menu name for errors.</p>');
				
				//send the menu name to the db		
				$.post(
					'/menus/request',
					{
						type:'EDIT_MENU',
						menuTitle:menuTitle,
						menuHtml:menuHtml,
						menu_id:menu_id
					}, function(result){
						var menu_id = $("#editMenuButton").attr('name');	
						if(result == 'TAKEN'){
							$("#menuSaveP").append('<p class="text-error">Error: This menu name has already been taken by another menu. Please try again.</p>');
							$('#menuTitleDiv').attr('class','control-group error');
							$('#menuTitleDiv .help-inline').html('This menu name has already been taken by another menu. Please choose another menu name.');
							$("#toTopHover").click();	
						} else {
							//the menu has successfully been saved and we now have a menu_id
							//send the rest of the menu items to the db
							$("#menuSaveP").append('<p class="text-success">Success: Menu name has been successfully updated.</p>');
							$("#menuSaveP").append('<p class="muted">Status: updating created navigational menu items. Please wait.</p>');
							
							var menuLiCount = $("#menuSortable li").length;
							
							$("#menuSortable li").each(function(index){
								//set the variables
								var label = $(this).attr('label');
								var url = $(this).attr('url');
								var icon = $(this).attr('icon');
								switch(icon){
									case '':
										icon = 'NULL';
									break;
									default:
										icon = icon;
									break;
								}
								var order = index+1;
								var tier = $(this).parent().attr('tier');
								
								$.post(
									'/menus/request',
									{
										type:'EDIT_MENU_ITEMS',
										label:label,
										url:url,
										icon:icon,
										order:order,
										tier:tier,
										menu_id:menu_id
									}, function(){
										//this is the last row
										if(index == menuLiCount-1){
											$("#menuSaveP").append('<p class="text-success">Success: Menu updated!</p>');
											location.reload();	
										}
									}
								);							
							});
							
						}
					}
				);
			}
		} else {
			$("#menuSaveP").append('<p class="text-error">Error: You must have at least 1 menu navigation before saving.</p>');
		}
	});
});