(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
/*
    $(function() {
      $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    });
*/

    $('.carousel').carousel({interval: 6000});
		
	});
    $(document).ready(function(){
      $('.search-trigger').click(function(){
        setTimeout(function(){$('.search-box input').focus();},500);
      });
      //console.log('hello');
	  $('.tax-product_tag header nav ul li#menu-item-836').addClass('active');
	  
	    
		$("#myCarousel").swiperight(function() { 
			$("#myCarousel").carousel('prev');  
		});  
		$("#myCarousel").swipeleft(function() {  
			$("#myCarousel").carousel('next');  
		});  
	
	  
	  
	  
    })
	
})(jQuery, this);

