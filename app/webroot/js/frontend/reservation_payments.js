$(document).ready(function(){
	payments.validation();
	payments.events();
});

/**
 * Function
 */

payments = {
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
		
		var cardFullName = $("#PaymentCardFullName").val();
		$("#PaymentCardFullName").blur(function(){
			var thisValue = $(this).val();
			if($(this).parent().hasClass('error')){
				if(cardFullName == thisValue){
					$(this).parent().addClass('error');
					$(this).parent().find('.help-block').html('This field cannot be the same value as previous');				
				} else {
					$(this).parent().removeClass('error');
					$(this).parent().find('.help-block').html('');				
				}
			}

		});
		
		var cardCVV = $("#PaymentCardCvv").val();
		$("#PaymentCardCvv").blur(function(){
			var thisValue = $(this).val();
			if($(this).parent().hasClass('error')){
				if(cardCVV == thisValue){
					$(this).parent().addClass('error');
					$(this).parent().find('.help-block').html('This field cannot be the same value as previous');				
				} else {
					$(this).parent().removeClass('error');
					$(this).parent().find('.help-block').html('');				
				}
			}

		});

		var contactAddress = $("#PaymentContactAddress").val();
		$("#PaymentContactAddress").blur(function(){
			var thisValue = $(this).val();
			if($(this).parent().parent().hasClass('error')){
				if(contactAddress == thisValue){
					$(this).parent().parent().addClass('error');
					$(this).parent().parent().find('.help-block').html('This field cannot be the same value as previous');				
				} else {
					$(this).parent().parent().removeClass('error');
					$(this).parent().parent().find('.help-block').html('');				
				}
			}

		});
		var contactCity = $("#PaymentContactCity").val();
		$("#PaymentContactCity").blur(function(){
			var thisValue = $(this).val();
			if($(this).parent().parent().hasClass('error')){
				if(contactCity == thisValue){
					$(this).parent().parent().addClass('error');
					$(this).parent().parent().find('.help-block').html('This field cannot be the same value as previous');				
				} else {
					$(this).parent().parent().removeClass('error');
					$(this).parent().parent().find('.help-block').html('');				
				}
			}

		});
		var contactState = $("#PaymentContactState").val();
		$("#PaymentContactState").blur(function(){
			var thisValue = $(this).val();
			if($(this).parent().parent().hasClass('error')){
				if(contactState == thisValue){
					$(this).parent().parent().addClass('error');
					$(this).parent().parent().find('.help-block').html('This field cannot be the same value as previous');				
				} else {
					$(this).parent().parent().removeClass('error');
					$(this).parent().parent().find('.help-block').html('');				
				}
			}

		});
		var contactZip = $("#PaymentContactZip").val();
		$("#PaymentContactZip").blur(function(){
			var thisValue = $(this).val();
			if($(this).parent().parent().hasClass('error')){
				if(contactZip == thisValue){
					$(this).parent().parent().addClass('error');
					$(this).parent().parent().find('.help-block').html('This field cannot be the same value as previous');				
				} else {
					$(this).parent().parent().removeClass('error');
					$(this).parent().parent().find('.help-block').html('');				
				}
			}

		});
		
		//terms hide review button or show based on checked status
		$("#terms").click(function(){
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$(".submitForm").removeAttr('disabled');
			} else {
				$(".submitForm").attr('disabled','disabled');
			}
		});

	},
	events: function(){
		//Removes any flashes on screen after 5 seconds
		$("#oldValuesCheckbox").click(function(){
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$("#billingContactDiv input").each(function(){
					var oldValue = $(this).attr('old');
					$(this).val(oldValue);
				});
			} else {
				$("#billingContactDiv input").each(function(){
					$(this).val('');
				});
			}
		});
	}
}
