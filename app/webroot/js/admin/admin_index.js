$(document).ready(function(){
	admin.datepicker();
	admin.events();
});

admin = {
	datepicker: function(){
		$(".datepicker1").datepicker().on('changeDate', function(ev){
  			$(this).datepicker('hide');

		});		
	},
	events: function(){
		$("#start_date_calendar, #end_date_calendar").click(function(){
			$(".datepicker1").datepicker('hide');
			$(this).parents('.input-append:first').find('input').focus();
		});
	}
};
