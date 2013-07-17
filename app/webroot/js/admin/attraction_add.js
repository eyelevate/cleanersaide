$(document).ready(function(){

/*
 * Attractions add page
 */
	
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
	
	//form events
	attractions.form_events();
	
 
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

	stepy: function(name){
		$(name).stepy({
		 	back: function(index) {
		 		//if back buton clicked then click to top
				$("#toTopHover").click();
 
				if(index ==2){//moving out of step 3
				}
			}, next: function(index) {
				$("#toTopHover").click();
				if(index ==3){ //moving out of step 2
				}
				if(index ==4){ //move out of step 3

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
	form_events: function(){
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
		// var row = 0;
		// for (var i=0; i < num; i++) {
			// var country = $(".countrySelect option:selected").val();
// 			
			// switch(country){
				// case '1':
					// var get_addOns = addOnsUs(i);
					// var newRow = newTicketUs(i, get_addOns);			
					// var ticketMarketing = newTicketMarketing(i);	
// 			
				// break;
// 				
				// case '2':
					// var get_addOns = addOnsCan(i);
					// var newRow = newTicketCan(i, get_addOns);			
					// var ticketMarketing = newTicketMarketing(i);			
				// break;
			// }
			// $(createClass).append(newRow);
			// $("#formTicketMarketing p").hide();
			// $(createTicketMarketingClass).append(ticketMarketing);
// 
			// attraction_tickets.addScripts(i, row);	
		// };
		
		$.post(
			'/attractions/get_us_tour',
			{
				content:1,
			},	function(results){
				alert(results);
			}
		);		
	},
}
