$(document).ready(function(){
	rack.events();
	
	setTimeout(function(){
		rack.initialize();
	}, 1000);
	
	
});

rack = {
	initialize: function(){
		$("#rackInput").val('').focus();	
	},
	
	events: function(){
		
		
		$('#rackInput').on('keyup', function(e) {
		    if (e.which == 13) {
		        $("#submitRack").click();
		        
		        e.preventDefault();
		        
		    }
		});		
		
		$("#submitRack").click(function(){
			var number = $("#rackInput").val();
			var number_length = number.length;
			switch(number_length){
				case 6: //this is a new row and adding new invoice

					count_row = $("#rackTbody tr").length;
					//create a new row
					new_row = newRow(number,count_row);
					$("#rackTbody tr").attr('status','notactive');
					$("#rackTbody").append(new_row);
					
					$("#rackTbody tr[status='active'] .removeRow").click(function(){
						if(confirm('Are you sure you want to delete this row?')){
							$(this).parents('tr:first').remove();
							rack.summary();
						}
					});
					
					rack.summary();
					rack.print(); //print a new row
				break;
				
				default: //this is a rack
					//enter rack
					$("#rackTbody tr[status='active'] #rackNumberInput").val(number);
				break;
			}
			$("#rackInput").val('').focus();
		});
	},
	
	summary: function(count){
		count = $("#rackTbody tr").length;
		$("#total_quantity").html(count);
	},
	
	print: function(){
		
	}

};

var newRow = function(invoice_id,idx){
	row = '<tr id="rackTbodyTr-'+invoice_id+'" status="active">'+
		'<td class="rackInvoiceIdTd">'+
			'<input id="rackInvoiceInput" type="text" value="'+invoice_id+'" name="data[Invoice]['+count_row+'][invoice_id]"/>'+
		'</td>'+
		'<td class="rackNumberTd">'+
			'<input id="rackNumberInput" type="text" value="" name="data[Invoice]['+count_row+'][rack]"/>'+
		'</td>'+
		'<td>'+
			'<a class="removeRow" style="cursor:pointer;">remove</a>'+
		'</td>'+
		'</tr>';
	return row;
};
