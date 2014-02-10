$(document).ready(function(){
	packages.numberformat();
	packages.stepy("#PackageForm");
	packages.datepicker();
	packages.events();
	packages.validate();
	
	
	//switch form, if opening edit page then run this script else dont run this script on add page
	var type = $("#formType").val();
	switch(type){
		case 'edit':


		break;
	}
	
	//console log script
	$("#console").click(function(){
		windowlog.printlog();
	});
});

/**
 *Functions 
 */
packages = {
	numberformat: function(){
		//number formatting

		$("#extraAdultFee").priceFormat({
			'prefix':'',
		});
		$("#extraChildFee").priceFormat({
			'prefix':'',

		});
		$("#extraNightFee").priceFormat({
			'prefix':'',
		});
		$("#total_chosen").priceFormat({
			'prefix':'',
		});
		$("#rt_passenger").priceFormat({
			'prefix':'',
		});
		$("#rt_vehicle").priceFormat({
			'prefix':'',
		});
		$(".psTax").priceFormat({
			'prefix':'',
		});
		$(".psAfterTax").priceFormat({
			'prefix':'',
		});


	},
	stepy: function(name){
		$(name).stepy({
		 	back: function(index) {
				$("#toTopHover").click();

				if(index ==2){//moving out of step 3

				}
			}, 
			next: function(index) {
				$("#toTopHover").click();
				if(index ==2){ //moving out of step 1

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
				//'data[Hotel][address]':'required'
			}, messages: {
				//'data[Hotel][address]': {required: 'This field is required!'}
			},
			//ignore : ':hidden'
		});
	}, 
	datepicker:function(){
		$(".packageStartDate").datepicker().on('changeDate', function(ev){
			var startDate = $(this).val();
			var endDate = $(".packageEndDate").val();
			var timeEndDate = new Date(endDate).getTime();
			var timeStartDate = new Date(startDate).getTime();
  			$('.packageStartDate').datepicker('hide');
  			if($(this).val()!='' && $('.packageEndDate').val() != ''){
				$(this).parent().parent().parent().removeClass('error');
				$(this).parent().parent().find(".help-block").html(''); 	
				if(timeStartDate > timeEndDate){
					$(this).parent().parent().parent().addClass('error');
					$(this).parent().parent().find(".help-block").html('Cannot be greater than end date');					
				} else {
					$(this).parent().parent().parent().removeClass('error');
					$(this).parent().parent().find(".help-block").html('');						
				}			
  			}
		});
		$(".packageEndDate").datepicker().on('changeDate', function(ev){
			var endDate = $(this).val();
			var startDate = $(".packageStartDate").val();
			
			var timeEndDate = new Date(endDate).getTime();
			var timeStartDate = new Date(startDate).getTime();
			
			if(timeStartDate > timeEndDate){
				$(this).parent().parent().parent().addClass('error');
				$(this).parent().parent().find(".help-block").html('Cannot be less than start date');
			} else {
				$(this).parent().parent().parent().removeClass('error');
				$(this).parent().parent().find('.help-block').html('');
				
				if($('.packageStartDate').val()==''){
					$(".packageStartDate").parent().parent().parent().addClass('error');
					$(".packageStartDate").parent().parent().find(".help-block").html('Please select a date');
				} else {
					$(".packageStartDate").parent().parent().parent().removeClass('error');
					$(".packageStartDate").parent().parent().find(".help-block").html('');

				}
				
			}
			
  			$('.packageEndDate').datepicker('hide');
		});		
		
		//span click to open up calendar
		$(".packageStartDate").click(function(){
			$('.packageEndDate').datepicker('hide');
		});
		
		$(".packageEndDate").click(function(){
			$('.packageStartDate').datepicker('hide');
		});
		//hotel check
		$(".hotelCheck").click(function(){
			var checked = $(this).attr('checked');
			var type = $(this).attr('id').replace('hotelCheck-','');
			if(checked == 'checked'){
				$("#hotelTr-"+type).fadeIn();
				$("#hotelTripUl-"+type).fadeIn();
			} else{
				$("#hotelTr-"+type).hide();
				$("#hotelTripUl-"+type).hide();
			}
		});
		
		$("#packageStartDateSpan").mouseup(function(){
			$('.packageStartDate').focus();
			$('.packageEndDate').datepicker('hide');
		});
		$("#packageEndDateSpan").mouseup(function(){
			$(".packageEndDate").focus();
			$('.packageStartDate').datepicker('hide');
		});

	},
	events: function(){
		calculateLowestAfterTax();
		
		element_check = $('.checkHotelRoom');
		addScripts.checkHotelRoom(element_check);
		element_net = $(".psNet");
		addScripts.numberformat(element_net);
		addScripts.netGrossCalc(element_net);
		element_markup = $(".psMarkup");
		addScripts.numberformat(element_markup);
		addScripts.markupGrossCalc(element_markup);
		element_gross = $(".psGross");
		addScripts.numberformat(element_gross);
		addScripts.grossNetCalc(element_gross);
		element_exchange = $(".exchangeRateSetup");
		addScripts.exchangeRateSetup(element_exchange);		
		element_round = $(".roundUp");
		addScripts.roundUp(element_round);		
		
		
		
		$(".hotelSelect").change(function(){
			var hotel_id = $(this).find("option:selected").val();
			var start = $(".packageStartDate").val();
			var end = $(".packageEndDate").val();
			var check_end = new Date(end).getTime() / 1000;
			var check_start = new Date(start).getTime() / 1000;
			if(start == ''){
				$(".packageStartDate").parents('.control-group:first').addClass('error');
				$(".packageStartDate").parents('.control-group:first').find('.help-block').html('Start date cannot be left empty');
			} else {
				$(".packageStartDate").parents('.control-group:first').removeClass('error');
				$(".packageStartDate").parents('.control-group:first').find('.help-block').html('');
			}
			if(end ==''){
				$(".packageEndDate").parents('.control-group:first').addClass('error');
				$(".packageEndDate").parents('.control-group:first').find('.help-block').html('End date cannot be left empty');
			} else {
				$(".packageEndDate").parents('.control-group:first').removeClass('error');
				$(".packageEndDate").parents('.control-group:first').find('.help-block').html('');
			}
			if(start !='' && end != ''){

				if(check_end < check_start){
					$(".packageEndDate").parents('.control-group:first').addClass('error');
					$(".packageEndDate").parents('.control-group:first').find('.help-block').html('End date cannot be less than start date');					
				} else {
					$(".packageEndDate").parents('.control-group:first').removeClass('error');
					$(".packageEndDate").parents('.control-group:first').find('.help-block').html('');					
				}
			}
			if(start != '' && end != '' && check_end > check_start){
				packages.hotel_request(hotel_id, start, end);	
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

			}
		});		

		$(".selectAttractionTour").click(function(){
			var attraction_id =$("#attractionSelect").find('option:selected').val();
			var start = $("#tourDate").val();
			
			alert(attraction_id+' '+start);

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
				getTours(attraction_id, start);
			}
			
			
			
		});
		
		$(".addOnCloseTicket").click(function(){
			$(this).parent().remove();
			calculateLowestAfterTax();
		});
		
	},
	validate: function(){

		$("#packagesAttractionSelect").change(function(){
			
			var attraction_id = $(this).find("option:selected").val();
			
			if(attraction_id != ''){
				$("#packagesAttractionTourSelect option:gt(0)").remove();
				$("#packagesAttractionTourSelect option[value='']").attr('selected','selected');
				$("#packagesAttractionTourSelect option[value='']").html('Finding attraction tour(s)...');
				setTimeout(function(){
					$("#packagesAttractionTourSelect option[value='']").html('Select Attraction Tour');
					
					var grabAll = $("#attractionTours option[attraction_id='"+attraction_id+"']").clone();
					$("#packagesAttractionTourSelect").append(grabAll);	
				},500);
			} else {
				
			}			
		});
		
		$("#packagesAttractionTourSelect").change(function(){
			var adults = $("#adults").val();
			var children = $("#children").val();
			var inventory = $("#inventory").val();
			var attraction_id = $(this).find('option:selected').attr('attraction_id');
			var tickets = $(this).find('option:selected').val();
			var start_date = $(".packageStartDate").val();
			var end_date = $(".packageEndDate").val();
			if(adults == '' || adults == '0'){
				adults = 'zero';
			}
			
			if(children == '' || children == '0'){
				children = 'zero';
			}
			
			if(inventory == '' || inventory == '0'){
				inventory = 'zero'; 
			}
			
			if(tickets != ''){
				packages.attraction_grabTickets(tickets, attraction_id, start_date, end_date);
				//packages.attraction_request(tickets, start_date, end_date, inventory, adults, children);	
			}
			
		});
		
		//select adult ticket
		$("#selectAttractionAdultTicket").change(function(){
			
		});
		
		
		$(".statusSelect").change(function(){
			var location = makeSEOfriendly($(this).find('option:selected').html());
			var loc_string = '/'+location;
			$("#PackageUrl").val(loc_string);
		});
		
		$("#PackageName").keyup(function(){
			var name = makeSEOfriendly($(this).val());
			var name_string = '/'+name;
			var location = makeSEOfriendly($('.statusSelect').find('option:selected').html());
			var loc_string = '/'+location;	
			
			var url = loc_string+name_string;

			
			$("#PackageUrl").val(url);
					
		})
		
		//select child ticket
		$("#selectAttractionChildTicket").change(function(){})
		$("#resetAttraction").click(function(){
			//reset the attraction
			$("#packagesAttractionSelect option[value='']").attr('selected','selected');
			$("#packagesAttractionTourSelect option[value='']").attr('selected','selected');
			$("#selectAttractionAdultTicket").html('<option value="">None Selected</option>');
			$("#selectAttractionChildTicket").html('<option value="">None Selected</option>');
			
		});
		
		$("#createAttraction").click(function(){
			var adults = $("#adults").val();
			var children = $("#children").val();
			var tickets = $("#packagesAttractionTourSelect").find('option:selected').val();
			var adult_price = $("#selectAttractionAdultTicket").find('option:selected').attr('net');
			if(adult_price == ''){
				adult_price = 'zero';
			}
			var children_price = $("#selectAttractionChildTicket").find('option:selected').attr('net');
			if(children_price == ''){
				children_price = 'zero';
			}
			var adult_markup = $("#selectAttractionAdultTicket").find('option:selected').attr('markup');
			if(adult_markup == ''){
				adult_markup = 'zero';
			}
			var children_markup = $("#selectAttractionChildTicket").find('option:selected').attr('markup');
			if(children_markup ==''){
				children_markup ='zero';
			}

			if(tickets == ''){
				
			}
			if(adult_price == ''){
				
			}
			if(children_price == ''){
				
			}
			if(adults != '' && children != '' && tickets != '' && adult_price != '' && children_price !=''){
				
				packages.attraction_request(tickets, adults, children, adult_price, children_price, adult_markup, children_markup);	
			}
			
		});

		$("#packagesInventorySelect").change(function(){
			var inventory_id = $(this).find("option:selected").val();

			if(inventory_id !=''){
				$("#packagesInventoryItemSelect").find("option").hide();
				$("#packagesInventoryItemSelect").find("option[value='']").show();
				$("#packagesInventoryItemSelect").find("option[value='']").html('Finding Inventory Items...');
				$("#packagesInventoryItemSelect").find("option[value='']").attr('selected','selected');
				setTimeout(function(){
					$("#packagesInventoryItemSelect").find("option[value='']").html('Select Inventory Item');
					$("#packagesInventoryItemSelect").find("option[inventory_id='"+inventory_id+"']").show();	
					
					var onewayCheck = $("#onewayCheck").attr('checked');
					if(onewayCheck == 'checked'){
						trip_count = 1;
					} else{
						trip_count = 2;
					}
					var adults = $("#adults").val();
					var children = $("#children").val();
					if(adults =='' || adults == '0'){
						adults = 'zero';
					}
					
					if(children=='' || children =='0'){
						children = 'zero';
					}
					packages.ferry_request(adults, children, trip_count, inventory_id);
				
				},1000);

			} else {
				$("#packagesInventoryItemSelect").find("option").hide();
				$("#packagesInventoryItemSelect").find("option[value='']").show();	
				$("#packagesInventoryItemSelect").find("option[value='']").html('No Inventory Selected');
				$("#packagesInventoryItemSelect").find("option[value='']").attr('selected','selected');			
			}
			
		});
		

		//inventory item grab
		$("#packagesInventorySelect").change(function(){
			var id = $(this).find('option:selected').val();
			var name = $(this).find('option:selected').html();
			var label = ferry_items(id, name);
			if(id !=''){
				$("#inventoryItemSelected").append(label);
			}
		});
		
		$("#addOnSelect").change(function(){
			var add_on_id = $(this).find('option:selected').val();

			if(add_on_id !=''){
				packages.add_ons(add_on_id);
				
				
			}
		});
		

	},
	hotel_request: function(hotel_id, start, end){
   		$.post('/packages/request_hotel_room',
   		{
			hotel_id: hotel_id,
			start: start,
			end: end
   		},function(results){
			$(".hotel_room_setup").html(results);
			element_check = $('.hotel_room_setup').find("li:last .checkHotelRoom");
			addScripts.checkHotelRoom(element_check);
			element_net = $(".hotel_room_setup").find("li:last .psNet");
			addScripts.numberformat(element_net);
			addScripts.netGrossCalc(element_net);
			element_markup = $(".hotel_room_setup").find('li:last .psMarkup');
			addScripts.numberformat(element_markup);
			addScripts.markupGrossCalc(element_markup);
			element_gross = $(".hotel_room_setup").find('li:last .psGross');
			addScripts.numberformat(element_gross);
			addScripts.grossNetCalc(element_gross);
			element_exchange = $(".hotel_room_setup").find('li:last .exchangeRateSetup');
			addScripts.exchangeRateSetup(element_exchange);
			element_after_tax = $(".hotel_room_setup").find('li:last .psTax');
			addScripts.numberformat(element_after_tax);
			element_tax = $(".hotel_room_setup").find('li:last .psAfterTax');
			addScripts.numberformat(element_tax);
			element_round = $(".hotel_room_setup").find('li:last .roundUp');
			addScripts.roundUp(element_round);
			
			//add basic summary
			var lowest_gross = parseFloat($(".lowest_gross").val());
			var roundtrip_vehicle = (parseFloat($(".roundtrip_vehicle").val()) + lowest_gross) ;
			var roundtrip_vehicle = roundtrip_vehicle.toFixed(2);
			var roundtrip_passenger =(parseFloat($(".roundtrip_passenger").val()) + lowest_gross);
			var roundtrip_passenger = roundtrip_passenger.toFixed(2);

			$("#rt_passenger").val(roundtrip_passenger);
			$("#rt_vehicle").val(roundtrip_vehicle);
   		});	

	},
	add_ons:function(addOn){


   		$.post('/packages/request',
   		{
   			type:'ADDONS',
   			addOn: addOn,
   		},function(results){

   			$("#addOnsSelected").append(results);
   			calculateLowestAfterTax();
   			packages.addOn_addScripts();
   		});			
	},
	addOn_addScripts: function(){
		$(".close").click(function(){
			var addOn_id = $(this).attr('id').replace('addOnCloseTicket-','');
			$(this).parent().remove();
			
			calculateLowestAfterTax();
		});
		
		
	},


}

