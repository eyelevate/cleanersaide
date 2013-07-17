$(document).ready(function(){
	checkout.events();
});

/**
 * Function
 */

checkout = {

	events: function(){

		$("#oldValuesCheckbox").click(function(){
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$('#PaymentContactAddress').val($('#UserContactAddress').val());
				$('#PaymentContactCity').val($('#UserContactCity').val());
				$('#PaymentContactState').val($('#UserContactState').val());
				$('#PaymentContactZip').val($('#UserContactZip').val());
			} else {
				$("#billingContactDiv input").each(function(){
					$(this).val('');
				});
			}
		});
		$("#removeTravelerSession").click(function(){
			if(confirm('Are you sure you want to clear the form?')){
				requests.remove_traveler_session();
			}	
		});

	}
}
requests = {
	remove_traveler_session: function(){
		var type = 'REMOVE_TRAVELERS';
		$.post('/reservations/request',
   		{
			type: type,
   		},function(){	
   			location.reload();
   		});	
	}
}