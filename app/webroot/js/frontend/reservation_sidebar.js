$(document).ready(function(){
	sidebar.deleteSidebar();
	sidebar.clearcart();
});

/**
 * Functions
 */
sidebar = {
	//delete individual trips form the ferry sidebar
	deleteSidebar: function(){
		$(".removeSidebar").click(function(){
			if(confirm('Are you sure you want to remove this trip from the cart?')){
				var thisRow = $(this).attr('row');
				if(thisRow == '0' || thisRow == ''){
					thisRow = 'zero';
				}
				$(this).parent().parent().parent().parent().remove();
				$.post(
					'/reservations/request_delete_sidebar',
					{
						type:'RESERVATION_DELETE_SIDEBAR',
						deleteSidebar: thisRow
					},	function(results){
						
			
					}
				);					
				
			}
		});
		$(".removeHotel").click(function(){
			if(confirm('Are you sure you want to remove this hotel from the cart?')){
				var thisRow = $(this).attr('row');
				if(thisRow == '0' || thisRow == ''){
					thisRow = 'zero';
				}
				$(this).parent().parent().remove();
				$.post(
					'/reservations/request_delete_hotel',
					{
						type:'RESERVATION_DELETE_HOTEL',
						deleteSidebar: thisRow
					},	function(results){
						
			
					}
				);					
				
			}
		});		
		$(".removeAttraction").click(function(){
			if(confirm('Are you sure you want to remove this Attraction from the cart?')){
				var thisRow = $(this).attr('row');
				if(thisRow == '0' || thisRow == ''){
					thisRow = 'zero';
				}
				$(this).parent().parent().remove();
				$.post(
					'/reservations/request_delete_attraction',
					{
						type:'RESERVATION_DELETE_ATTRACTION',
						deleteSidebar: thisRow
					},	function(results){
						
			
					}
				);					
				
			}
		});	
		$(".removePackage").click(function(){
			if(confirm('Are you sure you want to remove this Package from the cart?')){
				var thisRow = $(this).attr('row');
				if(thisRow == '0' || thisRow ==''){
					thisRow = 'zero';
				}
				$(this).parent().parent().remove();
				$.post(
					'/reservations/request_delete_package',
					{
						type:'RESERVATION_DELETE_PACKAGE',
						deleteSidebar: thisRow
					},	function(results){
						
			
					}
				);					
				
			}
		});				
	},
	//delete the whole entire cart
	clearcart: function(){
		$("#clearcart").click(function(e){
			if(confirm('Are you sure you would like to remove all contents from your cart?')){
				//remove all of the ferry data
				$(".ferry").remove();
				//remove all of the hotel data
				$(".hotel").remove();
				//remove all of the attraction data
				$.post(
					'/reservations/request_clear_cart',
					{
						type:'RESERVATION_CLEAR_CART',
					},	function(results){

					}
				);				
			}
			// Prevent the anchor's default click action
		    e.preventDefault();
		});
	}
}
