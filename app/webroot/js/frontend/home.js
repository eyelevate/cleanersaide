$(document).ready(function(){
	home.datePicker();
	home.slider();
	home.carousel();
	home.events();
});

/**
 * Functions
 */
home = {
	datePicker: function() {

		$(".datepicker").datepicker({minDate:0}).focus(function () {
			$(this).blur();
		});

	},
	slider: function(){
		$('.bxslider').bxSlider({
			"auto":true,
			"pause":5000,
			"autoDelay":1000,
		});
	},
	carousel: function(){

	},
	events: function(){

	}

};

requests = {

};
addScripts = {

};
