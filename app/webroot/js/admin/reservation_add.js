$(document).ready(function(){
	reservations.datepicker();
	reservations.events();
});

reservations = {
	datepicker: function(){
		$("#departDate").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
			var date = $(this).val();
  			$(this).datepicker('hide');
  			$("#returnDate").val(date);
  			
  			//depart time selection
  			var element = $(this).parents('.accordion-group:first');
  			reservations.ferryCheck(element);
		});
		$("#returnDate").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
			
			//return time selection
			var element = $(this).parents('.accordion-group:first');
			reservations.ferryCheck(element);
		});
		$("#hotelCheckIn").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
		});
		$("#hotelCheckOut").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
		});
		$("#tourDate").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
		});
		$("#packageDateOfTravel").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
  			
  			//get the packages based on this date
  			var start = new Date($(this).val()).getTime() /1000;
  			$("#packageSelect").html('');
  			$("#packageSelect").append('<option>Searching for packages...</option>');
  			setTimeout(function(){
  				var count = 0;
 	  			$('#packageSelection').find('option').each(function(){
	  				var p_start = $(this).attr('start');
	  				var p_end = $(this).attr('end');
	  				
	  				if(start >= p_start && start <= p_end){
	  					count++;
	  				}
	  			}); 	
	  					
	  			if(count>0){
		  			$("#packageSelect").html('');
		  			$("#packageSelect").append('<option value="none">'+count+' packages found.</option>');
		  			$('#packageSelection').find('option').each(function(){
		  				var p_start = $(this).attr('start');
		  				var p_end = $(this).attr('end');
		  				
		  				if(start >= p_start && start <= p_end){
		  					var optionClone = $(this).clone();		  					
		  					$('#packageSelect').append(optionClone);
		  				}
		  			}); 	  				
	  			} else {
					$("#packageSelect").append('<option>No packages found.</option>');	  				
	  			}	
  				
  				
 				
  			},1000);

		});
	}, 
	ferryCheck: function(element){ //checks for ferry dates
		var inventory_id = element.find(".inventoryCheck:checked").val();
		var port = element.find(".departSelect option:selected").val();
		var return_port = element.find(".returnSelect option:selected").val();
		var trip = element.find(".tripType:checked").val();
			
		switch(trip){
			case 'roundtrip': //roundtrip
			

			var depart_date = element.find("#departDate").val();
			var return_date = element.find("#returnDate").val();	

			var d = new Date(depart_date).getTime() / 1000;
			var r = new Date(return_date).getTime() / 1000;	
			
			if(d ==''){ //if depart is missing
				element.find("#departDate").parent().parent().addClass('error');
				element.find("#departDate").parent().parent().find('.help-block').html('Please select a depart date');
			} else { //clear errors if good
				element.find("#departDate").parent().parent().removeClass('error');
				element.find("#departDate").parent().parent().find('.help-block').html('');				
			}
			if(r ==''){ //if return is missing
				element.find("#returnDate").parent().parent().addClass('error');
				element.find("#returnDate").parent().parent().find('.help-block').html('Please select a depart date');				
			} else { //if return is good
				element.find("#returnDate").parent().parent().removeClass('error');
				element.find("#returnDate").parent().parent().find('.help-block').html('');						
			}
			if(d > r){ //if depart is greater than return
				element.find("#departDate").parent().parent().addClass('error');
				element.find("#departDate").parent().parent().find('.help-block').html('Depart date cannot be greater than return date');				
			} else { //if depart is equal or less than return
				element.find("#departDate").parent().parent().removeClass('error');
				element.find("#departDate").parent().parent().find('.help-block').html('');						
			}
			if(d != '' && r != '' && d <= r){ //if all is good then send 
				element.find("#departDate").parent().parent().removeClass('error');
				element.find("#departDate").parent().parent().find('.help-block').html('');	
				element.find("#returnDate").parent().parent().removeClass('error');
				element.find("#returnDate").parent().parent().find('.help-block').html('');		
				
				switch(inventory_id){
					case '2':

						var vehicle_types = {};
						
						element.find("#vehicleOverlengthOl li").each(function(ev){
							var item_id = $(this).find('.packagesInventorySelect option:selected').val();
							overlength = 18;
							if($(this).find('.overlengthInput').is('*')){
								var overlength = $(this).find('.overlengthInput').val();
								if(overlength == ''){
									overlength = 18;
								}								
							} 

							
							vehicle_types[ev] = {};
							vehicle_types[ev]['overlength'] = overlength; 
						});					

						requests.ajaxTimeLabelOverlengthDepart(element, depart_date, '2', port,vehicle_types);
						requests.ajaxTimeLabelOverlengthReturn(element, return_date, '2', return_port,vehicle_types);					
			
					break;
					
					case '1':
						requests.ajaxTimeLabelDepart(element, depart_date,'1',port);
						requests.ajaxTimeLabelReturn(element, return_date,'1',return_port);					
					break;
					
					case '3':
						requests.ajaxTimeLabelDepart(element, depart_date,'3',port);
						requests.ajaxTimeLabelReturn(element, return_date,'3',return_port);						
					break;
					
					case '4':
						requests.ajaxTimeLabelDepart(element, depart_date,'4',port);
						requests.ajaxTimeLabelReturn(element, return_date,'4',return_port);						
					break;
				}				

			}
			
			break;
			
			default: //oneway
			var depart_date = element.find("#departDate").val();
			var d = new Date(depart_date).getTime() / 1000;

			
			if(d ==''){ //if depart is missing
				element.find("#departDate").parent().parent().addClass('error');
				element.find("#departDate").parent().parent().find('.help-block').html('Please select a depart date');			
			} else { //clear errors if good
				element.find("#departDate").parent().parent().removeClass('error');
				element.find("#departDate").parent().parent().find('.help-block').html('');		
				switch(inventory_id){
					case '2':

						var vehicle_types = {};
						
						element.find("#vehicleOverlengthOl li").each(function(ev){
							var item_id = $(this).find('.packagesInventorySelect option:selected').val();
							overlength = 18;
							switch(item_id){
								case '23':
								
								break;
								
								default:
								
								break;
							}
							if($(this).find('.overlengthInput').is('*')){
								var overlength = $(this).find('.overlengthInput').val();
								if(overlength == ''){
									overlength = 18;
								}								
							} 

							
							vehicle_types[ev] = {};
							vehicle_types[ev]['overlength'] = overlength; 
						});					

						requests.ajaxTimeLabelOverlengthDepart(element, depart_date, '2', port,vehicle_types);
							
					break;
					
					case '1':
						requests.ajaxTimeLabelDepart(element, depart_date,'1',port);
					
					break;
					
					case '3':
						requests.ajaxTimeLabelDepart(element, depart_date,'3',port);
						
					break;
					
					case '4':
						requests.ajaxTimeLabelDepart(element, depart_date,'4',port);
				
					break;
				}								
			}
			break;
		}

	},
	events: function(){
		//initial page load scripts
		requests.getInventoryItems('2');
		
		
	
		$(".inventoryCheck").click(function(){
			var checked = $(this).attr('value');
			var top = $(this).parents('.accordion-group:first');
			
			var freshSelectOpts = inventoryOptions();
			requests.getInventoryItems(checked);
			// top.find(".packagesInventorySelect optgroup").remove();
			// top.find(".packagesInventorySelect").html(freshSelectOpts);
			switch(checked){
				case '2':
					top.find("#vehicleDiv").removeClass('hide');
					top.find("#driversDiv").removeClass('hide');
					top.find("#driversDiv input").removeAttr('disabled');
					top.find("#extraAdultsDiv").removeClass('hide');
					top.find("#adultsDiv").addClass('hide');
					top.find("#adultsDiv input").attr('disabled','disabled');
					top.find("#extraAdultsDiv input").removeAttr('disabled');
					top.find(".packagesInventorySelect optgroup[inventory_id !='2']").remove();
				break;
				
				case '1':
					top.find("#vehicleDiv").addClass('hide');
					top.find("#driversDiv").addClass('hide');
					top.find("#driversDiv input").attr('disabled','disabled');
					top.find("#extraAdultsDiv").addClass('hide');
					top.find("#extraAdultsDiv input").attr('disabled','disabled');
					top.find("#adultsDiv").removeClass('hide');
					top.find("#adultsDiv input").removeAttr('disabled');
					
					top.find(".packagesInventorySelect optgroup[inventory_id !='1']").remove();
				break;
				
				case '3':
					top.find("#vehicleDiv").removeClass('hide');
					top.find("#driversDiv").addClass('hide');
					top.find("#driversDiv input").attr('disabled','disabled');
					top.find("#extraAdultsDiv").addClass('hide');
					top.find("#extraAdultsDiv input").attr('disabled','disabled');
					top.find("#adultsDiv").removeClass('hide');
					top.find('#adults').removeAttr('disabled');
					top.find("#adultsDiv input").removeAttr('disabled');
					
					top.find(".packagesInventorySelect optgroup[inventory_id  !='3']").remove();
				break;
				
				case '4':
					top.find("#vehicleDiv").removeClass('hide');
					top.find("#driversDiv").addClass('hide');
					top.find("#driversDiv input").attr('disabled','disabled');
					top.find("#extraAdultsDiv").addClass('hide');
					top.find("#extraAdultsDiv input").attr('disabled','disabled');
					top.find("#adultsDiv").removeClass('hide');
					top.find('#adults').removeAttr('disabled');
					top.find("#adultsDiv input").removeAttr('disabled');		
					
					top.find(".packagesInventorySelect optgroup[inventory_id !='4']").remove();
				break;
			}
			reservations.ferryCheck(top);
		});
		
		$(".departSelect").change(function(){
			var selected = $(this).find('option:selected').val();
			var top = $(this).parents('.accordion-group');
			switch(selected){
				case 'Port Angeles':
					$(".returnSelect").find('option[value="Victoria"]').attr('selected','selected');
					
				break;
				
				default:
					$(".returnSelect").find('option[value="Port Angeles"]').attr('selected','selected');
				break;
			}
			reservations.ferryCheck(top);
		});
		
		$(".returnSelect").change(function(){
			var selected = $(this).find('option:selected').val();
			var top = $(this).parents('.accordion-group');
			switch(selected){
				case 'Port Angeles':
					$(".departSelect").find('option[value="Victoria"]').attr('selected','selected');
				break;
				
				default:
					$(".returnSelect").find('option[value="Port Angeles"]').attr('selected','selected');
				break;
			}
			reservations.ferryCheck(top);
		});
		
		$(".tripType").click(function(){
			var trip = $(this).val();
			switch(trip){
				case 'roundtrip':
					$("#ferryReturnDiv").removeClass('hide');
				break;
				
				default:
					$("#ferryReturnDiv").addClass('hide');
				break;
			}
		});
		
		$(".changeVehicleCount").click(function(){
			var ol = $(this).parents('#vehicleDiv').find('ol');
			var count = parseInt($(this).parent().find('#vehicle_count').val());
			var grabTop = $(this).parents('#vehicleDiv').find('li[row="top"]');
			var notTop = $(this).parents('#vehicleDiv').find('ol li:not([row="top"])');
			notTop.remove();
			$(this).parents('#vehicleDiv').find('ol li:not(:first)').remove();
			
			for (var i=1; i < count; i++) {
				grabTop.clone().appendTo(ol);

				ol.find('li:last').removeAttr('row');
				var element = ol.find('li:last').find('.packagesInventorySelect');
				addScripts.inventorySelect(element);
				

			};
			
			var ferry_index =$('#ferry_index').val();		

			ol.find('li').each(function(ev){

				//alert(count+' '+index);
				//reindex the inputs
				$(this).find('.packagesInventorySelect').attr('name','data[Reservation]['+ferry_index+'][vehicle]['+ev+'][inventory_item_id]');
				$(this).find('.overlengthInput').attr('name','data[Reservation]['+ferry_index+'][vehicle]['+ev+'][overlength]');
				$(this).find('.towed_units').attr('name','data[Reservation]['+ferry_index+'][vehicle]['+ev+'][towed_unit]');				
			})
		});
		
		$(".packagesInventorySelect").change(function(){
			var vehicle = $(this).find('option:selected').val();

			
			switch(vehicle){
				case '23':
					$(this).parents('li:first').find('#overlengthDiv').fadeIn();
					$(this).parents('li:first').find('#towedUnitsDiv').fadeIn();				
				break;
				
				default:
					$(this).parents('li:first').find('#overlengthDiv').hide();
					$(this).parents('li:first').find('#towedUnitsDiv').hide();
				break;
			}
		});
		
		$("#ferrySavePlusAddButton").click(function(){
			//validate and send
			
			//change form action to save plus add method
			$(this).parents('form:first').attr('action','/reservations/processing_ferry_backend_continue');
			//submit form
			$(this).parents('form:first').submit();
		});
		
		/**
		 * Hotels
		 */
		$("#hotelSelect").change(function(){

			var max_age = parseInt($(this).find('option:selected').attr('max_age'))+1;
			var adults = '(Ages '+max_age+'+)';
			var children = '(Under '+max_age+')';
			
			$("#hotelAdultSpan").html(adults);
			$("#hotelChildrenSpan").html(children);
			
		});
		
		$("#searchHotelRoom").click(function(){
			var hotel_id =$("#hotelSelect").find('option:selected').val();
			var start = $("#hotelCheckIn").val();
			var end = $("#hotelCheckOut").val();
			var arrival = Math.round((new Date(start)).getTime() / 1000);
			var departure = Math.round((new Date(end)).getTime() / 1000);
			var adults = $("#hotel_adults").val();
			var children = $("#hotel_children").val();
			var rooms = $("#hotel_room_count").val();
			
			$("#hotelSaveToCart").attr('disabled','disabled');
			$("#hotelFinishToCart").attr('disabled','disabled');
			
			if(children == '' || children == '0'){
				children = 'zero';
			}
			
			if(adults == '' || adults == '0'){
				$("#hotel_adults").parent().addClass('error');
				$("#hotel_adults").parent().find('.help-block').html('Cannot be zero value');
			} else {
				$("#hotel_adults").parent().removeClass('error');
				$("#hotel_adults").parent().find('.help-block').html('');			
					
			}
			if(start == ''){
				$("#hotelCheckIn").parent().parent().addClass('error');
				$("#hotelCheckIn").parent().parent().find('.help-block').html('No date selected');
			} else {
				$("#hotelCheckIn").parent().parent().removeClass('error');
				$("#hotelCheckIn").parent().parent().find('.help-block').html('');				
			}
			if(end == ''){
				$("#hotelCheckOut").parent().parent().addClass('error');
				$("#hotelCheckOut").parent().parent().find('.help-block').html('No date selected');				
			}

			if(end != '' && parseInt(arrival) == parseInt(departure)){
				$("#hotelCheckOut").parent().parent().addClass('error');
				$("#hotelCheckOut").parent().parent().find('.help-block').html('cannot be the same as arrival');					
			} 
			if(end != '' && parseInt(arrival) > parseInt(departure)){
				$("#hotelCheckOut").parent().parent().addClass('error');
				$("#hotelCheckOut").parent().parent().find('.help-block').html('cannot be before arrival');					
			} 
			if(start != '' & end != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure)){
				$("#hotelCheckOut").parent().parent().removeClass('error');
				$("#hotelCheckOut").parent().parent().find('.help-block').html('');					
			}
			if(parseInt(rooms) > parseInt(adults)){
				$("#hotel_room_count").parent().addClass('error');
				$("#hotel_adults").parent().addClass('error');
				$("#hotel_adults").parent().find('.help-block').html('Not enough adults compared to rooms');
			} else {
				$("#hotel_room_count").parent().removeClass('error');
				$("#hotel_adults").parent().removeClass('error');
				$("#hotel_adults").find('.help-block').html('');				
			}
			
			//if all of the validation approves get hotel rooms
			if(start != '' & end != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure) && adults != '' && parseInt(adults) > 0 && parseInt(rooms) <= parseInt(adults)){
				//function to get hotel rooms
				requests.getHotelRooms(hotel_id, arrival, departure,rooms, adults, children);
			}
		});
		
		$("#hotelSaveToCart").click(function(){
			//do validation here
			
			//change the form to save to cart
			$(this).parents('form:first').attr('action','/reservations/processing_hotel_backend_continue');
			$(this).parents('form:first').submit();
		});
		
		$("#searchTours").click(function(){
			var attraction_id =$("#attractionSelect").find('option:selected').val();
			var start = $("#tourDate").val();

			var arrival = Math.round((new Date(start)).getTime() / 1000);
			
			//place disabled attribute to book tour buttons
			$("#attractionSaveToCart").attr('disabled','disabled');
			$("#attractionSaveToFinish").attr('disabled','disabled');
			
			//start validation
			if(start == ''){
				$("#tourDate").parent().parent().addClass('error');
				$("#tourDate").parent().parent().find('.help-block').html('No date selected');
			} else {
				$("#tourDate").parent().parent().removeClass('error');
				$("#tourDate").parent().parent().find('.help-block').html('');				
			}

			
			//if all of the validation approves get hotel rooms
			if(start != '' && parseInt(arrival) != ''){
				//function to get hotel rooms
				requests.getTours(attraction_id, arrival);
			}

		});
		$("#attractionSaveToCart").click(function(){
			//do validation here
			
			//change the form to save to cart
			$(this).parents('form:first').attr('action','/reservations/processing_attraction_backend_continue');
			$(this).parents('form:first').submit();			
		});
		
		//packages
		$("#packageSelect").change(function(){
			var package_id = $(this).find('option:selected').val();
			var start_date = $("#packageDateOfTravel").val();
			requests.getPackage(package_id,start_date);
		});
		

		
		$(".icon-calendar").parent().click(function(){

			$(this).parent().find('input').focus();
			$(this).parent().find('input').select();
		});
	}
	
}


