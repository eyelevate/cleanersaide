$(document).ready(function(){
	//calendar
	var activeInventory = $("#scheduleMainUl").find('.active .switchCalendar').attr('id').replace('switchCalendar-','');
	schedule.regular(activeInventory);
	
	$("#scheduleMainUl a").click(function(){
		var activeInventory = $(this).attr('id').replace('switchCalendar-','');	
		$("#calendar").remove();
		$("#displayCalendar").html('<div id="calendar"></div>')
		schedule.regular(activeInventory);
	});
	
	
	schedule.datePicker();
	//submits the initial attributes data to create a form
	$("#submitScheduleAttributes").click(function(){	
		
		
		//create variables
		var start_date = $("#schedule_start").val();
		var end_date = $("#schedule_end").val();
		var trips = $("#tripsSelected option:selected").val();
		//validate dates
		if(start_date == ''){
			$("#startDateDiv").attr('class','control-group error');
			$("#startDateDiv .help-block").html('Start date cannot be left empty. Please select a date.');
		} else {
			$("#startDateDiv").attr('class','control-group');
			$("#startDateDiv .help-block").html('');			
		}
		if(end_date ==''){
			$("#endDateDiv").attr('class','control-group error');
			$("#endDateDiv .help-block").html('Start date cannot be left empty. Please select a date.');			
		} else {
			$("#endDateDiv").attr('class','control-group');
			$("#endDateDiv .help-block").html('');			
		}
		if(trips == 'none'){
			$("#tripsDiv").attr('class','control-group error');
			$("#tripsDiv .help-block").html('Please select a trip amount.');
		} 
		if(trips == 'NIS'){
			//hide the time and rates form and show the NIS form only
			$("#scheduleFormDiv").hide();
			$("#nisDiv").show();
			//insert the start and end date into the form
			$("#nisStartDate").val(start_date);
			$("#nisEndDate").val(end_date);
			//close this accordion group
			$("#scheduleAttributes .accordion-heading a").click();	
			//open form accordion group
			$("#scheduleForm").show();
			$("#scheduleForm .accordion-heading a").click();			
			
		} 
		if(trips != 'none' && trips !='NIS') {
			$("#tripsDiv").attr('class','control-group');
			$("#tripsDiv .help-block").html('');			
		}
		
		//if validates then get data and send to request page to get form
		if(start_date != '' && end_date != '' && (trips != 'none' && trips != 'NIS')) {
			$("#scheduleFormDiv").show();
			$("#nisDiv").hide();			
			$.post(
				'/schedules/request',
				{
					type:'Create_Form',
					start_date:start_date,
					end_date:end_date,
					trips:trips
				},	function(result){

					//check to see if there are prexisting dates		
					if(result =='prexists'){
						$("#errorMessageAlert").show();
						$("#errorMessageAlert small").html('Warning: There are prexisting trips on this date. Any time matching these set dates will not be written.')
						

						

						
					} else { // success send to get the proper form
						//checks to see if the end date is set earlier than the start date
						if(result =='dates_error'){
							//set error on the end date
							$("#endDateDiv").attr('class','control-group error');
							$("#endDateDiv .help-block").html('End date cannot be earlier than start date.');		
								
						} else { //remove errors and parse html script
							$("#endDateDiv").attr('class','control-group');
							$("#endDateDiv .help-block").html('');							
							//get form and send it to #createdFormDiv
							$("#scheduleFormTbody").html(result);
							//close this accordion group
							$("#scheduleAttributes .accordion-heading a").click();	
							//open form accordion group
							$("#scheduleForm").show();
							$("#scheduleForm .accordion-heading a").click();
							
							//send the info to the form
							$("#previewScheduleForm").html(
								'<input type="hidden" id="start_date" value="'+start_date+'" name="start_date"/>'+
								'<input type="hidden" id="start_date" value="'+end_date+'" name="end_date"/>'+
								'<input type="hidden" id="trips" value="'+trips+'" name="trips"/>'
							);							
						}
						
					}

				} 	
			);						
		
		}

		
	});
	
	//save nis form
	$("#saveNIS").click(function(){
		if($("#nisReasonInput").val()==''){
			$("#nisFormInputDiv").attr('class','control-group error');
			$("#nisFormInputDiv .help-block").html('You must specify a not in service reason.');				
		} else{
			//send the form
			$("#formNIS").submit();			
		}
	});
	
	//goes back to the previous attributes page to change data
	$("#attributesBackButton").click(function(){
		//close this accordion group
		$("#scheduleForm .accordion-heading a").click();
		//open form accordion group
		$("#scheduleAttributes .accordion-heading a").click();				
	});

	//update the ferry rates on the ferry add page
	$(".ferry_oneWay").bind('blur',function(){
		var oneWay = $(this).val();
		var oneWay_id = $(this).parent().parent().parent().attr('id').replace('setOneWayTd-','');
        var pattern = /^\d+(?:\.\d{0,2})$/ ;
        var intPattern = /^\d+$/ ;
        var oldValue = $(this).attr('old');
		if(intPattern.test(oneWay)){
			var oneWay = parseInt(oneWay).toFixed(2);
		}

        //check if value is currency 
        if (pattern.test(oneWay) && oneWay !='0.00') {
        	var surchargeValue = $("#setSurchargeTd-"+oneWay_id+" div div input").val();
        	if(surchargeValue == ''){
        		surchargeValue = '0.00';
        	}
        	var newValue = parseFloat(oneWay) + parseFloat(surchargeValue);
        	var newValue = newValue.toFixed(2);
		 	//remove error from list and add values
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).parent().siblings('.help-block').html('');
			//change to fixed value 2
			var oneWay = parseFloat(oneWay).toFixed(2);
			$(this).val(oneWay);

			
			$("#setSurchargeTotalTd-"+oneWay_id+" div div input").val(newValue);

        } else if(oneWay == '' || oneWay == '0.00') {
 			//create error
			$(this).parent().parent().parent().attr('class','control-group warning');
			$(this).parent().siblings('.help-block').html('Zero Value');   
			$(this).val('0.00');           
        } else {
			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('This must be a valid currency value.');        	
        }
        //check to see if the value has changed if so then create the form input
        if(oldValue != oneWay){
        	$(this).attr('changed','Yes');
        } else {
        	$(this).attr('changed','No');
        }
        


	});
	//update ferry surcharge and adds total surchagred value
	$(".ferry_surcharge").bind('blur',function(){
		//set the variables
		var surcharge = $(this).val();
		var surcharge_id = $(this).parent().parent().parent().attr('id').replace('setSurchargeTd-','');
        var pattern = /^\d+(?:\.\d{0,2})$/ ;
        var intPattern = /^\d+$/ ;
        var oldValue = $(this).attr('old');
		if(intPattern.test(surcharge)){
			var surcharge = parseInt(surcharge).toFixed(2);
		}
		var oneWayValue = $("#setOneWayTd-"+surcharge_id+" div div input").val();
    	if(oneWayValue == ''){
    		oneWayValue = '0.00';
    	}
    	
    	//if the value is a currency
        if (pattern.test(surcharge)) {
        	if(surcharge ==''){
        		surcharge = '0.00';
        	}
        	var newValue = parseFloat(surcharge) + parseFloat(oneWayValue);
        	var newValue = parseFloat(newValue).toFixed(2);
		 	//remove error from list and add values
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).parent().siblings('.help-block').html('');
			var surcharge = parseFloat(surcharge).toFixed(2);
			$(this).val(surcharge);
			//set the last surcharge + one way rate
			$("#setSurchargeTotalTd-"+surcharge_id+" div div input").val(newValue);
		//if the value is empty
        } else if(surcharge ==''){
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).val('0.00');      
			$("#setSurchargeTotalTd-"+surcharge_id+" div div input").val(oneWayValue); 	
        } else {
			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('This must be a valid currency value.');        	
        }
        //check to see if the value has changed if so then create the form input
        if(oldValue != surcharge){
        	$(this).attr('changed','Yes');
        } else {
        	$(this).attr('changed','No');
        }
				
	});

	$('.ferry_reservableUnits').bind('blur',function(){
		var reservable = $(this).val();
		var reservable_id = $(this).parent().parent().parent().attr('id').replace('ferryReservableUnitsDiv-','');
        var pattern = /^\d+$/ ;
        var oldValue = $(this).attr('old');

        //check if value is currency 
        if (pattern.test(reservable) && reservable != '0') {
        	var total = $("#ferryTotalUnitsDiv-"+reservable_id+" div div input").val();
        	if(total == ''){
        		total = '0.00';
        	}
        	var newValue = (parseFloat(reservable)/ parseFloat(total))*100;
        	var newValue = newValue.toFixed(2);
		 	//remove error from list and add values
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).parent().siblings('.help-block').html('');
		
			$("#ferryCapacityDiv-"+reservable_id+" div div input").val(newValue);

        } else if(reservable == '' || reservable == '0') {
 			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('Zero Value');   
			$(this).val('0');           
        } else {
			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('This is not a valid number.');        	
        }
        //check to see if the value has changed if so then create the form input
        if(oldValue != reservable){
        	$(this).attr('changed','Yes');
        } else {
        	$(this).attr('changed','No');
        }
		
	});
	
	$(".ferry_totalUnits").blur('blur',function(){
		var total = $(this).val();
		var total_id = $(this).parent().parent().parent().attr('id').replace('ferryTotalUnitsDiv-','');
        var pattern = /^\d+$/ ;
        var oldValue = $(this).attr('old');

        if (pattern.test(total) && total != '0') {
			var reservable = $("#ferryReservableUnitsDiv-"+total_id+" div div input").val();
        	if(reservable == ''){
        		reservable = '0';
        	}
        	var newValue = (parseFloat(reservable) / parseFloat(total))*100;
        	var newValue = parseFloat(newValue).toFixed(2);
		 	//remove error from list and add values
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).parent().siblings('.help-block').html('');

			//set the last surcharge + one way rate
			$("#ferryCapacityDiv-"+total_id+" div div input").val(newValue);

        } else if(total =='' || total == '0'){
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('Zero Value');   
			$(this).val('0');       	
        } else {
			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('This is not a valid number.');        	
        }	
        //check to see if the value has changed if so then create the form input
        if(oldValue != total){
        	$(this).attr('changed','Yes');
        } else {
        	$(this).attr('changed','No');
        }
	
	});


	//creates a preview of the form
	$("#previewSchedule").click(function(){
		//create variables
		var value = $("#scheduleFormTbody .scheduleFormTableTr").attr('id');
		var tripCount = $("#scheduleFormTbody .scheduleFormTableTr").length;
		var count = $("#scheduleFormTbody .scheduleFormTableTr").length;
		var countChanged = $("input[changed='Yes']").length;
		
		$(".pickTimeInput").each(function(){
			var checkTimeEmpty = $(this).val();
			if(checkTimeEmpty == ''){
				$(this).parent().attr('class','control-group error');
				$(this).parent().find('.help-block').html('This field cannot be left empty');
			} else {
				$(this).parent().attr('class','control-group');
				$(this).parent().find('.help-block').html('');				
			}
		});
		$(".pickTimeInput2").each(function(){
			var checkTimeEmpty = $(this).val();
			if(checkTimeEmpty == ''){
				$(this).parent().attr('class','control-group error');
				$(this).parent().find('.help-block').html('This field cannot be left empty');
			} else {
				$(this).parent().attr('class','control-group');
				$(this).parent().find('.help-block').html('');				
			}
		});		
		
		var errorCount = $(".error").length;
		
		//count the error length if greater than 0 then go back to top of page and fix errors
		if(errorCount == 0){
			
			//check to see if any of the rates values has been changed if so then create the variable 
			if(parseInt(countChanged) >0){
				var rates_id = '2';
			} else {
				var rates_id = '1';
			}
			$("#previewScheduleForm").append(
				'<input type="hidden" id="rates_id" value="'+rates_id+'" name="rates_id"/>'
			);		
			$("#scheduleFormTbody .scheduleFormTableTr").each(function(idx){
				var trip = $(this).attr('id').replace('scheduleFormTableTr-','');
				var startDate = $(this).children('.scheduleStart').html();	
				var endDate = $(this).children('.scheduleEnd').html();
				var startValue = $(this).children().children('.pickTimeInput').val();
				if (startValue ==''){
					startValue = 'NONE';
				}
				var endValue = $(this).children().children('.pickTimeInput2').val();
				if (endValue == ''){
					endValue = 'NONE';
				}
				var startFullDate = $(this).children('.scheduleStart').attr('date');
				var endFullDate = $(this).children('.scheduleEnd').attr('date');
				
				//create preview
				//var rates_id = $("");
				$("#previewScheduleForm").append(
					'<input type="hidden" id="start_value" value="'+startValue+'" name="depart_1_'+trip+'"/>'+
					'<input type="hidden" id="end_value" value="'+endValue+'" name="depart_2_'+trip+'">'
				);
	
			});
			$(".setRate").each(function(){
				var item_id = $(this).attr('id').replace('setRate-','');
				var inventory_id = $(this).attr('name');
				var one_way = $(this).children().children().children().find('.ferry_oneWay').val();
				var surcharged = $(this).children().children().children().find('.ferry_surcharge').val();
				var total = $(this).children().children().children().find('.ferry_surchargeTotal').val();
				$("#previewScheduleForm").append(
					'<input type="hidden" id="one_way" value="'+one_way+'" name="rates_oneWay_'+inventory_id+'_'+item_id+'"/>'+
					'<input type="hidden" id="surcharged" value="'+surcharged+'" name="rates_surcharge_'+inventory_id+'_'+item_id+'">'+
					'<input type="hidden" id="surcharedTotal" value="'+total+'" name="rates_total_'+inventory_id+'_'+item_id+'">'
				);				
			});
			var countLimits = $(".ferry_limits").length;
			$(".ferry_limits").each(function(idx){
				var inventory = $(this).children('legend').attr('name');
				var inventory_id = $(this).attr('name');
				var reserved = $(this).children().children().children().children().find('.ferry_reservableUnits').val();
				var total = $(this).children().children().children().children().find('.ferry_totalUnits').val();
				var capacity = $(this).children().children().children().children().find('.ferry_capacity').val();
				$("#previewScheduleForm").append(
					'<input type="hidden" id="start_value" value="'+reserved+'" name="limit_'+inventory+'_reserved"/>'+
					'<input type="hidden" id="end_value" value="'+total+'" name="limit_'+inventory+'_total">'
				);			
				if(idx == countLimits-1){
					$("#previewScheduleForm").submit();
				}
			});
			
			$("#errorMessageAlert").attr('class','alert hide');
			$("#errorMessageAlert small").html('');
			
		} else {
			$("#toTopHover").click();
			$("#errorMessageAlert").attr('class','alert alert-error');
			$("#errorMessageAlert small").html('Error: you have errors on your form please fix');
		}
	});
	
		
    $('#cancelFerrySchedule').click(function(){ 
        if(document.referrer.indexOf(window.location.hostname) != -1){ 
            parent.history.back(); 
            return false; 
        } 
    });	

