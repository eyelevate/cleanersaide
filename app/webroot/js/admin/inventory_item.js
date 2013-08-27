$(document).ready(function(){
	//numberformatting
	inventory.numberformat();

	inventory.images();
});

/**
 * Functions 
 */

inventory = {
	numberformat: function(){

		$(".price").priceFormat({
			'prefix':'',
		});		
	},
	images: function(){

		$(".inventoryImage").click(function(){
			$(this).parent().find('li').removeClass('image_selected');

			$(this).addClass('image_selected');	
			source = $(this).find('img').attr('src');
			$("#imageInput").val(source);		
		});
		
	}
}
