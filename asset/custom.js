jQuery.noConflict();
//scroll to top
jQuery(function($) {
  
    // When to show the scroll link
    // higher number = scroll link appears further down the page    
    var upperLimit = 100; 
        
    // Our scroll link element
    var scrollElem = $('a#scroll-to-top');
    
    // Scroll Speed. Change the number to change the speed
    var scrollSpeed = 600;
    
    // Choose your easing effect http://jqueryui.com/resources/demos/effect/easing.html
    var scrollStyle = 'swing';
    
    
    // Show and hide the scroll to top link based on scroll position    
    scrollElem.hide();
    $(window).scroll(function () {          
        var scrollTop = $(document).scrollTop();        
        if ( scrollTop > upperLimit ) {
            $(scrollElem).stop().fadeTo(300, 1); // fade back in            
        }else{      
            $(scrollElem).stop().fadeTo(300, 0); // fade out
        }
    });

    // Scroll to top animation on click
    $(scrollElem).click(function(){ 
        $('html, body').animate({scrollTop:0}, scrollSpeed, scrollStyle ); return false; 
    });
 
});

jQuery(document).ready(function($) {
	//cloudzoom gallery for single product page
	var thumbs = [];
	$('.cloud-zoom-gallery').each(function() {
		thumbs.push(this);
	});
	$('.cloud-zoom-gallery').on('click', function() {
		//if($.inArray(this, thumbs)===-1) thumbs.push(this);
		for(var i=0;i<thumbs.length;i++) $(thumbs[i]).closest('li').removeClass('active');
		$(this).closest('li').addClass('active');
	});
	
});