var hotelBlock = function(row, newDate){
	var block = 
		'<tr>'+
			'<td>'+
				'<h5 class="heading">Hotel Block Set: <span>'+(row+1)+'</span></h5>'+
				'<div class="control-group pull-left" style="margin-right:15px;">'+
					'<label>Hotel Block Quantity</label>'+
					'<div class="input-append">'+
						'<input id="HotelBlocks'+row+'BlockQuantity" class="hotelBlockQuantity" type="text" name="data[Hotel][blocks]['+row+'][block_quantity]">'+
						'<span class="add-on">#</span>'+
					'</div>'+
					'<span class="help-block"></span>'+
				'</div>'+
				'<div class="control-group pull-left" style="margin-right:15px;">'+
					'<label>Block Begin Date</label>'+
					'<input id="HotelBlocks'+row+'StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel][blocks]['+row+'][start_date]" value="'+newDate+'">'+
					'<span class="help-block"></span>'+
				'</div>'+
				'<div class="control-group clearfix">'+
					'<label>Block End Date</label>'+
					'<input id="HotelBlocks'+row+'EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel][blocks]['+row+'][end_date]">'+
					'<span class="help-block"></span>'+
				'</div>'+
			'</td>'+
		'</tr>';
		
	return block;
}
var addOnsUs = function(num) {
	//get room add-ons
	var addOnLength = $("#hotelAddOnTbody tr").length;
	if(addOnLength >0){
		var addOns = '';
		$("#hotelAddOnTbody tr").each(function(idx){
			var title = $(this).find("#hotelAddOnTitle").val();
			var net = $(this).find(".hotelAddOnNet").val();
			var per_basis = $(this).find("input:checked").val();
			var markup = $(this).find('.hotelAddOnMarkup').val();
			var gross = $(this).find(".hotelAddOnGross").val();
			switch (per_basis){
				case 'onetime':
					per_basis = 'One Time Fee';
				break;
				
				case 'pernight':
					per_basis = 'Per Night Fee';
				break;
			}
			
			addOns = addOns+
				'<tr num="'+num+'" idx="'+idx+'">'+
					'<td>'+
						'<label class="checkbox"><input class="addOnCheckList" type="checkbox" checked="checked" name="addOnCheckList"/></label>'+
					'</td>'+
					'<td class="addOnActiveRow-title">'+title+' <input class="inventoryAddOnsTitle" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][title]" value="'+title+'"/></td>'+
					'<td class="addOnActiveRow-net">US$'+net+' <input class="inventoryAddOnsNet" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][net]" value="'+net+'"/></td>'+
					'<td class="addOnActiverow-markup">'+markup+'% <input class="inventoryAddOnsMarkup" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][markup]" value="'+markup+'"/>'+
					'<td class="addOnActiveRow-gross">US$'+gross+' <input class="inventoryAddOnsGross" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][gross]" value="'+gross+'"/></td>'+
					'<td class="addOnActiveRow-perbasis">'+per_basis+' <input class="inventoryAddOnsPerBasis" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][per_basis]" value="'+per_basis+'"/></td>'+

				'</tr>';
		});	
		var tableAddOnStart = 
			'<table class="table table-bordered table-condensed table-hover">'+
				'<thead>'+
					'<tr>'+
						'<th style="width:20px"></th>'+
						'<th>Add-On Name</th>'+
						'<th>Net</th>'+
						'<th>Markup</th>'+
						'<th>Gross</th>'+
						'<th>Per Basis</th>'+

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
	var addOnLength = $("#hotelAddOnTbody tr").length;
	if(addOnLength >0){
		var addOns = '';
		$("#hotelAddOnTbody tr").each(function(idx){
			var title = $(this).find("#hotelAddOnTitle").val();
			var net = $(this).find(".hotelAddOnNet").val();
			var exchange = $(this).find('.hotelAddOnExchange').val();
			var markup = $(this).find('.hotelAddOnMarkup').val();
			var gross = $(this).find('.hotelAddOnGross').val();
			var per_basis = $(this).find("input:checked").val();
			switch (per_basis){
				case 'onetime':
					per_basis = 'One Time Fee';
				break;
				
				case 'pernight':
					per_basis = 'Per Night Fee';
				break;
			}		
			addOns = addOns+
				'<tr num="'+num+'" idx="'+idx+'">'+
					'<td>'+
						'<label class="checkbox"><input class="addOnCheckList" type="checkbox" checked="checked" name="addOnCheckList"/></label>'+
					'</td>'+
					'<td class="addOnActiveRow-title">'+title+' <input class="inventoryAddOnsTitle" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][title]" value="'+title+'"/></td>'+
					'<td class="addOnActiveRow-net">CN$'+net+' <input class="inventoryAddOnsNet" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][net]" value="'+net+'"/></td>'+
					'<td class="addOnActiveRow-exchange">'+exchange+' CAN/USD <input class="inventoryAddOnsExchange" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][exchange]" value="'+exchange+'"/></td>'+
					'<td class="addOnActiveRow-markup">'+markup+'% <input class="invnentoryAddOnsMarkup" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][markup]" value="'+markup+'"/></td>'+
					'<td class="addOnActiveRow-gross">US$'+gross+' <input class="inventoryAddOnsGross" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][gross]" value="'+gross+'"/></td>'+
					'<td class="addOnActiveRow-perbasis">'+per_basis+' <input class="inventoryAddOnsPerBasis" type="hidden" name="data[Hotel_room]['+num+'][add_ons]['+idx+'][per_basis]" value="'+per_basis+'"/></td>'+

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
						'<th>Markup</th>'+
						'<th>Gross</th>'+
						'<th>Per Basis</th>'+

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


  
 
/**
 * US Form For new room 
 * @param {Object} num
 * @param {Object} get_addOns
 */
var newRoomUs = function(num, get_addOns){
	//reset all of the accordion headings
	$("#accordionRoomType .accordion-heading a").attr('class','accordion-toggle collapsed');
	$("#accordionRoomType .accordion-body").attr('class','accordion-body collapse');

	//click to top
	$("#toTop").click();
	var attribute = 'accordion-toggle acc-in';
	var attribute2 = 'accordion-body collapse in';	

	
	//tax rates
	$("#taxRateDiv .taxSelection").attr('num','new-'+num);
	var tax_rates = $("#taxRateDiv").html();
	
	var room = 
		'<div id="hotelRoomNew-'+num+'"  class="hotelRoomNew accordion-group" idx="'+num+'"  style="background:#fff;" method="New">'+
			'<div class="accordion-heading" name="hotelRoom">'+
				'<a class="'+attribute+'" data-toggle="collapse" data-parent="#accordionRoomType" href="#roomType-n-'+num+'"><h4>Room Name: <span id="roomTypeSpan-'+num+'" class="roomTypeSpan">New Room</span> <span id="roomTypeLabel-'+num+'"></span></h4></a>'+
			'</div>'+
			'<div id="roomTypen-n-'+num+'" class="'+attribute2+'">'+
				'<div id="roomInventoryDiv" class="accordion-inner">'+
					'<div id="hotelRoomInventoryDiv-'+num+'">'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 1:<span class="f_req">*</span> <strong>Room Information</strong></h5>'+
							'<div class="form-horizontal">'+
								'<div class="control-group">'+				
									'<label class="control-label">Hotel Room Name</label>'+
									'<div class="controls">'+
										'<input id="Hotel_room_new'+num+'Name" class="hotelRoomName span6" dataRow="'+num+'" type="text" placeholder="enter a hotel room type" name="data[Hotel_room_new]['+num+'][name]">'+						
										'<span class="help-inline"></span>'+
									'</div>'+			
								'</div>'+
								'<div class="control-group">'+
									'<label class="control-label">Room Status</label>'+
									'<div class="controls">'+
									'<select id="HotelRoom'+num+'Status" name="data[Hotel_room][status]">'+
										'<option value="">Select Here</option>'+
										'<option value="1">Unfinished</option>'+
										'<option value="2">Unbookable</option>'+
										'<option value="3">Unbookable, except in packages</option>'+
										'<option value="4">Unbookable, except in packages or by employees</option>'+
										'<option value="5">Bookable, but not public</option>'+
										'<option selected="selected" value="6">Bookable, and public</option>'+
									'</select>'+					
									'<span class="help-inline"></span>'+
									'</div>'+
								'</div>'+
								'<div class="control-group">'+
									'<label class="control-label">Base Occupancy</label>'+
									'<div class="controls">'+
										'<div class="input-prepend">'+
											'<span class="add-on">#</span>'+
											'<input id="Hotel_room_new'+num+'OccupancyBase" class="hotelOccupancyBase" dataRow="'+num+'" type="text" value="2" name="data[Hotel_room_new]['+num+'][occupancy_base]">'+
										'</div>'+
										'<span class="help-inline"></span>'+
									'</div>'+
								'</div>'+
								'<div class="control-group">'+
									'<label class="control-label">Max Occupancy</label>'+
									'<div class="controls">'+
										'<div class="input-prepend">'+
											'<span class="add-on">#</span>'+
											'<input id="Hotel_room_new'+num+'OccupancyMax" class="hotelOccupancyMax" dataRow="'+num+'" type="text" value="4" name="data[Hotel_room_new]['+num+'][occupancy_max]">'+
										'</div>'+
										'<span class="help-inline"></span>'+
									'</div>'+
								'</div>'+
								'<div class="well well-small">'+
									'<h5 class="heading">Extra Person Fee</h5>'+
									'<div class="control-group">'+
										'<label class="control-label">Net</label>'+
										'<div class="controls">'+
											'<div class="input-prepend">'+
												'<span class="add-on">US$</span>'+
												'<input id="Hotel_room'+num+'Net" class="hotelPlusFeeNet" dataRow="'+num+'" type="text" name="data[Hotel_room]['+num+'][plus_net]">'+
											'</div>'+
											'<span class="help-inline"></span>'+
										'</div>'+
									'</div>'+
									'<div class="control-group">'+
										'<label class="control-label">Gross</label>'+
										'<div class="controls">'+
											'<div class="input-prepend">'+
												'<span class="add-on">US$</span>'+
												'<input id="Hotel_room'+num+'PlusFee" class="hotelExtraFee" dataRow="'+num+'" type="text" name="data[Hotel_room]['+num+'][plus_fee]">'+
											'</div>'+
											'<span class="help-inline"></span>'+
										'</div>'+
									'</div>'+
								'</div>'+
								// '<div class="control-group">'+
									// '<label class="control-label">Extra Person Fee</label>'+
									// '<div class="controls">'+
										// '<div class="input-prepend">'+
											// '<span class="add-on">US$</span>'+
											// '<input id="Hotel_room_new'+num+'PlusFee" class="hotelExtraFee" dataRow="'+num+'" type="text" name="data[Hotel_room_new]['+num+'][plus_fee]">'+
										// '</div>'+
										// '<span class="help-inline"></span>'+
									// '</div>'+
								// '</div>'+
							'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 2: <strong>Room Add-Ons - <em>Deselect add-ons that are not applicable</em></strong></h5>'+
							'<div class="control-group">'+get_addOns+'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 3: <span class="f_req">*</span><strong>Tax Rate Setup</strong></h5>'+
							'<div id="'+num+'" class="form-horizontal">'+tax_rates+
								'<div class="control-group">'+
									'<label class="control-label"><strong>Tax Rate</strong></label>'+
									'<div class="controls">'+
										'<div class="input-append">'+
											'<input id="taxrateNew-'+num+'" class="taxrate" disabled="disabled" type="text" name="" value="0"/>'+
											'<span class="add-on">%</span>'+
										'</div>'+
										'<input id="taxrateNew-'+num+'" class="taxrate" type="hidden" name="data[Hotel_room_new]['+num+'][tax_rate]" value=""/>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+

						'<div class="formSep clearfix">'+
							'<h5 class="heading">Step 4:<span class="f_req">*</span> <strong>Room Schedule</strong></h5>'+
							'<table class="table table-condensed table-bordered table-striped table-vam">'+
								'<thead>'+
									'<tr>'+
										'<th>Room Schedule Begin Date</th>'+
										'<th>Room Schedule End Date</th>'+
										'<th>Available Rooms</th>'+
										'<th>Net Rate</th>'+
										'<th>Mark Up Rate</th>'+
										'<th>Gross Rate</th>'+
									'<tr>'+
								'</thead>'+
								
								'<tbody id="roomInventoryTbodyNew-'+num+'">'+
									'<tr>'+	
										'<td class="control-group">'+
											'<div class="input-append">'+
												'<input id="HotelRoomNew'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room_new]['+num+'][Inventory][0][start_date]" style="width:100px;">'+
												'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
											'</div>'+
											'<span class="help-block"></span>'+														
										'</td>'+
										'<td class="control-group">'+
											'<div class="input-append">'+
												'<input id="HotelRoomNew'+num+'Inventory0EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room_new]['+num+'][Inventory][0][end_date]" style="width:100px;">'+
												'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
											'</div>'+
											'<span class="help-block"></span>'+														
										'</td>'+
										'<td class="control-group">'+
											'<div class="input-prepend">'+
												'<span class="add-on">#</span>'+
												'<input id="HotelRoomNew'+num+'Inventory0Total" class="roomBlockTotal" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][total]" style="width:75px;">'+
											'</div>'+
											'<span class="help-block"></span>'+																											
										'</td>'+							
										'<td class="control-group">'+
											'<div class="input-prepend">'+
												'<span class="add-on">US$</span>'+
												'<input id="Hotel_room_new'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][net]" value="0" style="width:75px;">'+	
											'</div>'+
											'<span class="help-block"></span>'+		
											//'<input id="Hotel_room'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Hotel_room]['+num+'][Inventory][0][net]" value="0">'+																							
										'</td>'+

										'<td class="control-group">'+
											'<div class="input-append">'+
												'<input id="Hotel_room_new'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][markup]" value="0" style="width:75px;">'+	
												'<span class="add-on">%</span>'+
											'</div>'+
											'<span class="help-block"></span>'+																									
										'</td>'+
										'<td class="control-group">'+
											'<div class="input-prepend">'+
												'<span class="add-on">US$</span>'+
												'<input id="Hotel_room_new'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][gross]" value="0" style="width:75px;">'+
											'</div>'+
											'<span class="help-block"></span>'+													
										'</td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
							'<div class="pull-right">'+
								'<button type="button" id="addRoomInventoryNew-'+num+'" class="btn btn-primary">Add New Schedule</button>'+
							'</div>'+
						'</div>'+
						'<div class="formSep clearfix">'+
							'<h5 class="heading">Step 5:<span class="f_req">*</span> <strong>Set Blackout Dates</strong></h5>'+
							'<div class="formRow">'+
								'<div class="w-box">'+
									'<div class="w-box-header">'+
										'<div class="pull-left">'+
											'Select Blackout Dates '+
											'<input id="fullYearNew-'+num+'" type="text" class="fullYear" placeholder="Click Here"/>'+											
										'</div>'+		
										'<div class="pull-right">'+		
											'<span id="blackoutDateCounterNew-'+num+'" class="label label-inverse">0 Blackout Dates Selected</span>'+
										'</div>'+
									'</div>'+
									'<div id="selectedBlackoutDatesNew-'+num+'" class="w-box-content" style="padding-left:10px; padding-top:5px">'+
										'<ul id="blackoutDatesUlNew-'+num+'" class="unstyled"></ul>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="formSep" style="height:40px;">'+
							'<button id="removeRoomButtonNew-'+num+'" type="button" class="removeRoomButton btn btn-danger btn-large pull-right">Remove Hotel Room</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';
	
	return room;
}

/**
 * Canadian Form For new room 
 * @param {Object} num
 * @param {Object} get_addOns
 */
var newRoomCan = function(num, get_addOns){
	//reset all of the accordion headings
	$("#accordionRoomType .accordion-heading a").attr('class','accordion-toggle collapsed');
	$("#accordionRoomType .accordion-body").attr('class','accordion-body collapse');

	//click to top
	$("#toTop").click();
	var attribute = 'accordion-toggle acc-in';
	var attribute2 = 'accordion-body collapse in';	

	var exRate = $(".exchange").val();
	//tax rates
	$("#taxRateDiv .taxSelection").attr('num','new-'+num);
	var tax_rates = $("#taxRateDiv").html();
	var room = 
		'<div id="hotelRoomNew-'+num+'"  class="hotelRoomNew accordion-group" idx="'+num+'" style="background:#fff;" method="New">'+
			'<div class="accordion-heading" name="hotelRoom">'+
				'<a class="'+attribute+'" data-toggle="collapse" data-parent="#accordionRoomType" href="#roomType-n-'+num+'"><h4>Room Name: <span id="roomTypeSpan-'+num+'" class="roomTypeSpan">New Room</span> <span id="roomTypeLabel-'+num+'"></span></h4></a>'+
			'</div>'+
			'<div id="roomType-n-'+num+'" class="'+attribute2+'">'+
				'<div id="roomInventoryDivNew" class="accordion-inner">'+
					'<div id="hotelRoomInventoryDivNew-'+num+'">'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 1:<span class="f_req">*</span> <strong>Room Information</strong></h5>'+
							'<div class="form-horizontal">'+
								'<div class="control-group">'+				
									'<label class="control-label">Hotel Room Name</label>'+
									'<div class="controls">'+
										'<input id="Hotel_room_new'+num+'Name" class="hotelRoomName span6" dataRow="'+num+'" type="text" placeholder="enter a hotel room type" name="data[Hotel_room_new]['+num+'][name]">'+						
										'<span class="help-inline"></span>'+
									'</div>'+			
								'</div>'+
								'<div class="control-group">'+
									'<label class="control-label">Room Status</label>'+
									'<div class="controls">'+
									'<select id="HotelRoom'+num+'Status" name="data[Hotel_room][status]">'+
										'<option value="">Select Here</option>'+
										'<option value="1">Unfinished</option>'+
										'<option value="2">Unbookable</option>'+
										'<option value="3">Unbookable, except in packages</option>'+
										'<option value="4">Unbookable, except in packages or by employees</option>'+
										'<option value="5">Bookable, but not public</option>'+
										'<option selected="selected" value="6">Bookable, and public</option>'+
									'</select>'+					
									'<span class="help-inline"></span>'+
									'</div>'+
								'</div>'+
								'<div class="control-group">'+
									'<label class="control-label">Base Occupancy</label>'+
									'<div class="controls">'+
										'<div class="input-prepend">'+
											'<span class="add-on">#</span>'+
											'<input id="Hotel_room_new'+num+'OccupancyBase" class="hotelOccupancyBase" dataRow="'+num+'" type="text" value="2" name="data[Hotel_room_new]['+num+'][occupancy_base]">'+
										'</div>'+
										'<span class="help-inline"></span>'+
									'</div>'+
								'</div>'+
								'<div class="control-group">'+
									'<label class="control-label">Max Occupancy</label>'+
									'<div class="controls">'+
										'<div class="input-prepend">'+
											'<span class="add-on">#</span>'+
											'<input id="Hotel_room_new'+num+'OccupancyMax" class="hotelOccupancyMax" dataRow="'+num+'" type="text" value="4" name="data[Hotel_room_new]['+num+'][occupancy_max]">'+
										'</div>'+
										'<span class="help-inline"></span>'+
									'</div>'+
								'</div>'+
								'<div class="well well-small">'+
									'<h5 class="heading">Extra Person Fee</h5>'+
									'<div class="control-group">'+
										'<label class="control-label">Net</label>'+
										'<div class="controls">'+
											'<div class="input-prepend">'+
												'<span class="add-on">CN$</span>'+
												'<input id="Hotel_room_new'+num+'Net" class="hotelPlusFeeNet" dataRow="'+num+'" type="text" name="data[Hotel_room_new]['+num+'][plus_net]">'+
											'</div>'+
											'<span class="help-inline"></span>'+
										'</div>'+
									'</div>'+
									'<div class="control-group">'+
										'<label class="control-label">Exchange</label>'+
										'<div class="controls">'+
											'<div class="input-append">'+
												'<input id="Hotel_room_new'+num+'ExchangeRate" class="hotelPlusFeeExchangeRate span6" dataRow="'+num+'" value="'+exRate+'" type="text" name="data[Hotel_room_new]['+num+'][exchange_rate]" disabled="disabled">'+
												'<span class="add-on">CAN/US</span>'+
											'</div>'+
											'<span class="help-inline"></span>'+
										'</div>'+
									'</div>'+
									'<div class="control-group">'+
										'<label class="control-label">Gross</label>'+
										'<div class="controls">'+
											'<div class="input-prepend">'+
												'<span class="add-on">US$</span>'+
												'<input id="Hotel_room_new'+num+'PlusFee" class="hotelExtraFee" dataRow="'+num+'" type="text" name="data[Hotel_room_new]['+num+'][plus_fee]">'+
											'</div>'+
											'<span class="help-inline"></span>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 2:<strong>Room Add-Ons - <em>Deselect add-ons that are not applicable</em></strong></h5>'+
							'<div class="control-group">'+get_addOns+'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h5 class="heading">Step 3: <span class="f_req">*</span><strong>Tax Rate Setup</strong></h5>'+
							'<div id="'+num+'" class="form-horizontal">'+tax_rates+
								'<div class="control-group">'+
									'<label class="control-label"><strong>Tax Rate</strong></label>'+
									'<div class="controls">'+
										'<div class="input-append">'+
											'<input id="taxrateNew-'+num+'" class="taxrate" disabled="disabled" type="text" name="" value="0"/>'+
											'<span class="add-on">%</span>'+
										'</div>'+
										'<input id="taxrateNew-'+num+'" class="taxrate" type="hidden" name="data[Hotel_room_new]['+num+'][tax_rate]" value=""/>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+

						'<div class="formSep clearfix">'+
							'<h5 class="heading">Step 4:<span class="f_req">*</span> <strong>Room Schedule</strong></h5>'+
							'<table class="table table-condensed table-bordered table-striped table-vam">'+
								'<thead>'+
									'<tr>'+
										'<th>Room Schedule Begin Date</th>'+
										'<th>Room Schedule End Date</th>'+
										'<th>Available Rooms</th>'+
										'<th>Net Rate</th>'+
										'<th>Exchange Rate</th>'+
										'<th>Mark Up Rate</th>'+
										'<th>Gross Rate</th>'+
									'<tr>'+
								'</thead>'+
								
								'<tbody id="roomInventoryTbodyNew-'+num+'">'+
									'<tr>'+	
										'<td class="control-group">'+
											'<div class="input-append">'+
												'<input id="HotelRoomNew'+num+'Inventory0StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room_new]['+num+'][Inventory][0][start_date]" style="width:100px;">'+
												'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
											'</div>'+
											'<span class="help-block"></span>'+														
										'</td>'+
										'<td class="control-group">'+
											'<div class="input-append">'+
												'<input id="HotelRoomNew'+num+'Inventory0EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room_new]['+num+'][Inventory][0][end_date]" style="width:100px;">'+
												'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
											'</div>'+
											'<span class="help-block"></span>'+														
										'</td>'+
										'<td class="control-group">'+
											'<div class="input-prepend">'+
												'<span class="add-on">#</span>'+
												'<input id="HotelRoomNew'+num+'Inventory0Total" class="roomBlockTotal" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][total]" style="width:75px;">'+
											'</div>'+
											'<span class="help-block"></span>'+																											
										'</td>'+							
										'<td class="control-group">'+
											'<div class="input-prepend input-append">'+
												'<span id="dollarSignSpan" class="add-on">CN$</span>'+
												'<input id="Hotel_room_new'+num+'Inventory0Net" class="inventoryNetRate" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][net]" value="0" style="width:75px;">'+	
												'<span id="Hotel_room_new'+num+'Inventory0ChangeCurrency" class="changeCurrencyStatus add-on btn btn-link" status="canusd">switch</span>'+
											'</div>'+
											'<span class="help-block"></span>'+		
											//'<input id="Hotel_room'+num+'Inventory0Net" class="inventoryNetRate" type="hidden" name="data[Hotel_room]['+num+'][Inventory][0][net]" value="0">'+																							
										'</td>'+
										'<td class="control-group">'+
											'<div class="input-append">'+
												'<input id="Hotel_room_new'+num+'Inventory0ExchangeRate" class="inventoryExchangeRate" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][exchange_rate]" disabled="disabled" style="width:75px;" value="'+exRate+'">'+	
												'<span class="add-on">CAN/USD</span>'+
											'</div>'+
											'<span class="help-block"></span>'+											
										'</td>'+
										'<td class="control-group">'+
											'<div class="input-append">'+
												'<input id="Hotel_room_new'+num+'Inventory0Markup" class="inventoryMarkupRate" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][markup]" value="0" style="width:75px;">'+	
												'<span class="add-on">%</span>'+
											'</div>'+
											'<span class="help-block"></span>'+																									
										'</td>'+
										'<td class="control-group">'+
											'<div class="input-prepend">'+
												'<span class="add-on">US$</span>'+
												'<input id="Hotel_room_new'+num+'Inventory0Gross" class="inventoryGrossRate" type="text" name="data[Hotel_room_new]['+num+'][Inventory][0][gross]" value="0" style="width:75px;">'+
											'</div>'+
											'<span class="help-block"></span>'+													
										'</td>'+
									'</tr>'+
								'</tbody>'+
							'</table>'+
							'<div class="pull-right">'+
								'<button type="button" id="addRoomInventoryNew-'+num+'" class="btn btn-primary">Add New Schedule</button>'+
							'</div>'+
						'</div>'+
						'<div class="formSep clearfix">'+
							'<h5 class="heading">Step 5:<span class="f_req">*</span> <strong>Set Blackout Dates</strong></h5>'+
							'<div class="formRow">'+
								'<div class="w-box">'+
									'<div class="w-box-header">'+
										'<div class="pull-left">'+
											'Select Blackout Dates '+
											'<input id="fullYearNew-'+num+'" type="text" class="fullYear" placeholder="Click Here"/>'+											
										'</div>'+		
										'<div class="pull-right">'+		
											'<span id="blackoutDateCounterNew-'+num+'" class="label label-inverse">0 Blackout Dates Selected</span>'+
										'</div>'+
									'</div>'+
									'<div id="selectedBlackoutDatesNew-'+num+'" class="w-box-content" style="padding-left:10px; padding-top:5px">'+
										'<ul id="blackoutDatesUlNew-'+num+'" class="unstyled"></ul>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="formSep" style="height:40px;">'+
							'<button id="removeRoomButtonNew-'+num+'" type="button" class="removeRoomButton btn btn-danger btn-large pull-right">Remove Hotel Room</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';
	
	return room;
}

var newRoomBlockUs = function(idx,num, newStartDate,netRate, grossRate, markupRate,available){
	var roomBlock = 
		'<tr>'+	
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="HotelRoom'+idx+'Inventory'+num+'StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][start_date]" style="width:100px;" value="'+newStartDate+'">'+
					'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="HotelRoom'+idx+'Inventory'+num+'EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][end_date]" style="width:100px;" value="'+newStartDate+'">'+
					'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">#</span>'+
					'<input id="HotelRoom'+idx+'Inventory'+num+'Total" class="roomBlockTotal" type="text" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][total]" value="'+available+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="Hotel_room'+idx+'Inventory'+num+'Net" type="text" class="inventoryNetRate" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][net]" value="'+netRate+'" style="width:75px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="Hotel_room'+idx+'Inventory'+num+'Markup" type="text" class="inventoryMarkupRate" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][markup]" value="'+markupRate+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+			
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="Hotel_room'+idx+'Inventory'+num+'Gross" type="text" class="inventoryGrossRate" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][gross]" value="'+grossRate+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
		'</tr>';
	return roomBlock;
}

