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
			$(this).blur()
		});

	},
	slider: function(){
		var options = {
			autoPlay: true,
			autoPlayDelay: 5000,
			nextButton: true,
			prevButton: true,
			//preloader: true,
			animateStartingFrameIn: true,
			transitionThreshold: 500,
			fallback: {
	        	theme: "slide",
	        	speed: 500
	        }
		};
		
		var sequence = $("#sequence").sequence(options).data("sequence");

		sequence.afterLoaded = function(){
			$(".info").css('display','block');
		    $("#sequence .slider_nav_holder").fadeIn(100);
			$("#sequence .slider_nav_holder span:nth-child("+(sequence.settings.startingFrameID)+")").addClass("active");

		}

		   sequence.beforeNextFrameAnimatesIn = function() {
		        $("#sequence .slider_nav_holder span:not(:nth-child("+(sequence.nextFrameID)+"))").removeClass("active");
		        $("#sequence .slider_nav_holder span:nth-child("+(sequence.nextFrameID)+")").addClass("active");
		    }

		$("#sequence").on("click", ".slider_nav", function() {
	        $(this).removeClass("active").addClass("active");
	        //console.log($(this).index()+1)
	        sequence.goTo($(this).index()+1);
	   });		
	},
	carousel: function(){
		$('#featured_packages_carousel').jcarousel({
		   	scroll: ($(window).width() > 767 ? 4 : 1),
		   	easing: 'easeInOutExpo',
		   	animation: 600
		});
	},
	events: function(){

	}

}

requests = {

}
addScripts = {

}
