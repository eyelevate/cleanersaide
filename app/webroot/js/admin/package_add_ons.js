$(document).ready(function(){
	add_ons.numberformat();
	add_ons.events();
	add_ons.taxes();
	add_ons.netCheck();
	add_ons.validate();
});

/**
 *Functions 
 */
add_ons = {
	numberformat: function(){
		//number formatting

		$("#usTable #PackageAddOnNet").priceFormat({
			'prefix':'',
		});
		$("#usTable #PackageAddOnMarkup").priceFormat({
			'prefix':'',
			limit:5
		});
		$("#usTable #PackageAddOnGross").priceFormat({
			'prefix':'',
		});
		$("#canTable #PackageAddOnNet").priceFormat({
			'prefix':'',
		});
		$("#canTable #PackageAddOnMarkup").priceFormat({
			'prefix':'',
			limit:5
		});
		$("#canTable #PackageAddOnGross").priceFormat({
			'prefix':'',
		});
	},
	events: function(){
		$("#PackageAddOnVouchersQuantityButton").click(function(){
			var amount = $('#PackageAddOnVouchersQuantity').val();
			var groups = accordion_group(amount);
			$("#side_accordion2").html(groups);
		});
		$("#PackageAddOnVouchersQuantityEditButton").click(function(){
			var old = $(".accordion-group[type='edit']").length;
			var amount = parseInt($("#PackageAddOnVouchersQuantityEdit").val());
			var new_amount = amount - old;
			var new_groups = accordion_group_new(amount);
			$("#side_accordion2").append(new_groups);
			addScripts.reindex_remove();
		
		});
		$(".removeVoucher").click(function(){
			if(confirm('Are you sure you want to delete?')){
				$(this).parents('.accordion-group:first').remove();
				addScripts.reindex_remove();
			}
		});
	},
	taxes: function(){
		$("#selectTaxes").change(function(){
			var tax_id = $(this).find('option:selected').attr('tax_id');
			var tax_rate = $(this).find('option:selected').val();
			var tax_name = $(this).find('option:selected').attr('tax_name');
			var tax_country = $(this).find('option:selected').attr('tax_country');
			var tax_basis = $(this).find('option:selected').attr('tax_basis');
			var idx = 0;
			var taxRow = createTax(tax_id,tax_name,tax_rate,tax_country,idx);
			var inputLength = $(".taxesRatesDivs input[name='data[PackageAddOn][0][taxes]["+tax_id+"]']").length;
			
			if(inputLength > 0){
				alert('Tax already selected');
			}
			
			if(tax_rate !='' && inputLength ==0){
				$("#taxesSelectedDiv").append(taxRow);			
			}

			add_ons.addScripts();
			
		});
	},
	netCheck: function(){
		$("#checkNetCanadian").click(function(){
			var check = $(this).attr('checked');
			
			if(check == 'checked'){
				$("#canTable input").removeAttr('disabled');
				$("#canTable").removeClass('hide');
				$("#usTable").addClass('hide');
				$("#usTable input").attr('disabled','disabled');
				$("#country").val('2');
				
			} else {
				$("#canTable input").attr('disabled','disabled');
				$("#usTable").removeClass('hide');
				$("#canTable").addClass('hide');
				$("#usTable input").removeAttr('disabled');
				$("#country").val('1');
				
			}
		});
	},
	validate: function(){
		$(".removeTax").click(function(){
			$(this).parent().remove();	
		});
		
		$("#usTable #PackageAddOnNet").keyup(function(){
			var net = $(this).val();
			var net = net.replace(/,/g,'');
			var net = parseFloat(net);
			var markup = $(this).parents('tr:first').find('#PackageAddOnMarkup').val();
			var gross = net * ((markup / 100)+1);
			var gross = gross.toFixed(2);

			$(this).parents('tr:first').find("#PackageAddOnGross").val(gross);
			$("#usTable #PackageAddOnGross").priceFormat({
				'prefix':'',
    			'thousandsSeparator': ','
			});		
			
		});
		
		$("#usTable #PackageAddOnMarkup").keyup(function(){
			var net = $("#usTable #PackageAddOnNet").val();
			var net = net.replace(/,/g,'');
			var net = parseFloat(net);
			var markup = parseFloat($(this).val());
			var gross = net * ((markup / 100)+1);
			var gross = gross.toFixed(2);

			$(this).parents('tr:first').find("#PackageAddOnGross").val(gross);
			$("#usTable #PackageAddOnGross").priceFormat({
				'prefix':'',
    			'thousandsSeparator': ','
			});					
		});
		
		$("#usTable #PackageAddOnGross").keyup(function(){
			var net = $("#usTable #PackageAddOnNet").val();
			var net = net.replace(/,/g,'');
			var net = parseFloat(net);
			var gross = $("#usTable #PackageAddOnGross").val();
			var gross = gross.replace(/,/g,'');
			var gross = parseFloat(gross);
			var markup = ((gross / net)-1)*100;
			var markup = markup.toFixed(2);


			$(this).parents('tr:first').find("#PackageAddOnMarkup").val(markup);
	
		});
		$("#canTable #PackageAddOnNet").keyup(function(){
			var net = $(this).val();
			var net = net.replace(/,/g,'');
			var net = parseFloat(net);
			var exchange = parseFloat($("#canTable #PackageAddOnExchange").val());
			var markup = $(this).parents('tr:first').find('#PackageAddOnMarkup').val();
			var gross = net * exchange * ((markup / 100)+1);
			var gross = gross.toFixed(2);

			$(this).parents('tr:first').find("#PackageAddOnGross").val(gross);
			$("#canTable #PackageAddOnGross").priceFormat({
				'prefix':'',
    			'thousandsSeparator': ','
			});				
		});
		
		$("#canTable #PackageAddOnMarkup").blur(function(){
			var net = $(this).val();
			var net = net.replace(/,/g,'');
			var net = parseFloat(net);
			var exchange = parseFloat($("#canTable #PackageAddOnExchange").val());
			var markup = parseFloat($(this).parents('tr:first').find('#PackageAddOnMarkup').val());
			var gross = net * exchange * ((markup / 100)+1);
			var gross = gross.toFixed(2);

			$(this).parents('tr:first').find("#PackageAddOnGross").val(gross);
			$("#canTable #PackageAddOnGross").priceFormat({
				'prefix':'',
    			'thousandsSeparator': ','
			});				
		});
		
		$("#canTable #PackageAddOnGross").keyup(function(){
			var net = $("#canTable #PackageAddOnNet").val();
			var net = net.replace(/,/g,'');
			var net = parseFloat(net);
			var exchange = parseFloat($("#canTable #PackageAddOnExchange").val());
			var gross = $(this).val();
			var gross = gross.replace(/,/g,'');
			var gross = parseFloat(gross);
			var markup = ((gross / (net * exchange))-1)*100;
			var markup = markup.toFixed(2);


			$(this).parents('tr:first').find("#PackageAddOnMarkup").val(markup);			
		});		
	},
	addScripts: function(idx){
		$(".removeTax").click(function(){
			$(this).parent().remove();	
		});
	}
}
addScripts = {
	reindex_remove: function(){
		group = '';
		$('#side_accordion2').find(".accordion-group").each(function(idx){
			count = idx+1;
	
			var type = $(this).attr('new');
			var name = $(this).find('.PackageAddOnVouchersName').val();
			var desc = $(this).find('.PackageAddOnVouchersDescription').val();
			switch(type){
				case 'No':
					group +='<div class="accordion-group" type="edit" new="No">'+
						'<div class="accordion-heading">'+
							'<a href="#collapse-'+idx+'" data-parent="#side_accordion2" data-toggle="collapse" class="accordion-toggle collapsed"> Voucher #<span class="voucher_number">'+count+'</span></a>'+
						'</div>'+
						'<div class="accordion-body collapse" id="collapse-'+idx+'">'+
							'<div class="accordion-inner">'+
								'<div class="control-group">'+
									'<label>Voucher Name <span class="f_req">*</span></label>'+
									'<input id="PackageAddOnVouchersName-'+idx+'" type="text" class="PackageAddOnVouchersName" name="data[PackageAddOn][vouchers]['+idx+'][name]" value="'+name+'"/>'+
									'<span class="help-block"></span>'+
								'</div>'+
								'<div class="control-group">'+
									'<label>Voucher Description <span class="f_req">*</span></label>'+
									'<textarea id="PackageAddOnVouchersDescription-'+idx+'" class="PackageAddOnVouchersDescription span6" cols="30" rows="6" name="data[PackageAddOn][vouchers]['+idx+'][description]">'+desc+'</textarea>'+
									'<span class="help-block"></span>'+
								'</div>'+
								'<div>'+
									'<button id="removeVoucher-'+idx+'" type="button" class="removeVoucher btn btn-danger">remove</button>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>';					
				break;
				
				default:
					group +='<div class="accordion-group" type="edit" new="Yes">'+
						'<div class="accordion-heading">'+
							'<a href="#collapse-'+idx+'" data-parent="#side_accordion2" data-toggle="collapse" class="accordion-toggle collapsed"> New Voucher #<span class="voucher_number">'+count+'</span></a>'+
						'</div>'+
						'<div class="accordion-body collapse" id="collapse-'+idx+'">'+
							'<div class="accordion-inner">'+
								'<div class="control-group">'+
									'<label>Voucher Name <span class="f_req">*</span></label>'+
									'<input id="PackageAddOnVouchersName-'+idx+'" type="text" class="PackageAddOnVouchersName" name="data[PackageAddOn][vouchers]['+idx+'][name]" value="'+name+'"/>'+
									'<span class="help-block"></span>'+
								'</div>'+
								'<div class="control-group">'+
									'<label>Voucher Description <span class="f_req">*</span></label>'+
									'<textarea id="PackageAddOnVouchersDescription-'+idx+'" class="PackageAddOnVouchersDescription span6" cols="30" rows="6" name="data[PackageAddOn][vouchers]['+idx+'][description]">'+desc+'</textarea>'+
									'<span class="help-block"></span>'+
								'</div>'+
								'<div>'+
									'<button id="removeVoucher-'+idx+'" type="button" class="removeVoucher btn btn-danger">remove</button>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>';					
				break;
			}
			

		});
		
		$('#side_accordion2').html(group);
		$('#side_accordion2').find(".accordion-group").each(function(idx){
			var element = $(this).find('.removeVoucher');
			addScripts.remove_voucher(element);
		});
		var new_count = $("#side_accordion2").find('.accordion-group').length;
		$("#PackageAddOnVouchersQuantityEdit").val(new_count);
	},
	remove_voucher: function(element){
		element.click(function(){
			if(confirm('Are you sure you want to delete?')){
				$(this).parents('.accordion-group:first').remove();
				addScripts.reindex_remove();
			}
		});		
	}
}

