$(document).ready(function() {

	$('#start').datepicker().on('changeDate', function(ev){
		//var start = $(this).val();
		//$('#end').val($(this).val());
		$("#start").datepicker('hide');

	});
	
	$('#end').datepicker().on('changeDate', function(ev){
		$("#end").datepicker('hide');
	});	
	
			
});