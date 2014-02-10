$(document).ready(function(){
	packages.datepicker();
	packages.events();
	packages.initialize()
});

packages = {
	datepicker: function(){
		//packages/home search by date
		$("#searchDateInput").datepicker({
			minDate: 0,
			numberOfMonths: 2,
			onSelect: function(){
				var date = $("#searchDateInput").val();
				var location = $("#searchDateInput").attr('location');
				var second_location = '';
				var third_location = '';
				if(location == ''){
					location = 'all';
				}
				if(date == ''){
					$(this).parent().parent().addClass('error');
					$(this).parent().parent().find('.help-block').html('Must select a valid date. Please try again.');
				} else {
					$(this).parent().parent().removeClass('error');
					$(this).parent().parent().find('.help-block').html('');			
					
					requests.getPackages(date, location);
				}			
			}
		}).focus(function(){
			$(this).blur();
		});			
	}, 
	initialize: function(){
		
		filter.filterResults();
	},
	events: function(){
		$("#searchDate").click(function(){
			var date = $("#searchDateInput").val();
			var location = $("#searchDateInput").attr('location');
			if(location == ''){
				location = 'all';
			}
			if(date == ''){
				$(this).parent().parent().addClass('error');
				$(this).parent().parent().find('.help-block').html('Must select a valid date. Please try again.');
			} else {
				$(this).parent().parent().removeClass('error');
				$(this).parent().parent().find('.help-block').html('');			
				
				requests.getPackages(date, location);
			}			
		});
		$("#searchCalendarSpan").click(function(){
			$(this).parent().find('input').focus();
		});
		//filter results scripts
	
		$(".byLocation").change(function(){
			var location = $(this).val();
			filter.byLocation(location);	
			filter.filterResults();	
		});
		$(".byRating").change(function(){
			filter.filterResults();
		});
		// $(".orderBy").change(function(){
			// filter.filterResults();
		// });

	}, 


}
addScripts = {
	createPackageUrl: function(element){
		element.click(function(){
			var package_id = $(this).attr('package_id');
			var url = $(this).attr('url');
			
	
			$.post('/packages/request_package_session_url',
			  {
				package_id:package_id
			  },function(results){
			  	//alert('successful');
			  	//change url to href and submit

			  	window.location.href = url;
			  	
			  }
			);

		});
	},
	filters: function(element){
		element.change(function(){
			filter.filterResults();

		});			
	}
	
}
filter = {

	byLocation: function(location){
		switch(location){
			case 'All':
				$(".byLocation:not(value='All)").removeAttr('checked');
				$(".byLocation[value='All']").attr('checked','checked');
			break;
			
			default:
				$(".byLocation[value='All']").removeAttr('checked');
			break;
		}

	}, 
	filterResults: function(){
		//first hide all of the list items on both featured and non featured
		$("#featuredUl li").hide();
		$("#nonfeaturedUl li").hide();

		var citySelected = new Array();
		//then get the location
		$(".byLocation").each(function(en){
			
			var location = $(this).val();
			var checked = $(this).attr('checked');
			
			if(checked == 'checked'){
					
					
					//show all
					$('#featuredUl li').each(function(){
						var liLocation = $(this).attr('location');
						if( liLocation == location){
							$(this).fadeIn();
						}	
											
					});
					$('#nonfeaturedUl li').each(function(){
						var liLocation = $(this).attr('location');
						if(liLocation == location){
							$(this).fadeIn();
						}							
					});
					
					//count the elements shown if more than 0 then hide the error message
					var count_featured = $("#featuredUl li:visible").size();
					
					if(count_featured > 0){
						$("#featuredP").hide();
					} else {
						$("#featuredP").show();
					}
					var count_nonfeatured = $("#nonfeaturedUl li:visible").size();
					if(count_nonfeatured > 0){
						$("#nonfeaturedP").hide();
					} else {
						$("#nonfeaturedP").show();
					}					

				
			}
		});
		filter.orderBy();
	},
	// order by
	orderBy: function(){
		ordered = $('.orderBy').find('option:selected').val();
		switch(ordered){
			case '1': //name A-Z
				$("ul#featuredUl > li").tsort({attr:'name'});
				$("ul#nonfeaturedUl > li").tsort({attr:'name'});
			break;
			
			case '2': //name Z-A
				$("ul#featuredUl > li").tsort({order:'desc',attr:'name'});
				$("ul#nonfeaturedUl > li").tsort({order:'desc',attr:'name'});
			break;
			
			case '3': //rating 1-5 && sort by name A-Z
				$("ul#featuredUl > li").tsort({attr:'order',attr:'rating'});
				$("ul#nonfeaturedUl > li").tsort({attr:'order',attr:'rating'});
			break;
				
			case '4': //rating 5-1
				$("ul#featuredUl > li").tsort({order:'desc',attr:'order',attr:'rating'});
				$("ul#nonfeaturedUl > li").tsort({order:'desc',attr:'order',attr:'rating'});
			break;
			
			case '5': //starting price lowest to highest
				$("ul#featuredUl > li").tsort({attr:'order',attr:'starting'});
				$("ul#nonfeaturedUl > li").tsort({attr:'order',attr:'starting'});
			break;
			
			default: //starting price highest to lowest

				$("ul#featuredUl > li").tsort({order:'desc',attr:'order',attr:'starting'});
				$("ul#nonfeaturedUl > li").tsort({order:'desc',attr:'order',attr:'starting'});
			break;
		}
	}
}
requests = {
	getPackages: function(date, location){
		//change time and check limits
		$.post(
			'/packages/request_packages',
			{
				date: date,
				location: location
				
	
			},	function(results){
				$("#resultsDiv").show();
				$("#searchResultsDiv").html($(results).fadeIn());
				$('#searchResultsDiv').find('.packageDetailsLink').each(function(){

					var element_order = $(".orderBy");

					addScripts.filters(element_order);
					filter.filterResults();
				});
			}
		);			
	}
}
