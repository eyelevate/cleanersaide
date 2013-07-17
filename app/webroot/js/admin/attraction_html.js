/**
 * These scripts create the html for the page
 * 
 */

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
					'<td class="addOnActiveRow-title">'+title+' <input id="AttractionRoom'+num+'AddOns'+idx+'Title" class="inventoryAddOnsTitle" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][title]" value="'+title+'"/></td>'+
					'<td class="addOnActiveRow-price">US$'+price+' <input id="AttractionRoom'+num+'AddOns'+idx+'Price" class="inventoryAddOnsPrice" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][price]" value="'+price+'"/></td>'+
					//'<td class="addOnActiveRow-perbasis">'+per_basis+' <input id="AttractionRoom'+num+'AddOns'+idx+'PerBasis" class="inventoryAddOnsPerBasis" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][per_basis]" value="'+per_basis+'"/></td>'+
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
				'<tbody class="add_on_tbody">';
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
					'<td class="addOnActiveRow-title">'+title+' <input id="AttractionRoom'+num+'AddOns'+idx+'Title" class="inventoryAddOnsTitle" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][title]" value="'+title+'"/></td>'+
					'<td class="addOnActiveRow-net">CN$'+net+' <input id="AttractionRoom'+num+'AddOns'+idx+'Net" class="inventoryAddOnsNet" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][net]" value="'+net+'"/></td>'+
					'<td class="addOnActiveRow-exchange">'+exchange+' CAN/USD <input id="AttractionRoom'+num+'AddOns'+idx+'Exchange" class="inventoryAddOnsExchange" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][exchange]" value="'+exchange+'"/></td>'+
					'<td class="addOnActiveRow-gross">US$'+gross+' <input id="AttractionRoom'+num+'AddOns'+idx+'Gross" class="inventoryAddOnsGross" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][gross]" value="'+gross+'"/></td>'+
					//'<td class="addOnActiveRow-perbasis">'+per_basis+' <input id="AttractionRoom'+num+'AddOns'+idx+'PerBasis" class="inventoryAddOnsPerBasis" type="hidden" name="data[Attraction_ticket]['+num+'][add_ons]['+idx+'][per_basis]" value="'+per_basis+'"/></td>'+
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
				'<tbody class="add_on_tbody">';
		var tableEnd = '</tbody></table>';
		addOns = tableAddOnStart+addOns+tableEnd;
	} else {
		addOns = '<em>There were no add-ons created</em>';
	}	
	
	return addOns;
}
var newTicketUs = function(num, get_addOns){
	//tax rates
	$("#taxRateDiv .taxSelection").attr('num',num);
	var tax_rates = $("#taxRateDiv").html();
	//setup time search
	var minutes = $("#minutes").val();
	
	
	var ticket = 
		'<div class="accordion-group" style="background:#fff;" row="new" idx="'+num+'" method="New">'+
			'<div class="accordion-heading" name="attractionTicket">'+
				'<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionTicketType" href="#ticketType-n-'+num+'"><h4>Tour Name: <span id="ticketTypeSpan-'+num+'" class="ticketTypeSpan">'+(num+1)+'</span> <span id="ticketTypeLabel-'+num+'" class="ticketTypeLabel"></span></h4></a>'+
			'</div>'+
			'<div id="ticketType-n-'+num+'" class="accordion-body collapse">'+
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
										'<select class="statusSelect" class="attraction_ticket_status" name="data[Attraction_ticket['+num+'][status]">'+
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

								'<div class="control-group">'+
									'<label><strong>Select A Tour Type</strong></label>'+
											'<label class="radio"><input id="multiday-'+num+'" class="multiday" type="radio" name="data[Attraction_ticket_new]['+num+'][time_ticket]" value="No"/> Not Timed Tour</label>'+
											'<label class="radio"><input id="multiday-'+num+'"  class="multiday" type="radio" name="data[Attraction_ticket_new]['+num+'][time_ticket]" value="Yes"/> Timed Tour</label>'+									
								'</div>'+


								//'<label class="checkbox"><input id="multiday-'+num+'" class="multiday" type="checkbox"/> Click here if there are multiple times per day</label>'+
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
								'<table id="noTimeTable-'+num+'" status="active" class="attractionTable-'+num+' table table-condensed table-bordered table-vam" type="noTimeTable" country="US" method="New">'+
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
										'<tr class="AgeRow" row="top" num="0">'+	
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket_]['+num+'][inventory][0][start_date]" style="width:100px;">'+
													'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket_]['+num+'][inventory][0][end_date]" style="width:100px;">'+
													'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<input id="AttractionTicket'+num+'Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket_]['+num+'][inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;">'+
												'</div>'+
												'<span class="help-block"></span>'+																											
											'</td>'+							
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket_]['+num+'][inventory][0][inventory]" style="width:50px;">'+	
												'</div>'+
												'<span class="help-block"></span>'+											
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket_]['+num+'][inventory][0][net]" value="0" style="width:75px;">'+	
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket_]['+num+'][inventory][0][markup]" value="0" style="width:75px;">'+	
													'<span class="add-on">%</span>'+
												'</div>'+
												'<span class="help-block"></span>'+																									
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket_]['+num+'][inventory][0][gross]" value="0" style="width:75px;">'+
												'</div>'+
												'<span class="help-block"></span>'+													
											'</td>'+
											'<td>'+
											
												'<button class="addAgeButton btn btn-small" type="button" main="notime-us"><i class="icon-plus"></i></button>'+
												'<button class="deleteTbody btn btn-small btn-danger" type="button" style="margin-left:2px"><i class="icon-white icon-trash"></i></button>'+
											'</td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+
							'</div>'+
							'<div id="timeTableDiv-'+num+'" class="clearfix hide">'+
								'<table id="timeTable-'+num+'" status="notactive" class="attractionTable-'+num+' table table-condensed table-bordered" type="timeTable" country="US" method="New">'+
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
										'<tr class="AgeRow" row="top" num="0">'+	
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket_]['+num+'][inventory][0][start_date]" style="width:100px;" disabled="disabled">'+
													'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][inventory][0][end_date]" style="width:100px;" disabled="disabled">'+
													'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Time" class="ticketTime" type="text" placeholder=""  style="width:75px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+	
												'<input id="AttractionTicket'+num+'Inventory0Time" class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket]['+num+'][inventory][0][time]" style="width:100px;">'+													
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<input id="AttractionTicket'+num+'Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][age_range]" placeholder="i.e. Adults (16+)" disabled="disabled" style="width:125px">'+
												'</div>'+
												'<span class="help-block"></span>'+																											
											'</td>'+							
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][inventory]" style="width:50px;" disabled="disabled">'+	
												'</div>'+
												'<span class="help-block"></span>'+											
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0" style="width:75px;" disabled="disabled">'+	
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][markup]" value="0" style="width:75px;" disabled="disabled">'+	
													'<span class="add-on">%</span>'+
												'</div>'+
												'<span class="help-block"></span>'+																									
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][gross]" value="0" style="width:75px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+													
											'</td>'+
											'<td>'+
											
												'<button class="addAgeButton btn btn-small" type="button" main="time-us"><i class="icon-plus"></i></button>'+
												'<button class="deleteTbody btn btn-small btn-danger" type="button" style="margin-left:2px"><i class="icon-white icon-trash"></i></button>'+
											'</td>'+
										'</tr>'+
									'</tbody>'+

								'</table>'+

							'</div>'+
							'<div class="formSep clearfix">'+
								'<button type="button" class="addTicketInventory btn btn-primary pull-right">Add New Schedule</button>'+
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

										'<ul id="blackoutDatesUl-'+num+'" class="blackoutDatesUl unstyled clearfix"></ul>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="formSep" style="height:40px;">'+
							'<button id="removeTicketButton-'+num+'" type="button" class="removeTicketButton btn btn-danger btn-large pull-right">Remove Tour</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';
	
	return ticket;
}

