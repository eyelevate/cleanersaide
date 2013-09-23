$(document).ready(function(){
	pickup.events();
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
			var new_total = $("#newTotal").html();
			
			$('#total_discount').html(new_discount);
			$('#total_at').html(new_total);
			$("#closeDiscountModal").click();
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
	},
	createFinalForm: function(){
		
	}
	
};
