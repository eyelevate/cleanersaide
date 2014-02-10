$(document).ready(function(){
	hotels_attractions.events();
	hotels_attractions.initialize();

});
hotels_attractions = {
	initialize: function(){
		filter.filterResults();
	},
	events: function(){
		//run filter
		$(".byType").change(function(){
			var results = $(this).val();
			//alert (results);
			filter.byType(results);		
			filter.filterResults();
		});
		$(".byLocation").change(function(){
			var location = $(this).val();
			filter.byLocation(location);	
			filter.filterResults();	
		});
		$(".byRating").change(function(){
			filter.filterResults();
		});
		$(".orderBy").change(function(){
			filter.filterResults();
		});		
	}
}
filter = {
	byType: function(results){
		switch(results){
			
			case 'Hotel':
			//change the headers
			var featuredHeader = 'Hotels';
			var moreHeader = 'Hotels';			
			break;
			
			case 'Attraction':
			//change the headers
			var featuredHeader = 'Attractions';
			var moreHeader = 'Attractions';
			break;
			
			default:
			//change the headers
			var featuredHeader = 'Hotels + Attractions';
			var moreHeader = 'Hotels + Attractions';
			break;
		}
		$("#featuredHeader").html(featuredHeader);
		$("#moreHeader").html(moreHeader);
	}, 
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
		
		
		//next get list item type
		var type = $(".byType").val();		
		//next get star rating
		var starRating = parseFloat($(".byRating").find('option:selected').val());

		//starting price
		

		var citySelected = new Array();
		//then get the location
		$(".byLocation").each(function(en){
			
			var location = $(this).val();
			var checked = $(this).attr('checked');
			
			if(checked == 'checked'){
				if(location == 'All'){
					//show all 
					$('#featuredUl li').each(function(){
						var liType = $(this).attr('type');
						var liRating = parseFloat($(this).attr('rating'));
						if(isNaN(liRating)){
							liRating = 0;
						}
						switch(type){
							case 'both':
								if(liRating <= starRating){
									$(this).fadeIn();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating){
									$(this).fadeIn();
								}								
							break;
						}						

					});
					$('#nonfeaturedUl li').each(function(){
						var liType = $(this).attr('type');
						var noliRating = parseFloat($(this).attr('rating'));
						if(isNaN(noliRating)){
							noliRating = 0;
						}
						
						switch(type){
							case 'both':
								if(noliRating <= starRating){
									
									$(this).fadeIn();
								}								
							break;
							
							default:
								if(liType == type && noliRating <= starRating){
									$(this).fadeIn();
								}								
							break;
						}						

					});
					return false;
				} else { //location specific
					
					//show all
					$('#featuredUl li').each(function(){
						var liType = $(this).attr('type');
						var liLocation = $(this).attr('location');
						var liRating = parseFloat($(this).attr('rating'));
						if(isNaN(liRating)){
							liRating = 0;
						}
						switch(type){
							case 'both':
								if(liRating <= starRating && liLocation == location){
									$(this).fadeIn();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating && liLocation == location){
									$(this).fadeIn();
								}								
							break;
						}						

					});
					$('#nonfeaturedUl li').each(function(){
						var liType = $(this).attr('type');
						var liLocation = $(this).attr('location');
						var liRating = parseFloat($(this).attr('rating'));
						if(isNaN(liRating)){
							liRating = 0;
						}
						
						switch(type){
							case 'both':
								if(liRating <= starRating && liLocation == location){
									$(this).fadeIn();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating && liLocation == location){
									$(this).fadeIn();
								}								
							break;
						}						

					});
				}
			}
		});
		filter.orderBy();
	},
	// order by
	orderBy: function(){

		var ordered = $(".orderBy").val();
		switch(ordered){
			case '1': //name A-Z
				$("ul#featuredUl > li").tsort({attr:'order'});
				$("ul#nonfeaturedUl > li").tsort({attr:'order'});
			break;
			
			case '2': //name Z-A
				$("ul#featuredUl > li").tsort({order:'desc',attr:'order'});
				$("ul#nonfeaturedUl > li").tsort({order:'desc',attr:'order'});
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
/**
 * Functions
 * Methods that do something
 */


/**
 * Variable Funtcions
 * Methods that return results
 */
