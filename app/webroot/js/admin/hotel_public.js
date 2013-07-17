$(document).ready(function(){
	//calendar
	hotel_schedule.regular();
	
	//general plugins for datepicker, number formatting, and phone number masking
	plugins.phoneNumber();
	plugins.numberformat();
	plugins.datepicker();
});
/*
 * Hotel Plugin Scripts
 */
plugins = {
	phoneNumber: function(){
		//phone formatting
		$("#phoneMask").mask("+9 (999) 999-9999");
		// $(".blockBeginDate").mask("99/99/9999");
		// $(".blockEndDate").mask("99/99/9999");	
	},
	numberformat: function(){
		//number formatting

		$('.taxrate').priceFormat({
			'prefix':'',
			limit:5
		});
		$(".netRate").priceFormat({
			'prefix':'',
		});
	},
	datepicker: function() {
		$("#chkin").datepicker().on('changeDate', function(ev){
  			$('.blockBeginDate').datepicker('hide');
		});
		$("#chkout").datepicker().on('changeDate', function(ev){
  			$('.blockBeginDate').datepicker('hide');
		});		
	},	
}
//* calendar
hotel_schedule = {
	regular: function() {
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		var id = $("#hotel_id").val();

		//sets calendar
		var calendar = $('#calendar_hotel').fullCalendar({
			
			header: {
				left: 'prev next',
				center: 'title,today',
				right: ''
			},
			buttonText: {
				prev: '<i class="icon-chevron-left cal_prev" />',
				next: '<i class="icon-chevron-right cal_next" />'
			},
			aspectRatio: 2,
			selectable: false,
			selectHelper: false,
			select: function(start, end, allDay) {
				var title = prompt('Event Title:');
				if (title) {
					calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start,
							end: end,
							allDay: allDay
						},
						true // make the event "stick"
					);
				}
				calendar.fullCalendar('unselect');
			
			},
			editable: false,
			theme: false,
	 		eventSources: [
	
	        // your event source
	        {
	            url: '/hotels/getJson',
	            type: 'POST',
	            data: {
	            	type:'Monthly_Schedule_Calendar',
	            	id:id
	            },
	            error: function() {	            	
	                alert('there was an error while fetching events!');
	            },
	            color: 'yellow',   // a non-ajax option
	            textColor: 'black' // a non-ajax option
	        }

    // any other sources...

			],				
			//events: '/schedules/getJson',
			eventColor: '#bcdeee'
		})
	},
	google: function() {
		var calendar = $('#calendar_google').fullCalendar({
			header: {
				left: 'prev next',
				center: 'title,today',
				right: 'month,agendaWeek,agendaDay'
			},
			buttonText: {
				prev: '<i class="icon-chevron-left cal_prev" />',
				next: '<i class="icon-chevron-right cal_next" />'
			},
			aspectRatio: 3,
			theme: false,
			events: {
				url:'http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic',
				title: 'Italian Holidays',
				color: '#bcdeee'
			},
			eventClick: function(event) {
				// opens events in a popup window
				window.open(event.url, 'gcalevent', 'width=700,height=600');
				return false;
			}
			
		})
	}
}