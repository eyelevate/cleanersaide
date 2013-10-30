$(document).ready(function(){
	delivery.events();
});

delivery = {
	events: function(){
		$("#selectPickupMonth").change(function(){
			var month = $(this).find('option:selected').val();
			var year = $("#selectPickupYear option:selected").val();
			delivery.getPickupDate(month,year);
		});
		$("#selectPickupYear").change(function(){
			var month = $("#selectPickupMonth option:selected").val();
			var year = $(this).find('option:selected').val();
			delivery.getPickupDate(month,year);
		});	
		$("#selectDropoffMonth").change(function(){
			var month = $(this).find('option:selected').val();
			var year = $("#selectPickupYear option:selected").val();
			delivery.getPickupDate(month,year);
		});
		$("#selectDropoffYear").change(function(){
			var month = $("#selectPickupMonth option:selected").val();
			var year = $(this).find('option:selected').val();
			delivery.getPickupDate(month,year);
		});				
			
		$("#schedule_pickup_date").change(function(){
			//set variables
			var get_date = $("#schedule_pickup_date option:selected").val();
			var get_time = $("#schedule_pickup_time option:selected").val();
			$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
			//first clean out the dropoff form and reset
			$("#dropoffFormDiv").hide();
			$("#pickupFinishFake").show();
			$("#pickupFinish").hide();
			$("#schedule_dropoff_time").html('<option value="">Select dropoff time</option>');			
			$("#pickupFinishFake").show();
			$("#pickupFinish").hide();			

			var selected = $(this).find('option:selected').val();
			$("#schedule_pickup_time").html('<option value="">Searching for delivery times...</option>');
			setTimeout(function(){
				$("#schedule_pickup_time").html('<option value="">Select pickup time</option>');
				$("#timeFieldsDiv option").each(function(){
					
					var get_date = $(this).attr('date');
					get_html = $(this).clone();
					
					if(selected == get_date){
						$("#schedule_pickup_time").append(get_html);
					}
				});						
			},1000);

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
			var get_date = $("#schedule_pickup_date option:selected").val();
			var get_time = $("#schedule_pickup_time option:selected").val();	
			if(get_date != '' && get_time != ''){
				$("#pickupFinishFake").hide();
				$("#pickupFinish").show();
			}
				
		});
		
		$("#schedule_dropoff_date").change(function(){
			//set variables
			var get_date = $("#schedule_dropoff_date option:selected").val();
			var get_time = $("#schedule_dropoff_time option:selected").val();
			$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
		

			var selected = $(this).find('option:selected').val();
			$("#schedule_dropoff_time").html('<option value="">Searching for delivery times...</option>');
			setTimeout(function(){
				$("#schedule_dropoff_time").html('<option value="">Select pickup time</option>');
				$("#hiddenFormFields2 #timeFieldsDiv option").each(function(){
					
					var get_date = $(this).attr('date');
					get_html = $(this).clone();
					
					if(selected == get_date){
						$("#schedule_dropoff_time").append(get_html);
					}
				});						
			},1000);

		});
		
		$("#schedule_dropoff_time").change(function(){			
			//validate date and time
			//set variables
			var get_date = $("#schedule_dropoff_date option:selected").val();
			var get_time = $("#schedule_dropoff_time option:selected").val();	
			if(get_date != '' && get_time != ''){
				$("#dropoffFinishFake").hide();
				$("#dropoffFinish").show();
			}
				
		});		
		
		$("#pickupFinish").click(function(){
			var get_month = $("#selectPickupMonth option:selected").val();
			var get_year = $("#selectPickupYear option:selected").val();
			var get_date = $("#schedule_pickup_date option:selected").val();
			var get_time = $("#schedule_pickup_time option:selected").val();
			$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
			$("#deliveryTimeDiv").removeClass('error').find('.help-block').html('');
			
			delivery.getDropoffDate(get_date, get_time, get_month, get_year);
			

		});
		$("#dropoffFinish").click(function(){
			var get_date = $("#schedule_dropoff_date option:selected").val();
			var get_time = $("#schedule_dropoff_time option:selected").val();
			$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
			$("#deliveryTimeDiv").removeClass('error').find('.help-block').html('');
			
			if(get_date == ''){
				$("#deliveryDateDiv").addClass('error').find('.help-block').html('This field cannot be left empty');

			}
			if(get_time == ''){
				$("#deliveryTimeDiv").addClass('error').find('.help-block').html('This field cannot be left empty');
			}
			
			if(get_date != '' && get_time !=''){
				$("#successfulFormMessage").removeClass('hide').addClass('alert alert-success').html('Thank you for selected your delivery date and time!');
				$("#dateTimeForm").submit();	

				
			}
		});
	},
	getPickupDate: function(month,year){
		//change time and check limits
		$.post(
			'/deliveries/request_pickup_date_time',
			{
				month: month,
				year: year,
			},	function(results){
				//first clean out the dropoff form and reset
				$("#dropoffFormDiv").hide();
				$("#pickupFinishFake").show();
				$("#pickupFinish").hide();
				$("#schedule_dropoff_time").html('<option value="">Select dropoff time range</option>');
				$("#pickupFinishFake").show();
				$("#pickupFinish").hide();	
				$("#hiddenFormFields").html(results); //paste created html to select
				
				//next clean up the current time select and add a search animation
				$("#schedule_pickup_date").html('<option value="">Searching for delivery dates...</option>');
				setTimeout(function(){
					$("#schedule_pickup_date").html('<option value="">Select pickup date</option>');
					$("#schedule_pickup_time").html('<option value="">Select pickup time</option>');
					$("#dateFieldsDiv option").each(function(){
						get_html = $(this).clone();
						$("#schedule_pickup_date").append(get_html);

					});						
				},1000);				
			}
		);		
	},
	getDropoffDate: function(pickup_date,pickup_time, pickup_month, pickup_year){
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
					pickup_month: pickup_month,
					pickup_year: pickup_year,
					pickup_date: pickup_date,
					pickup_time: pickup_time,
				},	function(results){
					$("#successfulPickupMessage").removeClass('hide').addClass('alert alert-success').html('Thank you for selected your delivery dropoff date and time!');
					$("#pickupFinishFake, #pickupFinish").hide();
					$("#dropoffFormDiv").show();
					$("#hiddenFormFields2").html(results);
					$("#schedule_dropoff_date").html('<option value="">Searching for delivery dates...</option>');
					$("#schedule_dropoff_date, #schedule_dropoff_time").html('');
				
					$("#hiddenFormFields2 #dateFieldsDiv option").each(function(){
						get_html = $(this).clone();
						$("#schedule_dropoff_date").append(get_html);

					});			
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
};

