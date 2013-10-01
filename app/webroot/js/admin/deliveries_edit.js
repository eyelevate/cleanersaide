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
			//reindex rows
			$(".blackoutList li input").each(function(en){
				$(this).attr('name','data[Delivery][blackout]['+en+']');
			});
			var row = $(".blackoutList li").length;
			display = createBlackoutInput(row,blackout);
			
			$(".blackoutList").append(display);
			
			$(this).parents('div:first').find('.blackoutInput').val('');
		});
		
		$(".zipcodeButton").click(function(){
			var zipcode = $(this).parents('div:first').find('.zipcodeInput').val();
			var idx = $(this).attr('index');
			//reindex rows
			$(".zipcodeList li input").each(function(en){
				$(this).attr('name','data[Delivery][zipcode]['+en+']');
			});
			var row = $(".zipcodeList li").length;
			display = createZipcodeInput(row,zipcode);
			
			$(".zipcodeList").append(display);
			
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

var createZipcodeInput = function(row, zipcode){
	var input = '<li class="alert alert-info">'+zipcode+'<button type="button" class="close" data-dismiss="alert">&times;</button><input type="hidden" name="data[Delivery][zipcode]['+row+']" value="'+zipcode+'"/></li>';
	return input;
};

var createBlackoutInput = function(row, blackout){
	var input = '<li class="alert alert-error">'+blackout+'<button type="button" class="close" data-dismiss="alert">&times;</button><input type="hidden" name="data[Delivery][blackout]['+row+']" value="'+blackout+'"/></li>';
	return input;
};
