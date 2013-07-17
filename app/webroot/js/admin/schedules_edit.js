$(document).ready(function(){
	edit.numberformat();
	edit.checkRows();
	edit.validateAll();
	$("#setAllByTripButton").click(function(){
		var trip_id = $(".chooseTripNumber option:selected").val();
		var start = $("#tripStart").val();
		var end = $("#tripEnd").val();
		
		edit.setAllByTrip(trip_id, start, end);

	});
	
	
	//Delete an individual Trip
	$(".deleteDateButton").click(function(){
		//create variables status and trip_id
		var status = $(this).attr('status'); // status checks to see if you are deleting or reinstating a date
		var trip_id = $(this).attr('row'); // trip_id is used to create a hidden input field to send to the controller to delete that trip
		var old_value = $(this).parent().find('.tripTimeInput').attr('old');
		if(status == 'deleted'){ //if the use clicks on delete button and the status is already deleted then reinstate the date
			$(this).parent().find('.tripTimeInput').removeAttr('disabled'); 
			$(this).parent().find('.tripTimeInput').val(old_value);
			$(this).parent().parent().attr('class','control-group');
			$(this).html('Delete Sailing');
			$(this).attr('status','notdeleted');
			//go to the hidden form and remove the trip_id and reinstate the date
			edit.removeDelete(trip_id); 
		} else {
			$(this).parent().find('.tripTimeInput').attr('disabled','disabled');
			$(this).parent().find('.tripTimeInput').val('Date Deleted');
			$(this).parent().parent().attr('class','control-group error');
			$(this).html('Reinstate Sailing');
			$(this).attr('status','deleted');
			//add an additional row to the hidden form, this will create a hidden input field, for the controller to read and delete.
			edit.makeDelete(trip_id);
		}
		//make the badge show as edited
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('a span').attr('class','label label-success');
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('a span').html('Edited');
	});
	
	$(".removeNIS").click(function(){
		var trip_id = $(this).attr('row');
		if (confirm("Are you sure you want to delete?")) { 
		 // do things if OK
		 edit.makeDelete(trip_id);
		 $(this).parent().remove();
		}
		
	});
	$("#saveScheduleEditButton").click(function(){
		$(".formEdit").submit();
	});
	
});

/**
 *Functions 
 */
edit = {
	checkRows: function(){ //checks to see if there are any missing rows on the serice schedule

		//loop through each row starting from the tbody
		$("#tripTimeTableTbody tr").each(function(){ 
			var countTd = $(this).find('td').length;
			if(countTd == 2){ //check to see if there are any td missing if so add a td
				//add a td and row
				var dest1 = $(this).find('#dest1').length;
				var dest2 = $(this).find('#dest2').length;
				
				if(dest1 == 0){ // set before dest 1
					$("#dest2").before('<td></td>');
				}
				
				if(dest2 == 0){ //set after dest 2
					$("#dest1").after('<td></td>');
				}
			}
		});
	},
	numberformat: function(){
		//number formatting
		$(".ferry_oneWay").priceFormat({
			'prefix':'',
		});
		$(".ferry_surcharge").priceFormat({
			'prefix':'',
		});

	},	
	setAllByTrip: function(trip_id, start, end){
		//first validate the script
		if(trip_id =='none'){
			$(".chooseTripNumber").parent().attr('class','control-group error');
			$(".chooseTripNumber").parent().find('.help-block').html('Value cannot be left empty');
		}
		if(start ==''){
			$("#tripStart").parent().attr('class','control-group error');
			$("#tripStart").parent().find('.help-block').html('Value cannot be left empty');			
		}
		if(end == ''){
			$("#tripEnd").parent().attr('class','control-group error');
			$("#tripEnd").parent().find('.help-block').html('Value cannot be left empty');			
		}
		
		if(trip_id != '' && start != '' && end != ''){
			$(".tripTr[row='"+trip_id+"']").each(function(){
				$(this).find('#dest1 .tripTimeInput').val(start);
				$(this).find('#dest2 .tripTimeInput').val(end);
				
				//change all dates to say edited
				$(this).parent().parent().parent().parent().parent().find('a span').attr('class','label label-success');
				$(this).parent().parent().parent().parent().parent().find('a span').html('edited');
			});
			$(".chooseTripNumber").parent().attr('class','control-group');
			$(".chooseTripNumber").parent().find('.help-block').html('');			
			$("#tripStart").parent().attr('class','control-group');
			$("#tripStart").parent().find('.help-block').html('');	
			$("#tripEnd").parent().attr('class','control-group');
			$("#tripEnd").parent().find('.help-block').html('');			
			$(".chooseTripNumber option:selected").val();
			$("#tripStart").val('');
			$("#tripEnd").val('');				
		}
	
	},
	makeDelete: function(trip_id){
		var deletedInput = deleteDate(trip_id);
		$(".formEdit").append(deletedInput);
	},
	removeDelete: function(trip_id){
		$(".formEdit #deleteTrip-"+trip_id).remove();
	},
	validateAll: function(){
		$(".ferry_oneWay").keyup(function(){
			var oneway = $(this).val();
			var surcharge = $(this).parent().parent().parent().parent().find('.ferry_surcharge').val();
			var total = parseFloat(oneway) + parseFloat(surcharge);
			var total = total.toFixed(2);
			$(this).parent().parent().parent().parent().find(".ferry_surchargeTotal").val(total);
			$(this).attr('changed','Yes');
			//change the edit label
			$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('a span').attr('class','label label-success');
			$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('a span').html('edited');

		});
		
		$(".ferry_surcharge").keyup(function(){
			var oneway = $(this).parent().parent().parent().parent().find('.ferry_oneWay').val();
			var surcharge = $(this).val();
			var total = parseFloat(oneway) + parseFloat(surcharge);
			var total = total.toFixed(2);
			$(this).attr('changed','Yes');
			$(this).parent().parent().parent().parent().find(".ferry_surchargeTotal").val(total);
			//change the edit label
			$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('a span').attr('class','label label-success');
			$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('a span').html('edited');
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



/**
 *Variable Functions 
 */

//creates a hidden input field with the array of Delete
// when user sends the edit form this will delete the trip_id from the database.
var deleteDate = function(trip_id){
	input = '<input id="deleteTrip-'+trip_id+'" type="hidden" name="data[Delete]['+trip_id+']" value="'+trip_id+'"/>';
	return input;
}
