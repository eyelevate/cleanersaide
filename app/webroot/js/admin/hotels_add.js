$(document).ready(function(){

/*
 * Hotels add page
 */
	//mask all of the inputs for phone numbers
	hotels.mask();
	
	//change the number format on specified input fields
	hotels.numberformat();
	
	//add datepicker to the selected form fields
	hotels.datepicker();
	
	hotels.events();

});

/**
 * All Functions with hotel form validation
 */
hotels = {
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
		$(".hotelAddOnPrice").priceFormat({'prefix':''});
		$('.hotelExtraFee').priceFormat({'prefix':''});
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
		$("#hotelStartingPrice").priceFormat({
			'prefix':'',
		});
		$(".hotelAddOnNet").priceFormat({
			'prefix':'',
		});
		$(".hotelAddOnMarkup").priceFormat({
			'prefix':'',
		});
		$(".hotelAddOnGross").priceFormat({
			'prefix':'',
		});
		$(".hotelPlusFeeNet").priceFormat({
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
		$("#Hotel_block0StartDate").datepicker().on('changeDate', function(ev){
  			$("#Hotel_block0StartDate").datepicker('hide');
		});
		$("#Hotel_block0EndDate").datepicker().on('changeDate', function(ev){
  			$('#Hotel_block0EndDate').datepicker('hide');
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
	events: function(){
		$("#hotel_name,#hotel_location").html(''); //clear the hotel name and hotel location fields on page refresh
		$(".hotelNameInput").val(''); //clear the hotel name inputs and location inputs on page refersh
		hotels.cityStateCountry('.cityInput','#stateInput','.countrySelect option'); //auto fill inputs based on city search
		hotels.series1check(); 
		
		//if a hotel url has been successfully created, then run the script for stepy form validation
		if($("#hotel").length ==1){
			hotels.stepy('#hotel');	
		}
		//on form creation this will make sure that the url is unique and validates any empty fields
		// if successful it will send a get to the same page to finish the hotel form, 1 for manual, 2 for automatic
		$("#buttonSeries1Next").click(function(){
			var name = $('.hotelNameInput').val();
			var location = $(".locationInput option:selected").val();
			var url = createUrl(location)+createUrl(name);
			var type_selected = $(".transactionTypeSelect option:selected").val();
			//validate scripts
			if(type_selected=='none'){ //if no hotel creation type is selected
				$(".transactionTypeSelect").parent().attr('class','control-group error');
				$(".transactionTypeSelect").parent().find('.help-inline').html('Reservation Transaction Handler must be selected');				
			} else { 
				$(".transactionTypeSelect").parent().attr('class','control-group');
				$(".transactionTypeSelect").parent().find('.help-inline').html('');			
			}
			if(location == ''){
				$(".locationInput").parent().attr('class','control-group error');
				$(".locationInput").parent().find('.help-inline').html('Error: Please provide a location.');			
			} else {
				$(".locationInput").parent().attr('class','control-group');
				$(".locationInput").parent().find('.help-inline').html('');			
			}
			if(name == ''){ //if hotel name field is empty
				$(".hotelNameInput").parent().attr('class','control-group error');
				$(".hotelNameInput").parent().find('.help-inline').html('Error: Please provide a hotel name.');
				$("#hotelUrlDiv").attr('class','control-group error');
				$("#hotelUrlDiv p").attr('class','alert alert-error');
				$("#hotelUrlDiv .help-block").html('Not a valid url');
			}
			if(name != '' && type_selected != 'none' && location != '') {	// if both name and hotel type is selected then run these scripts
				$(".transactionTypeSelect").parent().attr('class','control-group');
				$(".transactionTypeSelect").parent().find('help-inline').html('');
				$(".locationInput").parent().attr('class','control-group');
				$(".locationInput").parent().find('.help-inline').html('');		
				$(".hotelNameInput").parent().attr('class','control-group');
				$(".hotelNameInput").parent().find('.help-inline').html('');
				$("#hotelUrlDiv").attr('class','control-group');
				$("#hotelUrlDiv p").attr('class','well well-small muted');
				$("#hotelUrlDiv .help-block").html('');
				var url = createUrl(location)+createUrl(name);
				
				//check if the url created is valid
				hotels.checkHotelUrl(url);
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
		
		//checks if user wants to do room marketing, if checked then div will open up with all the hotel marketing fields
		$("#checkRoomMarketing").change(function(){
			if($(this).attr('checked')){
				$("#createHotelRoomMarketing").show();
				$("#roomsBadge").html('Hide');
				
				
			} else {
				$("#createHotelRoomMarketing").hide();
				$("#roomsBadge").html('Show');
			}
		});

		$("#company_info_validate").click(function(){hotels.companyInfoValidate()});
		
		$("#btnUpload").click(function(){
	    	var sendEmpty = $("#imageFindInput").val();
	    	var send = document.getElementById('imageFindInput');
	    	
	    	if (sendEmpty ==''){
	    		alert('Please select a photo from your directory.');
	    	} else {
	    		hotels.processFiles(send.files); 
	    	}
	
		});
		/**
		 * Hotel Block creation
		 */
		$("#addHotelBlockButton").click(function(){
			var row = $("#hotelBlocksTbody tr").length;
			var start_date = $("#hotelBlocksTbody tr:last-child .blockBeginDate").val();
			var end_date = $("#hotelBlocksTbody tr:last-child .blockEndDate").val();
			hotel_blocks.addBlock(row, start_date,end_date);
		});
		
		/**
		 * Hotel Room Creation Step 3 & 4 of wizard
		 */
		$("#createRoomFormButton").click(function(){
			var amount = $("#createRoomInput").val();
			$("#accordion4 .accordion-group").remove();
			hotel_rooms.validate(amount, '#createRoomFormDiv', '#accordion4');	
		});
		$("#addRoomRow").click(function(){
			var lastRows =  $("#roomTbody tr:last-child").attr('id').replace('roomTr-','');
			var newRow = parseInt(lastRows)+1;
			hotel_rooms.addRoomSchedule(newRow, '#roomTbody','#accordion4');
		});
		/**
		 * Hotel Add-on creation
		 */
		$("#hotelAddOnButton").click(function(){
			hotels.addOn();
		});		
		$(".hotelAddOnNet").keyup(function(){
			var country = $("#country").val();
			var element = $(this);
			switch(country){
				case '1':
				addScripts.addOnNetUs(element);
				break;
				
				case '2':
				addScripts.addOnNetCan(element);
				break;
			}
		});
		$(".hotelAddOnMarkup").keyup(function(){
			var country = $("#country").val();
			var element = $(this);
			switch(country){
				case '1':
				addScripts.addOnMarkupUs(element);
				break;
				
				case '2':
				addScripts.addOnMarkupCan(element);
				break;
			}
		});
		$(".hotelAddOnGross").keyup(function(){
			var country = $("#country").val();
			var element = $(this);
			switch(country){
				case '1':
				addScripts.addOnGrossUs(element);
				break;
				
				case '2':
				addScripts.addOnGrossCan(element);
				break;
			}
		});
		
		$(".deleteAddOn").click(function(){
			var country = $('#country').val();
			switch(country){
				case '1':				
					var addOn = blankTrUs();
				break;
				
				default:
					var addOn = blankTrCan();
				break;
			}
			$(this).parents('tr:first').remove();	
			var count = $(this).parents('tbody:first tr').length;
			if(count == 0){
				$(this).parents('tbody:first').append(addOn);	
			}
			
		});
		
		
		var country = $("#country").val();
		var element_net = $(".hotelAddOnNet");
		var element_markup = $(".hotelAddOnMarkup");
		var element_gross = $(".hotelAddOnGross");
		switch(country){
			case '1':
				
				addScripts.addOnNetUs(element_net);
				addScripts.addOnMarkupUs(element_markup);
				addScripts.addOnGrossUs(element_gross);
			break;
			
			default:

				addScripts.addOnNetCan(element_net);
				addScripts.addOnMarkupCan(element_markup);
				addScripts.addOnGrossCan(element_gross);			
			break;
		}
	},
	series1check: function(){
		$(".hotelNameInput").keyup(function(){
			var name = $(this).val();
			var url = createUrl(name);
			$("#hotel_name").html('');
			$(".hotelNameInput").parent().attr('class','control-group');
			$(".hotelNameInput").parent().find('.help-inline').html('');
			$("#hotelUrlDiv").attr('class','control-group');	
			$("#hotelUrlDiv p").attr('class','well well-small muted');	
			$("#hotelUrlDiv .help-block").html('');		
			$("#hotel_name").html(url);	
			$("#hotelUrlDiv").attr('name','notvalid');		
		});
		
		$(".locationInput").change(function(){
			var location = $('.locationInput option:selected').val();
			var url = createUrl(location);
			$("#hotel_location").html('');
			$(".locationInput").parent().attr('class','control-group');
			$(".locationInput").parent().find('.help-inline').html('');
			$("#hotelUrlDiv").attr('class','control-group');	
			$("#hotelUrlDiv p").attr('class','well well-small muted');	
			$("#hotelUrlDiv .help-block").html('');	
			$("#hotel_location").html(url);
			$("#hotelUrlDiv").attr('name','notvalid');	
		});
		
		$(".hotelNameInputEdit").keyup(function(){
			var name = $(this).val();
			var url = createUrl(name);
			$("#hotel_name_edit").html('');
			$(".hotelNameInputEdit").parent().attr('class','control-group');
			$(".hotelNameInputEdit").parent().find('.help-inline').html('');
			$("#hotelUrlDiv").attr('class','control-group');	
			$("#hotelUrlDiv p").attr('class','well well-small muted');	
			$("#hotelUrlDiv .help-block").html('');		
			$("#hotel_name_edit").html(url);	
			$("#hotelUrlDiv").attr('name','notvalid');		
		});
		
		$(".locationInputEdit").keyup(function(){
			var location = $(this).val();
			var url = createUrl(location);
			$("#hotel_location_edit").html('');
			$(".locationInputEdit").parent().attr('class','control-group');
			$(".locationInputEdit").parent().find('.help-inline').html('');
			$("#hotelUrlDiv").attr('class','control-group');	
			$("#hotelUrlDiv p").attr('class','well well-small muted');	
			$("#hotelUrlDiv .help-block").html('');	
			$("#hotel_location_edit").html(url);
			$("#hotelUrlDiv").attr('name','notvalid');	
		});
		//add validation scripts
		$(".hotelAddOnNet").blur(function(){
			var net = $(this).val();
			var exchange = $(this).parent().parent().parent().find('.hotelAddOnExchange').val();
			var gross = parseFloat(net)*parseFloat(exchange);
			var gross = gross.toFixed(2);
			var flag = 'No';
			$(this).parent().parent().parent().find('.hotelAddOnGross').attr('flag',flag);
			var row = $("input[exchange='Yes']").length;
			
			$(this).parent().parent().parent().find('.hotelAddOnGross').val(gross);
			$(this).parent().parent().parent().find('.hotelAddOnGross').attr('old',gross);
			$(this).parent().parent().parent().find('.hotelAddOnFlag').remove();
			var hiddenFields = getAddOnExchange(row,net,flag,exchange,gross,gross); 
			$(this).parent().parent().parent().find('.hotelAddOnGross').parent().append(hiddenFields);
			
		});
			
		$('.hotelAddOnGross').blur(function(){
			var gross = $(this).val();
			var old = $(this).attr('old');
			var net = $(this).parent().parent().parent().find('.hotelAddOnNet').val();
			var exchange = $(this).parent().parent().parent().find('.hotelAddOnExchange').val();
			// var row = $(this).attr('id').replace('hotelAddOnGross-','');
			
			// if(gross != old){
// 				
				// var flag = 'Yes';
				// $(this).attr('flag',flag);
				// var row = $("input[exchange='Yes']").length;
				// //add a new hidden input named flag
				// $(this).parent().find('.hotelAddOnFlag').remove();
				// // var hiddenFields = getAddOnExchange(row,net,flag,exchange,old,gross); 
				// // $(this).parent().append(hiddenFields);
// 				
			// }
		});
		
		//add Hotel Room Button
		$("#addHotelRoomButton").click(function(){
			var idx = $("#accordionRoomType .accordion-group:last-child").attr('idx');
			if(idx == ''){
				idx = 1;
			} else {
				var idx = parseFloat(idx)+1;	
			}
			
			var row = 0;
			
			hotel_rooms.addRoom(idx,row);
		});

	},

    cityStateCountry: function(cityInput, stateInput, countrySelect) { //function to return city and state
		$(cityInput).typeahead({
			source: function (query, process) {
		        labels = [];
		        $.getJSON('/hotels/getCities', function(data){
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
		   		$.post('/hotels/request',
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
	checkHotelUrl: function(url) {
		$.post(
			'/hotels/request',
			{
				type:'Check_Url',
				url:url
			},	function(result){
				switch(result){
					case 'taken':
						$(".hotelNameInput").parent().attr('class','control-group error');
						$(".hotelNameInput").parent().find('.help-inline').html('Error: Please select another hotel name.');
						$("#hotelUrlDiv").attr('class','control-group error');	
						$("#hotelUrlDiv p").attr('class','alert alert-error');	
						$("#hotelUrlDiv").attr('name','notvalid');	
					break;
					
					case 'available':

						$("#hotelUrlDiv").attr('class','control-group success');	
						$("#hotelUrlDiv p").attr('class','alert alert-success');
						$("#hotelUrlDiv").attr('name','valid');	
						var getUrl = '/hotels'+$("#hotel_location").html()+''+$("#hotel_name").html();
						var type = $(".transactionTypeSelect option:selected").val();					
						//insert into form
						$("#hotel_url").val(getUrl);
						$("#hotel_type").val(type);
						//submit form
						$("#hotel_basic_form").submit();
					break;	
					
				}
			}
		);	
	},

	stepy: function(name){
		$(name).stepy({
		 	back: function(index) {
				$("#toTopHover").click();

				if(index ==2){//moving out of step 3
					var addOnLength = $('#hotelAddOnTbody tr').length;
					if(addOnLength ==0){
						var country = $("#country").val();
						switch(country){
							case '1':
							var addOnTbody = blankTrUs();
							break;
							
							default:
							var addOnTbody = blankTrCan();
							break;
						}
						//add in a new row
						$("#hotelAddOnTbody").append(addOnTbody);
						hotels.numberformat();
					}
				}
			}, 
			next: function(index) {
				$("#toTopHover").click();
				if(index ==2){ //moving out of step 1
					var location = $(".countrySelect").val();
					
					switch(location){
						
						case '1': //united states form
							//
								
						
						break;
						
						case '2': //canadian form
						
						break;
					}
				}
				
				
				
				if(index ==3){ //moving out of step 2
					$("#hotelBlocksTbody tr").each(function(){
						var emptyBlock = $(this).find('.hotelBlockQuantity').val();
						
						if(emptyBlock == ''){
							$(this).remove();
						}
					});
					$("#hotelAddOnTbody tr").each(function(){
						var emptyAddOn = $(this).find('#hotelAddOnTitle').val();
						if(emptyAddOn == ''){
							$(this).remove();
						}
					});
				}
				if(index ==4){ //move out of step 3
					//check for errors
					var errors = 0;
					//check each hotel room name
					$("#accordionRoomType .hotelRoomName").each(function(){
						var name = $(this).val();
						
						if(name == ''){
							errors = errors +1;
							$(this).parent().parent().attr('class','control-group error');
							$(this).parent().parent().find('.help-inline').html('Error: Hotel name cannot be left empty. Please enter a valid room name');
						} else {
							$(this).parent().parent().attr('class','control-group');
							$(this).parent().parent().find('.help-inline').html('');
						}
					});
					//check each hotel room base
					$("#accordionRoomType .hotelOccupancyBase").each(function(){
						var base = $(this).val();
						
						if (base ==''){
							errors = errors +1;
							$(this).parent().parent().parent().attr('class','control-group error');
							$(this).parent().parent().parent().find('.help-inline').html('Error: Hotel base occupancy cannot be left empty. Please enter a valid room name');							
						} else {
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-inline').html('');
						}
					});
					//check each hotel room max
					$("#accordionRoomType .hotelOccupancyMax").each(function(){
						var max = $(this).val();
						
						if (max ==''){
							errors = errors +1;
							$(this).parent().parent().parent().attr('class','control-group error');
							$(this).parent().parent().parent().find('.help-inline').html('Error: Hotel max occupancy cannot be left empty. Please enter a valid room name');							
						} else {
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-inline').html('');
						}						
					});
					//check each extra person fee
					$("#accordionRoomType .hotelExtraFee").each(function(){
						var extra = $(this).val();
						
						if (extra ==''){
							errors = errors +1;
							$(this).parent().parent().parent().attr('class','control-group error');
							$(this).parent().parent().parent().find('.help-inline').html('Error: Hotel extra person fee cannot be left empty. Please enter a valid room name');							
						} else {
							$(this).parent().parent().parent().attr('class','control-group');
							$(this).parent().parent().parent().find('.help-inline').html('');
						}						
					});
					
					//count errors, if more than 0 then go back, else move on
					if(errors >0) {
						//alert('errors are commited')
						
						hotels.errors();
					}
					
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
				'data[Hotel][address]':'required',
				'data[Hotel][city]':'required',
				'data[Hotel][state]':'required',
				'data[Hotel][zipcode]':'required',
				'data[Hotel][country]':'required',
				'data[Hotel][phone]':'required',
				'data[Hotel][billing_address]':'required',
				'data[Hotel][billing_city]':'required',
				'data[Hotel][billing_state]':'required',
				'data[Hotel][billing_zip]':'required',
				'data[Hotel][billing_country]':'required',
				'data[Hotel][shuttle_service]':'required',
				'data[Hotel][reservation_cutoff]':'required',
				'data[Hotel][reservation_cutoff_units]':'required',
				'data[Hotel][max_age_free]':'required'

			}, messages: {
				'data[Hotel][address]': {required: 'This field is required!'},
				'data[Hotel][city]': {required: 'This field is required!'},
				'data[Hotel][state]': {required: 'This field is required!'},
				'data[Hotel][zipcode]':{required: 'This field is required!'},
				'data[Hotel][country]':{required: 'This field is required!'},
				'data[Hotel][phone]': {required: 'This field is required!'},
				'data[Hotel][billing_address]':{required: 'This field is required!'},
				'data[Hotel][billing_city]':{required: 'This field is required!'},
				'data[Hotel][billing_state]':{required: 'This field is required!'},
				'data[Hotel][billing_zip]':{required: 'This field is required!'},
				'data[Hotel][billing_country]':{required: 'This field is required!'},
				'data[Hotel][shuttle_service]':{required: 'This field is required'},
				'data[Hotel][reservation_cutoff]':{required: 'This field is required'},
				'data[Hotel][reservation_cutoff_units]':{required: 'This field is required'},
				'data[Hotel][max_age_free]':{required: 'This field is required'},
				

			},
			//ignore : ':hidden'
		});
	}, 
	errors: function(){
		setTimeout(function () {$("#hotel-back-3").click(); }, 100);
	},
	addOn: function(){
		
		//determine where the location is, its either us or can
		var country = $("#country").val();
		switch(country){
			case '1': //us
				
				//set the initial variables, check to see what radio the user has selected before cloning
				var addOnRadioSelected = 'data[Hotel][add_ons][0][per_basis]';
				var addOnChecked = $("#hotelAddOnTbody tr:first-child input[name='"+addOnRadioSelected+"']:checked").val();
				
				
				//remove all the values in the new cloned tr
				$("#hotelAddOnTr-0").clone().insertAfter("#hotelAddOnTbody tr:last-child");
				$("#hotelAddOnTbody tr:last-child").find('#hotelAddOnTitle').val('');
				$("#hotelAddOnTbody tr:last-child").find('.hotelAddOnPrice').val('');
				var element_net = $("#hotelAddOnTbody tr:last").find('.hotelAddOnNet');
				var element_markup = $("#hotelAddOnTbody tr:last").find(".hotelAddOnMarkup");
				//var element_exchange = $("#hotelAddOnTbody tr:last-child #hotelAddOnExchange");
				var element_gross = $("#hotelAddOnTbody tr:last").find('.hotelAddOnGross');
				var element_delete =$("#hotelAddOnTbody tr:last").find('.deleteAddOn');
				
				addScripts.numberFormat(element_net);
				addScripts.numberFormat(element_markup);
				addScripts.numberFormat(element_gross);
				addScripts.addOnNetUs(element_net);
				addScripts.addOnMarkupUs(element_markup);
				addScripts.addOnGrossUs(element_gross);
				addScripts.addOnDelete(element_delete);
				//reinsert selected radio back into th first child
				$("#hotelAddOnTbody tr:first-child").find('input[value="'+addOnChecked+'"]').attr('checked','checked');
		
				//rename all of the rows and input names
				$("#hotelAddOnTbody tr").each(function(row){
					//create the name attributes
					var class1 = 'hotelAddOnTr-'+row;
					var class2 = 'data[Hotel][add_ons]['+row+'][title]';
					var class3 = 'data[Hotel][add_ons]['+row+'][net]';
					var class4 = 'data[Hotel][add_ons]['+row+'][per_basis]';
					//insert new attributes with a for each loop (in case some rows have been deleted renumber your array)
					$(this).attr('id',class1);
					$(this).find('#hotelAddOnTitle').attr('name',class2);
					$(this).find('.hotelAddOnNet').attr('name',class3);
					$(this).find('#hotelAddOnPerBasis-onetime').attr('name',class4);
					$(this).find("#hotelAddOnPerBasis-pernight").attr('name',class4);
		
				});

			break;
			
			case '2': //can
				//set the initial variables, check to see what radio the user has selected before cloning
				var addOnRadioSelected = 'data[Hotel][add_ons][0][per_basis]';
				var addOnChecked = $("#hotelAddOnTbody tr:first-child input[name='"+addOnRadioSelected+"']:checked").val();
				var exchange = $("#exchange").val();
				//remove all the values in the new cloned tr
				$("#hotelAddOnTr-0").clone().insertAfter("#hotelAddOnTbody tr:last-child");
				
				$("#hotelAddOnTbody tr:last-child").find('#hotelAddOnTitle').val('');
				$("#hotelAddOnTbody tr:last-child").find('.hotelAddOnNet').val('');
				$("#hotelAddOnTbody tr:last-child").find('.hotelAddOnMarkup').val('');
				$("#hotelAddOnTbody tr:last-child").find('.hotelAddOnGross').val('');
				$("#hotelAddOnTbody tr:last-child").find('.hotelAddOnGross').attr('old','');

				
				//reinsert selected radio back into th first child
				$("#hotelAddOnTbody tr:first-child").find('input[value="'+addOnChecked+'"]').attr('checked','checked');
		
				//rename all of the rows and input names
				$("#hotelAddOnTbody tr").each(function(idx){
					//create the name attributes
					var class1 = 'hotelAddOnTr-'+idx;
					var class2 = 'data[Hotel][add_ons]['+idx+'][title]';
					var class3 = 'data[Hotel][add_ons]['+idx+'][net]';
					var class4 = 'data[Hotel][add_ons]['+idx+'][exchange]';
					var class5 = 'data[Hotel][add_ons]['+idx+'][markup]';
					var class6 = 'data[Hotel][add_ons]['+idx+'][gross]';
					var class7 = 'data[Hotel][add_ons]['+idx+'][per_basis]';
					//insert new attributes with a for each loop (in case some rows have been deleted renumber your array)
					$(this).attr('id',class1);
					$(this).find('#hotelAddOnTitle').attr('name',class2);
					$(this).find('.hotelAddOnNet').attr('name',class3);
					$(this).find('.hotelAddOnNet').attr('id','hotelAddOnNet-'+idx);
					$(this).find('.hotelAddOnExchange').attr('name',class4);
					$(this).find('.hotelAddOnMarkup').attr('name',class5);	
					$(this).find('.hotelAddOnGross').attr('name',class6);
					$(this).find('.hotelAddOnGross').attr('id','hotelAddOnGross-'+idx);
					$(this).find('#hotelAddOnPerBasis-onetime').attr('name',class7);
					$(this).find("#hotelAddOnPerBasis-pernight").attr('name',class7);
		
				});
			
				//add number formattting
				var element_net = $("#hotelAddOnTbody tr:last-child").find('.hotelAddOnNet');
				var element_markup = $("#hotelAddOnTbody tr:last-child").find('.hotelAddOnMarkup');
				var element_exchange = $("#hotelAddOnTbody tr:last-child").find('.hotelAddOnExchange');
				var element_gross = $("#hotelAddOnTbody tr:last-child").find('.hotelAddOnGross');
				var element_delete =$("#hotelAddOnTbody tr:last").find('.deleteAddOn');
				
				addScripts.numberFormat(element_net);
				addScripts.numberFormat(element_markup);
				addScripts.numberFormat(element_gross);	
				addScripts.addOnNetCan(element_net);	
				addScripts.addOnMarkupCan(element_markup);
				addScripts.addOnGrossCan(element_gross);
				addScripts.addOnDelete(element_delete);			

			break;
		}
	} 
}
hotel_blocks = {
	addBlock: function(row,start, end) {
		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
		var blockVal = $('#hotelBlocksTbody tr:last-child .hotelBlockQuantity').val();
		var blockVal = parseInt(blockVal);
		var intRegex = /^\d+$/;
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();

		if(start == ''){
			//add errors
			$('#hotelBlocksTbody tr:last-child .blockBeginDate').parent().attr('class','control-group pull-left error');
			$('#hotelBlocksTbody tr:last-child .blockBeginDate').parent().find('.help-block').html('You must choose an start date');			
		} else {
			$('#hotelBlocksTbody tr:last-child .blockBeginDate').parent().attr('class','control-group pull-left');
			$('#hotelBlocksTbody tr:last-child .blockBeginDate').parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#hotelBlocksTbody tr:last-child .blockEndDate').parent().attr('class','control-group error');
			$('#hotelBlocksTbody tr:last-child .blockEndDate').parent().find('.help-block').html('You must choose an end date');
		} else {
			$('#hotelBlocksTbody tr:last-child .blockEndDate').parent().attr('class','control-group controls');
			$('#hotelBlocksTbody tr:last-child .blockEndDate').parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#hotelBlocksTbody tr:last-child .blockEndDate').parent().attr('class','control-group pull-left error');
				$('#hotelBlocksTbody tr:last-child .blockEndDate').parent().find('.help-block').html('End date must be greater than start date');					
			} else {
				$('#hotelBlocksTbody tr:last-child .blockEndDate').parent().attr('class','control-group pull-left');
				$('#hotelBlocksTbody tr:last-child .blockEndDate').parent().find('.help-block').html('');				
			}
			
		} 
		if(!intRegex.test(blockVal) || intRegex.test(blockVal) <=0) { //checks if number
			$('#hotelBlocksTbody tr:last-child .hotelBlockQuantity').parent().parent().attr('class','control-group pull-left error');
			$('#hotelBlocksTbody tr:last-child .hotelBlockQuantity').parent().parent().find('.help-block').html('You must put in a valid block quantity');
			
		} else {
			$('#hotelBlocksTbody tr:last-child .hotelBlockQuantity').parent().parent().attr('class','control-group pull-left');
			$('#hotelBlocksTbody tr:last-child .hotelBlockQuantity').parent().parent().find('.help-block').html('');			
		}
		//sucess now send
		if(start != '' && end != '' && startCheck < endCheck && intRegex.test(blockVal) && intRegex.test(blockVal) >0) {
			//remove errors
			$('#hotelBlocksTbody tr:last-child .hotelBlockQuantity').parent().parent().attr('class','control-group pull-left');
			$('#hotelBlocksTbody tr:last-child .hotelBlockQuantity').parent().parent().find('.help-block').html('');
			//add new block form
			var block = hotelBlock(row,newDateString);
			$('#hotelBlocksTbody').append(block);	
			hotel_blocks.addScripts(row);
		}
		
	}, 
	addScripts: function(row){
		$("#HotelBlocks"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$("#HotelBlocks"+row+"StartDate").datepicker('hide');
		});

		$("#HotelBlocks"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$("#HotelBlocks"+row+"EndDate").datepicker('hide');
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
hotel_rooms = {
	validate: function(num, errorClass, createRoomMarketingClass){
		if(num == '' || num =='0'){
			$(errorClass).attr('class','control-group error');
			$(errorClass+' .help-block').html('Error: You must enter a valid room amount');
		} else {
			$(errorClass).attr('class','control-group');
			$(errorClass+' .help-block').html('');	
			$("#accordionRoomType").empty();
			hotel_rooms.create(num, '#accordionRoomType',createRoomMarketingClass);	
			$("#createRoomAccordion2").show();
			$("#accordionGroup2").click();
		}
	}, 
	create: function(num, createClass, createRoomMarketingClass){

		//create the necessary variables
		var row = 0; //states that this is the first row
		var location = $(".countrySelect option:selected").val(); //location is used to determine what type of hotel room form we are using
		
		//loop through the total amount of rooms we are creating
		for (var i=0; i < num; i++) {
			//based on the location switch the variables
			switch(location){
				case '1': //This is US Add Ons
					var get_addOns = addOnsUs(i);
					var newRow = newRoomUs(i, get_addOns);
				break;
				
				case '2': //This is CAN Add Ons
					var get_addOns = addOnsCan(i);
					var newRow = newRoomCan(i, get_addOns);
				break;
			}
			//create the room marketing scripts as well
			var roomMarketing = newRoomMarketing(i);
			
			//append the newly created hotel room rows based on the variables set above
			$(createClass).append(newRow);
			//hide the room marketing paragraph
			$("#formRoomMarketing p").hide();
			
			//add the room marketing scripts on the next step
			$(createRoomMarketingClass).append(roomMarketing);
			
			//add all of the necessary scripts needed to make hotel rooms work
			hotel_rooms.addScripts(i, row);	

		};
	}, 
	addRoom: function(idx, row){
		var location = $(".countrySelect option:selected").val(); //location is used to determine what type of hotel room form we are using
		//based on the location switch the variables
		switch(location){
			case '1': //This is US Add Ons
				var get_addOns = addOnsUs(idx);
				var newRow = newRoomUs(idx, get_addOns);
			break;
			
			case '2': //This is CAN Add Ons
				var get_addOns = addOnsCan(idx);
				var newRow = newRoomCan(idx, get_addOns);
			break;
		}
		//create the room marketing scripts as well
		var roomMarketing = newRoomMarketing(idx);
		
		//append the newly created hotel room rows based on the variables set above
		$("#accordionRoomType").append(newRow);
		//hide the room marketing paragraph
		$("#formRoomMarketing p").hide();
		
		//add the room marketing scripts on the next step
		$("#accordion4").append(roomMarketing);
		
		//add all of the necessary scripts needed to make hotel rooms work
		hotel_rooms.addScripts(idx, row);		
		
	},

	addRoomSchedule: function(num,row, createClass, createRoomMarketingClass){
		var newRow = newRoom(num);			
		var roomMarketing = newRoomMarketing(num);

		$(createClass).append(newRow);
		$("#formRoomMarketing p").hide();
		$(createRoomMarketingClass).append(roomMarketing);	
		hotel_rooms.addScripts(num, row);
	}, 
	addScripts: function(idx, row){
		//plugin scripts
		hotels.numberformat();
		$("#HotelRoom"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#HotelRoom"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#HotelRoom"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$("#HotelRoom"+idx+"Inventory"+row+"StartDate").datepicker('hide');
		});
		$("#HotelRoom"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$("#HotelRoom"+idx+"Inventory"+row+"EndDate").datepicker('hide');
		});
		$(".blockBeginDate").datepicker().on('changeDate', function(ev){
  			$('.blockBeginDate').datepicker('hide');
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
		$("#fullYear-"+idx).datepicker().change(function() {
			var date = $(this).val();
			$('.datepicker td .day').css({'background-color':'red'});
			hotel_rooms.editSelect(date,idx,row, '#blackoutDatesUl-'+idx,'#blackoutDateCounter-'+idx);
			//$('#fullYear-'+idx).datepicker('hide');
		});
		
		//accordion room click to top page
		$("#collapseTwo2 .accordion-toggle").click(function(){
			$("#toTop").click();
			//focus on the name
			$(this).parent().parent().find('.hotelRoomName').focus();
		});
		
		//new room 
		$("#addRoomInventory-"+idx).click(function(){
			var row = $("#roomInventoryTbody-"+idx+" tr").length;
			var newRow = parseInt(row);
			var startDate = $('#roomInventoryTbody-'+idx+' tr:last-child .blockBeginDate').val();
			var endDate = $('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').val();
			var blockClass = $(this).parent().parent().attr('id');
			var blockVal = $('#roomInventoryTbody-'+idx+' tr:last-child .roomBlockQuantity').val();
			var total = $("#roomInventoryTbody-"+idx+" tr:last-child .roomBlockTotal").val();
			
			hotel_rooms.addInventory(idx,newRow,total,blockVal, startDate, endDate);
			
		});	
		//remove room
		$("#removeRoomButton-"+idx).click(function(){
			if(confirm('Are you sure you want to delete hotel room?')){
				
				//remove from step 3
				$(this).parent().parent().parent().parent().parent().remove();		
				//remove marketing from step 4
				$("#marketingRoom-"+idx).remove();
					
			}
			
				
		});
		//addInventory change
		$('.addOnCheckList').change(function(){
			var row = $(this).parent().parent().parent().attr('num');
			var idx = $(this).parent().parent().parent().attr('idx');
			var checked = $(this).attr('checked');
			var title = 'data[Hotel_room]['+row+'][add_ons]['+idx+'][title]';
			var price = 'data[Hotel_room]['+row+'][add_ons]['+idx+'][price]';
			var per_basis = 'data[Hotel_room]['+row+'][add_ons]['+idx+'][per_basis]';
			if(checked =='checked'){
				//add the name
				$('#HotelRoom'+row+'AddOns'+idx+'Title').attr('name',title);
				$('#HotelRoom'+row+'AddOns'+idx+'Price').attr('name',price);
				$('#HotelRoom'+row+'AddOns'+idx+'PerBasis').attr('name',perbasis);
				
			} else {
				//remove the name
				$('#HotelRoom'+row+'AddOns'+idx+'Title').attr('name','');
				$('#HotelRoom'+row+'AddOns'+idx+'Price').attr('name','');
				$('#HotelRoom'+row+'AddOns'+idx+'PerBasis').attr('name','');			
			}
		});
		//marketing scripts
		$("#Hotel_room"+idx+"Name").blur(function(){
			var value = $(this).val();
			var row = $(this).attr('dataRow');
			if(value != ''){
				$('#roomTypeSpan-'+idx).html(value);
				$("#formRoomMarketing #hotelRoomName-"+idx).html(value);	
			}		
		});	
		$("#HotelRoom"+idx+"Status").change(function(){
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

			$("#roomTypeLabel-"+idx).html(badge);
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
		$("#Hotel_room"+idx+"Inventory"+row+"Net").keyup(function(){
			
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);	
					}	
				break;
				
				case '2': //can
					var net = $(this).val();
					var exchange = $("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val();
					var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}
			
		});
		//markup -> gross
		$("#Hotel_room"+idx+"Inventory"+row+"Markup").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);	
					}
				break;
				
				case '2': //can
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var exchange = $("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}

			
		});
		//gross -> markup
		$("#Hotel_room"+idx+"Inventory"+row+"Gross").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Markup").val(markup);	
					}
				break;
				
				case '2': //can
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var exchange = $("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Markup").val(markup);	
					}				
				
				break;
				
			}
		});	
		
		
		//canadian scripts
		$("#Hotel_room"+idx+"Net").blur(function(){
			
			var net = $(this).val();
			var exchange = $("#exchange").val();
			var gross = parseFloat(net)*parseFloat(exchange);
			var gross = gross.toFixed(2);
			var flag = 'No';
			$(this).attr('flag',"No");
			
			$(this).parent().parent().parent().parent().find(".hotelExtraFee").val(gross);	
			$(this).parent().parent().parent().parent().find(".hotelExtraFee").attr('old',gross);
			$(this).parent().parent().parent().parent().find('.hotelExtraFeeFlag').remove();
			var row = $('input[exchange="Yes"]').length;
			var hiddenFields = getExtraFeeExchange(idx,row,net,flag,exchange,gross,gross); 
			$(this).parent().parent().parent().parent().find("#Hotel_room"+idx+"PlusFee").parent().append(hiddenFields);			
				
			
		});
		
		$("#Hotel_room"+idx+"PlusFee").blur(function(){
			
			var net = $(this).val();
			var exchange =$("#exchange").val();
			var gross =	$(this).val();
			var old =	$(this).attr('old');

			if(old != gross){
				var flag = 'Yes';
				$(this).attr('flag','Yes');
				
				//add a new hidden input named flag
				$(this).parent().parent().parent().parent().find('.hotelExtraFeeFlag').remove();
				var row = $('input[exchange="Yes"]').length;
				var hiddenFields = getExtraFeeExchange(idx,row,net,flag,exchange,old,gross); 
				$(this).parent().parent().parent().parent().find("#Hotel_room"+idx+"PlusFee").parent().append(hiddenFields);	
			}
		});
		
		//change status
		$("#Hotel_room"+idx+"Inventory"+row+"ChangeCurrency").click(function(){
			//var check status
			var status = $(this).attr('status');
			
			switch(status){
				case 'canusd':
					//var old = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					//$(this).attr('old',old);
					
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					//var gross = $("#Hotel_room"+idx+"Inventory"+row+"Gross").val();
					var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
					var exchange = 1;
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','usdcan');
					$(this).parent().find("#dollarSignSpan").html("US$");
					$("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val('1.0000');
					$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);
				break;
				
				case 'usdcan':
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
					var exchange = $("#exchange").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val(exchange);
					$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);				
				break;
			}
		});

	}, 
	addInventory:function(idx,row,total, blockVal,start, end){		
		//get last date
		var thisDate = new Date(end);
		var newDate = new Date(thisDate.getFullYear(), thisDate.getMonth(), thisDate.getDate()+1); // add one day
		var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
		var startCheck = parseInt(start.replace(regExp, "$3$1$2"));
		var endCheck = parseInt(end.replace(regExp, "$3$1$2"));
		var blockVal = parseInt(blockVal);
		var total = parseInt(total);
		var intRegex = /^\d+$/;
		//validate block form make sure all the data is right
		var newDateString = (('0'+(newDate.getMonth()+1)).substr(-2))+'/'+('0'+newDate.getDate()).substr(-2)+'/'+ newDate.getFullYear();
		if(start == ''){
			//add errors
			$('#roomInventoryTbody-'+idx+' tr:last-child .blockBeginDate').parent().parent().attr('class','control-group error');
			$('#roomInventoryTbody-'+idx+' tr:last-child .blockBeginDate').parent().parent().find('.help-block').html('You must choose an start date');			
		} else {
			//remove errors
			$('#roomInventoryTbody-'+idx+' tr:last-child .blockBeginDate').parent().parent().attr('class','control-group');
			$('#roomInventoryTbody-'+idx+' tr:last-child .blockBeginDate').parent().parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group error');		
			$('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('You must choose an end date');	
		} else {
			//remove errors
			$('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group');
			$('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group error');
				$('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
			} else {
				//remove errors
				$('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group');
				$('#roomInventoryTbody-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
			}
			
		} 
		if(!intRegex.test(total) || intRegex.test(total) <=0) { //checks if number
			$('#roomInventoryTbody-'+idx+' tr:last-child .roomBlockTotal').parent().parent().attr('class','control-group error');
			$('#roomInventoryTbody-'+idx+' tr:last-child .roomBlockTotal').parent().parent().find('.help-block').html('You must put in a valid quantity');
			
		} else {
			if(intRegex.test(total) && intRegex.test(blockVal) && total < blockVal){
				$('#roomInventoryTbody-'+idx+' tr:last-child .roomBlockTotal').parent().parent().attr('class','control-group error');
				$('#roomInventoryTbody-'+idx+' tr:last-child .roomBlockTotal').parent().parent().find('.help-block').html('Available rooms cannot be less than block amount');				
			} else {
				$('#roomInventoryTbody-'+idx+' tr:last-child .roomBlockTotal').parent().parent().attr('class','control-group');
				$('#roomInventoryTbody-'+idx+' tr:last-child .roomBlockTotal').parent().parent().find('.help-block').html('');				
			}
			
		}		

		//sucess now send
		if(start != '' && end != '' && startCheck <= endCheck && intRegex.test(total)) {
			var taxRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryTaxRate").val();
			var netRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryNetRate").val();
			var grossRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryGrossRate").val();
			var markupRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryMarkupRate").val();
			var available = $("#roomInventoryTbody-"+idx+" tr:first-child .roomBlockTotal").val();
			var location = $(".countrySelect option:selected").val();
			
			switch(location){
				case '1':
					var block = newRoomBlockUs(idx, row, newDateString, netRate, grossRate, markupRate,available);	
				break;
				
				case '2':
					var exRate = $("#exchange").val();
					var block = newRoomBlockCan(idx, row, newDateString, exRate, netRate, grossRate, markupRate,available);
				break;
			}
			
			$("#roomInventoryTbody-"+idx).append(block);
			hotel_rooms.addInventoryScripts(idx, row, block);
		}
	}, 
	addInventoryScripts: function(idx, row, date){
		//plugin scripts
		hotels.numberformat();
		$("#HotelRoom"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#HotelRoom"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#HotelRoom"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$("#HotelRoom"+idx+"Inventory"+row+"StartDate").datepicker('hide');
		});
		$("#HotelRoom"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$("#HotelRoom"+idx+"Inventory"+row+"EndDate").datepicker('hide');

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
		$("#Hotel_room"+idx+"Inventory"+row+"Net").keyup(function(){
			
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);	
					}	
				break;
				
				case '2': //can
					var net = $(this).val();
					var exchange = $("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val();
					var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}
			
		});
		//markup -> gross
		$("#Hotel_room"+idx+"Inventory"+row+"Markup").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);	
					}
				break;
				
				case '2': //can
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var exchange =$("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}

			
		});
		//gross -> markup
		$("#Hotel_room"+idx+"Inventory"+row+"Gross").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Markup").val(markup);	
					}
				break;
				
				case '2': //can
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var exchange = $("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Hotel_room"+idx+"Inventory"+row+"Markup").val(markup);	
					}				
				
				break;
				
			}
			
		});	
		//change status
		$("#Hotel_room"+idx+"Inventory"+row+"ChangeCurrency").click(function(){
			//var check status
			var status = $(this).attr('status');
			
			switch(status){
				case 'canusd':
					//var old = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					//$(this).attr('old',old);
					
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					//var gross = $("#Hotel_room"+idx+"Inventory"+row+"Gross").val();
					var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
					var exchange = 1;
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','usdcan');
					$(this).parent().find("#dollarSignSpan").html("US$");
					$("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val('1.0000');
					$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);
				break;
				
				case 'usdcan':
					var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
					var exchange = $("#exchange").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross = gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val(exchange);
					$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);				
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
				'<input type="hidden" id="HotelRoom'+idx+'Blackout'+(count-1)+'Dates" name="data[Hotel_room]['+idx+'][blackout]['+(count-1)+'][dates]" value="'+date+'"/>'+
			'</li>';
		hotel_rooms.editCounter(count,idx,updateClass, updateCount);
		hotel_rooms.minusCounter(count,idx,updateClass,updateCount);
		
		//check to see where in place the new li should be, then append it
		hotel_rooms.insertBlackoutDates(idx,timestamp,updateClass,code_append);	
		
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
			    	$(this).attr('id','HotelRoom'+idx+'Blackout'+row+'Dates');
			    	$(this).attr('name','data[Hotel_room]['+idx+'][blackout]['+row+'][dates]');
			    });              
            });
     	});
 
 
	}
}
requests = {
	
}

