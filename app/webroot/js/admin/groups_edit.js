$(document).ready(function(){

	groups.events();

});

groups = {
	events: function(){
		$("#groupsUl").treeview();
			
		//add page scripts
		$("#accessDisplay").change(function(){
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$("#acoDiv").show();
			} else {
				$("#acoDiv").hide();
			}
		});

		$("#groupsUl input[type='checkbox']").click(function(){
			var controller = $(this).attr('id');
			var type = $(this).attr('class');
			var checked = $(this).attr('checked');
			groups.checked(controller,type,checked);
	
		});		

		
		$("#deleteGroupButton").click(function(){
			$(".deleteGroupButton2").click();
		});
	},

	checked: function(controller, type, checked){
		if(type =='controller'){			
			if(checked == 'checked'){
				$("#groupsUl input[type='checkbox'][controller='"+controller+"']").attr('checked','true');
				$("#groupsUl input[type='checkbox'][controller='"+controller+"']").attr('disabled','disabled');
			} else {

				$("#groupsUl input[type='checkbox'][controller='"+controller+"']").removeAttr('checked');
				$("#groupsUl input[type='checkbox'][controller='"+controller+"']").removeAttr('disabled');							
			}
		}
	},

}

