$(document).ready(function(){
	pickup.events();
	pickup.calculator();
});

pickup = {
	events: function(){
		$(".invoiceSelectInput").click(function(){
			var input = $(this);

			var invoice_id = $(this).parents('tr:first').attr('invoice_id');

			pickup.selectInvoice(input, invoice_id);

		});
		
		$("#invoiceSelectTable tbody tr td:not(:first-child)").click(function(){
			var invoice_id = $(this).parents('tr:first').attr('invoice_id');
			var input = $(this).parents('tr:first').find('.invoiceSelectInput');
			var checked = $(this).parents('tr:first').find('.invoiceSelectInput').attr('checked');
			if(checked == 'checked'){
				$(input).removeAttr('checked');
			} else {
				$(input).attr('checked','checked');
			}

			pickup.selectInvoice(input, invoice_id);
		});
		
		$("#discountSelect").change(function(){
			var discount = $(this).find('option:selected').val();
			if(discount != ''){
				var old_total = parseFloat($("#currentTotal").attr('value'));
				var discount_total = (old_total * parseFloat(discount)) * 100;
				var discount_total = Math.round(discount_total) / 100;
				var discount_total = discount_total.toFixed(2);
				var new_total = old_total - discount_total;
				var new_total = new_total.toFixed(2);
				var reward_points = parseInt($("#rewardPoints").val());
				var points_used = parseInt($(this).find('option:selected').attr('points'));
				var points_remaining = reward_points - points_used;
				
				$("#discountTotal").attr('value',discount_total).html('$'+discount_total);
				$("#newTotal").attr('value',new_total).html('$'+new_total);
				$("#newPoints").attr('value',points_remaining).html(points_remaining);

			}
		});
		
		$("#addDiscountButton").click(function(){
			var new_discount = $("#discountTotal").html();
			var new_total = $("#newTotal").attr('value');
			
			$('#total_discount').html(new_discount);
			$('#total_at').attr('value',new_total).html('$'+new_total);
			$("#finalTotalDue").val(new_total);
			$('#totalPaidFinal').val('0.00');
			$('#totalChangeDue').val('0.00');
			$("#closeDiscountModal").click();
		});
		
		$("#printPickup").click(function(){
			//check to see how many invoices are selected;
			pickup.finishInvoice('Yes');
		});
		$("#noPrintPickup").click(function(){
			//check to see how many invoices are selected;
			pickup.finishInvoice('No');
		});
	},
	
	selectInvoice: function(input, invoice_id){
		if($(input).attr('checked')== 'checked'){
			$(input).parents('tr:first').find('td').addClass('status_select');
			$(".invoiceSummary-"+invoice_id).removeClass('hide');
		} else {
			$(input).parents('tr:first').find('td').removeClass('status_select');
			$(".invoiceSummary-"+invoice_id).addClass('hide');
		}		
		pickup.summary();
	},
	finishInvoice: function(print){
		created_invoice = '';
		//first create the print input
		if(print == 'Yes'){
			created_invoice += '<input type="hidden" value="Yes" name="data[Invoice][print]"/>';
		} else {
			created_invoice += '<input type="hidden" value="No" name="data[Invoice][print]"/>';
		}
		
		var count_checked_invoices = $(".invoiceSelectInput:checked").length;
		if(count_checked_invoices > 0){
			//grab all of the invoices that are being picked up
			$(".invoiceSelectInput:checked").each(function(en){
				var invoice_id = $(this).attr('value');
				created_invoice += '<input name="data[Invoice][picked_up]['+en+'][invoice_id]" type="hidden" value="'+invoice_id+'"/>';
			});	
			
			//grab all the totals including any discounts
			var total_quantity = $("#total_quantity").attr('value');
			var total_bt = $("#total_bt").attr('value');
			var total_tax = $("#total_tax").attr('value');
			var total_discount = $("#discountTotal").attr('value');
			var total_points = $("#discountSelect option:selected").attr('points');
			var total_at = $("#total_at").attr('value');
			var customer_id = $("#finalPickupForm").attr('customer_id');
			
			created_invoice += '<input type="hidden" name="data[Invoice][quantity]" value="'+total_quantity+'"/>';
			created_invoice += '<input type="hidden" name="data[Invoice][total_bt]" value="'+total_bt+'"/>';
			created_invoice += '<input type="hidden" name="data[Invoice][total_tax]" value="'+total_tax+'"/>';
			created_invoice += '<input type="hidden" name="data[Invoice][total_discount]" value="'+total_discount+'"/>';
			created_invoice += '<input type="hidden" name="data[Invoice][total_points]" value="'+total_points+'"/>';
			created_invoice += '<input type="hidden" name="data[Invoice][total_at]" value="'+total_at+'"/>';
			created_invoice += '<input type="hidden" name="data[Invoice][customer_id]" value="'+customer_id+'"/>';
			
			$("#finalPickupForm").html(created_invoice).submit();
		} else {
			alert('You must have at least one invoice selected. Please select an invoice.');
		}
	},
	
	summary: function(){
		total_quantity = 0;
		total_bt = 0;
		total_tax = 0;
		total_at = 0;		
		$("#invoiceSelectTable tbody tr").each(function(){
			var checked = $(this).find('.invoiceSelectInput').attr('checked');
			quantity = parseInt($(this).find('#invoice_td-quantity').attr('value'));
			before_tax = parseFloat($(this).find('#invoice_td-bt').attr('value'));
			tax = parseFloat($(this).find('#invoice_td-tax').attr('value'));
			after_tax = parseFloat($(this).find('#invoice_td-total').attr('value'));
			

			if(checked == 'checked'){
				total_quantity += quantity;
				total_bt += before_tax;
				total_tax += tax;
				total_at += after_tax;
				
			}
		});
		
		$("#total_quantity").attr('value',total_quantity).html(total_quantity);
		$("#total_bt").attr('value',total_bt.toFixed(2)).html('$'+total_bt.toFixed(2));
		$("#total_tax").attr('value',total_tax.toFixed(2)).html('$'+total_tax.toFixed(2));
		$("#total_at").attr('value',total_at.toFixed(2)).html('$'+total_at.toFixed(2));
		$("#total_discount").attr('value','0.00').html('');
		//discounted totals
		$("#currentTotal").attr('value',total_at.toFixed(2)).html('$'+total_at.toFixed(2));
		$("#discountTotal").attr('value','0.00').html('$0.00');
		$("#newTotal").attr('value',total_at.toFixed(2)).html('$'+total_at.toFixed(2));
		$("#finalTotalDue").val(total_at.toFixed(2));
		$('#totalPaidFinal').val('0.00');
		$('#totalChangeDue').val('0.00');
	},
	
	calculator: function(){
		
		$("#calculator button").click(function(){
			var due = parseFloat($('#finalTotalDue').val());
			var number = $(this).attr('value');
			var paid = $('#totalPaidFinal').val();
			switch(number){
				case 'C':
					$('#totalPaidFinal').val('0.00');
					$('#totalChangeDue').val('0.00');
				break;
				default:
					if(parseFloat(paid)>0){
						var paid_float =parseFloat(paid) * 100;
						var paid_float = paid_float+''+number;
						var paid_float = parseInt(paid_float) / 100;
						var paid_float = paid_float.toFixed(2);
					} else {
						var paid_float = '0.0'+number;
					}
					
					
					$("#totalPaidFinal").val(paid_float);
					
					var total_change_due = parseFloat(paid_float) - due;
					var total_change_due = total_change_due.toFixed(2);
					$("#totalChangeLi").removeClass('error').removeClass('success');
					if(total_change_due >= 0){
						$("#totalChangeLi").addClass('success');
						
					} else {
						total_change_due = total_change_due * -1;
						$("#totalChangeLi").addClass('error');

					}
					$("#totalChangeDue").val(total_change_due);
				break;
			}

		});
		
		$(".quickButtons").click(function(){
			var due = parseFloat($('#finalTotalDue').val());
			var amount = $(this).attr('value');
			var total_change_due = parseFloat(amount) - due;
			var total_change_due = total_change_due.toFixed(2);
			$("#totalChangeLi").removeClass('error').removeClass('success');
			if(total_change_due >= 0){
				$("#totalChangeLi").addClass('success');
				
			} else {
				total_change_due = total_change_due * -1;
				$("#totalChangeLi").addClass('error');

			}
			$("#totalPaidFinal").val(amount);			
			$("#totalChangeDue").val(total_change_due);			
		});
	},
	
	createFinalForm: function(){
		
	},
	
	
};