addScripts = {
	checkHotelRoom: function(element){
		
		element.click(function(){
			checked = $(this).attr('checked');
			if(checked == 'checked'){
				$(this).parents('div:first').attr('class','well well-small');
				$(this).parents('div:first').find('table').show();
				$(this).parents('div:first').find('label').addClass('heading');
				$(this).parents('div:first').find('table input').removeAttr('disabled');
				$(this).parents('div:first').find('table .lrNet').attr('disabled','disabled');
				$(this).parents('div:first').find('table .lrExchange').attr('disabled','disabled');
				$(this).parents('div:first').find('table .lrMarkup').attr('disabled','disabled');
				$(this).parents('div:first').find('table .lrGross').attr('disabled','disabled');
				
			} else {
				$(this).parents('div:first').attr('class','alert alert-error');
				$(this).parents('div:first').find('table').hide();
				$(this).parents('div:first').find('label').removeClass('heading');
				$(this).parents('div:first').find('table input').attr('disabled','disabled');
				
			}
			calculateLowestAfterTax();
		});
		
		
	},
	numberformat: function(element){
		element.priceFormat({
			'prefix':'',
		});
	},
	netGrossCalc: function(element){
		element.keyup(function(){
			var net = parseFloat($(this).val());
			var markup = parseFloat($(this).parents('table:first').find('.psMarkup').val());
			if($(this).parents('table:first').find('.psExchange').is('*')){
				var exchange = parseFloat($(this).parents('table:first').find('.psExchange').val());	
			} else {
				var exchange = 1;
			}
			
			var gross = net * exchange;
			var gross = gross * (1+(markup /100));
			var gross = gross * 100;
			var gross = Math.round(gross);
			var gross = gross / 100;
			var gross = gross.toFixed(2);

			
			$(this).parents('table:first').find('.psGross').val(gross);

			var tax_rate = parseFloat($(this).parents('table:first').find('.psTax').attr('tax_rate'));
			
			var tax = (gross * tax_rate) * 100;
			var tax = Math.round(tax) / 100;
			var tax = tax.toFixed(2);
			
			var after_tax = parseFloat(gross) + parseFloat(tax);
			var after_tax = after_tax.toFixed(2);

			$(this).parents('table:first').find('.psTax').val(tax);
			$(this).parents('table:first').find('.psAfterTax').val(after_tax);
			calculateLowestAfterTax();
			
		});
	}, 
	grossNetCalc: function(element){
		element.keyup(function(){
			var gross = parseFloat($(this).val());
			var net = parseFloat($(this).parents('table:first').find('.psNet').val());
			
			if($(this).parents('table:first').find('.psExchange').is('*')){
				var exchange = parseFloat($(this).parents('table:first').find('.psExchange').val());	
			} else {
				var exchange = 1;
			}
			
			var markup = ((gross / net / exchange)-1) * 100 * 100;
			var markup = Math.round(markup) /100;
			var markup = markup.toFixed(2);
			
			
			$(this).parents('table:first').find('.psMarkup').val(markup);		

			var tax_rate = parseFloat($(this).parents('table:first').find('.psTax').attr('tax_rate'));
			
			var tax = (gross * tax_rate) * 100;
			var tax = Math.round(tax) / 100;
			var tax = tax.toFixed(2);
			
			var after_tax = parseFloat(gross) + parseFloat(tax);
			var after_tax = after_tax.toFixed(2);
			$(this).parents('table:first').find('.psTax').val(tax);
			$(this).parents('table:first').find('.psAfterTax').val(after_tax);
			calculateLowestAfterTax();	
		});
	}, 
	markupGrossCalc: function(element){
		element.keyup(function(){
			var net = parseFloat($(this).parents('table:first').find('.psNet').val());
			var markup = parseFloat($(this).val());
			if($(this).parents('table:first').find('.psExchange').is('*')){
				var exchange = parseFloat($(this).parents('table:first').find('.psExchange').val());	
			} else {
				var exchange = 1;
			}
			
			var gross = (net * (1+(markup / 100)) * exchange) * 100;
			var gross = Math.round(gross) / 100;
			var gross = gross.toFixed(2);
			
			$(this).parents('table:first').find('.psGross').val(gross);			
			
			var tax_rate = parseFloat($(this).parents('table:first').find('.psTax').attr('tax_rate'));
			
			var tax = (gross * tax_rate) * 100;
			var tax = Math.round(tax) / 100;
			var tax = tax.toFixed(2);
			
			var after_tax = parseFloat(gross) + parseFloat(tax);
			var after_tax = after_tax.toFixed(2);
			$(this).parents('table:first').find('.psTax').val(tax);
			$(this).parents('table:first').find('.psAfterTax').val(after_tax);
			
			calculateLowestAfterTax();
		});
	},
	exchangeRateSetup: function(element){
		element.click(function(){
			var type = $(this).attr('type');
			switch(type){
				case 'canusd':
					var exchange = 1;
					$(this).html('USD/CAN');
					$(this).attr('type','usdcan');
					$(this).parents('table:first').find('.psExchange').val('1.00');
					$(this).parents('table:first').find('.prependLabel').html('US$');
				break;
				
				case 'usdcan':
					var exchange = parseFloat($(this).parents('table:first').find('.psExchange').attr('exchange'));	
					$(this).html('CAN/USD');
					$(this).attr('type','canusd');
					$(this).parents('table:first').find('.psExchange').val(exchange);
					$(this).parents('table:first').find('.prependLabel').html('CN$');
				break;
			}
			var gross = parseFloat($(this).parents('table:first').find('.psGross').val());
			var markup = 1+(parseFloat($(this).parents('table:first').find('.psMarkup').val()) / 100);
			
			var net = (gross / markup / exchange) * 100;
			var net = Math.round(net) / 100;
			var net = net.toFixed(2);
			
			$(this).parents('table:first').find('.psNet').val(net);		
		});
	},
	roundUp: function(element){
		element.click(function(){
			var after_tax = parseFloat($(this).parents('tr:first').find('.psAfterTax').val());
			var after_tax = Math.round(after_tax);
			var after_tax = after_tax.toFixed(2);
			
			$(this).parents('tr:first').find('.psAfterTax').val(after_tax);
			var tax_rate = parseFloat($(this).parents('table:first').find('.psTax').attr('tax_rate'));
			var new_gross = (after_tax / (1+tax_rate))*100;
			var new_gross = Math.round(new_gross)/ 100;
			var new_gross = new_gross.toFixed(2);
			$(this).parents('table:first').find('.psGross').val(new_gross);
			var new_tax = after_tax - new_gross;
			var new_tax = new_tax.toFixed(2);
			$(this).parents('table:first').find('.psTax').val(new_tax);
			var net = $(this).parents('table:first').find('.psNet').val();
			
			if ($(".psExchange").is('*')) {
				
				var exchange = $(this).parents('table:first').find('.psExchange').val();	
			} else {
				exchange = 1;
			}
			var new_markup =(parseFloat(new_gross) / (parseFloat(net) * parseFloat(exchange)))-1;
			var new_markup = new_markup * 100 * 100;
			var new_markup = Math.round(new_markup) / 100;
			var new_markup = new_markup.toFixed(2);
			$(this).parents('table:first').find('.psMarkup').val(new_markup);
			
			calculateLowestAfterTax();
		});
	}
}

