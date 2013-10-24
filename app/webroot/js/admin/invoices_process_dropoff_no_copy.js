$(document).ready(function(){
	printing.events();
});

printing = {
	events: function(){
		/**
		 * type
		 * 	codabar
			code11 (code 11)
			code39 (code 39)
			code93 (code 93)
			code128 (code 128)
			ean8 (ean 8)
			ean13 (ean 13)
			std25 (standard 2 of 5 - industrial 2 of 5)
			int25 (interleaved 2 of 5)
			msi
			datamatrix (ASCII + extended)
		 * 
		 */
		$("#bcTarget").barcode("123456", "code128",{barWidth:2, barHeight:50});;   
	}
};