var createTax = function(tax_id,tax_name,tax_rate,tax_country,idx){
	var tax =
		'<div class="taxesRatesDivs alert alert-info form-horizontal" style="margin-bottom:2px;">'+
			'<button id="removeTax-'+idx+'" type="button" class="removeTax pull-right" ><icon class="icon-trash"></icon></button>'+
			'<label class="control-label">'+tax_name+'</label>'+
			'<div class="controls">'+
				'<div class="input-append">'+
					
					'<input id="taxesInput-'+tax_id+'" class="taxesInput" name="" type="text" disabled="disabled" value="'+tax_rate+'"/>'+
					'<span class="add-on">'+tax_country+'</span>'+
				'</div>'+
				'<input type="hidden" name="data[PackageAddOn]['+idx+'][taxes]['+tax_id+']" value="'+tax_id+'"/>'+
			'</div>'+
			
		'</div>';
		
	return tax;
}
var accordion_group = function(num){
	num = parseInt(num);

	group = '';
	for (var i=0; i < num; i++) {
		var group_create = 
			'<div class="accordion-group">'+
				'<div class="accordion-heading">'+
					'<a href="#collapse-'+i+'" data-parent="#side_accordion2" data-toggle="collapse" class="accordion-toggle collapsed"> Voucher #<span class="voucher_number">'+(parseInt(i)+1)+'</span></a>'+
				'</div>'+
				'<div class="accordion-body collapse" id="collapse-'+i+'">'+
					'<div class="accordion-inner">'+
						'<div class="control-group">'+
							'<label>Voucher Name <span class="f_req">*</span></label>'+
							'<input id="PackageAddOnVouchersName-'+i+'" type="text" class="PackageAddOnVouchersName" name="data[PackageAddOn][vouchers]['+i+'][name]"/>'+
							'<span class="help-block"></span>'+
						'</div>'+
						'<div class="control-group">'+
							'<label>Voucher Description <span class="f_req">*</span></label>'+
							'<textarea id="PackageAddOnVouchersDescription-'+i+'" class="PackageAddOnVouchersDescription span6" cols="30" rows="6" name="data[PackageAddOn][vouchers]['+i+'][description]"></textarea>'+
							'<span class="help-block"></span>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>';	  
			group += group_create;
	};

		
	return group;
}
var accordion_group_new = function(num){
	num = parseInt(num);
	var old = $(".accordion-group[type='edit']").length;

	group = '';
	for (var i=old; i < num; i++) {
		var group_create = 
			'<div class="accordion-group" type="edit" new="Yes">'+
				'<div class="accordion-heading">'+
					'<a href="#collapse-'+i+'" data-parent="#side_accordion2" data-toggle="collapse" class="accordion-toggle collapsed"> New Voucher #<span class="voucher_number">'+(parseInt(i)+1)+'</span></a>'+
				'</div>'+
				'<div class="accordion-body collapse" id="collapse-'+i+'">'+
					'<div class="accordion-inner">'+
						'<div class="control-group">'+
							'<label>Voucher Name <span class="f_req">*</span></label>'+
							'<input id="PackageAddOnVouchersName-'+i+'" type="text" class="PackageAddOnVouchersName" name="data[PackageAddOn][vouchers]['+i+'][name]"/>'+
							'<span class="help-block"></span>'+
						'</div>'+
						'<div class="control-group">'+
							'<label>Voucher Description <span class="f_req">*</span></label>'+
							'<textarea id="PackageAddOnVouchersDescription-'+i+'" class="PackageAddOnVouchersDescription span6" cols="30" rows="6" name="data[PackageAddOn][vouchers]['+i+'][description]"></textarea>'+
							'<span class="help-block"></span>'+
						'</div>'+
						'<div>'+
							'<button id="removeVoucher-'+i+'" type="button" class="removeVoucher btn btn-danger">remove</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>';	  
			group += group_create;
			
	};

		
	return group;
}
