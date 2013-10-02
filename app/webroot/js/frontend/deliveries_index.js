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
			$("#guestForm").attr('action','/users/redirect_new_frontend_customer').submit();
		});
	},

};
