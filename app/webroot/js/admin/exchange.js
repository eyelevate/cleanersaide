$(document).ready(function(){
	
	//number format 0.000
	exchange.numberformat();
	
	//change type
	$(".selectType").change(function(){
		var type = $(this).find('option:selected').val();
		exchange.type(type);
	});
	
	//keyup
	exchange.trace('.usdcad','.cadusd');
	
	
	//show or hide history on index page
	$("#showExchangeRateHistory").click(function(){
		var checked = $(this).attr('checked');
		if(checked =='checked'){
			$("#exchangeRateHistoryDiv").fadeIn('fast');
		} else {
			$("#exchangeRateHistoryDiv").fadeOut('fast');
		}
	});

});


/**
 * Functions
 */
exchange = {
	type: function(type){
		switch(type){
			case 'USDCAD':
				//show the proper form elements and hide cadusd
				$("#showUsdCad").fadeIn('slow');
				$("#showCadUsd").hide();
				//show the header info
				$("#usdcadP").show();
				$("#cadusdP").hide();	
			break;
			
			case 'CADUSD':
				//show cadusd and hide usdcad
				$("#showCadUsd").fadeIn('slow');
				$("#showUsdCad").hide();	
				//show the header info
				$("#cadusdP").show();
				$("#usdcadP").hide();		
			break;
		}
	},
	numberformat: function(){
		//number formatting
		$(".usdcad").priceFormat({			
			'prefix':'',
		    limit: 5,
		    centsLimit: 4
		});
		$(".cadusd").priceFormat({			
			'prefix':'',
		    limit: 5,
		    centsLimit: 4
		});
	},
	trace: function(field1,field2){
		//usdcad
		$(field1).keyup(function(){
			var value = $(this).val();
			//trace to header
			$("#usdcadSpan").html(value);
			//convert to cadusd
			var cadusd = convert('cadusd',value);
			$(field2).val(cadusd);
			//update the header of cadusd
			$("#cadusdSpan").html(cadusd);
		});
		//cadusd
		$(field2).keyup(function(){
			var value = $(this).val();
			//trace to header
			$("#cadusdSpan").html(value);
			//convert to usdcad
			var usdcad = convert('usdcad',value);
			$(field1).val(usdcad);
			//update the header of usdcad
			$("#usdcadSpan").html(usdcad);
		});
	}
}
var convert = function(type, value){
	value = parseFloat(value);
	switch(type){
		case 'usdcad':
			currency = 1 / value;
		break;
		
		case 'cadusd':
			currency = 1 / value;
		break;
	}	
	return currency.toFixed(4);
}
