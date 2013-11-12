$(document).ready(function(){
	printing.events();
	printing.timedRedirect(30);
});

printing = {
	events: function(){

	},
	timedRedirect: function(duration,message){
	    // If no message is provided, we use an empty string
	    message = message || "";
	    alert_box = $("#redirect-alert");
	    // Get reference to container, and set initial content
	    var container = alert_box.html('Redirecting in '+duration +' second(s). Please wait for reciepts to finish printing.');
	    var customer_id = $("#customer_id").val();
	    // Get reference to the interval doing the countdown
	    var countdown = setInterval(function () {
	        // If seconds remain
	        if (--duration) {
	        	if(duration>=15){
	        		alert_box.attr('class','alert alert-success');
	        	} else if(duration>= 5 && duration <15){
	        		alert_box.attr('class','alert alert');
	        	} else if(duration >= 1 && duration <5){
	        		alert_box.attr('class','alert alert-error');
	        	} 
	            // Update our container's message
	            container.html('Redirecting in '+duration +' second(s). Please wait for reciepts to finish printing.');
	        // Otherwise
	        } else {
	            // Clear the countdown interval
	            clearInterval(countdown);
	            // And fire the callback passing our container as `this`
				alert_box.html('<span class="badge badge-inverse">0 seconds</span> You are now being redirected.');
				 window.location = "/invoices/index/"+customer_id;
	        }
	    // Run interval every 1000ms (1 second)
	    }, 1000);
	},

};