var newTicketCan = function(num, get_addOns){
	var exchange = $(".exchange").val();
	
	//tax rates
	$("#taxRateDiv .taxSelection").attr('num',num);
	var tax_rates = $("#taxRateDiv").html();
	
	//setup time table minutes
	var minutes = $("#minutes").val();
	
	//new created ticket
	var ticket = 
		'<div class="accordion-group" row="new" style="background:#fff;" idx="'+num+'" method="New">'+
			'<div class="accordion-heading" name="attractionTicket">'+
				'<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionTicketType" href="#ticketType-n-'+num+'"><h4>Tour Name: <span id="ticketTypeSpan-'+num+'" class="ticketTypeSpan">'+(num+1)+'</span> <span id="ticketTypeLabel-'+num+'" class="ticketTypeLabel"></span></h4></a>'+
			'</div>'+
			'<div id="ticketType-n-'+num+'" class="accordion-body collapse">'+
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
										'<select id="AttractionTicket'+num+'Status" class="attraction_ticket_status" name="data[Attraction_ticket]['+num+'][status]">'+
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
								'<div class="control-group">'+
									'<label><strong>Select A Tour Type</strong></label>'+
											'<label class="radio"><input id="multiday-'+num+'" class="multiday" type="radio" name="data[Attraction_ticket_new]['+num+'][time_ticket]" value="No"/> Not Timed Tour</label>'+
											'<label class="radio"><input id="multiday-'+num+'"  class="multiday" type="radio" name="data[Attraction_ticket_new]['+num+'][time_ticket]" value="Yes"/> Timed Tour</label>'+									
								'</div>'+
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
								'<table id="noTimeTable-'+num+'" status="active" class="attractionTable-'+num+' table table-condensed table-bordered table-vam" type="noTimeTable" country="CAN" method="New">'+
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
													'<input id="AttractionTicket'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][inventory][0][start_date]" style="width:100px;">'+
													'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][inventory][0][end_date]" style="width:100px;">'+
													'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<input id="AttractionTicket'+num+'Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;">'+
												'</div>'+
												'<span class="help-block"></span>'+																											
											'</td>'+							
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][inventory]" style="width:50px;">'+	
												'</div>'+
												'<span class="help-block"></span>'+											
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend input-append">'+
													'<span id="dollarSignSpan" class="add-on">CN$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0" style="width:75px;">'+	
													'<span id="switchNetRate-'+num+'-0" status="canusd" dataRow=""class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
													
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][exchange]" value="'+exchange+'" style="width:75px;" disabled="disabled">'+	
													'<span class="add-on">CAN/USD</span>'+												
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][markup]" value="0" style="width:75px;">'+	
													'<span class="add-on">%</span>'+
												'</div>'+
												'<span class="help-block"></span>'+																									
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][gross]" value="0" style="width:75px;">'+
												'</div>'+
												'<span class="help-block"></span>'+													
											'</td>'+
											'<td>'+
											
												'<button id="addAgeButton-'+num+'" class="addAgeButton btn btn-small" type="button" main="notime-can"><i class="icon-plus"></i></button>'+
												'<button class="deleteTbody btn btn-small btn-danger" type="button" style="margin-left:2px"><i class="icon-white icon-trash"></i></button>'+
											'</td>'+
										'</tr>'+
									'</tbody>'+
								'</table>'+
							'</div>'+
							'<div id="timeTableDiv-'+num+'" class="clearfix hide">'+
								'<table id="timeTable-'+num+'" status="notactive" class="attractionTable-'+num+' table table-condensed table-bordered" type="timeTable" country="CAN" method="New">'+
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
													'<input id="AttractionTicket'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][inventory][0][start_date]" style="width:100px;" disabled="disabled">'+
													'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket]['+num+'][inventory][0][end_date]" style="width:100px;" disabled="disabled">'+
													'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
												'</div>'+
												'<span class="help-block"></span>'+														
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Time" class="ticketTime" type="text" placeholder=""  style="width:75px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+	
												'<input id="AttractionTicket'+num+'Inventory0Time" class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket]['+num+'][inventory][0][time]">'+													
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<input id="AttractionTicket'+num+'Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+																											
											'</td>'+							
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][inventory]" style="width:50px;" disabled="disabled">'+	
												'</div>'+
												'<span class="help-block"></span>'+											
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend input-append">'+
													'<span id="dollarSignSpan" class="add-on">CN$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][net]" style="width:75px;" disabled="disabled">'+	
													'<span id="switchNetRate-'+num+'-0" status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][exchange]" style="width:75px;" disabled="disabled" value="'+exchange+'" >'+	
													'<span class="add-on">CAN/USD</span>'+												
												'</div>'+
												'<span class="help-block"></span>'+		
												//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-append">'+
													'<input id="AttractionTicket'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][markup]"  style="width:75px;" disabled="disabled">'+	
													'<span class="add-on">%</span>'+
												'</div>'+
												'<span class="help-block"></span>'+																									
											'</td>'+
											'<td class="control-group">'+
												'<div class="input-prepend">'+
													'<span class="add-on">US$</span>'+
													'<input id="AttractionTicket'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket]['+num+'][inventory][0][gross]"  style="width:75px;" disabled="disabled">'+
												'</div>'+
												'<span class="help-block"></span>'+													
											'</td>'+
											'<td>'+										
												'<button class="addAgeButton btn btn-small" type="button" main="time-can"><i class="icon-plus"></i></button>'+
												'<button class="deleteTbody btn btn-small btn-danger" type="button" style="margin-left:2px"><i class="icon-white icon-trash"></i></button>'+
											'</td>'+
										'</tr>'+
									'</tbody>'+

								'</table>'+

							'</div>'+							

							'<div class="clearfix">'+
								'<button type="button" class="addTicketInventory btn btn-primary pull-right">Add New Schedule</button>'+
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

										'<ul id="blackoutDatesUl-'+num+'" class="blackoutDatesUl unstyled clearfix"></ul>'+
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


