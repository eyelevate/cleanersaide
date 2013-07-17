$(document).ready(function(){

/*
 * Hotels Edit page
 */

	$("#hotel_name,#hotel_location").html(''); //clear the hotel name and hotel location fields on page refresh
	$(".hotelNameInput").val(''); //clear the hotel name inputs and location inputs on page refersh
	hotels.cityStateCountry('.cityInput','#stateInput','.countrySelect option'); //auto fill inputs based on city search
	hotels.events();
	hotels.series1check(); 
	
	//if a hotel url has been successfully created, then run the script for stepy form validation
	if($("#hotel").length ==1){
		hotels.stepy('#hotel');	
	}
	
	//mask all of the inputs for phone numbers
	hotels.mask();
	
	//change the number format on specified input fields
	hotels.numberformat();
	
	//add datepicker to the selected form fields
	hotels.datepicker();
	
	
	//on form creation this will make sure that the url is unique and validates any empty fields
	// if successful it will send a get to the same page to finish the hotel form, 1 for manual, 2 for automatic
	$("#buttonSeries1Next").click(function(){
		var name = $('.hotelNameInputEdit').val();
		var location = $(".locationInputEdit").val();
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
		if(name == ''){ //if hotel name field is empty
			$(".hotelNameInput").parent().attr('class','control-group error');
			$(".hotelNameInput").parent().find('.help-inline').html('Error: Please provide a hotel name.');
			$("#hotelUrlDiv").attr('class','control-group error');
			$("#hotelUrlDiv p").attr('class','alert alert-error');
			$("#hotelUrlDiv .help-block").html('Not a valid url');
		}
		if(name != '' && type_selected != 'none') {	// if both name and hotel type is selected then run these scripts
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
	
	$(".addRoomInventory").click(function(){
		var room_id = $(this).attr('room');
		var room_length = $("#roomInventoryTbody-"+room_id+" tr").length;
		var start_date = $("#roomInventoryTbody-"+room_id+" tr:last-child .blockBeginDate").val();
		var end_date = $("#roomInventoryTbody-"+room_id+" tr:last-child .blockEndDate").val();
		var total = $("#roomInventoryTbody-"+room_id+" tr:last-child .roomBlockTotal").val();
		hotel_rooms.addInventory(room_id,room_length, total, start_date, end_date);
	});
//accordion room click to top page
	$("#collapseTwo2 .accordion-toggle").click(function(){
		$("#toTop").click();
		//focus on the name
		$(this).parent().parent().find('.hotelRoomName').focus();
	});
	

	//marketing scripts
	$(".hotelRoomName").blur(function(){
		var value = $(this).val();
		var row = $(this).attr('dataRow');
		if(value != ''){
			$('#roomTypeSpan-'+row).html(value);
			$("#formRoomMarketing #hotelRoomName-"+row).html(value);	
		}		
	});	
	//net rate creation
	$('.netRate').keyup(function(){
		var netRate = $(this).val();
		
		$("#roomInventoryTbody-"+idx+" .inventoryNetRate").val(netRate);
		$("#roomInventoryTbody-"+idx+" .inventoryMarkupRate").val('0.00');
		$("#roomInventoryTbody-"+idx+" .inventoryGrossRate").val(netRate);
	});			
	//tax rate creation

	//markup keyup function
	//net->gross
	$(".inventoryNetRate").keyup(function(){
		var idx = $(this).attr('dataRow');
		var row = $(this).attr('row');
		var net = $(this).val();
		var markup = $("#Hotel_room"+idx+"Inventory"+row+"Markup").val();
		var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
		var gross =gross.toFixed(2);	

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
	$(".inventoryMarkupRate").keyup(function(){
		var idx = $(this).attr('dataRow');
		var row = $(this).attr('row');
		var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
		var markup = $(this).val();
		var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
		var gross =gross.toFixed(2);		
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
	$(".inventoryGrossRate").keyup(function(){
		var idx = $(this).attr('dataRow');
		var row = $(this).attr('row');
		var net = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
		var gross = $(this).val();
		var markup = (parseFloat(gross)/parseFloat(net))-1;
		var markup =(markup*100).toFixed(2);
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

		
	});			//change status
		$(".switchCurrencyButton").click(function(){
			//var check status
			var status = $(this).attr('status');
			var row = $(this).attr('dataRow');
			var idx = $(this).attr('row');	

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
					var exchange = $("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").attr('old');
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$("#Hotel_room"+idx+"Inventory"+row+"ExchangeRate").val(exchange);
					$("#Hotel_room"+idx+"Inventory"+row+"Gross").val(gross);				
				break;
			}
		});		$(".taxcheck").click(function(){
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
			$('#roomInventoryTbody-'+idx+' .inventoryTaxRate').val(newTax);
			
		} else {	
			$(this).parent().parent().parent().attr('class','well well-small');
			$(this).parent().parent().parent().find('.taxesInput').attr('disabled','disabled');
			var taxValue = $(this).parent().parent().parent().find('.taxesInput').val();
			var totalTax = $(this).parent().parent().parent().parent().find('#taxrate-'+idx).val();
			var newTax = parseFloat(totalTax)-parseFloat(taxValue);
			var newTax = newTax.toFixed(2);
			$(this).parent().parent().parent().parent().find('#taxrate-'+idx).val(newTax);
			$('#roomInventoryTbody-'+idx+' .inventoryTaxRate').val(newTax);
		}
	});

	$(".thumbnail").click(function(){		
		$(this).parents('ul:first').find('li').attr('name','nonprimary');
		$(this).parents('ul:first').find('li').css({
			'background':'#ffffff'
		});
		$(this).attr('name','primary');	
		$(this).css({
			'background':'#a7ffb8'
		});
		//establish if this is a hotel or a hotel room
		var parent_id = $(this).parent().attr('name');
		//var id = $(this).attr('id').replace('thumbnail-','');
		var filename =  $(this).attr('imageId');

		if(parent_id == 'Hotel'){
			var primary_input = '<input type="hidden" hotel="'+parent_id+'" filename="'+filename+'" name="data['+parent_id+'][image_main]" value="'+filename+'"/>';
			//remove other instances
			$("#imagesFormDiv input[hotel='"+parent_id+"']").remove();
			//add in new hotel primary image
			$("#imagesFormDiv").append(primary_input);
		}
		if(parent_id == 'Hotel_room'){
			var room = $(this).parent().parent().parent().parent().parent().parent().parent().find('a h4').html();
			var room_id = $(this).parents('.accordion-group:first').attr('id').replace('marketingRoom-','');
			var primary_input = '<input type="hidden" hotel="'+parent_id+'" room="'+room+'" filename="'+filename+'" name="data['+parent_id+']['+room_id+'][image_primary]" value="'+filename+'"/>';
			//remove other instances
			$("#imagesFormDiv input[hotel='"+parent_id+"'][room='"+room+"']").remove();
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
			$("#accordion4 .hotel_room_images #thumbnail-"+filename).each(function(){
				$(this).remove();
			});
		}
	});
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

		$('.taxrate').priceFormat({
			'prefix':'',
			limit:5
		});
		$(".netRate").priceFormat({
			'prefix':'',
		});
		$("#HotelStartingPrice").priceFormat({
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
		$(".hotelPlusNet").priceFormat({
			'prefix':'',
		});
		$(".hotelPlusFee").priceFormat({
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
  			$('#Hotel_block0StartDate').datepicker('hide');
		});
		$("#Hotel_block0EndDate").datepicker().on('changeDate', function(ev){
  			$('#Hotel_block0EndDate').datepicker('hide');
		});	
		$(".fullYear").datepicker().change(function() {
			var date = $(this).val();
			var idx = $(this).attr('idx');
			$('.datepicker td .day').css({'background-color':'red'});
			hotel_rooms.editSelect(date,idx, '#blackoutDatesUl-'+idx,'#blackoutDateCounter-'+idx);
			//$('.fullYear').datepicker('hide');
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
		
		var element_add_on = $('.deleteAddOn');
		addScripts.deleteAddOn(element_add_on);
		
		
		var element_plus_net = $(".hotelPlusNet");
		addScripts.hotelPlusNet(element_plus_net);
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
		
		$("#hotelAddOnUpdate").click(function(){

			$("#hotelAddOnTbody tr").each(function(num){
				
				var emptyAddOn = $(this).find('#hotelAddOnTitle').val();
				if(emptyAddOn == ''){
					$(this).remove();
				} else {
					var add_on_title = $(this).find('#hotelAddOnTitle').val();
					var add_on_net = $(this).find('.hotelAddOnNet').val();
					var add_on_exchange = $(this).find('.hotelAddOnExchange').val();
					var add_on_gross = $(this).find('.hotelAddOnGross').val();
					var add_on_basis = $(this).find('.hotelAddOnPerBasis:checked').val();
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
			});
			reindex.all();			
		});

	},
	series1check: function(){
		//step 1 create hotel name
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
			$("#hotel_location").html('');
			$(".locationInput").parent().attr('class','control-group');
			$(".locationInput").parent().find('.help-inline').html('');
			$("#hotelUrlDiv").attr('class','control-group');	
			$("#hotelUrlDiv p").attr('class','well well-small muted');	
			$("#hotelUrlDiv .help-block").html('');	
			$("#hotel_location_edit").html(url);
			$("#hotelUrlDiv").attr('name','notvalid');	
			
			//autofill next section based on location
			$(".cityInput,#billing_city").val(city);
			$("#stateInput,#billing_state").val(state);
			$("#country option[value='"+country+"'], #billing_country option[value='"+country+"']").attr('selected','selected');
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
		//tax rate creation
		$(".taxSelection").change(function(){
		
			//hide the em statement
			$(this).parent().parent().parent().find('.taxesCollectedDiv em').hide();
			
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
			var row = $(this).attr('id').replace('hotelAddOnGross-','');
			
			if(gross != old){
				
				var flag = 'Yes';
				$(this).attr('flag',flag);
				var row = $("input[exchange='Yes']").length;
				//add a new hidden input named flag
				$(this).parent().find('.hotelAddOnFlag').remove();
				var hiddenFields = getAddOnExchange(row,net,flag,exchange,old,gross); 
				$(this).parent().append(hiddenFields);
				
			}
		});
		//remove hotel room
		$(".removeRoomButton").click(function(){
			if(confirm('Are you sure you want to delete hotel room?')){
				var hotel_id = $(this).attr('id').replace('removeRoomButton-','');
				var delete_hotel = '<input type="hidden" name="data[Hotel_delete]['+hotel_id+']" value="'+hotel_id+'"/>';

				//add hotel id to the remove room div
				$("#formDelete").append(delete_hotel);
				//remove hotel room from dom
				$(this).parent().parent().parent().parent().parent().remove();	
				//remover marketing scripts from the dom
				$("#marketingRoom-"+hotel_id).remove();		
			}
			
				
		});
		//add Hotel Room
		$("#addHotelRoomButton").click(function(){
			var newRow = $("#accordionRoomType .hotelRoomNew:last-child").length;
			if(newRow >0){
				var idx = $("#accordionRoomType .hotelRoomNew:last-child").attr('idx');
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

			hotel_rooms.addRoom(idx,row);
		
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

			$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('.roomTypeLabel').html(badge);
		});
		
		
		$('.close').click(function(){
			var ticket_id = $(this).parent().parent().attr('id').replace('blackoutDatesUl-','');

			$(this).parent().fadeOut(300,function(){
				$(this).remove();
			});
			var countLi = $("#blackoutDatesUl-"+ticket_id).find('li').length;

			if(countLi ==0){
 
				$("#blackoutDatesUl-"+ticket_id).html('<li class="noCountLi"><input type="hidden" value="" name="data[Hotel_room]['+ticket_id+'][blackout][0][dates]"/></li>');				
			}
			
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

				if(index ==3){//moving out of step 3
					var country = $(".countrySelect option:selected").val();
					var add_on_length = $("#hotelAddOnTbody tr").length;
					if(add_on_length == 0){
						switch (country){
							case '1':
								var blankTr = blankTrUs();
								
							break;
							
							case '2':
								var blankTr = blankTrCan();
							break;
						}
						$("#hotelAddOnTbody").html(blankTr);
						var element_add_on_net = $("#hotelAddOnTbody tr:last .hotelAddOnNet");
						addScripts.hotelAddOnNet(element_add_on_net);
						addScripts.numberFormat(element_add_on_net);
							
						var element_add_on_gross = $("#hotelAddOnTbody tr:last .hotelAddOnGross");
						addScripts.hotelAddOnGross(element_add_on_gross);	
						addScripts.numberFormat(element_add_on_gross);									
					}

				}
			}, next: function(index) {
				$("#toTopHover").click();
				if(index ==4){ //moving out of step 2
					
					reindex.all();

					
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
				// 'data[Hotel][address]':'required',
				// 'data[Hotel][city]':'required',
				// 'data[Hotel][state]':'required',
				// 'data[Hotel][zipcode]':'required',
				// 'data[Hotel][country]':'required',
				// 'data[Hotel][phone]':'required',
				// 'data[Hotel][billing_address]':'required',
				// 'data[Hotel][billing_city]':'required',
				// 'data[Hotel][billing_state]':'required',
				// 'data[Hotel][billing_zip]':'required',
				// 'data[Hotel][billing_country]':'required',
				// 'data[Hotel][primary_first_name]':'required',
				// 'data[Hotel][primary_last_name]':'required',
				// 'data[Hotel][primary_phone]':'required',
				// 'data[Hotel][currency]':'required',


			}, messages: {
				// 'data[Hotel][address]': {required: 'Address field is required!'},
				// 'data[Hotel][city]': {required: 'City field is required!'},
				// 'data[Hotel][state]': {required: 'State field is required!'},
				// 'data[Hotel][zipcode]':{required: 'Zipcode field is required!'},
				// 'data[Hotel][country]':{required: 'Country field is required!'},
				// 'data[Hotel][phone]': {required: 'Phone number field is required!'},
				// 'data[Hotel][billing_address]':{required: 'Billing address is required!'},
				// 'data[Hotel][billing_city]':{required: 'Billing city is required!'},
				// 'data[Hotel][billing_state]':{required: 'Billing state is required!'},
				// 'data[Hotel][billing_zip]':{required: 'Billing zip is required!'},
				// 'data[Hotel][billing_country]':{required: 'Billing country is required!'},
				// 'data[Hotel][primary_first_name]':{required: 'Primary first name is required!'},
				// 'data[Hotel][primary_last_name]':{required: 'Primary last name is required!'},
				// 'data[Hotel][primary_phone]':{required: 'Primary phone number is required!'},
				// 'data[Hotel][currency]':{required: 'Hotel currency is required!'},
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
				var element_delete = $('#hotelAddOnTbody tr:last').find(".deleteAddOn");
				
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
				var element_delete = $("#hotelAddOnTbody tr:last-child").find('.deleteAddOn');
				
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
			$("#accordionGroup2").click();	
		}
	}, 
	create: function(num, createClass, createRoomMarketingClass){
		var row = 0;
		for (var i=0; i < num; i++) {
			var newRow = newRoom(i);			
			var roomMarketing = newRoomMarketing(i);

		
			$(createClass).append(newRow);
			$("#formRoomMarketing p").hide();
			$(createRoomMarketingClass).append(roomMarketing);
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
		$("#HotelRoomNew"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#HotelRoomNew"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#HotelRoomNew"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$("#HotelRoomNew"+idx+"Inventory"+row+"StartDate").datepicker('hide');
		});
		$("#HotelRoomNew"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$("#HotelRoomNew"+idx+"Inventory"+row+"EndDate").datepicker('hide');
		});
		$("#fullYearNew-"+idx).datepicker().change(function() {
			var date = $(this).val();
			$('.datepicker td .day').css({'background-color':'red'});
			hotel_rooms.editSelectNew(date,idx,row, '#blackoutDatesUlNew-'+idx,'#blackoutDateCounterNew-'+idx);
			//$("#fullYear-"+idx).datepicker('hide');
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
		
		//accordion room click to top page
		$("#collapseTwo2 .accordion-toggle").click(function(){
			$("#toTop").click();
			//focus on the name
			$(this).parent().parent().find('.hotelRoomNameNew').focus();
		});
		
		//new room 
		$("#addRoomInventoryNew-"+idx).click(function(){
			var row = $("#roomInventoryTbodyNew-"+idx+" tr").length;
			var newRow = parseInt(row);
			var startDate = $('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').val();
			var endDate = $('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').val();
			var total = $("#roomInventoryTbodyNew-"+idx+" tr:last-child .roomBlockTotal").val();
			
			hotel_rooms.addInventoryNew(idx,newRow,total, startDate, endDate);			
		});	
		//remove room
		$("#removeRoomButtonNew-"+idx).click(function(){
			if(confirm('Are you sure you want to delete hotel room?')){
				
				//remove from step 3
				$(this).parent().parent().parent().parent().parent().remove();		
				//remove marketing from step 4
				$("#marketingRoomNew-"+idx).remove();
					
			}
			
				
		});
		

		//marketing scripts
		$("#Hotel_room_new"+idx+"Name").blur(function(){
			var value = $(this).val();
			var row = $(this).attr('dataRow');
			if(value != ''){
				$('#roomTypeSpan-'+idx).html(value);
				$("#marketingRoomNew-"+idx+" #hotelRoomName-"+idx).html(value);	
							
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
	
		
		//markup keyup function
		//net->gross
		$("#Hotel_room_new"+idx+"Inventory"+row+"Net").keyup(function(){
			
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}	
				break;
				
				case '2': //can
					var net = $(this).val();
					var exchange = $("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var markup = $("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}
			
		});
		//markup -> gross
		$("#Hotel_room_new"+idx+"Inventory"+row+"Markup").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}
				break;
				
				case '2': //can
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var exchange = $("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}

			
		});
		//gross -> markup
		$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val(markup);	
					}
				break;
				
				case '2': //can
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var exchange = $("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val(markup);	
					}				
				
				break;
				
			}
		});	
		
		
		//canadian scripts
		$("#Hotel_room_new"+idx+"Net").blur(function(){
			
			var net = $(this).val();
			var exchange = $(".exchange").val();
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
		
		$("#Hotel_room_new"+idx+"PlusFee").blur(function(){
			
			var net = $(this).val();
			var exchange =$(".exchange").val();
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
		$("#Hotel_room_new"+idx+"Inventory"+row+"ChangeCurrency").click(function(){
			//var check status
			var status = $(this).attr('status');
			
			switch(status){
				case 'canusd':
					//var old = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					//$(this).attr('old',old);
					
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					//var gross = $("#Hotel_room"+idx+"Inventory"+row+"Gross").val();
					var markup = $("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val();
					var exchange = 1;
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','usdcan');
					$(this).parent().find("#dollarSignSpan").html("US$");
					$("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val('1.0000');
					$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);
				break;
				
				case 'usdcan':
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var markup = $("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val();
					var exchange = $(".exchange").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val(exchange);
					$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);				
				break;
			}
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
			
		} 	

		//sucess now send
		if(start != '' && end != '' && startCheck <= endCheck && intRegex.test(total)) {
			var taxRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryTaxRate").val();
			var netRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryNetRate").val();
			var grossRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryGrossRate").val();
			var markupRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryMarkupRate").val();
			var available = $("#roomInventoryTbody-"+idx+" tr:first-child .roomBlockTotal").val();
			var country = $(".countrySelect option:selected").val();
			var exRate = $("#roomInventoryTbody-"+idx+" tr:first-child .inventoryExchangeRate").val();

			//switch the country code if us then pull the US scripts if Can pull the canadian scripts
			switch (country){
				case '1':
					var block = newRoomBlockUs(idx, row, newDateString, netRate, grossRate, markupRate,available);
				break;
				
				case '2':
					var block = newRoomBlockCan(idx, row, newDateString, exRate, netRate, grossRate, markupRate,available);
				break;
			}
			$("#roomInventoryTbody-"+idx).append(block);
			hotel_rooms.addInventoryScripts(idx, row, block);
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
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').parent().parent().attr('class','control-group error');
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').parent().parent().find('.help-block').html('You must choose an start date');			
		} else {
			//remove errors
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').parent().parent().attr('class','control-group');
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockBeginDate').parent().parent().find('.help-block').html('');				
		}
		if(end == ''){
			//add errors
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group error');		
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('You must choose an end date');	
		} else {
			//remove errors
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group');
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
		}
		if(start != '' && end != ''){
			if(startCheck > endCheck){
				$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group error');
				$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('End date must be greater than or equal to the start date');					
			} else {
				//remove errors
				$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().attr('class','control-group');
				$('#roomInventoryTbodyNew-'+idx+' tr:last-child .blockEndDate').parent().parent().find('.help-block').html('');				
			}
			
		} 
		if(!intRegex.test(total) || intRegex.test(total) <=0) { //checks if number
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .roomBlockTotal').parent().parent().attr('class','control-group error');
			$('#roomInventoryTbodyNew-'+idx+' tr:last-child .roomBlockTotal').parent().parent().find('.help-block').html('You must put in a valid quantity');
			
		} 	

		//sucess now send
		if(start != '' && end != '' && startCheck <= endCheck && intRegex.test(total)) {
			var taxRate = $("#roomInventoryTbodyNew-"+idx+" tr:first-child .inventoryTaxRate").val();
			var netRate = $("#roomInventoryTbodyNew-"+idx+" tr:first-child .inventoryNetRate").val();
			var grossRate = $("#roomInventoryTbodyNew-"+idx+" tr:first-child .inventoryGrossRate").val();
			var markupRate = $("#roomInventoryTbodyNew-"+idx+" tr:first-child .inventoryMarkupRate").val();
			var available = $("#roomInventoryTbodyNew-"+idx+" tr:first-child .roomBlockTotal").val();
			var country = $(".countrySelect option:selected").val();
			var exRate = $("#roomInventoryTbodyNew-"+idx+" tr:first-child .inventoryExchangeRate").val();

			//switch the country code if us then pull the US scripts if Can pull the canadian scripts
			switch (country){
				case '1':
					var block = newRoomBlockUsNew(idx, row, newDateString, netRate, grossRate, markupRate,available);
				break;
				
				case '2':
					var block = newRoomBlockCanNew(idx, row, newDateString, exRate, netRate, grossRate, markupRate,available);
				break;
			}
			$("#roomInventoryTbodyNew-"+idx).append(block);
			hotel_rooms.addInventoryScriptsNew(idx, row, block);
		}
	}, 
	addInventoryScripts: function(idx, row, date){
		//plugin scripts
		hotels.numberformat();
		$("#HotelRoom"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#HotelRoom"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#HotelRoom"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$('#HotelRoom"+idx+"Inventory"+row+"StartDate').datepicker('hide');
		});
		$("#HotelRoom"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$('#HotelRoom"+idx+"Inventory"+row+"EndDate').datepicker('hide');

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
	addInventoryScriptsNew: function(idx, row, date){
		//plugin scripts
		hotels.numberformat();
		$("#HotelRoomNew"+idx+"Inventory"+row+"StartDate").mask("99/99/9999");
		$("#HotelRoomNew"+idx+"Inventory"+row+"EndDate").mask("99/99/9999");
		$("#HotelRoomNew"+idx+"Inventory"+row+"StartDate").datepicker().on('changeDate', function(ev){
  			$('#HotelRoomNew"+idx+"Inventory"+row+"StartDate').datepicker('hide');
		});
		$("#HotelRoomNew"+idx+"Inventory"+row+"EndDate").datepicker().on('changeDate', function(ev){
  			$('#HotelRoomNew"+idx+"Inventory"+row+"EndDate').datepicker('hide');

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
		$("#Hotel_room_new"+idx+"Inventory"+row+"Net").keyup(function(){
			
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $(this).val();
					var markup = $("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}	
				break;
				
				case '2': //can
					var net = $(this).val();
					var exchange = $("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var markup = $("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(markup != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}
			
		});
		//markup -> gross
		$("#Hotel_room_new"+idx+"Inventory"+row+"Markup").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var gross = parseFloat(net)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}
				break;
				
				case '2': //can
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var markup = $(this).val();
					var exchange =$("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					if(net != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);	
					}				
				break;
				
			}

			
		});
		//gross -> markup
		$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").keyup(function(){
			var location = $('.countrySelect option:selected').val();
			switch(location){
				case '1': //us
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val(markup);	
					}
				break;
				
				case '2': //can
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var exchange = $("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val();
					var gross = $(this).val();
					var markup = (parseFloat(gross)/parseFloat(exchange)/parseFloat(net))-1;
					var markup =(markup*100).toFixed(2);
					if(gross != ''){
						$("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val(markup);	
					}				
				
				break;
				
			}
			
		});	
		//change status
		$("#Hotel_room_new"+idx+"Inventory"+row+"ChangeCurrency").click(function(){
			//var check status
			var status = $(this).attr('status');
			
			switch(status){
				case 'canusd':
					//var old = $("#Hotel_room"+idx+"Inventory"+row+"Net").val();
					//$(this).attr('old',old);
					
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					//var gross = $("#Hotel_room"+idx+"Inventory"+row+"Gross").val();
					var markup = $("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val();
					var exchange = 1;
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross =gross.toFixed(2);
					$(this).attr('status','usdcan');
					$(this).parent().find("#dollarSignSpan").html("US$");
					$("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val('1.0000');
					$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);
				break;
				
				case 'usdcan':
					var net = $("#Hotel_room_new"+idx+"Inventory"+row+"Net").val();
					var markup = $("#Hotel_room_new"+idx+"Inventory"+row+"Markup").val();
					var exchange = $(".exchange").val();
					var gross = parseFloat(net)*parseFloat(exchange)*(1+(parseFloat(markup)/100));
					var gross = gross.toFixed(2);
					$(this).attr('status','canusd');
					$(this).parent().find("#dollarSignSpan").html("CN$");
					$("#Hotel_room_new"+idx+"Inventory"+row+"ExchangeRate").val(exchange);
					$("#Hotel_room_new"+idx+"Inventory"+row+"Gross").val(gross);				
				break;
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
				'<input type="hidden" id="HotelRoom'+idx+'Blackout'+(count-1)+'Dates" name="data[Hotel_room]['+idx+'][blackout]['+(count-1)+'][dates]" value="'+date+'"/>'+
			'</li>';

		
		hotel_rooms.editCounter(count,idx,updateClass, updateCount);
		hotel_rooms.minusCounter(count,idx,updateClass,updateCount);
		
		hotel_rooms.insertBlackoutDates(idx,timestamp,updateClass,code_append);
		
	}, 
	editSelectNew: function(date,idx,row,updateClass, updateCount){ //creates a multi select of the datepicker
		var timestamp = Math.round((new Date(date)).getTime() / 1000);
		
		var oldCount = $(updateClass+" li").length;
		var count = parseInt(oldCount)+1;
		
		
		var code_append = 
			'<li id="blackoutDate-'+count+'" timestamp="'+timestamp+'" class="label label-inverse pull-left" style="width:150px; margin-bottom:3; margin-top:3px; margin-right:15px; margin-left:0px;">'+
				'<button id="close-'+count+'" type="button" class="close" count="'+count+'" style="color:#ffffff;">×</button>'+
				'<span class="date_to_edit">Selected: <strong class="text-error">'+date+'</strong></span>'+
				'<input type="hidden" id="HotelRoomNew'+idx+'Blackout'+(count-1)+'Dates" name="data[Hotel_room_new]['+idx+'][blackout]['+(count-1)+'][dates]" value="'+date+'"/>'+
			'</li>';

		
		hotel_rooms.editCounter(count,idx,updateClass, updateCount);
		hotel_rooms.minusCounter(count,idx,updateClass,updateCount);
		//check to see where in place the new li should be, then append it
		
	
		hotel_rooms.insertNewBlackoutDates(idx,timestamp,updateClass,code_append);
		
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
									$(this).parent().fadeOut();
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
			    	$(this).attr('id','HotelRoom'+idx+'Blackout'+row+'Dates');
			    	$(this).attr('name','data[Hotel_room]['+idx+'][blackout]['+row+'][dates]');
			    });              
            });
     	});
	}
}

addScripts = {
	numberFormat: function(element){
		element.priceFormat({'prefix':''});
	},
	hotelAddOnGross: function(element){
		element.blur(function(){
			var gross = $(this).val();
			var old = $(this).attr('old');
			var net = $(this).parent().parent().parent().find('.hotelAddOnNet').val();
			var exchange = $(this).parent().parent().parent().find('.hotelAddOnExchange').val();
			var row = $(this).attr('id').replace('hotelAddOnGross-','');
			
			if(gross != old){
				//add a new hidden input named flag
				var flag = 'Yes';
				$(this).attr('flag',flag);
				var row = $("input[exchange='Yes']").length;
				$(this).parent().find('.hotelAddOnFlag').remove();
				var hiddenFields = getAddOnExchange(row,net,flag,exchange,old,gross); 
				$(this).parent().append(hiddenFields);
				
			}
		});		
	},
	hotelAddOnNet: function(element){
		element.blur(function(){
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
	},
	
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

	deleteAddOn: function(element){
		element.click(function(){
			var country = $('#country').val();
			var count = $(this).parents('#hotelAddOnTbody:first').find('tr').length;
			var count = count-1;

			switch(country){
				case '1':				
					var addOn = blankTrUs();
				break;
				
				default:
					var addOn = blankTrCan();
				break;
			}
			$(this).parents('tr:first').remove();	

			if(count == 0){
				$('#hotelAddOnTbody').append(addOn);	
			}
			
		});			
	},
	hotelPlusNet: function(element){
		var country = $("#country").val();
		
		element.blur(function(){
			var net = $(this).val();
			switch(country){
				case '1': //us
				var gross = net;
				break;
				
				default: //can
				var exchange = $(this).parents('.form-horizontal:first').find('.hotelPlusExchange').val();

				var gross = (net * exchange) * 100;
				var gross = Math.round(gross) / 100;
				var gross = gross.toFixed(2);
				break;
			}			
			$(this).parents('.form-horizontal:first').find('.hotelPlusFee').val(gross);
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

reindex = {
	all: function(){
		$('div[method="Edit"]').each(function(){
			var room_id = $(this).attr('room_id');
			//add ons
			$(this).find('.addOnCheckList:checked').each(function(ev){
				$(this).parents('tr:first').find(".inventoryAddOnsTitle").attr('name','data[Hotel_room]['+room_id+'][add_ons]['+ev+'][title]');
				$(this).parents('tr:first').find(".inventoryAddOnsNet").attr('name','data[Hotel_room]['+room_id+'][add_ons]['+ev+'][net]');
				$(this).parents('tr:first').find('.inventoryAddOnsMarkup').attr('name','data[Hotel_room]['+room_id+'][add_ons]['+ev+'][markup]');
				$(this).parents('tr:first').find(".inventoryAddOnsExchange").attr('name','data[Hotel_room]['+room_id+'][add_ons]['+ev+'][exchange]');
				$(this).parents('tr:first').find(".inventoryAddOnsGross").attr('name','data[Hotel_room]['+room_id+'][add_ons]['+ev+'][gross]');
				$(this).parents('tr:first').find('.inventoryAddOnsPerBasis').attr('name','data[Hotel_room]['+room_id+'][add_ons]['+ev+'][per_basis]');
			});				
		});
		
		$('div[method="New"]').each(function(eb){
			$(this).find('.addOnCheckList:checked').each(function(me){
				$(this).parents('tr:first').find(".inventoryAddOnsTitle").attr('name','data[Hotel_room_new]['+eb+'][add_ons]['+me+'][title]');
				$(this).parents('tr:first').find(".inventoryAddOnsNet").attr('name','data[Hotel_room_new]['+eb+'][add_ons]['+me+'][net]');
				$(this).parents('tr:first').find(".inventoryAddOnsMarkup").attr('name','data[Hotel_room_new]['+eb+'][add_ons]['+me+'][markup]');
				$(this).parents('tr:first').find(".inventoryAddOnsExchange").attr('name','data[Hotel_room_new]['+eb+'][add_ons]['+me+'][exchange]');
				$(this).parents('tr:first').find(".inventoryAddOnsGross").attr('name','data[Hotel_room_new]['+eb+'][add_ons]['+me+'][gross]');
				$(this).parents('tr:first').find('.inventoryAddOnsPerBasis').attr('name','data[Hotel_room_new]['+eb+'][add_ons]['+ev+'][per_basis]');
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




