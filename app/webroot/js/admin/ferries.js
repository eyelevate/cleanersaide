$(document).ready(function(){
	
	//update the ferry rates on the ferry add page
	$(".ferry_oneWay").bind('blur',function(){
		var oneWay = $(this).val();
		var oneWay_id = $(this).parent().parent().parent().attr('id').replace('setOneWayTd-','');
        var pattern = /^\d+(?:\.\d{0,2})$/ ;
        var intPattern = /^\d+$/ ;
		if(intPattern.test(oneWay)){
			var oneWay = parseInt(oneWay).toFixed(2);
		}

        //check if value is currency 
        if (pattern.test(oneWay) && oneWay !='0.00') {
        	var surchargeValue = $("#setSurchargeTd-"+oneWay_id+" div div input").val();
        	if(surchargeValue == ''){
        		surchargeValue = '0.00';
        	}
        	var newValue = parseFloat(oneWay) + parseFloat(surchargeValue);
        	var newValue = newValue.toFixed(2);
		 	//remove error from list and add values
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).parent().siblings('.help-block').html('');
			//change to fixed value 2
			var oneWay = parseFloat(oneWay).toFixed(2);
			$(this).val(oneWay);

			
			$("#setSurchargeTotalTd-"+oneWay_id+" div div input").val(newValue);

        } else if(oneWay == '' || oneWay == '0.00') {
 			//create error
			$(this).parent().parent().parent().attr('class','control-group warning');
			$(this).parent().siblings('.help-block').html('Zero Value');   
			$(this).val('0.00');           
        } else {
			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('This must be a valid currency value.');        	
        }


	});
	//update ferry surcharge and adds total surchagred value
	$(".ferry_surcharge").bind('blur',function(){
		//set the variables
		var surcharge = $(this).val();
		var surcharge_id = $(this).parent().parent().parent().attr('id').replace('setSurchargeTd-','');
        var pattern = /^\d+(?:\.\d{0,2})$/ ;
        var intPattern = /^\d+$/ ;
		if(intPattern.test(surcharge)){
			var surcharge = parseInt(surcharge).toFixed(2);
		}
		var oneWayValue = $("#setOneWayTd-"+surcharge_id+" div div input").val();
    	if(oneWayValue == ''){
    		oneWayValue = '0.00';
    	}
    	
    	//if the value is a currency
        if (pattern.test(surcharge)) {
        	if(surcharge ==''){
        		surcharge = '0.00';
        	}
        	var newValue = parseFloat(surcharge) + parseFloat(oneWayValue);
        	var newValue = parseFloat(newValue).toFixed(2);
		 	//remove error from list and add values
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).parent().siblings('.help-block').html('');
			var surcharge = parseFloat(surcharge).toFixed(2);
			$(this).val(surcharge);
			//set the last surcharge + one way rate
			$("#setSurchargeTotalTd-"+surcharge_id+" div div input").val(newValue);
		//if the value is empty
        } else if(surcharge ==''){
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).val('0.00');      
			$("#setSurchargeTotalTd-"+surcharge_id+" div div input").val(oneWayValue); 	
        } else {
			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('This must be a valid currency value.');        	
        }				
	});

	$('.ferry_reservableUnits').bind('blur',function(){
		var reservable = $(this).val();
		var reservable_id = $(this).parent().parent().parent().attr('id').replace('ferryReservableUnitsDiv-','');
        var pattern = /^\d+$/ ;

        //check if value is currency 
        if (pattern.test(reservable) && reservable != '0') {
        	var total = $("#ferryTotalUnitsDiv-"+reservable_id+" div div input").val();
        	if(total == ''){
        		total = '0.00';
        	}
        	var newValue = (parseFloat(reservable)/ parseFloat(total))*100;
        	var newValue = newValue.toFixed(2);
		 	//remove error from list and add values
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).parent().siblings('.help-block').html('');
		
			$("#ferryCapacityDiv-"+reservable_id+" div div input").val(newValue);

        } else if(reservable == '' || reservable == '0') {
 			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('Zero Value');   
			$(this).val('0');           
        } else {
			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('This is not a valid number.');        	
        }		
	});
	
	$(".ferry_totalUnits").blur('blur',function(){
		var total = $(this).val();
		var total_id = $(this).parent().parent().parent().attr('id').replace('ferryTotalUnitsDiv-','');
        var pattern = /^\d+$/ ;

        if (pattern.test(total) && total != '0') {
			var reservable = $("#ferryReservableUnitsDiv-"+total_id+" div div input").val();
        	if(reservable == ''){
        		reservable = '0';
        	}
        	var newValue = (parseFloat(reservable) / parseFloat(total))*100;
        	var newValue = parseFloat(newValue).toFixed(2);
		 	//remove error from list and add values
			$(this).parent().parent().parent().attr('class','control-group success');
			$(this).parent().siblings('.help-block').html('');

			//set the last surcharge + one way rate
			$("#ferryCapacityDiv-"+total_id+" div div input").val(newValue);

        } else if(total =='' || total == '0'){
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('Zero Value');   
			$(this).val('0');       	
        } else {
			//create error
			$(this).parent().parent().parent().attr('class','control-group error');
			$(this).parent().siblings('.help-block').html('This is not a valid number.');        	
        }		
	});
	
	$(".ferry_name").bind('blur', function(){
		var name = $(this).val();
		if(name != ''){
			$('#ferryTitleDiv').attr('class','control-group');
			$("#ferryTitleDiv .help-block").html('');			
		}
	});
	
	//ajax saving page to pages controller add method -> db 
	$("#createFerry").click(function(){
		//set variables
		var ferry_name = $(".ferry_name").val();
		if (ferry_name != ''){
			$("#ferrySaveDiv").append('<p class="muted">Status: Checking menu name ['+ferry_name+'] for errors.</p>');
			$.post(
				'/ferries/validate_form',
				{
					type:'Ferry_Name',
					ferry_name:ferry_name
				},	function(error){
					if(error=='Taken'){
						//taken error
						$("#toTop").click();
						$('#ferryTitleDiv').attr('class','control-group error');
						$("#ferryTitleDiv .help-inline").html('Error: This ferry name has been taken. Please choose another name.');
						$("#ferrySaveDiv").append('<p class="text-error">Error: Ferry name has already been taken. Please enter a new name.</p>');
					} else {
						//place the ferry_id into the form
						$(".ferry_id").val(error)
						$("#ferrySaveDiv").append('<p class="text-success">Success: Successfully saved your ferry name!</p>');
						$("#ferrySaveDiv").append('<p class="muted">Status: Sending your ferry rates to the database.</p>');
						//send the data to save ferry regions
						var ferry_input_row = $(".setRate").length;
						$(".setRate").each(function(index){
							var setRate_id = $(this).attr('id').replace('setRate-','');
							var inventory_id = $(this).attr('name');
							var ferry_oneWay = $('#setOneWayTd-'+setRate_id+' div div input').val();
							var ferry_surcharge = $("#setSurchargeTd-"+setRate_id+" div div input").val();
							var ferry_rateTotal = $('#setSurchargeTotalTd-'+setRate_id+" div div input").val();
							var ferry_id = error;
							switch(ferry_oneWay){
								case '':
									ferry_oneWay = '0.00';
								break;
							}
							switch(ferry_surcharge){
								case '':
									ferry_surcharge = '0.00';
								break;
							}
							switch(ferry_rateTotal){
								case '':
									ferry_rateTotal = '0.00';
								break;
							}
							
							$.post(
								'/ferries/validate_form',
								{
									type:'Ferry_Rates',
									ferry_id:ferry_id,
									inventory_id:inventory_id,
									item_id: setRate_id,
									one_way:ferry_oneWay,
									surcharge:ferry_surcharge,
									surcharge_total:ferry_rateTotal
									
								},	function(){	
									//do this script after last row
									if(index == parseInt(ferry_input_row)-1){
										$("#ferrySaveDiv").append('<p class="text-success">Success: Successfully saved your ferry rates!</p>');	
										$("#ferrySaveDiv").append('<p class="muted">Status: Sending your ferry limits to the database.</p>');
										var ferry_limit_count = $(".ferry_limits").length;
										$(".ferry_limits").each(function(idx){
											var setRate_id = $(this).attr('id').replace('ferry_limits-','');
											var total_reserved = $("#ferryReservableUnitsDiv-"+setRate_id+" div div input").val();
											var total_allowed = $("#ferryTotalUnitsDiv-"+setRate_id+" div div input").val();
											var inventory_id = $(this).attr('name');
											var ferry_id = error;
											switch(total_reserved){
												case '':
													total_reserved = '0';
												break;
											}
											switch(total_allowed){
												case '':
													total_allowed= '0';
												break;
											}
											
											$.post(
												'/ferries/validate_form',
												{
													type:'Ferry_Limits',
													ferry_id:ferry_id,
													inventory_id:inventory_id,
													total_reserved:total_reserved,
													total_allowed:total_allowed
			
												},	function(){	
													
													//do this script after last row
													if(idx == parseInt(ferry_limit_count)-1){
														$("#ferrySaveDiv").append('<p class="text-success">Success: Successfully saved your ferry limits!</p>');
														//redirect to the index page
														window.location.replace("/ferries");
													}
												}
											);							
										});		
									}
								}
							);										
						});
					}
				} 	
			);			
		} else {
			//this name field was left empty
			$("#toTop").click();
			$('#ferryTitleDiv').attr('class','control-group error');
			$("#ferryTitleDiv .help-block").html('Please provide a value for the ferry name');

		}
	
	});
	
	
	/*
	 * EDIT FORM PAGE
	 */
	
	$(".resetFerryFormButton").click(function(){
		location.reload();
	});
	$(".editFerryFormButton").click(function(){
		//create the variables for the form
		var title = $(".ferry_name").val();
		if(title == ''){
			$("#toTop").click();
			$('#ferryTitleDiv').attr('class','control-group error');
			$("#ferryTitleDiv .help-block").html('Error: Ferry name cannot be left empty, please enter a valid ferry name.');
		} else {
			
			//add to the form
			$(".ferryEditForm").append('<input type="hidden" value="'+title+'" name="data[Ferry][name]"/>');	
			
			var setRateCount = -1;
			$(".setRate").each(function(){
				setRateCount = setRateCount +1;
				var item_id = $(this).attr('id').replace('setRate-','');
				var inventory_id = $(this).attr('name');
				var one_way = $(this).children().children().children().find('.ferry_oneWay').val();
				var surcharged = $(this).children().children().children().find('.ferry_surcharge').val();
				var total = $(this).children().children().children().find('.ferry_surchargeTotal').val();
				$(".ferryEditForm").append(
					'<input type="hidden" value="'+inventory_id+'" name="data[Ferry_inventory]['+setRateCount+'][inventory_id]"/>'+
					'<input type="hidden" value="'+item_id+'" name="data[Ferry_inventory]['+setRateCount+'][item_id]"/>'+
					'<input type="hidden" value="'+one_way+'" name="data[Ferry_inventory]['+setRateCount+'][one_way]"/>'+
					'<input type="hidden" value="'+surcharged+'" name="data[Ferry_inventory]['+setRateCount+'][surcharge]"/>'+
					'<input type="hidden" value="'+total+'" name="data[Ferry_inventory]['+setRateCount+'][surcharge_total]"/>'
				);				
			});
			var setRateCount = -1;
			var countLimits = $(".ferry_limits").length;
			$(".ferry_limits").each(function(idx){
				setRateCount = setRateCount +1;
				var inventory = $(this).children('legend').attr('name');
				var inventory_id = $(this).attr('name');
				var reserved = $(this).children().children().children().children().find('.ferry_reservableUnits').val();
				var total = $(this).children().children().children().children().find('.ferry_totalUnits').val();
				var capacity = $(this).children().children().children().children().find('.ferry_capacity').val();
				$(".ferryEditForm").append(
					'<input type="hidden" value="'+inventory_id+'" name="data[Ferry_limit]['+setRateCount+'][inventory_id]"/>'+
					'<input type="hidden" value="'+reserved+'" name="data[Ferry_limit]['+setRateCount+'][total_reserved]"/>'+
					'<input type="hidden" value="'+total+'" name="data[Ferry_limit]['+setRateCount+'][total_allowed]"/>'
				);			
				if(idx == countLimits-1){
					$(".ferryEditForm").submit();
				}
			});
		}
	
	});
	
});
