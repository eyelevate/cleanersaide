$(document).ready(function(){

	//ajax save schedule
	save.ajaxSave();

});


/**
 * functions
 */
save = {
	ajaxSave: function(){
		$(".save_schedule_button").click(function(){
			var requestCount = $("#ScheduleAddForm input").length;
			
			var serializeData = $("#ScheduleAddForm").serialize();
			
				//send via ajax post method
				$.post(
					'/schedules/request',
					{
						type:'NEW_SCHEDULE',
						form_data:serializeData
					}, function(result){
						//set the new form_id
						var form_id = result;
						$(".modal-body").html('<p class="text text-success">Successfully saved your schedule! You will be redirected to the schedule index page.</p>');
						setTimeout(function(){  //pass it an anonymous function that calls foo
    						window.location.replace("/schedules");
						},2000);
						
					}
				);
		});		
	}
}