var newRoomBlockCan = function(idx,num, newStartDate,exRate,netRate, grossRate, markupRate,available){
	var exchange = $("#exchange").val();
	var roomBlock = 
		'<tr>'+	
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="HotelRoom'+idx+'Inventory'+num+'StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][start_date]" style="width:100px;" value="'+newStartDate+'">'+
					'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="HotelRoom'+idx+'Inventory'+num+'EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][end_date]" style="width:100px;" value="'+newStartDate+'">'+
					'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">#</span>'+
					'<input id="HotelRoom'+idx+'Inventory'+num+'Total" class="roomBlockTotal" type="text" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][total]" value="'+available+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input id="Hotel_room'+idx+'Inventory'+num+'Net" type="text" class="inventoryNetRate" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][net]" value="'+netRate+'" style="width:75px;">'+	
					'<span id="Hotel_room'+idx+'Inventory'+num+'ChangeCurrency" class="switchCurrencyButton add-on btn btn-link" status="canusd">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="Hotel_room'+idx+'Inventory'+num+'ExchangeRate" class="inventoryExRate" type="text" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][exchange_rate]" value="'+exRate+'" disabled="disabled" style="width:75px;">'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="Hotel_room'+idx+'Inventory'+num+'Markup" type="text" class="inventoryMarkupRate" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][markup]" value="'+markupRate+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+			
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="Hotel_room'+idx+'Inventory'+num+'Gross" type="text" class="inventoryGrossRate" name="data[Hotel_room]['+idx+'][Inventory]['+num+'][gross]" value="'+grossRate+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
		'</tr>';
	return roomBlock;
}



