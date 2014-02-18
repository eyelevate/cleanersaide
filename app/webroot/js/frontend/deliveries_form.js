$(document).ready(function(){
	delivery.datePicker();
	delivery.events();
	
	//set the library of scripts to the olsen library
	timezoneJS.timezone.zoneFileBasePath = '/js/timezone/tz';
	timezoneJS.timezone.init();	
});

delivery = {
	datePicker: function(){
		selectable_days = new Array();
		blackout_dates = new Array();
		returned_array = new Array();
		$("#deliveryScheduleTable tbody tr").each(function(ev){
			var day = $(this).attr('day');
			selectable_days[ev] = day;
		});
		$('.blackoutLi').each(function(ev){
			var blackout = $(this).attr('blackout');
			blackout_dates[ev] = blackout;
		});
		$(".pickupDate").datepicker({
			minDate:0,
			beforeShowDay: function(date){ 
				date.setHours(7);
				var current_datetotime = convertDateToPacific(new Date()).getTime();
				var selected_datetotime = convertDateToPacific(date).getTime();


				var date_string = jQuery.datepicker.formatDate('mm/dd/yy', date);
				switch(selectable_days.length){
					case 0:
						
        				returned_array = [blackout_dates.indexOf(date_string) == -1 ];
					break;
					
					case 1:
						returned_array = [current_datetotime <= selected_datetotime && blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0],""];
						
					break;
					
					case 2:
						returned_array = [current_datetotime <= selected_datetotime && blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1],""];
					break;
					
					case 3:
						returned_array = [current_datetotime <= selected_datetotime && blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1] || date.getDay() == selectable_days[2],""];
					break;
					
					case 4:
						returned_array = [current_datetotime <= selected_datetotime && blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1] || date.getDay() == selectable_days[2] || date.getDay() == selectable_days[3],""];
					break;
					
					case 5:
						returned_array = [current_datetotime <= selected_datetotime && blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1] || date.getDay() == selectable_days[2] || date.getDay() == selectable_days[3] || date.getDay() == selectable_days[4],""];
					break;
					
					case 6:
						returned_array = [current_datetotime <= selected_datetotime && blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1] || date.getDay() == selectable_days[2] || date.getDay() == selectable_days[3] || date.getDay() == selectable_days[4] || selectable_days[5],""];
					break;
				}
				return returned_array;
				
			},
			onSelect: function(en){ //runs an onselect script grabs times and status
				//set variables

				var get_time = $("#schedule_pickup_time option:selected").val();
				$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
				//first clean out the dropoff form and reset
				$("#dropoffFormDiv").hide();
				$("#pickupFinishFake").show();
				$("#pickupFinish").hide();
				$("#schedule_dropoff_time").html('<option value="">Select dropoff time</option>');			
				$("#pickupFinishFake").show();
				$("#deliveryFinish").hide();			
	
				var pickup_date = convertDateToPacific($(".pickupDate").val()).getTime() / 1000;
				delivery.getPickupDate(pickup_date);				
				

			}		
		}).focus(function () {$(this).blur();});
		
	},
	events: function(){
		$("#selectPickupMonth").change(function(){
			var pickup_date = convertDateToPacific($(".pickupDate").val()).getTime() / 1000;
			delivery.getPickupDate(pickup_date);
		});
		$("#selectPickupYear").change(function(){
			var pickup_date = convertDateToPacific($(".pickupDate").val()).getTime() / 1000;
			delivery.getPickupDate(pickup_date);
		});	
		$("#selectDropoffMonth").change(function(){
			var pickup_date = convertDateToPacific($(".dropoffDate").val()).getTime() / 1000;

			delivery.getPickupDate(pickup_date);
		});
		$("#selectDropoffYear").change(function(){
			var pickup_date = convertDateToPacific($(".dropoffDate").val()).getTime() / 1000;

			delivery.getPickupDate(pickup_date);
		});				
			

		
		$("#schedule_pickup_time").change(function(){
			//first clean out the dropoff form and reset

			$("#dropoffFormDiv").hide();
			$("#pickupFinishFake").show();
			$("#pickupFinish").hide();
			$("#schedule_dropoff_time").html('<option value="">Select pickup time</option>');
			$("#deliveryTimeDiv").removeClass('error').find('.help-block').html('');
			
			//validate date and time
			//set variables
			var get_date = convertDateToPacific($(".pickupDate").val()).getTime() / 1000;
			var get_time = $("#schedule_pickup_time option:selected").val();	
			if(get_date != '' && get_time != ''){
				delivery.getDropoffDate(get_date, get_time);
				
				element = $(".dropoffDate");
				
				addScripts.newDatePicker(element);
				
			}
				
		});
		
		$(".stepDiv input, .stepDiv select").click(function(){
			$(".stepDiv").removeClass('alert').removeClass('alert-info');
			$(this).parents('.stepDiv:first').addClass('alert').addClass('alert-info');		
		});
		

		
		$("#schedule_dropoff_time").change(function(){			
			//validate date and time
			//set variables
			var get_date = $(".dropoffDate").val();
			var get_time = $("#schedule_dropoff_time option:selected").val();	
			$(".stepDiv").removeClass('alert').removeClass('alert-info');
			$(this).parents('.stepDiv:first').addClass('alert').addClass('alert-info');
			if(get_date != '' && get_time != 'none'){
				$("#pickupFinishFake").hide();
				$("#deliveryFinish").show();
			}
				
		});		
		
		$("#pickupFinish").click(function(){
			var get_date = $(".pickupDate").val();
			var get_time = $("#schedule_pickup_time option:selected").val();
			$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
			$("#deliveryTimeDiv").removeClass('error').find('.help-block').html('');
			
			
			

		});
		$("#deliveryFinish").click(function(){
			var get_date = $(".dropoffDate").val();
			var get_time = $("#schedule_dropoff_time option:selected").val();
			$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
			$("#deliveryTimeDiv").removeClass('error').find('.help-block').html('');
			
			if(get_date == ''){
				$(".dropoffDate").parents('.control-group:first').addClass('error').find('.help-block').html('This field cannot be left empty');

			}
			if(get_time == ''){
				$("#deliveryTimeDiv").addClass('error').find('.help-block').html('This field cannot be left empty');
			}
			
			if(get_date != '' && get_time !=''){
				$("#successfulFormMessage").removeClass('hide').addClass('alert alert-success').html('Thank you for selected your delivery date and time!');
				$("#dateTimeForm").submit();	

				
			}
		});
		
		$("#step1Button").click(function(){
			var value1 = $(".pickupDate").val();
			var value2 = $("#schedule_pickup_time option:selected").val();
			if(value1 == ''){
				$(".pickupDateDiv").addClass('error');
				$(".pickupDateDiv").find('.help-block').html('Please select a pickup date.');
			} else {
				$(".pickupDateDiv").removeClass('error');
				$(".pickupDateDiv").find('.help-block').html('');				
			}
			
			if(value2 == 'none'){
				$("#deliveryTimeDiv").addClass('error');
				$("#deliveryTimeDiv").find('.help-block').html('Please select a pickup time');
			} else {
				$("#deliveryTimeDiv").removeClass('error');
				$("#deliveryTimeDiv").find('.help-block').html('');						
			}
			
			if(value1 != '' && value2 != 'none'){
				$(this).parents('.stepButtonDiv:first').hide();
				$(this).parents('#step1Div').removeClass('alert').removeClass('alert-info');
				$(".stepDiv").removeClass('alert').removeClass('alert-info');
				$('#step2Div').addClass('alert').addClass('alert-info');
				$("#pickupFinishFake").hide();
				$("#step2Div, #deliveryFinish").show();

			}
		});
		
		$("#step2Button").click(function(){
			var value1 = $("#schedule_pickup_date option:selected").val();
			var value2 = $("#schedule_pickup_time option:selected").val();
			if(value1 == 'none'){
				$("#deliveryDateDiv").addClass('error');
				$("#deliveryDateDiv").find('.help-block').html('Please select a pickup date.');
			} else {
				$("#deliveryDateDiv").removeClass('error');
				$("#deliveryDateDiv").find('.help-block').html('');				
			}
			
			if(value2 == 'none'){
				$("#deliveryTimeDiv").addClass('error');
				$("#deliveryTimeDiv").find('.help-block').html('Please select a pickup time');
			} else {
				$("#deliveryTimeDiv").removeClass('error');
				$("#deliveryTimeDiv").find('.help-block').html('');						
			}
			
			if(value1 != 'none' && value2 != 'none'){
				$("#step2ButtonDiv").hide();
				$("#step2Div").removeClass('alert').removeClass('alert-info');
				$("#step3Div").show();
			}
		});
		
		$('.add-on').click(function(){
			$(this).parents('.input-append:first').find('input').focus();
		});
	},
	getPickupDate: function(pickup_date){
		//change time and check limits
		$.post(
			'/deliveries/request_pickup_date_time',
			{
				pickup_date: pickup_date
			},	function(results){
				//first clean out the dropoff form and reset
				$("#dropoffFormDiv").hide();
				$("#pickupFinishFake").show();
				$("#pickupFinish").hide();
				$("#schedule_dropoff_time").html('<option value="">Select Dropoff Time</option>');
				$("#pickupFinishFake").show();
				$("#pickupFinish").hide();	
				$("#hiddenFormFields").html(results); //paste created html to select
				
				//next clean up the current time select and add a search animation
				$("#schedule_pickup_time").html('<option value="">Searching for delivery times...</option>');
				setTimeout(function(){
					$("#schedule_pickup_time").html(results);

					
				},500);				
			}
		);		
	},
	getDropoffDate: function(pickup_date,pickup_time){
		if(pickup_date == ''){
			$("#deliveryDateDiv").addClass('error').find('.help-block').html('This field cannot be left empty');
	
		}
		if(pickup_time == ''){
			$("#deliveryTimeDiv").addClass('error').find('.help-block').html('This field cannot be left empty');
		}
		
		if(pickup_date != '' && pickup_time !=''){
			
			$.post(
				'/deliveries/request_dropoff_date_time',
				{
					pickup_date: pickup_date,
					pickup_time: pickup_time,
				},	function(results){
					$("#successfulPickupMessage").removeClass('hide').addClass('alert alert-success').html('Thank you for selecting your delivery pickup date and time! Please press next to select a dropoff date and time.');
					//$("#pickupFinishFake").hide();
					
					$("#step1Button").removeClass('disabled');
					$("#dropoffFormDiv").show();
					$("#hiddenFormFields2").html(results);
					$("#schedule_dropoff_date").html('<option value="">Searching for delivery dates...</option>');
					$("#schedule_dropoff_date, #schedule_dropoff_time").html('');
				
					// $("#hiddenFormFields2 #dateFieldsDiv option").each(function(){
						// get_html = $(this).clone();
						// $("#schedule_dropoff_date").append(get_html);
// 
					// });		
					var new_pickup_date = $("#hiddenFormFields2 #dateFieldsDiv option:first").html();
					console.log(new_pickup_date);
					$(".dropoffDate").val(new_pickup_date).datepicker("option", "minDate", new_pickup_date);	

					$("#hiddenFormFields2 #timeFieldsDiv option").each(function(en){
						if(en == 0){
							
							get_html = $(this).clone();
							$("#schedule_dropoff_time").append(get_html);								
						}


					});				
				}
			);				
			
		}		
			
	},	
	selectDropOffDate: function(dropoff_date){
		//change time and check limits
		$.post(
			'/deliveries/request_pickup_date_time',
			{
				pickup_date: dropoff_date
			},	function(results){
				//first clean out the dropoff form and reset
				$("#dropoffFormDiv").hide();
				$("#pickupFinishFake").show();
				$("#pickupFinish").hide();
				
				$("#pickupFinishFake").show();
				$("#pickupFinish").hide();	
				$("#hiddenFormFields").html(results); //paste created html to select
				
				//next clean up the current time select and add a search animation
				$("#schedule_dropoff_time").html('<option value="">Searching for delivery times...</option>');
				setTimeout(function(){
					$("#schedule_dropoff_time").html(results);

					
				},500);				
			}
		);			
	}
};

