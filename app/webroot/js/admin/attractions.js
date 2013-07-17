$(document).ready(function(){

/*
 * Attractions add page
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
	
	
	//on form creation this will make sure that the url is unique and validates any empty fields
	// if successful it will send a get to the same page to finish the attraction form, 1 for manual, 2 for automatic
	$("#buttonSeries1Next").click(function(){
		var name = $('.attractionNameInput').val();
		var location = $(".locationInput").val();
		var url = createUrl(location)+createUrl(name);

		if(name == ''){ //if attraction name field is empty
			$(".attractionNameInput").parent().attr('class','control-group error');
			$(".attractionNameInput").parent().find('.help-inline').html('Error: Please provide a attraction name.');
			$("#attractionUrlDiv").attr('class','control-group error');
			$("#attractionUrlDiv p").attr('class','alert alert-error');
			$("#attractionUrlDiv .help-block").html('Not a valid url');
		}
		if(name != '' ) {	// if both name and attraction type is selected then run these scripts
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
	 * Attraction Ticket Creation Step 3 & 4 of wizard
	 */
	$("#createTicketFormButton").click(function(){
		var amount = $("#createTicketInput").val();
		//remove all of the old markteting tickets
		$("#accordion4 .accordion-group").remove();
		
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
		$('.taxesInput').priceFormat({
			'prefix':'',
			limit:5
		});
		$('.taxrate').priceFormat({
			'prefix':'',
			limit:5
		});
		$(".netRate").priceFormat({
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
  			var date = $(this).val();

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
		//focus on date after clicking icon span
		$(".blockBeginSpan").click(function(){
			$(this).parent().find('.blockBeginDate').focus();
			$(this).parent().find('.blockEndDate').select();
		});
		$(".blockEndSpan").click(function(){
			$(this).parent().find('.blockEndDate').focus();
			$(this).parent().find('.blockEndDate').select();
		});
	},
	series1check: function(){
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
		
		$(".locationInput").change(function(){
			var location = $('.locationInput option:selected').val();
			var url = createUrl(location);
			$("#attraction_location").html('');
			$(".locationInput").parent().attr('class','control-group');
			$(".locationInput").parent().find('.help-inline').html('');
			$("#attractionUrlDiv").attr('class','control-group');	
			$("#attractionUrlDiv p").attr('class','well well-small muted');	
			$("#attractionUrlDiv .help-block").html('');	
			$("#attraction_location").html(url);
			$("#attractionUrlDiv").attr('name','notvalid');	
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
				
				var flag = 'Yes';
				$(this).attr('flag',flag);
				var row = $("input[exchange='Yes']").length;
				//add a new hidden input named flag
				$(this).parent().find('.attractionAddOnFlag').remove();
				var hiddenFields = getAddOnExchange(row,net,flag,exchange,old,gross); 
				$(this).parent().append(hiddenFields);
				
			}
		});	
		//add Hotel Room Button
		$("#addAttractionTicketButton").click(function(){
			var idx = $("#accordionTicketType .accordion-group:last-child").attr('idx');
			if(idx == ''){
				idx = 1;
			} else {
				var idx = parseFloat(idx)+1;	
			}
			
			var row = 0;
			attraction_tickets.addTicket(idx,row);
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
						//insert into form
						$("#attraction_url").val(getUrl);
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
		 		//if back buton clicked then click to top
				$("#toTopHover").click();
 
				if(index ==2){//moving out of step 3
					var addOnLength = $('#attractionAddOnTbody tr').length;
					if(addOnLength ==0){
						var country = $(".countrySelect option:selected").val();
						switch(country){
							case '1':
								//add in a new row
								$("#attractionAddOnTbody").append(
									'<tr id="attractionAddOnTr-0" class="attractionAddOnTr">'+
										'<td><input id="attractionAddOnTitle" type="text" name="data[Attraction][add_ons][0][title]"/></td>'+
										'<td class="control-group">'+
											'<div class="input-prepend">'+
												'<span class="add-on">US$</span>'+
												'<input class="attractionAddOnPrice" type="text" class="span10" name="data[Attraction][add_ons][0][price]"/>'+
											'</div>'+
										'</td>'+
		
									'</tr>'
								);
								attractions.numberformat();							
							break;
							
							case '2':
								var exRate = $(".exchange").val(); 								
								//add in a new row
								$("#attractionAddOnTbody").append(
									'<tr id="attractionAddOnTr-0" class="attractionAddOnTr">'+
										'<td><input id="attractionAddOnTitle" type="text" name="data[Attraction][add_ons][0][title]"/></td>'+
										'<td class="control-group">'+
											'<div class="input-prepend">'+
												'<span class="add-on">CN$</span>'+
												'<input id="attractionAddOnNet-0" class="attractionAddOnNet" type="text" style="width:75px"  name="data[Attraction][add_ons][0][net]"/>'+
											'</div>'+
										'</td>'+
										'<td>'+
											'<div class="input-append">'+
												'<input id="attractionAddOnExchange-0" class="attractionAddOnExchange" type="text" style="width:75px"  name="data[Attraction][add_ons][0][exchange]" value="'+exRate+'" disabled="disabled"/>'+
												'<span class="add-on">CAN/USD</span>'+
											'</div>'+									
										'</td>'+
										"<td>"+
											'<div class="input-prepend">'+
												'<span class="add-on">US$</span>'+
												'<input id="attractionAddOnGross-0" class="attractionAddOnGross" type="text" style="width:75px" name="data[Attraction][add_ons][0][gross]"/>'+
											'</div>'+									
										'</td>'+
									'</tr>'
								);
								attractions.numberformat();							
							break;
						}
					}
				}
			}, next: function(index) {
				$("#toTopHover").click();
				if(index ==3){ //moving out of step 2
					$("#attractionBlocksTbody tr").each(function(){
						var emptyBlock = $(this).find('.attractionBlockQuantity').val();
						
						if(emptyBlock == ''){
							$(this).remove();
						}
					});
					$("#attractionAddOnTbody tr").each(function(){
						var emptyAddOn = $(this).find('#attractionAddOnTitle').val();
						if(emptyAddOn == ''){
							$(this).remove();
						}
					});
				}
				if(index ==4){ //move out of step 3
							//reindex the whole table name attributes
							$("#step3part2 table[status='active']").each(function(idx){
								var name = 'data[Attraction_ticket]['+idx+']';
								$(this).find('tbody').each(function(idx2){
									//set the name attribute variables
									var start = $(this).find('.blockBeginDate').val();
									var end = $(this).find('.blockEndDate').val();
									var timestamp = new Date(start).getTime() / 1000;
									var start_date = name+'[Inventory]['+idx2+'][start_date]';
									var end_date = name+'[Inventory]['+idx2+'][end_date]';
									var time_attr = name+'[Inventory]['+idx2+'][time_inventory]';
									var time = $(this).find('.ticketTimeFinal').val();
									//set the names
									$(this).find('.blockBeginDate').attr('name',start_date);
									$(this).find('.blockEndDate').attr('name',end_date);
				
									$(this).find('.ticketTimeFinal').attr('name',name+'[Inventory]['+idx2+'][time]');
									
									
									//parse the table rows to create the time array
									$(this).find('tr').each(function(idx3){
										var age_range = time_attr+'['+idx3+'][age_range]';
										var inventory = time_attr+'['+idx3+'][inventory]';
										var markup = time_attr+'['+idx3+'][markup]';
										var net = time_attr+'['+idx3+'][net]';
										var gross = time_attr+'['+idx3+'][gross]';

	
										$(this).find('.ticketAgeRange').attr('name',age_range);
										$(this).find('.inventoryInventory').attr('name',inventory);
										$(this).find('.inventoryMarkupRate').attr('name',markup);
										$(this).find('.inventoryNetRate').attr('name',net);
										$(this).find('.inventoryGrossRate').attr('name',gross);
									});
								});
							});				
					
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
			$("#step3part2").show();
			$("#accordionGroup2").click();	
		}
	}, 
	create: function(num, createClass, createTicketMarketingClass){
		var row = 0;
		for (var i=0; i < num; i++) {
			var country = $(".countrySelect option:selected").val();
			
			switch(country){
				case '1':
					var get_addOns = addOnsUs(i);
					var newRow = newTicketUs(i, get_addOns);			
					var ticketMarketing = newTicketMarketing(i);	
			
				break;
				
				case '2':
					var get_addOns = addOnsCan(i);
					var newRow = newTicketCan(i, get_addOns);			
					var ticketMarketing = newTicketMarketing(i);			
				break;
			}
			$(createClass).append(newRow);
			$("#formTicketMarketing p").hide();
			$(createTicketMarketingClass).append(ticketMarketing);

			attraction_tickets.addScripts(i, row);	
		};
	}, 
	addTicket: function(idx,row){
		var location = $(".countrySelect option:selected").val(); //location is used to determine what type of hotel room form we are using
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
		
		//append the newly created hotel room rows based on the variables set above
		$("#accordionTicketType").append(newRow);
		//hide the room marketing paragraph
		$("#formTicketMarketing p").hide();
		
		//add the room marketing scripts on the next step
		$("#accordion4").append(ticketMarketing);
		
		//add all of the necessary scripts needed to make hotel rooms work
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
		$("#AttractionTicket"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#AttractionTicket"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#AttractionTicket"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$("#AttractionTicket"+idx+"Inventory"+row+"StartDate").datepicker('hide');
		});
		$(".blockBeginDate").datepicker().on('changeDate', function(ev){
  			$('.blockBeginDate').datepicker('hide');

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
		$(".blockBeginDate").blur(function(){
			var date = $(this).val();
			var timestamp = new Date(date).getTime() / 1000;
			var type = $(this).parent().parent().parent().parent().parent().attr('type');
			
			switch(type){
				case 'noTimeTable':
					$(this).attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][start_date]');
					$(this).parent().parent().parent().find('.blockEndDate').attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][end_date]');					
				break;
				
				case 'timeTable':
					var time = $(this).parent().parent().parent().parent().find('.ticketTime').val();
					//send timestamp to the create row button
					$("#timeSubmit-"+idx).attr('timestamp',timestamp);
					
					$(this).attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][start_date]');
					$(this).parent().parent().parent().find('.blockEndDate').attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][end_date]');
					$(this).parent().parent().parent().find(".ticketTimeFinal").attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][time]');
					
	
				break;
			}
		});
		$(".ticketAgeRange").blur(function(){
			var age_range = $(this).val();
			var date = $(this).parent().parent().parent().find('.blockBeginDate').val();
			var timestamp = new Date(date).getTime() / 1000;
			var time = $(this).parent().parent().parent().find('.ticketTime').val();

			if(age_range !=''){
				$(this).parent().parent().attr('class','control-group');
				$(this).parent().parent().find('.help-block').html('');
			}
			
			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().attr('row');
			if(topDawg == '0'){
				var num = $(this).parent().parent().parent().attr('num');

				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .ticketAgeRange").val(age_range);
			}	
		});
		$(".inventoryInventory").blur(function(){
			var inventory = $(this).val();

			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().attr('row');
			if(topDawg == '0'){
				var num = $(this).parent().parent().parent().attr('num');

				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryInventory").val(inventory);
			}	
		});		
		$(".inventoryNetRate").blur(function(){
			var net = $(this).val();
			var gross = $(this).parent().parent().parent().find('.inventoryGrossRate').val();

			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().attr('row');
			if(topDawg == '0'){
				var num = $(this).parent().parent().parent().attr('num');

				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryNetRate").val(net);
				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryGrossRate").val(gross);
			}	
		});
		// $(".inventoryMarkupRate").blur(function(){
			// var markup = $(this).val();
			// var gross = $(this).parent().parent().parent().find('.inventoryGrossRate').val();
			// //copy all of the values to every other value below
			// var topDawg = $(this).parent().parent().parent().attr('row');
			// if(topDawg == '0'){
				// var num = $(this).parent().parent().parent().attr('num');
				// $(".attractionTable-"+idx+"[status='active'] tbody:not(:first-child) tr[num='"+num+"'] .inventoryMarkupRate").val(markup);
				// $(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryGrossRate").val(gross);
			// }	
		// });	
		$(".inventoryGrossRate").blur(function(){
			var gross = $(this).val();

			//copy all of the values to every other value below
			var topDawg = $(this).parent().parent().parent().attr('row');
			if(topDawg == '0'){
				var num = $(this).parent().parent().parent().attr('num');
				$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryGrossRate").val(gross);
			}	
		});
		$(".blockEndDate").datepicker().on('changeDate', function(ev){
  			$('.blockEndDate').datepicker('hide');
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
		$("#AttractionTicket"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$("#AttractionTicket"+idx+"Inventory"+row+"EndDate").datepicker('hide');
		});
		$("#fullYear-"+idx).datepicker().change(function() {
			var date = $(this).val();
			$('.datepicker td .day').css({'background-color':'red'});
			attraction_tickets.editSelect(date,idx,row, '#blackoutDatesUl-'+idx,'#blackoutDateCounter-'+idx);
			//$("#fullYear-"+idx).datepicker('hide');
		});
		
		//accordion ticket click to top page
		$("#collapseTwo2 .accordion-toggle").click(function(){
			$("#toTop").click();
			//focus on the name
			$(this).parent().parent().find('.attractionTicketName').focus();
		});
		//remove ticket
		$("#removeTicketButton-"+idx).click(function(){
			if(confirm('Are you sure you want to delete ticket?')){
				
				//remove from step 3
				$(this).parent().parent().parent().parent().parent().parent().parent().remove();		
				//remove marketing from step 4
				$("#marketingTicket-"+idx).remove();
					
			}
			
				
		});		
		//new ticket 
		$("#addTicketInventory-"+idx).click(function(){
			//first check to see what type of table this is
			var type = $(".attractionTable-"+idx+"[status='active']").attr('type');
			
			switch(type){
				case 'noTimeTable':

					var startDate = $("#noTimeTable-"+idx+" tbody[special='primary'] .blockBeginDate").val();
					var endDate = $("#noTimeTable-"+idx+" tbody[special='primary'] .blockEndDate").val();	
	
					if(startDate ==''){

						$("#noTimeTable-"+idx+" tbody[special='primary'] .blockBeginDate").parent().parent().attr('class','control-group error');
						$("#noTimeTable-"+idx+" tbody[special='primary'] .blockBeginDate").parent().parent().find('.help-block').html('This value cannot be left empty');
					} else {
						$("#noTimeTable-"+idx+" tbody[special='primary'] .blockBeginDate").parent().parent().attr('class','control-group');
						$("#noTimeTable-"+idx+" tbody[special='primary'] .blockBeginDate").parent().parent().find('.help-block').html('');						
					}
					if(endDate == ''){
						$("#noTimeTable-"+idx+" tbody[special='primary'] .blockEndDate").parent().parent().attr('class','control-group error');
						$("#noTimeTable-"+idx+" tbody[special='primary'] .blockEndDate").parent().parent().find('.help-block').html('This value cannot be left empty');						
					} else {
						$("#noTimeTable-"+idx+" tbody[special='primary'] .blockEndDate").parent().parent().attr('class','control-group');
						$("#noTimeTable-"+idx+" tbody[special='primary'] .blockEndDate").parent().parent().find('.help-block').html('');							
					}
					
					if(startDate != '' && endDate != ''){
						//clone the current primary section
						var timeTbody = $("#noTimeTable-"+idx+" tbody[special='primary']").clone();
						$("#attractionTicketManipulate").html(timeTbody);
					
						//manipulate the tables first get the variables needed then change the values accordingly
						var countTbody = $("#attractionTicketManipulate tbody").length;
						var lastRow = $("#noTimeTable-"+idx+" tbody:last-child").attr('row');
						var lastRow = parseInt(lastRow)+1;
						//get the next date on list
						//enter in the newly created dates
						var end = $("#noTimeTable-"+idx+" tbody:last-child .blockEndDate").val();
						var thisDate = new Date(end);
						var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
						var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
						var timestamp = new Date(newDateString).getTime() / 1000;
						//place new dates into fields
						$("#attractionTicketManipulate .blockBeginDate").val(newDateString);
						$("#attractionTicketManipulate .blockEndDate").val(newDateString);
						$("#noTimeTable-"+idx+" .blockEndDate").attr('last','notlast');
						$("#attractionTicketManipulate .blockEndDate").attr('last','last');
	
						//change the special attribute to notprimary
						$("#attractionTicketManipulate tbody").attr('special','notprimary');	
						
					
						//reindex the remove buttons before cloning it back to table
						$("#attractionTicketManipulate tbody .removeAgeButton").each(function(index){
							var lastRemoveRow = $("#noTimeTable-"+idx+" .removeAgeButton").length;
							var lastRemoveRow = lastRemoveRow + index;
							$(this).attr('id','removeAgeButton-'+idx+'-'+lastRemoveRow);
						});		
						
						//add one to the add button index
						var addButtonCount = $("#noTimeTable-"+idx+" .addAgeButton").length;
						$("#attractionTicketManipulate tbody .addAgeButton").attr('id','addAgeButton-'+addButtonCount);	
						
								
						
						//reindex the ids, names
						$("#attractionTicketManipulate tr").each(function(index){
							var rowCount = $("#noTimeTable-"+idx+" tbody tr").length;
							var rowCount = rowCount+index;
							var beginDate = $(this).parent().parent().parent().find('.blockBeginDate').val();
							var timestamp = new Date(beginDate).getTime() / 1000;
							var age_range = $(this).find('.ticketAgeRange').val();
							var inventory = $(this).find('.inventoryInventory').val();
							var net = $(this).find('.inventoryNetRate').val();
							var markup = $(this).find('.inventoryMarkupRate').val();
							var gross = $(this).find('.inventoryGrossRate').val();
							//mark each row with a timestamp
							$(this).parent().attr('timestamp',timestamp);
							//change the id
							$(this).find('.blockBeginDate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'StartDate');
							$(this).find('.blockEndDate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'EndDate');
							$(this).find('.ticketAgeRange').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'AgeRange');
							$(this).find('.inventoryInventory').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Inventory');
							$(this).find('.inventoryNetRate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Net');
							$(this).find('.inventoryMarkupRate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Markup');
							$(this).find('.inventoryGrossRate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Gross');
							$(this).find('.switchNetRate').attr('id','switchNetRate-'+idx+'-'+rowCount);
							//change the name
					
							
						});
						
						//add in a remove button to the tr class named .newAgeRow insert it in the last td and have it remove the whole tbody if need be
						$("#attractionTicketManipulate .newAgeRow").find('td:last-child').append(
							'<button id="deleteNewTimeTbodyButton-'+timestamp+'" type="button" class="deleteNewTimeTbodyButton btn btn-danger btn-small"><i class="icon-trash icon-white"></i></button>'
						);									
						//alter the row attribute values to the new counted created values
						var countTbody = $("#attractionTicketManipulate tbody").length;
						
						$("#attractionTicketManipulate tbody").each(function(index){
							var row = lastRow+(index);
							$(this).attr('row',row);
							$(this).find('tr[row="newAge"]').attr('num',row);
							$(this).find('.addAgeButtonTime').attr('id','addAgeButtonTime-'+idx+'-'+row);
							
							
							
	
							//clone the tbody back into the time table
							var newTimeTbody = $(this).clone();
							$("#noTimeTable-"+idx).append(newTimeTbody);
							//add the remove scripts into the time table
							$(this).find('.removeAgeButton').each(function(){
								var removeRow = $(this).attr('id').replace('removeAgeButton-'+idx+'-','');
	
								$("#removeAgeButton-"+idx+"-"+removeRow).click(function(){
								if(confirm('Are you sure you want to delete this ticket age range row?')){
									$(this).parent().parent().remove();	

								}	
								});						
							});
							//add the add age range scripts back into the time table
							attraction_tickets.addTimeScripts(idx,row);
							
						});

	
						//delete the newly cloned rows
						$("#noTimeTable-"+idx+" #deleteNewTimeTbodyButton-"+timestamp).click(function(){
							if(confirm('Are you sure you want to delete ticket dates?')){
								$(this).parent().parent().parent().remove();	
								
								// //reindex the action buttons
								// $("#timeTable-"+idx+" .addAgeButtonTime").each(function(index){
									// $(this).attr('id','addAgeButtonTime-'+idx+'-'+index);
								// });
								//add last to the last row
								var countEndDate = $('#noTimeTable-'+idx+' .blockEndDate').length;
								if(countEndDate ==1){
									$("#noTimeTable-"+idx+" .newAgeRow .blockEndDate").attr('last','last');	
								} else {
									$("#noTimeTable-"+idx+" tbody:last-child .newAgeRow .blockEndDate").attr('last','last');	
								}
														
							}
						});
						//add inventory
						$("#noTimeTable-"+idx+" #addAgeButton-"+addButtonCount).click(function(){
							var row = $("#noTimeTable-"+idx+" tbody tr").length;
							var age_range = $(this).parent().parent().find('.ticketAgeRange').val();
							var inventory = $(this).parent().parent().find('.inventoryInventory').val();
							var net = parseFloat($(this).parent().parent().find('.inventoryNetRate').val());
							var markup = parseFloat($(this).parent().parent().find('.inventoryMarkupRate').val());
							var gross = parseFloat($(this).parent().parent().find('.inventoryGrossRate').val());
							var start = $(this).parent().parent().find('.blockBeginDate').val();
							var end = $(this).parent().parent().find('.blockEndDate').val();
							//get last date
							var thisDate = new Date(end);
							var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
							var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
							var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
							var endCheck = parseInt(end.replace(regExp, "$3$1$2"));

							var timestamp = new Date(start).getTime() / 1000;
						
							//var total = parseInt(total);
							var intRegex = /^\d+$/;
							//validate block form make sure all the data is right
							var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
							if(start == ''){
								//add errors
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().attr('class','control-group error');
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().find('.help-block').html('You must choose an start date');			
							} else {
								//remove errors
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().attr('class','control-group');
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().find('.help-block').html('');				
							}
							if(end == ''){
								//add errors
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group error');		
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('You must choose an end date');	
							} else {
								//remove errors
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group');
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
							}
							if(start != '' && end != ''){
								if(startCheck > endCheck){
									$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group error');
									$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
								} else {
									//remove errors
									$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group');
									$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
								}
							} 
							if(age_range ==''){
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().attr('class','control-group error');		
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().find('.help-block').html('This value cannot be empty');				
							} else{
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().attr('class','control-group');		
								$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().find('.help-block').html('');				
							}
						
					
							//sucess now send
							if(start != '' && end != '' && startCheck <= endCheck) {
								var country = $(".countrySelect option:selected").val();
								switch(country){
									case '1':
										var addAgeRow = newTicketBlockUs(idx,row,timestamp, inventory,net, gross, markup);
									break;
									
									case '2':
										var addAgeRow = newTicketBlockCan(idx,row,timestamp, inventory,net, gross, markup);
									break;
								}

								
								$(this).parent().parent().parent().append(addAgeRow);
								attraction_tickets.addInventoryScripts(idx, row);
								
								//remove button
								var removeAgeCount = $('#noTimeTable-'+idx+' .removeAgeButton').length;
								var removeAgeCount = removeAgeCount -1;

								$("#removeAgeButton-"+idx+'-'+removeAgeCount).click(function(){
						
									if(confirm('Are you sure you want to delete row?')){
										$(this).parent().parent().remove();
									}
								});
							}						
						});
						$("#noTimeTable-"+idx+" tbody tr").each(function(index){
							attraction_tickets.addTimeScriptsCan(idx,index);
						});
						$("#attractionTicketManipulate").html('');
						//$("#attractionTicketManipulate").html('');
						//alert(countTbody);					
				
					}
				break;
				//the table is a time table
				case 'timeTable':
					var startDate = $("#timeTable-"+idx+" tbody[special='primary'] .blockBeginDate").val();
					var endDate = $("#timeTable-"+idx+" tbody[special='primary'] .blockEndDate").val();	
					if(startDate ==''){
						$("#timeTable-"+idx+" tbody[special='primary'] .blockBeginDate").parent().parent().attr('class','control-group error');
						$("#timeTable-"+idx+" tbody[special='primary'] .blockBeginDate").parent().parent().find('.help-block').html('This value cannot be left empty');
					} else {
						$("#timeTable-"+idx+" tbody[special='primary'] .blockBeginDate").parent().parent().attr('class','control-group');
						$("#timeTable-"+idx+" tbody[special='primary'] .blockBeginDate").parent().parent().find('.help-block').html('');						
					}
					if(endDate == ''){
						$("#timeTable-"+idx+" tbody[special='primary'] .blockEndDate").parent().parent().attr('class','control-group error');
						$("#timeTable-"+idx+" tbody[special='primary'] .blockEndDate").parent().parent().find('.help-block').html('This value cannot be left empty');						
					} else {
						$("#timeTable-"+idx+" tbody[special='primary'] .blockEndDate").parent().parent().attr('class','control-group');
						$("#timeTable-"+idx+" tbody[special='primary'] .blockEndDate").parent().parent().find('.help-block').html('');							
					}
					
					if(startDate != '' && endDate != ''){
						//clone the current primary section
						var timeTbody = $("#timeTable-"+idx+" tbody[special='primary']").clone();
	
						$("#attractionTicketManipulate").html(timeTbody);
						
						//manipulate the tables first get the variables needed then change the values accordingly
						var countTbody = $("#attractionTicketManipulate tbody").length;
						var lastRow = $("#timeTable-"+idx+" tbody:last-child").attr('row');
						var lastRow = parseInt(lastRow)+1;
						//get the next date on list
						//enter in the newly created dates
						var end = $("#timeTable-"+idx+" .blockEndDate[last='last']").val();
						var thisDate = new Date(end);
						var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
						var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
						//place new dates into fields
						$("#attractionTicketManipulate .blockBeginDate").val(newDateString);
						$("#attractionTicketManipulate .blockEndDate").val(newDateString);
						$("#timeTable-"+idx+" .blockEndDate").attr('last','notlast');
						$("#attractionTicketManipulate .blockEndDate").attr('last','last');
	
						//change the special attribute to notprimary
						$("#attractionTicketManipulate tbody").attr('special','notprimary');	
						
					
						//reindex the remove buttons before cloning it back to table
						$("#attractionTicketManipulate tbody .removeAgeRow").each(function(index){
							var lastRemoveRow = $("#timeTable-"+idx+" tbody .removeAgeRow").length;
							var lastRemoveRow = lastRemoveRow + index;
							$(this).attr('id','removeAgeRow-'+idx+'-'+lastRemoveRow);
						});					
						
						//reindex the ids, names
						$("#attractionTicketManipulate tr").each(function(index){
							var rowCount = $("#timeTable-"+idx+" tbody tr").length;
							var rowCount = rowCount+index;
							var beginDate = $(this).parent().parent().find('.blockBeginDate').val();
							var timestamp = new Date(beginDate).getTime() / 1000;
							var age_range = $(this).find('.ticketAgeRange').val();
							var inventory = $(this).find('.inventoryInventory').val();
							var net = $(this).find('.inventoryNetRate').val();
							var markup = $(this).find('.inventoryMarkupRate').val();
							var gross = $(this).find('.inventoryGrossRate').val();
							//mark each row with a timestamp
							$(this).parent().attr('timestamp',timestamp);
							//number the row
							$(this).attr('num',index);
							//change the id
							$(this).find('.blockBeginDate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'StartDate');
							$(this).find('.blockEndDate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'EndDate');
							$(this).find('.ticketTimeFinal').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Time');
							$(this).find('.ticketAgeRange').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'AgeRange');
							$(this).find('.inventoryInventory').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Inventory');
							$(this).find('.inventoryNetRate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Net');
							$(this).find('.inventoryMarkupRate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Markup');
							$(this).find('.inventoryGrossRate').attr('id','AttractionTicket'+idx+'Inventory'+rowCount+'Gross');
							$(this).find('.switchNetRate').attr('id','switchNetRate-'+idx+'-'+rowCount);
							//change the name
					
							
						});
						
	
						var timestamp = $("#attractionTicketManipulate tbody:first-child .newAgeRow").parent().attr('timestamp');	

						//add in a remove button to the tr class named .newAgeRow insert it in the last td and have it remove the whole tbody if need be
						$("#attractionTicketManipulate tbody:first-child .newAgeRow").find('td:last-child').append(
							'<button id="deleteNewTimeTbodyButton-'+timestamp+'" type="button" class="deleteNewTimeTbodyButton btn btn-danger btn-small"><i class="icon-trash icon-white"></i></button>'
						);									
						//alter the row attribute values to the new counted created values
						var countTbody = $("#attractionTicketManipulate tbody").length;
						
						$("#attractionTicketManipulate tbody").each(function(index){
							var row = lastRow+(index);
							$(this).attr('row',row);
							$(this).find('tr[row="newAge"]').attr('num',row);
							$(this).find('.addAgeButtonTime').attr('id','addAgeButtonTime-'+idx+'-'+row);

							$(this).find('tr').each(function(index2){

								$(this).attr('num',index2); 
							});
							//clone the tbody back into the time table
							var newTimeTbody = $(this).clone();
							$("#timeTable-"+idx).append(newTimeTbody);
							
							//add the remove scripts into the time table
							$(this).find('.removeAgeRow').each(function(){
								var removeRow = $(this).attr('id').replace('removeAgeRow-'+idx+'-','');
	
								$("#removeAgeRow-"+idx+"-"+removeRow).click(function(){
								if(confirm('Are you sure you want to delete this ticket age range row?')){
									$(this).parent().parent().remove();	

								}	
								});						
							});
							//add the add age range scripts back into the time table
							attraction_tickets.addTimeScripts(idx,row);
							
							
							
						});
						$("#timeTable-"+idx+" tbody tr").each(function(index){
							

							attraction_tickets.addTimeScriptsCan(idx,index);
						});
	
						//delete the newly cloned rows
						$("#timeTable-"+idx+" #deleteNewTimeTbodyButton-"+timestamp).click(function(){
							if(confirm('Are you sure you want to delete ticket dates?')){
								$("#timeTable-"+idx+" tbody[timestamp='"+timestamp+"']").remove();
								// //reindex the action buttons
								// $("#timeTable-"+idx+" .addAgeButtonTime").each(function(index){
									// $(this).attr('id','addAgeButtonTime-'+idx+'-'+index);
								// });
								//add last to the last row
								var countEndDate = $('#timeTable-'+idx+' .blockEndDate').length;
								if(countEndDate ==1){
									$("#timeTable-"+idx+" .newAgeRow .blockEndDate").attr('last','last');	
								} else {
									$("#timeTable-"+idx+" tbody:last-child .newAgeRow .blockEndDate").attr('last','last');	
								}
														
							}
						});
						$("#attractionTicketManipulate").html('');
						//$("#attractionTicketManipulate").html('');
						//alert(countTbody);						
					}
				
				
				break;
			}

			
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
		$("#AttractionTicket"+idx+"Name").blur(function(){
			var value = $(this).val();
			var row = $(this).attr('dataRow');
			if(value != ''){
				$('#ticketTypeSpan-'+idx).html(value);
				$("#formTicketMarketing #attractionTicketName-"+idx).html(value);	
			}		
		});	

		//tax rate creation
		$(".taxSelection[num='"+idx+"']").change(function(){

			//hide the em statement
			$(this).parent().parent().parent().find('.taxesCollectedDiv em').hide();
			
			//grab the selected option and get its values
			var tax_id = $(this).find('option:selected').val();
			var tax_name = $(this).find('option:selected').attr('taxName');
			var tax_rate = $(this).find('option:selected').attr('taxRate');
			var tax_country = $(this).find('option:selected').attr('taxCountry');
			var row = $(".taxcheck[idx='"+idx+"']").length;
			var create_tax = createTax(tax_id,tax_name,tax_rate,tax_country,idx,row);
			var total_tax = $("#taxrate-"+idx).val();

			var new_rate = parseFloat(tax_rate)+parseFloat(total_tax);
			var new_rate = new_rate.toFixed(2);
			//alert(tax_rate+' '+total_tax+' '+new_rate);
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
					$("#taxrate-"+idx).val(new_rate);
				}
			
			
				$("#removeTax-"+idx+"-"+tax_id).click(function(){
					var value = $(this).parent().find('.taxesInput').val();
					var total_tax = $("#taxrate-"+idx).val();
					var newValue = parseFloat(total_tax)-parseFloat(value);
					var newValue = newValue.toFixed(2);				
					$("#taxrate-"+idx).val(newValue);
					$(this).parent().remove();
				});
			
			}			

		});	

		//markup keyup function
		//net->gross
		$(".inventoryNetRate").keyup(function(){

			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Gross").val(gross);	
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
		$(".inventoryMarkupRate").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Gross").val(gross);	
					}
				break;
				
				case '2': //can
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					var markup = $(this).val();
					var exchange = $(".exchange").val()
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$(this).parent().parent().parent().find('.inventoryGrossRate').val(gross);	
					}				
				break;
				
			}

			
		});
		//gross -> markup
		$(".inventoryGrossRate").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Markup").val(markup);	
					}
				break;
				
				case '2': //can
					var net = $(this).parent().parent().parent().find('.inventoryNetRate').val();
					var exchange = $(".exchange").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$(this).parent().parent().parent().find('.inventoryMarkupRate').val(markup);	
					}				
				
				break;
				
			}
		});			
		//add age range 
		$("#addAgeButton-"+idx).click(function(){
	
			var num = 0;
			var startDate = $(this).parent().parent().find('.blockBeginDate').val();
			var endDate = $(this).parent().parent().find('.blockEndDate').val();
			var country =$('.countrySelect option:selected').val();
			var formType = $(this).parent().parent().parent().parent().attr('type');
			var timestamp = new Date(startDate).getTime() / 1000;
			
			switch(formType){
				case 'noTimeTable':
					switch(country){
						case '1':
							var row = $("#noTimeTable-"+idx+" tbody tr").length;
							var age_range = $(this).parent().parent().find('.ticketAgeRange').val();
							var inventory = $(this).parent().parent().find('.inventoryInventory').val();
							var netRate = parseFloat($(this).parent().parent().find('.inventoryNetRate').val()).toFixed(2);
							var markupRate = parseFloat($(this).parent().parent().find('.inventoryMarkupRate').val()).toFixed(2);
							var grossRate = parseFloat($(this).parent().parent().find('.inventoryGrossRate').val()).toFixed(2);
							attraction_tickets.addInventoryUs(idx,row,startDate, endDate,age_range,inventory,netRate,markupRate,grossRate);
							
							var removeRow = $(".removeAgeButton").length;
							var removeRow = removeRow-1;
							//remove button
							$("#removeAgeButton-"+idx+'-'+removeRow).click(function(){
					
								if(confirm('Are you sure you want to delete row?')){
									$(this).parent().parent().remove();
								}
							});
						break;
						
						case '2':
						
							var row = $("#noTimeTable-"+idx+" tbody tr").length;
							var age_range = $(this).parent().parent().find('.ticketAgeRange').val();
							var inventory = $(this).parent().parent().find('.inventoryInventory').val();
							var netRate = parseFloat($(this).parent().parent().find('.inventoryNetRate').val()).toFixed(2);
							var markupRate = parseFloat($(this).parent().parent().find('.inventoryMarkupRate').val()).toFixed(2);
							var grossRate = parseFloat($(this).parent().parent().find('.inventoryGrossRate').val()).toFixed(2);
							attraction_tickets.addInventoryCan(idx,row,startDate, endDate,age_range,inventory,netRate,markupRate,grossRate);
							var removeRow = $(".removeAgeButton").length;
							var removeRow = removeRow-1;
							//remove button
							$("#removeAgeButton-"+idx+'-'+removeRow).click(function(){
					
								if(confirm('Are you sure you want to delete row?')){
									$(this).parent().parent().remove();
								}
							});						
						break;
					}

				break;
				
				default:
					switch(country){
						case '1':
							
							var addAgeRow = newAgeRangeBlockUs(idx, num, startDate, endDate);
							$(this).parent().parent().parent().append(addAgeRow);
					
						break;
						
						case '2':
							var addAgeRow = newAgeRangeBlockCan(idx, num, startDate, endDate);
							$(this).parent().parent().parent().append(addAgeRow);		
						break;
						
					}
					$("#removeAgeRow-"+idx+"-"+row).click(function(){
						alert('remove');
					});				
				break;
			}

			
		});

		
		//Time Table Setup
		$("#multiday-"+idx).click(function(){
			var status = $(this).attr('checked');
			//check the status of checkd if its not checked then do this
			if(status =='checked'){
				$(this).attr('value','Yes');
				//show the time table & hide the no time table
				$("#multidayDiv-"+idx).fadeIn();
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
				$("#multidayDiv-"+idx).fadeOut();
				$("#timeTableDiv-"+idx).hide();
				$("#noTimeTableDiv-"+idx).fadeIn();
				//change the status of each table
				$("#noTimeTable-"+idx).attr('status','active');
				$("#timeTable-"+idx).attr('status','notactive');
				$("#timeTable-"+idx+" input").attr('disabled','disabled');
				$("#noTimeTable-"+idx+" input").removeAttr('disabled','disabled');
				
			}
		});
		$("#timeSubmit-"+idx).click(function(){
			var time = $("#timeInput-"+idx).val();
			var timestamp = $(this).attr('timestamp');
			var exchange = $('.exchange').val();
			if(time ==''){
				$(this).parent().parent().parent().attr('class','control-group error');
				$(this).parent().parent().parent().find('.help-block').html('Time cannot be empty');
			} else {
				$(this).parent().parent().parent().attr('class','control-group');
				$(this).parent().parent().parent().find('.help-block').html('');
				
				
				var newTime = '<li class="alert alert-info pull-left span2" time="'+time+'" style="margin-right:5px;"><button type="button" row="'+time+'" class="closeTimeButton close">&times;</button>'+time+'</li>'
				var timeLength = $("#timeResults-"+idx+" li").length;
				switch(timeLength){
					case 0:
						var countTableRows = $("#timeTable-"+idx+" tbody tr").length;
						if(countTableRows == 0){
							var country = $('.countrySelect option:selected').val();
							switch(country){
								case '1':
									var newTbody = 
										'<tbody id="ticketInventoryTbody-0" class="ticketInventoryTbody" special="primary">'+
											'<tr class="newAgeRow" row="top">'+	
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][Inventory][0][start_date]" style="width:100px;" disabled="disabled">'+
														'<span class="add-on"><i class="icon-calendar"></i></span>'+
													'</div>'+
													'<span class="help-block"></span>'+														
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][Inventory][0][end_date]" style="width:100px;" disabled="disabled">'+
														'<span class="add-on"><i class="icon-calendar"></i></span>'+
													'</div>'+
													'<span class="help-block"></span>'+														
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0Time" class="ticketTime" type="text" placeholder=""  style="width:100px;" disabled="disabled">'+
													'</div>'+
													'<span class="help-block"></span>'+	
													'<input id="AttractionTicket0Inventory0Time" class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket][0][Inventory][0][time]" style="width:100px;">'+													
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-prepend">'+
														'<input id="AttractionTicket0Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][Inventory][0][age_range]" placeholder="i.e. Adults (16+)" disabled="disabled">'+
													'</div>'+
													'<span class="help-block"></span>'+																											
												'</td>'+							
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket][0][Inventory][0][inventory]" style="width:75px;" disabled="disabled">'+	
													'</div>'+
													'<span class="help-block"></span>'+											
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-prepend">'+
														'<span class="add-on">US$</span>'+
														'<input id="AttractionTicket0Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][Inventory][0][net]" style="width:75px;" disabled="disabled">'+	
													'</div>'+
													'<span class="help-block"></span>'+		
													//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][Inventory][0][markup]" style="width:75px;" disabled="disabled">'+	
														'<span class="add-on">%</span>'+
													'</div>'+
													'<span class="help-block"></span>'+																									
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-prepend">'+
														'<span class="add-on">US$</span>'+
														'<input id="AttractionTicket0Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][Inventory][0][gross]" style="width:75px;" disabled="disabled">'+
													'</div>'+
													'<span class="help-block"></span>'+													
												'</td>'+
												'<td>'+
												
													'<button id="addAgeButtonTime-0-0" class="addAgeButtonTime btn btn-small" type="button"><i class="icon-plus"></i></button>'+
													
												'</td>'+
											'</tr>'+
										'</tbody>';
								break;
								
								case '2':
									var newTbody = 
										'<tbody id="ticketInventoryTbody-0" class="ticketInventoryTbody" special="primary">'+
											'<tr class="newAgeRow" row="top">'+	
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][Inventory][0][start_date]" style="width:100px;" disabled="disabled">'+
														'<span class="add-on"><i class="icon-calendar"></i></span>'+
													'</div>'+
													'<span class="help-block"></span>'+														
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][Inventory][0][end_date]" style="width:100px;" disabled="disabled">'+
														'<span class="add-on"><i class="icon-calendar"></i></span>'+
													'</div>'+
													'<span class="help-block"></span>'+														
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0Time" class="ticketTime" type="text" placeholder=""  style="width:75px;" disabled="disabled">'+
													'</div>'+
													'<span class="help-block"></span>'+	
													'<input id="AttractionTicket0Inventory0Time" class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket][0][Inventory][0][time]">'+													
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-prepend">'+
														'<input id="AttractionTicket0Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][Inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;" disabled="disabled">'+
													'</div>'+
													'<span class="help-block"></span>'+																											
												'</td>'+							
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket][0][Inventory][0][inventory]" style="width:50px;" disabled="disabled">'+	
													'</div>'+
													'<span class="help-block"></span>'+											
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-prepend input-append">'+
														'<span id="dollarSignSpan" class="add-on">CN$</span>'+
														'<input id="AttractionTicket0Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][Inventory][0][net]" value="0" style="width:75px;" disabled="disabled">'+	
														'<span id="switchNetRate-0-0" status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
													'</div>'+
													'<span class="help-block"></span>'+		
													//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket][0][Inventory][0][exchange]" style="width:50px;" disabled="disabled" value="'+exchange+'" >'+	
														'<span class="add-on">CAN/USD</span>'+												
													'</div>'+
													'<span class="help-block"></span>'+		
													//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-append">'+
														'<input id="AttractionTicket0Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][Inventory][0][markup]"  style="width:75px;" disabled="disabled">'+	
														'<span class="add-on">%</span>'+
													'</div>'+
													'<span class="help-block"></span>'+																									
												'</td>'+
												'<td class="control-group">'+
													'<div class="input-prepend">'+
														'<span class="add-on">US$</span>'+
														'<input id="AttractionTicket0Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][Inventory][0][gross]" style="width:75px;" disabled="disabled">'+
													'</div>'+
													'<span class="help-block"></span>'+													
												'</td>'+
												'<td>'+
												
													'<button id="addAgeButtonTime-0-0" class="addAgeButtonTime btn btn-small" type="button"><i class="icon-plus"></i></button>'+
													
												'</td>'+
											'</tr>'+
										'</tbody>';						
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
							var topRow = $(".attractionTable-"+idx+"[status='active'] tbody[special='primary'][row='0']").clone();
							$("#attractionTicketManipulate").html(topRow);
							var timestamp = $("#attractionTicketManipulate tbody .blockBeginDate").val();
							var timestamp = new Date(timestamp).getTime() / 1000;	
												
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
								attraction_tickets.addTimeScripts(idx,newRow);

							});
							


							//clone the tbody back into the time table
							var newTimeTbody = $('#attractionTicketManipulate tbody').clone();
							$("#timeTable-"+idx+" tbody[special='primary']:last-child").after(newTimeTbody);

							$("#timeTable-"+idx+" tbody tr").each(function(index){	
								attraction_tickets.addTimeScriptsCan(idx,index);
							});	

							//add the remove scripts into the time table
							$("#timeTable-"+idx+" .removeAgeRow").each(function(){
								var removeRow = $(this).attr('id').replace('removeAgeRow-'+idx+'-','');
	
								$("#removeAgeRow-"+idx+"-"+removeRow).click(function(){
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
								$("#removeAgeRow-"+idx+"-"+newRow).click(function(){
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
		
		$("#addAgeButtonTime-"+idx+"-"+row).click(function(){
			var time = $(this).parent().parent().parent().attr('time');
			var startDate = $(this).parent().parent().find('.blockBeginDate').val();
			var timestamp = new Date(startDate).getTime() / 1000;
			var age_range = $(this).parent().parent().find('.ticketAgeRange').val();
			var endDate = $(this).parent().parent().find('.blockEndDate').val();
		
			var country =$('.countrySelect option:selected').val();
			switch(country){
				case '1':

					attraction_tickets.addTimeInventoryUs(idx, row, time, startDate, endDate, age_range);
				break;
				
				case '2':

					attraction_tickets.addTimeInventoryCan(idx, row, time, startDate, endDate, age_range);
				
				break;
				
			}
			$(this).parent().parent().parent().find('tr').each(function(index){
				$(this).attr('num',index);
			});
			
		});	
		//change status
		$(".switchNetRate").click(function(){

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
					var markup = $(this).parent().parent().parent().find('.inventoryMarkupRate').val();
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
		$("#AttractionTicket"+idx+"Status").change(function(){
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

			$("#ticketTypeLabel-"+idx).html(badge);
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
		$(".attractionTable-"+idx+"[status='active'] #AttractionTicket"+idx+"Inventory"+row+"Markup").blur(function(){
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

					var topDawg = $(this).parent().parent().parent().parent().attr('row');
					if(topDawg == '0'){
						var num = $(this).parent().parent().parent().attr('num');
						$(".attractionTable-"+idx+"[status='active'] tbody tr[num='"+num+"'] .inventoryMarkupRate").val(markup);
						$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryGrossRate").val(gross);
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
					var topDawg = $(this).parent().parent().parent().parent().attr('row');
					if(topDawg == '0'){
						var num = $(this).parent().parent().parent().attr('num');
						$(".attractionTable-"+idx+"[status='active'] tbody:not(:first-child) tr[num='"+num+"'] .inventoryMarkupRate").val(markup);
						$(".attractionTable-"+idx+"[status='active'] tr[num='"+num+"'] .inventoryGrossRate").val(gross);
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
	addTimeInventoryUs: function(idx, row, time, start, end, age_range){
		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
	
		//var total = parseInt(total);
		var intRegex = /^\d+$/;
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
		if(start == ''){
			//add errors
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'StartDate').parent().parent().attr('class','control-group error');
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'StartDate').parent().parent().find('.help-block').html('You must choose an start date');			
		} else {
			//remove errors
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'StartDate').parent().parent().attr('class','control-group');
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'StartDate').parent().parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().attr('class','control-group error');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().find('.help-block').html('You must choose an end date');	
		} else {
			//remove errors
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().attr('class','control-group');
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().attr('class','control-group error');
				$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
			} else {
				//remove errors
				$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().attr('class','control-group');
				$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().find('.help-block').html('');				
			}
			
		} 
		if(age_range == ''){
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().attr('class','control-group error');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().find('.help-block').html('You must enter an age range');			
		} else {
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().attr('class','control-group');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().find('.help-block').html('');				
		}

		//sucess now send
		if(start != '' && end != '' && age_range !='' && startCheck <= endCheck) {


			var netRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Net").val();
			var netRate = parseFloat(netRate).toFixed(2);
			var grossRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Gross").val();
			var grossRate = parseFloat(grossRate).toFixed(2);
			var markupRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Markup").val();
			var markupRate = parseFloat(markupRate).toFixed(2);
			var inventory = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Inventory").val();
			var timestamp = new Date(start).getTime() / 1000;
			var addAgeRow = newAgeRangeBlockUs(idx, row, time, timestamp, netRate, grossRate, markupRate, inventory)
			
//this is where its not saving
			$("#addAgeButtonTime-"+idx+"-"+row).parent().parent().parent().append(addAgeRow);
			
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
			$("#removeAgeRow-"+idx+"-"+newRow).click(function(){
				if(confirm('Are you sure you want to delete this ticket age range row?')){
					$(this).parent().parent().remove();	
				}
				
				
			});		
			
			attraction_tickets.addTimeScriptsCan(idx,ageRow);	

		}		
	},
	addTimeInventoryCan: function(idx, row, time, start, end, age_range){

		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
	
		//var total = parseInt(total);
		var intRegex = /^\d+$/;
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
		if(start == ''){
			//add errors
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'StartDate').parent().parent().attr('class','control-group error');
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'StartDate').parent().parent().find('.help-block').html('You must choose an start date');			
		} else {
			//remove errors
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'StartDate').parent().parent().attr('class','control-group');
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'StartDate').parent().parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().attr('class','control-group error');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().find('.help-block').html('You must choose an end date');	
		} else {
			//remove errors
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().attr('class','control-group');
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().attr('class','control-group error');
				$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
			} else {
				//remove errors
				$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().attr('class','control-group');
				$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'EndDate').parent().parent().find('.help-block').html('');				
			}
			
		} 
		if(age_range == ''){
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().attr('class','control-group error');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().find('.help-block').html('You must enter an age range');			
		} else {
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().attr('class','control-group');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().find('.help-block').html('');				
		}

		//sucess now send
		if(start != '' && end != '' && age_range !='' && startCheck <= endCheck) {


			var netRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Net").val();
			var netRate = parseFloat(netRate).toFixed(2);
			var grossRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Gross").val();
			var grossRate = parseFloat(grossRate).toFixed(2);
			var markupRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Markup").val();
			var markupRate = parseFloat(markupRate).toFixed(2);
			var inventory = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Inventory").val();
			var timestamp = new Date(start).getTime() / 1000;
			var addAgeRow = newAgeRangeBlockCan(idx, row, time, timestamp, netRate, grossRate, markupRate, inventory)
			
			$("#addAgeButtonTime-"+idx+"-"+row).parent().parent().parent().append(addAgeRow);
			
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
			$("#removeAgeRow-"+idx+"-"+newRow).click(function(){
				if(confirm('Are you sure you want to delete this ticket age range row?')){
					$(this).parent().parent().remove();	
				}
				
				
			});		
			
			attraction_tickets.addTimeScriptsCan(idx,ageRow);	

		}			
	},
	addAgeRangeInventoryUs: function(idx, row,time, timestamp, age_range){

	

		if(age_range == ''){
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().attr('class','control-group error');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().find('.help-block').html('You must enter an age range');			
		} else {
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().attr('class','control-group');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().find('.help-block').html('');				
		}

		//sucess now send
		if(age_range !='') {


			var netRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Net").val();
			if(netRate == ''){
				var netRate = '';
			} else {
				var netRate = parseFloat(netRate).toFixed(2);
			}

			var grossRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Gross").val();
			if(grossRate == ''){
				var grossRate = '';
			} else {
				var grossRate = parseFloat(grossRate).toFixed(2);
			}

			var markupRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Markup").val();
			if(markupRate == ''){
				var markupRate = '';
			} else {
				var markupRate = parseFloat(markupRate).toFixed(2);
			}
			var inventory = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Inventory").val();

			var addAgeRow = newAgeRangeBlockUs(idx, row, time, timestamp, netRate, grossRate, markupRate, inventory);
			
			$("#addAgeButtonTime-"+idx+"-"+row).parent().parent().parent().append(addAgeRow);
			
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
			$("#removeAgeRow-"+idx+"-"+newRow).click(function(){
				if(confirm('Are you sure you want to delete this ticket age range row?')){
					$(this).parent().parent().remove();	
				}
				
			});			
			
			attraction_tickets.addTimeScriptsCan(idx,ageRow);

		}		
	},
	addAgeRangeInventoryCan: function(idx, row,time, timestamp, age_range){

	

		if(age_range == ''){
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().attr('class','control-group error');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().find('.help-block').html('You must enter an age range');			
		} else {
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().attr('class','control-group');		
			$('#timeTable-'+idx+' #AttractionTicket'+idx+'Inventory'+row+'AgeRange').parent().parent().find('.help-block').html('');				
		}

		//sucess now send
		if(age_range !='') {


			var netRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Net").val();
			if(netRate == ''){
				var netRate = '';
			} else {
				var netRate = parseFloat(netRate).toFixed(2);
			}

			var grossRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Gross").val();
			if(grossRate == ''){
				var grossRate = '';
			} else {
				var grossRate = parseFloat(grossRate).toFixed(2);
			}

			var markupRate = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Markup").val();
			if(markupRate == ''){
				var markupRate = '';
			} else {
				var markupRate = parseFloat(markupRate);
			}
			var inventory = $("#timeTable-"+idx+" #AttractionTicket"+idx+"Inventory"+row+"Inventory").val();

			var addAgeRow = newAgeRangeBlockCan(idx, row, time, timestamp, netRate, grossRate, markupRate, inventory);
		
			$("#addAgeButtonTime-"+idx+"-"+row).parent().parent().parent().append(addAgeRow);
			
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
			$("#removeAgeRow-"+idx+"-"+newRow).click(function(){
				if(confirm('Are you sure you want to delete this ticket age range row?')){
					$(this).parent().parent().remove();	
				}
				
			});		
			
			attraction_tickets.addTimeScriptsCan(idx,ageRow);	

		}		
	},
	addInventoryUs:function(idx,row,start, end, age_range,inventory,net,markup,gross){		

		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
		var blockVal = parseInt(blockVal);
		var timestamp = new Date(start).getTime() / 1000;
	
		//var total = parseInt(total);
		var intRegex = /^\d+$/;
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
		if(start == ''){
			//add errors
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().attr('class','control-group error');
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().find('.help-block').html('You must choose an start date');			
		} else {
			//remove errors
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().attr('class','control-group');
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group error');		
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('You must choose an end date');	
		} else {
			//remove errors
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group');
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group error');
				$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
			} else {
				//remove errors
				$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group');
				$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
			}
		} 
		if(age_range ==''){
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().attr('class','control-group error');		
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().find('.help-block').html('This value cannot be empty');				
		} else{
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().attr('class','control-group');		
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().find('.help-block').html('');				
		}
	

		//sucess now send
		if(start != '' && end != '' && startCheck <= endCheck) {

			var addAgeRow = newTicketBlockUs(idx,row,timestamp, inventory,net, gross, markup);
			$("#ticketInventoryTbody-"+idx).append(addAgeRow);
			attraction_tickets.addInventoryScripts(idx, row);
		}
	}, 

	addInventoryCan:function(idx,row,start, end, age_range,inventory,net,markup,gross){		

		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
		var blockVal = parseInt(blockVal);
		var timestamp = new Date(start).getTime() / 1000;
	
		//var total = parseInt(total);
		var intRegex = /^\d+$/;
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
		if(start == ''){
			//add errors
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().attr('class','control-group error');
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().find('.help-block').html('You must choose an start date');			
		} else {
			//remove errors
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().attr('class','control-group');
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockBeginDate').parent().parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group error');		
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('You must choose an end date');	
		} else {
			//remove errors
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group');
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group error');
				$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
			} else {
				//remove errors
				$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().attr('class','control-group');
				$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
			}
		} 
		if(age_range ==''){
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().attr('class','control-group error');		
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().find('.help-block').html('This value cannot be empty');				
		} else{
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().attr('class','control-group');		
			$('#ticketInventoryTbody-'+idx+' .newAgeRow:last-child .ticketAgeRange').parent().parent().find('.help-block').html('');				
		}
	

		//sucess now send
		if(start != '' && end != '' && startCheck <= endCheck) {

			var addAgeRow = newTicketBlockCan(idx,row,timestamp, inventory,net, gross, markup);
			$("#ticketInventoryTbody-"+idx).append(addAgeRow);
			attraction_tickets.addInventoryScripts(idx, row);
			
			
			
			

		}
	}, 
	addInventoryScripts: function(idx, row){
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
		$("#AttractionTicket"+idx+"Inventory"+row+"AgeRange").blur(function(){
			var age_range = $(this).val();
			var date = $(this).parent().parent().parent().parent().find('.blockBeginDate').val();
			var timestamp = new Date(date).getTime() / 1000;
			
			$(this).parent().parent().parent().find(".ticketAgeRange").attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+age_range+'][age_range]');
			$(this).parent().parent().parent().find(".inventoryInventory").attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+age_range+'][inventory]');
			$(this).parent().parent().parent().find(".inventoryNetRate").attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+age_range+'][net]');
			$(this).parent().parent().parent().find(".inventoryMarkupRate").attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+age_range+'][markup]');
			$(this).parent().parent().parent().find(".inventoryGrossRate").attr('name','data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range]['+age_range+'][gross]');			
			
			
		});


		//remove button
		$("#removeAgeButton-"+idx+'-'+row).click(function(){

			if(confirm('Are you sure you want to delete row?')){
				$(this).parent().parent().remove();
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
		
	}, 
	editSelect: function(date,idx,row,updateClass, updateCount){ //creates a multi select of the datepicker
		var timestamp = Math.round((new Date(date)).getTime() / 1000);		
		var oldCount = $(updateClass+" li").length;
		var count = parseInt(oldCount)+1;
		var code_append = 
			'<li id="blackoutDate-'+count+'" timestamp="'+timestamp+'" class="label label-inverse pull-left" style="width:150px; margin-bottom:3; margin-top:3px; margin-right:15px; margin-left:0px;">'+
				'<button id="close-'+count+'" type="button" class="close" count="'+count+'" style="color:#ffffff;">×</button>'+
				'<span class="date_to_edit">Selected: <strong class="text-error">'+date+'</strong></span>'+
				'<input type="hidden" id="AttractionTicket'+idx+'Blackout'+(count-1)+'Dates" name="data[Attraction_ticket]['+idx+'][blackout]['+(count-1)+'][dates]" value="'+date+'"/>'+
			'</li>';
		attraction_tickets.editCounter(count,idx,updateClass, updateCount);
		attraction_tickets.minusCounter(count,idx,updateClass,updateCount);
		//check to see where in place the new li should be, then append it
		attraction_tickets.insertBlackoutDates(idx,timestamp,updateClass,code_append);		
	}, 
	insertBlackoutDates: function(idx,timestamp,updateClass, code_append){
		//check to see where in place the new li should be, then append it
		var liLength = $("#blackoutDatesUl-"+idx+' li').length;
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
									$(this).parent().fadeOut();
								});								
								return false;
							}
							if(timestamp < thisTime){
								var thisId = '#blackoutDatesUl-'+idx+' #'+$(this).attr('id');
								$(code_append).insertBefore(thisId);
								$('#blackoutDatesUl-'+idx+' .close').click(function(){
									$(this).parent().fadeOut();
								});								
								return false;								
							}
						} else {
							if(timestamp > thisTime){

								var thisId = '#blackoutDatesUl-'+idx+' #'+$(this).attr('id');
								$(code_append).insertAfter(thisId);		
								$('#blackoutDatesUl-'+idx+' .close').click(function(){
									$(this).parent().fadeOut();
								});								
								return false;						
							} else {
								var thisId = '#blackoutDatesUl-'+idx+' #'+$(this).attr('id');
								$(code_append).insertBefore(thisId);		
								$('#blackoutDatesUl-'+idx+' .close').click(function(){
									$(this).parent().fadeOut();
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

var addOnsUs = function(num) {
	//get room add-ons
	var addOnLength = $("#attractionAddOnTbody tr").length;
	if(addOnLength >0){
		var addOns = '';
		$("#attractionAddOnTbody tr").each(function(idx){
			var title = $(this).find("#attractionAddOnTitle").val();
			var price = $(this).find(".attractionAddOnPrice").val();
			
			addOns = addOns+
				'<tr num="'+num+'" idx="'+idx+'">'+
					'<td>'+
						'<label class="checkbox"><input id="addOnCheckList'+num+'Row'+idx+'" class="addOnCheckList" type="checkbox" checked="checked" name="addOnCheckList"/></label>'+
					'</td>'+
					'<td class="addOnActiveRow-title">'+title+' <input id="HotelRoom'+num+'AddOns'+idx+'Title" class="inventoryAddOnsTitle" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][title]" value="'+title+'"/></td>'+
					'<td class="addOnActiveRow-price">US$'+price+' <input id="HotelRoom'+num+'AddOns'+idx+'Price" class="inventoryAddOnsPrice" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][price]" value="'+price+'"/></td>'+
					//'<td class="addOnActiveRow-perbasis">'+per_basis+' <input id="HotelRoom'+num+'AddOns'+idx+'PerBasis" class="inventoryAddOnsPerBasis" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][per_basis]" value="'+per_basis+'"/></td>'+
				'</tr>';
		});	
		var tableAddOnStart = 
			'<table class="table table-bordered table-condensed table-hover">'+
				'<thead>'+
					'<tr>'+
						'<th style="width:20px"></th>'+
						'<th>Add-On Name</th>'+
						'<th>Price</th>'+
					'</tr>'+
				'</thead>'+
				'<tbody>';
		var tableEnd = '</tbody></table>';
		addOns = tableAddOnStart+addOns+tableEnd;
	} else {
		addOns = '<em>There were no add-ons created</em>';
	}	
	
	return addOns;
}
var addOnsCan = function(num) {
	//get room add-ons
	var addOnLength = $("#attractionAddOnTbody tr").length;
	if(addOnLength >0){
		var addOns = '';
		$("#attractionAddOnTbody tr").each(function(idx){
			var title = $(this).find("#attractionAddOnTitle").val();
			var net = $(this).find(".attractionAddOnNet").val();
			var exchange = $(this).find('.attractionAddOnExchange').val();
			var gross = $(this).find('.attractionAddOnGross').val();

			addOns = addOns+
				'<tr num="'+num+'" idx="'+idx+'">'+
					'<td>'+
						'<label class="checkbox"><input id="addOnCheckList'+num+'Row'+idx+'" class="addOnCheckList" type="checkbox" checked="checked" name="addOnCheckList"/></label>'+
					'</td>'+
					'<td class="addOnActiveRow-title">'+title+' <input id="HotelRoom'+num+'AddOns'+idx+'Title" class="inventoryAddOnsTitle" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][title]" value="'+title+'"/></td>'+
					'<td class="addOnActiveRow-net">CN$'+net+' <input id="HotelRoom'+num+'AddOns'+idx+'Net" class="inventoryAddOnsNet" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][net]" value="'+net+'"/></td>'+
					'<td class="addOnActiveRow-exchange">'+exchange+' CAN/USD <input id="HotelRoom'+num+'AddOns'+idx+'Exchange" class="inventoryAddOnsExchange" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][exchange]" value="'+exchange+'"/></td>'+
					'<td class="addOnActiveRow-gross">US$'+gross+' <input id="HotelRoom'+num+'AddOns'+idx+'Gross" class="inventoryAddOnsGross" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][gross]" value="'+gross+'"/></td>'+
					//'<td class="addOnActiveRow-perbasis">'+per_basis+' <input id="HotelRoom'+num+'AddOns'+idx+'PerBasis" class="inventoryAddOnsPerBasis" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][per_basis]" value="'+per_basis+'"/></td>'+
				'</tr>';
		});	
		var tableAddOnStart = 
			'<table class="table table-bordered table-condensed table-hover">'+
				'<thead>'+
					'<tr>'+
						'<th style="width:20px"></th>'+
						'<th>Add-On Name</th>'+
						'<th>Net</th>'+
						'<th>Exchange Rate</th>'+
						'<th>Gross</th>'+
					'</tr>'+
				'</thead>'+
				'<tbody>';
		var tableEnd = '</tbody></table>';
		addOns = tableAddOnStart+addOns+tableEnd;
	} else {
		addOns = '<em>There were no add-ons created</em>';
	}	
	
	return addOns;
}




var newTicketUs = function(num, get_addOns){
	if(num == '0'){
		var attribute = 'accordion-toggle acc-in';
		var attribute2 = 'accordion-body collapse in';
	} else {
		var attribute = 'accordion-toggle';
		var attribute2 = 'accordion-body collapse';
	}

	//tax rates
	$("#taxRateDiv .taxSelection").attr('num',num);
	var tax_rates = $("#taxRateDiv").html();
	//setup time search
	var minutes = $("#minutes").val();
	
	var ticket = 
		'<div class="accordion-group" style="background:#fff;" idx="'+num+'">'+
			'<div class="accordion-heading" name="attractionTicket">'+
				'<a class="'+attribute+'" data-toggle="collapse" data-parent="#accordionTicketType" href="#ticketType'+num+'"><h4>Tour Name: <span id="ticketTypeSpan-'+num+'" class="ticketTypeSpan">'+(num+1)+'</span> <span id="ticketTypeLabel-'+num+'" class="ticketTypeLabel"></span></h4></a>'+
			'</div>'+
			'<div id="ticketType'+num+'" class="'+attribute2+'">'+
				'<div id="ticketInventoryDiv" class="accordion-inner">'+
					'<div id="attractionTicketInventoryDiv-'+num+'">'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 1:<span class="f_req">*</span> <strong>Tour Information</strong></h5>'+
							'<div class="form-horizontal">'+
								'<div class="control-group">'+				
									'<label class="control-label">Attraction Tour Name</label>'+
									'<div class="controls">'+
										'<input id="AttractionTicket'+num+'Name" class="attractionTicketName span6" dataRow="'+num+'" type="text" placeholder="enter a attraction ticket type" name="data[Attraction_ticket]['+num+'][name]">'+						
										'<span class="help-inline"></span>'+
									'</div>'+			
								'</div>'+
								'<div class="control-group">'+				
									'<label class="control-label">Ticket Status</label>'+
									'<div class="controls">'+
										'<select id="AttractionTicket'+num+'Status" name="data[Attraction_ticket]['+num+'][status]">'+
											'<option value="1">Select Here</option>'+
											'<option value="2">Unbookable</option>'+
											'<option value="3">Unbookable, except in packages</option>'+
											'<option value="4">Unbookable, except in packages or by employees</option>'+
											'<option value="5">Bookable, but not public</option>'+
											'<option value="6">Bookable, and public</option>'+
										'</select>'+					
										'<span class="help-inline"></span>'+
									'</div>'+			
								'</div>'+								
								'<div class="control-group">'+				
									'<label class="control-label">Special Instrucations (<em>optional</em>)</label>'+
									'<div class="controls">'+
										'<textarea class="span6" cols="30" rows="6" type="text" name="data[Attraction_ticket]['+num+'][instructions]" ></textarea>'+				
										'<span class="help-inline"></span>'+
									'</div>'+			
								'</div>'+										
							'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 2:<span class="f_req">*</span> <strong>Tour Add-Ons - <em>Deselect add-ons that are not applicable</em></strong></h5>'+
							'<div class="control-group">'+get_addOns+'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 3: <span class="f_req">*</span><strong>Tax Rate Setup</strong></h5>'+
							'<div id="'+num+'" class="form-horizontal">'+tax_rates+
								'<div class="control-group">'+
									'<label class="control-label"><strong>Tax Rate</strong></label>'+
									'<div class="controls">'+
										'<div class="input-append">'+
											'<input id="taxrate-'+num+'" class="taxrate" disabled="disabled" type="text" name="" value="0"/>'+
											'<span class="add-on">%</span>'+
										'</div>'+
										'<input id="taxrate-'+num+'" class="taxrate" type="hidden" name="data[Attraction_ticket]['+num+'][tax_rate]" value=""/>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+

						'<div class="formSep clearfix">'+
							'<h5 class="heading">Step 4:<span class="f_req">*</span> <strong>Ticket Schedule</strong></h5>'+
							'<div class="clearfix">'+
								'<label class="checkbox"><input id="multiday-'+num+'" class="multiday" type="checkbox" name="data[Attraction_ticket]['+num+'][time_ticket]" value="No"/> Click here if there are multiple times per day</label>'+
								'<div id="multidayDiv-'+num+'" class="form-horizontal well well-small hide">'+
									'<h5 class="heading">Time Settings</h5>'+
									'<div class="control-group">'+
										'<label class="control-label">Select Time</label>'+
										'<div class="controls">'+
											'<div class="input-append">'+
												'<input type="search" id="timeInput-'+num+'" class="timeInput" data-provide="typeahead" data-source=\''+minutes+'\'/>'+
												'<span id="timeSubmit-'+num+'" class="timeSubmit add-on btn btn-link">create</span>'+
											'</div>'+
											'<span id="help-block-'+num+'" class="help-block"></span>'+
										'</div>'+
									'</div>'+
									'<ol id="timeResults-'+num+'" class="timeResults controls unstyled clearfix hide">'+

									'</ol>'+
								'</div>'+
							'<div id="noTimeTableDiv-'+num+'">'+
								'<table id="noTimeTable-'+num+'" status="active" class="attractionTable-'+num+' table table-condensed table-bordered table-vam" type="noTimeTable">'+
									'<thead>'+
										'<tr>'+
											'<th>Begin Date</th>'+
											'<th>End Date</th>'+
											'<th>Age Range</th>'+
											'<th>Inventory</th>'+
											'<th>Net Rate</th>'+
											'<th>Mark Up Rate</th>'+
											'<th>Gross Rate</th>'+
											'<th>Actions</th>'+
										'<tr>'+
									'</thead>'+
									
									'<tbody id="ticketInventoryTbody-'+num+'" class="ticketInventoryTbody" special="primary">'+
										'<tr class="newAgeRow" row="top" num="0">'+	
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][Inventory][0][start_date]" style="width:100px;">'+
													'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][Inventory][0][end_date]" style="width:100px;">'+
													'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<input id="AttractionTicket'+num+'Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][age_range]" placeholder="i.e. Adults (16+)">'+
												'</div>'+
												'<span class="help-block"></span>'+																											
											'</td>'+							
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][inventory]" style="width:75px;">'+	
												'</div>'+
												'<span class="help-block"></span>'+											
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0" style="width:75px;">'+	
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][markup]" value="0" style="width:75px;">'+	
													'<span class="add-on">%</span>'+
												'</div>'+
												'<span class="help-block"></span>'+																									
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][gross]" value="0" style="width:75px;">'+
												'</div>'+
												'<span class="help-block"></span>'+													
											'</td>'+
											'<td>'+
											
												'<button id="addAgeButton-'+num+'" class="addAgeButton btn btn-small" type="button"><i class="icon-plus"></i></button>'+
											'</td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+
							'</div>'+
							'<div id="timeTableDiv-'+num+'" class="clearfix hide">'+
								'<table id="timeTable-'+num+'" status="notactive" class="attractionTable-'+num+' table table-condensed table-bordered" type="timeTable">'+
									'<thead>'+
										'<tr>'+
											'<th>Begin Date</th>'+
											'<th>End Date</th>'+
											'<th>Time</th>'+
											'<th>Age Range</th>'+
											'<th>Inventory</th>'+
											'<th>Net Rate</th>'+
											'<th>Mark Up Rate</th>'+
											'<th>Gross Rate</th>'+
											'<th>Actions</th>'+
										'<tr>'+
									'</thead>'+

									'<tbody id="ticketInventoryTbody-'+num+'" class="ticketInventoryTbody" special="primary">'+
										'<tr class="newAgeRow" row="top" num="0">'+	
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][Inventory][0][start_date]" style="width:100px;" disabled="disabled">'+
													'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][Inventory][0][end_date]" style="width:100px;" disabled="disabled">'+
													'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Time" class="ticketTime" type="text" placeholder=""  style="width:100px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+	
												'<input id="AttractionTicket'+num+'Inventory0Time" class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket]['+num+'][Inventory][0][time]" style="width:100px;">'+													
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<input id="AttractionTicket'+num+'Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][age_range]" placeholder="i.e. Adults (16+)" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+																											
											'</td>'+							
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][inventory]" style="width:75px;" disabled="disabled">'+	
												'</div>'+
												'<span class="help-block"></span>'+											
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0" style="width:75px;" disabled="disabled">'+	
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][markup]" value="0" style="width:75px;" disabled="disabled">'+	
													'<span class="add-on">%</span>'+
												'</div>'+
												'<span class="help-block"></span>'+																									
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][gross]" value="0" style="width:75px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+													
											'</td>'+
											'<td>'+
											
												'<button id="addAgeButtonTime-'+num+'-0" class="addAgeButtonTime btn btn-small" type="button"><i class="icon-plus"></i></button>'+
												
											'</td>'+
										'</tr>'+
									'</tbody>'+

								'</table>'+

							'</div>'+
							'<div class="formSep clearfix">'+
								'<button type="button" id="addTicketInventory-'+num+'" class="btn btn-primary pull-right">Add New Schedule</button>'+
							'</div>'+							

						'</div>'+
						'<div class="formSep clearfix">'+
							'<h5 class="heading">Step 5:<span class="f_req">*</span> <strong>Set Blackout Dates</strong></h5>'+
							'<div class="formRow">'+
								'<div class="w-box">'+
									'<div class="w-box-header">'+
										'<div class="pull-left">'+
											'Select Blackout Dates '+
											'<input id="fullYear-'+num+'" type="text" class="fullYear" placeholder="Click Here"/>'+											
										'</div>'+		
										'<div class="pull-right">'+		
											'<span id="blackoutDateCounter-'+num+'" class="label label-inverse">0 Blackout Dates Selected</span>'+
										'</div>'+
									'</div>'+
									'<div id="selectedBlackoutDates-'+num+'" class="w-box-content" style="padding-left:10px; padding-top:5px">'+
										'<p id="noneSelectedP-'+num+'"><em>None Selected</em></p>'+
										'<ul id="blackoutDatesUl-'+num+'" class="unstyled clearfix"></ul>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="formSep" style="height:40px;">'+
							'<button id="removeTicketButton-'+num+'" type="button" class="removeTicketButton btn btn-danger btn-large pull-right">Remove Ticket</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';
	
	return ticket;
}