/**
 * Index Page
 */

	$("#editDateRangeButton").click(function(){
		var start = $("#schedule_start").val();
		var end = $("#schedule_end").val();
		if(start ==''){
			$("#startDateDiv").attr('class','control-group error');
			$("#startDateDiv .help-block").html('Start date cannot be left empty. Please select a date.');			
		} 
		
		if(end ==''){
			$("#endDateDiv").attr('class','control-group error');
			$("#endDateDiv .help-block").html('Start date cannot be left empty. Please select a date.');			
		}
		if(start != '' && end != ''){
			$("#startDateDiv").attr('class','control-group');
			$("#startDateDiv .help-block").html('');	
			$("#endDateDiv").attr('class','control-group');
			$("#endDateDiv .help-block").html('');	
			
			$("#editScheduleForm1").submit();		
		}
	});
	
	$("#selectDatesButton").click(function(){
		var count = $("#addEditSelectableDates li").length;
		$("#addEditSelectableDates li").each(function(idx){
			var date_selected = $(this).find('.date_to_edit').html();
			var date_input = '<input type="hidden" name="data[Date]['+idx+']" value="'+date_selected+'"/>';
			$("#editScheduleForm2").append(date_input);
			
			if((count-1) == idx){
				$("#editScheduleForm2").submit();
			}
		});
		
	});
	
