$(document).ready(function() {

	$('#start').datepicker().on('changeDate', function(ev){
		//var start = $(this).val();
		//$('#end').val($(this).val());
		$("#start").datepicker('hide');

	});
	
	$('#end').datepicker().on('changeDate', function(ev){
		$("#end").datepicker('hide');
	});	
	
	$('#retrieve').click(function(){ 
		$('#retrieve').attr('disabled', 'disabled');
		$('#retrieve').html("Generating report...");
		bookings.getBookings(); 
	})
			
});

bookings =  {
	getBookings: function(){
		$.post(
				'/reports/request_bookings',
				{
					start: $('#start').val(),
					end: $('#end').val(),
					type: $('input[name="type"]:checked').val(),
					criteria: $('input[name="date-criteria"]:checked').val()
				},	function(results){
					$(".bookings").html((results));
					$('#retrieve').removeAttr('disabled');
					$('#retrieve').html("Run report");
				}
			);
	},
	
}
