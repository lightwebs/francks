(function ($, root, undefined) {	
$(function () {	
	'use strict';
		
// ------------------- Menu
$(".main-header ul").addClass('flex vert-center');
$(".main-header li:not(.expander)").addClass('displaythis');
$(".sub-header ul").addClass('flex vert-center');	
$(".menu-huvudmeny ul li a").addClass('flex vert-center');
$(".expander li.primary-bg a").addClass('flex vert-center');
$(".expander .sub-menu").addClass('exsub');
$(".expander > .sub-menu:first-of-type").addClass('mainexsub');
$('.main-header li:not(.expander) > .sub-menu:not(.exsub) > li:nth-child(3n+1)').addClass('firstcol');
	
$(".nav ul li.menu-item-has-children").append("<i class='expand-ul icon-arrow-thin-down'></i>");
$(".nav > ul >li.menu-item-has-children:not(.expander)").append("<svg version='1.1' id='Lager_1' class='bubblepoint displaythis' viewBox='0 0 20.6 19' xml:space='preserve'><style type='text/css'>.st0{fill:#FFFFFF;}</style><path class='st0' d='M16,0C16,14.3,0,19,0,19h19.8C22.8,9.9,16.7,0.1,16,0z'/></svg>");
$(".nav > ul >li.menu-item-has-children.expander").append("<svg version='1.1' id='Lager_1' class='bubblepoint' viewBox='0 0 20.6 19' xml:space='preserve'><style type='text/css'>.st0{fill:#FFFFFF;}</style><path class='st0' d='M16,0C16,14.3,0,19,0,19h19.8C22.8,9.9,16.7,0.1,16,0z'/></svg>");
	
$(".nav > ul >li.expander").prepend("<span class='expanding'></span>");
	
// More menu
$(".expander").click(function(){
  $(this).toggleClass('is-active');
  $(this).find('.sub-menu').first().slideToggle(100);
  $(".expander .expanding").toggleClass('is-active');
});
	
// Mobile sidebar
$(".trigger").click(function(){
  $(this).closest('.sidebar').toggleClass('is-active');
});
	
// Mobile menu
$(".hamburger-outer").click(function(){
    $(".nav").toggleClass('active');
    $(".c-hamburger--htx").toggleClass("is-active");
});
$(".expand-ul").click(function(){
  $(this).closest('.menu-item-has-children').find('.sub-menu').first().slideToggle(100);
  $(this).closest('.menu-item-has-children').toggleClass('activeparent');
  $(this).toggleClass('icon-arrow-thin-up');
  $(this).toggleClass('icon-arrow-thin-down');
});
	
/* Insert topmenu into main menu */
function mediaSize() { 
	if (window.matchMedia('(max-width: 1000px)').matches) {  
		$( ".expander > .sub-menu.mainexsub" ).appendTo( $( ".main-header #menu-huvudmeny" ) );
    }
	else {
		$( ".main-header .sub-menu.mainexsub" ).appendTo( $( ".expander" ) );
	}
};
mediaSize(); window.addEventListener('resize', mediaSize, false); 

// ----------------- Header on scroll
$(window).on('scroll', function() {
    var scrollTop = $(this).scrollTop();
    if (scrollTop > 0) {
        $('.header').addClass("header-scroll");
    }
    else {
        $('.header').removeClass("header-scroll");
    }
});

// -------------- Tiny Slider
// See demos & options at ganlanyuan.github.io/tiny-slider/#options

[].forEach.call(document.querySelectorAll('.slideshow'), function (variabel) {
    tns({
		container: variabel,
		mode: 'carousel',
		mouseDrag: true,
		loop: true,
		nav: true,
		navAsThumbnails: false,
		controls: false,
		autoplay: true,
		autoplayButtonOutput: false,
		navAsThumbnails: true,
		lazyload: true,
		arrowKeys: true,
		axis: 'horizontal',
		gutter: 20,
		navPosition: 'bottom',
		responsive: {
			1500: { fixedWidth: 400, },
			1000: { fixedWidth: 300, items: 10, },
			800: { items: 3, edgePadding: 0,},
			630: { items: 2, edgePadding: 80,},
			0: { fixedWidth: false, items: 1, edgePadding: 40,},
		}
    });
});
[].forEach.call(document.querySelectorAll('.tabslide'), function (variabel) {
    tns({
		container: variabel,
		mode: 'carousel',
		mouseDrag: true,
		loop: true,
		nav: true,
		navAsThumbnails: false,
		controls: false,
		autoplay: true,
		autoplayButtonOutput: false,
		autoplayHoverPause: true,
		lazyload: true,
		arrowKeys: true,
		axis: 'horizontal',
		gutter: 20,
		navPosition: 'bottom',
		responsive: {
			1280: {items:4},
			1000: { items: 3, },
			600: { items: 2,},
			0: { items: 1, autoHeight: true},
		}
    });
});
[].forEach.call(document.querySelectorAll('.bildspel'), function (variable) {
    tns({
		container: variable,
		mode: 'gallery',
		mouseDrag: true,
		loop: true,
		nav: false,
		edgePadding: 0,
		controls: false,
		autoplay: true,
		autoplayButtonOutput: false,
		lazyload: true,
		axis: 'horizontal',
		gutter: 0,
		navPosition: 'bottom',
		responsive: {
			0: { items: 1 },
		}
    });
});
	
// --------------- Filter function
$(".filterblock").prepend("<div class='flex horiz-center col-f-1'></div>");
$(".filters").appendTo( $( ".filterblock .horiz-center" ) );
	
$(".filters").first().addClass('thecurrent');
var curr = $(".thecurrent").attr('data-filter');
if ($('#mapfilter').length) {
	$(".filteritems").show(500);
}else{
$(".filteritems").not('.' + curr).hide(500);
}
	
$('.filters').click(function() {
	$(this).siblings().removeClass('thecurrent');
	$(this).addClass('thecurrent');
	var value = $(this).attr('data-filter');
	$(".filteritems").not('.' + value).hide(500);
	$('.filteritems').filter('.' + value).show(500);
});
$('#map g').click(function() {
	$(this).siblings().removeClass('thecurrent');
	$(this).addClass('thecurrent');
	var value = $(this).attr('data-filter');
	$(".filteritems").not('.' + value).hide(500);
	$('.filteritems').filter('.' + value).show(500);
});

// --------------- Tabs
$(".tabs .tab-item").each(function(i,x) {
    $(this).attr("data-tab","tab-" + i);
});
$(".tab-content").each(function(i,x) {
    $(this).attr("id","tab-" + i);
});
$('.tabs .tab-item').click(function() {
    var tab_id = $(this).attr('data-tab');
    $('.tabs .tab-item').removeClass('current');
    $('.tab-content').removeClass('current');
    $(this).addClass('current');
    $("#" + tab_id).addClass('current');
});
$(".tabs .tab-item:first-child").addClass("current");
$(".tab-content:first-child").addClass("current");

// -------------- Form label animation 
$('.wpcf7 input').focus(function(){
  $(this).parents('.input-outer div').addClass('focused');
});
$('.wpcf7 input').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
    $(this).removeClass('filled');
    $(this).parents('.input-outer div').removeClass('focused');  
  } else {
    $(this).addClass('filled');
  }
});
$('.wpcf7 textarea').focus(function(){
  $(this).parents('.input-outer div').addClass('focused');
});
$('.wpcf7 textarea').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
    $(this).removeClass('filled');
    $(this).parents('.input-outer div').removeClass('focused');  
  } else {
    $(this).addClass('filled');
  }
});
			
// --------------- Row reverse on mobile
(function($) {
function mediaSize() { 
	if (window.matchMedia('(max-width: 800px)').matches) {  
        $('.half .forcolrev').each(function() {
			var conimg = $(this).find('div.content .bg-img');
			if ($(conimg).parent('.content').is(':last-child')) {
				$(this).closest('.forcolrev').addClass("col-rev");
			} 
			else{
				$(this).closest('.forcolrev').removeClass("col-rev");
			}
        });
    }
	else{
		$('.half .forcolrev').each(function() {
			$(this).removeClass("col-rev");
        });
	}
};
mediaSize(); window.addEventListener('resize', mediaSize, false);  
})(jQuery);	
		

});	
})(jQuery, this);