var newTicketCan = function(num, get_addOns){
	var exchange = $(".exchange").val();
	
	if(num == '0'){
		var attribute = 'accordion-toggle acc-in';
		var attribute2 = 'accordion-body collapse in';
	} else {
		var attribute = 'accordion-toggle';
		var attribute2 = 'accordion-body collapse';
	}

	//tax rates
	$("#taxRateDiv .taxSelection").attr('num',num);
	var tax_rates = $("#taxRateDiv").html();
	
	//setup time table minutes
	var minutes = $("#minutes").val();
	
	//new created ticket
	var ticket = 
		'<div class="accordion-group" style="background:#fff;" idx="'+num+'">'+
			'<div class="accordion-heading" name="attractionTicket">'+
				'<a class="'+attribute+'" data-toggle="collapse" data-parent="#accordionTicketType" href="#ticketType'+num+'"><h4>Tour Name: <span id="ticketTypeSpan-'+num+'" class="ticketTypeSpan">'+(num+1)+'</span> <span id="ticketTypeLabel-'+num+'" class="ticketTypeLabel"></span></h4></a>'+
			'</div>'+
			'<div id="ticketType'+num+'" class="'+attribute2+'">'+
				'<div id="ticketInventoryDiv" class="accordion-inner">'+
					'<div id="attractionTicketInventoryDiv-'+num+'">'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 1:<span class="f_req">*</span> <strong>Tour Information</strong></h5>'+
							'<div class="form-horizontal">'+
								'<div class="control-group">'+				
									'<label class="control-label">Attraction Tour Name</label>'+
									'<div class="controls">'+
										'<input id="AttractionTicket'+num+'Name" class="attractionTicketName span6" dataRow="'+num+'" type="text" placeholder="enter a attraction ticket type" name="data[Attraction_ticket]['+num+'][name]">'+						
										'<span class="help-inline"></span>'+
									'</div>'+			
								'</div>'+
								'<div class="control-group">'+				
									'<label class="control-label">Ticket Status</label>'+
									'<div class="controls">'+
										'<select id="AttractionTicket'+num+'Status" name="data[Attraction_ticket]['+num+'][status]">'+
											'<option value="1">Select Here</option>'+
											'<option value="2">Unbookable</option>'+
											'<option value="3">Unbookable, except in packages</option>'+
											'<option value="4">Unbookable, except in packages or by employees</option>'+
											'<option value="5">Bookable, but not public</option>'+
											'<option value="6">Bookable, and public</option>'+
										'</select>'+					
										'<span class="help-inline"></span>'+
									'</div>'+			
								'</div>'+
								'<div class="control-group">'+				
									'<label class="control-label">Special Instrucations (<em>optional</em>)</label>'+
									'<div class="controls">'+
										'<textarea class="span6" cols="30" rows="6" type="text" name="data[Attraction_ticket]['+num+'][instructions]" ></textarea>'+				
										'<span class="help-inline"></span>'+
									'</div>'+			
								'</div>'+		
							'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 2:<span class="f_req">*</span> <strong>Tour Add-Ons - <em>Deselect add-ons that are not applicable</em></strong></h5>'+
							'<div class="control-group">'+get_addOns+'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 3: <span class="f_req">*</span><strong>Tax Rate Setup</strong></h5>'+
							'<div id="'+num+'" class="form-horizontal">'+tax_rates+
								'<div class="control-group">'+
									'<label class="control-label"><strong>Tax Rate</strong></label>'+
									'<div class="controls">'+
										'<div class="input-append">'+
											'<input id="taxrate-'+num+'" class="taxrate" disabled="disabled" type="text" name="" value="0"/>'+
											'<span class="add-on">%</span>'+
										'</div>'+
										'<input id="taxrate-'+num+'" class="taxrate" type="hidden" name="data[Attraction_ticket]['+num+'][tax_rate]" value=""/>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+

						'<div class="formSep clearfix">'+
							'<h5 class="heading">Step 4:<span class="f_req">*</span> <strong>Ticket Schedule</strong></h5>'+
							'<div>'+
								'<label class="checkbox"><input id="multiday-'+num+'" class="multiday" type="checkbox" name="data[Attraction_ticket]['+num+'][time_ticket]" value="No"/> Click here if there are multiple times per day</label>'+
								'<div id="multidayDiv-'+num+'" class="form-horizontal well well-small hide">'+
									'<h5 class="heading">Time Settings</h5>'+
									'<div class="control-group">'+
										'<label class="control-label">Select Time</label>'+
										'<div class="controls">'+
											'<div class="input-append">'+
												'<input type="search" id="timeInput-'+num+'" class="timeInput" data-provide="typeahead" data-source=\''+minutes+'\'/>'+
												'<span id="timeSubmit-'+num+'" class="timeSubmit add-on btn btn-link">create</span>'+
											'</div>'+
											'<span id="help-block-'+num+'" class="help-block"></span>'+
										'</div>'+
									'</div>'+
									'<ol id="timeResults-'+num+'" class="timeResults controls unstyled clearfix hide">'+

									'</ol>'+
								'</div>'+
							'<div>'+
							'<div id="noTimeTableDiv-'+num+'">'+
								'<table id="noTimeTable-'+num+'" status="active" class="attractionTable-'+num+' table table-condensed table-bordered table-vam" type="noTimeTable">'+
									'<thead>'+
										'<tr>'+
											'<th>Begin Date</th>'+
											'<th>End Date</th>'+
											'<th>Age Range</th>'+
											'<th>Inventory</th>'+
											'<th>Net Rate</th>'+
											'<th>Exchange</th>'+
											'<th>Mark Up Rate</th>'+
											'<th>Gross Rate</th>'+
											'<th>Actions</th>'+
										'<tr>'+
									'</thead>'+
									
									'<tbody id="ticketInventoryTbody-'+num+'" class="ticketInventoryTbody" special="primary">'+
										'<tr class="newAgeRow" row="top" num="0">'+	
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][Inventory][0][start_date]" style="width:100px;">'+
													'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][Inventory][0][end_date]" style="width:100px;">'+
													'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<input id="AttractionTicket'+num+'Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;">'+
												'</div>'+
												'<span class="help-block"></span>'+																											
											'</td>'+							
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][inventory]" style="width:50px;">'+	
												'</div>'+
												'<span class="help-block"></span>'+											
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend input-append">'+
													'<span id="dollarSignSpan" class="add-on">CN$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0" style="width:75px;">'+	
													'<span id="switchNetRate-'+num+'-0" status="canusd" dataRow=""class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
													
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][exchange]" value="'+exchange+'" style="width:75px;" disabled="disabled">'+	
													'<span class="add-on">CAN/USD</span>'+												
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][markup]" value="0" style="width:75px;">'+	
													'<span class="add-on">%</span>'+
												'</div>'+
												'<span class="help-block"></span>'+																									
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][gross]" value="0" style="width:75px;">'+
												'</div>'+
												'<span class="help-block"></span>'+													
											'</td>'+
											'<td>'+
											
												'<button id="addAgeButton-'+num+'" class="addAgeButton btn btn-small" type="button"><i class="icon-plus"></i></button>'+
											'</td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+
							'</div>'+
							'<div id="timeTableDiv-'+num+'" class="clearfix hide">'+
								'<table id="timeTable-'+num+'" status="notactive" class="attractionTable-'+num+' table table-condensed table-bordered" type="timeTable">'+
									'<thead>'+
										'<tr>'+
											'<th>Begin Date</th>'+
											'<th>End Date</th>'+
											'<th>Time</th>'+
											'<th>Age Range</th>'+
											'<th>Inventory</th>'+
											'<th>Net Rate</th>'+
											'<th>Exchange</th>'+
											'<th>Mark Up Rate</th>'+
											'<th>Gross Rate</th>'+
											'<th>Actions</th>'+
										'<tr>'+
									'</thead>'+

									'<tbody id="ticketInventoryTbody-'+num+'" class="ticketInventoryTbody" special="primary">'+
										'<tr class="newAgeRow" row="top" num="0">'+	
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][Inventory][0][start_date]" style="width:100px;" disabled="disabled">'+
													'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][Inventory][0][end_date]" style="width:100px;" disabled="disabled">'+
													'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Time" class="ticketTime" type="text" placeholder=""  style="width:75px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+	
												'<input id="AttractionTicket'+num+'Inventory0Time" class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket]['+num+'][Inventory][0][time]">'+													
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<input id="AttractionTicket'+num+'Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+																											
											'</td>'+							
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][inventory]" style="width:50px;" disabled="disabled">'+	
												'</div>'+
												'<span class="help-block"></span>'+											
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend input-append">'+
													'<span id="dollarSignSpan" class="add-on">CN$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" style="width:75px;" disabled="disabled">'+	
													'<span id="switchNetRate-'+num+'-0" status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][exchange]" style="width:50px;" disabled="disabled" value="'+exchange+'" >'+	
													'<span class="add-on">CAN/USD</span>'+												
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][markup]"  style="width:75px;" disabled="disabled">'+	
													'<span class="add-on">%</span>'+
												'</div>'+
												'<span class="help-block"></span>'+																									
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+num+'][Inventory][0][gross]"  style="width:75px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+													
											'</td>'+
											'<td>'+
											
												'<button id="addAgeButtonTime-'+num+'-0" class="addAgeButtonTime btn btn-small" type="button"><i class="icon-plus"></i></button>'+
												
											'</td>'+
										'</tr>'+
									'</tbody>'+

								'</table>'+

							'</div>'+							

							'<div class="clearfix">'+
								'<button type="button" id="addTicketInventory-'+num+'" class="btn btn-primary pull-right">Add New Schedule</button>'+
							'</div>'+
						'</div>'+
						'<div class="formSep clearfix">'+
							'<h5 class="heading">Step 5:<span class="f_req">*</span> <strong>Set Blackout Dates</strong></h5>'+
							'<div class="formRow">'+
								'<div class="w-box">'+
									'<div class="w-box-header">'+
										'<div class="pull-left">'+
											'Select Blackout Dates '+
											'<input id="fullYear-'+num+'" type="text" class="fullYear" placeholder="Click Here"/>'+											
										'</div>'+		
										'<div class="pull-right">'+		
											'<span id="blackoutDateCounter-'+num+'" class="label label-inverse">0 Blackout Dates Selected</span>'+
										'</div>'+
									'</div>'+
									'<div id="selectedBlackoutDates-'+num+'" class="w-box-content" style="padding-left:10px; padding-top:5px">'+
										'<p id="noneSelectedP-'+num+'"><em>None Selected</em></p>'+
										'<ul id="blackoutDatesUl-'+num+'" class="unstyled clearfix"></ul>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="formSep" style="height:40px;">'+
							'<button id="removeTicketButton-'+num+'" type="button" class="removeTicketButton btn btn-danger btn-large pull-right">Remove Ticket</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';
	
	return ticket;
}


