$(document).ready(function(){
	payments.mask();
	payments.validation();
	payments.events();
});

/**
 * Function
 */

payments = {
	mask: function(){
		//phone formatting
		//var phone = $("#UserContactPhone").val();
		//$("#UserContactPhone").mask("(999) 999-9999").val(phone).blur();

	},
	validation: function(){
		
		
		
		var paymentValue = $("#PaymentVdata").val();
		$("#PaymentVdata").blur(function(){
			var thisValue = $(this).val();

			if($(this).parent().hasClass('error')){
				if(paymentValue == thisValue){
					$(this).parent().addClass('error');
					$(this).parent().find('.help-block').html('This field cannot be the same value as previous');				
				} else {
					$(this).parent().removeClass('error');
					$(this).parent().find('.help-block').html('');				
				}			
			}

		});
		


	},
	events: function(){
		//on page load show disabled
		if($("#showNewUser").attr('checked') == 'checked'){
			$(".userInputUsername").removeAttr('disabled');
			$(".userInputPassword").removeAttr('disabled');
			$(".userInputRetypePassword").removeAttr('disabled');			
		} else {
			$(".userInputUsername").attr('disabled','disabled');
			$(".userInputPassword").attr('disabled','disabled');
			$(".userInputRetypePassword").attr('disabled','disabled');			
		}
		
		$("#showNewUser").click(function(){
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$(".newUserDiv").fadeIn();
				$(".newUserDiv input").removeAttr('disabled');
				$("#new_user").val('Yes');
				$(".userInputUsername").removeAttr('disabled');
				$(".userInputPassword").removeAttr('disabled');
				$(".userInputRetypePassword").removeAttr('disabled');

			} else {
				$(".newUserDiv").fadeOut();
				$(".newUserDiv input").attr('disabled','disabled');
				$("#new_user").val('No');
				$(".userInputUsername").attr('disabled','disabled');
				$(".userInputPassword").attr('disabled','disabled');
				$(".userInputRetypePassword").attr('disabled','disabled');
			}
		})
	}
}