var newTicketBlockUs = function(age_range,inventory,net, markup, gross){

	var ticketBlock = 
		'<tr class="" row="sub">'+	
			'<td class="control-group"></td>'+
			'<td class="control-group" style="border-left:none"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][age_range]" placeholder="i.e. Adults (16+)" value="'+age_range+'" style="width:125px">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][inventory]" style="width:50px;" value="'+inventory+'">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][net]" style="width:75px;" value="'+net+'">'+	
				'</div>'+
				'<span class="help-block"></span>'+		
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][markup]" style="width:75px;" value="'+markup+'">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][inventory][0]age_range][0][gross]" style="width:75px;" value="'+gross+'">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button class="addAgeButton btn btn-small" type="button" main="notime-us"><i class="icon-plus"></i></button>'+
				'<button class="deleteRow btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-minus icon-white"></i></button>'+
			'</td>'+
		'</tr>';
	return ticketBlock;
}


var newTicketBlockCan = function(age_range,inventory,net,exchange, gross, markup){

	var ticketBlock = 
		'<tr class="aegaergre"  row="sub">'+
			'<td class="control-group"></td>'+
			'<td class="control-group" style="border-left:none"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;" value="'+age_range+'">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][inventory]" style="width:50px;" value="'+inventory+'">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][inventory][0][net]" style="width:75px;" value="'+net+'">'+	
					'<span status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																							
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryExchangeRate" type="text" name="data[Attraction_ticket][0][inventory][0][exchange]" style="width:75px;" disabled="disabled" value="'+exchange+'">'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][inventory][0][markup]" style="width:75px;" value="'+markup+'">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][inventory][0][gross]" style="width:75px;" value="'+gross+'">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button class="addAgeButton btn btn-small" type="button" main="notime-can"><i class="icon-plus"></i></button>'+
				'<button class="deleteRow btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-minus icon-white"></i></button>'+
			'</td>'+
		'</tr>';
	return ticketBlock;
}
/**
 * New time based ticket. US form. based on location of the attraction 
 * @param {Object} time
 */
