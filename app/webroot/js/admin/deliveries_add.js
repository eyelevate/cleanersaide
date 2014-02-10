$(document).ready(function(){
	delivery.datePicker();
	delivery.events();
});

delivery = {
	datePicker: function(){
		$(".blackoutInput").datepicker().on('changeDate', function(ev){
  			$('.blackoutInput').datepicker('hide');

		});
	},
	events: function(){
		$(".blackoutButton").click(function(){
			var blackout = $(this).parents('div:first').find('.blackoutInput').val();
			var idx = $(this).attr('index');
			var row = $("#blackoutList-"+idx+' li').length;
			display = createBlackoutInput(idx,row,blackout);
			
			$("#blackoutList-"+idx).append(display);
			
			$(this).parents('div:first').find('.blackoutInput').val('');
		});
		
		$(".zipcodeButton").click(function(){
			var zipcode = $(this).parents('div:first').find('.zipcodeInput').val();
			var idx = $(this).attr('index');
			var row = $("#zipcodeList-"+idx+' li').length;
			display = createZipcodeInput(idx,row,zipcode);
			
			$("#zipcodeList-"+idx).append(display);
			
			$(this).parents('div:first').find('.zipcodeInput').val('').focus();
			
		});
		
		$("#cancelDelivery").click(function(){
			if(confirm('Are you sure you want to cancel you delivery form?')){
				location.reload();
			}
		});
		
		$('#submitDelivery').click(function(){
			if(confirm('Are you ready to submit this delivery form?')){
				$(this).parents('form:first').submit();
			}
		});
	}
};

var createZipcodeInput = function(idx, row, zipcode){
	var input = '<li class="alert alert-info">'+zipcode+'<button type="button" class="close" data-dismiss="alert">&times;</button><input type="hidden" name="data[Delivery]['+idx+'][zipcode]['+row+']" value="'+zipcode+'"/></li>';
	return input;
};

var createBlackoutInput = function(idx, row, blackout){
	var input = '<li class="alert alert-error">'+blackout+'<button type="button" class="close" data-dismiss="alert">&times;</button><input type="hidden" name="data[Delivery]['+idx+'][blackout]['+row+']" value="'+blackout+'"/></li>';
	return input;
};
