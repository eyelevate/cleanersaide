$(document).ready(function(){
	view.datePicker();
	view.initialize();
	view.events();
	view.validate();
	
});

/**
 * Functions
 */
view = {
	datePicker: function(){

		$(".departDateCalendar").datepicker().on('changeDate', function(ev){
  			$(this).datepicker('hide');
  			var date = new Date($(this).val()).getTime() / 1000;
  			var port = $(this).parent().parent().parent().find('#selectPort option:selected').val();
  			element = $(this);
  			element.parent().parent().parent().find('#timeSelect').html('<option>Searching</option');
			//find the new times using port and date as variables
			requests.dateTime(date, port, element);
			
			var element_time = $(this).parents('tr:first').find("#timeSelect");
			element_time.parent().parent().removeClass('success').removeClass('error').addClass('warning');
			element_time.parent().parent().find('.help-block').html('Please select time');
		});
		$(".hotelDateCalendar").datepicker().on('changeDate', function(ev){
  			$(this).datepicker('hide');
		});
		$(".attractionDateCalendar").datepicker().on('changeDate', function(ev){
  			$(this).datepicker('hide');
  			var start = $(this).val();
  			var index = $(this).parents('tr:first').find('.attractionSelect').attr('index');
  			var attraction_id = $(this).parents('tr:first').find('.attractionSelect option:selected').val();
  			var element_tour = $(this).parents('tr:first').find('#tourSelectionDiv');
  			var tour_selected = $(this).parents('tr:first').find('.attractionSelect').attr('old');

  			requests.getTours(index, start, attraction_id, element_tour,tour_selected);		
		});
	},
	initialize: function(){
		//each to get initial attraction tours for edit
		$(".attractionSelect").each(function(){
			var index = $(this).attr('index');
			var attraction_id = $(this).find('option:selected').val();
			var start = $(this).parents('tr:first').find('#attractionTourDate').val();
			var element_tour = $(this).parents('tr:first').find("#tourSelectionDiv");
			var tour_selected = $(this).attr('old');

			requests.getTours(index, start, attraction_id, element_tour,tour_selected);		
			
			
			
			
			
				

		});		

		$('.attraction_age_group').keyup(function(){
			var element_this = $(this);
			var element_gross = $(this).parents('tr:first').find('#attractionTotal');
			addScripts.calculateTotalGrossTour(element_this, element_gross);
		});
	},
	events: function(){
		
		
		$(".selectPorts").change(function(){
			
			var port = $(this).find('option:selected').val();
			element_date = $(this).parents('tr:first').find('.departDateCalendar');
			var date = new Date(element_date.val()).getTime() / 1000;
			//find the new times using port and date as variables
			requests.dateTime(date, port, element_date);
			
			var element_time = $(this).parents('tr:first').find("#timeSelect");
			element_time.parent().parent().removeClass('success').removeClass('error').addClass('warning');
			element_time.parent().parent().find('.help-block').html('Please select time');
		});
		
		$(".returnTimeSelect, .departTimeSelect").change(function(){
			var time = $(this).val();
			switch(time){
				case 'Select Time':
					$(this).parent().parent().find('.help-block').html('You must select a time');
				break;
				
				default:
					$(this).parent().parent().find('.help-block').html('');	
				break;
			}
			
		});

		
		$("#cancelReservationButton").click(function(){
			if(confirm('Are you sure you want to cancel this reservation?')){
				if($(this).parent().parent().find('.status_reservation').val() != '0'){
					$(this).parents('form:first').submit();
				}
			}
		});
		
		$(".cancelAttractionButton").click(function(){
			if(confirm('Are you sure you want to cancel this attraction?')){
				if($(this).parent().parent().find('.attractionStatus').val() != '0'){
					$(this).parents('form:first').submit();
				}
			}
		});
		
		$(".cancelHotelButton").click(function(){
			selected_cancel = $(this).html();
			if(selected_cancel != 'Refund'){
				if(confirm('Are you sure you want to cancel this hotel?')){
					if($(this).parent().parent().find('.hotelStatus').val() != '0'){
						$(this).parents('form:first').submit();
					}
				}
			}
		});
		
		$(".cancelFerryButton").click(function(){
			selected_cancel = $(this).html();
			if(selected_cancel != 'Refund'){
				if(confirm('Are you sure you want to cancel this ferry sailing?')){
					if($(this).parent().parent().find('.status_ferry').val() != '0'){
						$(this).parents('form:first').submit();	
					}
					
				}	
			}		
		});
		$(".cancelFerryAllButton").click(function(){
			selected_cancel = $(this).html();
			if(selected_cancel != 'Refund'){
				if(confirm('Are you sure you want to change this ferry reservation?')){
					if($(this).parent().parent().find('.status_ferry').val() != '0'){
						$(this).parents('form:first').submit();	
					}
					
				}
			}			
		});
		
		$(".cancelHotelAllButton").click(function(){
			selected_cancel = $(this).html();
			if(selected_cancel != 'Refund'){
				if(confirm('Are you sure you want to change this ferry reservation?')){
					if($(this).parent().parent().find('.status_hotel').val() != '0'){
						$(this).parents('form:first').submit();	
					}
					
				}	
			}		
		});
		$(".cancelAttractionAllButton").click(function(){
			selected_cancel = $(this).html();
			if(selected_cancel != 'Refund'){
				if(confirm('Are you sure you want to change this ferry reservation?')){
					if($(this).parent().parent().find('.status_attraction').val() != '0'){
						$(this).parents('form:first').submit();	
					}
					
				}	
			}		
		});
		$(".selectDropDown li").click(function(){
			var refundStatus = $(this).attr('value');
			var refundTitle = $(this).html();
			//update the button title
			$(this).parent().parent().find('.cancelFerryButton').html(refundTitle);
			$(this).parent().parent().parent().find('.status_ferry').val(refundStatus);
		});
		$(".selectDropDownFerryAll li").click(function(){
			var refundStatus = $(this).attr('value');
			var refundTitle = $(this).html();
			//update the button title
			$(this).parent().parent().find('.cancelFerryAllButton').html(refundTitle);
			$(this).parent().parent().parent().find('.ferry_refund_all').val(refundStatus);
		});
		$(".selectDropDownHotel li").click(function(){
			var refundStatus = $(this).attr('value');
			var refundTitle = $(this).html();
			//update the button title
			$(this).parent().parent().find('.cancelHotelButton').html(refundTitle);
			$(this).parent().parent().parent().find('.hotelStatus').val(refundStatus);
		});	
		$(".selectDropDownHotelAll li").click(function(){
			var refundStatus = $(this).attr('value');
			var refundTitle = $(this).html();
			//update the button title
			$(this).parent().parent().find('.cancelHotelAllButton').html(refundTitle);
			$(this).parent().parent().parent().find('.hotelStatus').val(refundStatus);
		});			
		$(".selectDropDownAttraction li").click(function(){
			var refundStatus = $(this).attr('value');
			var refundTitle = $(this).html();
			//update the button title
			$(this).parent().parent().find('.cancelAttractionButton').html(refundTitle);
			$(this).parent().parent().parent().find('.attractionStatus').val(refundStatus);
		});	
		$(".selectDropDownAttractionAll li").click(function(){
			var refundStatus = $(this).attr('value');
			var refundTitle = $(this).html();
			//update the button title
			$(this).parent().parent().find('.cancelAttractionAllButton').html(refundTitle);
			$(this).parents('form:first').find('.attractionStatus').val(refundStatus);
		});	
		//changes table rows into forms
		$(".editButton").click(function(){
			$(this).hide();
			$(this).parent().find('.cancelEditButton').show();
			$(this).parent().find('.checkFerryButton').removeClass('hide');
			$(this).parent().find('#refundButtonGroup').addClass('hide');
			$(this).parent().parent().find('.tdView').addClass('hide');
			$(this).parent().parent().find('.tdEdit').removeClass('hide');
			
			//change the tr color to a yellow for editing
			$(this).parent().parent().css({
				'background-color':'#fcf8e3'
			});
			$(this).parent().parent().find('td').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
			$(this).parent().parent().attr('edit_check','Yes');	
			view.counter();	
		});
		
		$("#cancelAll").click(function(){
			location.reload();
		});
		
		$(".cancelEditButton").click(function(){
			$(this).hide();
			$(this).parent().find('.editButton').show();
			$(this).parent().find('.checkFerryButton').addClass('hide');
			$(this).parent().find('#refundButtonGroup').removeClass('hide');
			$(this).parent().parent().find('.tdView').removeClass('hide');
			$(this).parent().parent().find('.tdEdit').addClass('hide');
			//change the tr color to a yellow for editing
			$(this).parent().parent().css({
				'background-color':'#ffffff'
			});
			$(this).parent().parent().find('td').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
			$(this).parent().parent().attr('edit_check','No');	
			view.counter();	
		});		
		$(".inventorySelect").change(function(){
			var option = $(this).find('option:selected').val();
			var name = $(this).find('option:selected').html();
			var trip = $(this).attr('trip');
			switch(option){
				case 'FootPassengers':
					$(this).parent().parent().parent().find(".drivers").attr('disabled','disabled');
					$(this).parent().parent().parent().find(".drivers").val('0');
					$(this).parent().parent().parent().find('.addInventoryOl').html('');
					$(this).addClass('warning');

				break;
				
				case '22':
					$(this).parent().parent().parent().find(".drivers").removeAttr('disabled');
					$(this).parent().parent().parent().find(".drivers").val('0');	
					$(this).parent().parent().parent().find('.addInventoryOl li[inventory_id="3"]').remove();
					$(this).parent().parent().parent().find('.addInventoryOl li[inventory_id="4"]').remove();		
					
					//create a new li and render it to view		
					var idx = $(this).parent().parent().parent().find('.addInventoryOl li').length;
					var ferry_id = $(this).parent().parent().parent().attr('ferry_id');
					var inventory_id = '2';
					var item_id = option;
					var overlength = 'No';
					var drivers = parseInt(idx)+1;
					var createLi = vehicleLi(option, name,ferry_id, idx, inventory_id, item_id, overlength, trip);
					$(this).parent().parent().parent().find('.addInventoryOl').append(createLi);
					$(this).parent().parent().parent().find('.drivers').val(drivers);
					$(this).find('option[value="none"]').attr('selected','selected');
					$(this).removeClass('warning');
				break;
				
				case '23':
					$(this).parent().parent().parent().find(".drivers").removeAttr('disabled');
					
					$(this).parent().parent().parent().find(".drivers").val('0');		
					$(this).parent().parent().parent().find('.addInventoryOl li[inventory_id="3"]').remove();
					$(this).parent().parent().parent().find('.addInventoryOl li[inventory_id="4"]').remove();	
					
					//create a new li and render it to view		
					var idx = $(this).parent().parent().parent().find('.addInventoryOl li').length;
					var inventory_id = '2';
					var ferry_id = $(this).parent().parent().parent().attr('ferry_id');
					var item_id = option;
					var overlength = 'Yes';
					var drivers = parseInt(idx)+1;
					var createLiExtra = vehicleLiExtra(option, name, ferry_id,idx, inventory_id,item_id, overlength, trip);
					
					$(this).parent().parent().parent().find('.addInventoryOl').append(createLiExtra);	
					$(this).parent().parent().parent().find('.drivers').val(drivers);
					$(this).find('option[value="none"]').attr('selected','selected');
					$(this).removeClass('warning');
				break;
				
				case '28':
					$(this).parent().parent().parent().find(".drivers").attr('disabled','disabled');
					$(this).parent().parent().parent().find(".drivers").val('0');					
					$(this).parent().parent().parent().find('.addInventoryOl li[inventory_id="2"]').remove();
					$(this).parent().parent().parent().find('.addInventoryOl li[inventory_id="3"]').remove();
					
					//create a new li and render it to view		
					var idx = $(this).parent().parent().parent().find('.addInventoryOl li').length;
					var inventory_id = '4';
					var ferry_id = $(this).parent().parent().parent().attr('ferry_id');
					var item_id = option;
					var overlength = 'No';
					var createLiExtra = motorcycleLi(option, name, ferry_id, idx, inventory_id,item_id, overlength, trip);
					
					$(this).parent().parent().parent().find('.addInventoryOl').append(createLiExtra);	
					$(this).parent().parent().parent().find('.drivers').val('0');	
					$(this).find('option[value="none"]').attr('selected','selected');		
					$(this).removeClass('warning');		
				break;
				
				default:
					$(this).parent().parent().parent().find(".drivers").attr('disabled','disabled');
					$(this).parent().parent().parent().find(".drivers").val('0');		
					$(this).parent().parent().parent().find('.addInventoryOl li[inventory_id="2"]').remove();
					$(this).parent().parent().parent().find('.addInventoryOl li[inventory_id="4"]').remove();	

					//create a new li and render it to view		
					var idx = $(this).parent().parent().parent().find('.addInventoryOl li').length;
					var inventory_id = '3';
					var ferry_id = $(this).parent().parent().parent().attr('ferry_id');
					var item_id = option;
					var overlength = 'No';
					var createLiExtra = motorcycleLi(option, name,ferry_id, idx, inventory_id,item_id, overlength, trip);
					
					$(this).parent().parent().parent().find('.addInventoryOl').append(createLiExtra);	
					$(this).parent().parent().parent().find('.drivers').val('0');
					var motorcycles_count = $(this).parents('td:first').find('.addInventoryOl li').length;	
					
					$(this).parents('tr:first').find('.adults').val(motorcycles_count);	
					$(this).find('option[value="none"]').attr('selected','selected');
				break;
			}
			view.addScript();
			view.counter();	
			//change the tr color to a yellow for editing
			$(this).parents('tr:first').css({
				'background-color':'#fcf8e3'
			});
			$(this).parents('tr:first').find('td').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');			
			$(this).parents('tr:first').find('.checkFerryButton').removeAttr('disabled');
			$("#changeReservation").attr('disabled','disabled').removeClass('btn-success');
			$(this).parent().parent().parent().find('.checkFerryButton').addClass('btn-info');
		});
		
		$(".removeInventory").click(function(){
			var newCount = ($(this).parent().parent().find('li').length) - 1;
			var type = $(this).parent().attr('inventory_id');
			if(type == '2'){
				$(this).parent().parent().parent().parent().parent().find('.drivers').val(newCount);
			}
		});
		
		//change reservation button grabs all of the necessary form elements and creates one big form and submits it
		$("#changeReservation").click(function(){
			$('input[edit="Yes"]').each(function(){
				var formElement = $(this).clone();
				$("#editReservationForm").append(formElement);
			});
			$('select[edit="Yes"]').each(function(){
				var name = $(this).attr('name');
				var value = $(this).find('option:selected').val();
				
				var newRow = '<input type="hidden" value="'+value+'" name="'+name+'"/>';
				$("#editReservationForm").append(newRow);
			});
			$('#editReservationForm').submit();

		});
		
		$(".checkFerryButton").click(function(){
			var element = $(this);
			view.requests(element);
		});
		
		//hotel section
		$(".editHotelButton").click(function(){
			$(this).hide();
			$(this).parents('tr:first').find('.cancelHotelEditButton').show();
			$(this).parents('tr:first').find('.checkHotelButton').removeClass('hide');
			$(this).parents('tr:first').find('#refundButtonGroup').addClass('hide');
			$(this).parents('tr:first').find('.tdView').addClass('hide');
			$(this).parents('tr:first').find('.tdEdit').removeClass('hide');
			
			//change the tr color to a yellow for editing
			$(this).parent().parent().parent().css({
				'background-color':'#fcf8e3'
			});
			$(this).parent().parent().parent().find('td').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
			$(this).parent().parent().parent().attr('edit_check','Yes');	
			view.counter();	
		});		
		$(".cancelHotelEditButton").click(function(){
			$(this).hide();
			$(this).parents('tr:first').find('.editHotelButton').show();
			$(this).parents('tr:first').find('.checkHotelButton').addClass('hide');
			$(this).parents('tr:first').find('#refundButtonGroup').removeClass('hide');
			$(this).parents('tr:first').find('.tdView').removeClass('hide');
			$(this).parents('tr:first').find('.tdEdit').addClass('hide');
			$(this).parents('tr:first').next('tr').addClass('hide');
			//change the tr color to a yellow for editing
			$(this).parent().parent().css({
				'background-color':'#ffffff'
			});
			$(this).parent().parent().find('td').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
			$(this).parent().parent().attr('edit_check','No');	
			view.counter();	
		});		
		$(".hotelSelect").change(function(){
			var hotel_id = $(this).find('option:selected').val();
			//clean up the hotel room select options and replace it with a searching message
			$(this).parent().parent().parent().find('.hotelRoomSelect').html('<option>Searching Rooms</options>');
			element = $(this);
			//get all of the hotel rooms that has this hotel id in the hidden div

			setTimeout(function(){
				
				var rooms = $('.selectedHotelRoomOptions[hotel_id="'+hotel_id+'"]').clone();
				element.parent().parent().parent().find('.hotelRoomSelect').html(rooms);
		
			}, 700);
		});
		
		$(".checkHotelButton").click(function(){
			var element = $(this);
			view.hotel_request(element);
		});
		
		//attraction section
		$(".editAttractionButton").click(function(){
			$(this).hide();
			$(this).parent().find('.cancelAttractionEditButton').show();
			$(this).parent().find('.checkAttractionButton').removeClass('hide');
			$(this).parent().find('#refundButtonGroup').addClass('hide');
			$(this).parent().parent().find('.tdView').addClass('hide');
			$(this).parent().parent().find('.tdEdit').removeClass('hide');
			
			//change the tr color to a yellow for editing
			$(this).parent().parent().css({
				'background-color':'#fcf8e3'
			});
			$(this).parent().parent().find('td').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
			$(this).parent().parent().attr('edit_check','Yes');	
			view.counter();	
		});		
		$(".cancelAttractionEditButton").click(function(){
			$(this).hide();
			$(this).parents('tr:first').find('.editAttractionButton').show();
			$(this).parents('tr:first').find('.checkAttractionButton').addClass('hide');
			$(this).parents('tr:first').find('#refundButtonGroup').removeClass('hide');
			$(this).parents('tr:first').find('.tdView').removeClass('hide');
			$(this).parents('tr:first').find('.tdEdit').addClass('hide');
			$(this).parents('tr:first').next('tr').addClass('hide');
			//change the tr color to a yellow for editing
			$(this).parent().parent().css({
				'background-color':'#ffffff'
			});
			$(this).parent().parent().find('td').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
			$(this).parent().parent().attr('edit_check','No');	
			view.counter();	
		});		
		
		$(".checkAttractionButton").click(function(){
			var element = $(this);
			view.attraction_request(element);
		});
		
		
		$(".attractionSelect").change(function(){
			var index = $(this).attr('index');
			var attraction_id = $(this).find('option:selected').val();
			var start = $(this).parents('tr:first').find('#attractionTourDate').val();
			var element_tour = $(this).parents('tr:first').find("#tourSelectionDiv");
			
			$(this).parents('tr:first').find("#attractionAgeGroupDiv ul").remove();
			$(this).parents('tr:first').find("#attractionTotal").val('0.00');

			requests.getTours(index, start, attraction_id, element_tour,'');
		});
		
		//send out emails
		$("#resendEmail").click(function(){
			var email  = $(this).parents('div:first').find('#emailInput').val();
			if(email ==''){
				$(this).parent().parent().addClass('error');
				$(this).parent().parent().find('.help-block').html('No email address was set');
				
			} else {
				$(this).parent().parent().removeClass('error');
				$(this).parent().parent().find('.help-block').html('');
				$(this).parents('form:first').submit();	
			}
			
		});
		
		$("#hotelEmailSelect").change(function(){
			var hotel = $(this).find('option:selected').val();
			var hotel_email = $(this).find('option:selected').attr('email');
			if(hotel == 'No'){
				$(this).parent().addClass('error');
				$(this).parent().find('.help-block').html('Please select a valid hotel');
				
			} else {
				$(this).parent().removeClass('error');
				$(this).parent().find('.help-block').html('');
				//replace email field
				$("#hotelEmailInput").val(hotel_email);
			}
		});
		
		$("#resendHotelEmail").click(function(){
			var hotel = $(this).parents('form:first').find('#hotelEmailSelect option:selected').val();
			if(hotel == 'No'){
				$('#selectHotelResendDiv').addClass('error');
				$("#selectHotelResendDiv").find('.help-block').html('You must select a hotel');
			} else {
				$('#selectHotelResendDiv').removeClass('error');
				$("#selectHotelResendDiv").find('.help-block').html('');
				$(this).parents('form:first').submit();	
			}
			
		});


	},
	addScript: function(){
		$(".removeInventory").click(function(){
			var newCount = ($(this).parent().parent().find('li').length) - 1;
			var type = $(this).parent().attr('inventory_id');
			if(type == '2'){
				$(this).parent().parent().parent().parent().parent().find('.drivers').val(newCount);
			}
		});		
	},
	validate: function(){
		$('.editable').change(function(){
		
			var type = $(this).attr('id');
			var old_port = $(this).parents('tr:first').find('#selectPort').attr('old');
			var new_port = $(this).parents('tr:first').find('#selectPort').val();
			var old_date = $(this).parents('tr:first').find('#dateInput').attr('old');
			var new_date = $(this).parents('tr:first').find('#dateInput').val();
			var old_time = $(this).parents('tr:first').find('#timeSelect').attr('old');
			var new_time = $(this).parents('tr:first').find('#timeSelect').val();
			var old_drivers = $(this).parents('tr:first').find('#driverInput').attr('old');
			var new_drivers = $(this).parents('tr:first').find('#driverInput').val();
			var old_adults = $(this).parents('tr:first').find('#adultInput').attr('old');
			var new_adults = $(this).parents('tr:first').find('#adultInput').val();		
			var old_children = $(this).parents('tr:first').find('#childrenInput').attr('old');
			var new_children = $(this).parents('tr:first').find('#childrenInput').val();
			var old_infants = $(this).parents('tr:first').find('#infantInput').attr('old');
			var new_infants = $(this).parents('tr:first').find('#infantInput').val();		
			
			$(this).parents('tr:first').find('.checkFerryButton').attr('disabled','disabled').removeClass('btn-info');
						
			if(old_port == new_port && old_date == new_date && old_time == new_time && old_drivers == new_drivers && old_adults == new_adults && old_children == new_children && old_infants == new_infants){
				$(this).parents('td:first').removeClass('control-group').removeClass('error').removeClass('success');
			
				$(this).parents('tr:first').find('.checkFerryButton').attr('disabled','disabled');
				$(this).parents('tr:first').find('.checkFerryButton').removeClass('btn-info');		
				
				
			} else {
				$(this).parents('tr:first').find('td').removeClass('control-group').removeClass('error').removeClass('success').addClass('control-group');
				$(this).parents('td:first').addClass('warning');
				//show check button
				$(this).parents('tr:first').find('.checkFerryButton').removeAttr('disabled').addClass('btn-info');	
				
			}
			$(this).parents('tr:first').css({
				'background-color':'#fcf8e3'
			});
			
			view.counter();
		});
		
		$(".hotelEditable").change(function(){
			var check_in = $(this).parents('tr:first').find('#hotelCheckIn').val();
			var old_check_in = $(this).parents('tr:first').find('#hotelCheckIn').attr('old');
			var check_out = $(this).parents('tr:first').find('#hotelCheckOut').val();
			var old_check_out= $(this).parents('tr:first').find('#hotelCheckOut').attr('old');
			var hotel_id = $(this).parents('tr:first').find('.hotelSelect option:selected').val();
			var old_hotel_id = $(this).parents('tr:first').find('.hotelSelect').attr('old');
			var room_id = $(this).parents('tr:first').find('.hotelRoomSelect option:selected').val();
			var old_room_id = $(this).parents('tr:first').find('.hotelRoomSelect').attr('old');
			var qty = $(this).parents('tr:first').find('#roomQty').val();
			var old_qty = $(this).parents('tr:first').find('#roomQty').attr('old');
			var adults = $(this).parents('tr:first').find('#hotelAdults').val();
			var old_adults = $(this).parents('tr:first').find('#hotelAdults').attr('old');
			var children = $(this).parents('tr:first').find('#hotelChildren').val();
			var old_children = $(this).parents('tr:first').find('#hotelChildren').attr('old');
			//remove contents from next tr row and hide it
			$(this).parents('tr:first').next('tr').addClass('hide');
			
			$(this).parents('tr:first').find('.checkHotelButton').attr('disabled','disabled').removeClass('btn-info');
			if(old_check_in ==check_in && old_check_out == check_out && old_hotel_id == hotel_id && old_room_id == room_id && old_qty == qty && old_adults == adults && old_children==children){
				$(this).parents('td:first').removeClass('control-group').removeClass('error').removeClass('success');
				$(this).parents('tr:first').find('.checkFerryButton').attr('disabled','disabled');
				$(this).parents('tr:first').find('.checkFerryButton').removeClass('btn-info');	
			} else {
				$(this).parents('tr:first').find('td').removeClass('control-group').removeClass('error').removeClass('success').addClass('control-group');
				$(this).parents('td:first').addClass('warning');
				//show check button
				$(this).parents('tr:first').find('.checkHotelButton').removeAttr('disabled').addClass('btn-info');	
				
			}
			$(this).parents('tr:first').css({
				'background-color':'#fcf8e3'
			});
			
			view.counter();
			
		});
		$(".attractionEditable").change(function(){
			var attraction_id = $(this).parents('tr:first').find('.attractionTourSelect option:selected').attr('attraction_id');
			var tour_id = $(this).parents('tr:first').find('.attractionTourSelect option:selected').val();
			var old_tour_id = $(this).parents('tr:first').find('.attractionTourSelect').attr('old');
			var date = $(this).parents('tr:first').find('attractionTourDate').val();
			var old_date = $(this).parents('tr:first').find('#attractionTourDate').attr('old');
			var time_check = $(this).parents('tr:first').find('#timeSelect').length;
			if(time_check > 0){
				var time= $(this).parents('tr:first').find('#timeSelect option:selected').val();
				var old_time = $(this).parents('tr:first').find("#timeSelect").attr('old');	
			} else {
				var time = 'No';
				var old_time = 'No';
			}
			var changes = 0;
			$(this).parents('tr:first').find('.age_range_group').each(function(){
				var old_qty = $(this).attr('old');
				var qty = $(this).val();
				
				if(qty != old_qty){
					changes ++;
				}
			});

			
			$(this).parents('tr:first').find('.checkAttractionButton').attr('disabled','disabled').removeClass('btn-info');
			if(old_tour_id ==tour_id && old_date == date && old_time == time && changes == 0){
				$(this).parents('td:first').removeClass('control-group').removeClass('error').removeClass('success');
				$(this).parents('tr:first').find('.checkAttractionButton').attr('disabled','disabled');
				$(this).parents('tr:first').find('.checkAttreactionButton').removeClass('btn-info');	
			} else {
				$(this).parents('tr:first').find('td').removeClass('control-group').removeClass('error').removeClass('success').addClass('control-group');
				$(this).parents('td:first').addClass('warning');
				//show check button
				$(this).parents('tr:first').find('.checkAttractionButton').removeAttr('disabled').addClass('btn-info');	
				
			}
			$(this).parents('tr:first').css({
				'background-color':'#fcf8e3'
			});
			
			view.counter();
			
		});

	},
	counter: function(){
		var count = $(".warning").length;
		if(count > 0){	
			$("#editCounterP").removeClass('hide');
			$("#counter").html(count);
			$("#counterP").html(' changed reservation data.');

		} else {
			$("#editCounterP").addClass('hide');
			$("#counter").html('');
			$("#counterP").html('');

		}
		
		var edit_check_count = $('tr[edit_check="Yes"]').length;
		
		if(edit_check_count >0 ){
			
			var check_count = $('tr[edit_check="Yes"][check="Yes"]').length;
			if(check_count == edit_check_count){
				$("#changeReservation").removeAttr('disabled');
				$("#changeReservation").attr('class','btn btn-success');				
			} else {
				$("#changeReservation").attr('disabled','disabled');
				$("#changeReservation").attr('class','btn');				
			}	
						
		} else {
			$("#changeReservation").attr('disabled','disabled');
			$("#changeReservation").attr('class','btn');			
		}
	},
	requests: function(element){ //ferry check
		var reservation_id = $("#reservation_id").val();
		var port = element.parent().parent().find('#selectPort option:selected').val();
		var date =new Date(element.parent().parent().find('#dateInput').val()).getTime() / 1000;
		var time = element.parent().parent().find('#timeSelect option:selected').val();
		var inventory ='Passenger';
		var inventory_length = element.parent().parent().find('.addInventoryOl li').length;
		if(inventory_length > 0){
			inventory = {};
			element.parent().parent().find('.addInventoryOl li').each(function(ev){
					
				inventory[ev] = {};
				inventory[ev]['inventory_id'] = $(this).find('#inventory_id').val();
				inventory[ev]['item_id']  = $(this).find('#item_id').val();
				inventory[ev]['overlength'] = $(this).find('#overlength').val();
				inventory[ev]['overlength_feet'] = $(this).find('#overlength_feet').val();
				inventory[ev]['towed_units'] = $(this).find('#towed_units option:selected').val();
	
			});
		} else {
			inventory = 'Passenger';
		}

		var drivers = element.parent().parent().find('.drivers').val();
		if(drivers == ''){
			drivers = 0;
		}
		var adults =element.parent().parent().find('.adults').val();
		if(adults == ''){
			adults = 0;
		}
		var children = element.parent().parent().find('.children').val();
		if(children == ''){
			children = 0;
		}
		var infants = element.parent().parent().find('.infants').val();
		if(infants == ''){
			infants = 0;
		}
		var old_drivers = element.parent().parent().find('.drivers').attr('old');
		var old_adults = element.parent().parent().find('.adults').attr('old');
		var old_children = element.parent().parent().find('.children').attr('old');
		var old_infants = element.parent().parent().find('.infants').attr('old');
		
		var old_passengers = parseInt(old_drivers) + parseInt(old_adults) + parseInt(old_children) + parseInt(old_infants);
		var new_passengers = parseInt(drivers) + parseInt(adults) + parseInt(children) + parseInt(infants);
		var schedule_id = element.parent().parent().attr('schedule_id');
		$.post(
			'/schedules/request_edit_check',
			{
				type:'RESERVATION_EDIT_CHECK',
				reservation_id: reservation_id,
				port: port,
				date: date,
				time: time,
				inventory: inventory,
				schedule_id: schedule_id,
				old_passengers: old_passengers,
				new_passengers: new_passengers,
			},	function(status){
				/**
				 * Calculate status
				 * 1. inventory and passengers ok
				 * 2. inventory ok passengers over
				 * 3. inventory over passengers ok
				 * 4. inventory over passengers over
				 */
				//remove error list
				element.parent().parent().find('.addErrorsList').html('');
				//turn all elements in tr to success
				element.parent().parent().find('td').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');

				switch(status){
					case '1': //everything is ok you can turn this row green and change 
						element.parent().parent().find('#inventorySelectOption').removeClass('warning').removeClass('error').removeClass('control-group');
						element.parent().parent().find('#driverInput').parent().removeClass('warning').removeClass('error').removeClass('control-group');
						element.parent().parent().find('#adultInput').parent().removeClass('warning').removeClass('error').removeClass('control-group');
						element.parent().parent().find('#childrenInput').parent().removeClass('warning').removeClass('error').removeClass('control-group');
						element.parent().parent().find('#infantInput').parent().removeClass('warning').removeClass('error').removeClass('control-group');
						
						element.parent().parent().css({
							'background-color':'#dff0d8',
							'border-color':'#d6e9c6'
						});
						//turn all elements in tr to success
						element.parent().parent().find('td').removeClass('control-group').removeClass('warning').removeClass('error').addClass('control-group').addClass('success');
						element.parent().parent().find('td:last-child').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
						//create a list of errors
						$(".addErrorsList").html('');	
						
						//set check to Yes. this will ensure that the change reservation button does appear (if all rows are set to yes)
						element.parent().parent().attr('check','Yes');
						element.parents('tr:first').find('.checkFerryButton').attr('disabled','disabled').removeClass('btn-info');
						view.counter();
					break;
					
					case '2': //passengers is over so turn the control group to error for passengers
						element.parent().parent().find('#driverInput').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						element.parent().parent().find('#adultInput').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						element.parent().parent().find('#childrenInput').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						element.parent().parent().find('#infantInput').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						
						//turn background back to red
						element.parent().parent().css({
							'background-color':'#f2dede',
							'border-color':'#eed3d7'
						});		
						
						//create a list of errors
						element.parent().parent().find(".addErrorsList").append('<li class="text text-error">Passenger count is over the limit.</li>');		

						//set check to No. this will ensure that the change reservation button does not appear
						element.parent().parent().attr('check','No');
					break;
					
					case '3': //vehicles is over so turn the control group for vehicles to error
						element.parent().parent().find('#inventorySelectOption').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						//turn background back to red
						element.parent().parent().css({
							'background-color':'#f2dede',
							'border-color':'#eed3d7'
						});	

						
						//create a list of errors
						element.parent().parent().find(".addErrorsList").append('<li class="text text-error">Vehicle count is over the limit.</li>');	
						//set check to No. this will ensure that the change reservation button does not appear
						element.parent().parent().attr('check','No');	
					break;
					
					case '4': //both vehicles and passengers are over turn control group to error
						element.parent().parent().find('#inventorySelectOption').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						element.parent().parent().find('#driverInput').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						element.parent().parent().find('#adultInput').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						element.parent().parent().find('#childrenInput').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						element.parent().parent().find('#infantInput').parent().removeClass('warning').removeClass('control-group').addClass('control-group').addClass('error');
						
						//turn background back to red
						element.parent().parent().css({
							'background-color':'#f2dede',
							'border-color':'#eed3d7'
						});			

						//create a list of errors
						element.parent().parent().find(".addErrorsList").append('<li class="text text-error">Passenger count is over the limit.</li>');	
						element.parent().parent().find(".addErrorsList").append('<li class="text text-error">Vehicle count is over the limit.</li>');	
						//set check to No. this will ensure that the change reservation button does not appear
						element.parent().parent().attr('check','No');
						
					break;
				}
				
			}
		);
		
	},
	hotel_request: function(element){ //hotel check
		var reservation_id = element.parents('tr:first').attr('reservation_id');
		var check_in = element.parents('tr:first').find('#hotelCheckIn').val();
		var check_out = element.parents('tr:first').find('#hotelCheckOut').val();
		var hotel_id = element.parents('tr:first').find('.hotelSelect option:selected').val();
		var room_id = element.parents('tr:first').find('.hotelRoomSelect option:selected').val();
		var qty = element.parents('tr:first').find('#roomQty').val();
		var adults = element.parents('tr:first').find('#hotelAdults').val();
		var children = element.parents('tr:first').find('#hotelChildren').val();
		$.post(
			'/hotels/request_edit_check',
			{
				type:'RESERVATION_EDIT_CHECK',
				reservation_id: reservation_id,
				check_in: check_in,
				check_out: check_out,
				hotel_id: hotel_id,
				room_id: room_id,
				room_qty: qty,
				adults: adults,
				children: children,
			},	function(results){
				element.parents('tr:first').next('tr').removeClass('hide');
				element.parents('tr:first').next('tr').find('#showRoomsTd').html($(results).fadeIn());
				
				//grab new elements created from request_edit_check
				var newTotal = element.parents('tr:first').next('tr').find('#requestHotelTotalGross').val();
				var status = element.parents('tr:first').next('tr').find("#requestHotelStatus").val();
				
				
				//show teh change reservation button if the returned status is set to 1
				switch(status){
					case '1': //if status is returned as 1 then this was a successful hotel 
					element.parents('tr:first').find('#hotelCheckIn').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					element.parents('tr:first').find('#hotelCheckOut').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					element.parents('tr:first').find('.hotelSelect').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					element.parents('tr:first').find('.hotelRoomSelect').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					element.parents('tr:first').find('#roomQty').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					element.parents('tr:first').find('#hotelAdults').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					element.parents('tr:first').find('#hotelChildren').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					//turn all elements in tr to success
					element.parents('tr:first').find('td').removeClass('control-group').removeClass('warning').removeClass('error').addClass('control-group').addClass('success');
					element.parents('tr:first').find('td:last-child').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
					element.parents('tr:first').attr('check','Yes');
					element.parents('tr:first').find('.checkHotelButton').attr('disabled','disabled').removeClass('btn-info');			
					element.parents('tr:first').find('#hotelTotal').val(newTotal);	
					element.parents('tr:first').find('td').css({
						'background-color':'#dff0d8',
						'border-color':'#d6e9c6'
					});
					view.counter();	
					break;
					
					default: //else show error message and do not show change reservation button
					element.parents('tr:first').next('tr').find('#resultHotelStatusUl').append('<li class="text text-error">There was an error with your selection.</li>');
					//turn background back to red
					element.parents('tr:first').find('td').css({
						'background-color':'#f2dede',
						'border-color':'#eed3d7'
					});						
					
					break;
				}
			}
		);		
		
		
	
	},
	attraction_request: function(element){
		var reservation_id = element.parents('tr:first').attr('reservation_id');
		var tour_id = element.parents('tr:first').find('.tourSelect option:selected').val();
		var attraction_id =  element.parents('tr:first').find('.attractionSelect option:selected').val();
		var date = element.parents('tr:first').find('#attractionTourDate').val();
		var time_check = element.parents('tr:first').find('.tourSelect option:selected').attr('timed');
		//if this is a timed attraction
		if(time_check =='Yes'){
			var time = element.parents('tr:first').find('.tourSelect option:selected').attr('time');
		} else {
			var time = 'No';
		}
		//get the remaining age_range inventory levels
		age_range = {};
		element.parents('tr:first').find('.attraction_age_group').each(function(ev){
			var age_range_name = $(this).attr('age_range');
			var age_range_value = $(this).val();
			age_range[age_range_name] = {};
			age_range[age_range_name] = age_range_value;
		});

		$.post(
			'/attractions/request_edit_check',
			{
				type:'RESERVATION_EDIT_CHECK',
				reservation_id: reservation_id,
				attraction_id: attraction_id,
				tour_id: tour_id,
				date: date,
				time: time,
				age_range: age_range
			},	function(results){
				//render ajax returned values into the hidden div
				$("#attractionTourDiv").html(results);
				
				//grab new elements created from request_edit_check
				var status = $('#attractionTourDiv #attractionStatus').val();
				var total_gross = $('#attractionTourDiv #attractionTotalGross').val();
				
				
				//show teh change reservation button if the returned status is set to 1
				switch(status){
					case '1': //if status is returned as 1 then this was a successful hotel 
					element.parents('tr:first').find('.attractionTourSelect').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					element.parents('tr:first').find('#attractionTourDate').parent().removeClass('warning').removeClass('error').removeClass('control-group');
					element.parents('tr:first').find('.age_range_group').parent().removeClass('warning').removeClass('error').removeClass('control-group');

					//turn all elements in tr to success
					element.parents('tr:first').find('td').removeClass('control-group').removeClass('warning').removeClass('error').addClass('control-group').addClass('success');
					element.parents('tr:first').find('td:last-child').removeClass('control-group').removeClass('warning').removeClass('error').removeClass('success');
					element.parents('tr:first').attr('check','Yes');
					element.parents('tr:first').find('.checkAttractionButton').attr('disabled','disabled').removeClass('btn-info');			
					element.parents('tr:first').find('#attractionTotal').val(total_gross);	
					element.parent().parent().css({
						'background-color':'#dff0d8',
						'border-color':'#d6e9c6'
					});
					view.counter();	
					break;
					
					default: //else show error message and do not show change reservation button
					element.parents('tr:first').find('.age_range_group').parent().removeClass('warning').removeClass('error').removeClass('control-group').addClass('control-group').addClass('error');
					element.parents('tr:first').next('tr').find('#resultAttractionStatusUl').append('<li class="text text-error">There was an error with your selection.</li>');
					//turn background back to red
					element.parents('tr:first').css({
						'background-color':'#f2dede',
						'border-color':'#eed3d7'
					});						
					
					break;
				}
			}
		);	
		
	}

}

