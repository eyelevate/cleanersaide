$(document).ready(function(){
	schedule.datePicker();
	schedule.events();
});

schedule = {
	datePicker: function(){
		$("#deliveryDate").datepicker().on('changeDate', function(ev){
  			$('#deliveryDate').datepicker('hide');

		});
	},
	events: function(){
		$("#submitDeliveryForm").click(function(){
			$(this).parents('form:first').submit();
		});
	}
};
