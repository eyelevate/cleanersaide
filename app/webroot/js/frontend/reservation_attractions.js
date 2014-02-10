$(document).ready(function(){
	reservation_attractions.datePicker();
	reservation_attractions.events();
	
	$(".pointer").click(function(){
		$(this).parent().find('input').focus().blur();
	});
});

/**
 * Functions
 */
reservation_attractions = {
	datePicker: function(){
		cutoff = parseInt($("#start").attr('cutoff')) / 86400;
		//datepicker scripts runs off of jquery-ui
		
		var __picker = $.fn.datepicker;
		$.fn.datepicker = function(options) {
		    __picker.apply(this, [options]);
		    var $self = this;
		    
		    if (options && options.trigger) {
		        $(options.trigger).bind("click", function () {
		            $self.datepicker("show");
		        });
		    }
		}
		
		$("#start").datepicker({ minDate: cutoff, trigger:'#buttonStart'});		
		$("#end").datepicker({ minDate: cutoff, trigger:'#buttonEnd' });	
	},
	events: function(){
		$("#searchButton").click(function(){
			var attraction_id =$("#attraction_id").val();
			var start = $("#start").val();
			var end = $("#end").val();
			var arrival = Math.round((new Date(start)).getTime() / 1000);
			var departure = Math.round((new Date(end)).getTime() / 1000);

			if(start == ''){
				$("#start").parent().parent().addClass('error');
				$("#start").parent().parent().find('.help-block').html('No date selected');
			} else {
				$("#start").parent().parent().removeClass('error');
				$("#start").parent().parent().find('.help-block').html('');				
			}
			if(end == ''){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('No date selected');				
			}

			if(end != '' && parseInt(arrival) == parseInt(departure)){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('cannot be the same as arrival');					
			} 
			if(end != '' && parseInt(arrival) > parseInt(departure)){
				$("#end").parent().parent().addClass('error');
				$("#end").parent().parent().find('.help-block').html('cannot be before arrival');					
			} 
			if(start != '' && end != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure)){
				$("#end").parent().parent().removeClass('error');
				$("#end").parent().parent().find('.help-block').html('');					
			}
			
			//if all of the validation approves get hotel rooms
			if(start != '' && parseInt(arrival) != ''){
				//function to get hotel rooms
				getTours(attraction_id, arrival);
			}
			
			
			
		});
	},
	//adds scripts to page after ajax call
	addScripts: function(){
		//select time
		$(".tourTime").click(function(){
			var type = $(this).attr('timed');
			var id = $(this).attr('id').replace('tourTime-','');
			var time = $(this).attr('time');
			switch(type){
				case 'Yes':
				$(".tourLi").hide();
				$('.tourLi #tourAmountDiv').removeClass('selected');

				$('#tourLi-'+id+'[time="'+time+'"]').show();	
				$('#tourLi-'+id+'[time="'+time+'"] #tourAmountDiv').addClass('tourAmountDiv-selected');
				$('#tourLi-'+id+'[time="'+time+'"] #timeSelected').val(time);			
				break;
				
				default:
				$(".tourLi").hide();
				$('.tourLi #tourAmountDiv').removeClass('selected');
				$('#tourLi-'+id).show();	
				$('#tourLi-'+id+'[time="'+time+'"] #tourAmountDiv').addClass('tourAmountDiv-selected');
				$('#tourLi-'+id+'[time="'+time+'"] #timeSelected').val(time);
				
				break;
			}
			

		});
		
		
		$(".bookTour").click(function(e){
			// var attraction_id =$("#attraction_id").val();
			var start = $("#start").val();

			errors = 0;
			
			amount = 0;
			$(this).parents('form:first').find('#tourAmountDiv:visible .typePrice').each(function(en){
				var qty = $(this).val();

				if(qty == ''){
					qty = 0;
					
					$(this).val(qty);
				}
				amount += parseInt(qty);
			});
	
			if(amount == 0){
				errors++;
				$(this).parents('form:first').find('#errorMessage').html('You must enter at least one ticket');
			} else {
				$(this).parents('form:first').find('#errorMessage').html('');
			}

			if(errors == 0){
				$(this).parents('form:first').submit();	
			} else {
				alert('You must have at least one ticket quantity');
			}
		
			
			
			e.preventDefault();
		});
		
		$(".typePrice").blur(function(){
			//remove the previous summary
			$(this).parent().parent().parent().parent().find("#summaryTable tbody tr").remove();
			$(this).parent().parent().parent().parent().find('#summaryTable').removeClass('hide');
			total_pretax = 0;
			total_after_tax = 0;
			$(this).parent().parent().parent().parent().find(".typePrice").each(function(){
				var amount = $(this).val();
				if(amount == ''){
					amount = 0;
				} else {
					amount = parseInt(amount);
				}
				var type = $(this).parent().find('label').html();
				var gross = parseFloat($(this).attr('gross'));
				var tax = parseFloat($(this).attr('tax_rate'));		
				var total_gross = Math.round((amount * gross)*100) / 100;
				var total_gross = total_gross.toFixed(2);
				
				total_pretax = parseFloat(total_pretax) + parseFloat(total_gross);
				total_after_tax = parseFloat(total_after_tax) + (parseFloat(total_gross)*(1+(tax)));
				var newTr = '<tr><td>'+type+'</td><td style="text-align:right">$'+total_gross+'</td></tr>';
				$(this).parent().parent().parent().parent().find('#summaryTable tbody').append(newTr);		
			});
			total_after_tax = Math.round((total_after_tax * 100)) / 100;
			total_pretax = Math.round((total_pretax * 100)) / 100;
			total_tax = Math.round((total_after_tax - total_pretax)*100) / 100;
			total_after_tax = total_after_tax.toFixed(2);
			total_pretax = total_pretax.toFixed(2);
			total_tax = total_tax.toFixed(2);
			
			
			$(this).parent().parent().parent().parent().find('#summaryTable #total_pretax').html('$'+total_pretax);
			$(this).parent().parent().parent().parent().find('#summaryTable #total_tax').html('$'+total_tax);
			$(this).parent().parent().parent().parent().find('#summaryTable #total_after_tax').html('$'+total_after_tax);
		});
	}
}

//gets hotel rooms and sends them to the ul in the page
var getTours = function(attraction_id, start){
	//change time and check limits
	$.post(
		'/attractions/request_attraction_tours',
		{
			attraction_id: attraction_id,
			start: start

		},	function(results){
			$("#resultsDiv").removeClass('hide');
			$("#tourAvailableUl").html(results);
			reservation_attractions.addScripts();

		}
	);		
}

var bookTour = function(attraction_id,tour_id, start,date,time, purchase_info){
	//change time and check limits
	$.post(
		'/attractions/request',
		{
			type:'BOOK_ATTRACTION_TOUR',
			attraction_id: attraction_id,
			time:time,
			tour_id: tour_id,
			date: date,
			start: start,
			purchase_info: purchase_info
		},	function(results){
			//window.location = "/reservations/thank-you";
			
		}
	);	
}
