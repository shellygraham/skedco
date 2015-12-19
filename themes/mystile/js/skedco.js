(function($) {
	if(typeof slides == "undefined") return false;
	var count = Object.keys(slides).length;
	d = Array();
	$.each(slides,function(){
		d.push('<li id="' + this.slug + '"><a href="javascript:go_to_slide(\'' + this.slug + '\')">' + this.title + '</a></li>');
		//console.log(this);
	});
	l = '<ul id="index-hero-ul">' + d.join('') + '</ul>';
	$('.index-page-hero').after(l);
	// click_me = jQuery('#index-hero-ul li').eq(0).attr('id');
	// setTimeout(function() { go_to_slide(click_me); }, 500)
	return false;
})(jQuery);

function go_to_slide(k) {
	slide = slides[k];
	jQuery('.index-page-hero h1.stacked').html(slide.headline).fadeOut(1).fadeIn(500);
	jQuery('.index-page-hero h2.stacked').html(slide.subhead).fadeOut(1).fadeIn(500);
	jQuery('.index-cta a.button2').html(slide.button_text).attr('href','rescue-solutions/' + slide.slug + '/').fadeOut(1).fadeIn(500);
	jQuery('.index-page-hero').css({
		"background-image":"url(" + slide.img + ")",
		"background-repeat":"no-repeat",
		"background-position":"center 300px",
		"background-size":"1063px auto",
		"opacity":"1"
	}).animate({backgroundPosition: 'center bottom', opacity:1}, 200, 'easeInExpo');
	// Add class to "Selected" button.
	jQuery('#index-hero-ul li').removeClass('selected');
	jQuery('#index-hero-ul li#' + k).addClass('selected');
	put_button_up();
	return false;
}

function put_button_up() {
	// We need to move the button to make it clickable...
	padding_num = 10;
	jQuery('.index-cta').eq(0).insertBefore('.index-page-hero');
	pos = jQuery('.index-page-hero h2.stacked').eq(0).offset();
	pos.height = jQuery('.index-page-hero h2.stacked').eq(0).height();
	jQuery(jQuery('.index-cta').eq(0)).css({
		'position':'absolute',
		'top':(pos.top + pos.height + padding_num) + 'px',
		'margin-left':'auto',
		'margin-right':'auto',
		'left':'0',
		'right':'0',
		'text-align':'center'
	}).fadeIn();
	return false;
}

(function($) {
	$.each($('.product-rollover'), function(){
		$(this)
			.on('mouseover',function(){
				$(this).children().eq(1).removeClass('hide').addClass('hovered_product');
			})
			.on('mouseout',function(){
				$(this).children().eq(1).addClass('hide').removeClass('hovered_product');
			});
	});
})(jQuery);


// Show correct NSN number
(function($) {
	console.log('yep yep');
	var sT = setTimeout(function(){
		$('#pa_style').on('change',function(){
			console.log($(this));
			//console.log('changed to %s', $(this).selectedIndex);
		});
	},3000);
	
	
})(jQuery);