requests = {
	dateTime: function(date, port, element){
		$.post(
			'/reservations/request_get_time',
			{
				type:'RESERVATION_GET_TIME',
				port: port,
				date: date,
			},	function(results){

				setTimeout(function(){
					element.parent().parent().parent().find("#timeSelect").html(results);	
				}, 700);
				
			}
		);  
	},
	getTours: function(index,start, attraction_id, element, tour_selected){
		
		$.post(
			'/attractions/request_backend_attraction_tours',
			{
				index: index,
				start: start,
				attraction_id: attraction_id,
				tour_selected: tour_selected
			},	function(results){
				element.html(results);
		
				//setup javascript for new element
				var element_tours = element.parents('tr:first').find('.tourSelect');
				addScripts.findAgeRange(element_tours);
			}
		); 		
	},
	getAgeRange: function(date, attraction_id, tour_id, element, index, timed_tour, time){
		$.post(
			'/attractions/request_backend_age_range',
			{
				start: date,
				attraction_id: attraction_id,
				tour_id: tour_id,
				index: index,
				timed_tour: timed_tour,
				time: time
			},	function(results){

				element.html(results);
				var element_gross = element.parents('tr:first').find('#attractionTotal');
				element.find('.attraction_age_group').keyup(function(){
					var element_this = $(this);
					addScripts.calculateTotalGrossTour(element_this, element_gross);
				});
				
			}
		); 			
	}
}

