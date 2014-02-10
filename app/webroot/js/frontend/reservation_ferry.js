
$(document).ready(function(){
	reservation_ferry.tabs(); //Select Inventory tabs
	reservation_ferry.datePicker(); //datepicker scripts
	reservation_ferry.changeValues(); //main event scripts
	
	//console log scripts
	$("#ferryConsoleLog").click(function(){
		alert('Created Log');
		reservation_ferry.consoleLogging();
	});
});

/**
 * Functions
 */
reservation_ferry = {
	tabs: function(){
		$('.tabbable').each(function(){

		    // For each set of tabs, we want to keep track of
		    // which tab is active and it's associated content
		    var $active, $content, $links = $(this).find('a');
		
		    // If the location.hash matches one of the links, use that as the active tab.
		    // If no match is found, use the first link as the Passengers the active tab.
		    $active = $($links.filter('[href="'+location.hash+'"]')[4] || $links[0]);
		   
		    $active.addClass('active');
		   	$content = $($active.attr('href'));
		   	

		    // Hide the remaining content
		    $links.not($active).each(function () {
		        $($(this).attr('href')).hide();
		    });
		    // Bind the click event handler
		    $(this).on('click', 'a', function(e){
		        // Make the old tab inactive.
		        $active.removeClass('active');
		        
		        $content.find('input').attr('disabled','disabled');
		        $content.find('select').find('option[value=""]').attr('selected','selected');
		        $content.slideUp(500);
		
		        // Update the variables with the new link and content
		        $active = $(this);
		        $content = $($(this).attr('href'));
		
		        // Make the tab active.
		        $active.addClass('active');
		        $content.slideDown(500);
				$content.find('input').removeAttr('disabled');
				$content.find('select').removeAttr('disabled');
				
				//remove error classes
				$("#inventoryList div").removeClass('error');
				$("#inventoryList .help-block").html('');
				$("#departTableDiv").removeClass('error');
				$("#departTableDiv").find('.help-block').html('');	
				$("#returnTableDiv").removeClass('error');
				$("#returnTableDiv").find('.help-block').html('');	
				
				//get variable data
				var index = $("#formFerry").attr('index');
				var inventory_id = $("#inventoryList .active").parent().attr('inventory_id');
				var depart_date = $("#Reservation"+index+"Departs").val();
				var return_date = $("#Reservation"+index+"Returns").val();
				var trip_type = $('input[name="data[Reservation]['+index+'][trip_type]"]:checked').val();
				var port = $("#Reservation"+index+"DepartPort").find('option:selected').val();
				if(inventory_id != '2'){ // all other inventory types will go through a basic limit check based on count and inventory_id and port
					switch(trip_type){
						case 'roundtrip':
							//get new sailing times
							ajaxTimeLabelFast1(depart_date,inventory_id,port);	
							var return_date = $("#Reservation"+index+"Returns").val();
							
							if(port == 'Port Angeles'){
								second_port = 'Victoria';
							} else {
								second_port = 'Port Angeles';
							}
							ajaxTimeLabelFast2(return_date,inventory_id,second_port);					
						break;
						
						default:
							//get new sailing times
							ajaxTimeLabelFast1(depart_date,inventory_id,port);						
						break;
					}	
				} else { //this is a vehicle type we will run a different set of codes to check for incremental units
					//get the set inventory item ids and overlength (if applicable)
					var vehicle_types = {};
					
					$(".vtaiud").each(function(ev){
						var item_id = $(this).find('.vehicle_type option:selected').val();
						var overlength = $(this).find('#overlengthAmount').val();
						if(overlength == ''){
							overlength = 18;
						}
						
						vehicle_types[ev] = {};
						vehicle_types[ev]['overlength'] = overlength; 
					});
					switch(trip_type){
						case 'roundtrip':
							//get new sailing times
							ajaxTimeLabelFastOverlength1(depart_date,inventory_id,port, vehicle_types);	
							var return_date = $("#Reservation"+index+"Returns").val();
							
							if(port == 'Port Angeles'){
								second_port = 'Victoria';
							} else {
								second_port = 'Port Angeles';
							}
							ajaxTimeLabelFastOverlength2(return_date,inventory_id,second_port, vehicle_types);					
						break;
						
						default:
							//get new sailing times
							ajaxTimeLabelFastOverlength1(depart_date,inventory_id,port, vehicle_types);						
						break;
					}
					reservation_ferry.addScripts();
				}
				
		        // Prevent the anchor's default click action
		        e.preventDefault();
		    });
		});
	},
	datePicker: function(){
		//datepicker scripts runs off of jquery-ui
		$(".datepicker").datepicker({
			minDate:0,
			onSelect: function(en){ //runs an onselect script grabs times and status
				var index = $("#formFerry").attr('index');
				var trip = $('input[name="data[Reservation]['+index+'][trip_type]"]:checked').val();
				var type = $(this).attr('id');
				var port = $("#Reservation"+index+"DepartPort").find('option:selected').val();
				var date = en;
				var inventory_id = $("#inventoryList .active").parent().attr('inventory_id');
				var weekday = findWeekDay(date);
				
				//hide sum
				$("#tripSummaryDiv").hide();
				$("#calcButtonDiv").show();
				$(this).val(weekday+' '+en);
				
				
				switch(type){
					case 'Reservation'+index+'Departs':
						id = '#departPortSpan';
						var d = new Date(en).getTime() / 1000;
						var r = new Date($("#Reservation"+index+"Returns").val()).getTime() / 1000;
						if(parseInt(d) > parseInt(r) && r != ''){
							$("#Reservation"+index+"Departs").parent().parent().addClass('error');
							$("#Reservation"+index+"Departs").parent().parent().find('.help-block').html('Depart Date cannot be greater than return date');
							
						} else {
							$("#Reservation"+index+"Departs").parent().parent().removeClass('error');
							$("#Reservation"+index+"Departs").parent().parent().find('.help-block').html('');
							$("#departTableDiv").removeClass('error');
							$("#departTableDiv").find('.help-block').html('');	
							
							
							if(date != ''){
								switch(inventory_id){
									case '2':
									var vehicle_types = {};
									
									$(".vtaiud").each(function(ev){
										var item_id = $(this).find('.vehicle_type option:selected').val();
										var overlength = $(this).find('#overlengthAmount').val();
										if(overlength == ''){
											overlength = 18;
										}
										
										vehicle_types[ev] = {};
										vehicle_types[ev]['overlength'] = overlength; 
									});
									ajaxTimeLabelSlowOverlength1(date, inventory_id, port,vehicle_types);
									break;
									
									default:
									ajaxTimeLabelSlow1(date, inventory_id, port);	
									break;
								}
								
								reservation_ferry.addScripts();
							}
						}
										
					break;
					
					default:
						var d = new Date($("#Reservation"+index+"Departs").val()).getTime() / 1000;
						var r = new Date(en).getTime() / 1000;	

										
						id="#returnPortSpan";
						if(port == 'Port Angeles'){
							port = 'Victoria';
						} else {
							port = 'Port Angeles';
						}
						if(parseInt(d) > parseInt(r)){
							$("#Reservation"+index+"Returns").parent().parent().addClass('error');
							$("#Reservation"+index+"Returns").parent().parent().find('.help-block').html('Return date cannot be less than depart date');
							
						} else {
							$("#Reservation"+index+"Returns").parent().parent().removeClass('error');
							$("#Reservation"+index+"Returns").parent().parent().find('.help-block').html('');		
							$("#returnTableDiv").removeClass('error');
							$("#returnTableDiv").find('.help-block').html('');						
							if(date != ''){				
								switch(inventory_id){
									case '2':
									var vehicle_types = {};
									
									$(".vtaiud").each(function(ev){
										var item_id = $(this).find('.vehicle_type option:selected').val();
										var overlength = $(this).find('#overlengthAmount').val();
										if(overlength == ''){
											overlength = 18;
										}
										
										vehicle_types[ev] = {};
										vehicle_types[ev]['overlength'] = overlength; 
									});									
														
									
									ajaxTimeLabelSlowOverlength2(date, inventory_id, port, vehicle_types);
									break;
									
									default:
									ajaxTimeLabelSlow2(date, inventory_id, port);	
									break;
								}	
								reservation_ferry.addScripts();
							}
						}
					
					break;
				}

			}		
		}).focus(function () {$(this).blur()});

	},
	//runs main event scripts on page
	changeValues: function(){
		var index = $("#formFerry").attr('index');
		//click add-on and focus on calendar input
		$(".pointer").click(function(){
			$(this).parent().find('input').focus().blur();
		});
		
		
		//removes return trip if oneway selected and adds it back if roundtrip is selected
		$('.tripRadio').click(function(){
			var trip_type = $(this).val();
			$("#innerTripType").html(trip_type);
			
		
			if(trip_type=='oneway'){
				$("#returnTableDiv").removeClass('error');
				$("#returnTableDiv").find('.help-block').html('');	
				$("#Reservation"+index+"Returns").parent().parent().fadeOut();
				$("#returnTableDiv").fadeOut();
				$("#Reservation"+index+"Returns").val('');
				$("#returnTable tbody tr").remove();

			} else {
				
				$("#Reservation"+index+"Returns").parent().parent().fadeIn();
				$("#returnTableDiv").fadeIn();	
			
			}
		});
		
		$(".reservationDepartPort").change(function(){

			//get variable data
			var index = $("#index").val();
			var inventory_id = $("#inventoryList .active").parent().attr('inventory_id');
			var depart_date = $("#Reservation"+index+"Departs").val();
			var return_date = $("#Reservation"+index+"Returns").val();
			var trip_type = $('input[name="data[Reservation]['+index+'][trip_type]"]:checked').val();		
			var port = $(this).find('option:selected').val();

			if(port == 'Port Angeles'){
				return_port = "Victoria";
				
			} else {
				return_port = 'Port Angeles';
				
			}
			switch(trip_type){
				case 'roundtrip':
					//get new sailing times
					ajaxTimeLabelFast1(depart_date,inventory_id,port);	
					var return_date = $("#Reservation"+index+"Returns").val();
					
					if(port == 'Port Angeles'){
						second_port = 'Victoria';
					} else {
						second_port = 'Port Angeles';
					}
					ajaxTimeLabelFast2(return_date,inventory_id,second_port);					
				break;
				
				default:
					//get new sailing times
					ajaxTimeLabelFast1(depart_date,inventory_id,port);						
				break;
			}		
			$("#departPortSpan").html(port+' to '+return_port);
			$("#returnPortSpan").html(return_port+' to '+port);
			
			$("#tripSummary").html(port+' to '+return_port);
		});
		
		$("#departTable tbody .touch").click(function(){

			var schedule_id = $(this).attr('schedule_id');
			$('#departTable tbody tr').removeClass('selected');
			$('#departTable tbody tr').attr('status','notselected');
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$("#departTableDiv").removeClass('error');
			$("#departTableDiv").find('.help-block').html('');	
		});
		$("#returnTable tbody .touch").click(function(){

			var schedule_id = $(this).attr('schedule_id');
			$('#returnTable tbody tr').removeClass('selected');
			$('#returnTable tbody tr').attr('status','notselected');
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$("#returnTableDiv").removeClass('error');
			$("#returnTableDiv").find('.help-block').html('');	
		});		
		
		//calculate final price and show trip summary
		$("#calcPrice").click(function(){
			var index = $("#formFerry").attr('index');
			var inventory_id = $("#inventoryList .active").parent().attr('inventory_id');
			var depart_date = $("#Reservation"+index+"Departs").val();
			var return_date = $("#Reservation"+index+"Returns").val();
			var port = $("#Reservation"+index+"DepartPort option:selected").val();
			var trip_type = $("input[name='data[Reservation]["+index+"][trip_type]']:checked").val();	
			
			switch(trip_type){
				case 'roundtrip':
					var schedule_id1 = $("#departTable tbody tr[status='selected']").attr('schedule_id');
					var schedule_id2 = $("#returnTable tbody tr[status='selected']").attr('schedule_id');					
				break;
				
				default:
					var schedule_id1 = $("#departTable tbody tr[status='selected']").attr('schedule_id');
					var schedule_id2 = 'zero';						
				break;
			}

			reservation_ferry.createSummary(inventory_id, depart_date, return_date, port, trip_type, schedule_id1, schedule_id2);		
		});
		
		$("#vehicle_count, #motorcycle_count, #bicycle_count").keyup(function(){
			if($(this).val() != ''){
				$(this).parent().removeClass('error');
				$(this).parent().find('.help-block').html('');
			}
		});
		
		$("#vehicle_type,.motorcycle_type, #bicycle_count").change(function(){
			if($(this).val() != ''){
				$(this).parent().removeClass('error');
				$(this).parent().find('.help-block').html('');
			}			
		});
		
		//recalculate totals
		$("#recalculateTotals").click(function(){
			var index = $("#formFerry").attr('index');
			var inventory_id = $("#inventoryList .active").parent().attr('inventory_id');
			var depart_date = $("#Reservation"+index+"Departs").val();
			var return_date = $("#Reservation"+index+"Returns").val();
			var port = $("#Reservation"+index+"DepartPort option:selected").val();
			
			var trip_type = $("input[name='data[Reservation]["+index+"][trip_type]']:checked").val();	
			switch(trip_type){
				case 'roundtrip':
					var schedule_id1 = $("#departTable tbody tr[status='selected']").attr('schedule_id');
					var schedule_id2 = $("#returnTable tbody tr[status='selected']").attr('schedule_id');					
				break;
				
				default:
					var schedule_id1 = $("#departTable tbody tr[status='selected']").attr('schedule_id');
					var schedule_id2 = 'zero';						
				break;
			}

			reservation_ferry.createSummary(inventory_id, depart_date, return_date, port, trip_type, schedule_id1, schedule_id2);				
		});
		
		//get limits by...
		//vehicle count, motorcycle count, bicycle count, adults, children, infants
		$("#vehicle_count,#motorcycle_count,#bicycle_count,.adults, .children, .infants, .vtaiud #overlengthAmount").blur(function(){
			//get variable data
			var index = $("#formFerry").attr('index');
			var inventory_id = $("#inventoryList .active").parent().attr('inventory_id');
			var depart_date = $("#Reservation"+index+"Departs").val();
			var return_date = $("#Reservation"+index+"Returns").val();
			
			var trip_type = $('input[name="data[Reservation]['+index+'][trip_type]"]:checked').val();
			var port = $("#Reservation"+index+"DepartPort").find('option:selected').val();
			if(port == 'Port Angeles'){
				return_port = "Victoria";
				
			} else {
				return_port = 'Port Angeles';
				
			}
			
			//if(inventory_id != '2'){ // all other inventory types will go through a basic limit check based on count and inventory_id and port
				switch(trip_type){
					case 'roundtrip':
						//get new sailing times
						ajaxTimeLabelFast1(depart_date,inventory_id,port);	
						var return_date = $("#Reservation"+index+"Returns").val();
						
						if(port == 'Port Angeles'){
							second_port = 'Victoria';
						} else {
							second_port = 'Port Angeles';
						}
						ajaxTimeLabelFast2(return_date,inventory_id,second_port);					
					break;
					
					default:
						//get new sailing times
						ajaxTimeLabelFast1(depart_date,inventory_id,port);						
					break;
				}	
			//}
			
		});
		
		$(".motorcycle_type").change(function(){
			//get variable data
			var index = $("#formFerry").attr('index');
			var inventory_id = $("#inventoryList .active").parent().attr('inventory_id');
			var depart_date = $("#Reservation"+index+"Departs").val();
			var return_date = $("#Reservation"+index+"Returns").val();
			
			var trip_type = $('input[name="data[Reservation]['+index+'][trip_type]"]:checked').val();
			var port = $("#Reservation"+index+"DepartPort").find('option:selected').val();
			if(port == 'Port Angeles'){
				return_port = "Victoria";
				
			} else {
				return_port = 'Port Angeles';
				
			}
			switch(trip_type){
				case 'roundtrip':
					//get new sailing times
					ajaxTimeLabelFast1(depart_date,inventory_id,port);	
					var return_date = $("#Reservation"+index+"Returns").val();
					
					if(port == 'Port Angeles'){
						second_port = 'Victoria';
					} else {
						second_port = 'Port Angeles';
					}
					ajaxTimeLabelFast2(return_date,inventory_id,second_port);					
				break;
				
				default:
					//get new sailing times
					ajaxTimeLabelFast1(depart_date,inventory_id,port);						
				break;
			}			
		});
		// creates new vehicle select boxes for user to choose which type of vehicle also adds a hidden element for overlength vehicles
		$("#vehicle_count").keyup(function(){
			var vehicle_count = parseInt($(this).val());
			if (!vehicle_count) {vehicle_count = 0}
			var index = $("#formFerry").attr('index');
			
			$("#extraVehicleAndIncUnitsDiv .vtaiud").remove();
			
			for (var i=0; i < (vehicle_count-1); i++) {
				var clonePrimary = $("#vtaiud-primary").clone();
				$("#extraVehicleAndIncUnitsDiv").append(clonePrimary);  
			
			}
			$("#vehicleTypeAndIncUnitsDiv #vehicleTypeLabel").html('Select Vehicle 1 Type');
			$("#extraVehicleAndIncUnitsDiv .vtaiud").each(function(en){
				var idx = en+1;
				var labelCount = idx + 1;
				$(this).find('.vehicle_type option[value=""]').attr('selected','selected');
				$(this).find('#overlengthDiv').addClass('hide');
				$(this).find('#overlengthAmount').val('');
				$(this).find('.vehicle_type').attr('name','data[Reservation]['+index+'][vehicle]['+idx+'][inventory_item_id]');
				$(this).find('#overlengthAmount').attr('name','data[Reservation]['+index+'][vehicle]['+idx+'][overlength]');
				$(this).find('#vehicleTypeLabel').html('Select Vehicle '+labelCount+' Type');
				$(this).find('.towed_units').attr('name','data[Reservation]['+index+'][vehicle]['+idx+'][towed_unit]');
			});

			//edit the driver form field to reflect the changes
			$(".drivers").val(vehicle_count);
			reservation_ferry.addScripts();
		});
		$(".vehicle_type").change(function(){
			var vehicle_type = $(this).find('option:selected').val();

			if(vehicle_type == '23'){
				$(this).parents('.vtaiud:first').find('#overlengthDiv').removeClass('hide');
			} else {
				$(this).parents('.vtaiud:first').find('#overlengthDiv').addClass('hide');
			}
			$(this).parent().parent().find('#overlengthAmount').val('');
			$(this).parent().parent().find('#overlengthDiv').removeClass('error');
			$(this).parent().parent().find('#overlengthDiv .help-block').html('');

		});
		$("#motorcycle_count").keyup(function(){
			var motorcycle_count = parseInt($(this).val());
			if (!motorcycle_count) {motorcycle_count = 0}
			var index = $("#formFerry").attr('index');
			$("#extraMotorcycleAndIncUnitsDiv .mtaiud").remove();
			for (var i = 0; i < (motorcycle_count-1); i++){
				var clonePrimary = $("#motorcycleTypeAndIncUnitsDiv #mtaiud-primary").clone();
				$("#extraMotorcycleAndIncUnitsDiv").html(clonePrimary);  
			}

			$("#motorcycleTypeAndIncUnitsDiv #motorcycleTypeLabel").html('Select Motorcycle 1 Type');
			$("#extraMotorcycleAndIncUnitsDiv .mtaiud").each(function(en){
				var idx = en+1;
				var labelCount = idx + 1;
				$(this).find('.motorcycle_type option[value=""]').attr('selected','selected');

				$(this).find('.motorcycle_type').attr('name','data[Reservation]['+index+'][motorcycle]['+idx+'][inventory_item_id]');
				$(this).find('#motorcycleTypeLabel').html('Select Motorcycle '+labelCount+' Type');
			});
			$("#motorcycle-adults").val(motorcycle_count);
		});		
		$("#bicycle_count").keyup(function(){
			
			var bicycle_count = parseInt($(this).val());
			if (!bicycle_count) {bicycle_count = 0}
			$("#bicycle-adults").val(bicycle_count);
			
		});					
		$(".overlengthInput").blur(function(){
			var amount = parseInt($(this).val());
			if(amount <= 18){
				$(this).parent().addClass('error');
				$(this).parent().find('.help-block').html('This value must be greater than 18.');
				$(this).parent().parent().find('.vehicleTypeDiv').addClass('error');
				$(this).parent().parent().find('.vehicleTypeDiv .help-block').html('Error: ');
				
			} else {
				$(this).parent().removeClass('error');
				$(this).parent().find('.help-block').html('');		
				$(this).parent().parent().find('.vehicleTypeDiv').removeClass('error');
				$(this).parent().parent().find('.vehicleTypeDiv .help-block').html('');		
			}
		});
	
		$("#acceptSummary").click(function(){
			var checked = $(this).attr('checked');
			switch(checked){
				case 'checked':
					$(this).parents('div:first').removeClass('alert-error').addClass('alert-success');
					$(this).parent().removeClass('text-error').addClass('text-success');
					$("#addToReservation").removeAttr('disabled');
					$("#addToReservation").addClass('btn-bbfl');
				break;
				
				default:
					$(this).parents('div:first').removeClass('alert-success').addClass('alert-error');
					$(this).parent().removeClass('text-success').addClass('text-error');
					$("#addToReservation").attr('disabled','disabled');
					$("#addToReservation").removeClass('btn-bbfl');
				break;
			}
		});

	},
	//scripts that arrive after ajax call
	addScripts: function(){
		
		$("#departTable tbody .touch").click(function(){

			var schedule_id = $(this).attr('schedule_id');
			$('#departTable tbody tr').removeClass('selected');
			$('#departTable tbody tr').attr('status','notselected');
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$("#departTableDiv").removeClass('error');
			$("#departTableDiv").find('.help-block').html('');		
		});	
		$("#returnTable tbody .touch").click(function(){

			var schedule_id = $(this).attr('schedule_id');
			$('#returnTable tbody tr').removeClass('selected');
			$('#returnTable tbody tr').attr('status','notselected');
			$(this).addClass('selected');
			$(this).attr('status','selected');
			$("#returnTableDiv").removeClass('error');
			$("#returnTableDiv").find('.help-block').html('');		
		});	
		$(".vehicle_type").change(function(){
			var vehicle_type = $(this).find('option:selected').val();
			if(vehicle_type != ''){
				$(this).parent().removeClass('error');
				$(this).parent().find('.help-block').html('');
				$(this).parent().parent().find('#overlengthAmount').val('');
				$(this).parent().parent().find('#overlengthDiv').removeClass('error');
				$(this).parent().parent().find('#overlengthDiv .help-block').html('');
				if(vehicle_type == '23'){
					$(this).parents('.vtaiud:first').find('#overlengthDiv').removeClass('hide');
				} else {
					$(this).parents('.vtaiud:first').find('#overlengthDiv').addClass('hide');
				}
			} else {
				$(this).parent().parent().find('#overlengthAmount').val('');
				$(this).parent().parent().find('#overlengthDiv').removeClass('error');
				$(this).parent().parent().find('#overlengthDiv .help-block').html('');
				$(this).parent().removeClass('error');
				$(this).parent().find('.help-block').html('');
			}

		});
		$(".overlengthInput").blur(function(){
			var amount = parseInt($(this).val());
			if(amount <= 18){
				$(this).parent().addClass('error');
				$(this).parent().find('.help-block').html('This value must be greater than 18.');
				$(this).parent().parent().find('.vehicleTypeDiv').addClass('error');
				$(this).parent().parent().find('.vehicleTypeDiv .help-block').html('Error: ');
				
			} else {
				$(this).parent().removeClass('error');
				$(this).parent().find('.help-block').html('');		
				$(this).parent().parent().find('.vehicleTypeDiv').removeClass('error');
				$(this).parent().parent().find('.vehicleTypeDiv .help-block').html('');		
			}
		});

	},
	createSummary: function(inventory_id, depart_date, return_date, port, trip_type, schedule_id1,schedule_id2){
		
		//first validate the info and check for errors
		var index = $("#formFerry").attr('index');
		if(port == 'Port Angeles'){
			return_port = 'Victoria';
		} else {
			return_port = 'Port Angeles';
		}
		
		var trip_message = port+' to '+return_port;
		var trip_type_message = trip_type;

		if(trip_type =='roundtrip'){
			
			var trip_dates = depart_date+' - '+return_date;
			//check depart and return times
			var selected = $("#departTable tbody tr[status='selected']").length;
			if(selected == 0){
				$("#departTableDiv").addClass('error');
				$("#departTableDiv").find('.help-block').html('You must selected a deport sailing time.');
			} else {
				$("#departTableDiv").removeClass('error');
				$("#departTableDiv").find('.help-block').html('');				
			}
			var selected = $("#returnTable tbody tr[status='selected']").length;
			if(selected == 0){
				$("#returnTableDiv").addClass('error');
				$("#returnTableDiv").find('.help-block').html('You must selected a return sailing time.');
			} else {
				$("#returnTableDiv").removeClass('error');
				$("#returnTableDiv").find('.help-block').html('');				
			}
		
			if(depart_date == ''){
				$("#Reservation"+index+"Departs").parent().parent().addClass('error');
				$("#Reservation"+index+"Departs").parent().parent().find('.help-block').html('This value field cannot be left empty.');
			} else {
				$("#Reservation"+index+"Departs").parent().parent().removeClass('error');
				$("#Reservation"+index+"Departs").parent().parent().find('.help-block').html('');	
			}
			
			if(return_date == ''){
				$("#Reservation"+index+"Returns").parent().parent().addClass('error');
				$("#Reservation"+index+"Returns").parent().parent().find('.help-block').html('This value field cannot be left empty.');
			} else {
				$("#Reservation"+index+"Returns").parent().parent().removeClass('error');
				$("#Reservation"+index+"Returns").parent().parent().find('.help-block').html('');	
			}
		} else {
			var trip_dates = depart_date;
			var selected = $("#departTable tbody tr[status='selected']").length;
			
			if(selected == 0){
				$("#departTableDiv").addClass('error');
				$("#departTableDiv").find('.help-block').html('You must selected a deport sailing time.');
			} else {
				$("#departTableDiv").removeClass('error');
				$("#departTableDiv").find('.help-block').html('');				
			}
		
			if(depart_date == ''){
				$("#Reservation"+index+"Departs").parent().parent().addClass('error');
				$("#Reservation"+index+"Departs").parent().parent().find('.help-block').html('This value field cannot be left empty.');
			} else {
				$("#Reservation"+index+"Departs").parent().parent().removeClass('error');
				$("#Reservation"+index+"Departs").parent().parent().find('.help-block').html('');	
			}
			
			$("#returnTableDiv").removeClass('error');
			$("#returnTableDiv").find('.help-block').html('');	
		}

		

		
		switch(inventory_id){
			case '2': //vehicles
				var adults = $("#inventory-Vehicles .adults").val();
				var children = $("#inventory-Vehicles .children").val();	
				var infants = $("#inventory-Vehicles .infants").val();
				if(adults == ''){
					var adults = 0;
				}
				if(children == ''){
					var children = 0;
				}
				if(infants == ''){
					var infants = 0;
				}
				
				
				
				var vehicle_count = $("#vehicle_count").val();
				
				
				if(vehicle_count =='' || vehicle_count == '0'){
					
					$("#vehicle_count").parent().addClass('error');
					$("#vehicle_count").parent().find('.help-block').html('This value field cannot be left empty.');
				} else { 
					$("#vehicle_count").parent().removeClass('error');
					$("#vehicle_count").parent().find('.help-block').html('');	
					var vehicle_type = '';
					var idx = -1;
					vehicle_type = {};
						
					$(".vehicle_type").each(function(){
						idx = idx + 1;
						vehicle_type[idx] = {};
						var void_check = $(this).find('option:selected').val();
						var overlength = $(this).parent().parent().find('#overlengthAmount').val();
						var towed_unit = $(this).parent().parent().find('.towed_units option:selected').val();
						
						if(void_check == ''){
							$(this).parent().addClass('error');
							$(this).parent().find('.help-block').html('This value field cannot be left empty.');
						} else if(void_check == '22') {
							$(this).parent().removeClass('error');
							$(this).parent().find('.help-block').html('');	
							$(this).parent().parent().find('#overlengthDiv').removeClass('error');
							$(this).parent().parent().find('#overlengthDiv .help-block').html('');							
						} else {
							$(this).parent().removeClass('error');
							$(this).parent().find('.help-block').html('');	
							$(this).parent().parent().find('#overlengthDiv').removeClass('error');
							$(this).parent().parent().find('#overlengthDiv .help-block').html('');							
							
							
							var overlengthCheck = $(this).parent().parent().find('.overlengthInput').val();
							if(overlengthCheck == ''){
								$(this).parent().parent().find('#overlengthAmount').parent().addClass('error');
								$(this).parent().parent().find('#overlengthAmount').parent().find('.help-block').html('This field cannot be left empty');
							} else {
								$(this).parent().parent().find('#overlengthAmount').parent().removeClass('error');
								$(this).parent().parent().find('#overlengthAmount').parent().find('.help-block').html('');				
							}
						}

						vehicle_type[idx]['type'] = $(this).find('option:selected').val();
						vehicle_type[idx]['overlength'] = overlength;
						vehicle_type[idx]['towed_unit'] = towed_unit;
						
					});
					
					// //check overlength types
					// $(".overlengthInput").each(function(){
						// var overlengthVal = $(this).val();
						// var overType = $(this).parent
						// if(overlengthVal == ''){
							// $(this).parent().parent().find('.vehicleTypeDiv').addClass('error');
							// $(this).parent().parent().find('.vehicleTypeDiv .help-block').html('Error:');
							// $(this).parent().addClass('error');
							// $(this).parent().find('.help-block').html('Overlength value cannot be left empty');
						// } else {
							// $(this).parent().parent().find('.vehicleTypeDiv').removeClass('error');
							// $(this).parent().parent().find('.vehicleTypeDiv .help-block').html('');
							// $(this).parent().removeClass('error');
							// $(this).parent().find('.help-block').html('');						
						// }
					// });
					
					
								
				}
			
					
			break;
			
			case '1': //passengers
				var vehicle_count = 0;
				var vehicle_type =  'Passengers';
				var adults = $("#inventory-Passengers .adults").val();
				var children = $("#inventory-Passengers .children").val();
				var infants = $("#inventory-Passengers .infants").val();

			break;
			
			case '3': //motorcycles
				var adults = $("#inventory-Motorcycles .adults").val();
				var children = $("#inventory-Motorcycles .children").val();	
				var infants = $("#inventory-Motorcycles .infants").val();
				if(adults == ''){
					var adults = 0;
				}
				if(children == ''){
					var children = 0;
				}
				if(infants == ''){
					var infants = 0;
				}	
				var vehicle_count = $("#motorcycle_count").val();
				var vehicle_type =  {};
				var idx = -1;				
				$(".motorcycle_type").each(function(){
					idx = idx + 1;
					vehicle_type[idx] = {};
					var void_check = $(this).find('option:selected').val();
					
					if(void_check == ''){
						$(this).parent().addClass('error');
						$(this).parent().find('.help-block').html('This value field cannot be left empty.');
						
						//alert(void_check);	
					} else {
						$(this).parent().removeClass('error');
						$(this).parent().find('.help-block').html('');	
						//alert(void_check);							
					}

					vehicle_type[idx]['type'] = $(this).find('option:selected').val();
					
				});				
				
				if(vehicle_count =='' || vehicle_count == '0'){
					$("#motorcycle_count").parent().addClass('error');
					$("#motorcycle_count").parent().find('.help-block').html('This value field cannot be left empty.');
				} else {
					$("#motorcycle_count").parent().removeClass('error');
					$("#motorcycle_count").parent().find('.help-block').html('');					
				}
				
				
				// if(vehicle_type ==''){
					// $(".motorcycle_type").parent().addClass('error');
					// $(".motorcycle_type").parent().find('.help-block').html('This value field cannot be left empty.');
				// } else {
					// $(".motorcycle_type").parent().removeClass('error');
					// $(".motorcycle_type").parent().find('.help-block').html('');					
				// }	

			break;
			
			default: //bicycles
				var adults = $("#inventory-Bicycles .adults").val();
				var children = $("#inventory-Bicycles .children").val();
				var infants = $("#inventory-Bicycles .infants").val();
				if(adults == ''){
					var adults = 0;
				}
				if(children == ''){
					var children = 0;
				}
				if(infants == ''){
					var infants = 0;
				}
				var vehicle_count = $("#bicycle_count").val();	
				var vehicle_type = '28';	
				if(vehicle_count =='' || vehicle_count == '0'){
					$("#bicycle_count").parent().addClass('error');
					$("#bicycle_count").parent().find('.help-block').html('This value field cannot be left empty.');
				} else {
					$("#bicycle_count").parent().removeClass('error');
					$("#bicycle_count").parent().find('.help-block').html('');					
				}	
			break;
		}
		//update trip summary
		$("#trip_summary").html(trip_message);
		$("#tripType").html(trip_type_message);
		
		//update trip dates
		$("#tripDates").html(trip_dates);
		
		if(adults == 0){
			adults = 'zero';
		}
		if(children == 0){
			children ='zero';
		}
		if(infants == 0){
			infants = 'zero';
		}
		if(vehicle_count == 0){
			vehicle_count = 'zero';
		}
	
		
		//create hidden input fields for next page
		var index = $('#formFerry').attr('index');
		var schedule_id1_input = '<input type="hidden" name="data[Reservation]['+index+'][schedule_id1]" value="'+schedule_id1+'"/>';
		var schedule_id2_input = '<input type="hidden" name="data[Reservation]['+index+'][schedule_id2]" value="'+schedule_id2+'"/>';
		var inventory_id_input = '<input type="hidden" name="data[Reservation]['+index+'][inventory_id]" value="'+inventory_id+'"/>';
		
		$("#hiddenFormInputs").html(schedule_id1_input+schedule_id2_input+inventory_id_input);
		
		//count errors if no errors show summary
		var errors =$("fieldset .error").length;
		if(errors == 0){
			
			$.post(
				'/reservations/request_get_summary',
				{
					type:'RESERVATION_GET_SUMMARY',
					inventory_id: inventory_id,
					schedule_id1: schedule_id1,
					schedule_id2: schedule_id2,
					adults: adults,
					children: children,
					infants: infants,
					vehicle_count: vehicle_count,
					vehicle_type: vehicle_type,
					trip_type: trip_type,
					port: port,
				},	function(results){
					$("#tripSummaryTable").html(results);
					$("#calcButtonDiv").hide();
					$("#tripSummaryDiv").fadeIn();
					reservation_ferry.consoleLogging();
				}
			);				

			
			
		}
		
	},
	//console logging for admins
	consoleLogging: function(){
		var index = $("#formFerry").attr('index');
		var trip_type = $(".tripRadio[checked='checked']").val();
		var port = $("#Reservation"+index+"DepartPort").find('option:selected').val();
			switch(port){
				case 'Port Angeles':
					return_port = 'Victoria';
					
				break;
				default:
					return_port = 'Port Angeles';
				break;
			}
		var depart_date = $("#Reservation"+index+"Departs").val();
		var depart_time = $("#departTable tbody .selected td:first-child").html();
		var return_date = $("#Reservation"+index+"Returns").val();
		var return_time = $("#returnTable tbody .selected td:first-child").html();
		var inventory_id = $("#inventoryList .active").parent().attr('inventory_id');
		var reservation_type = $("#inventoryList .active span").html();
		switch(trip_type){
			case 'roundtrip':
				var schedule_id1 = $("#departTable tbody tr[status='selected']").attr('schedule_id');
				var schedule_id2 = $("#returnTable tbody tr[status='selected']").attr('schedule_id');					
			break;
			
			default:
				var schedule_id1 = $("#departTable tbody tr[status='selected']").attr('schedule_id');
				var schedule_id2 = 'zero';						
			break;
		}		
		switch(inventory_id){
			case '2': //vehicles
				var adults = $("#inventory-Vehicles .adults").val();
				var children = $("#inventory-Vehicles .children").val();	
				var infants = $("#inventory-Vehicles .infants").val();
				if(adults == ''){
					var adults = 0;
				}
				if(children == ''){
					var children = 0;
				}
				if(infants == ''){
					var infants = 0;
				}
				var vehicle_count = $("#vehicle_count").val();
				var vehicle_type = $("#vehicle_type option:selected").html();	
			
					
			break;
			
			case '1': //passengers
				
				var vehicle_type =  'Passengers';
				var adults = $("#inventory-Passengers .adults").val();
				var children = $("#inventory-Passengers .children").val();
				var infants = $("#inventory-Passengers .infants").val();
				var vehicle_count = parseInt(adults)+parseInt(children)+parseInt(infants);
			break;
			
			case '3': //motorcycles
				var adults = $("#inventory-Motorcycles .adults").val();
				var children = $("#inventory-Motorcycles .children").val();	
				var infants = $("#inventory-Motorcycles .infants").val();
				if(adults == ''){
					var adults = 0;
				}
				if(children == ''){
					var children = 0;
				}
				if(infants == ''){
					var infants = 0;
				}	
				var vehicle_count = $("#motorcycle_count").val();
				var vehicle_type =  $(".motorcycle_type option:selected").html();

			break;
			
			default: //bicycles
				var adults = $("#inventory-Bicycles .adults").val();
				var children = $("#inventory-Bicycles .children").val();
				var infants = $("#inventory-Bicycles .infants").val();
				if(adults == ''){
					var adults = 0;
				}
				if(children == ''){
					var children = 0;
				}
				if(infants == ''){
					var infants = 0;
				}
				var vehicle_count = $("#bicycle_count").val();	
				var vehicle_type = 'Bicycles';	

			break;
		}		
		
		//print global variables
		window.console.log('FERRY RESERVATION LOG');
		window.console.log('(1) Trip Details');
		window.console.log(' - Trip Type = '+trip_type);
		switch(trip_type){
			case 'roundtrip':
				var trips = 2;
				window.console.log(' - [Departing] '+port+' to '+return_port+' on '+depart_date+' @ '+depart_time);		
				window.console.log(' - [Returning] '+return_port+' to '+port+' on '+return_date+' @ '+return_time);	
			break;
			
			default:
				var trips = 1;
				window.console.log(' - [Departing] '+port+' to '+return_port+' on '+depart_date+' @ '+depart_time);	
				window.console.log(' - [Returning] No return scheduled.');
			break;
		}
		window.console.log(' - Vehicle Type = '+vehicle_type);
		window.console.log(' - Reservation type = '+reservation_type);
		window.console.log(' - Driver(s) = '+vehicle_count);
		window.console.log(' - Adult(s) (ages 12+) = '+adults);
		window.console.log(' - Child(ren) (ages 5-11) = '+children);
		window.console.log(' - Child(ren) (ages 0-4) = '+infants);
		window.console.log(' ');
		window.console.log('(2) Inventory Levels & Capacity');
		window.console.log(' - Depart Sailing Passenger limits = [/] = %');
		window.console.log(' - Return Sailing Passenger limits = [/] = %');
		window.console.log(' - Depart Sailing Inventory limits () = [/] = %');
		window.console.log(' - Return Sailing Inventory limits () = [/] = %');
		window.console.log(' ');
		
		if(adults != 0){
			var adult_rate = (parseFloat($("#adult_rate").html()) / trips) / parseInt(adults);	
		} else {
			var adult_rate = (parseFloat($("#adult_rate").html()) / trips);
		}
		var adult_rate = Math.round(adult_rate * 100)  / 100;
		var adult_rate = adult_rate.toFixed(2);
		var adult_total = $("#adult_rate").html();
		if(children != 0){
			var child_rate = (parseFloat($("#child_rate").html()) / trips) / parseInt(children);	
		} else {
			var child_rate = (parseFloat($("#child_rate").html()) / trips);
		}
		
		var child_rate = Math.round(child_rate * 100)  / 100;
		var child_rate = child_rate.toFixed(2);
		var child_total = $("#child_rate").html();
		var infant_rate = '0.00';
		var infant_total = '0.00';
		if(vehicle_count != 0){
			var vehicle_rate = (parseFloat($("#vehicle_rate").html()) / trips) / parseInt(vehicle_count);	
		} else {
			var vehicle_rate = (parseFloat($("#vehicle_rate").html()) / trips);
		}
		var vehicle_rate = Math.round(vehicle_rate * 100)  / 100;
		var vehicle_rate = vehicle_rate.toFixed(2);
		var vehicle_total = $("#vehicle_rate").html();
		var subtotal = $("#subtotal").html();
		var online_fee = $("#online_fee").html();
		if(online_fee == ''){
			online_fee = 0.00;
		}
		var total = $("#total").html();
		var dueAtCheckout = $("#dueAtCheckout").html();
		var dueAtArrival = $("#dueAtArrival").html();
		
		window.console.log('(3) Trip Summary');
		switch(inventory_id){
			case '1':
			window.console.log(' - '+adults+' Adult(s) (ages 12+) @ $'+adult_rate+' x '+trips+' = $'+adult_total);
			window.console.log(' - '+children+' Child(ren) (ages 5-11) @ $'+child_rate+' x '+trips+' = $'+child_total);
			window.console.log(' - '+infants+' Child(ren) (ages 0-4) @ $0.00 x'+trips+' = $0.00');			
			break;
			
			default:
			window.console.log(' - '+vehicle_count+' '+vehicle_type+' @ $'+vehicle_rate+' x '+trips+' = '+vehicle_total);
			window.console.log(' - '+adults+' Adult(s) (ages 12+) @ $'+adult_rate+' x '+trips+' = $'+adult_total);
			window.console.log(' - '+children+' Child(ren) (ages 5-11) @ $'+child_rate+' x '+trips+' = $'+child_total);
			window.console.log(' - '+infants+' Child(ren) (ages 0-4) @ $0.00 x'+trips+' = $0.00');			
			break;
		}
		window.console.log(' - [Subtotal] = $'+subtotal);
		window.console.log(' - [Online Reservation Fee] = $'+online_fee);
		window.console.log(' - [Total] = $'+total);
		window.console.log(' - [Due at Checkout] = $'+dueAtCheckout);
		window.console.log(' - [Due at Arrival] = $'+dueAtArrival);

		
	}
}
var ajaxTimeLabelFast1 = function(date, inventory_id, port){
	if(date != ''){
		var d = new Date(date);
		var n = d.getTime() / 1000;		
	} else {
		n = 'NoDate'
	}
	
	switch(inventory_id){
		case '2': //vehicles
			var adults = $("#inventory-Vehicles .adults").val();
			var children = $("#inventory-Vehicles .children").val();	
			var infants = $("#inventory-Vehicles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#vehicle_count").val();
			if(vehicle_count == '' || vehicle_count == '0'){
				var vehicle_count = 'zero';
			}			
			var vehicle_type = $("#vehicle_type option:selected").val();	
							
		break;
		
		case '1': //passengers
			var vehicle_count = 'zero';
			var vehicle_type =  'Passengers';
			var adults = $("#inventory-Passengers .adults").val();
			var children = $("#inventory-Passengers .children").val();
			var infants = $("#inventory-Passengers .infants").val();
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
			var adults = $("#inventory-Motorcycles .adults").val();
			var children = $("#inventory-Motorcycles .children").val();	
			var infants = $("#inventory-Motorcycles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#motorcycle_count").val();
			var vehicle_type =  $(".motorcycle_type option:selected").val();

		break;
		
		default: //bicycles
			var adults = $("#inventory-Bicycles .adults").val();
			var children = $("#inventory-Bicycles .children").val();
			var infants = $("#inventory-Bicycles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#bicycle_count").val();	
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
			$("#departTable tbody").html(results);
			reservation_ferry.addScripts();

		}
	);	

}
var ajaxTimeLabelFast2 = function(date, inventory_id, port){
	if(date != ''){
		var d = new Date(date);
		var n = d.getTime() / 1000;		
	} else {
		n = 'NoDate'
	}
	
	switch(inventory_id){
		case '2': //vehicles
			var adults = $("#inventory-Vehicles .adults").val();
			var children = $("#inventory-Vehicles .children").val();	
			var infants = $("#inventory-Vehicles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#vehicle_count").val();
			if(vehicle_count == '' || vehicle_count == '0'){
				var vehicle_count = 'zero';
			}			
			var vehicle_type = $("#vehicle_type option:selected").val();	
							
		break;
		
		case '1': //passengers
			var vehicle_count = 'zero';
			var vehicle_type =  'Passengers';
			var adults = $("#inventory-Passengers .adults").val();
			var children = $("#inventory-Passengers .children").val();
			var infants = $("#inventory-Passengers .infants").val();
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
			var adults = $("#inventory-Motorcycles .adults").val();
			var children = $("#inventory-Motorcycles .children").val();	
			var infants = $("#inventory-Motorcycles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#motorcycle_count").val();
			var vehicle_type =  $(".motorcycle_type option:selected").val();

		break;
		
		default: //bicycles
			var adults = $("#inventory-Bicycles .adults").val();
			var children = $("#inventory-Bicycles .children").val();
			var infants = $("#inventory-Bicycles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#bicycle_count").val();	
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
			$("#returnTable tbody").html(results);
			reservation_ferry.addScripts();

		}
	);	

}
var ajaxTimeLabelFastOverlength1 = function(date, inventory_id, port, vehicle_types){
	if(date != ''){
		var d = new Date(date);
		var n = d.getTime() / 1000;		
	} else {
		n = 'NoDate'
	}
	var adults = $("#inventory-Vehicles .adults").val();
	var children = $("#inventory-Vehicles .children").val();	
	var infants = $("#inventory-Vehicles .infants").val();
	if(adults == '' || adults == '0'){
		var adults = 'zero';
	}
	if(children == '' || children == '0'){
		var children = 'zero';
	}
	if(infants == '' || infants == '0'){
		var infants = 'zero';
	}
	var vehicle_count = $("#vehicle_count").val();
	if(vehicle_count == '' || vehicle_count == '0'){
		var vehicle_count = 'zero';
	}			

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
			reservation_ferry.addScripts();

		}
	);	

}
var ajaxTimeLabelFastOverlength2 = function(date, inventory_id, port, vehicle_types){
	if(date != ''){
		var d = new Date(date);
		var n = d.getTime() / 1000;		
	} else {
		n = 'NoDate'
	}
	var adults = $("#inventory-Vehicles .adults").val();
	var children = $("#inventory-Vehicles .children").val();	
	var infants = $("#inventory-Vehicles .infants").val();
	if(adults == '' || adults == '0'){
		var adults = 'zero';
	}
	if(children == '' || children == '0'){
		var children = 'zero';
	}
	if(infants == '' || infants == '0'){
		var infants = 'zero';
	}
	var vehicle_count = $("#vehicle_count").val();
	if(vehicle_count == '' || vehicle_count == '0'){
		var vehicle_count = 'zero';
	}			

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
			reservation_ferry.addScripts();

		}
	);	

}
var ajaxTimeLabelSlow1 = function(date, inventory_id, port){
	if(date != ''){
		var d = new Date(date);
		var n = d.getTime() / 1000;		
	} else {
		n = 'NoDate'
	}
	
	switch(inventory_id){
		case '2': //vehicles
			var adults = $("#inventory-Vehicles .adults").val();
			var children = $("#inventory-Vehicles .children").val();	
			var infants = $("#inventory-Vehicles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#vehicle_count").val();
			if(vehicle_count == '' || vehicle_count == '0'){
				var vehicle_count = 'zero';
			}			
			var vehicle_type = $("#vehicle_type option:selected").val();	
							
		break;
		
		case '1': //passengers
			var vehicle_count = 'zero';
			var vehicle_type =  'Passengers';
			var adults = $("#inventory-Passengers .adults").val();
			var children = $("#inventory-Passengers .children").val();
			var infants = $("#inventory-Passengers .infants").val();
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
			var adults = $("#inventory-Motorcycles .adults").val();
			var children = $("#inventory-Motorcycles .children").val();	
			var infants = $("#inventory-Motorcycles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#motorcycle_count").val();
			var vehicle_type =  $(".motorcycle_type option:selected").val();

		break;
		
		default: //bicycles
			var adults = $("#inventory-Bicycles .adults").val();
			var children = $("#inventory-Bicycles .children").val();
			var infants = $("#inventory-Bicycles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#bicycle_count").val();	
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
			$("#departTable tbody").html($(results).fadeIn('slow'));
			reservation_ferry.addScripts();

		}
	);	

}
var ajaxTimeLabelSlow2 = function(date, inventory_id, port){
	if(date != ''){
		var d = new Date(date);
		var n = d.getTime() / 1000;		
	} else {
		n = 'NoDate'
	}
	
	switch(inventory_id){
		case '2': //vehicles
			var adults = $("#inventory-Vehicles .adults").val();
			var children = $("#inventory-Vehicles .children").val();	
			var infants = $("#inventory-Vehicles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#vehicle_count").val();
			if(vehicle_count == '' || vehicle_count == '0'){
				var vehicle_count = 'zero';
			}			
			var vehicle_type = $("#vehicle_type option:selected").val();	
							
		break;
		
		case '1': //passengers
			var vehicle_count = 'zero';
			var vehicle_type =  'Passengers';
			var adults = $("#inventory-Passengers .adults").val();
			var children = $("#inventory-Passengers .children").val();
			var infants = $("#inventory-Passengers .infants").val();
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
			var adults = $("#inventory-Motorcycles .adults").val();
			var children = $("#inventory-Motorcycles .children").val();	
			var infants = $("#inventory-Motorcycles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#motorcycle_count").val();
			var vehicle_type =  $(".motorcycle_type option:selected").val();

		break;
		
		default: //bicycles
			var adults = $("#inventory-Bicycles .adults").val();
			var children = $("#inventory-Bicycles .children").val();
			var infants = $("#inventory-Bicycles .infants").val();
			if(adults == '' || adults == '0'){
				var adults = 'zero';
			}
			if(children == '' || children == '0'){
				var children = 'zero';
			}
			if(infants == '' || infants == '0'){
				var infants = 'zero';
			}
			var vehicle_count = $("#bicycle_count").val();	
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
			$("#returnTable tbody").html($(results).fadeIn('slow'));
			reservation_ferry.addScripts();

		}
	);	

}
var ajaxTimeLabelSlowOverlength1 = function(date, inventory_id, port, vehicle_types){
	if(date != ''){
		var d = new Date(date);
		var n = d.getTime() / 1000;		
	} else {
		n = 'NoDate'
	}
	var adults = $("#inventory-Vehicles .adults").val();
	var children = $("#inventory-Vehicles .children").val();	
	var infants = $("#inventory-Vehicles .infants").val();
	if(adults == '' || adults == '0'){
		var adults = 'zero';
	}
	if(children == '' || children == '0'){
		var children = 'zero';
	}
	if(infants == '' || infants == '0'){
		var infants = 'zero';
	}
	var vehicle_count = $("#vehicle_count").val();
	if(vehicle_count == '' || vehicle_count == '0'){
		var vehicle_count = 'zero';
	}			

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
			reservation_ferry.addScripts();

		}
	);	

}
var ajaxTimeLabelSlowOverlength2 = function(date, inventory_id, port, vehicle_types){
	if(date != ''){
		var d = new Date(date);
		var n = d.getTime() / 1000;		
	} else {
		n = 'NoDate'
	}
	var adults = $("#inventory-Vehicles .adults").val();
	var children = $("#inventory-Vehicles .children").val();	
	var infants = $("#inventory-Vehicles .infants").val();
	if(adults == '' || adults == '0'){
		var adults = 'zero';
	}
	if(children == '' || children == '0'){
		var children = 'zero';
	}
	if(infants == '' || infants == '0'){
		var infants = 'zero';
	}
	var vehicle_count = $("#vehicle_count").val();
	if(vehicle_count == '' || vehicle_count == '0'){
		var vehicle_count = 'zero';
	}			

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
			reservation_ferry.addScripts();

		}
	);	

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

