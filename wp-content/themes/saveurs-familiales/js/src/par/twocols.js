const $ = jQuery;

const SLIDER_CONFIG = {
	dots: true,
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: true,
	prevArrow: '<button class="slick-arrow prev"><svg class="fa fa-angle-left"><use xlink:href="#fa-angle-left"></use></svg></button>',
	nextArrow: '<button class="slick-arrow next"><svg class="fa fa-angle-right"><use xlink:href="#fa-angle-right"></use></svg></button>',
	fade: false,
	autoplay: false,
	autoplaySpeed: 5000
}

const state = {
	sliders: [],
}

on_load();

function on_load(){
	if( $ == undefined ) return;
	if( $.fn.slick == undefined ) return;

	init();
}

function init(){
    state.cols = Array.from( document.querySelectorAll('.col__slider') );
    state.sliders = Array.from( document.querySelectorAll('.block__slides') );

    slick_galleries();
}

function slick_galleries(){
	state.cols.forEach(slider => {
		$(slider).slick(SLIDER_CONFIG)
    });
    
    state.sliders.forEach(slider => {
		$(slider).slick(SLIDER_CONFIG)
    });
}