addScripts = {
	findAgeRange: function(element){

		element.change(function(){
			//alert('test');
			var start = $(this).parents('tr:first').find('#attractionTourDate').val();
			var attraction_id = $(this).parents('tr:first').find('.attractionSelect').find('option:selected').val();
			var index = $(this).parents('tr:first').find('.attractionSelect').attr('index');
			var tour_id = $(this).find('option:selected').val();
			var old_tour_id = $(this).parents('td:first').attr('old');
			var timed_tour = $(this).find('option:selected').attr('timed');
			
			if(timed_tour == 'No'){
				time = 'No';
			} else {
				var time = $(this).find('option:selected').attr('time');
				$(this).parents('div:first').find('.attractionTourTime').remove();
				var createTimeInput = '<input class="attractionTourTime attractionEditable" edit="Yes" type="hidden" value="'+time+'" name="data[Attraction_reservation]['+index+'][time]"/>'
				$(this).parents('div:first').append(createTimeInput);
			}

			var element_div = $(this).parents('tr:first').find('#attractionAgeGroupDiv');
			//get age_range
			requests.getAgeRange(start, attraction_id, tour_id, element_div, index, timed_tour, time);
			
			/**
			 * Now check for validation 
			 */
			var attraction_id = $(this).parents('tr:first').find('.attractionTourSelect option:selected').attr('attraction_id');
			var tour_id = $(this).parents('tr:first').find('.attractionTourSelect option:selected').val();
			var old_tour_id = $(this).parents('tr:first').find('.attractionTourSelect').attr('old');
			var date = $(this).parents('tr:first').find('attractionTourDate').val();
			var old_date = $(this).parents('tr:first').find('#attractionTourDate').attr('old');
			var time_check = $(this).parents('tr:first').find('#timeSelect').length;
			if(time_check > 0){
				var time= $(this).parents('tr:first').find('#timeSelect option:selected').val();
				var old_time = $(this).parents('tr:first').find("#timeSelect").attr('old');	
			} else {
				var time = 'No';
				var old_time = 'No';
			}
			var changes = 0;
			$(this).parents('tr:first').find('.age_range_group').each(function(){
				var old_qty = $(this).attr('old');
				var qty = $(this).val();
				
				if(qty != old_qty){
					changes ++;
				}
			});

			
			$(this).parents('tr:first').find('.checkAttractionButton').attr('disabled','disabled').removeClass('btn-info');
			if(old_tour_id ==tour_id && old_date == date && old_time == time && changes == 0){
				$(this).parents('td:first').removeClass('control-group').removeClass('error').removeClass('success');
				$(this).parents('tr:first').find('.checkAttractionButton').attr('disabled','disabled');
				$(this).parents('tr:first').find('.checkAttreactionButton').removeClass('btn-info');	
			} else {
				$(this).parents('tr:first').find('td').removeClass('control-group').removeClass('error').removeClass('success').addClass('control-group');
				$(this).parents('td:first').addClass('warning');
				//show check button
				$(this).parents('tr:first').find('.checkAttractionButton').removeAttr('disabled').addClass('btn-info');	
				
			}
			$(this).parents('tr:first').css({
				'background-color':'#fcf8e3'
			});
			
			view.counter();			

			
		});
	},
	calculateTotalGrossTour: function(element, element_gross){

		var total_gross = 0;
		element.parents('tr:first').find('.attraction_age_group').each(function(){
			var qty = parseInt($(this).val());
			var gross = parseFloat($(this).attr('gross'));
			if(gross == ''){
				gross = 0;
			}
			gross = (gross*qty) * 100;
			gross = Math.round(gross) / 100;
			total_gross = total_gross +gross;
		});
		total_gross = total_gross.toFixed(2);
		element_gross.val(total_gross);
	}
}
//functions


