$(document).ready(function(){
	//numberformatting
	inventory.numberformat();
	inventory.validation();
});

/**
 * Functions 
 */

inventory = {
	numberformat: function(){
		$(".oneway").priceFormat({
			'prefix':'',
		});	
		$(".surcharge").priceFormat({
			'prefix':'',
		});	
		$(".total").priceFormat({
			'prefix':'',
		});		
	},
	validation: function(){
		$(".oneway").keyup(function(){
			var oneway = $(this).val();
			var surcharge = $('.surcharge').val();
			var total = parseFloat(oneway)+parseFloat(surcharge);
			var total = total.toFixed(2);

			$('.total').val(total);
			
		});
		$(".surcharge").keyup(function(){
			var oneway = $('.oneway').val();
			var surcharge = $(this).val();
			var total = parseFloat(oneway)+parseFloat(surcharge);
			var total = total.toFixed(2);

			$('.total').val(total);			
		});
		$(".total").keyup(function(){
			var oneway = $('.oneway').val();
			var total = $(this).val();
			var surcharge = parseFloat(total)-parseFloat(oneway);
			var surcharge = total.toFixed(2);

			$('.surcharge').val(surcharge);				
		});		
	}
}