windowlog = {

	printlog: function(){
		var adult_base = $("#adults").val();
		var adult_max = $("#adult_max").val();
		var children_base = $("#children").val();
		var children_max = $("#children_max").val();
		var start_date = $(".packageStartDate").val();
		var end_date = $(".packageEndDate").val();
		var hard_count = $("#hard_count").val();
		var inventory = $("#inventory").val();
		var cutoff = $("#cutoff").val();
		var cutoff_by = $("#PackageCutoffBy").find('option:selected').val();
		var starting_point = $("#PackageStartingPoint").find('option:selected').val();
		
		//print global variables
		window.console.log('PACKAGE CREATION LOG');
		window.console.log('Global Variables:');
		window.console.log('(1) Adult Base = '+adult_base);
		window.console.log('(2) Adult Max = '+adult_max);
		window.console.log('(3) Children Base = '+children_base);
		window.console.log('(4) Children Max = '+children_max);
		window.console.log('(5) Hard Count = '+hard_count);
		window.console.log('(6) Inventory = '+inventory);
		window.console.log('(7) Start Date = '+start_date);
		window.console.log('(8) End Date = '+end_date);
		window.console.log('(9) Cutoff Time = '+cutoff+' '+cutoff_by);
		window.console.log('(10) Starting Point = '+starting_point);
		
		//print ferry summary
		var trip_check = $("#onewayCheck").attr('checked');
		if(trip_check == 'checked'){
			trips = 1;
		} else {
			trips = 2;
		}
		
		var adult_single_price = parseFloat($("#adult_single_price").html());
		var child_single_price = parseFloat($("#child_single_price").html());
		var vehicleLi = $("#ferrySummaryUl li:nth-child(3)").html();
		var reservation_fee = $("#ferrySummaryUl li:last-child").html();
		var adult_price = adult_single_price * trips * parseInt(adult_base);
		var adult_price = adult_price.toFixed(2);
		var child_price = child_single_price * trips * parseInt(children_base);
		var child_price = child_price.toFixed(2);
		var ferry_alacarte = $("#ferryGrossRate").val();
		window.console.log(' ');
		window.console.log('Ferry Reservation Summary:');
		window.console.log(' ');
		window.console.log(adult_base+' adult(s) @ $'+adult_single_price+' = $'+adult_price);
		window.console.log(children_base+' child(ren) @ $'+child_single_price+' = $'+child_price);
		window.console.log(vehicleLi);
		window.console.log(reservation_fee);
		window.console.log('_________________________________________________________');
		window.console.log('Ferry A la carte = $'+ferry_alacarte);
		window.console.log(' ');
		
			
		
	}
}

