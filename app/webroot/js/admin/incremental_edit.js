$(document).ready(function(){
	incremental.numberformat();
	incremental.validation();
});

/**
 *Functions 
 */

incremental = {
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
		$(".insertIncUnitStart").priceFormat({
			'prefix':'',
		});
		$(".insertIncUnitEnd").priceFormat({
			'prefix':'',
		});
		$(".insertIncUnitAdd").priceFormat({
			'prefix':'',
		});
	},	
	validation: function(){
		//removes the incremental unit table row
		$(".deleteButtonInc").click(function(){
			var row = $(this).attr('row');
			
			if (confirm("Are You Sure You Want To Delete?")) { 
			 // do things if OK
				var deleteRow = '<input type="hidden" name="data[Delete]['+row+']" value="'+row+'"/>';
				$(".deleteDiv").append(deleteRow);
				$(this).parent().parent().remove();
			}			
			
		});
		
		$("#createIncUnitButton").click(function(){
			var start = $(".inc_unit_start").val();
			var end = $(".inc_unit_end").val();
			var unit = $(".inc_unit_add").val();
			
			//First check to see if values are empty
			if(start ==''){
				$(".inc_unit_start").parent().parent().attr('class','control-group error');
				$(".inc_unit_start").parent().parent().find('.help-block').html('Overlength start cannot be left empty');				
			}  else {
				$(".inc_unit_start").parent().parent().attr('class','control-group');
				$(".inc_unit_start").parent().parent().find('.help-block').html('');					
			}
			
			if(end ==''){
				$(".inc_unit_end").parent().parent().attr('class','control-group error');
				$(".inc_unit_end").parent().parent().find('.help-block').html('Overlength end cannot be left empty');					
			} else {
				$(".inc_unit_end").parent().parent().attr('class','control-group');
				$(".inc_unit_end").parent().parent().find('.help-block').html('');	
			}
			
			if(unit ==''){
				$(".inc_unit_add").parent().parent().attr('class','control-group error');
				$(".inc_unit_add").parent().parent().find('.help-block').html('Incremental unit cannot be left empty');					
			} else {
				$(".inc_unit_add").parent().parent().attr('class','control-group');
				$(".inc_unit_add").parent().parent().find('.help-block').html('');	
			}
			
			//if the values are all properly set
			if(start != '' && end != '' && unit != ''){
				//next check to see if start is larger than end
				if(parseFloat(start) > parseFloat(end)){
					$(".inc_unit_start").parent().parent().attr('class','control-group error');
					$(".inc_unit_start").parent().parent().find('.help-block').html('Overlength start value must be less than Overlength end value');
				} else { //if start is less than larger then run the rest of the validation
					
					//remove error classes and messages
					$(".inc_unit_start").parent().parent().attr('class','control-group');
					$(".inc_unit_start").parent().parent().find('.help-block').html('');
					
					//check the page for errors before proceeding
					var errors = incremental.checkErrors(start, end, unit);	
					
					//if the page is error free
					if(errors ==0){
						var tr = incUnitEdit(start, end, unit);
						var whereTotal = $(".insertIncUnitEnd").length;
						
						$(".insertIncUnitEnd").each(function(idx){
	
							var status = parseFloat($(this).val());
							var nextStatus = parseFloat($(this).parent().parent().parent().next('tr').find('.insertIncUnitStart').val());
							var unitStatus = parseFloat($(this).parent().parent().parent().find('.insertIncUnitAdd').val());
							
							if(status > parseFloat(start)){
								
							}
							
							if (parseFloat(start) > status && parseFloat(start) < nextStatus){
								$(this).parent().parent().parent().after(tr);	
								return false;						
							}
							
							if(parseFloat(start) < status && parseFloat(end) < status && parseFloat(unit) < unitStatus){
								$("#inc_unitsTbody").prepend(tr);
								return false;
							}
						
							if(idx == whereTotal-1){

								$("#inc_unitsTbody").append(tr);

							}

						});
	
						//clear the form inputs for the next rows
						$(".inc_unit_start").val('');
						$(".inc_unit_end").val('');
						$(".inc_unit_add").val('');
						$(".inc_unit_add").focus();
						//removes the incremental unit table row
						$(".insertIncUnitStart").priceFormat({
							'prefix':'',
						});		
						$(".insertIncUnitEnd").priceFormat({
							'prefix':'',
						});	
						$(".insertIncUnitAdd").priceFormat({
							'prefix':'',
						});			
						$("#createdIncUnitsTable tbody button").click(function(){
							if (confirm("Are you sure you want to delete?")) { 
								// do things if OK
								$(this).parent().parent().remove();
							}			
						});			
					}
				}	
			}	
			
		});

	},
	checkErrors: function(start, end, unit){
		//check if the table shows any errors. check for errors in table value placement. 
		start = parseFloat(start);
		end = parseFloat(end);
		unit = parseFloat(unit);
		
		//first reset all errors start fresh
		$(".inc_unit_start").parent().parent().attr('class','control-group');
		$(".inc_unit_start").parent().parent().find('.help-block').html('');
		$(".inc_unit_end").parent().parent().attr('class','control-group');
		$(".inc_unit_end").parent().parent().find('.help-block').html('');		
		$(".inc_unit_add").parent().parent().attr('class','control-group');
		$(".inc_unit_add").parent().parent().find('.help-block').html('');	
		$("#inc_unitsTbody td").attr('class','control-group');
		$("#inc_unitsTbody td .help-block").html('');	
		
		//check to see if any of the overlength start fields in the table match the overlength start value 
		$(".insertIncUnitStart").each(function(){
			var overStart = parseFloat($(this).val());
			var overEnd = parseFloat($(this).parent().parent().parent().find('.insertIncUnitEnd').val());
			var overUnit = parseFloat($(this).parent().parent().parent().find('.insertIncUnitAdd').val());
			if(start==overStart){
				$(".inc_unit_start").parent().parent().attr('class','control-group error');
				$(".inc_unit_start").parent().parent().find('.help-block').html('Overlength Start value must be unique. Please enter a new start value.');
				$(this).parent().attr('class','control-group error');
				$(this).parent().find('.help-block').html('This value must be unique');
				return false;
			} else {
				$(".inc_unit_start").parent().parent().attr('class','control-group');
				$(".inc_unit_start").parent().parent().find('.help-block').html('');
				$(this).parent().attr('class','control-group');
				$(this).parent().find('.help-block').html('');	
			}
		});
		
		//next do the same for  overlength end
		$(".insertIncUnitEnd").each(function(){
			var status = parseFloat($(this).val());
			if(end==status){
				$(".inc_unit_end").parent().parent().attr('class','control-group error');
				$(".inc_unit_end").parent().parent().find('.help-block').html('Overlength End value must be unique. Please enter a new end value.');
				$(this).parent().attr('class','control-group error');
				$(this).parent().find('.help-block').html('This value must be unique');
				return false;
			} else {
				$(".inc_unit_end").parent().parent().attr('class','control-group');
				$(".inc_unit_end").parent().parent().find('.help-block').html('');
				$(this).parent().attr('class','control-group');
				$(this).parent().find('.help-block').html('');					
			}			
		});		
		//finally check the incremental units value to the table
		$(".insertIncUnitAdd").each(function(){
			var status = parseFloat($(this).val());
			if(unit==status){
				$(".inc_unit_add").parent().parent().attr('class','control-group error');
				$(".inc_unit_add").parent().parent().find('.help-block').html('Incremental Unit value must be unique. Please enter a new value.');
				$(this).parent().attr('class','control-group error');
				$(this).parent().find('.help-block').html('This value must be unique');
				return false;
			} else {
				$(".inc_unit_add").parent().parent().attr('class','control-group');
				$(".inc_unit_add").parent().parent().find('.help-block').html('');
				$(this).parent().attr('class','control-group');
				$(this).parent().find('.help-block').html('');					
			}			
		});
		
		//check the amount of errors commited. If there are more than 0 then show an error and exit out of function 
		var errors = $(".error").length;
		
		if(errors >0){
			return errors;	
		} else {
			// if there are no errors still then move on to the next step of validation
			
			//set the 3 values again
			var start = parseFloat($(".inc_unit_start").val());
			var end = parseFloat($(".inc_unit_end").val());
			var unit = parseFloat($(".inc_unit_add").val());
			
			//check all of the overlength start values in the table
			var rows = 0;
			$(".insertIncUnitStart").each(function(idx){
				var start = parseFloat($(".inc_unit_start").val());

				var overStart = parseFloat($(this).val());
				rows = rows+1;
				//find what row the new unit belongs to
				if(start < overStart){
					
					
					return false;
				}	
			});
			var start = parseFloat($(".inc_unit_start").val());
			var end = parseFloat($(".inc_unit_end").val());
			var unit = parseFloat($(".inc_unit_add").val());
			var overStart = $("#inc_unitsTbody tr:nth-child("+(rows-1)+")").find('.insertIncUnitStart').val();
			var overEnd = $("#inc_unitsTbody tr:nth-child("+(rows-1)+")").find('.insertIncUnitEnd').val();
			var overUnit = $("#inc_unitsTbody tr:nth-child("+(rows-1)+")").find('.insertIncUnitAdd').val();
			var overNextStart = $("#inc_unitsTbody tr:nth-child("+(rows+1)+")").find('.insertIncUnitStart').val();
			var overNextEnd = $("#inc_unitsTbody tr:nth-child("+(rows+1)+")").find('.insertIncUnitEnd').val();
			var overNextUnit = $("#inc_unitsTbody tr:nth-child("+(rows+1)+")").find('.insertIncUnitAdd').val();
			// var overNextCount = $(this).parent().parent().parent().next('tr').length;
			// var beforeCount = $(this).parent().parent().parent().prev('tr').length;	
			if((rows-1) < 0){
				if(start < overStart && end > overStart){
					errors = 1;
				}
				
			} 
			return errors;
		}


		
			
	}
}

