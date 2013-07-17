$(document).ready(function(){
	view.numberformat();
	view.validateAll();
	$("#editFormButton").click(function(){
		
		view.editForm();
	});
	
	$("#deleteFormButton").click(function(){
		if(confirm('Are you sure you want to delete trip?')){
			view.deleteForm();	
		}
		
	});
});

/**
 *Functions 
 */

view = {
	numberformat: function(){
		//number formatting
		$(".ferry_oneWay").priceFormat({
			'prefix':'',
		});
		$(".ferry_surcharge").priceFormat({
			'prefix':'',
		});

	},	
	editForm: function(){
		// $("input[edit='editable']").each(function(){
// 			
			// var inputClone = $(this).clone();
// 			
			// $("#editScheduleForm1").append(inputClone);
// 
		// });
		
		$("#editScheduleForm1").submit();
	},
	deleteForm: function(){
		var trip_id = $("#trip_id").val();
		var delete_form = deleteInput(trip_id);
		$("#deleteTrip").append(delete_form);
		$("#deleteTrip").submit();	

		
	},

	validateAll: function(){
		$(".ferry_oneWay").keyup(function(){
			var oneway = $(this).val();
			var surcharge = $(this).parent().parent().parent().find('.ferry_surcharge').val();
			var total = parseFloat(oneway) + parseFloat(surcharge);
			var total = total.toFixed(2);

			$(this).parent().parent().parent().find(".ferry_surchargeTotal").val(total);
			$(this).attr('changed','Yes');
			//change the edit label
			$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('a span').attr('class','label label-success');
			$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('a span').html('edited');

		});
		
		$(".ferry_surcharge").keyup(function(){
			var oneway = $(this).parent().parent().parent().find('.ferry_oneWay').val();
			var surcharge = $(this).val();
			var total = parseFloat(oneway) + parseFloat(surcharge);
			var total = total.toFixed(2);
			$(this).attr('changed','Yes');
			$(this).parent().parent().parent().find(".ferry_surchargeTotal").val(total);
			//change the edit label
			$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('a span').attr('class','label label-success');
			$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('a span').html('edited');
		});
		
		$(".ferry_reservableUnits").keyup(function(){
			//change the edit label
			$(this).attr('changed','Yes');
			$(this).parent().parent().parent().parent().parent().parent().parent().find('a span').attr('class','label label-success');
			$(this).parent().parent().parent().parent().parent().parent().parent().find('a span').html('edited');	
			
			//grab value 
			var reservable = $(this).val();
			var total = $(this).parent().parent().parent().parent().find('.ferry_totalUnits').val();
			var capacity = (parseFloat(reservable) / parseFloat(total))*100;
			var capacity = capacity.toFixed(2);
			//insert capacity value into form field
			$(this).parent().parent().parent().parent().find('.ferry_capacity ').val(capacity);	
		});
		$(".ferry_totalUnits").keyup(function(){
			//change the edit label
			$(this).attr('changed','Yes');
			$(this).parent().parent().parent().parent().parent().parent().parent().find('a span').attr('class','label label-success');
			$(this).parent().parent().parent().parent().parent().parent().parent().find('a span').html('edited');	
			//grab value 
			var reservable = $(this).parent().parent().parent().parent().find('.ferry_reservableUnits').val();
			var total = $(this).val();
			var capacity = (parseFloat(reservable) / parseFloat(total))*100;
			var capacity = capacity.toFixed(2);
			//insert capacity value into form field
			$(this).parent().parent().parent().parent().find('.ferry_capacity ').val(capacity);			
		});
	},

}

var deleteInput = function(trip_id){
	form = '<input type="hidden" name="data[Delete]['+trip_id+']" value="'+trip_id+'"/>';
	
	return form;
}
