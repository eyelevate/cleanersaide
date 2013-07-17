$(document).ready(function() {
	
	

	
	$('#start').datepicker().on('changeDate', function(ev){
		//var start = $(this).val();
		$('#end').val($(this).val());
		$("#start").datepicker('hide');

	});
	
	$('#end').datepicker().on('changeDate', function(ev){
		$("#end").datepicker('hide');
	});	
	
	$('#retrieve').click(function(){ vouchers.getReservations(); })
			
});

vouchers =  {
	getReservations: function(){
		$.post(
				'/reports/request_voucher_list',
				{
					start: $('#start').val(),
					end: $('#end').val()
				},	function(results){
					$(".voucher_list").html((results));
				}
			);
	},
	
}
