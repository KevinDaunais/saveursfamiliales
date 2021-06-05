(function($){

	$('.ginput_container_select').append('<svg class="fa fa-angle-down"><use xlink:href="#fa-angle-down"></use></svg>');

	var header_height = $('.header').height();

	$('.page-wrapper .main').css('padding-top', header_height + 'px');

	$('a[href*="#"]:not([href="#"])').on({
		click: function(e) {
			var target = $(this.hash);
			$('html,body').stop().animate({
				scrollTop: target.offset().top - header_height
			}, 'linear');
		}
	});

	if (location.hash) {
		var id = $(location.hash);
	}

	$(window).on({
		load: function(e) {
			if (location.hash) {
				$('html,body').animate({ scrollTop: id.offset().top - header_height }, 'linear')
			};
		}
	});

	$('.search__toggle').on({
		click: function(e) {
			$('.search__overlay').toggleClass("active");
			$(".search__overlay .search-field").focus();
			return false;
		}
	});

	$('.testimonials__slider').slick({
		dots: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: false,
		autoplay: true,
		autoplaySpeed: 4000

	});

	$('.search__overlay .close').on({
		click: function(e) {
			$('.search__overlay').toggleClass("active");
			$(".search__overlay .search-field").focus();
			return false;
		}
	});


	$('.mobile-menu .menu-item-has-children > a').on({
		click: function(e) {
			$(this).toggleClass('menu-active');
			$(this).closest('li').toggleClass('menu-active');
			//$(this).closest('li').children('.sub-menu').slideToggle(300);
			$(this).closest('li').children('.sub-menu').toggleClass('sub-active');

			return false;
		}
	});

	$('.mobile-menu .menu-item-has-children > a').each(function () {

		$(this).append('<svg class="fa fa-angle-down"><use xlink:href="#fa-angle-down"></use></svg>');
	});

	if ($.fn.lightGallery) {

		$(".gallery__images").lightGallery({
			selector: '.gallery__image .img',
			thumbnail: true,
			exThumbImage: 'data-exthumbimage',
			enableDrag: false
		});
	}


	$('.acc .title').on({
		click: function(e) {
			var parent = $(this).parent();

			$(".slick-slider").slick("refresh");


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
		}
	});

	var par_flexs_margin = Array.from(document.querySelectorAll("[data-custom_margin]") ),
		par_flexs_padding = Array.from(document.querySelectorAll("[data-custom_padding]") );

	function check_custom_spacing(){

		if ( $(window).width() < 767 ){

			par_flexs_margin.forEach(item => {

				item.style.removeProperty('margin-top');
				item.style.removeProperty('margin-bottom');
			});

			par_flexs_padding.forEach(item => {

				item.style.removeProperty('padding-top');
				item.style.removeProperty('padding-bottom');
			});

		}else{

			par_flexs_margin.forEach(item => {

				let dim = item.getAttribute('data-custom_margin').split("|");

				item.style.setProperty('margin-top', dim[0]);
				item.style.setProperty('margin-bottom', dim[1]);
			});

			par_flexs_padding.forEach(item => {

				let dim = item.getAttribute('data-custom_padding').split("|");

				item.style.setProperty('padding-top', dim[0]);
				item.style.setProperty('padding-bottom', dim[1]);
			});
		}
	};

	check_custom_spacing();
	$(window).resize( function(){
		check_custom_spacing();
	});

})(jQuery);