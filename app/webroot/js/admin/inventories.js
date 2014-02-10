$(document).ready(function(){
	
	inventories.validate();
	inventories.numberformat();
});

inventories = {
	numberformat: function(){
		//number formatting
		$(".online_oneway").priceFormat({
			'prefix':'',
		});
		$(".online_roundtrip").priceFormat({
			'prefix':'',
		});
		$(".phone_oneway").priceFormat({
			'prefix':'',
		});
		$(".phone_roundtrip").priceFormat({
			'prefix':'',
		});
		$(".overlength_extra_fee").priceFormat({
			'prefix':'',
		});
		$(".overlength_base_unit").priceFormat({
			'prefix':'',
		});
		$(".inc_unit_start").priceFormat({
			'prefix':'',
		});
		$(".inc_unit_end").priceFormat({
			'prefix':'',
		});
		$(".inc_unit_add").priceFormat({
			'prefix':'',
		});

	},	
	validate: function(){
		
		$(".overlength_base_unit").blur(function(){
			var value = $(this).val();
			if(value == '' || value =='0.00'){
				$(this).val('');
			}
		});
		$(".overlength_extra_fee").blur(function(){
			var value = $(this).val();
			if(value == '' || value =='0.00'){
				$(this).val('');
			}
		});
		$("#InventoryReservable").keyup(function(){
			var reservable = $(this).val();
			var total = $("#InventoryTotalUnits").val();
			if(total != ''){
				var capacity = (parseFloat(reservable) / parseFloat(total))*100;
				var capacity = capacity.toFixed(2);
				
				$("#InventoryCapacity").val(capacity);				
			}
		});
		$("#InventoryTotalUnits").keyup(function(){
			var reservable = $("#InventoryReservable").val();
			var total = $(this).val();
			if(total !=''){
				var capacity = (parseFloat(reservable) / parseFloat(total))*100;
				var capacity = capacity.toFixed(2);
				
				$("#InventoryCapacity").val(capacity);				
			}
		});
		$("#addTowedUnit").click(function(){
			var name = $(".towed_unit_name").val();
			var desc = $(".towed_unit_description").val();
			var input = towedInput(name,desc);
			
			if(name == ''){
				$('.towed_unit_name').parent().parent().attr('class','control-group error');
				$('.towed_unit_name').parent().parent().find('.help-block').html('This field cannot be left empty');
			} else {
				$('.towed_unit_name').parent().parent().attr('class','control-group');
				$('.towed_unit_name').parent().parent().find('.help-block').html('');					
			}
			if(desc ==''){
				$('.towed_unit_description').parent().parent().attr('class','control-group error');
				$('.towed_unit_description').parent().parent().find('.help-block').html('This field cannot be left empty');
			} else {
				$('.towed_unit_description').parent().parent().attr('class','control-group');
				$('.towed_unit_description').parent().parent().find('.help-block').html('');				
			}
			if(name != '' && desc != ''){
				$('.towed_unit_name').parent().parent().attr('class','control-group');
				$('.towed_unit_name').parent().parent().find('.help-block').html('');	
				$('.towed_unit_description').parent().parent().attr('class','control-group');
				$('.towed_unit_description').parent().parent().find('.help-block').html('');	
				$(".towedUnitsOl").append(input);
				$(".towed_unit_name").val('');
				$(".towed_unit_description").val('');
				$(".towed_unit_name").focus();		
			}
			
		});
		$("#createIncUnitButton").click(function(){
			var start = $(".inc_unit_start").val();
			var end = $(".inc_unit_end").val();
			var unit = $(".inc_unit_add").val();
			
			
			$(".overStart").each(function(){
				var status = $(this).val();
				if(start==status){
					$(this).parent().attr('class','control-group error');
					$(this).parent().find('.help-block').html('This value must be unique');
					
				} else {
					$(this).parent().attr('class','control-group');
					$(this).parent().find('.help-block').html('');					
				}			
			});
			
			$(".overEnd").each(function(){
				var status = $(this).val();
				if(end==status){
					$(this).parent().attr('class','control-group error');
					$(this).parent().find('.help-block').html('This value must be unique');
					
				} else {
					$(this).parent().attr('class','control-group');
					$(this).parent().find('.help-block').html('');					
				}			
			});		
			$(".overUnit").each(function(){
				var status = $(this).val();
				if(unit==status){
					$(this).parent().attr('class','control-group error');
					$(this).parent().find('.help-block').html('This value must be unique');
					
				} else {
					$(this).parent().attr('class','control-group');
					$(this).parent().find('.help-block').html('');					
				}			
			});
		
			var errors = $("#inc_unitsTbody tr .error").length;
			
			if(errors ==0){
				var inc_unit_row = incUnit(start, end, unit);
				
				$("#inc_unitsTbody").append(inc_unit_row);
				
				//clear the form inputs for the next rows
				$(".inc_unit_start").val('');
				$(".inc_unit_end").val('');
				$(".inc_unit_add").val('');
				$(".inc_unit_start").focus();
				
				//removes the incremental unit table row
				$("#createdIncUnitsTable tbody button").click(function(){
					$(this).parent().parent().remove();
				});				
			} else {
				alert('There are '+errors+' errors with your incremental units creation. Please adjust your values accordingly.');
			}
			
			
		});
	}
}

var towedInput = function(name, desc){
	var row =$(".towedUnitsOl li").length;
	input = 
		'<li class="alert alert-info" style="margin-bottom:2px;">'+
			'<button type="button" class="close" data-dismiss="alert">&times;</button>'+name+' ('+desc+')'+
			'<input type="hidden" name="data[Inventory][towed_units]['+row+'][name]" value="'+name+'"/>'+
			'<input type="hidden" name="data[Inventory][towed_units]['+row+'][desc]" value="'+desc+'"/>'+
		'</li>';
	
	return input;
}
var incUnit = function(start, end, unit){
	var row = $("#inc_unitsTbody tr").length;
	tr = 
		'<tr>'+
			'<td class="inc_unit_start_td"><div class="control-group" style="margin:0"><input type="text" class="overStart" name="data[Incremental_unit]['+row+'][start]" value="'+start+'"/><span class="help-block" style="margin:0px;"></span></div></td>'+
			'<td class="inc_unit_end_td"><div class="control-group" style="margin:0"><input type="text" class="overEnd" name="data[Incremental_unit]['+row+'][end]" value="'+end+'"/><span class="help-block" style="margin:0px;"></span></div></td>'+
			'<td class="inc_unit_add_td"><div class="control-group" style="margin:0"><input type="text" class="overUnit" name="data[Incremental_unit]['+row+'][inc_units]" value="'+unit+'"/><span class="help-block" style="margin:0px;"></span></div></td>'+
			'<td><button type="button" class="incUnitRemove btn btn-link btn-small">remove</button></td>'+
		'</tr>';
		
	return tr;
}