var newRoomBlockUsNew = function(idx,num, newStartDate,netRate, grossRate, markupRate,available){
	var roomBlock = 
		'<tr>'+	
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="HotelRoomNew'+idx+'Inventory'+num+'StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][start_date]" style="width:100px;" value="'+newStartDate+'">'+
					'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="HotelRoomNew'+idx+'Inventory'+num+'EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][end_date]" style="width:100px;" value="'+newStartDate+'">'+
					'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">#</span>'+
					'<input id="HotelRoomNew'+idx+'Inventory'+num+'Total" class="roomBlockTotal" type="text" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][total]" value="'+available+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="Hotel_room_new'+idx+'Inventory'+num+'Net" type="text" class="inventoryNetRate" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][net]" value="'+netRate+'" style="width:75px;">'+	
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="Hotel_room_new'+idx+'Inventory'+num+'Markup" type="text" class="inventoryMarkupRate" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][markup]" value="'+markupRate+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+			
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="Hotel_room_new'+idx+'Inventory'+num+'Gross" type="text" class="inventoryGrossRate" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][gross]" value="'+grossRate+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
		'</tr>';
	return roomBlock;
}


var newRoomBlockCanNew = function(idx,num, newStartDate,exRate,netRate, grossRate, markupRate,available){
	var exchange = $("#exchange").val();
	var roomBlock = 
		'<tr>'+	
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="HotelRoomNew'+idx+'Inventory'+num+'StartDate" class="blockBeginDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][start_date]" style="width:100px;" value="'+newStartDate+'">'+
					'<span class="blockBeginSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="HotelRoomNew'+idx+'Inventory'+num+'EndDate" class="blockEndDate" type="text" placeholder="mm/dd/yyyy" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][end_date]" style="width:100px;" value="'+newStartDate+'">'+
					'<span class="blockEndSpan add-on" style="cursor:pointer;"><i class="icon-calendar"></i></span>'+
				'</div>'+
				'<span class="help-block"></span>'+														
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">#</span>'+
					'<input id="HotelRoomNew'+idx+'Inventory'+num+'Total" class="roomBlockTotal" type="text" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][total]" value="'+available+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+																											
			'</td>'+							
			'<td class="control-group">'+
				'<div class="input-prepend input-append">'+
					'<span id="dollarSignSpan" class="add-on">CN$</span>'+
					'<input id="Hotel_room_new'+idx+'Inventory'+num+'Net" type="text" class="inventoryNetRate" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][net]" value="'+netRate+'" style="width:75px;">'+	
					'<span id="Hotel_room_new'+idx+'Inventory'+num+'ChangeCurrency" class="switchCurrencyButton add-on btn btn-link" status="canusd">switch</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="Hotel_room_new'+idx+'Inventory'+num+'ExchangeRate" class="inventoryExRate" type="text" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][exchange_rate]" value="'+exRate+'" disabled="disabled" style="width:75px;">'+	
					'<span class="add-on">CAN/USD</span>'+
				'</div>'+
				'<span class="help-block"></span>'+											
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input id="Hotel_room_new'+idx+'Inventory'+num+'Markup" type="text" class="inventoryMarkupRate" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][markup]" value="'+markupRate+'"  style="width:75px;">'+	
					'<span class="add-on">%</span>'+
				'</div>'+
				'<span class="help-block"></span>'+																									
			'</td>'+			
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="Hotel_room_new'+idx+'Inventory'+num+'Gross" type="text" class="inventoryGrossRate" name="data[Hotel_room_new]['+idx+'][Inventory]['+num+'][gross]" value="'+grossRate+'" style="width:75px;">'+
				'</div>'+
				'<span class="help-block"></span>'+													
			'</td>'+
		'</tr>';
	return roomBlock;
}