addScripts = {
	newDatePicker: function(element){
		selectable_days = new Array();
		blackout_dates = new Array();
		returned_array = new Array();
		$("#deliveryScheduleTable tbody tr").each(function(ev){
			var day = $(this).attr('day');
			selectable_days[ev] = day;
		});
		$('.blackoutLi').each(function(ev){
			var blackout = $(this).attr('blackout');
			blackout_dates[ev] = blackout;
		});
		element.datepicker({
			minDate:0,
			beforeShowDay: function(date){ 
				var date_string = jQuery.datepicker.formatDate('mm/dd/yy', date);
				switch(selectable_days.length){
					case 0:
						returned_array = [ blackout_dates.indexOf(date_string) == -1 ];
					break;
					
					case 1:
						returned_array = [blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0],""];
						
					break;
					
					case 2:
						returned_array = [blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1],""];
					break;
					
					case 3:
						returned_array = [blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1] || date.getDay() == selectable_days[2],""];
					break;
					
					case 4:
						returned_array = [blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1] || date.getDay() == selectable_days[2] || date.getDay() == selectable_days[3],""];
					break;
					
					case 5:
						returned_array = [blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1] || date.getDay() == selectable_days[2] || date.getDay() == selectable_days[3] || date.getDay() == selectable_days[4],""];
					break;
					
					case 6:
						returned_array = [blackout_dates.indexOf(date_string) == -1 && date.getDay() == selectable_days[0] || date.getDay() == selectable_days[1] || date.getDay() == selectable_days[2] || date.getDay() == selectable_days[3] || date.getDay() == selectable_days[4] || selectable_days[5],""];
					break;
				}
				return returned_array;
				
			},
			onSelect: function(en){ //runs an onselect script grabs times and status
				//set variables
				var get_time = $("#schedule_dropoff_time option:selected").val();
				$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
				//first clean out the dropoff form and reset
				$("#dropoffFormDiv").hide();
				$("#pickupFinishFake").show();
				$("#deliveryFinish").hide();
				$("#schedule_dropoff_time").html('<option value="">Select Dropoff Time</option>');			
				$("#pickupFinishFake").show();
				$("#pickupFinish").hide();			
	
				var dropoff_date = convertDateToPacific($(this).val()).getTime() / 1000;
				delivery.selectDropOffDate(dropoff_date);

			}		
		}).focus(function () {$(this).blur();});			
	}
};
var convertDateToPacific = function(date){
	


	var dt = new timezoneJS.Date(date, 'America/Los_Angeles');
		
	return dt;
	

};
