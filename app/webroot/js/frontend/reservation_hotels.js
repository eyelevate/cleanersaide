$(document).ready(function(){
	reservation_hotels.datePicker();
	reservation_hotels.events();
	
	$(".pointer").click(function(){
		$(this).parent().find('input').focus().blur();
	});	
});

/**
 * Functions
 */
reservation_hotels = {
	datePicker: function(){
		cutoff = parseInt($("#start").attr('cutoff')) / 86400;
		//datepicker scripts runs off of jquery-ui
		
		var __picker = $.fn.datepicker;
		
		$.fn.datepicker = function(options) {
		    __picker.apply(this, [options]);
		    var $self = this;
		    
		    if (options && options.trigger) {
		        $(options.trigger).bind("click", function () {
		            $self.datepicker("show");
		        });
		    }
		}
		
		// $("#start").datepicker({ minDate: cutoff, trigger:'#buttonStart', onSelect: function(dateStr) {
			// var newDate = new Date(dateStr);
			// var newDate = newDate.getTime() / 1000;
           // $("#end").datepicker('setDate',newDate);
      	// }});	

		$('#end').datepicker({minDate:cutoff});
		$("#start").datepicker({
			numberOfMonths: 1, 
			minDate: cutoff,
	 		onSelect: function(dateStr) {
				changeDatePicker(dateStr);
			}
		});		
		
	
	},
	events: function(){
		$("#searchButton").click(function(){
			var hotel_id =$("#hotel_id").val();
			var start = $("#start").val();
			var end = $("#end").val();
			var arrival = Math.round((new Date(start)).getTime() / 1000);
			var departure = Math.round((new Date(end)).getTime() / 1000);
			var adults = $("#adults").val();
			var children = $("#children").val();
			var rooms = $("#rooms").find('option:selected').val();
			
			if(children == '' || children == '0'){
				children = 'zero';
			}
			
			if(adults == '' || adults == '0'){
				$("#adults").parent().addClass('error');
				$("#adults").parent().find('.help-block').html('Cannot be zero value');
			} else {
				$("#adults").parent().removeClass('error');
				$("#adults").parent().find('.help-block').html('');			
					
			}
			if(start == ''){
				$("#start").parent().parent().addClass('error');
				$("#start").parent().parent().find('.help-block').html('No date selected');
			} else {
				$("#start").parent().parent().removeClass('error');
				$("#start").parent().parent().find('.help-block').html('');				
			}
			if(end == ''){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('No date selected');				
			}

			if(end != '' && parseInt(arrival) == parseInt(departure)){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('cannot be the same as arrival');					
			} 
			if(end != '' && parseInt(arrival) > parseInt(departure)){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('cannot be before arrival');					
			} 
			if(start != '' & end != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure)){
				$("#end").parent().parent().removeClass('error');
				$("#end").parent().parent().find('.help-block').html('');					
			}
			if(parseInt(rooms) > parseInt(adults)){
				$("#rooms").parent().addClass('error');
				$("#adults").parent().addClass('error');
				$("#adults").parent().find('.help-block').html('Not enough adults compared to rooms');
			} else {
				$("#rooms").parent().removeClass('error');
				$("#adults").parent().removeClass('error');
				$("#adults").find('.help-block').html('');				
			}
			
			//if all of the validation approves get hotel rooms
			if(start != '' & end != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure) && adults != '' && parseInt(adults) > 0 && parseInt(rooms) <= parseInt(adults)){
				//function to get hotel rooms
				getHotelRooms(hotel_id, arrival, departure,rooms, adults, children);
			}
		});

	},
	//adds scripts to page after ajax call
	addScripts: function(){
		$(".bookRoom").click(function(e){
			var hotel_id =$("#hotel_id").val();
			var start = $("#start").val();
			var end = $("#end").val();
			var room_id = $(this).attr('id').replace('bookRoom-','');
			var rooms = $('#rooms').find('option:selected').val();
			var arrival = Math.round((new Date(start)).getTime() / 1000);
			var departure = Math.round((new Date(end)).getTime() / 1000);
			var adults = $("#adults").val();
			var children = $("#children").val();
			var total = $(".hotel_total").val();
			if(children == ''){
				children = 0;
			}
			var base = $(this).attr("base");
			var max = $(this).attr('max');
			var total_occupants = parseInt(adults) + parseInt(children);
			var max_error = parseInt(total_occupants) / parseInt(max);
			var accepted_rooms = Math.ceil(total_occupants / parseInt(max));
			
			
			if(children == '' || children == '0'){
				children = 'zero';
			}
			
			if(adults == '' || adults == '0'){
				$("#adults").parent().addClass('error');
				$("#adults").parent().find('.help-block').html('Cannot be zero value');
			} else {
				$("#adults").parent().removeClass('error');
				$("#adults").parent().find('.help-block').html('');			
					
			}
			if(start == ''){
				$("#start").parent().parent().addClass('error');
				$("#start").parent().parent().find('.help-block').html('No date selected');
			} else {
				$("#start").parent().parent().removeClass('error');
				$("#start").parent().parent().find('.help-block').html('');				
			}
			if(end == ''){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('No date selected');				
			}

			if(end != '' && parseInt(arrival) == parseInt(departure)){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('cannot be the same as arrival');					
			} 
			if(end != '' && parseInt(arrival) > parseInt(departure)){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('cannot be before arrival');					
			} 
			if(start != '' & end != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure)){
				$("#end").parent().parent().removeClass('error');
				$("#end").parent().parent().find('.help-block').html('');					
			}
			if(parseInt(rooms) > parseInt(adults)){
				$("#rooms").parent().addClass('error');
				$("#adults").parent().addClass('error');
				$("#adults").parent().find('.help-block').html('Not enough adults compared to rooms');
			} else {
				$("#rooms").parent().removeClass('error');
				$("#adults").parent().removeClass('error');
				$("#adults").find('.help-block').html('');				
			}	
			if(max_error > parseInt(rooms)){
				alert('Warning! You have too many occupants per room. The max occupancy per room is set at '+max+'. In order to book this room you must select at least '+accepted_rooms+' rooms. Please try again.');
				$("#rooms").parent().addClass('error');
			} else {
				$("#rooms").parent().removeClass('error');
			}		
			//if all of the validation approves get hotel rooms
			if(start != '' & end != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure) && adults != '' && parseInt(adults) > 0 && parseInt(rooms) <= parseInt(adults) && max_error <= parseInt(rooms)){
				//function to get hotel rooms
				bookHotelRoom(hotel_id,room_id, arrival, departure, rooms, adults, children, total);
			}			
			
			
			e.preventDefault();
		});
	}
}

