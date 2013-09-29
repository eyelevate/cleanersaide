$(document).ready(function(){
	search.events();	
});

search = {
	events: function(){
		$(".indexFingerInput").click(function(){
			user_id = $(this).val();	
			$(this).parents('tbody:first').find('tr').removeClass('status_select');
			$(this).parents('tr:first').addClass('status_select');
			
			search.selectInvoice(user_id);
		});
		$("#searchCustomersTable tbody tr td:not(:first-child)").click(function(){
			user_id = $(this).parents('tr:first').find('.indexFingerInput').val();
			$(this).parents('tbody:first').find('tr').removeClass('status_select');
			$(this).parents('tr:first').addClass('status_select');
			search.selectInvoice(user_id);
		});
	},
	selectInvoice: function(id){
		$(".indexFingerInput").removeAttr('checked');
		$("#indexFingerInput-"+id).attr('checked','checked');
	}
};