var newTicketTimeUs = function(time){

	var ticketBlock = 
		'<tr class="newAgeRow" row="main" time="'+time+'">'+	
			'<td class="control-group"></td>'+
			'<td class="control-group" style="border-left:none"></td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="ticketTime" type="text" placeholder="" name="data[Attraction_ticket][0][inventory][0][time]" value="'+time+'" disabled="disabled" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+		
				'<input type="hidden" class="ticketTimeFinal" type="text" placeholder="" name="data[Attraction_ticket][0][inventory][0][time]" style="width:100px;" value="'+time+'">'+												
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][age_range]" placeholder="i.e. Adults (16+)" value="" style="width:125px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][age_range][inventory][0][age_range][0][inventory]" style="width:50px;" >'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][net]" style="width:75px;" >'+	
				'</div>'+
				'<span class="help-block"></span>'+		
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][markup]" style="width:75px;" >'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][gross]" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
			
				'<button class="addAgeButton btn btn-small" type="button" main="time-us" time="'+time+'"><i class="icon-plus"></i></button>'+
				'<button class="deleteRow btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-trash icon-white"></i></button>'+
			'</td>'+
		'</tr>';
		

	return ticketBlock;
}

var newTicketSubTimeUs = function(age_range,inventory,net,markup,gross, time){
	var sub_block = 
		'<tr row="sub" time="'+time+'">'+	
			'<td class="control-group" style=""></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][age_range]" value="'+age_range+'" style="width:125px">'+
				'</div>'+
				'<span class="help-block"></span>'+																										
			'</td>'+		
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][inventory]" value="'+inventory+'" style="width:50px;">'+
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">US$</span>'+
					'<input type="text" class="inventoryNetRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][net]" value="'+net+'" style="width:75px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input type="text" class="inventoryMarkupRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][markup]" value="'+markup+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input type="text" class="inventoryGrossRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][gross]" value="'+gross+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button class="addAgeButton btn btn-small" type="button" main="time-us" time="'+time+'"><i class="icon-plus" ></i></button>'+
				'<button class="deleteRow btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-minus icon-white"></i></button>'+			
			'</td>'+
		'</tr>';
		return sub_block;	
}
var newTicketSubTimeCan = function(age_range,inventory,exchange,net,markup,gross, time){
	var sub_block = 
		'<tr row="sub" time="'+time+'">'+	
			'<td class="control-group" style=""></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][age_range]" value="'+age_range+'" style="width:125px">'+
				'</div>'+
				'<span class="help-block"></span>'+																										
			'</td>'+		
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][inventory]" value="'+inventory+'" style="width:50px;">'+
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input type="text" class="inventoryNetRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][net]" value="'+net+'" style="width:75px;">'+	
					'<span status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryExchangeRate" type="text" name="data[Attraction_ticket][0][inventory][0][exchange]" style="width:75px;" disabled="disabled" value="'+exchange+'">'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input type="text" class="inventoryMarkupRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][markup]" value="'+markup+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input type="text" class="inventoryGrossRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][gross]" value="'+gross+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button class="addAgeButton btn btn-small" type="button" main="time-can"><i class="icon-plus" ></i></button>'+
				'<button class="deleteRow btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-minus icon-white"></i></button>'+			
			'</td>'+
		'</tr>';
		return sub_block;	
}
var newTicketTimeCan = function(time){
	var exchange = $(".exchange").val();
	var ticketBlock = 
		'<tr class="newAgeRow" time="'+time+'">'+	
			'<td class="control-group"></td>'+
			'<td class="control-group" style="border-left:none"></td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="ticketTime" type="text" placeholder="" name="data[Attraction_ticket][0][inventory][0][time]" style="width:75px;" value="'+time+'" disabled="disabled">'+
				'</div>'+
				'<span class="help-block"></span>'+		
				'<input type="hidden" class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket][0][inventory][0][time]" style="width:75px;" value="'+time+'">'+												
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][age_range]" placeholder="i.e. Adults (16+)" value="" style="width:125px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][age_range][inventory][0][age_range][0][inventory]" style="width:50px;" >'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][net]" style="width:75px;" >'+	
					'<span status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryExchangeRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][exchange]" value="'+exchange+'" disabled="disabled" style="width:75px;" >'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][markup]" style="width:75px;" >'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][gross]" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button class="addAgeButton btn btn-small" type="button" main="time-can"><i class="icon-plus"></i></button>'+
				'<button class="deleteRow btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-minus icon-white"></i></button>'+
			'</td>'+
		'</tr>';
	return ticketBlock;
}