var incUnitEdit = function(start, end, unit){
	var row = $('.newIncUnitRowTr').length;
	tr = 
		'<tr class="newIncUnitRowTr" style="background-color:#c8ffcb;">'+
			'<td class="inc_unit_start">'+
				'<div class="control-group" style="margin:0;">'+
					'<input class="insertIncUnitStart" type="text" value="'+start+'" name="data[Incremental_unit_new]['+row+'][start]"/>'+
					'<span class="help-block" style="margin:0px;"></span>'+
				'</div>'+
			'</td>'+
			'<td>'+
				'<div class="control-group" style="margin:0;">'+
					'<input class="insertIncUnitEnd" type="text" value="'+end+'" name="data[Incremental_unit_new]['+row+'][end]"/>'+
					'<span class="help-block" style="margin:0px;"></span>'+
				'</div>'+				
			'</td>'+			
			'<td>'+
				'<div class="control-group" style="margin:0;">'+
					'<input class="insertIncUnitAdd" type="text" value="'+unit+'" name="data[Incremental_unit_new]['+row+'][inc_units]"/></td>'+
					'<span class="help-block" style="margin:0px;"></span>'+
				'</div>'+				
			'</td>'+
					
			'<td><button type="button" class="incUnitRemove btn btn-link btn-small">remove</button></td>'+
		'</tr>';

	return tr;
}