var newRoomMarketing = function(num){
	var roomMarketing = 
		'<div id="marketingRoomNew-'+num+'" class="accordion-group">'+
			'<div class="accordion-heading">'+
				'<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#room-n-'+num+'"><h4 id="hotelRoomName-'+num+'"></h4></a>'+
			'</div>'+
			'<div id="room-n-'+num+'" class="accordion-body collapse">'+
				'<div class="accordion-inner">'+
					'<div id="hotel_room_marketing-'+num+'">'+
						'<div class="formSep">'+
							'<h4 class="heading">Select Primary Image For Room</h4>'+
							'<div id="mixed_grid" class="wmk_grid well well-large" >'+
								'<ul id="hotel_room_images-'+num+'" class="hotel_room_images" name="Hotel_room">'+'</ul>'+
							'</div>'+
						'</div>'+
						'<div class="formSep">'+
							'<h4>Create Room Description</h4>'+
							'<div class="control-group">'+
								'<label>Room Description</label>'+
								'<textarea name="data[Hotel_room_new]['+num+'][room_description]" class="span6" rows="5" cols="30"></textarea>'+
								'<span class="help-block"></span>'+
							'</div>'+	
						'</div>'+			
					'</div>'+
				'</div>'+	
			'</div>'+
		'</div>';
	return roomMarketing;
}