var newAgeRangeBlockUs = function(time, net, gross, markup, inventory){
	var ageRange = 
		'<tr row="sub" time="'+time+'" >'+	
			'<td class="control-group" style=""></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][age_range]" value="" style="width:125px">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+
							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][inventory]" value="'+inventory+'" style="width:50px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input type="text" class="inventoryNetRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][net]" value="'+net+'" style="width:75px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input type="text" class="inventoryMarkupRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][markup]" value="'+markup+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+			
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input type="text" class="inventoryGrossRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][gross]" value="'+gross+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button class="addAgeRange btn btn-small" type="button"><i class="icon-plus"></i></button>'+
				'<button class="deleteRow btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-minus icon-white"></i></button>'+
				
			'</td>'+
		'</tr>';
		
	return ageRange;
}

var newAgeRangeBlockCan = function(time, net, gross, markup, inventory){
	var exchange = $(".exchange").val();
	var ageRange = 
		'<tr row="sub" time="'+time+'" >'+	
			'<td class="control-group" style=""></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group" style="border-left:none;"></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][age_range]" value="" style="width:125px">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+
							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][age_range][0][inventory]" value="'+inventory+'" style="width:50px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input type="text" class="inventoryNetRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][net]" value="'+net+'" style="width:75px;">'+	
					'<span status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input type="text" class="inventoryExchangeRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][exchange]" value="'+exchange+'" disabled="disabled"  style="width:75px;">'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input type="text" class="inventoryMarkupRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][markup]" value="'+markup+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+			
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input type="text" class="inventoryGrossRate" name="data[Attraction_ticket][0][inventory][0][age_range][0][gross]" value="'+gross+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
				'<button id="removeAgeRowNew-'+idx+'-'+newButtonRow+'" type="button" class="removeAgeRow btn btn-small btn-danger"><i class="icon-trash icon-white"></i></button>'+
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
var createTax = function(room_id,tax_id,tax_name,tax_rate,tax_country){
	var tax =
		'<div class="taxesRatesDivs alert alert-info" style="margin-bottom:2px;">'+
			'<button type="button" class="removeTax pull-right" ><icon class="icon-trash"></icon></button>'+
			'<label class="control-label">'+tax_name+'</label>'+
			'<div class="controls">'+
				'<div class="input-append">'+
					
					'<input id="taxesInput-'+tax_id+'" class="taxesInput" type="text" name="data[Attraction_ticket]['+room_id+'][taxes]['+tax_id+']" value="'+tax_rate+'"/>'+
					'<span class="add-on">'+tax_country+'</span>'+
				'</div>'+
				//'<input type="hidden" class="taxRateInput" name="data[Attraction_ticket]['+room_id+'][taxes]['+tax_id+']" value="'+tax_id+'"/>'+
			'</div>'+
		'</div>';
		
	return tax;
}
var getAddOnExchange = function(row, net,flag, exchange,old, gross){
	
	var name = '<input type="hidden" class="attractionAddOnFlag" value="Attraction" name="data[Attraction][Exchange_pricing]['+row+'][name]" />';
	var desc = '<input type="hidden" class="attractionAddOnFlag" value="Add Ons" name="data[Attraction][Exchange_pricing]['+row+'][description]"/>';
	var flag = '<input type="hidden" class="attractionAddOnFlag" value="'+flag+'" name="data[Attraction][Exchange_pricing]['+row+'][flag]"/>';
	var flag_value = '<input type="hidden" class="attractionAddOnFlag" value="'+gross+'" name="data[Attraction][Exchange_pricing]['+row+'][flag_value]"/>';
	var net = '<input type="hidden" class="attractionAddOnFlag" value="'+net+'" name="data[Attraction][Exchange_pricing]['+row+'][net]"/>';
	var gross ='<input type="hidden" class="attractionAddOnFlag" value="'+old+'" name="data[Attraction][Exchange_pricing]['+row+'][gross]" exchange="Yes"/>';
	
	return name+desc+flag+flag_value+net+gross; 

}

