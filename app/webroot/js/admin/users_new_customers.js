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
			} else {
				$("#paymentForm").addClass('hide');
			}
		});
	},
};