var newTicketBlockUs = function(idx,num, timestamp, inventory,net, gross, markup){
	var removeCount = $("#noTimeTable-"+idx+" .removeAgeButton").length;
	var ticketBlock = 
		'<tr class="" row="sub">'+	
			'<td class="control-group"></td>'+
			'<td class="control-group" style="border-left:none"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][age_range]" placeholder="i.e. Adults (16+)" value="">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][inventory]" style="width:75px;" value="'+inventory+'">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][net]" style="width:75px;" value="'+net+'">'+	
				'</div>'+
				'<span class="help-block"></span>'+		
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][markup]" style="width:75px;" value="'+markup+'">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+']age_range][][gross]" style="width:75px;" value="'+gross+'">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
			
				'<button id="removeAgeButton-'+idx+'-'+removeCount+'" class="removeAgeButton btn btn-small btn-danger" type="button"><i class="icon-trash icon-white"></i></button>'+
			'</td>'+
		'</tr>';
	return ticketBlock;
}


var newTicketBlockCan = function(idx,num,timestamp, inventory,net, gross, markup){

	var exchange = $('.exchange').val();
	var removeCount = $("#noTimeTable-"+idx+" .removeAgeButton").length;
	var ticketBlock = 
		'<tr  row="sub">'+
			'<td class="control-group"></td>'+
			'<td class="control-group" style="border-left:none"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+num+'][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;" value="">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+num+'][inventory]" style="width:50px;" value="'+inventory+'">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+num+'][net]" style="width:75px;" value="'+net+'">'+	
					'<span id="switchNetRate-'+idx+'-'+num+'" status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+		
				//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][Inventory][0][net]" value="0">'+																							
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+num+'][exchange]" style="width:75px;" disabled="disabled" value="'+exchange+'">'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+num+'][markup]" style="width:75px;" value="'+markup+'">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+num+'][gross]" style="width:75px;" value="'+gross+'">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
			
				'<button id="removeAgeButton-'+idx+'-'+removeCount+'" class="removeAgeButton btn btn-small btn-danger" type="button"><i class="icon-trash icon-white"></i></button>'+
			'</td>'+
		'</tr>';
	return ticketBlock;
}
/**
 * New time based ticket. US form. based on location of the attraction 
 * @param {Object} idx
 * @param {Object} num
 * @param {Object} time
 * @param {Object} timestamp
 */
