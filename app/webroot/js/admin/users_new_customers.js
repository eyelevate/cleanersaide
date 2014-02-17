$(document).ready(function(){
	users.mask();
	users.events();
});

users = {
	mask: function(){
		//phone formatting
		$(".phone").mask("(999) 999-9999");

	},	
	events: function(){
		$("#newMemberButton").click(function(){
			$("#guestForm").attr('action','/users/new_customers').submit();
		});
		$(".piInput").click(function(){
			var checked = $(this).attr('value');
			
			if(checked == 'Yes'){
				$("#paymentForm").removeClass('hide');
				$("#paymentForm input").removeAttr('disabled');
				$("#UserCardFullName").attr('name','data[User][card_full_name]');
				$("#UserCcnum").attr('name','data[User][ccnum]');
				$("#UserExpMonth").attr('name','data[User][exp_month]');
				$("#UserExpYear").attr('name','data[User][exp_year]');
				$("#UserCvv").attr('name','data[User][cvv]');
			} else {
				$("#paymentForm").addClass('hide');
				$("#paymentForm input").attr('disabled','disabled').attr('name','');
				
			}
		});
		
		$("#deliveryBag").change(function(){
			var bag_message = '**['+$(this).val()+']** ';
			if($(this).is(':checked')){
				var special_instructions = $("#UserSpecialInstructions").val();
				var new_special_instructions = bag_message+''+special_instructions;
				$("#UserSpecialInstructions").val(new_special_instructions);
			} else {
				var special_instructions = $("#UserSpecialInstructions").val();
				var new_special_instructions = special_instructions.replace(bag_message,'');
				$("#UserSpecialInstructions").val(new_special_instructions);
				
			}
		});
	},
};
