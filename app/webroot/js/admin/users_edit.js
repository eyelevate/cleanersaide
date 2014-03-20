$(document).ready(function(){
	users.events();
});

users = {
	events: function(){
		$(".profileCheck").click(function(){
			var status = $(this).val();
			switch(status){
				case '0':
					$("#profileDiv").addClass('hide');
				break;
				
				default:
					$("#profileDiv").removeClass('hide');
				break;
			}
		});
		
		$("#set_delivery_customer").change(function(){
			var selected = $(this).find('option:selected').val();
			
			switch(selected){
				case '0':
					$("#paymentDiv").addClass('hide');
					
				break;
				
				default:
					$("#paymentDiv").removeClass('hide');
				break;
			}
		});
	}
};
