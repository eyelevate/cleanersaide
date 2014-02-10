$(document).ready(function(){
	search.searchScript();
});


/**
 * Functions
 */

search = {
	searchScript: function(){
		$("#searchButton").click(function(){
			//var action = $(".searchAction").val();
			var data = $(".search_query").val();
			//$("#searchForm").attr('action',action);
	   		$.post('/reservations/reservation_search',
	   		{
	   			type:'SEARCH',
	   			data:data
	   		},function(results){
				$("#reservationTbody").html(results);
	   		});			
			
		});
		
		$(".search_query").keyup(function(){
			var data = $(this).val();

		});
	}
}