var createTax = function(room_id,tax_id,tax_name,tax_rate,tax_country,idx,row){
	var tax =
		'<div class="taxesRatesDivs alert alert-info" style="margin-bottom:2px;">'+
			'<button id="removeTax-'+tax_id+'" type="button" class="removeTax pull-right" ><icon class="icon-trash"></icon></button>'+
			'<label class="control-label">'+tax_name+'</label>'+
			'<div class="controls">'+
				'<div class="input-append">'+
					
					'<input id="taxesInput-'+tax_id+'" class="taxesInput" name="" type="text" disabled="disabled" value="'+tax_rate+'"/>'+
					'<span class="add-on">'+tax_country+'</span>'+
				'</div>'+
				'<input type="hidden" name="data[Hotel_room]['+room_id+'][taxes]['+tax_id+']" value="'+tax_id+'"/>'+
			'</div>'+
			
		'</div>';
	
	return tax;
}
var createTaxNew = function(tax_id,tax_name,tax_rate,tax_country,idx,row){
	var tax =
		'<div class="taxesRatesDivs alert alert-info" style="margin-bottom:2px;">'+
			'<button id="removeTax-'+idx+'-'+row+'" type="button" class="removeTax pull-right" ><icon class="icon-trash"></icon></button>'+
			'<label class="control-label">'+tax_name+'</label>'+
			'<div class="controls">'+
				'<div class="input-append">'+
					
					'<input id="taxesInput-'+idx+'-'+row+'" class="taxesInput" name="" type="text" disabled="disabled" value="'+tax_rate+'"/>'+
					'<span class="add-on">'+tax_country+'</span>'+
				'</div>'+
				'<input type="hidden" name="data[Hotel_room_new]['+idx+'][taxes]['+tax_id+']" value="'+tax_id+'"/>'+
			'</div>'+
			
		'</div>';

	return tax;
}
var getAddOnExchange = function(row, net,flag, exchange,old, gross){
	
	var name = '<input type="hidden" class="hotelAddOnFlag" value="Hotel" name="data[Hotel][Exchange_pricing]['+row+'][name]" />';
	var desc = '<input type="hidden" class="hotelAddOnFlag" value="Add Ons" name="data[Hotel][Exchange_pricing]['+row+'][description]"/>';
	var flag = '<input type="hidden" class="hotelAddOnFlag" value="'+flag+'" name="data[Hotel][Exchange_pricing]['+row+'][flag]"/>';
	var flag_value = '<input type="hidden" class="hotelAddOnFlag" value="'+gross+'" name="data[Hotel][Exchange_pricing]['+row+'][flag_value]"/>';
	var net = '<input type="hidden" class="hotelAddOnFlag" value="'+net+'" name="data[Hotel][Exchange_pricing]['+row+'][net]"/>';
	var gross ='<input type="hidden" class="hotelAddOnFlag" value="'+old+'" name="data[Hotel][Exchange_pricing]['+row+'][gross]" exchange="Yes"/>';
	
	return name+desc+flag+flag_value+net+gross; 

}

