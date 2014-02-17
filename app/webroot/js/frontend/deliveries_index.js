$(document).ready(function(){
	delivery.mask();
	delivery.events();
	
});

delivery = {
	mask: function(){
		//phone formatting
		$(".phone").mask("(999) 999-9999");

	},	
	events: function(){
		$("#newMemberButton").click(function(){
			$("#custInfoForm").attr('action','/users/redirect_new_frontend_customer').submit();
		});
		$("#nextButton").click(function(){
			$("#custInfoForm").submit();
		});
		
		$("#deliveryBag").change(function(){
			var bag_message = '**['+$(this).val()+']** ';
			if($(this).is(':checked')){
				var special_instructions = $("#special_instructions").val();
				var new_special_instructions = bag_message+''+special_instructions;
				$("#special_instructions").val(new_special_instructions);
			} else {
				var special_instructions = $("#special_instructions").val();
				var new_special_instructions = special_instructions.replace(bag_message,'');
				$("#special_instructions").val(new_special_instructions);
				
			}
		});
	},

};
