$(document).ready(function(){
	//number formatting 
	ferry.numberformat();
	
	//stepy wizard setup
	ferry.stepy("#ferry");
	
	//step 1 Create Inventory Type Scripts
	$("#addInventoryTypeButton").click(function(){
		var inventory = $('.inventory_type_name').val();
		var ferry_id = $('.ferry_id').val();
		ferry.createInventoryType(ferry_id,inventory);
	});
	//step 1 delete inventory type
	$(".removeInventoryType").click(function(){
		var inv_id = $(this).attr('inv');
		var ferry_id = $("#ferry_id").val();
		ferry.deleteInventoryType(inv_id, ferry_id);
	});
	//step 1 Validation
	ferry.step1Validate();
	
	//Step 2 Validation
	ferry.step2Validate();
	
	//Step 2 Create Inventory
	$("#addInventoryItem").click(function(){
		ferry.step2Create();
	});
	
	//step2 validation
	ferry.step3Validate();
});

/**
 * Form Creation
 */
ferry = {
	numberformat: function(){
		//number formatting
		$(".oneway").priceFormat({
			'prefix':'',
		});
		$(".surcharge").priceFormat({
			'prefix':'',
		});
		$(".total").priceFormat({
			'prefix':'',
		});
		$(".inc_unit_rate").priceFormat({
			'prefix':'',
		});
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
		$('.overlength_base_unit').priceFormat({
			'prefix':'',
		});
		$('.overlenegth_extra_fee').priceFormat({
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
		$(".inv_item_oneway").priceFormat({
			'prefix':'',
		});
		$(".inv_item_oneway").priceFormat({
			'prefix':'',
		});
		$(".inv_item_surcharge").priceFormat({
			'prefix':'',
		});
		$(".inv_item_total").priceFormat({
			'prefix':'',
		});
		$(".base_unit_input").priceFormat({
			'prefix':'',
		});
		$(".overlength_rate_input").priceFormat({
			'prefix':'',
		});
		$(".inc_unitsTable tbody tr input").priceFormat({
			'prefix':'',
		});
		$(".inc_unit_start_edit").priceFormat({
			'prefix':''
		});
		$(".inc_unit_end_edit").priceFormat({
			'prefix':''
		});
		$(".inc_unit_add_edit").priceFormat({
			'prefix':''
		});

	},
	stepy: function(name){ //stepy wizard
		$(name).stepy({
			next: function(index) {
				$("#toTopHover").click();
				if(index ==2){ //moving into step 2
					//check to see if any rows were created if there are no rows then submit error
					var inventoryLength = $("#inventoryTbody tr").length;
					if(inventoryLength == 0){
						$("#ferry-step-0-error").html('Error: You must create at least one inventory before moving onto the next step!');
						$("#ferry-step-0-error").show();
						//setTimeout(function () {$("#ferry-back-1").click(); }, 100);
					} else { // you are ready to create limits for every item
						$("#ferry-step-0-error").html('');
						$("#ferry-step-0-error").hide();						
					}
				}
			},
			finishButton: false,
			description:	false,
			legend:			false,
			titleClick:		true,
			block : true,
			errorImage : true,
			nextLabel: 'Next <i class="icon-chevron-right icon-white"></i>',
			backLabel: '<i class="icon-chevron-left"></i> Back',	
			validate : false //change to true if using jquery validation else keep false
		});
		$('.stepy-titles').each(function(){
			$(this).children('li').each(function(index){
				var myIndex = index + 1
				$(this).append('<span>Step '+(index+1)+'</span><span class="stepNb">'+myIndex+'</span>');
			});
		});	
		stepy_validation = $(name).validate({
			onfocusout: false,
			errorPlacement: function(error, element) {
				error.appendTo( element.closest("div.controls") );
			},
			highlight: function(element) {
				$(element).closest("div.control-group").addClass("error f_error");
				var thisStep = $(element).closest('form').prev('ul').find('.current-step');
				thisStep.addClass('error-image');
			},
			unhighlight: function(element) {
				$(element).closest("div.control-group").removeClass("error f_error");
					if(!$(element).closest('form').find('div.error').length) {
					var thisStep = $(element).closest('form').prev('ul').find('.current-step');
					thisStep.removeClass('error-image');
				};
			},
			rules: {
				//'data[Hotel][address]':'required',
			}, messages: {
				//'data[Hotel][address]': {required: 'Address field is required!'},

			}
		});
	},
	step1Validate: function(){
		//create inc units
		$("#createIncUnitButton").click(function(){
			var start = $(".inc_unit_start").val();
			var end = $(".inc_unit_end").val();
			var unit = $(".inc_unit_add").val();
			
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
		});
		//create towed unit rows
		$("#createTowedUnit").click(function(){
			var name = $(".towed_unit_name").val();
			var desc = $(".towed_unit_description").val();
			var towed = towedUnit(name, desc);
			
			//grab the html for towed unit and place it into div
			$('#createdTowedUnitsDiv').append(towed);
			//reset the form fields
			$(".towed_unit_name").val('');
			$(".towed_unit_description").val('');
			$(".towed_unit_name").focus();
		});
		
		//remove incremental unit table row
		$(".removeIncRow").click(function(){
			var id = $(this).parent().parent().attr('row');
			var removed = '<input type="hidden" name="data[remove][Incremental_unit]['+id+']"/>';
			$(".removeInventoryTypeInput").append(removed);
			$(this).parent().parent().remove();
		});
		//removed towed unit table
		$(".removeTowedUnitButton").click(function(){
			var id = $(this).parent().parent().attr('row');
			var removed = '<input type="hidden" name="data[remove][Inventory][towed_unit]['+id+']"/>';
			$(".removeInventoryTypeInput").append(removed);
			$(this).parent().parent().remove();
		});
		
		//add incremental unit table row
		$(".addIncUnitsRow").click(function(){
			//var idx = $('table tbody .newIncUnitTr').length;
			var inventory_id = $(this).attr('row');
			var newIncUnitRow = incUnitEdit('','','',inventory_id);
					
			$(this).parent().parent().find('table tbody').append(newIncUnitRow);
			$(".newIncUnitRemoveButton").click(function(){
				$(this).parent().parent().remove();
			});
			$(".incUnitRemove").click(function(){
				$(this).parent().parent().remove();
			});
			$(".insertIncUnitStart").priceFormat({
				'prefix':''
			});
			$(".insertIncUnitEnd").priceFormat({
				'prefix':''
			});
			$(".insertIncUnitAdd").priceFormat({
				'prefix':''
			});
			$(".newIncUnitTr input").priceFormat({
				'prefix':''
			});
		});
		
		$(".addOverlengthDetails").click(function(){
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$(this).parent().parent().find('.addOverlengthDetailsDiv').fadeIn();
			} else {
				$(this).parent().parent().find('.addOverlengthDetailsDiv').fadeOut();
			}
		});
		$(".addIncrementalUnits").click(function(){
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$(this).parent().parent().find('.addIncrementalUnitsDiv').fadeIn();
			} else {
				$(this).parent().parent().find('.addIncrementalUnitsDiv').fadeOut();
			}
		});
		$(".addTowedUnits").click(function(){
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$(this).parent().parent().find('.addTowedUnitsDiv').fadeIn();
			} else {
				$(this).parent().parent().find('.addTowedUnitsDiv').fadeOut();
			}
		});
		//creates new incremental units on the edit page on the inventory level
		$('.addIncUnitButton').click(function(){
			//create the variables for the form data
			var start =  $(this).parent().parent().parent().find('.inc_unit_start_edit').val();
			var end = $(this).parent().parent().parent().find('.inc_unit_end_edit').val();
			var unit = $(this).parent().parent().parent().find('.inc_unit_add_edit').val();
			var inventory_id = $(this).attr('row');
			var inc_unit_row = incUnitEdit(start, end, unit, inventory_id);
			
			//append the new table rows into the tbody of the inventory 
			$(this).parent().parent().parent().parent().parent().find(".inc_unitsTbody_edit").append(inc_unit_row);
			//clear the form inputs for the next rows
			$(".inc_unit_start_edit").val('');
			$(".inc_unit_end_edit").val('');
			$(".inc_unit_add_edit").val('');
			$(".inc_unit_start_edit").focus();
			
			$(".insertIncUnitStart").priceFormat({
				'prefix':''
			});
			$(".insertIncUnitEnd").priceFormat({
				'prefix':''
			});
			$(".insertIncUnitAdd").priceFormat({
				'prefix':''
			});
			//removes the incremental unit table row
			$("#createdIncUnitsTable tbody button").click(function(){
				$(this).parent().parent().remove();
			});
		});
		$(".createTowedUnitEdit").click(function(){
			//set the form variables
			var name = $(this).parent().parent().parent().find('.towed_unit_name_edit').val();
			var desc = $(this).parent().parent().parent().find('.towed_unit_description_edit').val();
			var inventory_id = $(this).attr('row');
			var row = $(this).parent().parent().parent().parent().parent().find(".towedTableEdit tr").length;
			//create the table row
			var towed_unit_row = towedUnitEdit(name, desc, inventory_id,row);
			$(this).parent().parent().parent().parent().parent().find(".towedTableEdit").append(towed_unit_row);
			
			//reset the form fields and focus back onto the first form field
			$(this).parent().parent().parent().find('.towed_unit_name').val('');
			$(this).parent().parent().parent().find('.towed_unit_desc').val('');
			$(this).parent().parent().parent().find('.towed_unit_name').focus();
			
			$(".towedTableEdit button").click(function(){
				$(this).parent().parent().remove();
			});
		});
		$(".addTowedRowButton").click(function(){
			//set the form variables
			var name = '';
			var desc = '';
			var inventory_id = $(this).attr('row');
			var row = $(this).parent().parent().parent().find("tbody tr").length;
			
			//create the table row
			var towed_unit_row = towedUnitEdit(name, desc, inventory_id,row);
			$(this).parent().parent().parent().find("tbody").append(towed_unit_row);
			
			$(".incUnitRemove").click(function(){
				$(this).parent().parent().remove();
			});		
		});
	},
	createInventoryType: function(id,name){
		//check to see if inventory type is empty
		if(name==''){
			//add control group errors to inventory type field on step 1
			$('.inventory_type_name').parent().parent().attr('class','control-group error');
			$('.inventory_type_name').parent().parent().find('.help-block').html('This field cannot be left empty');
		} else { //else send via ajax to check for futher validation and save
			//remove control group errors to inventory type field on step 1
			$('.inventory_type_name').parent().parent().attr('class','control-group');
			$('.inventory_type_name').parent().parent().find('.help-block').html('');
			
			//get the name of the inventory type
			var inventory_type = $(".inventory_type_name").val();
			$("#step1Form").append(hiddenInput(inventory_type,'data[Inventory][name]'));
			
			//get all of the overlength data
			var overlength_feet = $(".overlength_base_unit").val();
			var overlength_rate = $('.overlenegth_extra_fee').val();
			$("#step1Form").append(hiddenInput(overlength_feet,'data[Inventory][overlength_feet]'));
			$("#step1Form").append(hiddenInput(overlength_rate,'data[Inventory][overlength_rate]'));
			
			//get all of the incremental units
			$("#inc_unitsTbody tr").each(function(idx){
				var start = $(this).find('.inc_unit_start').html();
				var end = $(this).find('.inc_unit_end').html();
				var unit = $(this).find('.inc_unit_add').html();
				var ferry_id = $("#ferry_id").val();
				
				//add units to hidden form
				$("#step1Form").append(hiddenInput(ferry_id,'data[Incremental_unit]['+idx+'][ferry_id]'));
				$("#step1Form").append(hiddenInput(start,'data[Incremental_unit]['+idx+'][start]'));
				$("#step1Form").append(hiddenInput(end,'data[Incremental_unit]['+idx+'][end]'));
				$("#step1Form").append(hiddenInput(unit,'data[Incremental_unit]['+idx+'][inc_units]'));
				
			});
			
			//towed units
			$("#createdTowedUnitsDiv li").each(function(idx){
				var name = $(this).attr('name');
				var desc = $(this).attr('desc');
				
				$('#step1Form').append(hiddenInput(name,'data[Inventory][towed_units]['+idx+'][name]'));
				$('#step1Form').append(hiddenInput(desc,'data[Inventory][towed_units]['+idx+'][desc]'));
			});
			
			//clean house, clean the form for the next inventory type
			$("#inventory_overlength").removeAttr('checked');
			$("#inventory_type_inc").removeAttr('checked');
			$("#inventory_type_towed").removeAttr('checked');
			$(".overlength_base_unit").val('');
			$(".overlenegth_extra_fee").val('');
			$(".inc_unit_start").val('');
			$(".inc_unit_end").val('');
			$(".inc_unit_add").val('');
			$(".inc_unit_start").focus();
			$("#inc_unitsTbody").html('');
			$("#createdTowedUnitsDiv").html('');
			$("#extraOverlengthForm").hide();
			$("#extraIncUnitsForm").hide();
			$("#extraTowedUnitsForm").hide();
			
			//submit created form
			$("#step1Form").submit();
		}
	},
	deleteInventoryType: function(id, ferry_id){
	    if (confirm("Are you sure you want to delete?")) {
	        // your deletion code
			//send form via ajax to ferry request controller to save and refresh page.
			$.post(
				'/ferries/validate_form',
				{
					type:'delete_inventory_type',
					delete_id:id,
					ferry_id:ferry_id
				},	function(status){
					location.reload();	
				}
			);	
	    }
	    return false;	
	},
	step2Validate: function(){
		//first check what inventory type is being selected if vehicle show extra form
		$(".inventory_type").change(function(){
			//reset the form
			$(".inventory_name").val('');
			$(".inventory_description").val('');
			$("#extraIncUnitsForm").hide();
			$("#inventory_type_inc").removeAttr('checked');
			$("#inventory_type_towed").removeAttr('checked');
			$(".inc_unit_start").val('');
			$(".inc_unit_end").val('');
			$(".inc_unit_add").val('');
			$("#inc_unitsTbody").html('');
			$(".towed_unit_name").val('');
			$(".towed_unit_description").val('');
			$("#extraTowedUnitsForm").hide();
			$(".oneway").val('0.00');
			$(".surcharge").val('0.00');
			$(".total").val('0.00');
			$("#createdTowedUnitsDiv").html('');
			//show the extra form
			var inventory_id = $(this).find('option:selected').val();
			$(".extraVehicleFormDiv").hide();
			$("#extraVehicleFormDiv-"+inventory_id).show();
			//make the chosen extra form fields "active" status
			$(".extraVehicleFormDiv .overlengthSelect").attr('status','notactive');
			$(".extraVehicleFormDiv .incrementalSelect").attr('status','notactive');
			$(".extraVehicleFormDiv .towedSelect").attr('status','notactive');
			$("#extraVehicleFormDiv-"+inventory_id+' .overlengthSelect').attr('status','active');
			$("#extraVehicleFormDiv-"+inventory_id+' .incrementalSelect').attr('status','active');
			$("#extraVehicleFormDiv-"+inventory_id+' .towedSelect').attr('status','active');
		});

		//if the type is a vehicle then check to see if towed units have been selected if so then show even more of the form
		$("#inventory_type_towed").click(function(){
			var checked = $(this).attr('checked');
			//alert('clicked');
			if(checked == 'checked'){ 
				$("#extraTowedUnitsForm").fadeIn('fast');
			} else {
				$("#extraTowedUnitsForm").fadeOut('slow');
			}		
		});
		
		//If incremental Units were selected then show the incremental unit creation
		$("#inventory_type_inc").click(function(){
			var checked = $(this).attr('checked');
			//alert('clicked');
			if(checked == 'checked'){ 
				$("#extraIncUnitsForm").fadeIn('fast');
			} else {
				$("#extraIncUnitsForm").fadeOut('slow');
			}				
		});

		//if overlength vehicle is clicked on step 1
		$("#inventory_overlength").click(function(){
			var checked = $(this).attr('checked');
			//alert('clicked');
			if(checked == 'checked'){ 
				$("#extraOverlengthForm").fadeIn('fast');
			} else {
				$("#extraOverlengthForm").fadeOut('slow');
			}				
		});
			
		//keyup oneway, surcharge, total helper
		$(".oneway").keyup(function(){
			var oneway = parseFloat($(this).val());
			var surcharge = parseFloat($('.surcharge').val());
			var total = (oneway+surcharge).toFixed(2);
			
			$('.total').val(total);
			
		});
		$(".surcharge").keyup(function(){
			var oneway = parseFloat($('.oneway').val());
			var surcharge = parseFloat($(this).val());
			var total = (oneway+surcharge).toFixed(2);
			
			$('.total').val(total);
			
		});
		$(".inv_item_oneway").keyup(function(){
			var oneway = parseFloat($(this).val());
			var surcharge = parseFloat($(this).parent().parent().parent().parent().find('.inv_item_surcharge').val());
			var total = (oneway+surcharge).toFixed(2);
			
			$(this).parent().parent().parent().parent().find('.inv_item_total').val(total);
			
		});
		$(".inv_item_surcharge").keyup(function(){
			var oneway = parseFloat($(this).parent().parent().parent().parent().find('.inv_item_oneway').val());
			var surcharge = parseFloat($(this).val());
			var total = (oneway+surcharge).toFixed(2);
			
			$(this).parent().parent().parent().parent().find('.inv_item_total').val(total);
			
		});	
		$(".inv_item_total").keyup(function(){
			var total = parseFloat($(this).val());
			var oneway = parseFloat($(this).parent().parent().parent().parent().find('.inv_item_oneway').val());
			var surcharge = (total-oneway).toFixed(2);
			$(this).parent().parent().parent().parent().find('.inv_item_surcharge').val(surcharge);
			
		});
		//remove created inventory_item rows
		$(".removeInventoryButton").click(function(){
			var inventory_id = $(this).attr('row');
			var deleteRow = '<input type="hidden" name="data[Delete]['+inventory_id+']"/>';
			//add delete row of item
			$(".deleteInventoryItem").append(deleteRow);
			//remove the row from the table
			$(this).parent().parent().remove();
		});
	},
	step2Create: function(){
		//grab the variables from step 2 
		var type = $(".inventory_type option:selected").val();
		var type_html = $(".inventory_type option:selected").html();
		var name = $(".inventory_name").val();
		var inc_units = $(".incrementalSelect[status='active'] option:selected").val();
		var towed_units = $(".towedSelect[status='active'] option:selected").val();
		var desc = $(".inventory_description").val();
		var oneway = $(".oneway").val();
		var surcharge = $(".surcharge").val();
		var total = $(".total").val();
		var overlength = $(".overlengthSelect[status='active'] option:selected").val();
		//check to see if they are empty or not checked
		if(type ==''){
			$(".inventory_type").parent().parent().attr('class','control-group error');
			$(".inventory_type").parent().parent().find('.help-block').html('This field cannot be left empty');			
		} else {
			$(".inventory_type").parent().parent().attr('class','control-group');
			$(".inventory_type").parent().parent().find('.help-block').html('');				
		}
		if(name ==''){
			$(".inventory_name").parent().parent().attr('class','control-group error');
			$(".inventory_name").parent().parent().find('.help-block').html('This field cannot be left empty');				
		} else {
			$(".inventory_name").parent().parent().attr('class','control-group');
			$(".inventory_name").parent().parent().find('.help-block').html('');				
		}
		if(desc ==''){
			$(".inventory_description").parent().parent().attr('class','control-group error');
			$(".inventory_description").parent().parent().find('.help-block').html('This field cannot be left empty');				
		} else {
			$(".inventory_description").parent().parent().attr('class','control-group');
			$(".inventory_description").parent().parent().find('.help-block').html('');				
		}
		if(oneway==''){
			$(".oneway").parent().parent().parent().attr('class','control-group error');
			$(".oneway").parent().parent().parent().find('.help-block').html('This field cannot be left empty');				
		} else {
			$(".oneway").parent().parent().parent().attr('class','control-group');
			$(".oneway").parent().parent().parent().find('.help-block').html('');			
		}
		if(surcharge==''){
			$(".surcharge").parent().parent().parent().attr('class','control-group error');
			$(".surcharge").parent().parent().parent().find('.help-block').html('This field cannot be left empty');				
		} else {
			$(".surcharge").parent().parent().parent().attr('class','control-group');
			$(".surcharge").parent().parent().parent().find('.help-block').html('');			
		}
		if(total==''){
			$(".total").parent().parent().parent().attr('class','control-group error');
			$(".total").parent().parent().parent().find('.help-block').html('This field cannot be left empty');				
		} else {
			$(".total").parent().parent().parent().attr('class','control-group');
			$(".total").parent().parent().parent().find('.help-block').html('');				
		}

		ferry.createInventory(type,type_html,name,desc,oneway,surcharge,total,inc_units,towed_units,overlength);	

	},
	createInventory:function(type,type_html,name,desc,oneway,surcharge,total,inc_units,towed_units,overlength){
		//reset inventory form creation
		$(".inventory_type option[value='']").attr('selected','selected');
		$(".inventory_name").val('');
		$(".inventory_description").val('');
		$(".incrementalSelect[status='active'] option[value='No']").attr('selected','selected');
		$(".towedSelect[status='active'] option[value='No']").attr('selected','selected');
		$(".incrementalSelect[status='active'] option[value='No']").attr('selected','selected');
		$(".oneway").val('0.00');
		$(".surcharge").val('0.00');
		$(".total").val('0.00');
		$("#createdTowedUnitsDiv").html('');
		
		//set variables
		var newRow = inventoryTr(type,type_html,name,desc,oneway,surcharge,total,inc_units,towed_units,overlength);
		
		
		//take fields and create hidden inputs and tr for new row
		$("#inventoryTbody").append(newRow);
		$(".removeInventory").click(function(){
			$(this).parent().parent().remove();
		});
	},
	step3Validate: function(){
		$('.reservableUnits').click(function(){
			var reservable = $(this).val();
			if(reservable =='0'){
				$(this).val('');
			}
		});
		$('.total_units').click(function(){
			var reservable = $(this).val();
			if(reservable =='0'){
				$(this).val('');
			}
		});
		$(".reservableUnits").keyup(function(){
			var reservable = parseFloat($(this).val());
			var total = parseFloat($(this).parent().parent().parent().parent().find('.total_units').val());
			var capacity = (reservable / total)*100;
			var capacity = capacity.toFixed(2);
			$(this).parent().parent().parent().parent().find('.capacity').val(capacity);
		});
		
		$(".total_units").keyup(function(){
			var reservable = parseFloat($(this).parent().parent().parent().parent().find('.reservableUnits').val());
			var total = parseFloat($(this).val());
			var capacity = (reservable / total)*100;
			var capacity = capacity.toFixed(2);
			$(this).parent().parent().parent().parent().find('.capacity').val(capacity);			
		});
		
		//validate 
		$(".reservableUnits").blur(function(){
			var reservable = parseFloat($(this).val());
			if(reservable <= 0){
				$(this).parent().parent().parent().attr('class','control-group error');
				$(this).parent().parent().parent().find('.help-block').html('Error: cannot be by zero value');
			} 
			
			if(reservable == ''){
				$(this).parent().parent().parent().attr('class','control-group error');
				$(this).parent().parent().parent().find('.help-block').html('Error: cannot be left blank');
			} 		
			
		});
		$(".total_units").blur(function(){
			var total = parseFloat($(this).val());
			var capacity = parseFloat($(this).parent().parent().parent().parent().parent().parent().find('.capacity').val());

			if(total <= 0){
				$(this).parent().parent().parent().attr('class','control-group error');
				$(this).parent().parent().parent().find('.help-block').html('Error: cannot be zero value');
				$(this).parent().parent().parent().parent().parent().parent().find('#statusBadge').html('Not Set');
				$(this).parent().parent().parent().parent().parent().parent().find('#statusBadge').attr('class','label label-inverse');
			} 
			if(total == ''){
				$(this).parent().parent().parent().attr('class','control-group error');
				$(this).parent().parent().parent().find('.help-block').html('Error: cannot be left blank');
				$(this).parent().parent().parent().parent().parent().parent().find('#statusBadge').html('Not Set');
				$(this).parent().parent().parent().parent().parent().parent().find('#statusBadge').attr('class','label label-inverse');
			} 
			
			if(capacity > 0){
				$(this).parent().parent().parent().parent().parent().parent().find('#statusBadge').html('Set');
				$(this).parent().parent().parent().parent().parent().parent().find('#statusBadge').attr('class','label label-success');
			} else {
				$(this).parent().parent().parent().parent().parent().parent().find('#statusBadge').html('Not Set');
				$(this).parent().parent().parent().parent().parent().parent().find('#statusBadge').attr('class','label label-inverse');				
			}
			
		});

	}
}