//new Tbody no time us
var new_tbody1 = function(){
	newTbody = 
		'<tbody id="ticketInventoryTbody-0" class="ticketInventoryTbody" special="primary">'+
			'<tr class="newAgeRow" row="top">'+	
				'<td class="control-group">'+
					'<div class="input-append">'+
						'<input class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][inventory][0][start_date]" style="width:100px;">'+
						'<span class="add-on"><i class="icon-calendar"></i></span>'+
					'</div>'+
					'<span class="help-block"></span>'+														
				'</td>'+
				'<td class="control-group">'+
					'<div class="input-append">'+
						'<input last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][inventory][0][end_date]" style="width:100px;" >'+
						'<span class="add-on"><i class="icon-calendar"></i></span>'+
					'</div>'+
					'<span class="help-block"></span>'+														
				'</td>'+
				// '<td class="control-group">'+
					// '<div class="input-append">'+
						// '<input class="ticketTime" type="text" placeholder=""  style="width:75px;" >'+
					// '</div>'+
					// '<span class="help-block"></span>'+	
					// '<input  class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket][0][inventory][0][time]" style="width:100px;">'+													
				// '</td>'+
				'<td class="control-group">'+
					'<div class="input-prepend">'+
						'<input class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px">'+
					'</div>'+
					'<span class="help-block"></span>'+																											
				'</td>'+							
				'<td class="control-group">'+
					'<div class="input-append">'+
						'<input class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][inventory]" style="width:50px;">'+	
					'</div>'+
					'<span class="help-block"></span>'+											
				'</td>'+
				'<td class="control-group">'+
					'<div class="input-prepend">'+
						'<span class="add-on">US$</span>'+
						'<input class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][inventory][0][net]" style="width:75px;" >'+	
					'</div>'+
					'<span class="help-block"></span>'+		
					//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
				'</td>'+
				'<td class="control-group">'+
					'<div class="input-append">'+
						'<input class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][inventory][0][markup]" style="width:75px;">'+	
						'<span class="add-on">%</span>'+
					'</div>'+
					'<span class="help-block"></span>'+																									
				'</td>'+
				'<td class="control-group">'+
					'<div class="input-prepend">'+
						'<span class="add-on">US$</span>'+
						'<input class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][inventory][0][gross]" style="width:75px;">'+
					'</div>'+
					'<span class="help-block"></span>'+													
				'</td>'+
				'<td>'+
				
					'<button class="addAgeButton btn btn-small" type="button" main="notime-us"><i class="icon-plus"></i></button>'+
					'<button class="deleteTbody btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-trash icon-white"></i></button>'+
				'</td>'+
			'</tr>'+
		'</tbody>';	
		
		return newTbody;
}
//new tbody time us
var new_tbody2 = function(){
	newTbody = 
	'<tbody id="ticketInventoryTbody-0" class="ticketInventoryTbody" special="primary">'+
		'<tr class="newAgeRow" row="top">'+	
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][inventory][0][start_date]" style="width:100px;">'+
					'<span class="add-on"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][inventory][0][end_date]" style="width:100px;">'+
					'<span class="add-on"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="ticketTime" type="text" placeholder=""  style="width:75px;" disabled="disabled">'+
				'</div>'+
				'<span class="help-block"></span>'+	
				'<input  class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket][0][inventory][0][time]" style="width:100px;">'+													
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket0Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][inventory]" style="width:50px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">US$</span>'+
					'<input id="AttractionTicket0Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][inventory][0][net]" value="0" style="width:75px;">'+	

				'</div>'+
				'<span class="help-block"></span>'+		
				//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][inventory][0][markup]"  style="width:75px;" >'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket0Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][inventory][0][gross]" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
			
				'<button class="addAgeButton btn btn-small" type="button" main="time-us"><i class="icon-plus"></i></button>'+
				'<button class="deleteTbody btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-trash icon-white"></i></button>'+
			'</td>'+
		'</tr>'+
	'</tbody>';	
	return newTbody;						
}
//new tbody no time can
var new_tbody3 = function(){
	var exchange = $(".exchange").val();
	newTbody = 
	'<tbody id="ticketInventoryTbody-0" class="ticketInventoryTbody" special="primary">'+
		'<tr class="newAgeRow" row="top">'+	
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][inventory][0][start_date]" style="width:100px;">'+
					'<span class="add-on"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][inventory][0][end_date]" style="width:100px;">'+
					'<span class="add-on"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+

			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket0Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][inventory]" style="width:50px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input id="AttractionTicket0Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][inventory][0][net]" value="0" style="width:75px;">'+	
					'<span id="switchNetRate-0-0" status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+		
				//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket][0][inventory][0][exchange]" style="width:75px;" disabled="disabled" value="'+exchange+'" >'+	
					'<span class="add-on">CAN/USD</span>'+												
				'</div>'+
				'<span class="help-block"></span>'+		
				//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][inventory][0][markup]"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket0Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][inventory][0][gross]" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
			
				'<button class="addAgeButton btn btn-small" type="button" main="notime-can"><i class="icon-plus"></i></button>'+
				'<button class="deleteTbody btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-trash icon-white"></i></button>'+
			'</td>'+
		'</tr>'+
	'</tbody>';	
	return newTbody;						
}
//new tbody time can
var new_tbody4 = function(){
	var exchange = $(".exchange").val();
	newTbody = 
	'<tbody id="ticketInventoryTbody-0" class="ticketInventoryTbody" special="primary">'+
		'<tr class="newAgeRow" row="top">'+	
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][inventory][0][start_date]" style="width:100px;">'+
					'<span class="add-on"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0EndDate" last="last" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Attraction_ticket][0][inventory][0][end_date]" style="width:100px;">'+
					'<span class="add-on"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Time" class="ticketTime" type="text" placeholder=""  style="width:75px;" disabled="disabled">'+
				'</div>'+
				'<span class="help-block"></span>'+	
				'<input id="AttractionTicket0Inventory0Time" class="ticketTimeFinal" type="hidden" placeholder="" name="data[Attraction_ticket][0][inventory][0][time]">'+													
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<input id="AttractionTicket0Inventory0AgeRange" class="ticketAgeRange" type="text" name="data[Attraction_ticket][0][inventory][0][age_range]" placeholder="i.e. Adults (16+)" style="width:125px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Inventory" class="inventoryInventory" type="text" name="data[Attraction_ticket][0][inventory][0][inventory]" style="width:50px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input id="AttractionTicket0Inventory0Net" class="inventoryNetRate" type="text" name="data[Attraction_ticket][0][inventory][0][net]" value="0" style="width:75px;">'+	
					'<span id="switchNetRate-0-0" status="canusd" class="switchNetRate add-on btn btn-small btn-link">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+		
				//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Exchange" class="inventoryExchangeRate" type="text" name="data[Attraction_ticket][0][inventory][0][exchange]" style="width:75px;" disabled="disabled" value="'+exchange+'" >'+	
					'<span class="add-on">CAN/USD</span>'+												
				'</div>'+
				'<span class="help-block"></span>'+		
				//'<input id="Attraction_ticket'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Attraction_ticket]['+num+'][inventory][0][net]" value="0">'+																							
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="AttractionTicket0Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Attraction_ticket][0][inventory][0][markup]"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="AttractionTicket0Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Attraction_ticket][0][inventory][0][gross]" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
			'<td>'+
			
				'<button class="addAgeButton btn btn-small" type="button" main="time-can"><i class="icon-plus"></i></button>'+
				'<button class="deleteTbody btn btn-small btn-danger" type="button" style="margin-left:2px;"><i class="icon-trash icon-white"></i></button>'+
			'</td>'+
		'</tr>'+
	'</tbody>';	
	return newTbody;						
}