var vehicleLi = function(vehicle_id, vehicle_name,ferry_id, idx, inventory_id,item_id, overlength, trip){
	if(trip == 'depart'){
		trip_destination = 'depart_vehicles';
	} else {
		trip_destination = 'return_vehicles';
	}
	var liInput = '<li class="alert alert-info warning" inventory_id="'+inventory_id+'" style="margin-top:3px;margin-bottom:3px;">'+
		'<a href="#" class="removeInventory close" data-dismiss="alert" style="cursor:pointer;">&times;</a>'+
		'<input id="inventory_id" class="editable" type="hidden" value="'+inventory_id+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][inventory_id]" edit="Yes"/>'+
		'<input id="item_id" class="editable" type="hidden" value="'+item_id+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][item_id]" edit="Yes"/>'+
		'<input id="overlength" class="editable" type="hidden" value="'+overlength+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][overlength]" edit="Yes"/>'+
		'<input id="overlength_feet" class="editable" type="hidden" value="0" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][overlength_feet]" edit="Yes"/>'+
		'<input id="vehicle_name" class="editable" type="hidden" value="'+vehicle_name+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][name]" edit="Yes"/><strong>'+vehicle_name+'</strong>'+
		'</li>';
		
	return liInput;
}
var vehicleLiExtra = function(vehicle_id, vehicle_name,ferry_id, idx, inventory_id,item_id, overlength, trip){
	var towed_units = $("#towedUnitsDiv").html();
	if(trip == 'depart'){
		trip_destination = 'depart_vehicles';
	} else {
		trip_destination = 'return_vehicles';
	}	
	var liInput = '<li class="alert alert-info warning" inventory_id="'+inventory_id+'" style="margin-top:3px;margin-bottom:3px;">'+
		'<a href="#" class="removeInventory close" data-dismiss="alert" style="cursor:pointer;">&times;</a>'+
		'<input id="inventory_id" class="editable" type="hidden" value="'+inventory_id+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][inventory_id]" edit="Yes"/>'+
		'<input id="item_id" class="editable" type="hidden" value="'+item_id+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][item_id]" edit="Yes"/>'+
		'<input id="overlength" class="editable" type="hidden" value="'+overlength+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][overlength]" edit="Yes"/>'+
		'<input id="vehicle_name" class="editable" type="hidden" value="'+vehicle_name+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][name]" edit="Yes"/><strong>'+vehicle_name+'</strong>'+
		'<div class="control-group" style="margin-bottom:0px;">'+
		'<label>Towed Units</label>'+
		'<select class="editable" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][towed_units]" edit="Yes">'+towed_units+'</select>'+
		'</div>'+
		'<div class="control-group"><div class="input-append">'+
		'<label>Overlength</label>'+
		'<input id="overlength_feet" class="editable" type="text" value="0" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][overlength_feet]" placeholder="overlength" style="width:50px" edit="Yes"/>'+
		'<span class="add-on">Feet</span>'+
		'</div><span class="help-block"></span></div>'+
		'</li>';
		
	return liInput;	
}

