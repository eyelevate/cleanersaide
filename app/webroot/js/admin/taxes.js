$(document).ready(function(){
	taxes.numberformat();
});

/**
 * Functions
 */

taxes = {
	numberformat: function(){
		$('.taxrate').priceFormat({
			'prefix':'',
			limit:5
		});

	}
}