var ferry_items = function(id, name){
	var label = 
		'<label style="margin-top:1px; margin-bottom:3px" class="alert alert-info">'+
			'<a href="#" class="close" data-dismiss="alert">&times;</a>'+name+
			'<input vehicle_id="'+id+'" type="hidden" value="data[Package][ferry_inventory]['+id+']"/>'+
		'</label>';
		
	return label;	
}
var attraction_tickets = function(id, name){
	var label = 
		'<label style="margin-top:1px; margin-bottom:3px" class="alert alert-info">'+
			'<a href="#" class="close" data-dismiss="alert">&times;</a>'+name+
			'<input ticket_id="'+id+'" type="hidden" value="data[Package][attraction_tickets]['+id+']"/>'+
		'</label>';
		
	return label;	
}


var calculateLowestAfterTax= function(){
	var vehicles = parseFloat($(".roundtrip_vehicle").val());
	var passengers = parseFloat($(".roundtrip_passenger").val());

	vehicles = vehicles.toFixed(2);
	passengers = passengers.toFixed(2);
	lowest_room = 0;
	lowest = [];
	var count_hotel_room = $(".checkHotelRoom").length;
	if(count_hotel_room > 0){

		$(".checkHotelRoom").each(function(){
			var checked = $(this).attr('checked');
			if(checked=='checked'){
				var after_tax = parseFloat($(this).parents('#sizedRoomDiv:first').find('.psAfterTax').val());	
				lowest.push(after_tax);
			} 
		});
		lowest.sort(function(a, b) { return a - b });
		var lowest_room = parseFloat(lowest[0]);
		
	}

	//calculate add ons to total
	var adults = 2;
	var children = 0;
	var count_add_on = $(".addOnLi").length;
	add_on_summary = 0;
	if(count_add_on >0){
		$(".addOnLi").each(function(){
			var type = $(this).find('.addOn_type').val();
			var tax = parseFloat($(this).find('.addOn_tax_sum').val()) / 100;
			var total = parseFloat($(this).find('.addOn_gross').val());
			switch(type){
				case 'person':

					var add_on_total = (total * (1+tax) * parseInt(adults)) * 100;
					var add_on_total = Math.round(add_on_total) / 100;
					var add_on_total = add_on_total.toFixed(2);
					
				break;
				default:

					var add_on_total = (total * (1+tax)) * 100;
					var add_on_total = Math.round(add_on_total) / 100;
					var add_on_total = add_on_total.toFixed(2);
				break;
			}
			
			add_on_summary = add_on_summary + parseFloat(add_on_total);			
			
		});
	}
	roundtrip_vehicle = (parseFloat(lowest_room) + parseFloat(vehicles) + parseFloat(add_on_summary))* 100;
	roundtrip_vehicle = Math.round(roundtrip_vehicle) / 100;
	roundtrip_vehicle = roundtrip_vehicle.toFixed(2);
	roundtrip_passenger = (parseFloat(lowest_room) + parseFloat(passengers) + parseFloat(add_on_summary)) * 100;
	roundtrip_passenger = Math.round(roundtrip_passenger) / 100;
	roundtrip_passenger = roundtrip_passenger.toFixed(2);
	
	$("#rt_passenger").val(roundtrip_passenger);
	$("#rt_vehicle").val(roundtrip_vehicle);

}

var makeSEOfriendly= function(string){
	var string = string.replace('&','and');
	var string = string.replace("'", '');
	var string = string.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();

	return string;
}