var motorcycleLi = function(vehicle_id, vehicle_name,ferry_id, idx, inventory_id,item_id, overlength, trip){
	if(trip == 'depart'){
		trip_destination = 'depart_vehicles';
	} else {
		trip_destination = 'return_vehicles';
	}
	var liInput = '<li class="alert alert-info warning" inventory_id="'+inventory_id+'" style="margin-top:3px;margin-bottom:3px;">'+
		'<a href="#" class="removeInventory close" data-dismiss="alert" style="cursor:pointer;">&times;</a>'+
		'<input id="inventory_id" class="editable" type="hidden" value="'+inventory_id+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][inventory_id]" edit="Yes"/>'+
		'<input id="item_id" class="editable" type="hidden" value="'+item_id+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][item_id]" edit="Yes"/>'+
		'<input id="overlength" class="editable" type="hidden" value="'+overlength+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][overlength]" edit="Yes"/>'+
		'<input id="overlength_feet" class="editable" type="hidden" value="0" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][overlength_feet]" edit="Yes"/>'+
		'<input id="vehicle_name" class="editable" type="hidden" value="'+vehicle_name+'" name="data[Ferry_reservation]['+ferry_id+']['+trip_destination+']['+idx+'][name]" edit="Yes"/><strong>'+vehicle_name+'</strong>'+
		'</li>';
		
	return liInput;	
}
