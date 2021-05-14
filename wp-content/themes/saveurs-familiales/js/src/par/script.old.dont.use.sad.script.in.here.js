(function($){
	'use strict';

	var animationObject;

	function PARanimation() {

		if( $.type(animationObject) === "undefined" ){
			animationObject = $('[paranim-type]');
		}

		animationObject.each(function (index, element) {
			var $currentElement = $(element),
				animationType = $currentElement.attr('paranim-type');

			if (PARonscreen($currentElement)) {
				$currentElement.addClass('animated ' + animationType);
			}
		});
	}

	// takes jQuery(element) a.k.a. $('element')
	function PARonscreen(element) {
		// window bottom edge
		var windowBottomEdge = $(window).scrollTop() + $(window).height();

		// element top edge
		var elementTopEdge = element.offset().top;
		var offset = 200;

		// if element is between window's top and bottom edges
		return elementTopEdge + offset <= windowBottomEdge;
	}

	$(window).load(function () {
		PARanimation();
	});

	$(window).on('scroll', function (e) {
		PARanimation();
	});

}(jQuery));

(function($){
	'use strict';

	$('#wpadminbar').addClass('fixed');

	if ( $.fn.jsSocials ) {
		par_socials();
	}

	// Accordion
	$('.acc .title').click(function () {

		var parent = $(this).parent();

		if (parent.hasClass('active')) {
			parent.removeClass('active');
			$('.acc .contents').slideUp(300);
		} else {

			if ($('.acc').not($(this.parent)).hasClass('active')) {
				$('.acc').removeClass('active');
				$('.acc .contents').slideUp(300);
			}

			parent.addClass('active');
			parent.find('.contents').slideToggle(300);
		}
		return false;
	});

}(jQuery));

function par_socials(){

	$ = jQuery;

	$(".share-list").each(function() {
		$(this).jsSocials({
			shareIn: "popup",
			text : $(this).data('title'),
			url : $(this).data('url'),
			showCount: false,
			showLabel: false,
			shares: [
				{ share: "facebook" },
				{ share: "twitter" },
				{ share: "googleplus" },
				{ share: "email" }
			]
		});
	});
}