var newTicketTimeUs = function(idx,num,time,timestamp){
	var num = $("#timeTable-"+idx+" tbody tr").length;
	var ticketBlock = 
		'<tbody id="ticketInventoryTbody-'+idx+'" class="ticketInventoryTbody" row="'+num+'" time="'+timestamp+'" special="primary">'+
		'<tr class="newAgeRow" row="main" time="'+time+'" background-color>'+	
			'<td class="control-group"></td>'+
			'<td class="control-group" style="border-left:none"></td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Time" class="ticketTime" type="text" placeholder="" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][time]" style="width:100px;" value="'+time+'" disabled="disabled">'+
				'</div>'+
				'<span class="help-block"></span>'+		
				'<input id="AttractionTicket'+idx+'Inventory'+num+'Time" type="hidden" class="ticketTimeFinal" type="text" placeholder="" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][time]" style="width:100px;" value="'+time+'">'+												
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][age_range]" placeholder="i.e. Adults (16+)" value="">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+idx+'][age_range][Inventory]['+timestamp+'][age_range][][inventory]" style="width:75px;" >'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][net]" style="width:75px;" >'+	
				'</div>'+
				'<span class="help-block"></span>'+		
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][markup]" style="width:75px;" >'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][gross]" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
			
				'<button id="addAgeButtonTime-'+idx+'-'+num+'" class="addAgeButtonTime btn btn-small" type="button"><i class="icon-plus"></i></button>'+
			'</td>'+
		'</tr>'+
		'</tbody>';
		

	return ticketBlock;
}

