$(document).ready(function(){
	printing.events();
});

printing = {
	events: function(){
		setTimeout(function(){
			$("#adminSubmitForm").submit();	
		}, 500);
		

	}
};
