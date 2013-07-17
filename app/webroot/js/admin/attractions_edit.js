$(document).ready(function(){

/*
 * Attractions Edit page
 */

	$("#attraction_name,#attraction_location").html(''); //clear the attraction name and attraction location fields on page refresh
	$(".attractionNameInput").val(''); //clear the attraction name inputs and location inputs on page refersh
	attractions.cityStateCountry('.cityInput','#stateInput','.countrySelect option'); //auto fill inputs based on city search
	//attractions.series1check(); 
	
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
	
	reindex.all();
	
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
			var blackoutUl = $(this).parents('.accordion-group:first').find('.blackoutDatesUl');
			var counterUl = $(this).parents('.accordtion-group:first').find('.blackoutDateCounter');
			attractions.editSelect(date,idx, blackoutUl,counterUl);
			reindex.all();
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
	stepy: function(name){
		$(name).stepy({
		 	back: function(index) {
				$("#toTopHover").click();

				if(index ==3){//moving out of step 3
					var country = $(".countrySelect option:selected").val();
					var add_on_length = $("#attractionAddOnTbody tr").length;
					if(add_on_length == 0){
						switch (country){
							case '1':
								var blankTr = blankTrUs();
								
							break;
							
							case '2':
								var blankTr = blankTrCan();
							break;
						}
						$("#attractionAddOnTbody").html(blankTr);
						var element_add_on_net = $("#attractionAddOnTbody tr:last .attractionAddOnNet");
						addScripts.attractionAddOnNet(element_add_on_net);
						addScripts.numberFormat(element_add_on_net);
							
						var element_add_on_gross = $("#attractionAddOnTbody tr:last .attractionAddOnGross");
						addScripts.attractionAddOnGross(element_add_on_gross);	
						addScripts.numberFormat(element_add_on_gross);									
					}
				}
			}, next: function(index) {
				$("#toTopHover").click();
				if(index ==4){ //moving out of step 2
					$("#attractionAddOnTbody tr").each(function(num){
						
						var emptyAddOn = $(this).find('#attractionAddOnTitle').val();
						if(emptyAddOn == ''){
							$(this).remove();
						} else {
							var add_on_title = $(this).find('#attractionAddOnTitle').val();
							var add_on_net = $(this).find('.attractionAddOnNet').val();
							var add_on_exchange = $(this).find('.attractionAddOnExchange').val();
							var add_on_gross = $(this).find('.attractionAddOnGross').val();
							var add_on_basis = $(this).find('.attractionAddOnPerBasis:checked').val();
							var country = $(".countrySelect option:selected").val();
							switch(country){
								case '1':
								addOnTable = addOnsUs(num);
								break;
								
								default:
								addOnTable = addOnsCan(num);
								break;
							}
							$(".addOnDiv").html(addOnTable);
							
							
						}
						reindex.all();
					});
				}
				if(index ==5){ //move out of step 3

					reindex.all();
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
		
		//ADD ONs 
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
			var element = $(this);
			addScripts.attractionAddOnNet(element);
			
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
			attractions.addBlock(row, start_date,end_date);
		});
		
		/**
		 * Attraction Ticket Creation Step 3 & 4 of wizard
		 */
		$("#createTicketFormButton").click(function(){
			var amount = $("#createTicketInput").val();
			attractions.validate(amount, '#createTicketFormDiv', '#accordion4');
			
		});
		$("#addTicketRow").click(function(){
			var lastRows =  $("#ticketTbody tr:last-child").attr('id').replace('ticketTr-','');
			var newRow = parseInt(lastRows)+1;
			attractions.addTicketSchedule(newRow, '#ticketTbody','#accordion4');
		});
		/**
		 * Attraction Add-on creation
		 */
		$("#attractionAddOnButton").click(function(){
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
					
					var element_add_on_net = $("#addOnTable #attractionAddOnTbody tr:last .attractionAddOnNet");
					addScripts.attractionAddOnNet(element_add_on_net);
					addScripts.numberFormat(element_add_on_net);
					
					var element_add_on_gross =  $("#addOnTable #attractionAddOnTbody tr:last .attractionAddOnGross");
					addScripts.attractionAddOnGross(element_add_on_gross);	
					addScripts.numberFormat(element_add_on_gross);
					
					
				break;
			}
 
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
		
		//Adds a row to the non timed attraction
		
		$(".addAgeButton").click(function(){
			var age_range = $(this).parents('tr:first').find('.ticketAgeRange').val();
			var inventory = $(this).parents('tr:first').find('.inventoryInventory').val();
			var net = $(this).parents('tr:first').find('.inventoryNetRate').val();
			var exchange = $(this).parents('tr:first').find('.inventoryExchangeRate').val();
			var markup = $(this).parents('tr:first').find('.inventoryMarkupRate').val();
			var gross = $(this).parents('tr:first').find('.inventoryGrossRate').val();
			var type = $(this).attr('main');
			//add a row here
			switch(type){
				case 'notime-can':
					var newInventoryTr = newTicketBlockCan(age_range,inventory,net,exchange, gross, markup);
				break;
				case 'notime-us':
					var newInventoryTr = newTicketBlockUs(age_range,inventory,net, markup, gross);
				break;
				case 'time-can':
					var time = $(this).parents('tr:first').attr('time');
					var newInventoryTr = newTicketSubTimeCan(age_range,inventory,exchange,net,markup,gross, time);
				break;
				case 'time-us':
					var time = $(this).parents('tr:first').attr('time');
					var newInventoryTr = newTicketSubTimeUs(age_range,inventory,net,markup,gross, time);
				break;
			}
			$(this).parents('tr:first').after(newInventoryTr);
			var element_add = $(this).parents('tr:first').next('tr').find('.addAgeButton');
			var element_delete = $(this).parents('tr:first').next('tr').find('.deleteRow');
			var element_delete_time = $(this).parents('tr:first').next('tr').find('.deleteRowTime');
			var element_delete_tbody = $(this).parents('tr:first').next('tr').find('.deleteTbody');
			var element_switch = $(this).parents('tr:first').next('tr').find('.switchNetRate');
			var element_net = $(this).parents('tr:first').next('tr').find('.inventoryNetRate');
			var element_exchange = $(this).parents('tr:first').next('tr').find('.inventoryExchangeRate');
			var element_markup = $(this).parents('tr:first').next('tr').find('.inventoryMarkupRate');
			var element_gross = $(this).parents('tr:first').next('tr').find('.inventoryGrossRate');
			
			addScripts.calculateGrossByNet(element_net);
			addScripts.calculateGrossByMarkup(element_markup);
			addScripts.calculateNetByGross(element_gross);
			addScripts.addAgeButton(element_add);
			addScripts.deleteRow(element_delete);
			addScripts.deleteRowTime(element_delete_time);
			addScripts.deleteTbody(element_delete_tbody);
			addScripts.calcExchange(element_switch);
			reindex.all();
		});
		
		//deletes a row from the attractions edit table		
		$(".deleteRow").click(function(){
			if(confirm('Are you sure you want to remove this date row?')){
				$(this).parents('tr:first').remove();	
			}		
			reindex.all();	
		});
		
		//deletes tbody for attractions no time ticket
		$(".deleteTbody").click(function(){
			if(confirm('Are you sure you want to remove this date range?')){
				var count = $(this).parents('table:first').find('tbody').length;

				if(count >1){
					$(this).parents('tbody:first').remove();		
				} else {
					var type = $(this).parents('table:first').attr('type');
					switch(type){
						case 'noTimeTable':
							//do not remove but clean up tbody 
							$(this).parents('tbody:first').find('tr:gt(0)').remove();
							$(this).parents('tbody:first').find('.blockBeginDate').val('');
							$(this).parents('tbody:first').find('.blockEndDate').val('');
							$(this).parents('tbody:first').find('.ticketAgeRange').val('');
							$(this).parents('tbody:first').find('.inventoryInventory').val('');
							$(this).parents('tbody:first').find('.inventoryNetRate').val('');
							$(this).parents('tbody:first').find('.inventoryMarkupRate').val('');
							$(this).parents('tbody:first').find('.inventoryGrossRate').val('');						
						break;
						
						case 'timeTable':
							$(this).parents('tbody:first').find('tr:gt(0)').remove();
							$(this).parents('tbody:first').find('.blockBeginDate').val('');
							$(this).parents('tbody:first').find('.blockEndDate').val('');
							$(this).parents('tbody:first').find('.ticketAgeRange').val('');
							$(this).parents('tbody:first').find('.inventoryInventory').val('');
							$(this).parents('tbody:first').find('.inventoryNetRate').val('');
							$(this).parents('tbody:first').find('.inventoryMarkupRate').val('');
							$(this).parents('tbody:first').find('.inventoryGrossRate').val('');								
						break;
					}
				}
			}
			reindex.all();
		});
		

		
		//add new tbody attraction inventory no time ticket
		$(".addTicketInventory").click(function(){		
			var count_tr = $(this).parents('.accordion-group:first').find('table[status="active"] tbody tr').length;
			if(count_tr > 0){		
				var ticket_id = $(this).attr('id').replace('addTicketInventory-','');
				//get last date and add an extra day to it
				var get_last_date = $(this).parent().find('table[status="active"] tbody:last').find('.blockEndDate').val();
				var get_new_start = addDays(get_last_date, 1);
				var get_new_end = addDays(get_new_start, 1);
				var newTbody = $(this).parent().find('table[status="active"] tbody:first').clone();
				$(this).parent().find('table[status="active"]').append(newTbody);
				
			} else {
				//first remove any existing tbody
				$(this).parents('.accordion-group:first').find('table[status="active"] tbody').remove();
				var type = $(this).parents('.accordion-group:first').find('table[status="active"]').attr('type');
				var country = $(this).parents('.accordion-group:first').find('table[status="active"]').attr('country');
				switch(type){
					case 'noTimeTable':
						switch(country){
							case 'US':
								newTbody = new_tbody1();
							break;
							
							case 'CAN':
								newTbody = new_tbody3();
							break;
						}
					break;
					
					case 'timeTable':
						switch(country){
							case 'US':
								newTbody = new_tbody2();
							break;
							
							case 'CAN':
								newTbody = new_tbody4();
							break;
						}					
					break;
				}

				$(this).parents('.accordion-group:first').find('table[status="active"]').append(newTbody);
			}
			//get the dates from the last tbody and replace them with a new date
			
			$(this).parent().find('table[status="active"] tbody:last').find('.blockBeginDate').val(get_new_start);
			$(this).parent().find('table[status="active"] tbody:last').find('.blockEndDate').val(get_new_end);
			
			//add in scripts needed
			var element_start_datepicker = $(this).parent().find('table[status="active"] tbody:last').find('.blockBeginDate');
			var element_end_datepicker = $(this).parent().find('table[status="active"] tbody:last').find('.blockEndDate');
			
			addScripts.datePicker(element_start_datepicker);
			addScripts.datePicker(element_end_datepicker);
			
			
			$(this).parents('.accordion-group:first').find('table[status="active"] tbody:last tr').each(function(){
				
				var element_net = $(this).find('.inventoryNetRate');
				var element_exchange = $(this).find('.inventoryExchangeRate');
				var element_markup = $(this).find('.inventoryMarkupRate');
				var element_gross = $(this).find('.inventoryGrossRate');
				var element_delete_tr = $(this).find('.deleteRow');
				var element_delete_tr_time = $(this).find('.deleteRowTime');
				var element_delete_tbody =$(this).find('.deleteTbody');
				var element_add_button = $(this).find('.addAgeButton');
				var element_switch = $(this).find('.switchNetRate');
				addScripts.numberFormat(element_net);
				addScripts.numberFormat(element_markup);
				addScripts.numberFormat(element_gross);
				//keyup functions for calculating net or gross
				addScripts.calculateGrossByNet(element_net);
				addScripts.calculateGrossByMarkup(element_markup);
				addScripts.calculateNetByGross(element_gross);
				addScripts.deleteRow(element_delete_tr);
				addScripts.deleteRowTime(element_delete_tr_time);
				addScripts.deleteTbody(element_delete_tbody);
				addScripts.addAgeButton(element_add_button);
				addScripts.calcExchange(element_switch);
				
			});
			reindex.all();
		});
		
		//Calculating net<->exchange<->markup<->gross
		
		$(".inventoryNetRate").keyup(function(){
			var type = $(this).parents('table:first').attr('type');
			var net = parseFloat($(this).val());
			var gross = parseFloat($(this).parents('tr:first').find('.inventoryGrossRate').val());
			if($(this).parents('tr:first').find('.inventoryExchangeRate').is('*')){
				var exchange = parseFloat($(this).parents('tr:first').find('.inventoryExchangeRate').val());
			} else {
				var exchange = 1;
			}
			var markup = parseFloat($(this).parents('tr:first').find('.inventoryMarkupRate').val());
			
			var new_gross = calcGross(net, exchange, markup, gross);
			$(this).parents('tr:first').find('.inventoryGrossRate').val(new_gross);

		});
		$(".inventoryMarkupRate").keyup(function(){
			var type = $(this).parents('table:first').attr('type');
			var net = parseFloat($(this).parents('tr:first').find('.inventoryNetRate').val());
			var gross = parseFloat($(this).parents('tr:first').find('.inventoryGrossRate').val());
			if($(this).parents('tr:first').find('.inventoryExchangeRate').is('*')){
				var exchange = parseFloat($(this).parents('tr:first').find('.inventoryExchangeRate').val());
			} else {
				var exchange = 1;
			}
			var markup = parseFloat($(this).val());
			
			var new_gross = calcGross(net, exchange, markup, gross);
			$(this).parents('tr:first').find('.inventoryGrossRate').val(new_gross);

		});
		$(".inventoryGrossRate").keyup(function(){
			var type = $(this).parents('table:first').attr('type');
			var net = parseFloat($(this).parents('tr:first').find('.inventoryNetRate').val());
			var gross = parseFloat($(this).val());
			if($(this).parents('tr:first').find('.inventoryExchangeRate').is('*')){
				var exchange = parseFloat($(this).parents('tr:first').find('.inventoryExchangeRate').val());
			} else {
				var exchange = 1;
			}

			
			var new_net = calcMarkup(net, exchange, gross);
			$(this).parents('tr:first').find('.inventoryMarkupRate').val(new_net);
		});		
		
		//calculate currency exchange
		$(".switchNetRate").click(function(){
			var type = $(this).attr('status');
			switch(type){
				case 'canusd':
					$(this).attr('status','usdcan');
					$(this).parent().find('#dollarSignSpan').html('US$');
					$(this).parents('tr:first').find('.inventoryExchangeRate').val('1.0000');
					$(this).parents('tr:first').find('.inventoryExchangeRate').parent().find('.add-on').html('USD/CAN');
					
					
				break;
				
				case 'usdcan':
					$(this).attr('status','canusd');
					$(this).parent().find('#dollarSignSpan').html('CN$');
					$(this).parents('tr:first').find('.inventoryExchangeRate').val($('.exchange').val());
					$(this).parents('tr:first').find('.inventoryExchangeRate').parent().find('.add-on').html('CAN/USD');
				break;
			}
			var net = $(this).parents('tr:first').find('.inventoryNetRate').val();
			var gross = $(this).parents('tr:first').find('.inventoryGrossRate').val();
			var markup = $(this).parents('tr:first').find('.inventoryMarkupRate').val();
			var exchange = $(this).parents('tr:first').find('.inventoryExchangeRate').val();
			
			var new_net = calcNet(net, exchange, markup, gross);
			$(this).parents('tr:first').find('.inventoryMarkupRate').val(new_net);
		});
		//Time Table Setup
		//time table time select
		$(".timeSubmit").click(function(){
			var idx = $(this).attr('id').replace('timeSubmit-','');
			var time = $(this).parent().find(".timeInput").val();
			var exchange = $('.exchange').val();
			
			//first check to see if the active table has any rows. if not then click create row
			var tbodyCount = $(this).parents('.accordion-group:first').find('table[status="active"] tbody').length;
			if(tbodyCount ==0){
				$(this).parents('.accordion-group:first').find('.addTicketInventory').click();
			}
			
			if(time ==''){
				$(this).parent().parent().parent().attr('class','control-group error');
				$(this).parent().parent().parent().find('.help-block').html('Time cannot be empty');
			} else {
				$(this).parent().parent().parent().attr('class','control-group');
				$(this).parent().parent().parent().find('.help-block').html('');		
				
				var newTime = newTimeLi(time);
				var timeLength = $("#timeResults-"+idx+" li").length;
				switch(timeLength){
					case 0:

						var countTableRows = $(this).parents('.accordion-group:first').find("table[status='active'] tbody").length;

						if(countTableRows == 0){
							var country = $('.countrySelect option:selected').val();
							switch(country){
								case '1':

									var newTbody = new_tbody();
								break;
								
								case '2':

									var newTbody = new_tbody2();
									
								break;
							}

							$("#timeTable-"+idx).append(newTbody);	
							
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
						$("#timeTable-"+idx+" .ticketInventoryTbody tr").attr('time',time);
						$("#timeTable-"+idx+" .ticketInventoryTbody").attr('row',0);	
						$("#timeTable-"+idx+" .blockBeginDate").attr('name','data[Attraction_ticket][0][inventory][0][start_date]');
						$("#timeTable-"+idx+" .blockEndDate").attr('name','data[Attraction_ticket][0][inventory][0][end_date]');
						$("#timeTable-"+idx+" .ticketTimeFinal").attr('name','data[Attraction_ticket][0][inventory][0][time]');
						$("#timeTable-"+idx+" .ticketAgeRange").attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][age_range]');
						$("#timeTable-"+idx+" .inventoryInventory").attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][inventory]');
						$("#timeTable-"+idx+" .inventoryNetRate").attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][net]');
						$("#timeTable-"+idx+" .inventoryMarkupRate").attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][markup]');
						$("#timeTable-"+idx+" .inventoryGrossRate").attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][gross]');
						
						
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
							var country = $(".attractionTable-"+idx+"[status='active']").attr('country');
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-block').html('');
							
							$("#timeResults-"+idx).show();
							$("#timeResults-"+idx).append(newTime);
							var last_li = $("#timeResults-"+idx+' li:last').find('button');
							addScripts.removeByTime(last_li);
							$("#timeInput-"+idx).val('');	
							
							var type=$(this).parents('.accordion-group:first').find('table[status="active"]').attr('country');
							switch(type){
								case 'US':
									var nextRow =  newTicketTimeUs(time);		
								break;
								
								case 'CAN':
									var nextRow =  newTicketTimeCan(time);
								break;
							}
							$(".attractionTable-"+idx+"[status='active'] tbody:first").append(nextRow);						
							var element_net = $(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.inventoryNetRate');
							var element_exchange = $(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.inventoryExchangeRate');
							var element_markup =$(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.inventoryMarkupRate');
							var element_gross = $(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.inventoryGrossRate');
							var element_delete_tr = $(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.deleteRow');
							var element_delete_tr_time = $(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.deleteRowTime');
							var element_delete_tbody =$(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.deleteTbody');
							var element_add_button = $(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.addAgeButton');
							var element_switch = $(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.switchNetRate');
							var element_close_time = $(".attractionTable-"+idx+"[status='active'] tbody:first tr:last").find('.closeTimeButton');
							addScripts.numberFormat(element_net);
							addScripts.numberFormat(element_markup);
							addScripts.numberFormat(element_gross);
							//keyup functions for calculating net or gross
							addScripts.calculateGrossByNet(element_net);
							addScripts.calculateGrossByMarkup(element_markup);
							addScripts.calculateNetByGross(element_gross);
							addScripts.deleteRow(element_delete_tr);
							addScripts.deleteRowTime(element_delete_tr_time);
							addScripts.deleteTbody(element_delete_tbody);
							addScripts.addAgeButton(element_add_button);
							addScripts.calcExchange(element_switch);
							addScripts.closeTimeButton(element_close_time);
							
							
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-block').html('');		
							reindex.all();	
										
						} else {
							$(this).parent().parent().parent().attr('class','control-group error');
							$(this).parent().parent().parent().find('.help-block').html('Time has already been created. Please choose another time.');					
						}					
					break;
				}
				
				
			}
		});		

		$(".multiday").click(function(){
			var idx = $(this).attr('id').replace('multiday-','');
			var status = $(this).val();
			//check the status of checkd if its not checked then do this
			if(status =='Yes'){
				$(this).attr('value','Yes');
				//show the time table & hide the no time table
				$("#multidayDiv-"+idx).show();
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
		//write the script to remove the time from the table 
		$(".closeTimeButton").click(function(){
			var time = $(this).attr('row');
			var id = $(this).parents('ol:first').attr('id').replace('timeResults-','');
			
			if(confirm('Are you sure you want to delete all of the '+time+' rows?')){
				$(this).parents('li:first').remove();
				$(".attractionTable-"+id+" tbody").each(function(){
					//first clone the first begin date, end date tds
					var begin_date = $(this).find('tr:first td:first').html();
					var end_date = $(this).find('tr:first td:nth-child(2)').html();
					//next delete ALL of the rows in which this time is matching
					$(this).find('tr[time="'+time+'"]').remove();
					
					//then count the remaining tr left
					var count_top = $(this).find('tr[row="top"]').length;
					var count_tr = $(this).find('tr').length;
					if(count_top == 0 && count_tr==0){
						//remove tbody	
						$(this).remove();
					} else if(count_top == 0 && count_tr > 0){
						//take cloned values and insert into new first row
						$(this).find('tr:first td:first').html(begin_date);
						$(this).find('tr:First td:nth-child(2)').html(end_date);
						$(this).find('tr:first').attr('row','top');
					} else {
						$(this).remove();
					}
				});
			}
		});	
		//add Attraction Room
		$("#addAttractionTicketButton").click(function(){
			var newRow = $("#accordionTicketType .attractionTicket:last-child").length;
			if(newRow >0){
				var idx = $("#accordionTicketType .attractionTicket:last-child").attr('idx');
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

			var location = $(".countrySelect option:selected").val(); //location is used to determine what type of attraction room form we are using
			var idx = $(".accordion-group[row='new']").length;
			//based on the location switch the variables
			switch(location){
				case '1': //This is US Add Ons
					var get_addOns = addOnsUs(idx);
					var newRow = newTicketUs(idx,'');
				break;
				
				case '2': //This is CAN Add Ons
					var get_addOns = addOnsCan(idx);
					var newRow = newTicketCan(idx, '');
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
			var element_status = $("#accordionTicketType .accordion-group:last .statusSelect");
			var element_taxes = $("#accordionTicketType .accordion-group:last .taxSelection");
			var element_blackout = $("#accordionTicketType .accordion-group:last .fullYear");
			var element_remove = $("#accordionTicketType .accordion-group:last .removeTicketButton");
			var element_multiday = $("#accordionTicketType .accordion-group:last .multiday");
			var element_begin = $("#accordionTicketType .accordion-group:last .blockBeginDate");
			var element_end = $("#accordionTicketType .accordion-group:last .blockEndDate");
			var element_net = $("#accordionTicketType .accordion-group:last .inventoryNetRate");
			var element_exchange = $("#accordionTicketType .accordion-group:last .inventoryExchangeRate");
			var element_markup = $("#accordionTicketType .accordion-group:last .inventoryMarkupRate");
			var element_gross = $("#accordionTicketType .accordion-group:last .inventoryGrossRate");
			var element_add = $("#accordionTicketType .accordion-group:last .addAgeButton");
			var element_remove_row = $("#accordionTicketType .accordion-group:last .deleteRow");
			var element_row_time = $("#accordionTicketType .accordion-group:last .deleteRowTime");
			var element_tbody = $("#accordionTicketType .accordion-group:last .deleteTbody");
			var element_time_submit = $("#accordionTicketType .accordion-group:last .timeSubmit");
			var element_add_tour = $("#accordionTicketType .accordion-group:last .addTicketInventory");
			var element_time_input = $("#accordionTicketType .accordion-group:last .timeInput");

			addScripts.numberFormat(element_net);
			addScripts.numberFormat(element_markup);
			addScripts.numberFormat(element_gross);
			addScripts.addAgeButton(element_add);
			addScripts.calculateGrossByNet(element_net);
			addScripts.calculateGrossByMarkup(element_markup);
			addScripts.calculateNetByGross(element_gross);
			addScripts.datePicker(element_begin);
			addScripts.datePicker(element_end);
			addScripts.statusSelect(element_status);
			addScripts.taxSelect(element_taxes);
			addScripts.blackout(element_blackout);	
			addScripts.removeTour(element_remove);
			addScripts.multiday(element_multiday);
			addScripts.deleteRow(element_remove_row);
			addScripts.deleteTbody(element_tbody);
			addScripts.deleteRowTime(element_row_time);
			addScripts.timeSubmit(element_time_submit);
			addScripts.addTicketInventory(element_add_tour);
			addScripts.minutes(element_time_input);

		
		});	
		//status selection
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
			reindex.all();
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
		$('.close').click(function(){
			

			$(this).parent().remove();
			var countLi = $(this).parents('.accordion-group:first').find(".blackoutDatesUl li").length;

			if(countLi ==0){
 
				$("#blackoutDatesUl-"+ticket_id).html('<li class="noCountLi"><input type="hidden" value="" name="data[Attraction_ticket]['+ticket_id+'][blackout][0][dates]"/></li>');				
			}
			
		});		
		$(".thumbnail").click(function(){		
			$(this).parents('ul:first').find('li').attr('name','nonprimary');
			$(this).parents('ul:first').find('li').css({
				'background':'#ffffff'
			});
			$(this).parents('ul:first').find('li .thumbnail').css({
				'background':'#ffffff'
			});
			$(this).parents('li:first').attr('name','primary');	
			$(this).css({
				'background':'#a7ffb8'
			});
			//establish if this is a hotel or a hotel room
			var parent_id = $(this).parent().attr('name');
			//var id = $(this).attr('id').replace('thumbnail-','');
			var filename =  $(this).attr('imageId');

			if(parent_id == 'Attraction'){
				var primary_input = '<input type="hidden" attraction="'+parent_id+'" filename="'+filename+'" name="data['+parent_id+'][image_main]" value="'+filename+'"/>';
				//remove other instances
				$("#imagesFormDiv input[attraction='"+parent_id+"']").remove();
				//add in new hotel primary image
				$("#imagesFormDiv").append(primary_input);
			}
			if(parent_id == 'Attraction_ticket'){
				var tour = $(this).parent().parent().parent().parent().parent().parent().parent().find('a h4').html();
				var tour_id = $(this).parents('.accordion-group:first').attr('tour_id');
				var primary_input = '<input type="hidden" attraction="'+parent_id+'" tour_id="'+tour_id+'" filename="'+filename+'" name="data['+parent_id+']['+tour_id+'][image_primary]" value="'+filename+'"/>';
				//remove other instances
				$("#imagesFormDiv input[attraction='"+parent_id+"'][tour_id='"+tour_id+"']").remove();
				//add in new hotel primary image
				$("#imagesFormDiv").append(primary_input);				
			}
			
		});
		$(".removeImage").click(function(){
			if(confirm('Are you sure you want to delete?')){
				var filename =  $(this).parents('li:first').attr('imageId');

				//remove from dom
				$(this).parent().parent().remove();
				
				//add a remove to inputs
				var removeInput = '<input name="data[Remove]['+filename+']" value="'+name+'"/>';
				$("#imagesFormDiv").append(removeInput);
				//remove the rest of the room pics
				$("#accordion4 .attraction_ticket_images #thumbnail-"+filename).each(function(){
					$(this).remove();
				});
			}
		});

	},
	editSelect: function(date,idx,updateClass, updateCount){ //creates a multi select of the datepicker
		var timestamp = Math.round((new Date(date)).getTime() / 1000);		
		var oldCount =updateClass.find("li").length;
		var count = parseInt(oldCount)+1;
		var code_append = 
			'<li id="blackoutDate-'+count+'" timestamp="'+timestamp+'" class="label label-inverse pull-left" style="width:150px; margin-bottom:3; margin-top:3px; margin-right:15px; margin-left:0px;">'+
				'<button id="close-'+count+'" type="button" class="close" count="'+count+'" style="color:#ffffff;">×</button>'+
				'<span class="date_to_edit">Selected: <strong class="text-error">'+date+'</strong></span>'+
				'<input type="hidden" id="AttractionTicket'+idx+'Blackout'+(count-1)+'Dates" name="data[Attraction_ticket]['+idx+'][blackout]['+(count-1)+'][dates]" value="'+date+'"/>'+
			'</li>';

		//$(updateClass).append(code_append).fadeIn('slow');
		attractions.editCounter(count,idx,updateClass, updateCount);
		attractions.minusCounter(count,idx,updateClass,updateCount);
		//check to see where in place the new li should be, then append it
		attractions.insertBlackoutDates(idx,timestamp,updateClass,code_append);
		
	}, 
	editCounter: function(count,idx,updateClass,counterClass){ //adds to the counter
		if(count >0){
			$("#noneSelectedP-"+idx).hide();
		} 
		counterClass.html(count);	
	},
	minusCounter: function(count,idx,updateClass,counterClass){ //removes from the counter

		updateClass.find("#close-"+count).click(function(){
			$(this).parent().fadeTo("slow", 0.00, function(){ //fade           	
                $(this).remove(); //then remove from the DOM
                var newCount = updateClass.find('li').length;
                counterClass.html(newCount);
			    //reindex the hidden input fields inside of the blackout dates ul
			    updateClass.find('li input').each(function(row){
			    	$(this).attr('id','AttractionTicket'+idx+'Blackout'+row+'Dates');
			    	$(this).attr('name','data[Attraction_ticket]['+idx+'][blackout]['+row+'][dates]');
			    });              
            });
     	});
 
	},
	insertBlackoutDates: function(idx,timestamp,updateClass, code_append){
		//check to see where in place the new li should be, then append it
		var liLength = updateClass.find('li:not(.noCountLi)').length;
		switch(liLength){
			case 0:
				updateClass.append(code_append).fadeIn('slow');
			break;
			
			default:
				//first check to see if the date matches any of the selected blackout dates
				selected = 0;
				 updateClass.find('li').each(function(){
					var checkTime = $(this).attr('timestamp');
					if(timestamp == checkTime){
						
						selected = selected+1;
					}	
				});

				if(selected > 0){
					alert('You have already selected this date. Please choose another blackout date.');
				} else {
					 updateClass.find('li').each(function(){
						var thisTime = parseInt($(this).attr('timestamp'));
						var nextLength = $(this).next('li').length;					
						
						
						if(nextLength >0){
							var nextTime = parseInt($(this).next('li').attr('timestamp'));
							
							if(timestamp > thisTime && timestamp < nextTime){
								var thisId = $(this);
								$(code_append).insertAfter(thisId);
							
								return false;
							}
							if(timestamp < thisTime){
								var thisId = $(this);
								$(code_append).insertBefore(thisId);
							
								return false;								
							}
						} else {
							if(timestamp > thisTime){

								var thisId = $(this);
								$(code_append).insertAfter(thisId);		
						
								return false;						
							} else {
								var thisId = $(this);
								$(code_append).insertBefore(thisId);		
						
								return false;	
							}
						}
					});						
				}
			
			break;
		}		
		reindex.all();
	}
}
addScripts = {
	addAgeButton: function(element){
		element.click(function(){

			var age_range = $(this).parents('tr:first').find('.ticketAgeRange').val();
			var inventory = $(this).parents('tr:first').find('.inventoryInventory').val();
			var net = $(this).parents('tr:first').find('.inventoryNetRate').val();
			var exchange = $(this).parents('tr:first').find('.inventoryExchangeRate').val();
			var markup = $(this).parents('tr:first').find('.inventoryMarkupRate').val();
			var gross = $(this).parents('tr:first').find('.inventoryGrossRate').val();
			var type = $(this).attr('main');
			//add a row here
			switch(type){
				case 'notime-can':
					var newInventoryTr = newTicketBlockCan(age_range,inventory,net,exchange, gross, markup);
				break;
				case 'notime-us':
					var newInventoryTr = newTicketBlockUs(age_range,inventory,net, markup, gross);
				break;
				case 'time-can':
					var time = $(this).parents('tr:first').attr('time');
					var newInventoryTr = newTicketSubTimeCan(age_range,inventory,exchange,net,markup,gross, time);
				break;
				case 'time-us':
					var time = $(this).parents('tr:first').attr('time');
					var newInventoryTr = newTicketSubTimeUs(age_range,inventory,net,markup,gross, time);
				break;
			}
			$(this).parents('tr:first').after(newInventoryTr);
			var element_add = $(this).parents('tr:first').next('tr').find('.addAgeButton');
			var element_delete = $(this).parents('tr:first').next('tr').find('.deleteRow');
			var element_delete_time = $(this).parents('tr:first').next('tr').find('.deleteRowTime');
			var element_delete_tbody = $(this).parents('tr:first').next('tr').find('.deleteTbody');
			var element_switch = $(this).parents('tr:first').next('tr').find('.switchNetRate');
			var element_net = $(this).parents('tr:first').next('tr').find('.inventoryNetRate');
			var element_exchange = $(this).parents('tr:first').next('tr').find('.inventoryExchangeRate');
			var element_markup = $(this).parents('tr:first').next('tr').find('.inventoryMarkupRate');
			var element_gross = $(this).parents('tr:first').next('tr').find('.inventoryGrossRate');
			addScripts.calculateGrossByNet(element_net);
			addScripts.calculateGrossByMarkup(element_markup);
			addScripts.calculateNetByGross(element_gross);
			addScripts.addAgeButton(element_add);
			addScripts.deleteRow(element_delete);
			addScripts.deleteRowTime(element_delete_time);
			addScripts.deleteTbody(element_delete_tbody);
			addScripts.calcExchange(element_switch);
			
			reindex.all();

		});		
	},

	deleteRow: function(element){
		element.click(function(){
			if(confirm('Are you sure you want to remove this date row?')){
				$(this).parents('tr:first').remove();	
			}	
			reindex.all();		
		});		
	},
	deleteRowTime: function(element){
		element.click(function(){
			if(confirm('Are you sure you want to remove this time row?')){
				var time = $(this).parents('tr:first').attr('time');
				$(this).parents('tbody:first').find('tr[time="'+time+'"]').remove();
			}
			reindex.all();
		});
	},
	deleteTbody: function(element){

		element.click(function(){
			if(confirm('Are you sure you want to remove this date range?')){
				var count = $(this).parents('table:first').find('tbody').length;

				if(count >1){
					$(this).parents('tbody:first').remove();		
				} else {
					var type = $(this).parents('table:first').attr('type');
					switch(type){
						case 'noTimeTable':
							//do not remove but clean up tbody 
							$(this).parents('tbody:first').find('tr:gt(0)').remove();
							$(this).parents('tbody:first').find('.blockBeginDate').val('');
							$(this).parents('tbody:first').find('.blockEndDate').val('');
							$(this).parents('tbody:first').find('.ticketAgeRange').val('');
							$(this).parents('tbody:first').find('.inventoryInventory').val('');
							$(this).parents('tbody:first').find('.inventoryNetRate').val('');
							$(this).parents('tbody:first').find('.inventoryMarkupRate').val('');
							$(this).parents('tbody:first').find('.inventoryGrossRate').val('');						
						break;
						
						case 'timeTable':
							//do not remove but clean up tbody 
							$(this).parents('tbody:first').find('tr:gt(0)').remove();
							$(this).parents('tbody:first').find('.blockBeginDate').val('');
							$(this).parents('tbody:first').find('.blockEndDate').val('');
							$(this).parents('tbody:first').find('.ticketAgeRange').val('');
							$(this).parents('tbody:first').find('.inventoryInventory').val('');
							$(this).parents('tbody:first').find('.inventoryNetRate').val('');
							$(this).parents('tbody:first').find('.inventoryMarkupRate').val('');
							$(this).parents('tbody:first').find('.inventoryGrossRate').val('');									
						break;
					}
				}
			}
			reindex.all();
		});
		
	},
	minutes: function(element){
		var minutes = $(".minutes").attr('datasource');
		element.attr('data-source',minutes);
	},
	datePicker: function(element){
		element.datepicker().on('changeDate', function(ev){
  			$(this).datepicker('hide');
		});
	},
	numberFormat: function(element){
		element.priceFormat({'prefix':'',});
	},
	calculateGrossByNet: function(element){
		addScripts.numberFormat(element);
		element.keyup(function(){
			var type = $(this).parents('table:first').attr('type');
			var net = parseFloat($(this).val().replace(/,/g,""));
			var gross = parseFloat($(this).parents('tr:first').find('.inventoryGrossRate').val().replace(/,/g,""));
			if($(this).parents('tr:first').find('.inventoryExchangeRate').is('*')){
				var exchange = parseFloat($(this).parents('tr:first').find('.inventoryExchangeRate').val());
			} else {
				var exchange = 1;
			}
			var markup = parseFloat($(this).parents('tr:first').find('.inventoryMarkupRate').val());
			
			var new_gross = calcGross(net, exchange, markup, gross);
			$(this).parents('tr:first').find('.inventoryGrossRate').val(new_gross);

		});		
	}, 
	calculateGrossByMarkup: function(element){
		addScripts.numberFormat(element);
		element.keyup(function(){
			var type = $(this).parents('table:first').attr('type');
			var net = parseFloat($(this).parents('tr:first').find('.inventoryNetRate').val().replace(/,/g,""));
			var gross = parseFloat($(this).parents('tr:first').find('.inventoryGrossRate').val().replace(/,/g,""));
			if($(this).parents('tr:first').find('.inventoryExchangeRate').is('*')){
				var exchange = parseFloat($(this).parents('tr:first').find('.inventoryExchangeRate').val());
			} else {
				var exchange = 1;
			}
			var markup = parseFloat($(this).val());
			
			var new_gross = calcGross(net, exchange, markup, gross);
			$(this).parents('tr:first').find('.inventoryGrossRate').val(new_gross);

		});		
	},
	calculateNetByGross: function(element){
		addScripts.numberFormat(element);
		element.keyup(function(){
			var type = $(this).parents('table:first').attr('type');
			var net = parseFloat($(this).parents('tr:first').find('.inventoryNetRate').val().replace(/,/g,""));
			var gross = parseFloat($(this).val().replace(/,/g,""));
			if($(this).parents('tr:first').find('.inventoryExchangeRate').is('*')){
				var exchange = parseFloat($(this).parents('tr:first').find('.inventoryExchangeRate').val());
			} else {
				var exchange = 1;
			}
			var markup =parseFloat($(this).parents('tr:first').find('.inventoryMarkupRate').val());
			
			var new_net = calcNet(net, exchange, markup, gross);
			$(this).parents('tr:first').find('.inventoryNetRate').val(new_net);
		});			
	},
	calcExchange: function(element){
		element.click(function(){
			var type = $(this).attr('status');
			switch(type){
				case 'canusd':
					$(this).attr('status','usdcan');
					$(this).parent().find('#dollarSignSpan').html('US$');
					$(this).parents('tr:first').find('.inventoryExchangeRate').val('1.0000');
					$(this).parents('tr:first').find('.inventoryExchangeRate').parent().find('.add-on').html('USD/CAN');
					
					
				break;
				
				case 'usdcan':
					$(this).attr('status','canusd');
					$(this).parent().find('#dollarSignSpan').html('CN$');
					$(this).parents('tr:first').find('.inventoryExchangeRate').val($('.exchange').val());
					$(this).parents('tr:first').find('.inventoryExchangeRate').parent().find('.add-on').html('CAN/USD');
				break;
			}
			var net = $(this).parents('tr:first').find('.inventoryNetRate').val();
			var gross = $(this).parents('tr:first').find('.inventoryGrossRate').val();
			var markup = $(this).parents('tr:first').find('.inventoryMarkupRate').val();
			var exchange = $(this).parents('tr:first').find('.inventoryExchangeRate').val();
			
			var new_net = calcNet(net, exchange, markup, gross);

			$(this).parents('tr:first').find('.inventoryNetRate').val(new_net);
		});		
	},
	removeByTime: function(element){
		element.click(function(){
			var time = $(this).attr('row');
			var id = $(this).parents('ol:first').attr('id').replace('timeResults-','');
			
			if(confirm('Are you sure you want to delete all of the '+time+' rows?')){
				$(this).parents('li:first').remove();
				$(".attractionTable-"+id+" tbody").each(function(){
					//first clone the first begin date, end date tds
					var begin_date = $(this).find('tr:first td:first').html();
					var end_date = $(this).find('tr:first td:nth-child(2)').html();
					//next delete ALL of the rows in which this time is matching
					$(this).find('tr[time="'+time+'"]').remove();
					
					//then count the remaining tr left
					var count_top = $(this).find('tr[row="top"]').length;
					var count_tr = $(this).find('tr').length;
					if(count_top == 0 && count_tr==0){
						//remove tbody	
						$(this).remove();
					} else if(count_top == 0 && count_tr > 0){
						//take cloned values and insert into new first row
						$(this).find('tr:first td:first').html(begin_date);
						$(this).find('tr:First td:nth-child(2)').html(end_date);
						$(this).find('tr:first').attr('row','top');
					}
				});
			}
		});		
	},
	statusSelect: function(element){
		element.change(function(){
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

			$(this).parents('.accordion-group:first').find('.ticketTypeLabel').html(badge);
		});
	},
	taxSelect: function(element){
		//tax rate creation
		element.change(function(){
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
	},
	blackout: function(element){
		element.datepicker().change(function() {
			var date = $(this).val();
			var idx = 0;
			$('.datepicker td .day').css({'background-color':'red'});
			var blackoutDatesUl = $(this).parents('.accordion-group:first').find('.blackoutDatesUl');
			var countUl = $(this).parents('.accordion-group:first').find('.blackoutDateCounter');
			attractions.editSelect(date,idx, blackoutDatesUl,countUl);

		});		
		var element_close = element.find('.close');
		addScripts.closeBlackout(element_close);
	},
	removeTour: function(element){
		element.click(function(){
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
	},
	multiday: function(element){
		element.click(function(){
			
			var idx = $(this).attr('id').replace('multiday-','');
			var status = $(this).val();
			//check the status of checkd if its not checked then do this
			if(status =='Yes'){
				$(this).attr('value','Yes');
				//show the time table & hide the no time table
				$("#multidayDiv-"+idx).show();
				$("#noTimeTableDiv-"+idx).hide();
				$("#timeTableDiv-"+idx).fadeIn();
				
				//change the status of each table
				$("#noTimeTable-"+idx).attr('status','notactive');
				$("#noTimeTable-"+idx+" input").attr('disabled','disabled');
				$("#timeTable-"+idx).attr('status','active');
				$("#timeTable-"+idx+" input").removeAttr('disabled');
				$("#timeTable-"+idx+" .ticketTime").attr('disabled','disabled');
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
	},
	timeSubmit: function(element){
		//time table time select
		element.click(function(){

			//first check to see if the active table has any rows. if not then click create row
			var tbodyCount = $(this).parents('.accordion-group:first').find('table[status="active"] tbody').length;
			if(tbodyCount ==0){
				$(this).parents('.accordion-group:first').find('.addTicketInventory').click();
			}

			var time = $(this).parent().find('.timeInput').val();
			var exchange = $('.exchange').val();
			if(time ==''){
				$(this).parent().parent().parent().attr('class','control-group error');
				$(this).parent().parent().parent().find('.help-block').html('Time cannot be empty');
			} else {
				$(this).parent().parent().parent().attr('class','control-group');
				$(this).parent().parent().parent().find('.help-block').html('');		
				
				var newTime = newTimeLi(time);
				var timeLength = $(this).parent().parent().parent().parent().find('.timeResults li').length;

				switch(timeLength){
					case 0:
						var countTableRows = $(this).parents('.accordion-group:first').find('table[status="active"] tbody tr').length;
						if(countTableRows == 0){
							var country = $('.countrySelect option:selected').val();
							switch(country){
								case '1':
									var newTbody = new_tbody();
								break;
								
								case '2':
									var newTbody = new_tbody2();
									
								break;
							}

							$(this).parents('.accordion-group:first').find('table[status="active"]').append(newTbody);	
							
						}

						$(this).parent().parent().parent().parent().find('.timeResults').show();
						$(this).parent().parent().parent().parent().find('.timeResults').append(newTime);	
						$(this).parent().find('.timeInput').val('');
						$(this).parents('.accordion-group:first').find('table[status="active"] .newAgeRow').find('input').removeAttr('disabled');
						$(this).parents('.accordion-group:first').find('table[status="active"] .newAgeRow .ticketTime').attr('disabled','disabled');
						$(this).parents('.accordion-group:first').find('table[status="active"] .newAgeRow .inventoryExchangeRate').attr('disabled','disabled');
						$(this).parents('.accordion-group:first').find('table[status="active"] .newAgeRow').attr('time',time);
						$(this).parents('.accordion-group:first').find('table[status="active"] .ticketTime').val(time);	
						$(this).parents('.accordion-group:first').find('table[status="active"] .ticketTimeFinal').val(time);	
						$(this).parents('.accordion-group:first').find('table[status="active"] .ticketInventoryTbody').attr('time',time);
						$(this).parents('.accordion-group:first').find('table[status="active"] .ticketInventoryTbody').attr('row',0);	
						$(this).parents('.accordion-group:first').find('table[status="active"] .blockBeginDate').attr('name','data[Attraction_ticket][0][inventory][0][start_date]');
						$(this).parents('.accordion-group:first').find('table[status="active"] .blockEndDate').attr('name','data[Attraction_ticket][0][inventory][0][end_date]');
						$(this).parents('.accordion-group:first').find('table[status="active"] .ticketTimeFinal').attr('name','data[Attraction_ticket][0][inventory][0][time]');
						$(this).parents('.accordion-group:first').find('table[status="active"] .ticketAgeRange').attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][age_range]');
						$(this).parents('.accordion-group:first').find('table[status="active"] .inventoryInventory').attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][inventory]');
						$(this).parents('.accordion-group:first').find('table[status="active"] .inventoryNetRate').attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][net]');
						$(this).parents('.accordion-group:first').find('table[status="active"] .inventoryMarkupRate').attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][markup]');
						$(this).parents('.accordion-group:first').find('table[status="active"] .inventoryGrossRate').attr('name','data[Attraction_ticket][0][inventory][0][age_range][0][gross]');
						
						
					break;
					
					default:
						var errors = 0;
						$(this).parent().parent().parent().parent().find(".timeResults li").each(function(){
							var checkTime = $(this).attr('time');
							if(time ==checkTime){
								errors = 1;
								return false;
							}
						});
						if(errors == 0){
							var type = $(this).parents('.accordion-group:first').find('table[status="active"]').attr('type');
							var country = $(this).parents('.accordion-group:first').find('table[status="active"]').attr('country');
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-block').html('');
							
							$(this).parent().parent().parent().parent().find(".timeResults").show();
							$(this).parent().parent().parent().parent().find(".timeResults").append(newTime);
							var last_li = $(this).parent().parent().parent().parent().find(".timeResults li:last").find('button');
							addScripts.removeByTime(last_li);
							$(this).parent().find(".timeInput").val('');	
							switch(country){
								case 'US':
									var nextRow =  newTicketTimeUs(time);		
								break;
								
								case 'CAN':
									var nextRow =  newTicketTimeCan(time);
								break;
							}

							$(this).parents('.accordion-group:first').find('table[status="active"] tbody:first').append(nextRow);		
							$(this).parents('.accordion-group:first').find('table[status="active"] tr:last').attr('time',time);						
							var element_net =$(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.inventoryNetRate');
							var element_exchange = $(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.inventoryExchangeRate');
							var element_markup =$(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.inventoryMarkupRate');
							var element_gross = $(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.inventoryGrossRate');
							var element_delete_tr = $(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.deleteRow');
							var element_delete_tr_time = $(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.deleteRowTime');
							var element_delete_tbody =$(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.deleteTbody');
							var element_add_button = $(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.addAgeButton');
							var element_switch = $(this).parents('.accordion-group:first').find('table[status="active"] tbody:first tr:last').find('.switchNetRate');
							var element_remove_time =$("#accordionTicketType .accordion-group:last .closeTimeButton");
							addScripts.numberFormat(element_net);
							addScripts.numberFormat(element_markup);
							addScripts.numberFormat(element_gross);
							//keyup functions for calculating net or gross
							addScripts.calculateGrossByNet(element_net);
							addScripts.calculateGrossByMarkup(element_markup);
							addScripts.calculateNetByGross(element_gross);
							addScripts.deleteRow(element_delete_tr);
							addScripts.deleteRowTime(element_delete_tr_time);
							addScripts.deleteTbody(element_delete_tbody);
							addScripts.addAgeButton(element_add_button);
							addScripts.calcExchange(element_switch);
							addScripts.closeTimeButton(element_remove_time);
							
							
							reindex.all();	
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-block').html('');		
										
						} else {
							$(this).parent().parent().parent().attr('class','control-group error');
							$(this).parent().parent().parent().find('.help-block').html('Time has already been created. Please choose another time.');					
						}					
					break;
				}
				
				
			}
		});		
	},
	addTicketInventory: function(element){
		//add new tbody attraction inventory no time ticket
		element.click(function(){	
			var count_tr = $(this).parents('.accordion-group:first').find('table[status="active"] tbody tr').length;
			if(count_tr > 0){		
				//get last date and add an extra day to it
				var get_last_date = $(this).parent().find('table[status="active"] tbody:last').find('.blockEndDate').val();
				var get_new_start = addDays(get_last_date, 1);
				var get_new_end = addDays(get_new_start, 1);
				var newTbody = $(this).parent().find('table[status="active"] tbody:first').clone();
				$(this).parents('.accordion-group:first').find('table[status="active"]').append(newTbody);
				
			} else {
				alert('here2')
				//first remove any existing tbody
				$(this).parents('.accordion-group:first').find('table[status="active"] tbody').remove();
				var type = $(this).parents('.accordion-group:first').find('table[status="active"]').attr('type');
				var country = $(this).parents('.accordion-group:first').find('table[status="active"]').attr('country');
				switch(type){
					case 'noTimeTable':
						switch(country){
							case 'US':
								newTbody = new_tbody1();
							break;
							
							case 'CAN':
								newTbody = new_tbody3();
							break;
						}
					break;
					
					case 'timeTable':
						switch(country){
							case 'US':
								newTbody = new_tbody2();
							break;
							
							case 'CAN':
								newTbody = new_tbody4();
							break;
						}					
					break;
				}

				$(this).parents('.accordion-group:first').find('table[status="active"]').append(newTbody);
			}
			//get the dates from the last tbody and replace them with a new date
			
			$(this).parent().find('table[status="active"] tbody:last').find('.blockBeginDate').val(get_new_start);
			$(this).parent().find('table[status="active"] tbody:last').find('.blockEndDate').val(get_new_end);
			
			//add in scripts needed
			var element_start_datepicker = $(this).parent().find('table[status="active"] tbody:last').find('.blockBeginDate');
			var element_end_datepicker = $(this).parent().find('table[status="active"] tbody:last').find('.blockEndDate');
			addScripts.datePicker(element_start_datepicker);
			addScripts.datePicker(element_end_datepicker);
			
			
			$(this).parent().find('table[status="active"] tbody:last tr').each(function(){
				var element_net = $(this).find('.inventoryNetRate');
				var element_exchange = $(this).find('.inventoryExchangeRate');
				var element_markup = $(this).find('.inventoryMarkupRate');
				var element_gross = $(this).find('.inventoryGrossRate');
				var element_delete_tr = $(this).find('.deleteRow');
				var element_delete_tr_time = $(this).find('.deleteRowTime');
				var element_delete_tbody =$(this).find('.deleteTbody');
				var element_add_button = $(this).find('.addAgeButton');
				var element_switch = $(this).find('.switchNetRate');
				addScripts.numberFormat(element_net);
				addScripts.numberFormat(element_markup);
				addScripts.numberFormat(element_gross);
				//keyup functions for calculating net or gross
				addScripts.calculateGrossByNet(element_net);
				addScripts.calculateGrossByMarkup(element_markup);
				addScripts.calculateNetByGross(element_gross);
				addScripts.deleteRow(element_delete_tr);
				addScripts.deleteRowTime(element_delete_tr_time);
				addScripts.deleteTbody(element_delete_tbody);
				addScripts.addAgeButton(element_add_button);
				addScripts.calcExchange(element_switch);
				
			});
			reindex.all();
		});		
	},
	attractionAddOnNet: function(element){
		element.blur(function(){
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
			var element = $(this);
			addScripts.attractionAddOnNet(element);
			
		});
	},
	attractionAddOnGross: function(element){
		element.blur(function(){
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
	},
	closeBlackout: function(element){
		element.click(function(){
			var ticket_id = $(this).parent().parent().attr('id').replace('blackoutDatesUl-','');

			$(this).parent().remove();
			var countLi = $("#blackoutDatesUl-"+ticket_id).find('li').length;

			if(countLi ==0){
 
				$("#blackoutDatesUl-"+ticket_id).html('<li class="noCountLi"><input type="hidden" value="" name="data[Attraction_ticket]['+ticket_id+'][blackout][0][dates]"/></li>');				
			}
			
		});
	},
	closeTimeButton: function(element){
		//write the script to remove the time from the table 
		element.click(function(){
			var time = $(this).attr('row');
			
			if(confirm('Are you sure you want to delete all of the '+time+' rows?')){
				$(this).parents('li:first').remove();
				element.parents('.accordion-group:first').find("table[status='active'] tbody").each(function(){
					//first clone the first begin date, end date tds
					var begin_date = $(this).find('tr:first td:first').html();
					var end_date = $(this).find('tr:first td:nth-child(2)').html();
					//next delete ALL of the rows in which this time is matching
					$(this).find('tr[time="'+time+'"]').remove();
					
					//then count the remaining tr left
					var count_top = $(this).find('tr[row="top"]').length;
					var count_tr = $(this).find('tr').length;
					if(count_top == 0 && count_tr==0){
						//remove tbody	
						$(this).remove();
					} else if(count_top == 0 && count_tr > 0){
						//take cloned values and insert into new first row
						$(this).find('tr:first td:first').html(begin_date);
						$(this).find('tr:First td:nth-child(2)').html(end_date);
						$(this).find('tr:first').attr('row','top');
					} else {
						$(this).remove();
					}
				});
			}
		});			
	}
}
/**
 * Counts the elements needed to reindexed
 * then loops through all the elements with the proper attribute reindex="Yes"
 */
reindex = {
	all: function(){
		$('div[method="Edit"]').each(function(){

			var tour_id = $(this).attr('tour_id');
			
			//add ons
			$(this).find('.addOnCheckList:checked').each(function(ev){
				$(this).parents('tr:first').find(".inventoryAddOnsTitle").attr('name','data[Attraction_ticket]['+tour_id+'][add_ons]['+ev+'][title]');
				$(this).parents('tr:first').find(".inventoryAddOnsNet").attr('name','data[Attraction_ticket]['+tour_id+'][add_ons]['+ev+'][net]');
				$(this).parents('tr:first').find(".inventoryAddOnsExchange").attr('name','data[Attraction_ticket]['+tour_id+'][add_ons]['+ev+'][exchange]');
				$(this).parents('tr:first').find(".inventoryAddOnsGross").attr('name','data[Attraction_ticket]['+tour_id+'][add_ons]['+ev+'][gross]');
			});			

			$(this).find('.taxesInput').each(function(){ //ticket taxes
				var tax_id = $(this).attr('id').replace('taxesInput-','');
				$(this).attr('name','data[Attraction_ticket]['+tour_id+'][taxes]['+tax_id+']');
			});
			
			$(this).find('.taxrate').attr('name','data[Attraction_ticket]['+tour_id+'][tax_rate]'); //ticket tax rate			
			//first rearrange name indexes for the main inventory data inside the tables
			$('table[status="active"][method="Edit"]').each(function(){ //already created tables 
				var type = $(this).attr('type');
				switch(type){
					case 'noTimeTable':
						var id = $(this).attr('id').replace('noTimeTable-','');
						var idx = -1;
						var adx = -1;						
						
						$(this).find('tbody').each(function(){
							idx++;
							$(this).find('tr').each(function(){
								adx++;
								var tar = $(this).find('.ticketAgeRange').val();
								
								
								$(this).find('.blockBeginDate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][start_date]');
								$(this).find('.blockEndDate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][end_date]');		
								$(this).find('.ticketAgeRange').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+adx+'][age_range]');
								$(this).find('.inventoryInventory').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+adx+'][inventory]');
								$(this).find('.inventoryNetRate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+adx+'][net]');
								$(this).find('.inventoryMarkupRate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+adx+'][markup]');
								$(this).find('.inventoryGrossRate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+adx+'][gross]');
							});
						});				
						//next update the blackout dates
						
								
					break;
					
					case 'timeTable':

						var id = $(this).attr('id').replace('timeTable-','');
						var idx = -1;
						var adx = -1;						
						
						$(this).find('tbody').each(function(){
							idx++;
							$(this).find('tr').each(function(){
								adx++;
								var tar = $(this).find('.ticketAgeRange').val();
								var time = $(this).attr('time');
								$(this).find('.blockBeginDate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][start_date]');
								$(this).find('.blockEndDate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][end_date]');		
								$(this).find('.ticketTimeFinal').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][time]');							
								$(this).find('.ticketAgeRange').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][age_range]');
								$(this).find('.inventoryInventory').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][inventory]');
								$(this).find('.inventoryNetRate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][net]');
								$(this).find('.inventoryMarkupRate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][markup]');
								$(this).find('.inventoryGrossRate').attr('name','data[Attraction_ticket]['+id+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][gross]');
							
							});
						});		
					break;
				}		
			});
			
		});
		var ndx = -1;
		var bdx =-1;
		$('div[method="New"]').each(function(){
			ndx++;
			
			//change the name attr within the new divs
			$(this).find('.attractionTicketName').attr('name','data[Attraction_ticket_new]['+ndx+'][name]'); //ticket name
			$(this).find('.attraction_ticket_status').attr('name','data[Attraction_ticket_new]['+ndx+'][status]'); //ticket status
			//add ons
			$(this).find('.addOnCheckList:checked').each(function(ev){
				$(this).parents('tr:first').find(".inventoryAddOnsTitle").attr('name','data[Attraction_ticket_new]['+ndx+'][add_ons]['+ev+'][title]');
				$(this).parents('tr:first').find(".inventoryAddOnsNet").attr('name','data[Attraction_ticket_new]['+ndx+'][add_ons]['+ev+'][net]');
				$(this).parents('tr:first').find(".inventoryAddOnsExchange").attr('name','data[Attraction_ticket_new]['+ndx+'][add_ons]['+ev+'][exchange]');
				$(this).parents('tr:first').find(".inventoryAddOnsGross").attr('name','data[Attraction_ticket_new]['+ndx+'][add_ons]['+ev+'][gross]');
			});
			//tax
			$(this).find('.taxesInput').each(function(){ //ticket taxes
				var tax_id = $(this).attr('id').replace('taxesInput-','');
				$(this).attr('name','data[Attraction_ticket_new]['+ndx+'][taxes]['+tax_id+']');
			});
			
			$(this).find('.taxrate').attr('name','data[Attraction_ticket_new]['+ndx+'][tax_rate]'); //ticket tax rate
			
			$('table[status="active"][method="New"]').each(function(){ //newly created tours need a new index
				var type = $(this).attr('type');
				var idx = -1;
				var adx = -1;
				switch(type){
					case 'noTimeTable':
						$(this).find('tbody').each(function(){
							idx++;
							$(this).find('tr').each(function(){
								var tar = $(this).find('.ticketAgeRange').val();
								adx++;
								$(this).find('.multiday').attr('name','data[Attraction_ticket_new]['+ndx+'][timed_ticket]');
								$(this).find('.blockBeginDate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][start_date]');
								$(this).find('.blockEndDate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][end_date]');		
								$(this).find('.ticketAgeRange').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+adx+'][age_range]');
								$(this).find('.inventoryInventory').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+adx+'][inventory]');
								$(this).find('.inventoryNetRate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+adx+'][net]');
								$(this).find('.inventoryMarkupRate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+adx+'][markup]');
								$(this).find('.inventoryGrossRate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+adx+'][gross]');
							});
						});					
					break;
					
					case 'timeTable':
						$(this).find('tbody').each(function(){
							idx++;
							$(this).find('tr').each(function(){
								var tar = $(this).find('.ticketAgeRange').val();
								var time = $(this).attr('time');
								adx++;
								$(this).find('.multiday').attr('name','data[Attraction_ticket_new]['+ndx+'][timed_ticket]');
								$(this).find('.blockBeginDate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][start_date]');
								$(this).find('.blockEndDate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][end_date]');
								$(this).find('.ticketTimeFinal').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][time]');
								$(this).find('.ticketAgeRange').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][age_range]');
								$(this).find('.inventoryInventory').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][inventory]');
								$(this).find('.inventoryNetRate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][net]');
								$(this).find('.inventoryMarkupRate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][markup]');
								$(this).find('.inventoryGrossRate').attr('name','data[Attraction_ticket_new]['+ndx+'][inventory]['+idx+'][age_range]['+time+']['+adx+'][gross]');
							});
						});	
					break;
				}		
			});		
			
			$(this).find(".blackoutDatesUl li").each(function(){
				bdx++;
				$(this).find('input').attr('name','data[Attraction_ticket_new]['+ndx+'][blackout]['+bdx+'][dates]');
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

var addDays = function(date, days){
	var days = parseInt(days);
	var millis = Date.parse(date);
	var newDate = new Date();
	newDate.setTime(millis  + days*24*60*60*1000);
	var newDateStr = "" + (newDate.getMonth()+1) + "/" + newDate.getDate() + "/" + newDate.getFullYear();

	return newDateStr;
}
var calcGross = function(net, exchange, markup, gross){
	var net = parseFloat(net);
	var exchange = parseFloat(exchange);
	var markup = parseFloat(markup);
	var gross = parseFloat(gross);
	
	var new_gross = (net * exchange * (1+(markup / 100)))*100;
	var new_gross = Math.round(new_gross) / 100;
	var new_gross = new_gross.toFixed(2);
	return new_gross;
}
var calcNet = function(net, exchange, markup, gross){
	var net = parseFloat(net);
	var exchange = parseFloat(exchange);
	var markup = parseFloat(markup);
	var gross = parseFloat(gross);
	
	var new_net = (gross / exchange / (1+(markup / 100)))*100;
	var new_net = Math.round(new_net) / 100;
	var new_net = new_net.toFixed(2);
	
	return new_net;
}
var calcMarkup = function(net, exchange, gross){
	var net = parseFloat(net);
	var exchange = parseFloat(exchange);
	var gross = parseFloat(gross);
	var markup = (gross/net/exchange);
	var markup = (markup - 1) * 100 * 100;
	var markup = Math.round(markup) / 100;
	var markup = markup.toFixed(2);
	
	return markup;
}