var newTicketTimeCan = function(idx,num,time,timestamp){
	var num = $("#timeTable-"+idx+" tbody tr").length;
	var exchange = $(".exchange").val();
	var ticketBlock = 
		'<tbody id="ticketInventoryTbody-'+idx+'" class="ticketInventoryTbody" row="'+num+'" time="'+timestamp+'" special="primary">'+
		'<tr class="newAgeRow" row="main" time="'+time+'" background-color>'+	
			'<td class="control-group"></td>'+
			'<td class="control-group" style="border-left:none"></td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Time" class="ticketTime" type="text" placeholder="" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][time]" style="width:75px;" value="'+time+'" disabled="disabled">'+
				'</div>'+
				'<span class="help-block"></span>'+		
				'<input id="AttractionTicket'+idx+'Inventory'+num+'Time" type="hidden" class="ticketTimeFinal" type="text" placeholder="" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][time]" style="width:75px;" value="'+time+'">'+												
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][age_range]" placeholder="i.e. Adults (16+)" value="" style="width:125px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+idx+'][age_range][Inventory]['+timestamp+'][age_range][][inventory]" style="width:50px;" >'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][net]" style="width:75px;" >'+	
					'<span id="switchNetRate-'+idx+'-'+num+'" status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][exchange]" value="'+exchange+'" disabled="disabled" style="width:50px;" >'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][markup]" style="width:75px;" >'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+num+'Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][gross]" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
			
				'<button id="addAgeButtonTime-'+idx+'-'+num+'" class="addAgeButtonTime btn btn-small" type="button"><i class="icon-plus"></i></button>'+
			'</td>'+
		'</tr>'+
		'</tbody>';
	return ticketBlock;
}