var getExtraFeeExchange = function(idx,row, net, flag, exchange, old, gross){
	var name = '<input type="hidden" class="hotelExtraFeeFlag" value="Hotel" name="data[Hotel_room]['+idx+'][Exchange_pricing]['+row+'][name]"/>';
	var desc = '<input type="hidden" class="hotelExtraFeeFlag" value="Extra Fee" name="data[Hotel_room]['+idx+'][Exchange_pricing]['+row+'][description]"/>';
	var flag = '<input type="hidden" class="hotelExtraFeeFlag" value="'+flag+'" name="data[Hotel_room]['+idx+'][Exchange_pricing]['+row+'][flag]"/>';
	var flag_value = '<input type="hidden" class="hotelExtraFeeFlag" value="'+gross+'" name="data[Hotel_room]['+idx+'][Exchange_pricing]['+row+'][flag_value]"/>';
	var net = '<input type="hidden" class="hotelExtraFeeFlag" value="'+net+'" name="data[Hotel_room]['+idx+'][Exchange_pricing]['+row+'][net]"/>';
	var gross ='<input type="hidden" class="hotelExtraFeeFlag" value="'+old+'" name="data[Hotel_room]['+idx+'][Exchange_pricing]['+row+'][gross]" exchange="Yes"/>';
	
	return name+desc+flag+flag_value+net+gross; 	
}