addScripts = {
	numberFormat: function(element){

		element.priceFormat({
			'prefix':'',
		});
	},
	addOnNetCan: function(element){
		//add validation scripts
		element.blur(function(){
			var net = $(this).val();
			var markup = $(this).parents('tr:first').find('.hotelAddOnMarkup').val();
			var markup = 1+(parseFloat(markup)) / 100;
			var exchange = $(this).parent().parent().parent().find('.hotelAddOnExchange').val();
			var gross = (parseFloat(net)*parseFloat(exchange) * parseFloat(markup)) * 100;
			var gross = Math.round(gross) / 100;
			var gross = gross.toFixed(2);

			
			$(this).parent().parent().parent().find('.hotelAddOnGross').val(gross);
			$(this).parent().parent().parent().find('.hotelAddOnGross').attr('old',gross);
			$(this).parent().parent().parent().find('.hotelAddOnFlag').remove();

			
		});		
	},
	addOnMarkupCan: function(element){
		//add validation scripts
		element.blur(function(){
			var markup = 1+(parseFloat($(this).val()) / 100);
			var net = $(this).parents('tr:first').find('.hotelAddOnNet').val();
			var exchange = $(this).parents('tr:first').find('.hotelAddOnExchange').val();
			var gross = (parseFloat(net)*parseFloat(exchange)*parseFloat(markup))* 100;
			var gross = Math.round(gross) / 100;
			var gross = gross.toFixed(2);
			
			$(this).parents('tr:first').find('.hotelAddOnGross').val(gross);

			
		});				
	},
	addOnGrossCan: function(element){
		element.blur(function(){
			var gross = parseFloat($(this).val());
			var net = parseFloat($(this).parents('tr:first').find('.hotelAddOnNet').val());
			var exchange = parseFloat($(this).parents('tr:first').find('.hotelAddOnExchange').val());
			
			var markup = gross / exchange / net;
			
			var markup = (markup - 1) * 100 * 100;
			var markup = Math.round(markup) / 100;
			var markup = markup.toFixed(2);
			
			$(this).parents('tr:first').find('.hotelAddOnMarkup').val(markup);				
		});		
	},
	addOnNetUs: function(element){
		//add validation scripts
		element.blur(function(){
			var net = $(this).val();
			var markup = $(this).parents('tr:first').find('.hotelAddOnMarkup').val();
			var markup = 1+(parseFloat(markup) / 100);
			var gross = (parseFloat(net)*parseFloat(markup))* 100;
			var gross = Math.round(gross) / 100;
			var gross = gross.toFixed(2);

			
			$(this).parent().parent().parent().find('.hotelAddOnGross').val(gross);
			$(this).parent().parent().parent().find('.hotelAddOnGross').attr('old',gross);
			$(this).parent().parent().parent().find('.hotelAddOnFlag').remove();

			
		});		
	},
	addOnMarkupUs: function(element){
		//add validation scripts
		element.blur(function(){
			var markup = 1+(parseFloat($(this).val()) / 100);
			var net = $(this).parents('tr:first').find('.hotelAddOnNet').val();
			var gross = (parseFloat(net)*parseFloat(markup))* 100;
			var gross = Math.round(gross) / 100;
			var gross = gross.toFixed(2);
			
			$(this).parents('tr:first').find('.hotelAddOnGross').val(gross);

			
		});				
	},
	addOnGrossUs: function(element){
		element.blur(function(){
			var gross = parseFloat($(this).val());
			var net = parseFloat($(this).parents('tr:first').find('.hotelAddOnNet').val());
			var markup = gross / net;
			
			var markup = (markup - 1) * 100 * 100;
			var markup = Math.round(markup) / 100;
			var markup = markup.toFixed(2);
			
			$(this).parents('tr:first').find('.hotelAddOnMarkup').val(markup);	
		});		
	},
	addOnDelete: function(element){
		element.click(function(){
			var country = $('#country').val();
			switch(country){
				case '1':				
					var addOn = blankTrUs();
				break;
				
				default:
					var addOn = blankTrCan();
				break;
			}
			$(this).parents('tr:first').remove();	
			var count = $(this).parents('tbody:first tr').length;
			if(count == 0){
				$(this).parents('tbody:first').append(addOn);	
			}
			
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