var newAgeRangeBlockUs = function(idx, num,time, timestamp, net, gross, markup, inventory){
	var newRow = $('#timeTable-'+idx+' tbody tr').length;

	var newButtonRow = $('#timeTable-'+idx+' .removeAgeRow').length;
	var ageRange = 
		'<tr row="sub" num="'+num+'" time="'+time+'" timestamp="'+timestamp+'" >'+	
			'<td class="control-group" style=""></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][age_range]" value="">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+
							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][inventory]" value="'+inventory+'" style="width:75px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Net" type="text" class="inventoryNetRate" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][net]" value="'+net+'" style="width:75px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Markup" type="text" class="inventoryMarkupRate" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][markup]" value="'+markup+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+			
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Gross" type="text" class="inventoryGrossRate" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][gross]" value="'+gross+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button id="removeAgeRow-'+idx+'-'+newButtonRow+'" type="button" class="removeAgeRow btn btn-small btn-danger"><i class="icon-trash icon-white"></i></button>'+
			'</td>'+
		'</tr>';
		
	return ageRange;
}

var newAgeRangeBlockCan = function(idx, num,time, timestamp, net, gross, markup, inventory){
	var newRow = $('#timeTable-'+idx+' tbody tr').length;
	var exchange = $(".exchange").val();
	var newButtonRow = $('#timeTable-'+idx+' .removeAgeRow').length;
	var ageRange = 
		'<tr row="sub" num="'+num+'" time="'+time+'" timestamp="'+timestamp+'">'+	
			'<td class="control-group" style=""></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][age_range]" value="" style="width:125px">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+
							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][inventory]" value="'+inventory+'" style="width:50px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Net" type="text" class="inventoryNetRate" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][net]" value="'+net+'" style="width:75px;">'+	
					'<span id="switchNetRate-'+idx+'-'+newRow+'" status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Exchange" type="text" class="inventoryExchangeRate" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][exchange]" value="'+exchange+'" disabled="disabled"  style="width:50px;">'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Markup" type="text" class="inventoryMarkupRate" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][markup]" value="'+markup+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+			
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket'+idx+'Inventory'+newRow+'Gross" type="text" class="inventoryGrossRate" name="data[Attraction_ticket]['+idx+'][Inventory]['+timestamp+'][age_range][][gross]" value="'+gross+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button id="removeAgeRow-'+idx+'-'+newButtonRow+'" type="button" class="removeAgeRow btn btn-small btn-danger"><i class="icon-trash icon-white"></i></button>'+
			'</td>'+
		'</tr>';
		
	return ageRange;
}