var blankTrUs = function(){
	tr = 
		'<tr id="hotelAddOnTr-0" class="hotelAddOnTr">'+
			'<td><input id="hotelAddOnTitle" type="text" name="data[Hotel][add_ons][0][title]" value=""/></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input id="hotelAddOnPrice-0" class="hotelAddOnNet" type="text" name="data[Hotel][add_ons][0][net]" value="0.00" style="width:75px"/>'+
				'</div>'+
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="hotelAddOnMarkup" type="text" name="data[Hotel][add_ons][0][markup]" style="width:75px;" value="0.00"/>'+
					'<span class="add-on">%</span>'+
				'</div>'+
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input class="hotelAddOnGross" type="text" name="data[Hotel][add_ons][0][gross]" style="width:75px;" value="0.00"/>'+
				'</div>'+
			'</td>'+	
			'<td id="hotelRadioTr" class="form-inline">'+
				'<label id="hotelAddOnPerBasisLabel1" class="radio"><input id="hotelAddOnPerBasis-onetime" class="hotelAddOnPerBasis" type="radio" name="data[Hotel][add_ons][0][per_basis]" value="onetime" checked="checked"/> One Time Price</label>'+
				'<label id="hotelAddOnPerBasisLabel2" class="radio"><input id="hotelAddOnPerBasis-pernight" class="hotelAddOnPerBasis" type="radio" name="data[Hotel][add_ons][0][per_basis]" value="pernight"/> Per Night</label>'+		
			'</td>'+
			'<td class="control-group"><button class="deleteAddOn btn btn-small" type="button"><i class="icon-trash"></i></button></td>'+
		'</tr>';	
	return tr;	
}
var blankTrCan = function(){
	var exchange = $(".exchange").val();
	tr = 
		'<tr id="hotelAddOnTr-0" class="hotelAddOnTr">'+
			'<td><input id="hotelAddOnTitle" type="text" name="data[Hotel][add_ons][0][title]" value=""/></td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">CN$</span>'+
					'<input class="hotelAddOnNet" type="text" name="data[Hotel][add_ons][0][net]" style="width:75px" value="0.00"/>'+
				'</div>'+
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="hotelAddOnExchange" type="text" name="data[Hotel][add_ons][0][exchange]" style="width:75px" value="'+exchange+'" disabled="disabled"/>'+
					'<span class="add-on">CAN/US</span>'+
				'</div>'+
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-append">'+
					'<input class="hotelAddOnMarkup" type="text" name="data[Hotel][add_ons][0][markup]" style="width:75px" value="0.00"/>'+
					'<span class="add-on">%</span>'+
				'</div>'+
			'</td>'+
			'<td class="control-group">'+
				'<div class="input-prepend">'+
					'<span class="add-on">US$</span>'+
					'<input class="hotelAddOnGross" type="text" name="data[Hotel][add_ons][0][gross]" style="width:75px" value="0.00"/>'+
				'</div>'+
			'</td>'+
			'<td id="hotelRadioTr" class="form-inline">'+
				'<label id="hotelAddOnPerBasisLabel1" class="radio"><input id="hotelAddOnPerBasis-onetime" class="hotelAddOnPerBasis" type="radio" name="data[Hotel][add_ons][0 d][per_basis]" value="onetime" checked="checked"/> One Time Price</label>'+
				'<label id="hotelAddOnPerBasisLabel2" class="radio"><input id="hotelAddOnPerBasis-pernight" class="hotelAddOnPerBasis" type="radio" name="data[Hotel][add_ons][0[per_basis]" value="pernight"/> Per Night</label>'+
			'</td>'+
			'<td class="control-group"><button class="deleteAddOn btn btn-small" type="button"><i class="icon-trash"></i></button></td>'+
		'</tr>';
	return tr;
}