packages = {
		
	datePicker: function(){
		cutoff = parseInt($("#start").attr('cutoff')) / 86400;
		var start_date = new Date($("#package_start").val());
		var end_date = new Date($("#package_end").val());
		
		var check_start = start_date.getTime() / 1000;
		var today = new Date().getTime() / 1000;

		if(check_start > today){
			start = start_date;
		} else {
			start = 0;
		}


		$("#hotel_start").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
			var nights = $('#hotel_nights').val();
			package_addScripts.changeFerryDates(start, nights);		
			$("#roomUl").html('');
			$("#searchRooms").click();	
			packages.ferryCheck();	
		});		
		$("#package_ferry_start").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
  			var selected_date = $(this).val();
			changeDatePicker(selected_date);
			packages.ferryCheck();
			summary.all();
		});	
		
		$("#package_ferry_end").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
  			var selected_date = $(this).val();
			changeDatePicker(selected_date);
			packages.ferryCheck();
		});	
		$("#packageTourDate").datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
			
			//return time selection
			var element = $(this).parents('.accordion-group:first');
			reservations.ferryCheck(element);
		});	
		$(".icon-calendar").parent().click(function(){

			$(this).parent().find('input').focus();
			$(this).parent().find('input').select();
		});			
		
	}, 
	ferryCheck: function(){
		var item_id = $("#transportationSelect option:selected").val();
		var port = $("#portSelected option:selected").val();
		switch(port){
			case 'Port Angeles':
				return_port = 'Victoria';
			break;
			
			case 'Victoria':
				return_port = 'Port Angeles';
			break;
		}
		var trip = $(".roundTripCheck:checked").val();
				
		switch(trip){
			case 'Yes': //roundtrip
			var depart_date = $("#package_ferry_start").val();
			var return_date = $("#package_ferry_end").val();		
			var d = new Date(depart_date).getTime() / 1000;
			var r = new Date(return_date).getTime() / 1000;	
			
			if(d ==''){ //if depart is missing
				$("#package_ferry_start").parent().parent().addClass('error');
				$("#package_ferry_start").parent().parent().find('.help-block').html('Please select a depart date');
			} else { //clear errors if good
				$("#package_ferry_start").parent().parent().removeClass('error');
				$("#package_ferry_start").parent().parent().find('.help-block').html('');				
			}
			if(r ==''){ //if return is missing
				$("#package_ferry_end").parent().parent().addClass('error');
				$("#package_ferry_end").parent().parent().find('.help-block').html('Please select a depart date');				
			} else { //if return is good
				$("#package_ferry_end").parent().parent().removeClass('error');
				$("#package_ferry_end").parent().parent().find('.help-block').html('');						
			}
			if(d > r){ //if depart is greater than return
				$("#package_ferry_start").parent().parent().addClass('error');
				$("#package_ferry_start").parent().parent().find('.help-block').html('Depart date cannot be greater than return date');				
			} else { //if depart is equal or less than return
				$("#package_ferry_start").parent().parent().removeClass('error');
				$("#package_ferry_start").parent().parent().find('.help-block').html('');						
			}
			if(d != '' && r != '' && d <= r){ //if all is good then send 
				$("#package_ferry_start").parent().parent().removeClass('error');
				$("#package_ferry_start").parent().parent().find('.help-block').html('');	
				$("#package_ferry_end").parent().parent().removeClass('error');
				$("#package_ferry_end").parent().parent().find('.help-block').html('');						
				switch(item_id){
					case '19':
						package_requests.ajaxTimeLabelDepart(depart_date,'1',port);
						package_requests.ajaxTimeLabelReturn(return_date,'1',return_port);
					break;
					case '22':
						package_requests.ajaxTimeLabelDepart(depart_date,'2',port);
						package_requests.ajaxTimeLabelReturn(return_date,'2',return_port);					
					break;
					
					case '23':
						vehicle_types = {};
						var overlength = $('#overlengthInput').val();
						if(overlength == ''){
							overlength = 18;
						}
						vehicle_types[0] = {};
						vehicle_types[0]['overlength'] = overlength; 

						package_requests.ajaxTimeLabelOverlengthDepart(depart_date, '2', port,vehicle_types);
						package_requests.ajaxTimeLabelOverlengthReturn(return_date, '2', return_port,vehicle_types);					
					break;
					case '28':
						package_requests.ajaxTimeLabelDepart(depart_date,'4',port);
						package_requests.ajaxTimeLabelReturn(return_date,'4',return_port);						
					break;
					default:
						package_requests.ajaxTimeLabelDepart(depart_date,'3',port);
						package_requests.ajaxTimeLabelReturn(return_date,'3',return_port);					
					break;
				}
			}
			
			break;
			
			default: //oneway
			var depart_date = $("#package_ferry_start").val();
			var d = new Date(depart_date).getTime() / 1000;

			
			if(d ==''){ //if depart is missing
				$("#package_ferry_start").parent().parent().addClass('error');
				$("#package_ferry_start").parent().parent().find('.help-block').html('Please select a depart date');			
			} else { //clear errors if good
				$("#package_ferry_start").parent().parent().removeClass('error');
				$("#package_ferry_start").parent().parent().find('.help-block').html('');		
				switch(item_id){
					case '19':
						package_requests.ajaxTimeLabelDepart(depart_date,'1',port);
					break;
					case '22':
						package_requests.ajaxTimeLabelDepart(depart_date,'2',port);
					break;
					
					case '23':
						vehicle_types = {};
						var overlength = $('#overlengthInput').val();
						if(overlength == ''){
							overlength = 18;
						}
						vehicle_types[0] = {};
						vehicle_types[0]['overlength'] = overlength; 
						

						package_requests.ajaxTimeLabelOverlengthDepart(depart_date, '2', port,vehicle_types);					
					break;
					
					case '28':
						package_requests.ajaxTimeLabelDepart(depart_date,'3',port);
					break;
					
					default:
						package_requests.ajaxTimeLabelDepart(depart_date,'4',port);
					break;
				}				
			}
			break;
		}

	},
	events: function(){
		$(".inventoryCheck").click(function(){
			var type = $(this).val();
			if(type =='vehicle'){
				
				$("#inventoryDiv").show();
			} else {
				$("#inventoryDiv").hide();
				
			}
		});
		
		$("#portSelected").change(function(){
			packages.ferryCheck();
			summary.all();
		});
		
		$('#extraAdults').blur(function(){
			packages.ferryCheck();
			summary.all();
		});
		
		$("#adults").blur(function(){
			packages.ferryCheck();
			summary.all();
		});
		
		$("#children").blur(function(){
			packages.ferryCheck();
			summary.all();
		});
		
		$("#infants").blur(function(){
			packages.ferryCheck();
			summary.all();
		});
		$("#overlengthInput").blur(function(){
			packages.ferryCheck();
			summary.all();
		});
		$(".roundTripCheck").click(function(){
			var type = $(this).val();
			if(type == 'Yes'){
				$("#ferryEndSumDiv").show();
				$(".formPackage #returnTable").show();
			} else {
				
				$("#ferryEndSumDiv").hide();
				$(".formPackage #returnTable").hide();
				$("#packageScheduleId2").val('');
			}
			//packages.ferryCheck();
			summary.all();
		});
		$("#hotel_nights").live('blur',function(){
			var start = $('#hotel_start').val();
			var nights = $(this).val();
			
			$("#roomUl").html('');

			package_addScripts.changeFerryDates(start, nights);		
			
			$("#searchRooms").click();

		});
		
		$('#hotel_rooms').change(function(){
			$("#roomUl").html('');
			
			$("#searchRooms").click();

		});
		
		$("#hotel_adults").blur(function(){
			$("#roomUl").html('');
			
			$("#searchRooms").click();

		});
		
		$("#hotel_children").blur(function(){
			$("#roomUl").html('');
			
			$("#searchRooms").click();
		
		});
		
		$("#searchRooms").click(function(){
			var hotel_id =$("#hotel_id").val();
			var start = $("#hotel_start").val();
			var nights = parseInt($("#hotel_nights").val());
			var arrival = Math.round((new Date(start)).getTime() / 1000);
			var departure = (nights * 86400) + arrival;
			var adults = $("#hotel_adults").val();
			var children = $("#hotel_children").val();
			var rooms = $("#hotel_rooms").find('option:selected').val();
			
			if(children == '' || children == '0'){
				children = 'zero';
			}
			
			if(adults == '' || adults == '0'){
				$("#hotel_adults").parent().addClass('error');
				$("#hotel_adults").parent().find('.help-block').html('Cannot be zero value');
			} else {
				$("#hotel_adults").parent().removeClass('error');
				$("#hotel_adults").parent().find('.help-block').html('');			
					
			}
			if(start == ''){
				$("#hotel_start").parent().parent().addClass('error');
				$("#hotel_start").parent().parent().find('.help-block').html('No date selected');
			} else {
				$("#hotel_start").parent().parent().removeClass('error');
				$("#hotel_start").parent().parent().find('.help-block').html('');				
			}
			if(nights == ''){
				$("#hotel_nights").parent().addClass('error');
				$("#hotel_nights").parent().find('.help-block').html('Nights must be 1 or greater');				
			} else {
				$("#hotel_nights").parent().removeClass('error');
				$("#hotel_nights").parent().find('.help-block').html('');				
			}

			if(nights != '' && parseInt(arrival) == parseInt(departure)){
				$("#hotel_nights").parent().addClass('error');
				$("#hotel_nights").parent().find('.help-block').html('cannot be the same as arrival');					
			} 
			if(nights != '' && parseInt(arrival) > parseInt(departure)){
				$("#hotel_nights").parent().addClass('error');
				$("#hotel_nights").parent().find('.help-block').html('cannot be before arrival');					
			} 
			if(start != '' & nights != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure)){
				$("#hotel_nights").parent().removeClass('error');
				$("#hotel_nights").parent().find('.help-block').html('');					
			}
			// if(parseInt(rooms) > parseInt(adults)){
				// $("#hotel_rooms").parent().addClass('error');
				// $("#hotel_adults").parent().addClass('error');
				// $("#hotel_adults").parent().find('.help-block').html('Not enough adults compared to rooms');
			// } else {
				// $("#hotel_rooms").parent().removeClass('error');
				// $("#hotel_adults").parent().removeClass('error');
				// $("#hotel_adults").find('.help-block').html('');				
			// }
			
			//if all of the validation approves get hotel rooms
			if(start != '' & nights != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure) && adults != '' && parseInt(adults) > 0 ){
				//function to get hotel rooms
				package_requests.getHotelRooms(hotel_id, arrival, departure,rooms, adults, children);

			}
			
		});
		
		//form submission
		$("#addToCart").click(function(){
			packages.validate();
		});
		//attraction selection
		$(".selectAttractionTour").click(function(){
			var attraction_id =$("#packageAttractionSelect").find('option:selected').val();
			var start = $(this).parents('.form-actions:first').find('#packageTourDate').val();
			var start = new Date(start).getTime() / 1000;


			if(start == ''){
				$("#packageTourDate").parent().parent().addClass('error');
				$("#packageTourDate").parent().parent().find('.help-block').html('No date selected');
			} else {
				$("#packageTourDate").parent().parent().removeClass('error');
				$("#packageTourDate").parent().parent().find('.help-block').html('');				
			}
			
			//if all of the validation approves get hotel rooms
			if(start != ''){

				//function to get hotel rooms
				package_requests.getTours(attraction_id, start);
			}

		});
		
		//if attraction has not been selected
		$("#packageAttractionSelect").change(function(){
			selected = $(this).find('option:selected').val();
			if(selected =='No'){
				$("#toursAvailable").html('');
			}
		});
	
		$('#transportationSelect').change(function(){
			var selected = $(this).find('option:selected').val();
			
			switch(selected){
				case '22': //standard vehicle
					$(".formPackage #overlengthDiv").addClass('hide');
					$(".formPackage #overlengthDiv input").attr('disabled','disabled');	
					$(".formPackage #driversDiv").removeClass('hide');
					$(".formPackage #addtlAdultsDiv").removeClass('hide');
					$(".formPackage #addtlAdultsDiv input").removeAttr('disabled').val('1');
					$(".formPackage #driversDiv input").removeAttr('disabled').val('1');
					$(".formPackage #adultsDiv").addClass('hide');
					$(".formPackage #adultsDiv input").attr('disabled','disabled').addClass('hide').val('0');
					packages.ferryCheck();		
				break;
				
				case '23': //overlength vehicle
					$(".formPackage #overlengthDiv").removeClass('hide');
					$(".formPackage #overlengthDiv input").removeAttr('disabled');		
					$(".formPackage #driversDiv").removeClass('hide');
					$(".formPackage #addtlAdultsDiv").removeClass('hide');
					$(".formPackage #addtlAdultsDiv input").removeAttr('disabled').val('1');
					$(".formPackage #driversDiv input").removeAttr('disabled').val('1');
					$(".formPackage #adultsDiv input").attr('disabled','disabled').val('0');
					$(".formPackage #adultsDiv").addClass('hide');		
					
					packages.ferryCheck();			
				break;
				
				default:
					$(".formPackage #overlengthDiv").addClass('hide');
					$(".formPackage #overlengthDiv input").attr('disabled','disabled');	
					$(".formPackage #driversDiv").addClass('hide');
					$(".formPackage #addtlAdultsDiv").addClass('hide');
					$(".formPackage #addtlAdultsDiv input").attr('disabled','disabled').val('0');
					$(".formPackage #adultsDiv").removeClass('hide');	
					$(".formPackage #driversDiv input").attr('disabled','disabled').val('0');
					$(".formPackage #adultsDiv input").removeAttr('disabled').val('2');
					packages.ferryCheck();			
				break;
			}

			
		});
		
		$("#packagesSaveToCart").click(function(){
			//do validation here
			var errors = validation.package();
			
			if(errors ==0){
				//change the form to save to cart
				$(this).parents('form:first').attr('action','/reservations/processing_package_backend_continue');
				$(this).parents('form:first').submit();		
			} else {
				alert('There are '+errors+' errors with your package please make sure all form fields are correctly filled out');
			}		
		});
		
		
	}		

}
validation = {
	ferry: function(element){
		var errors = 0;
 		var count_depart_time = element.find("#packageFormDiv #departTable tbody tr[status='selected']").length;
		var count_return_time = $("#packageFormDiv #returnTable tbody tr[status='selected']").length;		
		
	},
	package: function(){
		var trip_type = $(".roundTripCheck[checked='checked']").val();
		
		var errors = 0;
		var count_depart_time = $("#packageFormDiv #departTable tbody tr[status='selected']").length;
		var count_return_time = $("#packageFormDiv #returnTable tbody tr[status='selected']").length;
		if(count_depart_time == 0){
			 $("#packageFormDiv #departTableDiv").addClass('error');
			 $("#packageFormDiv #departTableDiv .help-block").html('You must select a departure time');
			  $("#packageFormDiv #departTableDiv #departTable tr").css({
			  	'color':'red',	  	
			  });
			 errors++;
		} else {
			 $("#packageFormDiv #departTableDiv").removeClass('error');
			 $("#packageFormDiv #departTableDiv .help-block").html('');	
			  $("#packageFormDiv #departTableDiv #departTable tr").removeAttr('style');
		}
		if(trip_type == 'Yes'){
			if(count_return_time == 0){
				 $("#packageFormDiv #returnTableDiv").addClass('error');
				 $("#packageFormDiv #returnTableDiv .help-block").html('You must select a departure time');
				  $("#packageFormDiv #returnTableDiv #returnTable tr").css({
				  	'color':'red',	  	
				  });	
				 errors++;		
			} else {
				 $("#packageFormDiv #returnTableDiv").removeClass('error');
				 $("#packageFormDiv #returnTableDiv .help-block").html('');	
				  $("#packageFormDiv #returnTableDiv #returnTable tr").removeAttr('style');			
			}
		}
		// alert(count_depart_time+' '+count_return_time);
		
		
		
		return errors;
	}
}
filter = {

	byLocation: function(location){
		switch(location){
			case 'All':
				$(".byLocation:not(value='All)").removeAttr('checked');
				$(".byLocation[value='All']").attr('checked','checked');
			break;
			
			default:
				$(".byLocation[value='All']").removeAttr('checked');
			break;
		}

	}, 
	filterResults: function(){
		//first hide all of the list items on both featured and non featured
		$("#featuredUl li").hide();
		$("#nonfeaturedUl li").hide();
		
		
		//next get list item type
		var type = $(".byType:checked").val();		
		//next get star rating
		var starRating = parseFloat($(".byRating").find('option:selected').val());

		//starting price
		

		var citySelected = new Array();
		//then get the location
		$(".byLocation").each(function(en){
			
			var location = $(this).val();
			var checked = $(this).attr('checked');
			
			if(checked == 'checked'){
				if(location == 'All'){
					//show all 
					$('#featuredUl li').each(function(){
						var liType = $(this).attr('type');
						var liRating = parseFloat($(this).attr('rating'));
						if(isNaN(liRating)){
							liRating = 0;
						}
						switch(type){
							case 'both':
								if(liRating <= starRating){
									$(this).fadeIn();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating){
									$(this).fadeIn();
								}								
							break;
						}						

					});
					$('#nonfeaturedUl li').each(function(){
						var liType = $(this).attr('type');
						var noliRating = parseFloat($(this).attr('rating'));
						if(isNaN(noliRating)){
							noliRating = 0;
						}
						
						switch(type){
							case 'both':
								if(noliRating <= starRating){
									
									$(this).fadeIn();
								}								
							break;
							
							default:
								if(liType == type && noliRating <= starRating){
									$(this).fadeIn();
								}								
							break;
						}						

					});
					return false;
				} else { //location specific
					
					//show all
					$('#featuredUl li').each(function(){
						var liType = $(this).attr('type');
						var liLocation = $(this).attr('location');
						var liRating = parseFloat($(this).attr('rating'));
						if(isNaN(liRating)){
							liRating = 0;
						}
						switch(type){
							case 'both':
								if(liRating <= starRating && liLocation == location){
									$(this).fadeIn();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating && liLocation == location){
									$(this).fadeIn();
								}								
							break;
						}						

					});
					$('#nonfeaturedUl li').each(function(){
						var liType = $(this).attr('type');
						var liLocation = $(this).attr('location');
						var liRating = parseFloat($(this).attr('rating'));
						if(isNaN(liRating)){
							liRating = 0;
						}
						
						switch(type){
							case 'both':
								if(liRating <= starRating && liLocation == location){
									$(this).fadeIn();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating && liLocation == location){
									$(this).fadeIn();
								}								
							break;
						}						

					});
				}
			}
		});
		filter.orderBy();
	},
	// order by
	orderBy: function(){
		var ordered = $(".orderBy:checked").val();
		switch(ordered){
			case '1': //name A-Z
				$("ul#featuredUl > li").tsort({attr:'order'});
				$("ul#nonfeaturedUl > li").tsort({attr:'order'});
			break;
			
			case '2': //name Z-A
				$("ul#featuredUl > li").tsort({order:'desc',attr:'order'});
				$("ul#nonfeaturedUl > li").tsort({order:'desc',attr:'order'});
			break;
			
			case '3': //rating 1-5 && sort by name A-Z
				$("ul#featuredUl > li").tsort({attr:'order',attr:'rating'});
				$("ul#nonfeaturedUl > li").tsort({attr:'order',attr:'rating'});
			break;
				
			case '4': //rating 5-1
				$("ul#featuredUl > li").tsort({order:'desc',attr:'order',attr:'rating'});
				$("ul#nonfeaturedUl > li").tsort({order:'desc',attr:'order',attr:'rating'});
			break;
			
			case '5': //starting price lowest to highest
				$("ul#featuredUl > li").tsort({attr:'order',attr:'starting'});
				$("ul#nonfeaturedUl > li").tsort({attr:'order',attr:'starting'});
			break;
			
			default: //starting price highest to lowest
				$("ul#featuredUl > li").tsort({order:'desc',attr:'order',attr:'starting'});
				$("ul#nonfeaturedUl > li").tsort({order:'desc',attr:'order',attr:'starting'});
			break;
		}
	}
}