var newTimeLi = function(time){
	var timeLi = '<li class="alert alert-info pull-left span2" time="'+time+'" style="margin-right:5px;"><button type="button" row="'+time+'" class="closeTimeButton close">&times;</button>'+time+'</li>';	
	return timeLi;
}

var blankTrUs = function(){
	tr = 
		'<tr id="attractionAddOnTr-0" class="attractionAddOnTr">'+
			'<td><input id="attractionAddOnTitle" type="text" name="data[Attraction][add_ons][0][title]" value=""/></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="attractionAddOnPrice-0" class="attractionAddOnPrice" type="text" class="span10" name="data[Attraction][add_ons][0][price]" value="0"/>'+
				'</div>'+
			'</td>'+
			'<td id="attractionRadioTr" class="form-inline">'+
				'<label id="attractionAddOnPerBasisLabel1" class="radio"><input id="attractionAddOnPerBasis-onetime" class="attractionAddOnPerBasis" type="radio" name="data[Attraction][add_ons][0][per_basis]" value="onetime" checked="checked"/> One Time Price</label>'+
				'<label id="attractionAddOnPerBasisLabel2" class="radio"><input id="attractionAddOnPerBasis-pernight" class="attractionAddOnPerBasis" type="radio" name="data[Attraction][add_ons][0][per_basis]" value="pernight"/> Per Night</label>'+		
			'</td>'+
		'</tr>';	
	return tr;	
}
var blankTrCan = function(){
	var exchange = $(".exchange").val();
	tr = 
		'<tr id="attractionAddOnTr-0" class="attractionAddOnTr">'+
			'<td><input id="attractionAddOnTitle" type="text" name="data[Attraction][add_ons][0][title]" value=""/></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">CN$</span>'+
					'<input id="attractionAddOnNet-<?php echo $idx;?>" class="attractionAddOnNet" type="text" class="span10" name="data[Attraction][add_ons][0][net]" style="width:75px" value=""/>'+
				'</div>'+
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="attractionAddOnExchange-<?php echo $idx;?>" class="attractionAddOnExchange" type="text" class="span10" name="data[Attraction][add_ons][0][exchange]" style="width:75px" value="'+exchange+'" disabled="disabled"/>'+
					'<span class="add-on">CAN/US</span>'+
				'</div>'+
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="attractionAddOnGross-<?php echo $idx;?>" class="attractionAddOnGross" type="text" class="span10" name="data[Attraction][add_ons][0][gross]" style="width:75px" value=""/>'+
				'</div>'+
			'</td>'+
			'<td id="attractionRadioTr" class="form-inline">'+
				'<label id="attractionAddOnPerBasisLabel1" class="radio"><input id="attractionAddOnPerBasis-onetime" class="attractionAddOnPerBasis" type="radio" name="data[Attraction][add_ons][0][per_basis]" value="onetime" checked="checked"/> One Time Price</label>'+
				'<label id="attractionAddOnPerBasisLabel2" class="radio"><input id="attractionAddOnPerBasis-pernight" class="attractionAddOnPerBasis" type="radio" name="data[Attraction][add_ons][0][per_basis]" value="pernight"/> Per Night</label>'+
			'</td>'+
		'</tr>';
	return tr;
}