/**
 * function variables
 */

var inventoryTr = function(type,type_html,name,desc,oneway,surcharge,total,inc_units,towed_units,overlength){
	if(desc =='' || desc =='undefined'){
		desc = '';
	}
	
	var row = $('#inventoryTbody tr').length;
	var row = parseInt(row);
	//get towed units and make them into select options
	var options = '';
	var towed_inputs = '';

	tr = 
		'<tr>'+
			'<td>'+type_html+'<input type="hidden" name="data[Inventory_item]['+row+'][inventory_id]" value="'+type+'"/><input type="hidden" name="data[Inventory_item]['+row+'][type]" value="'+type_html+'"/></td>'+
			'<td>'+name+'<input type="hidden" name="data[Inventory_item]['+row+'][name]" value="'+name+'"/></td>'+
			'<td>'+desc+'<input type="hidden" name="data[Inventory_item]['+row+'][description]" value="'+desc+'"/></td>'+
			'<td>'+overlength+
				'<input type="hidden" name="data[Inventory_item]['+row+'][overlength]" value="'+overlength+'"/>'+
			'</td>'+
			'<td>'+inc_units+
				'<input type="hidden" name="data[Inventory_item]['+row+'][inc_units]" value="'+inc_units+'"/>'+
			'</td>'+
			'<td>'+towed_units+
				'<input type="hidden" name="data[Inventory_item]['+row+'][towed_units]" value="'+towed_units+'"/>'+
			'</td>'+

			'<td>$'+oneway+'<input type="hidden" name="data[Inventory_item]['+row+'][oneway]" value="'+oneway+'"/></td>'+
			'<td>$'+surcharge+'<input type="hidden" name="data[Inventory_item]['+row+'][surcharge]" value="'+surcharge+'"/></td>'+
			'<td>$'+total+'<input type="hidden" name="data[Inventory_item]['+row+'][total_price]" value="'+total+'"/></td>'+
			'<td><button id="removeInventory-'+row+'" class="removeInventory btn btn-small btn-link" type="button">remove</button></td>'+
		'</tr>';
	return tr;	
}