/**
 * Edit Page
 * 
 */
	$(".tripTimeInput").bind('blur',function(){
		var oldValue = $(this).attr('old');
		var newValue = $(this).val();
		
		if(newValue != oldValue){
			$(this).parent().attr('class','control-group info');	
			$(this).attr('status','edited');
			$(this).parent().parent().parent().parent().parent().parent().parent().find("a span").attr('class','label label-info');
			$(this).parent().parent().parent().parent().parent().parent().parent().find("a span").html('Edited');
					
		} else{
			$(this).parent().attr('class','control-group');
			$(this).attr('status','notedited');
		}
		
		//check all of the inputs in the table if any of them are edited then keep the edit badge up
		var table_id = $(this).parent().parent().parent().parent().attr('id').replace('tripTimeTable-','');
		var edited_length = $("#tripTimeTable-"+table_id+" input[status='edited']").length;
	
		if(edited_length ==0){
			$(this).parent().parent().parent().parent().parent().parent().parent().find("a span").attr('class','label label-warning');
			$(this).parent().parent().parent().parent().parent().parent().parent().find("a span").html('Not Edited');			
		} 
	});	
});



/**
 * calendar for ferry schedule
 */ 
	schedule = {
		datePicker: function() {
			$('#schedule_start').datepicker().on('changeDate', function(ev){
				var start = $(this).val();
				$("#schedule_start").datepicker('hide');

			});
			$('#schedule_end').datepicker().on('changeDate', function(ev){
				$("#schedule_end").datepicker('hide');
			});			
		},
		regular: function(inventory_id) {

			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();

			//sets calendar
		
			var calendar = $('#calendar').fullCalendar({
				
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
		            url: '/schedules/getJson',
		            type: 'POST',
		            data: {
		            	type:'Monthly_Schedule_Calendar',
		            	inventory_id: inventory_id,
		            },
		            success: function(results){

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
					right: 'month'
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
	};
	

/**
 * Functions
 */

