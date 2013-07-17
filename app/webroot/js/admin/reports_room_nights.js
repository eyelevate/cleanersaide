$(document).ready(function() {

	$('#start').datepicker().on('changeDate', function(ev){
		//var start = $(this).val();
		//$('#end').val($(this).val());
		$("#start").datepicker('hide');

	});
	
	$('#end').datepicker().on('changeDate', function(ev){
		$("#end").datepicker('hide');
	});	
	
	$('#retrieve').click(function(){ roomnights.getRooms(); })
			
});

roomnights =  {
	getRooms: function(){
		$.post(
				'/reports/request_room_nights',
				{
					start: $('#start').val(),
					end: $('#end').val(),
					hotel: $('#hotels').val()
				},	function(results){
					$(".room_nights").html((results));
				}
			);
	},
	
}