var newTicketMarketing = function(num){
	var ticketMarketing = 
		'<div id="marketingTicket-'+num+'" class="accordion-group">'+
			'<div class="accordion-heading">'+
				'<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#ticket-'+num+'"><h4 id="attractionTicketName-'+num+'"></h4></a>'+
			'</div>'+
			'<div id="ticket-'+num+'" class="accordion-body collapse">'+
				'<div class="accordion-inner">'+
					'<div id="attraction_ticket_marketing-'+num+'">'+
						'<div class="formSep">'+
							'<h4 class="heading">Select Primary Image For Ticket</h4>'+
							'<div id="mixed_grid" class="wmk_grid well well-large" >'+
								'<ul id="attraction_ticket_images-'+num+'" class="attraction_ticket_images" name="Attraction_ticket">'+'</ul>'+
							'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h4>Create Ticket Description</h4>'+
							'<div class="control-group">'+
								'<label>Ticket Description</label>'+
								'<textarea name="data[Attraction_ticket]['+num+'][ticket_description]" class="span6" rows="5" cols="30"></textarea>'+
								'<span class="help-block"></span>'+
							'</div>'+	
						'</div>'+			
					'</div>'+
				'</div>'+	
			'</div>'+
		'</div>';
	return ticketMarketing;
}
var createTax = function(tax_id,tax_name,tax_rate,tax_country,idx,row){
	var tax =
		'<div class="taxesRatesDivs alert alert-info" style="margin-bottom:2px;">'+
			'<button id="removeTax-'+idx+'-'+tax_id+'" type="button" class="removeTax pull-right" ><icon class="icon-trash"></icon></button>'+
			'<label class="control-label">'+tax_name+'</label>'+
			'<div class="controls">'+
				'<div class="input-append">'+
					
					'<input id="taxesInput-'+tax_id+'" class="taxesInput" name="" type="text" disabled="disabled" value="'+tax_rate+'"/>'+
					'<span class="add-on">'+tax_country+'</span>'+
				'</div>'+
				'<input type="hidden" name="data[Attraction_ticket]['+idx+'][taxes]['+tax_id+']" value="'+tax_id+'"/>'+
			'</div>'+
		'</div>';
		
	return tax;
}
var getAddOnExchange = function(row, net,flag, exchange,old, gross){
	
	var name = '<input type="hidden" class="attractionAddOnFlag" value="Hotel" name="data[Attraction][Exchange_pricing]['+row+'][name]" />';
	var desc = '<input type="hidden" class="attractionAddOnFlag" value="Add Ons" name="data[Attraction][Exchange_pricing]['+row+'][description]"/>';
	var flag = '<input type="hidden" class="attractionAddOnFlag" value="'+flag+'" name="data[Attraction][Exchange_pricing]['+row+'][flag]"/>';
	var flag_value = '<input type="hidden" class="attractionAddOnFlag" value="'+gross+'" name="data[Attraction][Exchange_pricing]['+row+'][flag_value]"/>';
	var net = '<input type="hidden" class="attractionAddOnFlag" value="'+net+'" name="data[Attraction][Exchange_pricing]['+row+'][net]"/>';
	var gross ='<input type="hidden" class="attractionAddOnFlag" value="'+old+'" name="data[Attraction][Exchange_pricing]['+row+'][gross]" exchange="Yes"/>';
	
	return name+desc+flag+flag_value+net+gross; 

}