$(document).ready(function(){


/*
 * Attractions Edit page
 */

	$("#attraction_name,#attraction_location").html(''); //clear the attraction name and attraction location fields on page refresh
	$(".attractionNameInput").val(''); //clear the attraction name inputs and location inputs on page refersh
	attractions.cityStateCountry('.cityInput','#stateInput','.countrySelect option'); //auto fill inputs based on city search
	attractions.series1check(); 
	
	//if a attraction url has been successfully created, then run the script for stepy form validation
	if($("#attraction").length ==1){
		attractions.stepy('#attraction');	
	}
	
	//mask all of the inputs for phone numbers
	attractions.mask();
	
	//change the number format on specified input fields
	attractions.numberformat();
	
	//add datepicker to the selected form fields
	attractions.datepicker();
	
	attractions.pageLoadEvents();
	
});	

/**
 * All Functions with attraction form validation
 */
attractions = {
	mask: function(){
		//phone formatting
		$(".phone1Input").mask("+9 (999) 999-9999");
		$(".phone2Input").mask("+9 (999) 999-9999");
		$(".phone3Input").mask("+9 (999) 999-9999");
		$("#primary_phone").mask("+9 (999) 999-9999");
		$("#alt_phone").mask("+9 (999) 999-9999");
		$(".blockBeginDate").mask("99/99/9999");
		$(".blockEndDate").mask("99/99/9999");	
	},
	numberformat: function(){
		//number formatting
		$(".attractionAddOnPrice").priceFormat({'prefix':''});

		$('.attractionExtraFee').priceFormat({'prefix':''});
		$('.inventoryTaxRate').priceFormat({
			'prefix':'',
			limit:5
		});
		$('.inventoryNetRate').priceFormat({'prefix':''});
		$('.inventoryGrossRate').priceFormat({
			'prefix':'',	
		});
		$('.inventoryMarkupRate').priceFormat({'prefix':''});

		$('.taxrate').priceFormat({
			'prefix':'',
			limit:5
		});
		$(".netRate").priceFormat({
			'prefix':'',
		});
		$("#AttractionStartingPrice").priceFormat({
			'prefix':'',
		});
		$("#attractionStartingPrice").priceFormat({
			'prefix':'',
		});
		$(".attractionAddOnNet").priceFormat({
			'prefix':'',
		});

		$(".attractionAddOnGross").priceFormat({
			'prefix':'',
		});
		$(".attractionPlusFeeNet").priceFormat({
			'prefix':'',
		});
	},
	datepicker: function() {
		$(".blockBeginDate").datepicker().on('changeDate', function(ev){
  			$('.blockBeginDate').datepicker('hide');
		});
		
		$(".blockEndDate").datepicker().on('changeDate', function(ev){
  			$('.blockEndDate').datepicker('hide');
		});
		$("#Attraction_block0StartDate").datepicker().on('changeDate', function(ev){
  			$('#Attraction_block0StartDate').datepicker('hide');
		});
		$("#Attraction_block0EndDate").datepicker().on('changeDate', function(ev){
  			$('#Attraction_block0EndDate').datepicker('hide');
		});	
		$(".fullYear").datepicker().change(function() {
			var date = $(this).val();
			var idx = $(this).attr('idx');
			$('.datepicker td .day').css({'background-color':'red'});
			attraction_tickets.editSelect(date,idx, '#blackoutDatesUl-'+idx,'#blackoutDateCounter-'+idx);

		});
		//focus on date after clicking icon span
		$(".blockBeginSpan").click(function(){
			$(this).parent().find('.blockBeginDate').focus();
			$(this).parent().find('.blockBeginDate').select();
		});
		$(".blockEndSpan").click(function(){
			$(this).parent().find('.blockEndDate').focus();
			$(this).parent().find('.blockEndDate').select();
		});

	},
	pageLoadEvents: function(){
		//on form creation this will make sure that the url is unique and validates any empty fields
		// if successful it will send a get to the same page to finish the attraction form, 1 for manual, 2 for automatic
		$("#buttonSeries1Next").click(function(){
			var name = $('.attractionNameInputEdit').val();
			var location = $(".locationInputEdit").val();
			var url = createUrl(location)+createUrl(name);
			var type_selected = $(".transactionTypeSelect option:selected").val();
			//validate scripts
			if(type_selected=='none'){ //if no attraction creation type is selected
				$(".transactionTypeSelect").parent().attr('class','control-group error');
				$(".transactionTypeSelect").parent().find('.help-inline').html('Reservation Transaction Handler must be selected');				
			} else { 
				$(".transactionTypeSelect").parent().attr('class','control-group');
				$(".transactionTypeSelect").parent().find('.help-inline').html('');			
			}
			if(name == ''){ //if attraction name field is empty
				$(".attractionNameInput").parent().attr('class','control-group error');
				$(".attractionNameInput").parent().find('.help-inline').html('Error: Please provide a attraction name.');
				$("#attractionUrlDiv").attr('class','control-group error');
				$("#attractionUrlDiv p").attr('class','alert alert-error');
				$("#attractionUrlDiv .help-block").html('Not a valid url');
			}
			if(name != '' && type_selected != 'none') {	// if both name and attraction type is selected then run these scripts
				$(".transactionTypeSelect").parent().attr('class','control-group');
				$(".transactionTypeSelect").parent().find('help-inline').html('');
				$(".locationInput").parent().attr('class','control-group');
				$(".locationInput").parent().find('.help-inline').html('');		
				$(".attractionNameInput").parent().attr('class','control-group');
				$(".attractionNameInput").parent().find('.help-inline').html('');
				$("#attractionUrlDiv").attr('class','control-group');
				$("#attractionUrlDiv p").attr('class','well well-small muted');
				$("#attractionUrlDiv .help-block").html('');
				var url = createUrl(location)+createUrl(name);
				
				//check if the url created is valid
				attractions.checkAttractionUrl(url);
			}	
		});
		
		//distance script
		$('.distanceSelect').change(function(){
			var option = $('.distanceSelect option:selected').val();
			$("#unitsType").html(option);
			
		});
		//time script
		$('.cutoffSelect').change(function(){
			var option = $('.cutoffSelect option:selected').val();
			$("#cutoffSpan").html(option);
		});	
		//billingAddress 
		$("#checkBillingAddress").change(function(){
			if(!$("#checkBillingAddress").attr('checked')){
				//remove all the billing address values
				$("#billing_address").val('');
				$("#billing_city").val('');
				$("#billing_state").val('');
				$("#billing_zip").val('');
				$("#billing_country option[value='0']").attr('selected','selected');
				
			} else {
				//copy all of the address values and place it into billing address
				var address = $("#address").val();
				var city = $("#city").val();
				var state = $("#stateInput").val();
				var country = $("#country option:selected").val();
				var zipcode = $("#zipcode").val();
				
				$("#billing_address").val(address);
				$("#billing_city").val(city);
				$("#billing_state").val(state);
				$("#billing_zip").val(zipcode);
				$("#billing_country option[value="+country+"]").attr('selected','selected');
			}
		});
		
		//show hidden form elements
		$("#checkAltContact").change(function(){
			if($(this).attr('checked')){
				$("#altContactInfoDiv").show();
				$("#altInfoBadge").html('Hide');
			} else {
				$("#altContactInfoDiv").hide();
				$("#altInfoBadge").html('Show');
			}
		});
		
		//checks if user wants to do ticket marketing, if checked then div will open up with all the attraction marketing fields
		$("#checkTicketMarketing").change(function(){
			if($(this).attr('checked')){
				$("#createAttractionTicketMarketing").show();
				$("#ticketsBadge").html('Hide');
				
				
			} else {
				$("#createAttractionTicketMarketing").hide();
				$("#ticketsBadge").html('Show');
			}
		});
		
	
		$("#company_info_validate").click(function(){attractions.companyInfoValidate()});
		
		$("#btnUpload").click(function(){
	    	var sendEmpty = $("#imageFindInput").val();
	    	var send = document.getElementById('imageFindInput');
	    	
	    	if (sendEmpty ==''){
	    		alert('Please select a photo from your directory.');
	    	} else {
	    		attractions.processFiles(send.files); 
	    	}
			
		});
		/**
		 * Attraction Block creation
		 */
		$("#addAttractionBlockButton").click(function(){
			var row = $("#attractionBlocksTbody tr").length;
			var start_date = $("#attractionBlocksTbody tr:last-child .blockBeginDate").val();
			var end_date = $("#attractionBlocksTbody tr:last-child .blockEndDate").val();
			attraction_blocks.addBlock(row, start_date,end_date);
		});
		
		/**
		 * Attraction Ticket Creation Step 3 & 4 of wizard
		 */
		$("#createTicketFormButton").click(function(){
			var amount = $("#createTicketInput").val();
			attraction_tickets.validate(amount, '#createTicketFormDiv', '#accordion4');
			
		});
		$("#addTicketRow").click(function(){
			var lastRows =  $("#ticketTbody tr:last-child").attr('id').replace('ticketTr-','');
			var newRow = parseInt(lastRows)+1;
			attraction_tickets.addTicketSchedule(newRow, '#ticketTbody','#accordion4');
		});
		/**
		 * Attraction Add-on creation
		 */
		$("#attractionAddOnButton").click(function(){
			attractions.addOn();
		});
		
		$(".addTicketInventory").click(function(){
			var ticket_id = $(this).attr('ticket');
			var ticket_length = $("#ticketInventoryTbody-"+ticket_id+" tr").length;
			var start_date = $("#ticketInventoryTbody-"+ticket_id+" tr:last-child .blockBeginDate").val();
			var end_date = $("#ticketInventoryTbody-"+ticket_id+" tr:last-child .blockEndDate").val();
			var total = $("#ticketInventoryTbody-"+ticket_id+" tr:last-child .ticketBlockTotal").val();
			attraction_tickets.addInventory(ticket_id,ticket_length, total, start_date, end_date);
		});
	//accordion ticket click to top page
		$("#collapseTwo2 .accordion-toggle").click(function(){
			$("#toTop").click();
			//focus on the name
			$(this).parent().parent().find('.attractionTicketName').focus();
		});
		
		//addInventory change
		$('.addOnCheckList').change(function(){
			var row = $(this).parent().parent().parent().attr('num');
			var idx = $(this).parent().parent().parent().attr('idx');
			var checked = $(this).attr('checked');
			var title = 'data[Attraction_ticket]['+row+'][add_ons]['+idx+'][title]';
			var price = 'data[Attraction_ticket]['+row+'][add_ons]['+idx+'][price]';
			var per_basis = 'data[Attraction_ticket]['+row+'][add_ons]['+idx+'][per_basis]';
			if(checked =='checked'){
				//add the name
				$('#AttractionTicket'+row+'AddOns'+idx+'Title').attr('name',title);
				$('#AttractionTicket'+row+'AddOns'+idx+'Price').attr('name',price);
				//$('#AttractionTicket'+row+'AddOns'+idx+'PerBasis').attr('name',perbasis);
				
			} else {
				//remove the name
				$('#AttractionTicket'+row+'AddOns'+idx+'Title').attr('name','');
				$('#AttractionTicket'+row+'AddOns'+idx+'Price').attr('name','');
				//$('#AttractionTicket'+row+'AddOns'+idx+'PerBasis').attr('name','');			
			}
		});
		//marketing scripts
		$(".attractionTicketName").blur(function(){
			var value = $(this).val();
			var row = $(this).attr('dataRow');
			if(value != ''){
				$('#ticketTypeSpan-'+row).html(value);
				$("#formTicketMarketing #attractionTicketName-"+row).html(value);	
			}		
		});	
		//net rate creation
		$('.netRate').keyup(function(){
			var netRate = $(this).val();
			
			$("#ticketInventoryTbody-"+idx+" .inventoryNetRate").val(netRate);
			$("#ticketInventoryTbody-"+idx+" .inventoryMarkupRate").val('0.00');
			$("#ticketInventoryTbody-"+idx+" .inventoryGrossRate").val(netRate);
		});		
		//tax rate creation
	
		//markup keyup function
		//net->gross
		$(".inventoryNetRate").keyup(function(){
			var idx = $(this).attr('dataRow');
			var row = $(this).attr('row');
			var net = $(this).val();
			var markup = $("#Attraction_ticket"+idx+"Inventory"+row+"Markup").val();
			var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
			var gross =gross.toFixed(2);
			
			if(markup != ''){
				$("#Attraction_ticket"+idx+"Inventory"+row+"Gross").val(gross);	
			}
		});
		//markup -> gross
		$(".inventoryMarkupRate").keyup(function(){
			var idx = $(this).attr('dataRow');
			var row = $(this).attr('row');
			var net = $("#Attraction_ticket"+idx+"Inventory"+row+"Net").val();
			var markup = $(this).val();
			var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
			var gross =gross.toFixed(2);
			if(net != ''){
				$("#Attraction_ticket"+idx+"Inventory"+row+"Gross").val(gross);	
			}
			
		});
	
		//gross -> markup
		$(".inventoryGrossRate").keyup(function(){
			var idx = $(this).attr('dataRow');
			var row = $(this).attr('row');
			var net = $("#Attraction_ticket"+idx+"Inventory"+row+"Net").val();
			var gross = $(this).val();
			var markup = (parseFloat(gross)/parseFloat(net))-1;
			var markup =(markup*100).toFixed(2);
			if(gross != ''){
				$("#Attraction_ticket"+idx+"Inventory"+row+"Markup").val(markup);	
			}
			
		});	
	
		$(".taxcheck").click(function(){
			var checked = $(this).attr('checked');
			var rows = $(this).parent().parent().parent().parent().attr('id');
			var idx = $(this).attr('id').replace('taxcheck-','');
			
			if(checked == 'checked'){
				$(this).parent().parent().parent().attr('class','alert alert-info');
				$(this).parent().parent().parent().find('.taxesInput').removeAttr('disabled');	
				
				var taxValue = $(this).parent().parent().parent().find('.taxesInput').val();
				var totalTax = $(this).parent().parent().parent().parent().find('#taxrate-'+idx).val();
				var newTax = parseFloat(taxValue)+parseFloat(totalTax);
				var newTax = newTax.toFixed(2);
				$(this).parent().parent().parent().parent().find('#taxrate-'+idx).val(newTax);
				$('#ticketInventoryTbody-'+idx+' .inventoryTaxRate').val(newTax);
				
			} else {	
				$(this).parent().parent().parent().attr('class','well well-small');
				$(this).parent().parent().parent().find('.taxesInput').attr('disabled','disabled');
				var taxValue = $(this).parent().parent().parent().find('.taxesInput').val();
				var totalTax = $(this).parent().parent().parent().parent().find('#taxrate-'+idx).val();
				var newTax = parseFloat(totalTax)-parseFloat(taxValue);
				var newTax = newTax.toFixed(2);
				$(this).parent().parent().parent().parent().find('#taxrate-'+idx).val(newTax);
				$('#ticketInventoryTbody-'+idx+' .inventoryTaxRate').val(newTax);
			}
		});

		
	},
	series1check: function(){
		//focus on date after clicking icon span
		$(".blockBeginSpan").click(function(){
			$(this).parent().find('.blockBeginDate').focus();
		});
		$(".blockEndSpan").click(function(){
			$(this).parent().find('.blockEndDate').focus();
		});
		//step 1 create attraction name
		$(".attractionNameInput").keyup(function(){
			var name = $(this).val();
			var url = createUrl(name);
			$("#attraction_name").html('');
			$(".attractionNameInput").parent().attr('class','control-group');
			$(".attractionNameInput").parent().find('.help-inline').html('');
			$("#attractionUrlDiv").attr('class','control-group');	
			$("#attractionUrlDiv p").attr('class','well well-small muted');	
			$("#attractionUrlDiv .help-block").html('');		
			$("#attraction_name").html(url);	
			$("#attractionUrlDiv").attr('name','notvalid');		
		});
		//step 1 select location
		$(".locationInput").change(function(){
			var location = $(this).find('option:selected').val();
			var url = createUrl(location);
			var city = $(".locationHidden[name='"+location+"']").attr('city');
			var state = $(".locationHidden[name='"+location+"']").attr('state');
			var country = $(".locationHidden[name='"+location+"']").attr('country');
			switch(country){
				case 'CAN':
					country = 2;
				break;
				case 'USA':
					country = 1;
				break;
			}
			$("#attraction_location").html('');
			$(".locationInput").parent().attr('class','control-group');
			$(".locationInput").parent().find('.help-inline').html('');
			$("#attractionUrlDiv").attr('class','control-group');	
			$("#attractionUrlDiv p").attr('class','well well-small muted');	
			$("#attractionUrlDiv .help-block").html('');	
			$("#attraction_location_edit").html(url);
			$("#attractionUrlDiv").attr('name','notvalid');	
			
			//autofill next section based on location
			$(".cityInput,#billing_city").val(city);
			$("#stateInput,#billing_state").val(state);
			$("#country option[value='"+country+"'], #billing_country option[value='"+country+"']").attr('selected','selected');
		});
		
		$(".attractionNameInputEdit").keyup(function(){
			var name = $(this).val();
			var url = createUrl(name);
			$("#attraction_name_edit").html('');
			$(".attractionNameInputEdit").parent().attr('class','control-group');
			$(".attractionNameInputEdit").parent().find('.help-inline').html('');
			$("#attractionUrlDiv").attr('class','control-group');	
			$("#attractionUrlDiv p").attr('class','well well-small muted');	
			$("#attractionUrlDiv .help-block").html('');		
			$("#attraction_name_edit").html(url);	
			$("#attractionUrlDiv").attr('name','notvalid');		
		});
		
		$(".locationInputEdit").keyup(function(){
			var location = $(this).val();
			var url = createUrl(location);
			$("#attraction_location_edit").html('');
			$(".locationInputEdit").parent().attr('class','control-group');
			$(".locationInputEdit").parent().find('.help-inline').html('');
			$("#attractionUrlDiv").attr('class','control-group');	
			$("#attractionUrlDiv p").attr('class','well well-small muted');	
			$("#attractionUrlDiv .help-block").html('');	
			$("#attraction_location_edit").html(url);
			$("#attractionUrlDiv").attr('name','notvalid');	
		});
		//tax rate creation
		$(".taxSelection").change(function(){
			//hide the em statement
			$(this).parents('.taxContainer').find('.taxesCollectedDiv em').hide();
			
			//grab the selected option and get its values
			var room_id = $(this).attr('num');
			var tax_id = $(this).find('option:selected').val();
			var tax_name = $(this).find('option:selected').attr('taxName');
			var tax_rate = $(this).find('option:selected').attr('taxRate');
			var tax_country = $(this).find('option:selected').attr('taxCountry');
			//var row = $(".taxcheck[idx='"+tax_id+"']").length;
			var create_tax = createTax(room_id,tax_id,tax_name,tax_rate,tax_country);
			var total_tax = $(this).parent().parent().parent().parent().find(".taxrate").val();
			var new_rate = parseFloat(tax_rate)+parseFloat(total_tax);
			var new_rate = new_rate.toFixed(2);
			
			
			if(tax_id != ''){

			//check to see if the tax has already been inserted into the tax container
			var errors = 'No';
			
				$(this).parent().parent().parent().find('.taxesCollectedDiv .taxesInput').each(function(){
					var check = $(this).attr('id').replace('taxesInput-','');
					if(tax_id == check){
						alert('You have already selected this tax.');
						errors = 'Yes';
						return false;
					}
				});
				
				if(errors == 'No'){
					$(this).parent().parent().parent().find('.taxesCollectedDiv').append(create_tax);	
					$(this).parent().parent().parent().parent().find(".taxrate").val(new_rate);
				}
			
			
			
			}			
			$(".removeTax").click(function(){
				var value = $(this).parent().find('.taxesInput').val();
				var total_tax = $(this).parent().parent().parent().parent().parent().parent().find(".taxrate").val();
				var newValue = parseFloat(total_tax)-parseFloat(value);
				var newValue = newValue.toFixed(2);
				
				$(this).parent().parent().parent().parent().parent().parent().find(".taxrate").val(newValue);
				$(this).parent().remove();
			});
		});	
		$(".removeTax").click(function(){
			var value = $(this).parent().find('.taxesInput').val();
			var total_tax = $(this).parent().parent().parent().parent().parent().parent().find(".taxrate").val();
			var newValue = parseFloat(total_tax)-parseFloat(value);
			var newValue = newValue.toFixed(2);
			
			$(this).parent().parent().parent().parent().parent().parent().find(".taxrate").val(newValue);
			$(this).parent().remove();
		});	
		//remove Attraction ticket
		$(".removeTicketButton").click(function(){
			if(confirm('Are you sure you want to delete ticket?')){
				var ticket_id = $(this).attr('id').replace('removeTicketButton-','');
				var delete_ticket = '<input type="hidden" name="data[Attraction_delete]['+ticket_id+']" value="'+ticket_id+'"/>';
				
				//add Attraction id to the remove ticket div
				$("#formDelete").append(delete_ticket);
				//remove ticket from dom
				$(this).parents('.accordion-group:first').remove();	
				//remover marketing scripts from the dom
				$("#marketingTicket-"+ticket_id).remove();		
			}
			
				
		});
		//add Attraction Room
		$("#addAttractionTicketButton").click(function(){
			var newRow = $("#accordionTicketType .attractionTicketNew:last-child").length;
			if(newRow >0){
				var idx = $("#accordionTicketType .attractionTicketNew:last-child").attr('idx');
				if(idx == ''){
					idx = 1;
				} else {
					var idx = parseFloat(idx)+1;	
				}
				
				var row = 0;				
			} else {
				var idx = 0;
				var row = 0;				
			}

			attraction_tickets.addTicket(idx,row);
		
		});		
		$(".statusSelect").change(function(){
			var status_number = $(this).find('option:selected').val();
			var status = $(this).find('option:selected').html();
			switch(status_number){				
				case '1':
					var badge = '<span class="label label-important">Unfinished</span>';
				break;
				
				case '2':
					var badge = '<span class="label label-important">'+status+'</span>';
				break;
				
				case '3':
					var badge = '<span class="label label-warning">'+status+'</span>';
				break;
				
				case '4':
					var badge = '<span class="label label-warning">'+status+'</span>';
				break;
				
				case '5':
					var badge = '<span class="label label-success">'+status+'</span>';
				break;
				case '6':
					var badge = '<span class="label label-success">'+status+'</span>';
				break;
			}

			$(this).parent().parent().parent().parent().parent().parent().parent().find('.ticketTypeLabel').html(badge);
		});

		//Time Table Setup
		$(".multiday").click(function(){
			var idx = $(this).attr('id').replace('multiday-','');
			var status = $(this).attr('checked');
			//check the status of checkd if its not checked then do this
			if(status =='checked'){
				$(this).attr('value','Yes');
				//show the time table & hide the no time table
				$("#multidayDiv-"+idx).removeClass('hide');
				$("#noTimeTableDiv-"+idx).hide();
				$("#timeTableDiv-"+idx).fadeIn();
				
				//change the status of each table
				$("#noTimeTable-"+idx).attr('status','notactive');
				$("#noTimeTable-"+idx+" input").attr('disabled','disabled');
				$("#timeTable-"+idx).attr('status','active');
				$("#timeTable-"+idx+" input").removeAttr('disabled');
				$("#timeTable-"+idx+" .inventoryExchangeRate").attr('disabled','disabled');
				
			} else {
				$(this).attr('value','No');
				$("#multidayDiv-"+idx).hide();
				$("#timeTableDiv-"+idx).hide();
				$("#noTimeTableDiv-"+idx).fadeIn();
				//change the status of each table
				$("#noTimeTable-"+idx).attr('status','active');
				$("#timeTable-"+idx).attr('status','notactive');
				$("#timeTable-"+idx+" input").attr('disabled','disabled');
				$("#noTimeTable-"+idx+" input").removeAttr('disabled','disabled');
				
			}
		});
		
		//time table time select
		$(".timeSubmit").click(function(){
			alert('pressed');
			var idx = $(this).attr('id').replace('timeSubmit-','');
			var time = $("#timeInput-"+idx).val();
			var timestamp = $(this).attr('timestamp');
			var exchange = $('.exchange').val();
			if(time ==''){
				$(this).parent().parent().parent().attr('class','control-group error');
				$(this).parent().parent().parent().find('.help-block').html('Time cannot be empty');
			} else {
				$(this).parent().parent().parent().attr('class','control-group');
				$(this).parent().parent().parent().find('.help-block').html('');		
				
				var newTime = '<li class="alert alert-info pull-left span2" time="'+time+'" style="margin-right:5px;"><button type="button" row="'+time+'" class="closeTimeButton close">&times;</button>'+time+'</li>';
				var timeLength = $("#timeResults-"+idx+" li").length;
				switch(timeLength){
					case 0:
						var countTableRows = $("#timeTable-"+idx+" tbody tr").length;
						if(countTableRows == 0){
							var country = $('.countrySelect option:selected').val();
							switch(country){
								case '1':
									var newTbody = new_tbody1();
								break;
								
								case '2':
									var newTbody = new_tbody2();
									
								break;
							}
							$("#timeTable-"+idx).append(newTbody);	
							
							attraction_tickets.addScripts(0,0);

						}

						
						$("#timeResults-"+idx).show();
						$("#timeResults-"+idx).append(newTime);	
						$("#timeInput-"+idx).val('');
						$("#timeTable-"+idx+" .newAgeRow").find('input').removeAttr('disabled');
						$("#timeTable-"+idx+" .newAgeRow .ticketTime").attr('disabled','disabled');
						$("#timeTable-"+idx+" .newAgeRow .inventoryExchangeRate").attr('disabled','disabled');
						$("#timeTable-"+idx+" .ticketTime").val(time);	
						$("#timeTable-"+idx+" .ticketTimeFinal").val(time);	
						$("#timeTable-"+idx+" .ticketInventoryTbody").attr('time',time);
						$("#timeTable-"+idx+" .ticketInventoryTbody").attr('row',0);	
						$("#timeTable-"+idx+" .blockBeginDate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][start_date]');
						$("#timeTable-"+idx+" .blockEndDate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][end_date]');
						$("#timeTable-"+idx+" .ticketTimeFinal").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]');
						$("#timeTable-"+idx+" .ticketAgeRange").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][age_range][][age_range]');
						$("#timeTable-"+idx+" .inventoryInventory").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][age_range][][inventory]');
						$("#timeTable-"+idx+" .inventoryNetRate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][age_range][][net]');
						$("#timeTable-"+idx+" .inventoryMarkupRate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][][markup]');
						$("#timeTable-"+idx+" .inventoryGrossRate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][age_range][][gross]');
						
						
					break;
					
					default:
						var errors = 0;
						$("#timeResults-"+idx+" li").each(function(){
							var checkTime = $(this).attr('time');
							if(time ==checkTime){
								errors = 1;
								return false;
							}
						});
						if(errors == 0){
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-block').html('');
							$("#timeResults-"+idx).show();
							$("#timeResults-"+idx).append(newTime);
							$("#timeInput-"+idx).val('');	
							
							var totalRowCount = $(".attractionTable-"+idx+"[status='active'] tbody tr").length;
							var topRow = $(".attractionTable-"+idx+"[status='active'] tbody[special='primary'][copy='Yes']").clone();
							$("#attractionTicketManipulate").html(topRow);
							var timestamp = $("#attractionTicketManipulate tbody .blockBeginDate").val();
							var timestamp = new Date(timestamp).getTime() / 1000;	
							$("#attractionTicketManipulate tbody").removeAttr('copy');					
							$("#attractionTicketManipulate tbody").attr('time',time);
							$("#attractionTicketManipulate tbody").attr('row',$(".attractionTable-"+idx+"[status='active'] tbody").length);
							$("#attractionTicketManipulate tbody td:first-child").html('');
							$("#attractionTicketManipulate tbody td:nth-child(2)").html('');
							$("#attractionTicketManipulate tbody td:nth-child(2)").css({'border-left':'none'});
							$("#attractionTicketManipulate .ticketTime").val(time);							
							$("#attractionTicketManipulate .ticketTimeFinal").val(time);
							
							//reindex the remove buttons before cloning it back to table
							$("#attractionTicketManipulate tbody .removeAgeRow").each(function(index){
								var lastRemoveRow = $("#timeTable-"+idx+" tbody .removeAgeRow").length;
								var lastRemoveRow = lastRemoveRow + index;
								$(this).attr('id','removeAgeRow-'+idx+'-'+lastRemoveRow);
							});								
							
							$("#attractionTicketManipulate tr").each(function(index){
								var time = $("#attractionTicketManipulate tbody .ticketTime").val();
								var age_range = $(this).find('.ticketAgeRange').val();
								var newRow = totalRowCount+index;
								
								$(this).attr('special','primary');
								$(this).attr('row','sub');
								$(this).attr('num',index);
								$(this).find('.ticketTime').attr('id','AttractionTicket'+idx+'Inventory'+newRow+'Time');
								$(this).find('.ticketTimeFinal').attr('id','AttractionTicket'+idx+'Inventory'+newRow+'Time');
								$(this).find('.ticketAgeRange').attr('id','AttractionTicket'+idx+'Inventory'+newRow+'AgeRange');
								$(this).find('.inventoryNetRate').attr('id','AttractionTicket'+idx+'Inventory'+newRow+'Net');
								$(this).find('.inventoryMarkupRate').attr('id','AttractionTicket'+idx+'Inventory'+newRow+'Markup');
								$(this).find('.inventoryGrossRate').attr('id','AttractionTicket'+idx+'Inventory'+newRow+'Gross');
								$(this).find('.switchNetRate').attr('id','switchNetRate-'+idx+'-'+newRow);
								$(this).find('.ticketTimeFinal').attr('id','AttractionTicket'+idx+'Inventory'+newRow+'Time');
								$(this).find('.addAgeButtonTime').attr('id','addAgeButtonTime-'+idx+'-'+newRow);
								$(this).find(".blockBeginDate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]['+time+'][start_date]');
								$(this).find(".blockEndDate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]['+time+'][end_date]');
								$(this).find(".ticketTimeFinal").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]['+time+'][time]');
								$(this).find(".ticketAgeRange").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]['+time+'][age_range]['+age_range+'][age_range]');
								$(this).find(".inventoryInventory").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]['+time+'][age_range]['+age_range+'][inventory]');
								$(this).find(".inventoryNetRate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]['+time+'][age_range]['+age_range+'][net]');
								$(this).find(".inventoryMarkupRate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]['+time+']['+age_range+'][markup]');
								$(this).find(".inventoryGrossRate").attr('name','data[Attraction_time]['+idx+'][Inventory]['+timestamp+'][time]['+time+'][age_range]['+age_range+'][gross]');							
								//attraction_tickets.addTimeScripts(idx,newRow);

							});
							


							//clone the tbody back into the time table
							var newTimeTbody = $('#attractionTicketManipulate tbody').clone();

							$(".attractionTable-"+idx+"[status='active']").append(newTimeTbody);

							$("#timeTable-"+idx+" tbody tr").each(function(index){	
								attraction_tickets.addTimeScriptsCan(idx,index);
							});	

							//add the remove scripts into the time table
							$("#timeTable-"+idx+" .removeAgeRow").each(function(){
								var removeRow = $(this).attr('id').replace('removeAgeRow-'+idx+'-','');
	
								$("#removeAgeRow-"+idx+"-"+removeRow).one('click',function(){
								if(confirm('Are you sure you want to delete this ticket age range row?')){
									$(this).parent().parent().remove();	
								}	
								});						
							});
							var countAgeAdd = $("#timeTable-"+idx+" .addAgeButtonTime").length;
							var countAgeAdd = countAgeAdd-1;
							$('#addAgeButtonTime-'+idx+'-'+countAgeAdd).click(function(){
								var time = $(this).parent().parent().parent().attr('time');

								var age_range = $(this).parent().parent().find('.ticketAgeRange').val();
								var netRate = $(this).parent().parent().find('.inventoryNetRate').val();
								var netRate = parseFloat(netRate).toFixed(2);
								var grossRate = $(this).parent().parent().find('.inventoryGrossRate').val();
								var grossRate = parseFloat(grossRate).toFixed(2);
								var markupRate = $(this).parent().parent().find('.inventoryMarkupRate').val();
								var markupRate = parseFloat(markupRate).toFixed(2);
								var inventory = $(this).parent().parent().find('.inventoryInventory').val();
								var start = $(this).parent().parent().find('.blockBeginDate').val();
								var timestamp = new Date(start).getTime() / 1000;
								
								var country = $('.countrySelect option:selected').val();
								
								switch(country){
									case '1':
										var addAgeRow = newAgeRangeBlockUs(idx, row, time, timestamp, netRate, grossRate, markupRate, inventory);
									break;
									
									case '2':
										var addAgeRow = newAgeRangeBlockCan(idx, row, time, timestamp, netRate, grossRate, markupRate, inventory);	
									break;
								}
								
								
								$(this).parent().parent().parent().append(addAgeRow);
								
								//remove button scripts
								var ageRow = $('#timeTable-'+idx+' tbody tr').length;
								var ageRow = ageRow-1;			
								//blur age range to add name attributes
								$("#AttractionTicket"+idx+"Inventory"+ageRow+"AgeRange").blur(function(){
									var new_age_range = $(this).val();
									
									$(this).attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+new_age_range+'][age_range]');
									$(this).parent().parent().parent().find('.inventoryInventory').attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+new_age_range+'][inventory]');
									$(this).parent().parent().parent().find('.inventoryNetRate').attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+new_age_range+'][inventory]');
									$(this).parent().parent().parent().find('.inventoryMarkupRate').attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+new_age_range+'][inventory]');
									$(this).parent().parent().parent().find('.inventoryGrossRate').attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+new_age_range+'][inventory]');
								});
								//remove button scripts
								var newRow = $('#timeTableDiv-'+idx+' .removeAgeRow').length;
								var newRow = newRow-1;
								$("#removeAgeRow-"+idx+"-"+newRow).one('click',function(){
									if(confirm('Are you sure you want to delete this ticket age range row?')){
										$(this).parent().parent().remove();	
									}
									
									
								});	
								
								//reindex the rows in this table
								$(this).parent().parent().parent().find('tr').each(function(index){
									$(this).attr('num',index);
								});	
								
								attraction_tickets.addTimeScriptsCan(idx,ageRow);
							});
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-block').html('');					
						} else {
							$(this).parent().parent().parent().attr('class','control-group error');
							$(this).parent().parent().parent().find('.help-block').html('Time has already been created. Please choose another time.');					
						}					
					break;
				}
				attraction_tickets.removeByTime(idx,time);
				
			}
		});
		$(".removeAgeRow").one('click',function(){
		alert('test')
		if(confirm('Are you sure you want to delete this ticket age range row?')){
			var checkTop = $(this).attr('row');
			if(checkTop == 'Primary'){
				var timestamp = $(this).parents('tbody:first').attr('timestamp');
				
				$(this).parents('table:first').find('tbody[timestamp="'+timestamp+'"]').remove();
			} else if(checkTop =='Secondary'){
				$(this).parents('tbody:first').remove();
			} else {
				$(this).parent().parent().remove();		
			}
		}	
		});		
		
		
		$('.close').click(function(){
			var ticket_id = $(this).parent().parent().attr('id').replace('blackoutDatesUl-','');

			$(this).parent().remove();
			var countLi = $("#blackoutDatesUl-"+ticket_id).find('li').length;

			if(countLi ==0){
 
				$("#blackoutDatesUl-"+ticket_id).html('<li class="noCountLi"><input type="hidden" value="" name="data[Attraction_ticket]['+ticket_id+'][blackout][0][dates]"/></li>');				
			}
			
		});		
		
		$(".deleteTbody").click(function(){
			if(confirm('Are you sure you want to remove this date range?')){
				$(this).parents('tbody:first').remove();	
			}
			
		});
		$(".deleteRow").click(function(){
			if(confirm('Are you sure you want to remove this date row?')){
				$(this).parents('tr:first').remove();	
			}			
		});
		
		//Adds a row to the non timed attraction
		
		$(".addAgeButtonNoTimeCan").click(function(){
			var inventory = '';
			var net = '';
			var gross = '';
			var markup = '0';
			
			//add a row here
			var newInventoryTr = newTicketBlockCan(inventory,net, gross, markup);
			$(this).parents('tr:first').after(newInventoryTr);
		});

	},

    cityStateCountry: function(cityInput, stateInput, countrySelect) { //function to return city and state
		$(cityInput).typeahead({
			source: function (query, process) {
		        labels = [];
		        $.getJSON('/attractions/getCities', function(data){
		            $.each(data, function(i, elem){
		                labels[i] = elem;
		            });
		            process(labels);
		        });
		        this.source = labels;
		    }
			, updater: function (item) {
				var state = returnState(item);
				var city = returnCity(item);
		   		$(stateInput).val(state);
		   		$.post('/attractions/request',
		   		{
		   			type:'Get_Country',
		   			state:state
		   		},function(country){
		   			$(countrySelect+"[value='"+country+"']").attr('selected','selected');
		   		});
		   		return city;
		  	}
		});       
    }, 
	checkAttractionUrl: function(url) {
		$.post(
			'/attractions/request',
			{
				type:'Check_Url',
				url:url
			},	function(result){
				switch(result){
					case 'taken':
						$(".attractionNameInput").parent().attr('class','control-group error');
						$(".attractionNameInput").parent().find('.help-inline').html('Error: Please select another attraction name.');
						$("#attractionUrlDiv").attr('class','control-group error');	
						$("#attractionUrlDiv p").attr('class','alert alert-error');	
						$("#attractionUrlDiv").attr('name','notvalid');	
					break;
					
					case 'available':

						$("#attractionUrlDiv").attr('class','control-group success');	
						$("#attractionUrlDiv p").attr('class','alert alert-success');
						$("#attractionUrlDiv").attr('name','valid');	
						var getUrl = '/attractions'+$("#attraction_location").html()+''+$("#attraction_name").html();
						var type = $(".transactionTypeSelect option:selected").val();					
						//insert into form
						$("#attraction_url").val(getUrl);
						$("#attraction_type").val(type);
						//submit form
						$("#attraction_basic_form").submit();
					break;	
					
				}
			}
		);	
	},

	stepy: function(name){
		$(name).stepy({
		 	back: function(index) {
				$("#toTopHover").click();

				if(index ==3){//moving out of step 3
					var addOnLength = $('#attractionAddOnTbodyEdit tr').length;
					var idx = parseInt(addOnLength)+1;
					if(addOnLength ==0){
						//add in a new row
						$("#attractionAddOnTbodyEdit").append(
							'<tr id="attractionAddOnTr-'+idx+'" class="attractionAddOnTr">'+
								'<td><input id="attractionAddOnTitle" type="text" name="data[Attraction][add_ons]['+idx+'][title]"/></td>'+
								'<td class="control-group">'+
									'<div class="input-prepend">'+
										'<span class="add-on">$</span>'+
										'<input class="attractionAddOnPrice" type="text" class="span10" name="data[Attraction][add_ons]['+idx+'][price]"/>'+
									'</div>'+
								'</td>'+
								'<td class="form-inline">'+
									'<label id="attractionAddOnPerBasisLabel1" class="radio"><input id="attractionAddOnPerBasis-onetime" type="radio" name="data[Attraction][add_ons]['+idx+'][per_basis]" value="onetime"/> One Time Price</label>'+
									'<label id="attractionAddOnPerBasisLabel2" class="radio"><input id="attractionAddOnPerBasis-pernight" type="radio" name="data[Attraction][add_ons]['+idx+'][per_basis]" value="pernight"/> Per Night</label>'+
								'</td>'+
							'</tr>'
						);
						attractions.numberformat();
					}
				}
			}, next: function(index) {
				$("#toTopHover").click();
				if(index ==4){ //moving out of step 2
					$("#attractionAddOnTbodyEdit tr").each(function(){
						var emptyAddOn = $(this).find('#attractionAddOnTitle').val();
						if(emptyAddOn == ''){
							$(this).remove();
						}
					});
				}
				if(index ==5){ //move out of step 3

					
				}
			},
			finishButton: false,
			description:	false,
			legend:			false,
			titleClick:		true,
			block : true,
			errorImage : true,
			nextLabel: 'Next <i class="icon-chevron-right icon-white"></i>',
			backLabel: '<i class="icon-chevron-left"></i> Back',	
			validate : false //change to true if using jquery validation else keep false
		});
		$('.stepy-titles').each(function(){
			$(this).children('li').each(function(index){
				var myIndex = index + 1
				$(this).append('<span>Step '+(index+1)+'</span><span class="stepNb">'+myIndex+'</span>');
			});
		});	
		stepy_validation = $(name).validate({
			onfocusout: false,
			errorPlacement: function(error, element) {
				error.appendTo( element.closest("div.controls") );
			},
			highlight: function(element) {
				$(element).closest("div.control-group").addClass("error f_error");
				var thisStep = $(element).closest('form').prev('ul').find('.current-step');
				thisStep.addClass('error-image');
			},
			unhighlight: function(element) {
				$(element).closest("div.control-group").removeClass("error f_error");
					if(!$(element).closest('form').find('div.error').length) {
					var thisStep = $(element).closest('form').prev('ul').find('.current-step');
					thisStep.removeClass('error-image');
				};
			},
			rules: {
				'data[Attraction][address]':'required',
				'data[Attraction][city]':'required',
				'data[Attraction][state]':'required',
				'data[Attraction][zipcode]':'required',
				'data[Attraction][country]':'required',
				'data[Attraction][phone]':'required',
				'data[Attraction][billing_address]':'required',
				'data[Attraction][billing_city]':'required',
				'data[Attraction][billing_state]':'required',
				'data[Attraction][billing_zip]':'required',
				'data[Attraction][billing_country]':'required',
				'data[Attraction][primary_first_name]':'required',
				'data[Attraction][primary_last_name]':'required',
				'data[Attraction][primary_phone]':'required',
				'data[Attraction][currency]':'required',
				'data[Attraction][bookable_tickets]':'required',


			}, messages: {
				'data[Attraction][address]': {required: 'Address field is required!'},
				'data[Attraction][city]': {required: 'City field is required!'},
				'data[Attraction][state]': {required: 'State field is required!'},
				'data[Attraction][zipcode]':{required: 'Zipcode field is required!'},
				'data[Attraction][country]':{required: 'Country field is required!'},
				'data[Attraction][phone]': {required: 'Phone number field is required!'},
				'data[Attraction][billing_address]':{required: 'Billing address is required!'},
				'data[Attraction][billing_city]':{required: 'Billing city is required!'},
				'data[Attraction][billing_state]':{required: 'Billing state is required!'},
				'data[Attraction][billing_zip]':{required: 'Billing zip is required!'},
				'data[Attraction][billing_country]':{required: 'Billing country is required!'},
				'data[Attraction][primary_first_name]':{required: 'Primary first name is required!'},
				'data[Attraction][primary_last_name]':{required: 'Primary last name is required!'},
				'data[Attraction][primary_phone]':{required: 'Primary phone number is required!'},
				'data[Attraction][currency]':{required: 'Attraction currency is required!'},
				'data[Attraction][bookable_tickets]':{required: 'Attraction bookable tickets is required!'},

			},
			//ignore : ':hidden'
		});
	}, 
	errors: function(){
		setTimeout(function () {$("#attraction-back-3").click(); }, 100);
	},
	addOn: function(){
		//determine where the location is, its either us or can
		var country = $(".countrySelect option:selected").val();
		switch(country){
			case '1': //us
				//set the initial variables, check to see what radio the user has selected before cloning
				var addOnRadioSelected = 'data[Attraction][add_ons][0][per_basis]';
				var addOnChecked = $("#attractionAddOnTbody tr:first-child input[name='"+addOnRadioSelected+"']:checked").val();
				//remove all the values in the new cloned tr
				$("#attractionAddOnTr-0").clone().insertAfter("#attractionAddOnTbody tr:last-child");
				$("#attractionAddOnTbody tr:last-child").find('#attractionAddOnTitle').val('');
				$("#attractionAddOnTbody tr:last-child").find('.attractionAddOnPrice').val('');
				//reinsert selected radio back into th first child
				$("#attractionAddOnTbody tr:first-child").find('input[value="'+addOnChecked+'"]').attr('checked','checked');
		
				//rename all of the rows and input names
				$("#attractionAddOnTbody tr").each(function(row){
					//create the name attributes
					var class1 = 'attractionAddOnTr-'+row;
					var class2 = 'data[Attraction][add_ons]['+row+'][title]';
					var class3 = 'data[Attraction][add_ons]['+row+'][price]';
					var class4 = 'data[Attraction][add_ons]['+row+'][per_basis]';
					//insert new attributes with a for each loop (in case some rows have been deleted renumber your array)
					$(this).attr('id',class1);
					$(this).find('#attractionAddOnTitle').attr('name',class2);
					$(this).find('.attractionAddOnPrice').attr('name',class3);
					$(this).find('#attractionAddOnPerBasis-onetime').attr('name',class4);
					$(this).find("#attractionAddOnPerBasis-pernight").attr('name',class4);
		
				});
				attractions.numberformat();			
			break;
			
			case '2': //can
				//set the initial variables, check to see what radio the user has selected before cloning
				var addOnRadioSelected = 'data[Attraction][add_ons][0][per_basis]';
				var addOnChecked = $("#attractionAddOnTbody tr:first-child input[name='"+addOnRadioSelected+"']:checked").val();
				//remove all the values in the new cloned tr
				$("#attractionAddOnTr-0").clone().insertAfter("#attractionAddOnTbody tr:last-child");
				
				$("#attractionAddOnTbody tr:last-child").find('#attractionAddOnTitle').val('');
				$("#attractionAddOnTbody tr:last-child").find('.attractionAddOnNet').val('');
				$("#attractionAddOnTbody tr:last-child").find('.attractionAddOnGross').val('');
				$("#attractionAddOnTbody tr:last-child").find('.attractionAddOnGross').attr('old','');
			
				$("#attractionAddOnTbody tr:last-child").remove('.attractionAddOnFlag');
				
				//reinsert selected radio back into th first child
				$("#attractionAddOnTbody tr:first-child").find('input[value="'+addOnChecked+'"]').attr('checked','checked');
		
				//rename all of the rows and input names
				$("#attractionAddOnTbody tr").each(function(idx){
					//create the name attributes
					var class1 = 'attractionAddOnTr-'+idx;
					var class2 = 'data[Attraction][add_ons]['+idx+'][title]';
					var class3 = 'data[Attraction][add_ons]['+idx+'][net]';
					var class4 = 'data[Attraction][add_ons]['+idx+'][exchange]';
					var class5 = 'data[Attraction][add_ons]['+idx+'][gross]';
					var class6 = 'data[Attraction][add_ons]['+idx+'][per_basis]';
					//insert new attributes with a for each loop (in case some rows have been deleted renumber your array)
					$(this).attr('id',class1);
					$(this).find('#attractionAddOnTitle').attr('name',class2);
					$(this).find('.attractionAddOnNet').attr('name',class3);
					$(this).find('.attractionAddOnNet').attr('id','attractionAddOnNet-'+idx);
					$(this).find('.attractionAddOnExchange').attr('name',class4);
					$(this).find('.attractionAddOnGross').attr('name',class5);
					$(this).find('.attractionAddOnGross').attr('id','attractionAddOnGross-'+idx);
					$(this).find('#attractionAddOnPerBasis-onetime').attr('name',class6);
					$(this).find("#attractionAddOnPerBasis-pernight").attr('name',class6);
		
				});
				
				//add validation scripts
				$(".attractionAddOnNet").blur(function(){
					var net = $(this).val();
					var exchange = $(this).parent().parent().parent().find('.attractionAddOnExchange').val();
					var gross = parseFloat(net)*parseFloat(exchange);
					var gross = gross.toFixed(2);
					var flag = 'No';
					$(this).parent().parent().parent().find('.attractionAddOnGross').attr('flag',flag);
					var row = $("input[exchange='Yes']").length;
					
					$(this).parent().parent().parent().find('.attractionAddOnGross').val(gross);
					$(this).parent().parent().parent().find('.attractionAddOnGross').attr('old',gross);
					$(this).parent().parent().parent().find('.attractionAddOnFlag').remove();
					var hiddenFields = getAddOnExchange(row,net,flag,exchange,gross,gross); 
					$(this).parent().parent().parent().find('.attractionAddOnGross').parent().append(hiddenFields);
					
				});
					
				$('.attractionAddOnGross').blur(function(){
					var gross = $(this).val();
					var old = $(this).attr('old');
					var net = $(this).parent().parent().parent().find('.attractionAddOnNet').val();
					var exchange = $(this).parent().parent().parent().find('.attractionAddOnExchange').val();
					var row = $(this).attr('id').replace('attractionAddOnGross-','');
					
					if(gross != old){
						//add a new hidden input named flag
						var flag = 'Yes';
						$(this).attr('flag',flag);
						var row = $("input[exchange='Yes']").length;
						$(this).parent().find('.attractionAddOnFlag').remove();
						var hiddenFields = getAddOnExchange(row,net,flag,exchange,old,gross); 
						$(this).parent().append(hiddenFields);
						
					}
				});
				
				
				//add number formattting
				attractions.numberformat();	
			break;
		}
	}  
}
attraction_blocks = {
	addBlock: function(row,start, end) {
		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
		var blockVal = $('#attractionBlocksTbody tr:last-child .attractionBlockQuantity').val();
		var blockVal = parseInt(blockVal);
		var intRegex = /^\d+$/;
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();

		if(start == ''){
			//add errors
			$('#attractionBlocksTbody tr:last-child .blockBeginDate').parent().attr('class','control-group pull-left error');
			$('#attractionBlocksTbody tr:last-child .blockBeginDate').parent().find('.help-block').html('You must choose an start date');			
		} else {
			$('#attractionBlocksTbody tr:last-child .blockBeginDate').parent().attr('class','control-group pull-left');
			$('#attractionBlocksTbody tr:last-child .blockBeginDate').parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#attractionBlocksTbody tr:last-child .blockEndDate').parent().attr('class','control-group error');
			$('#attractionBlocksTbody tr:last-child .blockEndDate').parent().find('.help-block').html('You must choose an end date');
		} else {
			$('#attractionBlocksTbody tr:last-child .blockEndDate').parent().attr('class','control-group controls');
			$('#attractionBlocksTbody tr:last-child .blockEndDate').parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#attractionBlocksTbody tr:last-child .blockEndDate').parent().attr('class','control-group pull-left error');
				$('#attractionBlocksTbody tr:last-child .blockEndDate').parent().find('.help-block').html('End date must be greater than start date');					
			} else {
				$('#attractionBlocksTbody tr:last-child .blockEndDate').parent().attr('class','control-group pull-left');
				$('#attractionBlocksTbody tr:last-child .blockEndDate').parent().find('.help-block').html('');				
			}
			
		} 
		if(!intRegex.test(blockVal) || intRegex.test(blockVal) <=0) { //checks if number
			$('#attractionBlocksTbody tr:last-child .attractionBlockQuantity').parent().parent().attr('class','control-group pull-left error');
			$('#attractionBlocksTbody tr:last-child .attractionBlockQuantity').parent().parent().find('.help-block').html('You must put in a valid block quantity');
			
		} else {
			$('#attractionBlocksTbody tr:last-child .attractionBlockQuantity').parent().parent().attr('class','control-group pull-left');
			$('#attractionBlocksTbody tr:last-child .attractionBlockQuantity').parent().parent().find('.help-block').html('');			
		}
		//sucess now send
		if(start != '' && end != '' && startCheck < endCheck && intRegex.test(blockVal) && intRegex.test(blockVal) >0) {
			//remove errors
			$('#attractionBlocksTbody tr:last-child .attractionBlockQuantity').parent().parent().attr('class','control-group pull-left');
			$('#attractionBlocksTbody tr:last-child .attractionBlockQuantity').parent().parent().find('.help-block').html('');
			//add new block form
			var block = attractionBlock(row,newDateString);
			$('#attractionBlocksTbody').append(block);	
			attraction_blocks.addScripts(row);
		}
		
	}, 
	addScripts: function(row){
		$("#AttractionBlocks"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$('#AttractionBlocks"+row+"StartDate').datepicker('hide');
		});

		$("#AttractionBlocks"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$('#AttractionBlocks"+row+"EndDate').datepicker('hide');
		});	
		//focus on date after clicking icon span
		$(".blockBeginSpan").click(function(){
			$(this).parent().find('.blockBeginDate').focus();
			$(this).parent().find('.blockBeginDate').select();

		});
		$(".blockEndSpan").click(function(){
			$(this).parent().find('.blockEndDate').focus();
			$(this).parent().find('.blockEndDate').select();
		});
	}
}
attraction_tickets = {
	validate: function(num, errorClass, createTicketMarketingClass){
		if(num == '' || num =='0'){
			$(errorClass).attr('class','control-group error');
			$(errorClass+' .help-block').html('Error: You must enter a valid ticket amount');
		} else {
			$(errorClass).attr('class','control-group');
			$(errorClass+' .help-block').html('');	
			$("#accordionTicketType").empty();
			attraction_tickets.create(num, '#accordionTicketType',createTicketMarketingClass);	
			$("#accordionGroup2").click();	
		}
	}, 
	create: function(num, createClass, createTicketMarketingClass){
		var row = 0;
		for (var i=0; i < num; i++) {
			var newRow = newTicket(i);			
			var ticketMarketing = newTicketMarketing(i);

		
			$(createClass).append(newRow);
			$("#formTicketMarketing p").hide();
			$(createTicketMarketingClass).append(ticketMarketing);
			attraction_tickets.addScripts(i, row);
		};
	}, 
	addTicket: function(idx,row){
		var location = $(".countrySelect option:selected").val(); //location is used to determine what type of attraction room form we are using
		var idx = $(".accordion-group[row='new']").length;
		//based on the location switch the variables
		switch(location){
			case '1': //This is US Add Ons
				var get_addOns = addOnsUs(idx);
				var newRow = newTicketUs(idx, get_addOns);
			break;
			
			case '2': //This is CAN Add Ons
				var get_addOns = addOnsCan(idx);
				var newRow = newTicketCan(idx, get_addOns);
			break;
		}
		//create the room marketing scripts as well
		var ticketMarketing = newTicketMarketing(idx);
		
		//append the newly created attraction room rows based on the variables set above
		$("#accordionTicketType").append(newRow);
		//hide the room marketing paragraph
		$("#formTicketMarketing p").hide();
		
		//add the room marketing scripts on the next step
		$("#accordion4").append(ticketMarketing);
		
		//add all of the necessary scripts needed to make attraction rooms work
		attraction_tickets.addScripts(idx, row);			
	},
	addTicketSchedule: function(num,row, createClass, createTicketMarketingClass){
		var newRow = newTicket(num);			
		var ticketMarketing = newTicketMarketing(num);

		$(createClass).append(newRow);
		$("#formTicketMarketing p").hide();
		$(createTicketMarketingClass).append(ticketMarketing);	
		attraction_tickets.addScripts(num, row);
	}, 
	addScripts: function(idx, row){
		//plugin scripts
		attractions.numberformat();
		$("#AttractionTicketNew"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#AttractionTicketNew"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#AttractionTicketNew"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$("#AttractionTicketNew"+idx+"Inventory"+row+"StartDate").datepicker('hide');
		});
		$("#AttractionTicketNew"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$("#AttractionTicketNew"+idx+"Inventory"+row+"EndDate").datepicker('hide');
		});
		//focus on date after clicking icon span
		$(".blockBeginSpan").click(function(){
			$(this).parent().find('.blockBeginDate').focus();
			$(this).parent().find('.blockBeginDate').select();
		});
		$(".blockEndSpan").click(function(){
			$(this).parent().find('.blockEndDate').focus();
			$(this).parent().find('.blockEndDate').select();
		});

		$("#fullYearNew-"+idx).datepicker().change(function() {
			var date = $(this).val();
			$('.datepicker td .day').css({'background-color':'red'});
			attraction_tickets.editSelectNew(date,idx, '#blackoutDatesUlNew-'+idx,'#blackoutDateCounterNew-'+idx);
			//$("#fullYear-"+idx).datepicker('hide');
		});
		//marketing scripts
		$("#AttractionTicketNew"+idx+"Name").blur(function(){
			var value = $(this).val();
			var row = $(this).attr('dataRow');
			if(value != ''){
				$('#ticketTypeSpan-'+idx).html(value);
				$("#marketingTicketNew-"+idx+" #attractionTicketName-"+idx).html(value);	
							
			}		
		});			
		//accordion ticket click to top page
		$("#collapseTwo2 .accordion-toggle").click(function(){
			$("#toTop").click();
			//focus on the name
			$(this).parent().parent().find('.attractionTicketNameNew').focus();
		});
		
		//new ticket 
		$("#addTicketInventoryNew-"+idx).click(function(){
			var row = $("#ticketInventoryTbodyNew-"+idx+" tr").length;
			var newRow = parseInt(row);
			var startDate = $('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').val();
			var endDate = $('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').val();
			var blockClass = $(this).parent().parent().attr('id');
			var blockVal = $('#ticketInventoryTbodyNew-'+idx+' tr:last-child .ticketBlockQuantity').val();
			var total = $("#ticketInventoryTbodyNew-"+idx+" tr:last-child .ticketBlockTotal").val();
			
			attraction_tickets.addInventoryNew(idx,newRow,total, startDate, endDate);
			
		});	
		
		//remove ticket
		$("#removeTicketButtonNew-"+idx).click(function(){
			if(confirm('Are you sure you want to delete ticket?')){
				
				//remove from step 3
				$(this).parents('.accordion-group:first').remove();		
				//remove marketing from step 4
				$("#marketingTicketNew-"+idx).remove();		
			}		
		});		

		//addInventory change
		$('.addOnCheckList').change(function(){
			var row = $(this).parent().parent().parent().attr('num');
			var idx = $(this).parent().parent().parent().attr('idx');
			var checked = $(this).attr('checked');
			var title = 'data[Attraction_ticket_new]['+row+'][add_ons]['+idx+'][title]';
			var price = 'data[Attraction_ticket_new]['+row+'][add_ons]['+idx+'][price]';
			var per_basis = 'data[Attraction_ticket_new]['+row+'][add_ons]['+idx+'][per_basis]';
			if(checked =='checked'){
				//add the name
				$('#AttractionTicketNew'+row+'AddOns'+idx+'Title').attr('name',title);
				$('#AttractionTicketNew'+row+'AddOns'+idx+'Price').attr('name',price);

				
			} else {
				//remove the name
				$('#AttractionTicketNew'+row+'AddOns'+idx+'Title').attr('name','');
				$('#AttractionTicketNew'+row+'AddOns'+idx+'Price').attr('name','');
		
			}
		});
	
		//marketing scripts
		$("#Attraction_ticket_new"+idx+"Name").blur(function(){
			var value = $(this).val();
			var row = $(this).attr('dataRow');
			if(value != ''){
				$('#ticketTypeSpan-'+idx).html(value);
				$("#formTicketMarketingNew-"+idx+" #attractionTicketName-"+idx).html(value);	
								
			}		
		});	
		
		//tax rate creation
		$(".taxSelection[num='new-"+idx+"']").change(function(){

			//hide the em statement
			$(this).parent().parent().parent().find('.taxesCollectedDiv em').hide();
			
			//grab the selected option and get its values
			var tax_id = $(this).find('option:selected').val();
			var tax_name = $(this).find('option:selected').attr('taxName');
			var tax_rate = $(this).find('option:selected').attr('taxRate');
			var tax_country = $(this).find('option:selected').attr('taxCountry');
			var row = $(this).parent().parent().parent().find('.taxesRatesDivs').length;
			var create_tax = createTaxNew(tax_id,tax_name,tax_rate,tax_country,idx,row);
			var total_tax = $("#taxrateNew-"+idx).val();
			var new_rate = parseFloat(tax_rate)+parseFloat(total_tax);
			var new_rate = new_rate.toFixed(2);
			if(tax_id != ''){

			//check to see if the tax has already been inserted into the tax container
			var errors = 'No';
			
				$(this).parent().parent().parent().find('.taxesCollectedDiv .taxesInput').each(function(){
					var check = $(this).attr('id').replace('taxesInput-','');
					if(tax_id == check){
						alert('You have already selected this tax.');
						errors = 'Yes';
						return false;
					}
				});
				
				if(errors == 'No'){
					$(this).parent().parent().parent().find('.taxesCollectedDiv').append(create_tax);	
					$("#taxrateNew-"+idx).val(new_rate);
				}
			
			
				$("#removeTax-"+idx+"-"+row).click(function(){
					var value = $(this).parent().find('.taxesInput').val();
					var total_tax = $("#taxrateNew-"+idx).val();
					var newValue = parseFloat(total_tax)-parseFloat(value);
					var newValue = newValue.toFixed(2);
					
					$("#taxrateNew-"+idx).val(newValue);
					$(this).parent().remove();
				});
			
			}			

		});		
		
		
		
		//net rate creation
		$("#netRate-"+idx).keyup(function(){
			var netRate = $(this).val();
			
			$("#ticketInventoryTbody-"+idx+" .inventoryNetRate").val(netRate);
			$("#ticketInventoryTbody-"+idx+" .inventoryMarkupRate").val('0.00');
			$("#ticketInventoryTbody-"+idx+" .inventoryGrossRate").val(netRate);
		});		
		

		//markup keyup function
		//net->gross
		$("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").keyup(function(){
			
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}	
				break;
				
				case '2': //can
					var net = $(this).val();
					var exchange = $("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var markup = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}
			
		});
		//markup -> gross
		$("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}
				break;
				
				case '2': //can
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var exchange = $("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}

			
		});
		//gross -> markup
		$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val(markup);	
					}
				break;
				
				case '2': //can
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var exchange = $("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val(markup);	
					}				
				
				break;
				
			}
		});	

		//canadian scripts

		
		//change status
		$("#Attraction_ticket_new"+idx+"Inventory"+row+"ChangeCurrency").click(function(){
			//var check status
			var status = $(this).attr('status');
			
			switch(status){
				case 'canusd':
					//var old = $("#Attraction_ticket"+idx+"Inventory"+row+"Net").val();
					//$(this).attr('old',old);
					
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					//var gross = $("#Attraction_ticket"+idx+"Inventory"+row+"Gross").val();
					var markup = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val();
					var exchange = 1;
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','usdcan');
					$(this).parent().find("#dollarSignSpan").html("US$");
					$("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val('1.0000');
					$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);
				break;
				
				case 'usdcan':
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var markup = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val();
					var exchange = $(".exchange").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val(exchange);
					$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);				
				break;
			}
		});
		//Add Scripts for Status creates badge on accordion title
		$("#AttractionTicketNew"+idx+"Status").change(function(){
			var status_number = $(this).find('option:selected').val();
			var status = $(this).find('option:selected').html();

			alert('status')
			switch(status_number){				
				case '1':
					var badge = '<span class="label label-important">Unfinished</span>';
				break;
				
				case '2':
					var badge = '<span class="label label-important">'+status+'</span>';
				break;
				
				case '3':
					var badge = '<span class="label label-warning">'+status+'</span>';
				break;
				
				case '4':
					var badge = '<span class="label label-warning">'+status+'</span>';
				break;
				
				case '5':
					var badge = '<span class="label label-success">'+status+'</span>';
				break;
				case '6':
					var badge = '<span class="label label-success">'+status+'</span>';
				break;
			}

			$(this).parent().parent().parent().parent().parent().parent().find('.ticketTypeLabel').html(badge);
		});	


	}, 
	addInventory:function(idx,row,total,start, end){		
		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
		var total = parseInt(total);
		var intRegex = /^\d+$/;
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
		if(start == ''){
			//add errors
			$('#ticketInventoryTbody-'+idx+' tr:last-child .blockBeginDate').parent().parent().attr('class','control-group error');
			$('#ticketInventoryTbody-'+idx+' tr:last-child .blockBeginDate').parent().parent().find('.help-block').html('You must choose an start date');			
		} else {
			//remove errors
			$('#ticketInventoryTbody-'+idx+' tr:last-child .blockBeginDate').parent().parent().attr('class','control-group');
			$('#ticketInventoryTbody-'+idx+' tr:last-child .blockBeginDate').parent().parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#ticketInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group error');		
			$('#ticketInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('You must choose an end date');	
		} else {
			//remove errors
			$('#ticketInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group');
			$('#ticketInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#ticketInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group error');
				$('#ticketInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
			} else {
				//remove errors
				$('#ticketInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group');
				$('#ticketInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
			}
			
		} 
		if(!intRegex.test(total) || intRegex.test(total) <=0) { //checks if number
			$('#ticketInventoryTbody-'+idx+' tr:last-child .ticketBlockTotal').parent().parent().attr('class','control-group error');
			$('#ticketInventoryTbody-'+idx+' tr:last-child .ticketBlockTotal').parent().parent().find('.help-block').html('You must put in a valid quantity');
			
		} 	

		//sucess now send
		if(start != '' && end != '' && startCheck <= endCheck && intRegex.test(total)) {
			var taxRate = $("#ticketInventoryTbody-"+idx+" tr:first-child .inventoryTaxRate").val();
			var netRate = $("#ticketInventoryTbody-"+idx+" tr:first-child .inventoryNetRate").val();
			var grossRate = $("#ticketInventoryTbody-"+idx+" tr:first-child .inventoryGrossRate").val();
			var markupRate = $("#ticketInventoryTbody-"+idx+" tr:first-child .inventoryMarkupRate").val();
			var available = $("#ticketInventoryTbody-"+idx+" tr:first-child .ticketBlockTotal").val();
			var block = newTicketBlock(idx, row, newDateString, taxRate, netRate, grossRate, markupRate,available);
			$("#ticketInventoryTbody-"+idx).append(block);
			attraction_tickets.addInventoryScripts(idx, row, block);
		}
	}, 
	addInventoryNew:function(idx,row,total,start, end){		
		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
		var total = parseInt(total);
		var intRegex = /^\d+$/;
		
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();

		if(start == ''){
			//add errors
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').parent().parent().attr('class','control-group error');
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').parent().parent().find('.help-block').html('You must choose an start date');			
		} else {
			//remove errors
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').parent().parent().attr('class','control-group');
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').parent().parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group error');		
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('You must choose an end date');	
		} else {
			//remove errors
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group');
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group error');
				$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
			} else {
				//remove errors
				$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group');
				$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
			}
			
		} 
		if(!intRegex.test(total) || intRegex.test(total) <=0) { //checks if number
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .roomBlockTotal').parent().parent().attr('class','control-group error');
			$('#ticketInventoryTbodyNew-'+idx+' tr:last-child .roomBlockTotal').parent().parent().find('.help-block').html('You must put in a valid quantity');
			
		} 	

		//sucess now send
		if(start != '' && end != '' && startCheck <= endCheck && intRegex.test(total)) {
			var taxRate = $("#ticketInventoryTbodyNew-"+idx+" tr:first-child .inventoryTaxRate").val();
			var netRate = $("#ticketInventoryTbodyNew-"+idx+" tr:first-child .inventoryNetRate").val();
			var grossRate = $("#ticketInventoryTbodyNew-"+idx+" tr:first-child .inventoryGrossRate").val();
			var markupRate = $("#ticketInventoryTbodyNew-"+idx+" tr:first-child .inventoryMarkupRate").val();
			var available = $("#ticketInventoryTbodyNew-"+idx+" tr:first-child .roomBlockTotal").val();
			var country = $(".countrySelect option:selected").val();
			var exRate = $("#ticketInventoryTbodyNew-"+idx+" tr:first-child .inventoryExchangeRate").val();

			//switch the country code if us then pull the US scripts if Can pull the canadian scripts
			switch (country){
				case '1':
					var block = newTicketBlockUsNew(idx, row, newDateString, netRate, grossRate, markupRate,available);
				break;
				
				case '2':
					var block = newTicketBlockCanNew(idx, row, newDateString, exRate, netRate, grossRate, markupRate,available);
				break;
			}
			$("#ticketInventoryTbodyNew-"+idx).append(block);
			attraction_tickets.addInventoryScriptsNew(idx, row, block);
		}
	}, 
	addInventoryScripts: function(idx, row, date){
		//plugin scripts
		attractions.numberformat();
		$("#AttractionTicket"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#AttractionTicket"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#AttractionTicket"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$('#AttractionTicket"+idx+"Inventory"+row+"StartDate').datepicker('hide');
		});
		$("#AttractionTicket"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$('#AttractionTicket"+idx+"Inventory"+row+"EndDate').datepicker('hide');

		});
		//focus on date after clicking icon span
		$(".blockBeginSpan").click(function(){
			$(this).parent().find('.blockBeginDate').focus();
			$(this).parent().find('.blockBeginDate').select();
		});
		$(".blockEndSpan").click(function(){
			$(this).parent().find('.blockEndDate').focus();
			$(this).parent().find('.blockEndDate').select();
		});
		//rate scripts
		//net->gross
		$("#Attraction_ticket"+idx+"Inventory"+row+"Net").bind('keyup',function(){
			var net = $(this).val();
			var markup = $("#Attraction_ticket"+idx+"Inventory"+row+"Markup").val();
			var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
			var gross =gross.toFixed(2); 
			if(markup != ''){
				$("#Attraction_ticket"+idx+"Inventory"+row+"Gross").val(gross);	
			}
			
		});
		//markup -> gross
		$("#Attraction_ticket"+idx+"Inventory"+row+"Markup").bind('keyup',function(){
			var net = $("#Attraction_ticket"+idx+"Inventory"+row+"Net").val();
			var markup = $(this).val();
			var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
			var gross =gross.toFixed(2);
			if(net != ''){
				$("#Attraction_ticket"+idx+"Inventory"+row+"Gross").val(gross);	
			}
			
		});
		//gross -> markup
		$("#Attraction_ticket"+idx+"Inventory"+row+"Gross").bind('keyup',function(){
			var net = $("#Attraction_ticket"+idx+"Inventory"+row+"Net").val();
			var gross = $(this).val();
			var markup = (parseFloat(gross)/parseFloat(net))-1;
			var markup =(markup*100).toFixed(2);
			if(gross != ''){
				$("#Attraction_ticket"+idx+"Inventory"+row+"Markup").val(markup);	
			}
			
		});	
		
	},
	addInventoryScriptsNew: function(idx, row, date){
		//plugin scripts
		attractions.numberformat();
		$("#AttractionTicketNew"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#AttractionTicketNew"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#AttractionTicketNew"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$('#AttractionTicketNew"+idx+"Inventory"+row+"StartDate').datepicker('hide');
		});
		$("#AttractionTicketNew"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$('#AttractionTicketNew"+idx+"Inventory"+row+"EndDate').datepicker('hide');

		});
		//focus on date after clicking icon span
		$(".blockBeginSpan").click(function(){
			$(this).parent().find('.blockBeginDate').focus();
			$(this).parent().find('.blockBeginDate').select();
		});
		$(".blockEndSpan").click(function(){
			$(this).parent().find('.blockEndDate').focus();
			$(this).parent().find('.blockEndDate').select();
		});	
		//markup keyup function
		//net->gross
		$("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").keyup(function(){
			
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}	
				break;
				
				case '2': //can
					var net = $(this).val();
					var exchange = $("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var markup = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}
			
		});
		//markup -> gross
		$("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}
				break;
				
				case '2': //can
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var exchange =$("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}

			
		});
		//gross -> markup
		$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val(markup);	
					}
				break;
				
				case '2': //can
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var exchange = $("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val(markup);	
					}				
				
				break;
				
			}
			
		});	
		//change status
		$("#Attraction_ticket_new"+idx+"Inventory"+row+"ChangeCurrency").click(function(){
			//var check status
			var status = $(this).attr('status');
			
			switch(status){
				case 'canusd':
					//var old = $("#Attraction_ticket"+idx+"Inventory"+row+"Net").val();
					//$(this).attr('old',old);
					
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					//var gross = $("#Attraction_ticket"+idx+"Inventory"+row+"Gross").val();
					var markup = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val();
					var exchange = 1;
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','usdcan');
					$(this).parent().find("#dollarSignSpan").html("US$");
					$("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val('1.0000');
					$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);
				break;
				
				case 'usdcan':
					var net = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Net").val();
					var markup = $("#Attraction_ticket_new"+idx+"Inventory"+row+"Markup").val();
					var exchange = $(".exchange").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross = gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$("#Attraction_ticket_new"+idx+"Inventory"+row+"ExchangeRate").val(exchange);
					$("#Attraction_ticket_new"+idx+"Inventory"+row+"Gross").val(gross);				
				break;
			}
		});
		

		
	},  
	addTimeScriptsCan: function(idx,row){
		
		
		attractions.numberformat();
		attractions.datepicker();
		//markup keyup function
		//net->gross
		//change status
		$(".attractionTable-"+idx+"[status='active'] #switchNetRate-"+idx+"-"+row).click(function(){

			//var check status
			var status = $(this).attr('status');

			switch(status){
				case 'canusd':
					//var old = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					//$(this).attr('old',old);
					
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					//var gross = $("#Hotel_room"+idx+"Inventory"+row+"Gross").val();
					var markup = $(this).parent().parent().parent().find('.inventoryMarkupRate').val();
					var exchange = 1;
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','usdcan');
					$(this).parent().find("#dollarSignSpan").html("US$");
					$(this).parent().parent().parent().find('.inventoryExchangeRate').val('1.0000');
					$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);
				break;
				
				case 'usdcan':
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					var markup =  $(this).parent().parent().parent().find('.inventoryMarkupRate').val();
					var exchange =  $('.exchange').val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$(this).parent().parent().parent().find('.inventoryExchangeRate').val(exchange);
					$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);				
				break;
			}
		});	
		$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Net").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}	
				break;
				
				case '2': //can

					var net = $(this).val();
					var exchange = $(".exchange").val();
					var markup = $(this).parent().parent().parent().find('.inventoryMarkupRate').val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}				
				break;
				
			}
			
		});
		//markup -> gross
		$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Markup").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}
				break;
				
				case '2': //can
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					var markup = $(this).val();
					var exchange = $(".exchange").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}				
				break;
				
			}
		
		});
		//gross -> markup
		$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Gross").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$(this).parent().parent().parent().find('.inventoryMarkupRate').val(markup);	
					}
				break;
				
				case '2': //can
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					var exchange = $('.exchange').val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$(this).parent().parent().parent().find('.inventoryMarkupRate').val(markup);	
					}				
				
				break;
				
			}
		});	
		$(".ticketAgeRange").blur(function(){
			var age_range = $(this).val();
			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().parent().attr('row');

			if(topDawg == '0'){
				
				var num = $(this).parent().parent().parent().attr('num');
				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .ticketAgeRange").val(age_range);
				
				
			}	
		});
		$(".inventoryInventory").blur(function(){
			var inventory = $(this).val();

			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().parent().attr('row');
			if(topDawg == '0'){
				var num = $(this).parent().parent().parent().attr('num');

				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryInventory").val(inventory);
			}	
		});		
		$(".inventoryNetRate").blur(function(){
			var net = $(this).val();
			var gross = $(this).parent().parent().parent().find('.inventoryGrossRate').val();

			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().parent().attr('row');
			if(topDawg == '0'){
				var num = $(this).parent().parent().parent().attr('num');

				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryNetRate:not(:first-child)").val(net);
				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryGrossRate").val(gross);
			}	
		});
		$(".inventoryMarkupRate").blur(function(){
			var markup = $(this).val();
			var gross = $(this).parent().parent().parent().find('.inventoryGrossRate').val();
			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().parent().attr('row');
			if(topDawg == '0'){
				var num = $(this).parent().parent().parent().attr('num');
				$(".attractionTable-"+idx+"[status='active'] tbody tr[num='"+num+"'] .inventoryMarkupRate").val(markup);
				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryGrossRate").val(gross);
			}	
		});	
		$(".inventoryGrossRate").blur(function(){
			var gross = $(this).val();

			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().parent().attr('row');
			if(topDawg == '0'){
				var num = $(this).parent().parent().parent().attr('num');
				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryGrossRate").val(gross);
			}	
		});		
	},
	addTimeScripts: function(idx,row){
		attractions.numberformat();
		attractions.datepicker();

		$("#addAgeButtonTime-"+idx+"-"+row).click(function(){

			var time = $(this).parent().parent().parent().attr('time');
			var startDate = $(this).parent().parent().find('.blockBeginDate').val();
			var timestamp = new Date(startDate).getTime() / 1000;
			var age_range = $(this).parent().parent().find('.ticketAgeRange').val();
			var endDate = $(this).parent().parent().find('.blockEndDate').val();
			

			
			var country =$('.countrySelect option:selected').val();
			switch(country){
				case '1':
					
					//var addAgeRow = newAgeRangeBlockUs(idx, row, startDate, endDate, time);
					attraction_tickets.addAgeRangeInventoryUs(idx, row,time, timestamp,age_range);
				break;
				
				case '2':
					
					//var addAgeRow = newAgeRangeBlockCan(idx, num, startDate, endDate, time);
					attraction_tickets.addAgeRangeInventoryCan(idx, row,time, timestamp,age_range);
					
				break;
				
			}
			
		});	

		
		//markup keyup function
		//net->gross

		$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Net").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}	
				break;
				
				case '2': //can

					var net = $(this).val();
					var exchange = $(".exchange").val();
					var markup = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}				
				break;
				
			}
			
		});
		//markup -> gross
		$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Markup").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}
				break;
				
				case '2': //can
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					var markup = $(this).val();
					var exchange = $(".exchange").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}				
				break;
				
			}

			
		});
		//gross -> markup
		$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Gross").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$(this).parent().parent().parent().find('.inventoryMarkupRate').val(markup);	
					}
				break;
				
				case '2': //can
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					var exchange = $('.exchange').val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$(this).parent().parent().parent().find('.inventoryMarkupRate').val(markup);	
					}				
				
				break;
				
			}
		});	
		
		$(".attractionTable-"+idx+"[status='active'] #switchNetRate-"+idx+"-"+row).click(function(){

			//var check status
			var status = $(this).attr('status');

			switch(status){
				case 'canusd':
					//var old = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					//$(this).attr('old',old);
					
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					//var gross = $("#Hotel_room"+idx+"Inventory"+row+"Gross").val();
					var markup = $(this).parent().parent().parent().find('.inventoryMarkupRate').val();
					var exchange = 1;
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','usdcan');
					$(this).parent().find("#dollarSignSpan").html("US$");
					$(this).parent().parent().parent().find('.inventoryExchangeRate').val('1.0000');
					$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);
				break;
				
				case 'usdcan':
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					var markup =  $(this).parent().parent().parent().find('.inventoryMarkupRate').val();
					var exchange =  $('.exchange').val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$(this).parent().parent().parent().find('.inventoryExchangeRate').val(exchange);
					$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);				
				break;
			}
		});			
		
	},
	removeByTime: function(idx,time){
		$(".closeTimeButton[row='"+time+"']").click(function(){
			var timeOrigin = time;
			if(confirm('This will delete all '+time+' time rows in the table. Are you sure you want to delete?')){
				
				
				
				$("#timeTable-"+idx+" .ticketTimeFinal").each(function(){
					var timeFind = $(this).val();
					
					if(time == timeFind){
						//count the current tr on the table if there is only 1 tr left only wipe out the data do not delete the row.
						var countTr = $("#timeTable-"+idx+" tbody tr").length;
						if(countTr ==1){
							$("#timeTable-"+idx+" .blockBeginDate").val('');
							$("#timeTable-"+idx+" .blockEndDate").val('');
							$("#timeTable-"+idx+" .ticketTime").val('');
							$("#timeTable-"+idx+" .ticketTimeFinal").val('');
							$("#timeTable-"+idx+" .ticketAgeRange").val('');
							$("#timeTable-"+idx+" .inventoryNetRate").val('');
							$("#timeTable-"+idx+" .inventoryMarkupRate").val('');
							$("#timeTable-"+idx+" .inventoryGrossRate").val('');
							$("#timeTable-"+idx+" .inventoryInventory").val('');
							$("#timeTable-"+idx+" tbody").attr('special','primary');
							$("#timeTable-"+idx+" tbody tr:first-child").attr('row','top');
							attraction_tickets.addScripts(idx,0);
						} else {
							
							var dateCheck = $(this).parent().parent().find('.blockBeginDate').length;
							//there is a current date set here
							if(dateCheck > 0){
								var blockBeginClone = $(this).parent().parent().find('td:first-child div').clone();
								var blockEndClone = $(this).parent().parent().find('td:nth-child(2) div').clone();
								//check the next row if there is a date set
								$(this).parent().parent().parent().next('tbody').find('tr:first-child td:first-child').html(blockBeginClone);
								$(this).parent().parent().parent().next('tbody').find('tr:first-child td:nth-child(2)').html(blockEndClone);
								$(this).parent().parent().parent().next('tbody').find('tr:first-child td:nth-child(2)').css({'border-left':'1px solid #dddddd'});
								
								$(this).parent().parent().parent().remove();

							} else {
								$(this).parent().parent().parent().remove();
							}
							
							
					
						}
					}
				});
				$(this).parent().remove();							
			}

		});		
	},
	editSelect: function(date,idx,updateClass, updateCount){ //creates a multi select of the datepicker
		var timestamp = Math.round((new Date(date)).getTime() / 1000);		
		var oldCount = $(updateClass+" li").length;
		var count = parseInt(oldCount)+1;
		var code_append = 
			'<li id="blackoutDate-'+count+'" timestamp="'+timestamp+'" class="label label-inverse pull-left" style="width:150px; margin-bottom:3; margin-top:3px; margin-right:15px; margin-left:0px;">'+
				'<button id="close-'+count+'" type="button" class="close" count="'+count+'" style="color:#ffffff;">×</button>'+
				'<span class="date_to_edit">Selected: <strong class="text-error">'+date+'</strong></span>'+
				'<input type="hidden" id="AttractionTicket'+idx+'Blackout'+(count-1)+'Dates" name="data[Attraction_ticket]['+idx+'][blackout]['+(count-1)+'][dates]" value="'+date+'"/>'+
			'</li>';

		//$(updateClass).append(code_append).fadeIn('slow');
		attraction_tickets.editCounter(count,idx,updateClass, updateCount);
		attraction_tickets.minusCounter(count,idx,updateClass,updateCount);
		//check to see where in place the new li should be, then append it
		attraction_tickets.insertBlackoutDates(idx,timestamp,updateClass,code_append);
		
	}, 
	editSelectNew: function(date,idx,updateClass, updateCount){ //creates a multi select of the datepicker
		var timestamp = Math.round((new Date(date)).getTime() / 1000);
		
		var oldCount = $(updateClass+" li").length;
		var count = parseInt(oldCount)+1;
		
		
		var code_append = 
			'<li id="blackoutDate-'+count+'" timestamp="'+timestamp+'" class="label label-inverse pull-left" style="width:150px; margin-bottom:3; margin-top:3px; margin-right:15px; margin-left:0px;">'+
				'<button id="close-'+count+'" type="button" class="close" count="'+count+'" style="color:#ffffff;">×</button>'+
				'<span class="date_to_edit">Selected: <strong class="text-error">'+date+'</strong></span>'+
				'<input type="hidden" id="AttractionTicketNew'+idx+'Blackout'+(count-1)+'Dates" name="data[Attraction_ticket_new]['+idx+'][blackout]['+(count-1)+'][dates]" value="'+date+'"/>'+
			'</li>';

		
		attraction_tickets.editCounter(count,idx,updateClass, updateCount);
		attraction_tickets.minusCounter(count,idx,updateClass,updateCount);
		//check to see where in place the new li should be, then append it
		

		attraction_tickets.insertNewBlackoutDates(idx,timestamp,updateClass,code_append);

		
	}, 
	insertBlackoutDates: function(idx,timestamp,updateClass, code_append){
		//check to see where in place the new li should be, then append it
		var liLength = $("#blackoutDatesUl-"+idx+' li:not(.noCountLi)').length;
		switch(liLength){
			case 0:
				$(updateClass).append(code_append).fadeIn('slow');
			break;
			
			default:
				//first check to see if the date matches any of the selected blackout dates
				selected = 0;
				$("#blackoutDatesUl-"+idx+' li').each(function(){
					var checkTime = $(this).attr('timestamp');
					if(timestamp == checkTime){
						
						selected = selected+1;
					}	
				});

				if(selected > 0){
					alert('You have already selected this date. Please choose another blackout date.');
				} else {
					$("#blackoutDatesUl-"+idx+' li').each(function(){
						var thisTime = parseInt($(this).attr('timestamp'));
						var nextLength = $(this).next('li').length;					
						
						
						if(nextLength >0){
							var nextTime = parseInt($(this).next('li').attr('timestamp'));
							
							if(timestamp > thisTime && timestamp < nextTime){
								var thisId = '#blackoutDatesUl-'+idx+' #'+$(this).attr('id');
								$(code_append).insertAfter(thisId);
								$('#blackoutDatesUl-'+idx+' .close').click(function(){

									$(this).parent().fadeOut(300,function(){
										$(this).remove();
									});
						
									
								});								
								return false;
							}
							if(timestamp < thisTime){
								var thisId = '#blackoutDatesUl-'+idx+' #'+$(this).attr('id');
								$(code_append).insertBefore(thisId);
								$('#blackoutDatesUl-'+idx+' .close').click(function(){
									$(this).parent().fadeOut(300,function(){
										$(this).remove();
									});
								});								
								return false;								
							}
						} else {
							if(timestamp > thisTime){

								var thisId = '#blackoutDatesUl-'+idx+' #'+$(this).attr('id');
								$(code_append).insertAfter(thisId);		
								$('#blackoutDatesUl-'+idx+' .close').click(function(){
									$(this).parent().fadeOut(300,function(){
										$(this).remove();
									});
								});								
								return false;						
							} else {
								var thisId = '#blackoutDatesUl-'+idx+' #'+$(this).attr('id');
								$(code_append).insertBefore(thisId);		
								$('#blackoutDatesUl-'+idx+' .close').click(function(){
									$(this).parent().fadeOut(300,function(){
										$(this).remove();
									});
								});								
								return false;	
							}
						}
					});						
				}
			
			break;
		}		
	},
	insertNewBlackoutDates: function(idx,timestamp,updateClass, code_append){
		

		//check to see where in place the new li should be, then append it
		var liLength = $("#blackoutDatesUlNew-"+idx+' li').length;
		switch(liLength){
			case 0:
				$(updateClass).append(code_append).fadeIn('slow');
			break;
			
			default:
				//first check to see if the date matches any of the selected blackout dates
				selected = 0;

				$("#blackoutDatesUlNew-"+idx+' li').each(function(){
					var checkTime = $(this).attr('timestamp');

					if(timestamp == checkTime){
						
						selected = selected+1;
					}	
				});
				if(selected > 0){
					alert('You have already selected this date. Please choose another blackout date.');
				} else {
					$("#blackoutDatesUlNew-"+idx+' li').each(function(){
						var thisTime = parseInt($(this).attr('timestamp'));
						var nextLength = $(this).next('li').length;					
						
						if(nextLength >0){
							var nextTime = parseInt($(this).next('li').attr('timestamp'));
							
							if(timestamp > thisTime && timestamp < nextTime){

								var thisId = '#blackoutDatesUlNew-'+idx+' #'+$(this).attr('id');
								$(code_append).insertAfter(thisId);
								$('#blackoutDatesUlNew-'+idx+' .close').click(function(){
									$(this).parent().fadeOut(300,function(){
										$(this).remove();
									});
								});								
								return false;
							} 
							if(timestamp < thisTime){
								var thisId = '#blackoutDatesUlNew-'+idx+' #'+$(this).attr('id');
								$(code_append).insertBefore(thisId);
								$('#blackoutDatesUlNew-'+idx+' .close').click(function(){
									$(this).parent().fadeOut(300,function(){
										$(this).remove();
									});
								});								
								return false;								
							}
						} else {
							if(timestamp > thisTime){

								var thisId = '#blackoutDatesUlNew-'+idx+' #'+$(this).attr('id');
								$(code_append).insertAfter(thisId);		
								$('#blackoutDatesUlNew-'+idx+' .close').click(function(){
									$(this).parent().fadeOut(300,function(){
										$(this).remove();
									});
								});								
								return false;						
							} else {
								var thisId = '#blackoutDatesUlNew-'+idx+' #'+$(this).attr('id');
								$(code_append).insertBefore(thisId);
								$('#blackoutDatesUlNew-'+idx+' .close').click(function(){
									$(this).parent().fadeOut(300,function(){
										$(this).remove();
									});
								});								
								return false;									
							}
						}
					});						
				}
			
			break;
		}		
	},
	editCounter: function(count,idx,updateClass,counterClass){ //adds to the counter
		if(count >0){
			$("#noneSelectedP-"+idx).hide();
		} 
		$(counterClass).html(count);	
	},
	minusCounter: function(count,idx,updateClass,counterClass){ //removes from the counter

		$(updateClass+" #close-"+count).click(function(){
			$(this).parent().fadeTo("slow", 0.00, function(){ //fade           	
                $(this).remove(); //then remove from the DOM
                var newCount = $(updateClass+" li").length;
                $(counterClass).html(newCount);
			    //reindex the hidden input fields inside of the blackout dates ul
			    $(updateClass+' li input').each(function(row){
			    	$(this).attr('id','AttractionTicket'+idx+'Blackout'+row+'Dates');
			    	$(this).attr('name','data[Attraction_ticket]['+idx+'][blackout]['+row+'][dates]');
			    });              
            });
     	});
 
	}
}
/**
 * All functions returning variables
 * @param {Object} str
 */
var returnState = function(str){
	var afterComma = str.substr(str.indexOf(",") + 1);
	var state = afterComma.replace(/ /g,'');  
	return state;
}
var returnCity = function(str){
	var beforeComma = str.substr(0, str.indexOf(',')); 
	return beforeComma;
}
var createUrl = function(str){
	var str = str.toLowerCase();
	if(str == ''){
		var url = '';
	} else {
		var url = '/'+str.replace(/[^\w\s]/gi, '').replace(/ /g,"-");
	}
	
	return url;
}