addScripts = {
	inventorySelect: function(element){
		
		element.change(function(){
			var vehicle = $(this).find('option:selected').val();

			switch(vehicle){
				case '23':
					$(this).parents('li:first').find('#overlengthDiv').fadeIn();
					$(this).parents('li:first').find('#towedUnitsDiv').fadeIn();				
				break;
				
				default:
					$(this).parents('li:first').find('#overlengthDiv').hide();
					$(this).parents('li:first').find('#towedUnitsDiv').hide();
				break;
			}
		});
	},
	selectFerry: function(element){

		element.find("#departTable tbody tr").click(function(){

			var schedule_id = $(this).attr('schedule_id');
			element.find('#departTable tbody tr').removeClass('selected');
			element.find('#departTable tbody tr').attr('status','notselected');
			element.find('#departTable tbody tr').css({
				"background-color":"#ffffff"
			});
			$(this).css({
				"background-color":"#D1FFD1"
			});
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$("#departTableDiv").removeClass('error');
			$("#departTableDiv").find('.help-block').html('');		
			
			//get schedule id
			var ferry_index = element.find('#ferry_index').val();
			var schedule_id = $(this).attr('schedule_id');

			depart_input = createdTimesInputDepart(schedule_id, ferry_index);
			
			$("#ferryTimesSelectedDiv #schedule_id1").remove();
			$("#ferryTimesSelectedDiv").append(depart_input);
			
		});	
		element.find("#returnTable tbody tr").click(function(){

			var schedule_id = $(this).attr('schedule_id');
			element.find('#returnTable tbody tr').removeClass('selected');
			element.find('#returnTable tbody tr').attr('status','notselected');
			element.find('#returnTable tbody tr').css({
				"background-color":"#ffffff"
			});
			$(this).css({
				"background-color":"#D1FFD1"
			});
			$(this).addClass('selected');
			$(this).attr('status','selected');
			element.find("#returnTableDiv").removeClass('error');
			element.find("#returnTableDiv").find('.help-block').html('');	

			//get schedule id
			var ferry_index = element.find('#ferry_index').val();
			var schedule_id = $(this).attr('schedule_id');
			return_input = createdTimesInputReturn(schedule_id, ferry_index);	
			$("#ferryTimesSelectedDiv #schedule_id2").remove();
			$("#ferryTimesSelectedDiv").append(return_input);
		});	
		
		
	
	},
	selectHotelRoom: function(element){
		element.click(function(){
			$("#hotel-availability .roomLi").attr('top','notselected');
			$(this).parents('.roomLi:first').attr('top','selected');
			$("#hotel-availability .roomLi[top='notselected']").remove();
			$(this).parents('.roomLi:first').css({'border':'2px dashed red'});
			$(this).remove();
			
			$("#hotelSaveToCart").removeAttr('disabled');
			$("#hotelFinishToCart").removeAttr('disabled');
		});
	},
	attractionTours: function(){
		//select time
		$(".tourTime").click(function(){
			var type = $(this).attr('timed');
			var id = $(this).attr('id').replace('tourTime-','');
			var time = $(this).attr('time');
			switch(type){
				case 'Yes':
				$(".tourLi").hide();
				$('#tourLi-'+id+'[time="'+time+'"]').show();				
				break;
				
				default:
				$(".tourLi").hide();
				$('#tourLi-'+id).show();	
				break;
			}
		});
		
		
		$(".bookTour").click(function(e){
			//do validation here
			
			//select tour scripts here
			$("#timedToursDiv").hide();
			$(this).parents('#attraction-availability:first').find('.tourLi').attr('top','notselected');
			$(this).parents('.tourLi:first').attr('top','selected');
			$('.tourLi[top="notselected"]').remove();
			$(this).parents('.tourLi:first').css({"border":"2px dashed red"});
			$(this).remove();
			$("#attractionSaveToCart").removeAttr('disabled');
			$("#attractionSaveToFinish").removeAttr('disabled');
			var tour_id = $(this).parents('.tourLi:first').attr('id').replace('tourLi-','');
			var time = $(this).parents('.tourLi:first').attr('time');
			$("#tour_id").val(tour_id);
			$("#tour_time").val(time);
			e.preventDefault();
		});
		
		$(".typePrice").blur(function(){
			//remove the previous summary
			$(this).parent().parent().parent().parent().parent().find("#summaryTable tbody tr").remove();
			$(this).parent().parent().parent().parent().parent().find('#summaryTable').removeClass('hide');
			total_pretax = 0;
			total_after_tax = 0;
			$(this).parent().parent().parent().parent().parent().find(".typePrice").each(function(){
				var amount = $(this).val();
				if(amount == ''){
					amount = 0;
				} else {
					amount = parseInt(amount);
				}
				var type = $(this).parent().parent().find('label').html();
				var gross = parseFloat($(this).attr('gross'));
				var tax = parseFloat($(this).attr('tax_rate'));		
				var total_gross = Math.round((amount * gross)*100) / 100;
				var total_gross = total_gross.toFixed(2);
				
				total_pretax = parseFloat(total_pretax) + parseFloat(total_gross);
				total_after_tax = parseFloat(total_after_tax) + (parseFloat(total_gross)*(1+(tax)));
				var newTr = '<tr><td>'+type+'</td><td style="text-align:right">$'+total_gross+'</td></tr>';
				$(this).parent().parent().parent().parent().parent().find('#summaryTable tbody').append(newTr);		
			});
			total_after_tax = Math.round((total_after_tax * 100)) / 100;
			total_pretax = Math.round((total_pretax * 100)) / 100;
			total_tax = Math.round((total_after_tax - total_pretax)*100) / 100;
			total_after_tax = total_after_tax.toFixed(2);
			total_pretax = total_pretax.toFixed(2);
			total_tax = total_tax.toFixed(2);
			
			
			$(this).parent().parent().parent().parent().parent().find('#summaryTable #total_pretax').html('$'+total_pretax);
			$(this).parent().parent().parent().parent().parent().find('#summaryTable #total_tax').html('$'+total_tax);
			$(this).parent().parent().parent().parent().parent().find('#summaryTable #total_after_tax').html('$'+total_after_tax);
		});		
	},
	changeFerryDates: function(start, nights){
		var ferry_start_length = $('#package_ferry_start').val();
		var millis = Date.parse(start);
		var newDate = new Date();
		newDate.setTime(millis  + parseInt(nights)*24*60*60*1000);
		var newDateStr = "" + (newDate.getMonth()+1) + "/" + newDate.getDate() + "/" + newDate.getFullYear();

		$('#package_ferry_start').val(start);
		$('#package_ferry_end').val(newDateStr);
	},
	attractionPrice: function(element){
	
		element.blur(function(){
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
	},
	selectFerry: function(){

		$("#departTable tbody tr").click(function(){
			var schedule_id = $(this).attr('schedule_id');
			$(this).parents('table:first').find('tbody tr').removeClass('selected');
			$(this).parents('table:first').find('tbody tr').attr('status','notselected');
			$(this).parents('table:first').find('tbody tr').css({
				"background-color":"#ffffff"
			});
			$(this).css({
				"background-color":"#D1FFD1"
			});
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$(this).parents("#departTableDiv:first").removeClass('error');
			$(this).parents("#departTableDiv:first").find('.help-block').html('');	
			
			$(this).parents('form:first').find('#schedule_id1').val(schedule_id);
		});	
		$("#returnTable tbody tr").click(function(){
			var schedule_id = $(this).attr('schedule_id');
			$(this).parents('table:first').find('tbody tr').removeClass('selected');
			$(this).parents('table:first').find('tbody tr').attr('status','notselected');
			$(this).parents('table:first').find('tbody tr').css({
				"background-color":"#ffffff"
			});
			$(this).css({
				"background-color":"#D1FFD1"
			});
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$(this).parents("#returnTableDiv:first").removeClass('error');
			$(this).parents("#returnTableDiv:first").find('.help-block').html('');	
			$(this).parents('form:first').find('#schedule_id2').val(schedule_id);
		});	
	},
	selectRoom: function(element){
		element.click(function(){
			//$(this).parents('.roomLi').css({"border":"1px dashed #5e5e5e"});
			
			$(this).parent().parent().parent().parent().parent().find('.roomLi').attr('status','notselected');
			$(this).parent().parent().parent().parent().attr('status','selected');
			$(this).parent().parent().parent().parent().parent().find('.roomLi[status="notselected"]').remove();
		});
	},
	package_end_datepicker: function(element){
		element.datepicker({
			minDate:0,
		}).on('changeDate', function(ev){
  			$(this).datepicker('hide');
  			var selected_date = $(this).val();
			changeDatePicker(selected_date);

			packages.ferryCheck();
		});	
	}
}
requests = {
	ajaxTimeLabelDepart: function(element, date, inventory_id, port){
		if(date != ''){
			var d = new Date(date);
			var n = d.getTime() / 1000;		
		} else {
			n = 'NoDate'
		}
		
		switch(inventory_id){
			case '2': //vehicles
				var adults = $("#extraAdults").val();
				var children = $("#children").val();	
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';
				if(vehicle_count == '' || vehicle_count == '0'){
					var vehicle_count = 'zero';
				}			
				var vehicle_type = $("#vehicle_type option:selected").val();	
								
			break;
			
			case '1': //passengers
				var vehicle_count = 'zero';
				var vehicle_type =  'Passengers';
				var adults = $("#adults").val();
				var children = $("#children").val();
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants== '0'){
					var infants = 'zero';
				}
	
			break;
			
			case '3': //motorcycles
				var adults = $("#adults").val();
				var children = $("#children").val();	
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';
				var vehicle_type =  '24';
	
			break;
			
			default: //bicycles
				var adults = $("#adults").val();
				var children = $("#children").val();
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';	
				var vehicle_type = '28';	
	
			break;
		}	
		//change time and check limits
		$.post(
			'/reservations/request_backend_date_get_time',
			{
				type:'RESERVATION_DATE_GET_TIME',
				inventory_id: inventory_id,
				vehicle_count: vehicle_count,
				adults: adults,
				children: children,
				infants: infants,
				date: n,
				port: port
			},	function(results){

				$("#departTable tbody").html(results);

				addScripts.selectFerry(element);
			}
		);	
	
	},
	ajaxTimeLabelReturn: function(element, date, inventory_id, port){
		if(date != ''){
			var d = new Date(date);
			var n = d.getTime() / 1000;		
		} else {
			n = 'NoDate'
		}
		
		switch(inventory_id){
			case '2': //vehicles
				var adults = element.find("#extraAdults").val();
				var children = element.find("#children").val();	
				var infants = element.find("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';
				if(vehicle_count == '' || vehicle_count == '0'){
					var vehicle_count = 'zero';
				}			
				var vehicle_type = $("#vehicle_type option:selected").val();	
								
			break;
			
			case '1': //passengers
				var vehicle_count = 'zero';
				var vehicle_type =  'Passengers';
				var adults = element.find("#adults").val();
				var children = element.find("#children").val();
				var infants = element.find("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants== '0'){
					var infants = 'zero';
				}
	
			break;
			
			case '3': //motorcycles
				var adults = element.find("#adults").val();
				var children = element.find("#children").val();	
				var infants = element.find("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';
				var vehicle_type =  '24';
	
			break;
			
			default: //bicycles
				var adults = element.find("#adults").val();
				var children = element.find("#children").val();
				var infants = element.find("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';	
				var vehicle_type = '28';	
	
			break;
		}	
		//change time and check limits
		$.post(
			'/reservations/request_backend_date_get_time',
			{
				type:'RESERVATION_DATE_GET_TIME',
				inventory_id: inventory_id,
				vehicle_count: vehicle_count,
				adults: adults,
				children: children,
				infants: infants,
				date: n,
				port: port
			},	function(results){

				$("#returnTable tbody").html(results);
				//reservation_ferry.addScripts();
				addScripts.selectFerry(element);
			}
		);	
	
	},
	ajaxTimeLabelOverlengthDepart: function(element, date, inventory_id, port, vehicle_types){
		if(date != ''){
			var d = new Date(date);
			var n = d.getTime() / 1000;		
		} else {
			n = 'NoDate'
		}
		var adults = element.find("#extraadults").val();
		var children = element.find("#children").val();	
		var infants = element.find("#infants").val();
		if(adults == '' || adults == '0'){
			var adults = 'zero';
		}
		if(children == '' || children == '0'){
			var children = 'zero';
		}
		if(infants == '' || infants == '0'){
			var infants = 'zero';
		}
		var vehicle_count = 1;		
	
		//change time and check limits
		$.post(
			'/reservations/request_backend_date_get_time_vehicle',
			{
				type:'RESERVATION_DATE_GET_TIME_VEHICLE',
				inventory_id: inventory_id,
				vehicle_count: vehicle_count,
				vehicle_types: vehicle_types,
				adults: adults,
				children: children,
				infants: infants,
				date: n,
				port: port
			},	function(results){
				$("#departTable tbody").html(results);
				//reservation_ferry.addScripts();
				addScripts.selectFerry(element);
			}
		);	
	
	},
	
	ajaxTimeLabelOverlengthReturn: function(element, date, inventory_id, port, vehicle_types){
	
		if(date != ''){
			var d = new Date(date);
			var n = d.getTime() / 1000;		
		} else {
			n = 'NoDate'
		}
		var adults = element.find("#extraadults").val();
		var children = element.find("#children").val();	
		var infants = element.find("#infants").val();
		if(adults == '' || adults == '0'){
			var adults = 'zero';
		}
		if(children == '' || children == '0'){
			var children = 'zero';
		}
		if(infants == '' || infants == '0'){
			var infants = 'zero';
		}
		var vehicle_count = 1;		
	
		//change time and check limits
		$.post(
			'/reservations/request_backend_date_get_time_vehicle',
			{
				type:'RESERVATION_DATE_GET_TIME_VEHICLE',
				inventory_id: inventory_id,
				vehicle_count: vehicle_count,
				vehicle_types: vehicle_types,
				adults: adults,
				children: children,
				infants: infants,
				date: n,
				port: port
			},	function(results){
				element.find("#returnTable tbody").html(results);
				addScripts.selectFerry(element);
	
				//reservation_ferry.addScripts();
	
			}
		);	
	
	},
	getHotelRooms: function(hotel_id, start, end,rooms, adults, children){

		//change time and check limits
		$.post(
			'/reservations/request_backend_hotel_rooms',
			{
				type:'GET_HOTEL_ROOMS',
				hotel_id: hotel_id,
				start: start,
				end: end,
				rooms: rooms,
				adults: adults,
				children: children
			},	function(results){

				$("#hotel-availability").html(results);
				$("#hotel-availability .bookRoom").each(function(){
					var element = $(this);
					addScripts.selectHotelRoom(element);	
				});
				
	
			}
		);	
	
	},
	//gets hotel rooms and sends them to the ul in the page
	getTours: function(attraction_id, start)
	{
		//change time and check limits
		$.post(
			'/reservations/request_backend_attraction_tours',
			{
				attraction_id: attraction_id,
				start: start
	
			},	function(results){
				$("#attraction-availability").html(results);
				addScripts.attractionTours();
	
			}
		);		
	},
	getPackage: function(package_id, start){
		//change time and check limits
		$.post(
			'/reservations/request_backend_packages',
			{
				package_id: package_id,
				start: start
	
			},	function(results){
				$("#packageFormDiv").html(results);
				//addScripts.attractionTours();
				packages.events();
				packages.datePicker();
				packages.ferryCheck();

			}
		);			
	},
	getInventoryItems: function(inventory_id){
		$.post(
			'/reservations/request_inventory_items',
			{
				inventory_id: inventory_id,
			}, function(results){
				$("#inventoryItemSelectDiv").html(results);
				element = $("#inventoryItemSelectDiv").find('.packagesInventorySelect');
				addScripts.inventorySelect(element);
			}
		)
	}
}
package_addScripts = {
	changeFerryDates: function(start, nights){
		var ferry_start_length = $('#package_ferry_start').val();
		var millis = Date.parse(start);
		var newDate = new Date();
		newDate.setTime(millis  + parseInt(nights)*24*60*60*1000);
		var newDateStr = "" + (newDate.getMonth()+1) + "/" + newDate.getDate() + "/" + newDate.getFullYear();

		$('#package_ferry_start').val(start);
		$('#package_ferry_end').val(newDateStr);
	},
	attractionPrice: function(element){
	
		element.blur(function(){
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
	},
	selectFerry: function(){

		$("#departTable tbody tr").click(function(){
			var schedule_id = $(this).attr('schedule_id');
			$(this).parents('table:first').find('tbody tr').removeClass('selected');
			$(this).parents('table:first').find('tbody tr').attr('status','notselected');
			$(this).parents('table:first').find('tbody tr').css({
				"background-color":"#ffffff"
			});
			$(this).css({
				"background-color":"#D1FFD1"
			});
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$(this).parents("#departTableDiv:first").removeClass('error');
			$(this).parents("#departTableDiv:first").find('.help-block').html('');	
			var schedule_id1 = $(this).attr('schedule_id');

			$("#packageFerryScheduleIds #packageScheduleId1").val(schedule_id1);	
			summary.all();
		});	
		$("#returnTable tbody tr").click(function(){
			var schedule_id = $(this).attr('schedule_id');
			$(this).parents('table:first').find('tbody tr').removeClass('selected');
			$(this).parents('table:first').find('tbody tr').attr('status','notselected');
			$(this).parents('table:first').find('tbody tr').css({
				"background-color":"#ffffff"
			});
			$(this).css({
				"background-color":"#D1FFD1"
			});
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$(this).parents("#returnTableDiv:first").removeClass('error');
			$(this).parents("#returnTableDiv:first").find('.help-block').html('');	
			var schedule_id2 = $(this).attr('schedule_id');

			$("#packageFerryScheduleIds #packageScheduleId2").val(schedule_id2);				
			summary.all();
		});	
	},
	selectRoom: function(element){
		element.click(function(){
			//$(this).parents('.roomLi').css({"border":"1px dashed #5e5e5e"});
			
			$(this).parent().parent().parent().parent().parent().find('.roomLi').attr('status','notselected');
			$(this).parent().parent().parent().parent().attr('status','selected');
			$(this).parent().parent().parent().parent().parent().find('.roomLi[status="notselected"]').remove();
			$(this).parents(".roomLi:first").css({"border":"2px dashed red"});
			$(this).remove();
			summary.all(); //sum the package up
		});
		
	},
	selectTourRadio: function(element){
		//select time
		element.click(function(){
			var type = $(this).attr('timed');
			var id = $(this).attr('id').replace('tourTime-','');
			var time = $(this).attr('time');
			switch(type){
				case 'Yes':
				$(".tourLi").hide();
				$('#tourLi-'+id+'[time="'+time+'"]').show();				
				break;
				
				default:
				$(".tourLi").hide();
				$('#tourLi-'+id).show();	
				break;
			}
			

		});		
	},
	updateTourSummaryTable: function(element){
		element.blur(function(){
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
					$(this).parent().removeClass('error');
					$(this).parent().find('.help-block').html('');
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
	},
	selectTour: function(element){
		element.click(function(){
			errors = 0;
			//first check to see if there is at least 1 
			$(this).parents('.tourLi:first').find('.typePrice').each(function(){
				var quantity = $(this).val();
				if(quantity==''){
					errors = 1;
					$(this).parent().addClass('error');
					$(this).parent().find('.help-block').html('value cannot be empty');
				} else {
					$(this).parent().removeClass('error');
					$(this).parent().find('.help-block').html('');
				}
			});
			
			if(errors == 0){
				$(this).parents('#toursAvailable:first').find('.tourLi').attr('top','notselected');
				$(this).parents('.tourLi:first').attr('top','selected');
				$(this).parents('.tourLi:first').css({"border":"2px dashed red"});	
				$('.tourLi[top="notselected"]').remove();
				$(this).remove();
				$(this).parents('#toursAvailable:first').find("#timedTourDiv").remove();
				
			}
			
			summary.all();//update sum table
		});
	},
	selectBaseRoom: function(){
		setTimeout(function(){
			$(".roomPlusMinusLi").each(function(){
				var type = $(this).html();
				if(type == 'Base room'){
					$(this).parents('ul:first').find('.bookRoom').click();
				}
			});			
		},1000);		
	}	
}
package_requests = {
	ajaxTimeLabelDepart:function(date, inventory_id, port){
		if(date != ''){
			var d = new Date(date);
			var n = d.getTime() / 1000;		
		} else {
			n = 'NoDate'
		}
		
		switch(inventory_id){
			case '2': //vehicles
				var adults = $("#extraAdults").val();
				var children = $("#children").val();	
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';
				if(vehicle_count == '' || vehicle_count == '0'){
					var vehicle_count = 'zero';
				}			
				var vehicle_type = $("#vehicle_type option:selected").val();	
								
			break;
			
			case '1': //passengers
				var vehicle_count = 'zero';
				var vehicle_type =  'Passengers';
				var adults = $("#adults").val();
				var children = $("#children").val();
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants== '0'){
					var infants = 'zero';
				}
	
			break;
			
			case '3': //motorcycles
				var adults = $("#adults").val();
				var children = $("#children").val();	
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';
				var vehicle_type =  '24';
	
			break;
			
			default: //bicycles
				var adults = $("#adults").val();
				var children = $("#children").val();
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';	
				var vehicle_type = '28';	
	
			break;
		}	
		//change time and check limits
		$.post(
			'/reservations/request_backend_date_get_time',
			{
				type:'RESERVATION_DATE_GET_TIME',
				inventory_id: inventory_id,
				vehicle_count: vehicle_count,
				adults: adults,
				children: children,
				infants: infants,
				date: n,
				port: port
			},	function(results){
				$("#departTable tbody").html($(results).show());
				package_addScripts.selectFerry();
			}
		);	
	
	},
	ajaxTimeLabelReturn:function(date, inventory_id, port){
		if(date != ''){
			var d = new Date(date);
			var n = d.getTime() / 1000;		
		} else {
			n = 'NoDate'
		}
		
		switch(inventory_id){
			case '2': //vehicles
				var adults = $("#extraAdults").val();
				var children = $("#children").val();	
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';
				if(vehicle_count == '' || vehicle_count == '0'){
					var vehicle_count = 'zero';
				}			
				var vehicle_type = $("#vehicle_type option:selected").val();	
								
			break;
			
			case '1': //passengers
				var vehicle_count = 'zero';
				var vehicle_type =  'Passengers';
				var adults = $("#adults").val();
				var children = $("#children").val();
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants== '0'){
					var infants = 'zero';
				}
	
			break;
			
			case '3': //motorcycles
				var adults = $("#adults").val();
				var children = $("#children").val();	
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';
				var vehicle_type =  '24';
	
			break;
			
			default: //bicycles
				var adults = $("#adults").val();
				var children = $("#children").val();
				var infants = $("#infants").val();
				if(adults == '' || adults == '0'){
					var adults = 'zero';
				}
				if(children == '' || children == '0'){
					var children = 'zero';
				}
				if(infants == '' || infants == '0'){
					var infants = 'zero';
				}
				var vehicle_count = '1';	
				var vehicle_type = '28';	
	
			break;
		}	
		//change time and check limits
		$.post(
			'/reservations/request_backend_date_get_time',
			{
				type:'RESERVATION_DATE_GET_TIME',
				inventory_id: inventory_id,
				vehicle_count: vehicle_count,
				adults: adults,
				children: children,
				infants: infants,
				date: n,
				port: port
			},	function(results){
				$("#returnTable tbody").html($(results).show());
				//reservation_ferry.addScripts();
				package_addScripts.selectFerry();
			}
		);	
	
	},
	ajaxTimeLabelOverlengthDepart: function(date, inventory_id, port, vehicle_types){
		if(date != ''){
			var d = new Date(date);
			var n = d.getTime() / 1000;		
		} else {
			n = 'NoDate'
		}
		var adults = $("#extraAdults").val();
		var children = $("#children").val();	
		var infants = $("#infants").val();
		if(adults == '' || adults == '0'){
			var adults = 'zero';
		}
		if(children == '' || children == '0'){
			var children = 'zero';
		}
		if(infants == '' || infants == '0'){
			var infants = 'zero';
		}
		var vehicle_count = 1;		
	
		//change time and check limits
		$.post(
			'/reservations/request_backend_date_get_time_vehicle',
			{
				type:'RESERVATION_DATE_GET_TIME_VEHICLE',
				inventory_id: inventory_id,
				vehicle_count: vehicle_count,
				vehicle_types: vehicle_types,
				adults: adults,
				children: children,
				infants: infants,
				date: n,
				port: port
			},	function(results){
				$("#departTable tbody").html(results);
				//reservation_ferry.addScripts();
				package_addScripts.selectFerry();
			}
		);	
	
	},

	ajaxTimeLabelOverlengthReturn: function(date, inventory_id, port, vehicle_types){
	
		if(date != ''){
			var d = new Date(date);
			var n = d.getTime() / 1000;		
		} else {
			n = 'NoDate'
		}
		var adults = $("#extraAdults").val();
		var children = $("#children").val();	
		var infants = $("#infants").val();
		if(adults == '' || adults == '0'){
			var adults = 'zero';
		}
		if(children == '' || children == '0'){
			var children = 'zero';
		}
		if(infants == '' || infants == '0'){
			var infants = 'zero';
		}
		var vehicle_count = 1;		
	
		//change time and check limits
		$.post(
			'/reservations/request_backend_date_get_time_vehicle',
			{
				type:'RESERVATION_DATE_GET_TIME_VEHICLE',
				inventory_id: inventory_id,
				vehicle_count: vehicle_count,
				vehicle_types: vehicle_types,
				adults: adults,
				children: children,
				infants: infants,
				date: n,
				port: port
			},	function(results){
				$("#returnTable tbody").html(results);
				package_addScripts.selectFerry();
				//reservation_ferry.addScripts();
			}
		);	
	},	
	getDepartTimes: function(date){
		var port = $("#start_port").val();
		
		var date = new Date(date);
		var date = date.getTime() / 1000;
		$("#departSelect option").remove();
		$("#departSelect").html('<option>retrieving sailing times</option>');
		
		$.post('/packages/request',
		{
			type:'GET_DEPART_TIMES',
			date: date,
			port: port,
		},function(results){
			setTimeout(function(){
				 $("#departSelect").html(results);	
			}, 300);
			
			
		});	
	},	
	getReturnTimes: function(date){

		var port = $("#return_port").val();
		var date = new Date(date);
		var date = date.getTime() / 1000;
		$("#returnSelect option").remove();
		$("#returnSelect").html('<option>retrieving sailing times</option>');	
		
		$.post('/packages/request',
		{
			type:'GET_RETURN_TIMES',
			date: date,
			port: port,
		},function(results){
			setTimeout(function(){
				 $("#returnSelect").html(results);	
			}, 300);
		});	
	},

	//gets hotel rooms and sends them to the ul in the page
	getHotelRooms: function(hotel_id, start, end,rooms, adults, children){
		var package_id = $("#package_id").val();
		//change time and check limits
		$.post(
			'/packages/request_package_backend_rooms',
			{
				type:'GET_HOTEL_ROOMS',
				package_id: package_id,
				hotel_id: hotel_id,
				start: start,
				end: end,
				rooms: rooms,
				adults: adults,
				children: children
			},	function(results){
				$("#roomUl").html($(results).show());
				//reservation_hotels.addScripts();
				$("#roomUl").find('.roomLi').each(function(){
					var element = $(this).find('.bookRoom');
					package_addScripts.selectRoom(element);
				});
			}
		);		
	},
	
	//gets hotel rooms and sends them to the ul in the page
	getTours: function(attraction_id, start){
		//change time and check limits
		$.post(
			'/packages/request_backend_attraction_tours',
			{
				attraction_id: attraction_id,
				start: start
	
			},	function(results){
				$("#toursAvailable").html(results);
				$('.tourLi[new="Yes"]').each(function(){
					var element_type = $(this).find(".typePrice");
					package_addScripts.attractionPrice(element_type);				
				});
				$('.tourLi[new="Yes"]').removeAttr('new');
	
				$(".tourTime").each(function(){
					var element = $(this);
					package_addScripts.selectTourRadio(element);
				});
				
				$(".typePrice").each(function(){
					var element = $(this);
					package_addScripts.updateTourSummaryTable(element);
				});
				
				$(".bookTour").each(function(){
					var element = $(this);
					package_addScripts.selectTour(element);
				});
			}
		);		
	}
		
}
summary = {
	initialize: function(){

		$("#searchRooms").click();


	},
	all: function(){

		setTimeout(function(){
			//get all form data
			form_data = $('.formPackage').serialize();
			
			$.ajax({
			    type: 'POST', 
			    url: '/packages/request_package_summary',
			    data: form_data, 
			    success: function(data) {
					$("#summaryTableLast").html(data);	
					
			  }
			});				
		}, 1000);


	}
}
/**
 * Functions
 */



/*
 * Functions
 */

//grabs the select opt groups and refreshses the select
var inventoryOptions = function(){
	optgroups = $("#inventoryOptgroups").html();
	
	return optgroups;
}
var createdTimesInputDepart = function(schedule_id, index){
	depart_input = '<input id="schedule_id1" type="hidden" value="'+schedule_id+'" name="data[Reservation]['+index+'][schedule_id1]"/>';

	return depart_input;
}
var createdTimesInputReturn = function(schedule_id, index){
	return_input = '<input id="schedule_id2" type="hidden" value="'+schedule_id+'" name="data[Reservation]['+index+'][schedule_id2]"/>';
	
	return return_input;	
}
var addOn_totals = function(){
	total = 0;
	$(".add_on:checked").each(function(){
		var add_on = parseFloat($(this).attr('extra'));
		total = total + add_on;
	});
	total = Math.round(total * 100) / 100;
	total = total.toFixed(2);
	return total;
}

var availableDates = function(){
	var start = parseInt($("#start").attr('starts'));
	var end = parseInt($("#start").attr('ends'));
	var days = (end - start) / 86400;
	dates = [];
	for (var i=0; i <= days; i++) {
		
	 	var n = start + (i*86400);
	 	var newDate = new Date(parseInt(n) * 1000);
	
	 	var newMonth = (newDate.getUTCMonth())+1;
	 	var newDay = newDate.getUTCDate();
	 	var newYear = newDate.getUTCFullYear();
	 	
	 	var date = newMonth+'/'+newDay+'/'+newYear;
	 	dates[i] = date;
	 	
	};	
	return dates;
}

function available(date){
  var available_dates = availableDates();

  dmy = (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear();
  
  //console.log(dmy+' : '+available_dates+' : '+($.inArray(dmy, available_dates)));
  if ($.inArray(dmy, available_dates) != -1) {
    return [true, "","Available"];
  } else {
    return [false,"","unAvailable"];
  }	
}
var remainingDates = function(){
	var type = $("#package_oneway").val();
	switch(type){
		case 'Yes':
		var s = $("#startDepartSpan").html();
		var s = new Date(s);
		var start = s.getTime() / 1000;
		var e = $("#package_end_date").val();
		var e = new Date(e);
		var end = e.getTime() / 1000;
		var days = (end - start) / 86400;		
		break;
		
		case 'No':
		var s = $("#startDepartSpan").html();
		var s = new Date(s);
		var start = s.getTime() / 1000;
		var e = $("#endReturnSpan").html();
		var e = new Date(e);
		var end = e.getTime() / 1000;
		var days = (end - start) / 86400;		
		break;
	}

	
	dates = [];
	for (var i=0; i <= days; i++) {
		
	 	var n = start + (i*86400);
	 	var newDate = new Date(parseInt(n) * 1000);
	
	 	var newMonth = (newDate.getUTCMonth())+1;
	 	var newDay = newDate.getUTCDate();
	 	var newYear = newDate.getUTCFullYear();
	 	
	 	var date = newMonth+'/'+newDay+'/'+newYear;
	 	dates[i] = date;
	 	
	};	
	console.log(dates);
	return dates;
}
function remaining(date){
  var remaining_dates = remainingDates();

  dmy = (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear();
  
  //console.log(dmy+' : '+available_dates+' : '+($.inArray(dmy, available_dates)));
  if ($.inArray(dmy, remaining_dates) != -1) {
    return [true, "","Available"];
  } else {
    return [false,"","unAvailable"];
  }	
}




function getDepartTimes(date){
	var port = $("#start_port").val();
	
	var date = new Date(date);
	var date = date.getTime() / 1000;
	$("#departSelect option").remove();
	$("#departSelect").html('<option>retrieving sailing times</option>');
	
	$.post('/packages/request',
	{
		type:'GET_DEPART_TIMES',
		date: date,
		port: port,
	},function(results){
		setTimeout(function(){
			 $("#departSelect").html(results);	
		}, 300);
		
		
	});	
}
function getReturnTimes(date){

	var port = $("#return_port").val();
	var date = new Date(date);
	var date = date.getTime() / 1000;
	$("#returnSelect option").remove();
	$("#returnSelect").html('<option>retrieving sailing times</option>');	
	
	$.post('/packages/request',
	{
		type:'GET_RETURN_TIMES',
		date: date,
		port: port,
	},function(results){
		setTimeout(function(){
			 $("#returnSelect").html(results);	
		}, 300);
	});	
}

//gets hotel rooms and sends them to the ul in the page
var getHotelRooms = function(hotel_id, start, end,rooms, adults, children){
	var package_id = $("#package_id").val();
	//change time and check limits
	$.post(
		'/packages/request_rooms',
		{
			type:'GET_HOTEL_ROOMS',
			package_id: package_id,
			hotel_id: hotel_id,
			start: start,
			end: end,
			rooms: rooms,
			adults: adults,
			children: children
		},	function(results){
			$("#roomUl").html($(results).fadeIn());
			//reservation_hotels.addScripts();
			$("#roomUl").find('.roomLi').each(function(){
				var element = $(this).find('.bookRoom');
				addScripts.selectRoom(element);
			});
		}
	);		
}
var changeDatePicker = function(date){
	//date = getDateConvert(date);
	max = new Date($("#package_end").val());
	$("#package_ferry_end").remove();
	$("#ferryEndDiv").prepend('<input id="package_ferry_end" class="span12 datepicker" type="text" value="'+date+'" name="data[Ferry_reservation][return_date]"/>');

	var ferry_end = $("#ferryEndDiv").find('#package_ferry_end');
	addScripts.package_end_datepicker(ferry_end);


}
// var changeDatePickerPackage = function(Date){
	// //date = getDateConvert(date);
	// max = new Date($("#package_end").val());
	// $("#package_ferry_end").remove();
	// $("#ferryEndDiv").prepend('<input id="pacakge_ferry_end" class="span12 datepicker" type="text" value="'+date+'"/>');
	// $("#ferry_end").datepicker({
		// minDate:date,
		// maxDate:max,
 		// onSelect: function(dateStr) {
// 
			// packages.ferryCheck();
// 			
		// }
	// });	
// }
var getDateConvert = function(date){
	var days = parseInt(days);
	var millis = Date.parse(date);
	var newDate = new Date();
	newDate.setTime(millis  + 1*24*60*60*1000);
	var newDateStr = "" + (newDate.getMonth()+1) + "/" + newDate.getDate() + "/" + newDate.getFullYear();

	return newDateStr;
}



//get weekday
var findWeekDay = function(date){
	var d=new Date(date);
	var weekday=new Array();
	weekday[0]="Sunday";
	weekday[1]="Monday";
	weekday[2]="Tuesday";
	weekday[3]="Wednesday";
	weekday[4]="Thursday";
	weekday[5]="Friday";
	weekday[6]="Saturday";
	
	var n = weekday[d.getUTCDay()];
	
	return n;
}

