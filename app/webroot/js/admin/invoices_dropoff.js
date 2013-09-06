$(document).ready(function(){
	invoice.quantity();
	invoice.orders();
	invoice.colors();
	invoice.print();
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
		$(".colorUl li").click(function(){
			var color = $(this).attr('color');
			var active_colors = $("#invoiceTable tbody tr[status='active'] .colorsTd").html();
			var qty = parseInt($("#invoiceTable tbody tr[status='active'] .quantityTd").html());
			color_check = $("#invoiceTable tbody tr[status='active'] .colorsTd ul li[color='"+color+"']").length;
			if(color_check >0){
				var color_count = parseInt($("#invoiceTable tbody tr[status='active'] .colorsTd ul li").attr('count'));
			} else {
				var color_count = 0;
			}	
			
			//get total color count for active row
			total_color_count = 0;
			$("#invoiceTable tbody tr[status='active'] .colorsTd ul li").each(function(){
				total_color_count += parseInt($(this).attr('count'));
			});

			colors = '';
		
			if(total_color_count <= (qty-1)){

				new_count = color_count + 1;
				
				colors_make = colors_html(color, new_count);
				$("#invoiceTable tbody tr[status='active'] .colorsTd ul li[color='"+color+"']").remove();
				$("#invoiceTable tbody tr[status='active'] .colorsTd ul").append(colors);
				
				
				$("#invoiceTable tbody tr").each(function(){

					color_li_count = $(this).find('ul li').length;
					if(color_li_count > 0){
						$(this).find('ul li').each(function(en){
							color_grab_qty = $(this).attr('count');
							color_grab_color = $(this).attr('color');
							color_item_id = $(this).parents('tr:first').attr('id').replace('invoice_item_td-','');

							colors_array = colors_form_input_array(color_grab_qty, color_grab_color, color_item_id, en);
							$(this).find('.colorsFormInput').remove();
							$(this).append(colors_array);
						});
						
					}

				});
				
			} else {
				alert('Color count cannot exceed quantity count.');
			}

			
		});
	},
	print: function(){
		$(".printCustomerCopy").click(function(){
			var type = $(this).attr('id').replace('printCustomerCopy-','');
			var count_invoice_rows = $("#invoiceTbody tr").length;
			if(count_invoice_rows>0){
				switch(type){
					case 'No':
						$('#invoiceForm').attr('action','/invoices/process_dropoff_no_copy');
					break;
					
					default:
						$('#invoiceForm').attr('action','/invoices/process_dropoff_copy');
					break;
				}
				
				$('#invoiceForm').submit();				
			} else {
				alert('There is no invoice to create. Please select at least one inventory item.');
			}

		});
	}
};

summary = {
	set_pricing: function(item_id, quantity, name,price, new_price, form, new_invoice){
		//check to see if any previous rows exist
		check_exists = 'No';
		
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
				$(this).parent().find('tr').attr('status','notactive');
				$(this).attr('status','active');				
				return false;
			}
		});
		
		if(check_exists == 'No'){
			$("#invoiceTbody").append(new_invoice);
			$("#finalTotal").html('0').attr('val','0');
			$('#invoiceTbody tr').attr('status','notactive');
			$('#invoiceTbody tr:last').attr('status','active');

			//click to remove
			$('#invoiceTbody tr:last .removeRow').click(function(){
				if(confirm('Would you like to delete this row?')){
					$(this).parents('tr:first').remove();
					summary.sum_all();
				}
			});
			//click to make active
			$("#invoiceTbody tr:last").click(function(){
				$(this).parents().find('tr').attr('status','notactive');
				$(this).attr('status','active');

			});
		}
		summary.sum_all();		
	},
	
	sum_all:function(){
		var tax = 1+(parseFloat($("#tax_rate").val()) / 100);
		total_qty = 0;
		total_pretax = 0;
		total_aftertax = 0;
		total_tax = 0;
		$("#invoiceTbody tr").each(function(){
			total_qty += parseInt($(this).find('.quantityTd').html());
			total_pretax += parseFloat($(this).find('.priceTd').html());
			
		});
		
		total_pretax = roundCents(total_pretax,1);
		total_aftertax = roundCents(parseFloat(total_pretax) * tax,1);
		total_tax = roundCents((total_aftertax - total_pretax),1);
		
		//remove old form and create a new form
		$("#total_qty").html(total_qty);
		$("#total_pretax").html(total_pretax);
		$("#total_tax").html(total_tax);
		$("#total_aftertax").html(total_aftertax);
		totals_form = new_totals_form(total_qty, total_pretax, total_tax, total_aftertax);
		$("#hiddenTotalsDiv").html(totals_form);
	}
};

//var funcitons
var new_invoice_item = function(item_id,qty, item, price,form){
	tr = '<tr id="invoice_item_td-'+item_id+'" class="invoice_item_td" status="active">'+
			'<td class="quantityTd">'+qty+'</td>'+
			'<td class="itemTd">'+item+'</td>'+
			'<td class="colorsTd"><ul class="unstyled" count="0"></ul></td>'+
			'<td class="priceTd">'+price+'</td>'+
			'<td><a class="removeRow">remove</a><div class="invoiceData hide">'+form+'</div></td>'+
		'</tr>';
	return tr;
};
var new_invoice_form = function(item_id,qty, item, price){
	new_form = '<input id="invoiceItemInput-quantity" type="hidden" name="data[Invoice][items]['+item_id+'][quantity]" value="'+qty+'"/>'+
				'<input id="invoiceItemInput-name" type="hidden" name="data[Invoice][items]['+item_id+'][name]" value="'+item+'"/>'+
				'<input id="invoiceItemInput-before_tax" type="hidden" name="data[Invoice][items]['+item_id+'][before_tax]" value="'+price+'"/>'+
				'<input id="invoiceItemInput-item_id" type="hidden" name="data[Invoice][items]['+item_id+'][item_id]" value="'+item_id+'"/>';
	return new_form;
};
var new_totals_form = function(qty, pretax, tax, aftertax){
	new_form = '<input type="hidden" name="data[Invoice][total_qty]" value="'+qty+'"/>'+
				'<input type="hidden" name="data[Invoice][total_pretax]" value="'+pretax+'"/>'+
				'<input type="hidden" name="data[Invoice][total_tax]" value="'+tax+'"/>'+
				'<input type="hidden" name="data[Invoice][total_aftertax]" value="'+aftertax+'"/>';
	return new_form;
};

var colors_html = function(color, count){
	if(count > 1){
		title = '('+count+'x) '+color;
	} else {
		title = color;
	}

	colors = '<li class="badge badge-inverse pull-left" color="'+color+'" count="'+count+'">'+title+'</li>';
	
	return colors;
};

var colors_form_input_array = function(count, color, item_id,row){
	input = '<input class="colorsFormInput" type="hidden" name="data[Invoice][items]['+item_id+'][colors]['+row+'][quantity]" value="'+count+'"/>';
	input += '<input class="colorsFormInput" type="hidden" name="data[Invoice][items]['+item_id+'][colors]['+row+'][color]" value="'+color+'"/>';
	return input;
};


var roundCents = function(price, qty){
	rounded = parseFloat(price) * parseInt(qty);
	rounded = rounded * 100;
	rounded = Math.round(rounded);
	rounded = rounded / 100;
	rounded = rounded.toFixed(2);
	
	return rounded;
};
