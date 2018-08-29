
$(document).ready(function () {
    $('.accordion-toggle').on('click', function(event){
    	event.preventDefault();
    	// create accordion variables
    	var accordion = $(this);
    	var accordionContent = accordion.next('.accordion-content');
    	var accordionToggleIcon = $(this).children('.toggle-icon');

    	// toggle accordion link open class
    	accordion.toggleClass("open");
    	// toggle accordion content
    	accordionContent.slideToggle(250);

		
		// change arrow icon
    	if (accordion.hasClass("open")) {
    		
			
			accordionToggleIcon.html("<span class='fa-stack fa-lg'><span class='fa fa-circle fa-stack-2x'></span><span class='fa fa-angle-down fa-stack-1x'></span></span>");
			
			
			
			
    	} else {
    		
			accordionToggleIcon.html("<span class='fa-stack fa-lg'><span class='fa fa-circle fa-stack-2x'></span><span class='fa fa-angle-right fa-stack-1x'></span></span>");
    	}
		
		
		
    });
});
