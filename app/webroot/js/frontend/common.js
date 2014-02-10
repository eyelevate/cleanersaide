// Bind the possible Add to Cart btns with event to position top links
$(document).ready(function(){
	
	  
    $.reject({  
        reject: {
        	msie5: true, 
        	msie6: true, 
        	msie7: true, 
        	msie8: true  
        },
        header: 'Black Ball Ferry Line is optimized for modern browsers.', // Header Text  
        paragraph1: 'Your browser is out of date, and may not be compatible with our reservation system. If possible, we recommend upgrading your browser. A list of the most popular web browsers can be found below.', // Paragraph 1  
        paragraph2: 'Just click on the icons to get to the download page.',  
        closeMessage: 'By closing this window without upgrading your browser, you acknowledge that your experience on this website may be degraded.', // Message below close window link 
        closeCookie: true, // Set cookie to remmember close for this session
		display: ['chrome','firefox','safari','opera','msie']  
    });  
 
	
	// Menu Animation
    $('#menu ul li').hover(
        function() {
            $(this).addClass("active");
            $(this).find('div').not('.subsub_menu, .subsubsub_menu').stop(false, true).slideDown({
            	duration:300,
            	easing:"easeOutExpo"});
        },
        function() {
            $(this).removeClass("active");        
            $(this).find('div').not('.subsub_menu, .subsubsub_menu').stop(false, true).slideUp({
            	duration:100,
            	easing:"easeOutExpo"});
        }
    );

	// Sub Menu Animation
    $('#menu ul li li').hover(
        function() {
            $(this).find('.subsub_menu').stop(false, true).slideDown({
            	duration:300,
            	easing:"easeOutExpo"});
        },
        function() {        
            $(this).find('.subsub_menu').stop(false, true).hide();
        }
    );	
    
    // Subsub Menu Animation
    $('#menu ul li li li').hover(
    		function() {
    			$(this).find('.subsubsub_menu').stop(false, true).slideDown({
    				duration:300,
    				easing:"easeOutExpo"});
    		},
    		function() {        
    			$(this).find('.subsubsub_menu').stop(false, true).hide();
    		}
    );	
	

	
	// Sidebar Nav effects	
	$('.side_bar_nav a').not(".active").hover(
		function() {
			$(this).children('.hover_span').stop().animate({width:'100%'},500,'easeOutExpo');
		},
		function() {
			$(this).children('.hover_span').stop().animate({width:'0'},200,'easeOutExpo');
		}
	);	

	
	
	/* Accordions */	
	accordion = false;

	$(".acc_item").click(function(){
		
		if(accordion){
			$(".accordion_content").not($(this).find(".accordion_content")).slideUp(600,'easeInOutExpo');
			$(".accordion").not($(this).find(".accordion")).removeClass("active_acc");
		}
		$(this).find(".accordion").next(".accordion_content").slideToggle(600,'easeInOutExpo');
		
		if($(this).find(".accordion").hasClass('active_acc')){
			$(this).find(".accordion").removeClass("active_acc");
		}else{
			$(this).find(".accordion").addClass("active_acc");
		}
	});
	
	// Open First item if accordion is set to true;
	if(accordion){
		setTimeout(function(){$(".acc_holder .acc_item:first-child .accordion").delay(1500).click();},600);
	}	
	/* Accordions::END */
	
	
	
	/* Info Messages */
	$(".closable").each(function(){
		$(this).prepend('<a class="close_img"></a>');		
	});
	
	$(".close_img").click(function(){
		$(this).parent().fadeOut(600);
	});
	

	// Sidebar Menu effects
	$('.side_bar_menu a').not(".active").hover(
			function() {
				$(this).children('.hover_span').stop().animate({width:'100%'},500,'easeOutExpo');
			},
			function() {
				$(this).children('.hover_span').stop().animate({width:'0'},200,'easeOutExpo');
			}
	);	
	
	
});

/* TABS */
$.fn.tabs = function() {
	var selector = this;
	
	this.each(function() {
		var obj = $(this); 
		
		$(obj.attr('href')).hide();
		
		$(obj).click(function() {
			$(selector).removeClass('selected');
			
			$(selector).each(function(i, element) {
				$($(element).attr('href')).hide();
			});
			
			$(this).addClass('selected');
			
			$($(this).attr('href')).fadeIn();
			
			return false;
		});
	});

	$(this).show();
	
	$(this).first().click();
};