//gets hotel rooms and sends them to the ul in the page
var getHotelRooms = function(hotel_id, start, end,rooms, adults, children){

	//change time and check limits
	$.post(
		'/hotels/request',
		{
			type:'GET_HOTEL_ROOMS',
			hotel_id: hotel_id,
			start: start,
			end: end,
			rooms: rooms,
			adults: adults,
			children: children
		},	function(results){
			$("#resultsDiv").removeClass('hide');
			$("#roomAvailableUl").html($(results).fadeIn());
			reservation_hotels.addScripts();

		}
	);		
}

var bookHotelRoom = function(hotel_id,room_id, start, end,rooms, adults, children, total){
	//change time and check limits
	$.post(
		'/hotels/request',
		{
			type:'BOOK_HOTEL_ROOM',
			hotel_id: hotel_id,
			room_id: room_id,
			start: start,
			end: end,
			rooms: rooms,
			adults: adults,
			children: children,
			total: total,
		},	function(results){
			window.location = "/reservations/thank-you";
			
		}
	);	
}
var changeDatePicker = function(date){
	date = getDateConvert(date);
	$("#end").remove();
	$("#checkoutDiv").prepend('<input id="end" class="span12 datepicker" type="text" value="'+date+'"/>');
	$("#end").datepicker({minDate:date});
}
var getDateConvert = function(date){
	var days = parseInt(days);
	var millis = Date.parse(date);
	var newDate = new Date();
	newDate.setTime(millis  + 1*24*60*60*1000);
	var newDateStr = "" + (newDate.getMonth()+1) + "/" + newDate.getDate() + "/" + newDate.getFullYear();

	return newDateStr;
}