var towedUnit = function(name, desc){
	towed = 
		'<li class="towedLi alert alert-small" name="'+name+'" desc="'+desc+'" style="margin-bottom:3px; border-color:#5e5e5e; background-color:#e5e5e5;">'+
			'<strong style="color:#5e5e5e">'+name+' ('+desc+')</strong> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
		'</li>';
	return towed;
}
var incUnit = function(start, end, unit){
	tr = 
		'<tr>'+
			'<td class="inc_unit_start">'+start+'</td>'+
			'<td class="inc_unit_end">'+end+'</td>'+
			'<td class="inc_unit_add">'+unit+'</td>'+
			'<td><button type="button" class="incUnitRemove btn btn-link btn-small">remove</button></td>'+
		'</tr>';
		
	return tr;
}
var incUnitEdit = function(start, end, unit, inventory_id){
	var row = $('.newIncUnitRowTr').length;
	tr = 
		'<tr class="newIncUnitRowTr">'+
			'<td class="inc_unit_start">'+
				'<input class="insertIncUnitStart" type="text" value="'+start+'" name="data[Incremental_unit_new]['+row+'][start]"/>'+
				'<input  type="hidden" value="'+inventory_id+'" name="data[Incremental_unit_new]['+row+'][inventory_id]"/>'+
			'</td>'+
			'<td ><input class="insertIncUnitEnd" type="text" value="'+end+'" name="data[Incremental_unit_new]['+row+'][end]"/></td>'+
			'<td ><input class="insertIncUnitAdd" type="text" value="'+unit+'" name="data[Incremental_unit_new]['+row+'][inc_units]"/></td>'+
			'<td><button type="button" class="incUnitRemove btn btn-link btn-small">remove</button></td>'+
		'</tr>';
	return tr;
}

var towedUnitEdit = function(name, desc, inventory_id, row){
	tr = 
		'<tr>'+
			'<td class="inc_unit_start">'+
				'<input class="insertIncUnitStart" type="text" value="'+name+'" name="data[Inventory]['+inventory_id+'][towed_units]['+row+'][name]"/>'+
			'</td>'+
			'<td ><input class="insertIncUnitEnd" type="text" value="'+desc+'" name="data[Inventory]['+inventory_id+'][towed_units]['+row+'][desc]"/></td>'+
			'<td><button type="button" class="incUnitRemove btn btn-link btn-small">remove</button></td>'+
		'</tr>';
	return tr;
}
//hidden form creation
var hiddenInput = function(value, name){
	input = 
		'<input type="hidden" name="'+name+'" value="'+value+'"/>';
		
	return input;
}
