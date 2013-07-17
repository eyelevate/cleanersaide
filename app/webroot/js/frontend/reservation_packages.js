$(document).ready(function(){
	packages.datePicker();
	packages.events();
	packages.ferryCheck();
	
	$(".pointer").click(function(){
		$(this).parent().find('input').focus().blur();
	});
	
	//get initial room
	requests.getHotelRooms();
	
	//get initial summary table
	summary.initialize();
});

/**
 * functions
 */
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
			minDate: start,
			maxDate: end_date,
			onSelect: function(start){
				var nights = $('#hotel_nights').val();
				addScripts.changeFerryDates(start, nights);		
				$("#roomUl").html('');
				$("#searchRooms").click();	
				packages.ferryCheck();	
				
			}
		}).focus(function(){
			$(this).blur();
				
		});		
			
		$("#ferry_start").datepicker({
			numberOfMonths: 1, 
			minDate: 0,
	 		onSelect: function(dateStr) {
				changeDatePicker(dateStr);
				packages.ferryCheck();
				summary.all();
				
			}
		}).focus(function () {$(this).blur()});
	
		//datepicker scripts runs off of jquery-ui
		$("#ferry_end").datepicker({
			numberOfMonths: 1, 
			minDate: 0,
	 		onSelect: function(dateStr) {
				changeDatePicker(dateStr);
				packages.ferryCheck_return();
				summary.all();
			}
		}).focus(function () {$(this).blur()});
		
		$("#tourDate").datepicker({
			minDate: start,
			maxDate: end_date,

		}).focus(function(){
			$(this).blur();

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
			var depart_date = $("#ferry_start").val();
			var return_date = $('#ferryEndDiv').find("#ferry_end").val();		
			var d = new Date(depart_date).getTime() / 1000;
			var r = new Date(return_date).getTime() / 1000;	
			
			if(d ==''){ //if depart is missing
				$("#ferry_start").parent().parent().addClass('error');
				$("#ferry_start").parent().parent().find('.help-block').html('Please select a depart date');
			} else { //clear errors if good
				$("#ferry_start").parent().parent().removeClass('error');
				$("#ferry_start").parent().parent().find('.help-block').html('');				
			}
			if(r ==''){ //if return is missing
				$("#ferry_end").parent().parent().addClass('error');
				$("#ferry_end").parent().parent().find('.help-block').html('Please select a depart date');				
			} else { //if return is good
				$("#ferry_end").parent().parent().removeClass('error');
				$("#ferry_end").parent().parent().find('.help-block').html('');						
			}
			if(d > r){ //if depart is greater than return
				$("#ferry_start").parent().parent().addClass('error');
				$("#ferry_start").parent().parent().find('.help-block').html('Depart date cannot be greater than return date');				
			} else { //if depart is equal or less than return
				$("#ferry_start").parent().parent().removeClass('error');
				$("#ferry_start").parent().parent().find('.help-block').html('');						
			}
			if(d != '' && r != '' && d <= r){ //if all is good then send 
				$("#ferry_start").parent().parent().removeClass('error');
				$("#ferry_start").parent().parent().find('.help-block').html('');	
				$("#ferry_end").parent().parent().removeClass('error');
				$("#ferry_end").parent().parent().find('.help-block').html('');						
				switch(item_id){
					case '19':
						requests.ajaxTimeLabelDepart(depart_date,'1',port);
						requests.ajaxTimeLabelReturn(return_date,'1',return_port);
					break;
					case '22':
						requests.ajaxTimeLabelDepart(depart_date,'2',port);
						requests.ajaxTimeLabelReturn(return_date,'2',return_port);					
					break;
					
					case '23':
						vehicle_types = {};
						var overlength = $('#overlengthInput').val();
						if(overlength == ''){
							overlength = 18;
						}
						vehicle_types[0] = {};
						vehicle_types[0]['overlength'] = overlength; 

						requests.ajaxTimeLabelOverlengthDepart(depart_date, '2', port,vehicle_types);
						requests.ajaxTimeLabelOverlengthReturn(return_date, '2', return_port,vehicle_types);					
					break;
					case '28':
						requests.ajaxTimeLabelDepart(depart_date,'4',port);
						requests.ajaxTimeLabelReturn(return_date,'4',return_port);						
					break;
					default:
						requests.ajaxTimeLabelDepart(depart_date,'3',port);
						requests.ajaxTimeLabelReturn(return_date,'3',return_port);					
					break;
				}
			}
			
			break;
			
			default: //oneway
			var depart_date = $("#ferry_start").val();
			var d = new Date(depart_date).getTime() / 1000;

			
			if(d ==''){ //if depart is missing
				$("#ferry_start").parent().parent().addClass('error');
				$("#ferry_start").parent().parent().find('.help-block').html('Please select a depart date');			
			} else { //clear errors if good
				$("#ferry_start").parent().parent().removeClass('error');
				$("#ferry_start").parent().parent().find('.help-block').html('');		
				switch(item_id){
					case '19':
						requests.ajaxTimeLabelDepart(depart_date,'1',port);
					break;
					case '22':
						requests.ajaxTimeLabelDepart(depart_date,'2',port);
					break;
					
					case '23':
						vehicle_types = {};
						var overlength = $('#overlengthInput').val();
						if(overlength == ''){
							overlength = 18;
						}
						vehicle_types[0] = {};
						vehicle_types[0]['overlength'] = overlength; 
						

						requests.ajaxTimeLabelOverlengthDepart(depart_date, '2', port,vehicle_types);					
					break;
					
					case '28':
						requests.ajaxTimeLabelDepart(depart_date,'3',port);
					break;
					
					default:
						requests.ajaxTimeLabelDepart(depart_date,'4',port);
					break;
				}				
			}
			break;
		}

	},
	ferryCheck_depart: function(){
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
		var depart_date = $("#ferry_start").val();
		var d = new Date(depart_date).getTime() / 1000;

		
		if(d ==''){ //if depart is missing
			$("#ferry_start").parent().parent().addClass('error');
			$("#ferry_start").parent().parent().find('.help-block').html('Please select a depart date');			
		} else { //clear errors if good
			$("#ferry_start").parent().parent().removeClass('error');
			$("#ferry_start").parent().parent().find('.help-block').html('');		
			switch(item_id){
				case '19':
					requests.ajaxTimeLabelDepart(depart_date,'1',port);
				break;
				case '22':
					requests.ajaxTimeLabelDepart(depart_date,'2',port);
				break;
				
				case '23':
					vehicle_types = {};
					var overlength = $('#overlengthInput').val();
					if(overlength == ''){
						overlength = 18;
					}
					vehicle_types[0] = {};
					vehicle_types[0]['overlength'] = overlength; 
					

					requests.ajaxTimeLabelOverlengthDepart(depart_date, '2', port,vehicle_types);					
				break;
				
				case '28':
					requests.ajaxTimeLabelDepart(depart_date,'3',port);
				break;
				
				default:
					requests.ajaxTimeLabelDepart(depart_date,'4',port);
				break;
			}				
		}

	},
	ferryCheck_return: function(){
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

		var return_date = $('#ferryEndDiv').find("#ferry_end").val();		

		var r = new Date(return_date).getTime() / 1000;	

		if(r ==''){ //if return is missing
			$("#ferry_end").parent().parent().addClass('error');
			$("#ferry_end").parent().parent().find('.help-block').html('Please select a depart date');				
		} else { //if return is good
			$("#ferry_end").parent().parent().removeClass('error');
			$("#ferry_end").parent().parent().find('.help-block').html('');			
			switch(item_id){
				case '19':
					requests.ajaxTimeLabelReturn(return_date,'1',return_port);
				break;
				case '22':
					requests.ajaxTimeLabelReturn(return_date,'2',return_port);					
				break;
				
				case '23':
					vehicle_types = {};
					var overlength = $('#overlengthInput').val();
					if(overlength == ''){
						overlength = 18;
					}
					vehicle_types[0] = {};
					vehicle_types[0]['overlength'] = overlength; 

					requests.ajaxTimeLabelOverlengthReturn(return_date, '2', return_port,vehicle_types);					
				break;
				case '28':
					requests.ajaxTimeLabelReturn(return_date,'4',return_port);						
				break;
				default:
					requests.ajaxTimeLabelReturn(return_date,'3',return_port);					
				break;
			}			
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
				$("#returnTableDiv").show();
				
			} else {
				
				$("#ferryEndSumDiv").hide();
				$("#returnTableDiv").hide();
				$("#schedule_id2").val('');
			}
			//packages.ferryCheck();
			summary.all();
		});
		$("#hotel_nights").live('blur',function(){
			var start = $('#hotel_start').val();
			var nights = $(this).val();
			
			$("#roomUl").html('');

			addScripts.changeFerryDates(start, nights);		
			
			requests.getHotelRooms();

		});
		$("#searchRooms").click(function(){
			requests.getHotelRooms();
		});
		
		$('#hotel_rooms').change(function(){
			$("#roomUl").html('');
			
			requests.getHotelRooms();

		});
		
		$("#hotel_adults").blur(function(){
			$("#roomUl").html('');
			
			requests.getHotelRooms();

		});
		
		$("#hotel_children").blur(function(){
			$("#roomUl").html('');
			
			requests.getHotelRooms();
		
		});
		

		
		//form submission
		$("#addToCart").click(function(){
			packages.validate();
		});
		//attraction selection
		$(".selectAttractionTour").click(function(){
			var attraction_id =$("#attractionSelect").find('option:selected').val();
			var start = new Date($("#tourDate").val()).getTime() / 1000;


			if(start == ''){
				$("#tourDate").parent().parent().addClass('error');
				$("#tourDate").parent().parent().find('.help-block').html('No date selected');
			} else {
				$("#tourDate").parent().parent().removeClass('error');
				$("#tourDate").parent().parent().find('.help-block').html('');				
			}
			
			//if all of the validation approves get hotel rooms
			if(start != ''){
				//function to get hotel rooms
				requests.getTours(attraction_id, start);
			}

		});
		
		//if attraction has not been selected
		$("#attractionSelect").change(function(){
			selected = $(this).find('option:selected').val();
			if(selected =='No'){
				$("#toursAvailable").html('');
			}
		});
	
		$('#transportationSelect').change(function(){
			var selected = $(this).find('option:selected').val();
			
			switch(selected){
				case '22': //standard vehicle
	
					$("#overlengthDiv").addClass('hide');
					$("#overlengthDiv input").attr('disabled','disabled');	
					$("#driversDiv").removeClass('hide');
					$("#addtlAdultsDiv").removeClass('hide');
					$("#extraAdults").removeAttr('disabled');
					$("#adultsDiv").addClass('hide');	
					$("#driver").removeAttr('disabled');
					$("#adults").attr('disabled','disabled');
					$("#driver").val('1');	
					$("#extraAdults").val('1');
					packages.ferryCheck();		
				break;
				
				case '23': //overlength vehicle
					$("#overlengthDiv").removeClass('hide');
					$("#overlengthDiv input").removeAttr('disabled');		
					$("#driversDiv").removeClass('hide');
					$("#addtlAdultsDiv").removeClass('hide');
					$("#extraAdults").removeAttr('disabled');
					$("#driver").removeAttr('disabled');
					$("#adults").attr('disabled','disabled');
					$("#adultsDiv").addClass('hide');		
					$("#driver").val('1');	
					$("#extraAdults").val('1');
					packages.ferryCheck();		
				break;
				
				default:
					$("#overlengthDiv").addClass('hide');
					$("#overlengthDiv input").attr('disabled','disabled');	
					$("#driversDiv").addClass('hide');
					$("#addtlAdultsDiv").addClass('hide');
					$("#adultsDiv").removeClass('hide');	
					$("#driver").attr('disabled','disabled');
					$("#extraAdults").attr('disabled');
					$("#adults").removeAttr('disabled');
					$("#driver").val('0');	
					$("#extraAdults").val('0');
					$("#adults").val('2');
					
					packages.ferryCheck();			
				break;
			}

			
		});
		
		
	},
	validate: function(){
		//validate scripts here
		var type = $(".roundTripCheck:checked").val();
		var depart_time = $("#departTable").find('.selected').length;
		//var depart_time = $("#departSelect").find('option:selected').val();
		var start_date = $("#start").val();
		var hotel_selected_count = $(".roomLi[status='selected']").length;
		var day_trip = $("#day_trip").val(); //checks if a day trip or not
		var errors = 0;
		if(start_date == ''){
			$("#start").parent().parent().addClass('error');
			$("#start").parent().parent().find('.help-block').html('This field cannt be left blank');
			errors++;
		} else {
			$("#start").parent().parent().removeClass('error');
			$("#start").parent().parent().find('.help-block').html('');			
		}
		
		$(".tourPicker").each(function(){
			var value = $(this).val();
			if(value == ''){
				$(this).parent().parent().addClass('error');
				$(this).parent().parent().find('.help-block').html('This field cannot be left blank');
				errors++;
			} else {
				$(this).parent().parent().removeClass('error');
				$(this).parent().parent().find('.help-block').html('');				
			}
		});
		$(".tourTime").each(function(){
			var value = $(this).val();
			if(value == 'No'){
				$(this).parent().addClass('error');
				$(this).parent().find('.help-block').html('This field cannot be left blank');
				errors++;
			} else {
				$(this).parent().removeClass('error');
				$(this).parent().find('.help-block').html('');				
			}
		});
		switch(type){
			case 'No': //oneway
				if(depart_time == '0'){
					
					$("#departTableDiv").addClass('error');
					$('#departTableDiv').find('.help-block').html('Please select a depart trip');

					errors++;
				} else {
					$("#departTableDiv").removeClass('error');
					$('#departTableDiv').find('.help-block').html('');
				}

			break;
			case 'Yes': //round trip
				var return_time = $("#returnTable").find('.selected').length;
				if(return_time == '0'){
					$("#returnTableDiv").addClass('error');
					$('#returnTableDiv').find('.help-block').html('Please select a return trip');
					errors++;	
				} else {
					$("#returnTableDiv").removeClass('error');
					$('#returnTableDiv').find('.help-block').html('');			
				}
				if(depart_time == '0'){
					$("#departTableDiv").addClass('error');
					$('#departTableDiv').find('.help-block').html('Please select a depart trip');
					errors++;
				} else {
					$("#departTableDiv").removeClass('error');
					$('#departTableDiv').find('.help-block').html('');		
				}			
		
			break;

		}
		if($("#attractionSelect").is('*')){
			var selected_attraction = $("#attractionSelect").find('option:selected').val();
		} else {
			var selected_attraction = 'No';
		}
		if(selected_attraction == 'No'){
			switch(day_trip){
				case 'No':
					$("#errorUl").html('');
					if(hotel_selected_count == 0){
						
						var errorLi = '<li class="text text-error">Please select your hotel room</li>';
						$("#errorDiv").removeClass('hide');
						$("#errorUl").append(errorLi);						
					}
					
					if(errors > 0){
						var errorLi = '<li class="text text-error">Please select a ferry depart and/or return time</li>';
						$("#errorDiv").removeClass('hide');
						$("#errorUl").append(errorLi);		
					}
					if(errors == 0 && hotel_selected_count > 0){
						$("#errorDiv").removeClass('hide').removeClass('alert-error').addClass('alert-success').css({'padding-top':'25px'});
						$("#errorUl").remove();
						$("#errorDiv h5 strong").addClass('text').addClass('text-success').html('Thank you! Your package reservation is being processed!');
						//remove unused objects from dom
						$(".tourLi[top='notselected']").remove();
	
						//submit form
						$(".formPackage").submit();
					} 
				break;
				
				default:
					$("#errorUl").html('');
					if(errors > 0){
						var errorLi = '<li class="text text-error">Please select a ferry depart and/or return time</li>';
						$("#errorDiv").removeClass('hide');
						$("#errorUl").append(errorLi);		
					}

					if(errors == 0){
						$('#errorDiv').removeClass('hide').removeClass('alert-error').addClass('alert-success').css({'padding-top':'25px'});
						$("#errorUl").remove();
						$("#errorDiv h5 strong").addClass('text').addClass('text-success').html('Thank you! Your package reservation is being processed!');
						//remove unused objects from dom
						$(".tourLi[top='notselected']").remove();
						
						//submit form
						$(".formPackage").submit();
					}			
				break;
			}			
			
		} else { //an attraction was selected
			switch(day_trip){
				case 'No':
					var count_attraction_selected = $(".tourLi[top='selected']").length;
					$("#errorUl").html('');
					if(hotel_selected_count == 0){
						var errorLi = '<li class="text text-error">Please select your hotel room</li>';
						$("#errorUl").removeClass('hide').append(errorLi);						
					}
					
					if(errors > 0){
						var errorLi = '<li class="text text-error">Please select a ferry depart and/or return time</li>';
						$("#errorDiv").removeClass('hide');
						$("#errorUl").append(errorLi);			
					}	
					if(count_attraction_selected == 0){
						var errorLi = '<li class="text text-error">Please make sure to confirm your attraction tour</li>';
						$("#errorDiv").removeClass('hide');
						$("#errorUl").append(errorLi);		
					}				
					if(errors == 0 && hotel_selected_count > 0 && count_attraction_selected > 0){
						$('#errorDiv').removeClass('hide').removeClass('alert-error').addClass('alert-success').css({'padding-top':'25px'});
						$("#errorUl").remove();
						
						$("#errorDiv h5 strong").addClass('text').addClass('text-success').html('Thank you! Your package reservation is being processed!');					
						//remove unused objects from dom
						$(".tourLi[top='notselected']").remove();
						//submit form
						$(".formPackage").submit();							
					}
				break;
				
				default:
					var count_attraction_selected = $(".tourLi[top='selected']").length;
					
					$("#errorUl").html('');
					if(errors > 0){
						var errorLi = '<li class="text text-error">Please select a ferry depart and/or return time</li>';
						$("#errorDiv").removeClass('hide');
						$("#errorUl").append(errorLi);				
					}
					if(count_attraction_selected == 0){
						var errorLi = '<li class="text text-error" >Please make sure to confirm your attraction tour</li>';
						$("#errorDiv").removeClass('hide');
						$("#errorUl").append(errorLi);		
					}						

					if(errors == 0 && count_attraction_selected>0){
						$('#errorDiv').removeClass('hide').removeClass('alert-error').addClass('alert-success').css({'padding-top':'25px'});
						$("#errorUl").remove();
						$("#errorDiv h5 strong").addClass('text').addClass('text-success').html('Thank you! Your package reservation is being processed!');
						//remove unused objects from dom
						$(".tourLi[top='notselected']").remove();
						
						//submit form
						$(".formPackage").submit();
					}					
		
				break;
			}			
		}

	}
}
addScripts= {
	changeFerryDates: function(start, nights){
		var ferry_start_length = $('#ferry_start').val();
		var millis = Date.parse(start);
		var newDate = new Date();
		newDate.setTime(millis  + parseInt(nights)*24*60*60*1000);
		var newDateStr = "" + (newDate.getMonth()+1) + "/" + newDate.getDate() + "/" + newDate.getFullYear();

		$('#ferry_start').val(start);

		max = new Date($("#package_end").val());
		$("#ferry_end").remove();
		$("#ferryEndDiv").prepend('<input id="ferry_end" class="span12 datepicker" type="text" value="'+newDateStr+'" name="data[Ferry_reservation][return_date]"/>');
		$("#ferry_end").datepicker({
			minDate:start,
			maxDate:max,
	 		onSelect: function(dateStr) {
	
				packages.ferryCheck_return();
				
			}
		});		
		packages.ferryCheck();		

	},
	attractionPrice: function(element){
	
		element.keyup(function(){
			//remove the previous summary
			$(this).parent().parent().parent().parent().find("#summaryTable tbody tr").remove();
			$(this).parent().parent().parent().parent().find('#summaryTable').removeClass('hide');
			total_pretax = 0;
			total_after_tax = 0;
			$(this).parent().parent().parent().parent().find(".typePrice").each(function(){
				var amount = $(this).val();
				if(amount == '' || amount == '0'){
					amount = 0;
					$(this).val(amount);
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
			
			
			if(parseFloat(total_after_tax) > 0){
				$(this).parents('.tourLi').find('.bookTour').removeAttr('disabled');
			} else {
				$(this).parents('.tourLi').find('.bookTour').attr('disabled','disabled');
			}
		});	
	},
	selectFerry: function(){

		$("#departTable tbody .touch").click(function(){

			var schedule_id = $(this).attr('schedule_id');
			$('#departTable tbody tr').removeClass('selected');
			$('#departTable tbody tr').attr('status','notselected');
			$('#departTable tbody tr').css({'font-weight':'normal'});
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$(this).css({'font-weight':'bold'});
			$("#departTableDiv").removeClass('error');
			$("#departTableDiv").find('.help-block').html('');	
			var schedule_id1 = $(this).attr('schedule_id');

			$("#hiddenFormDiv #schedule_id1").val(schedule_id1);	
			summary.all();
		});	
		$("#returnTable tbody .touch").click(function(){

			var schedule_id = $(this).attr('schedule_id');
			$('#returnTable tbody tr').removeClass('selected');
			$('#returnTable tbody tr').attr('status','notselected');
			$('#returnTable tbody tr').css({'font-weight':'normal'});
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$(this).css({'font-weight':'bold'});
			$("#returnTableDiv").removeClass('error');
			$("#returnTableDiv").find('.help-block').html('');		
			var schedule_id2 = $(this).attr('schedule_id');

			$("#hiddenFormDiv #schedule_id2").val(schedule_id2);	
			summary.all();
		});	
	},
	selectRoom: function(element){
		element.click(function(){


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
			
			$(".tourLi:not(:visible) input").attr('disabled','disabled');
			$(".tourLi:visible input").removeAttr('disabled');
			//remove the selected border if any
			$('.tourLi').css({"border":"none"}).attr('top','notselected');
			//turn all 
		});		
	},
	updateTourSummaryTable: function(element){
		element.keydown(function(event){
	        // Allow: backspace, delete, tab, escape, and enter
	        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
	             // Allow: Ctrl+A
	            (event.keyCode == 65 && event.ctrlKey === true) || 
	             // Allow: home, end, left, right
	            (event.keyCode >= 35 && event.keyCode <= 39)) {
	                 // let it happen, don't do anything
	                 //remove the previous summary
					$(this).parents('.tourLi:first').find("#summaryTable tbody tr").remove();
					$(this).parents('.tourLi:first').find('#summaryTable').removeClass('hide');
					total_pretax = 0;
					total_after_tax = 0;
					
					total_count = 0;
		
					$(this).parents('.tourLi:first').find(".typePrice").each(function(){
						var amount = $(this).val();
						if(amount == ''){
							amount = 0;
		
						} else {
							amount = parseInt(amount);
							$(this).val(amount);
							$(this).parent().removeClass('error');
							$(this).parent().find('.help-block').html('');
						}
						
						total_count += amount;
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
					
					if(total_count>0){
						$(this).parents('.tourLi:first').find('.bookTour').removeAttr('disabled').addClass('btn-success');
		
					} else {
						$(this).parents('.tourLi:first').css({'border':'none'}).attr('top','notselected');
						$(this).parents('.tourLi:first').find('.bookTour').attr('disabled','disabled').removeClass('btn-success');
					}               
	                 
	                 
	                 
	                 
	                 return;
	        }
	        else {
	            // Ensure that it is a number and stop the keypress
	            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	                event.preventDefault(); 
	            }   
	        }
	
			
		});

		
		element.blur(function(){

             //remove the previous summary
			$(this).parent().parent().parent().parent().find("#summaryTable tbody tr").remove();
			$(this).parent().parent().parent().parent().find('#summaryTable').removeClass('hide');
			total_pretax = 0;
			total_after_tax = 0;
			
			

			$(this).parents('.tourLi:first').find(".typePrice").each(function(){
				var amount = $(this).val();
				if(amount == ''){
					amount = 0;

				} else {
					amount = parseInt(amount);
					$(this).val(amount);
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
			
			if(parseFloat(total_after_tax)>0){
				$(this).parents('.tourLi:first').find('.bookTour').removeAttr('disabled').addClass('btn-success');
	
			} else {
				$(this).parents('.tourLi:first').css({'border':'none'}).attr('top','notselected');
				$(this).parents('.tourLi:first').find('.bookTour').attr('disabled','disabled').removeClass('btn-success');
			}  					
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
				//$('.tourLi[top="notselected"]').remove();
				//$(this).remove();
				//$(this).parents('#toursAvailable:first').find("#timedTourDiv").remove();
				
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
									$(this).show();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating){
									$(this).show();
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
									
									$(this).show();
								}								
							break;
							
							default:
								if(liType == type && noliRating <= starRating){
									$(this).show();
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
									$(this).show();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating && liLocation == location){
									$(this).show();
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
									$(this).show();
								}								
							break;
							
							default:
								if(liType == type && liRating <= starRating && liLocation == location){
									$(this).show();
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
	},

}
summary = {
	initialize: function(){

		$("#searchRooms").click();


	},
	all: function(){
	var vehicle_type = $('#transportationSelect').find('option:selected').val();
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

requests = {
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
			'/reservations/request_date_get_time',
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
				addScripts.selectFerry();

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
			'/reservations/request_date_get_time',
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
				addScripts.selectFerry();

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
			'/reservations/request_date_get_time_vehicle',
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
				addScripts.selectFerry();
				
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
			'/reservations/request_date_get_time_vehicle',
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
				addScripts.selectFerry();
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
	getHotelRooms: function(){
			var hotel_id =$("#hotel_id").val();
			var start = $("#hotel_start").val();
			var nights = parseInt($("#hotel_nights").val());
			var arrival = Math.round((new Date(start)).getTime() / 1000);
			var departure = (nights * 86400) + arrival;
			var adults = $("#hotel_adults").val();
			var children = $("#hotel_children").val();
			var rooms = $("#hotel_rooms").find('option:selected').val();
			var package_id = $("#package_id").val();
			
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
			if(parseInt(rooms) > parseInt(adults)){
				$("#hotel_rooms").parent().addClass('error');
				$("#hotel_adults").parent().addClass('error');
				$("#hotel_adults").parent().find('.help-block').html('Not enough adults compared to rooms');
			} else {
				$("#hotel_rooms").parent().removeClass('error');
				$("#hotel_adults").parent().removeClass('error');
				$("#hotel_adults").find('.help-block').html('');				
			}
			
			//if all of the validation approves get hotel rooms
			if(start != '' & nights != '' && parseInt(arrival) != parseInt(departure) && parseInt(arrival) < parseInt(departure) && adults != '' && parseInt(adults) > 0 && parseInt(rooms) <= parseInt(adults)){
				//function to get hotel rooms
				$.post(
					'/packages/request_rooms',
					{
						type:'GET_HOTEL_ROOMS',
						package_id: package_id,
						hotel_id: hotel_id,
						start: arrival,
						end: departure,
						rooms: rooms,
						adults: adults,
						children: children
					},	function(results){
						$("#roomUl").html($(results).show());
						//reservation_hotels.addScripts();
						$("#roomUl").find('.roomLi').each(function(){
							var element = $(this).find('.bookRoom');
							addScripts.selectRoom(element);
						});
					}
				);	
			}		
		

	
	},
	
	//gets hotel rooms and sends them to the ul in the page
	getTours: function(attraction_id, start){
		//change time and check limits
		$.post(
			'/packages/request_attraction_tours',
			{
				attraction_id: attraction_id,
				start: start
	
			},	function(results){
				$("#toursAvailable").html(results);
				$('.tourLi[new="Yes"]').each(function(){
					var element_type = $(this).find(".typePrice");
					addScripts.attractionPrice(element_type);				
				});
				$('.tourLi[new="Yes"]').removeAttr('new');
	
				$(".tourTime").each(function(){
					var element = $(this);
					addScripts.selectTourRadio(element);
				});
				
				$(".typePrice").each(function(){
					var element = $(this);
					addScripts.updateTourSummaryTable(element);
				});
				
				$(".bookTour").each(function(){
					var element = $(this);
					addScripts.selectTour(element);
				});
				
				//disable all non visible tourLi data
				$(".tourLi:not(:visible) input").attr('disabled','disabled');
				$(".tourLi:visible input").removeAttr('disabled');
			}
		);		
	}
	
}


//variable functions
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


var changeDatePicker = function(date){
	//date = getDateConvert(date);
	max = new Date($("#package_end").val());
	$("#ferry_end").remove();
	$("#ferryEndDiv").prepend('<input id="ferry_end" class="span12 datepicker" type="text" value="'+date+'" name="data[Ferry_reservation][return_date]"/>');
	$("#ferry_end").datepicker({
		minDate:date,
		maxDate:max,
 		onSelect: function(dateStr) {

			packages.ferryCheck_return();
			
		}
	});
}
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

