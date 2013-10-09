$(document).ready(function(){
	delivery.events();
});

delivery = {
	events: function(){
		$("#selectMonth").change(function(){
			var month = $(this).find('option:selected').val();
			var year = $("#selectYear option:selected").val();
			delivery.getDate(month,year);
		});
		$("#selectYear").change(function(){
			var month = $("#selectMonth option:selected").val();
			var year = $(this).find('option:selected').val();
			delivery.getDate(month,year);
		});		
		$("#schedule_date").change(function(){
			
			var get_date = $("#schedule_date option:selected").val();
			var get_time = $("#schedule_time option:selected").val();
			$("#deliveryDateDiv").removeClass('error').find('.help-block').html('');
			
			

			var selected = $(this).find('option:selected').val();
			$("#schedule_time").html('<option value="">Searching for delivery times...</option>');
			setTimeout(function(){
				$("#schedule_time").html('<option value="">Select time range</option>');
				$("#timeFieldsDiv option").each(function(){
					var get_date = $(this).attr('date');
					get_html = $(this);
					
					if(selected == get_date){
						$("#schedule_time").append(get_html);
					}
				});						
			},1000);

		});
		
		$("#schedule_time").change(function(){
			$("#deliveryTimeDiv").removeClass('error').find('.help-block').html('');
		});
		$("#datetimeFinish").click(function(){
			var get_date = $("#schedule_date option:selected").val();
			var get_time = $("#schedule_time option:selected").val();
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
	getDate: function(month,year){
		//change time and check limits
		$.post(
			'/deliveries/request_date_time',
			{
				month: month,
				year: year,
			},	function(results){

				$("#hiddenFormFields").html(results);
				
				$("#schedule_date").html('<option value="">Searching for delivery dates...</option>');
				setTimeout(function(){
					$("#schedule_date").html('<option value="">Select delivery date</option>');
					$("#dateFieldsDiv option").each(function(){
						get_html = $(this);
						$("#schedule_date").append(get_html);

					});						
				},1000);				
			}
		);		
	}
};

