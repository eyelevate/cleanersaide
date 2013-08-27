$(document).ready(function(){
	invoice.quantity();
	invoice.orders();
});

//functions
invoice = {
	quantity: function(){
		$(".number_list li:not(last)").click(function(){
			var quantity =$(this).attr('val');

			var total = $('#finalTotal').attr('val');

			var new_quantity= total+''+quantity;
			
			
			switch(quantity){
				case 'C':

					$("#finalTotal").html('0').attr('val','0');
				break;
				
				default:

					if(total=='0'){

						$("#finalTotal").attr('val',quantity).html(quantity);	
		
					} else {
						var new_length = new_quantity.length;

						if(new_length < 4){
							$("#finalTotal").attr('val',new_quantity).html(new_quantity);			
						}						
					}

					
				break;
			}
			
			
			// if(quantity == 'C'){
				// $("#finalTotal").attr('value','').html('');
			// } else {
				// $("#finalTotal").attr('value',new_quantity).html(new_quantity);
			// }	
			

			
		});
	},
	orders: function(){

		$('.inventory_item').click(function(){
			var item_id = $(this).attr('id').replace('item-','');
			var quantity = parseInt($("#finalTotal").attr('val'));
			if(quantity == 0){
				quantity =1;
			}
			var name = $(this).attr('item');
			var price = $(this).attr('price');
			var new_price = roundCents(price, quantity);
			var form = new_invoice_form(item_id,quantity, name, new_price);
			var new_invoice = new_invoice_item(item_id,quantity, name, new_price, form);
			
			summary.set_pricing(item_id, quantity,name, price, new_price, form, new_invoice);
			
		});
	},
	colors: function(){
		
	}
}

summary = {
	set_pricing: function(item_id, quantity, name,price, new_price, form, new_invoice){
		//check to see if any previous rows exist
		check_exists = 'No'
		
		$("#invoiceTbody tr").each(function(){
			var finished_item_id = $(this).attr('id').replace('invoice_item_td-','');

			if(finished_item_id == item_id){

				check_exists = 'Yes';
				old_quantity = parseInt($(this).find('.quantityTd').html());
				new_quantity = old_quantity + quantity;
				new_price = roundCents(price, new_quantity);
				var updated_form = new_invoice_form(item_id, new_quantity, name, new_price);
				var updated_invoice = new_invoice_item(item_id, new_quantity, name, new_price, updated_form);				
				
				$("#invoice_item_td-"+item_id+" .quantityTd").html(new_quantity);
				$("#invoice_item_td-"+item_id+" .priceTd").html(new_price);
				$("#invoice_item_td-"+item_id+" .invoiceData").html(updated_form);
				$("#finalTotal").html('0').attr('val','0');					
				return false;
			}
		});
		
		if(check_exists == 'No'){
			$("#invoiceTbody").append(new_invoice);
			$("#finalTotal").html('0').attr('val','0');
		}		
	}
}

//var funcitons
var new_invoice_item = function(item_id,qty, item, price,form){
	tr = '<tr id="invoice_item_td-'+item_id+'" class="invoice_item_td" status="active">'+
			'<td class="quantityTd">'+qty+'</td>'+
			'<td class="itemTd">'+item+'</td>'+
			'<td class="colorsTd"></td>'+
			'<td class="priceTd">'+price+'</td>'+
			'<td><a class="removeRow">remove</a><div class="invoiceData hide">'+form+'</div></td>'+
		'</tr>';
	return tr;
}
var new_invoice_form = function(item_id,qty, item, price){
	new_form = '<input type="hidden" name="data[Invoice][quantity]" value="'+qty+'"/>'+
				'<input type="hidden" name="data[Invoice][name]" value="'+item+'"/>'+
				'<input type="hidden" name="data[Invoice][before_tax]" value="'+price+'"/>'+
				'<input type="hidden" name="data[Invoice][item_id]" value="'+item_id+'"/>';
	return new_form;
}


var roundCents = function(price, qty){
	rounded = parseFloat(price) * parseInt(qty);
	rounded = rounded * 100;
	rounded = Math.round(rounded);
	rounded = rounded / 100;
	rounded = rounded.toFixed(2);
	
	return rounded;
}
