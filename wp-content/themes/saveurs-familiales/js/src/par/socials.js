/**
*	Generates js socials on element of id
*
*	@data [data-socials] - item to insert js socials in
*
*	@exemple <div data-socials></div>
*/

import Partools from './partools';
const $ = jQuery;

onLoad();

function onLoad(e){
	init();
}

function init(){
	if ( $.fn.jsSocials == undefined ) return;

	const elements = Array.from( document.querySelectorAll('[data-socials]') );

	elements.forEach(element => {
		const $element = $(element);
		$element.jsSocials({
			shareIn: "popup",
			text : $element.data('title'),
			url : $element.data('url'),
			showCount: false,
			showLabel: false,
			shares: [
				{ share: "facebook", logo: "data:image/svg+xml;base64," },
				{ share: "twitter",  logo: "data:image/svg+xml;base64," },
				{ share: "linkedin", logo: "data:image/svg+xml;base64," },
				{ share: "email",    logo: "data:image/svg+xml;base64," }
			]
		});
    });


	elements.forEach(element => {
		const buttons = {
			'facebook'  : document.querySelector('.jssocials-share-facebook img'),
			'twitter'   : document.querySelector('.jssocials-share-twitter img'),
			'linkedin'  : document.querySelector('.jssocials-share-linkedin img'),
			'envelope-o': document.querySelector('.jssocials-share-email img'),
		};

		Object.entries( buttons ).map( ([slug, el]) => {
			if(el) el.parentNode.replaceChild( Partools.get_icon(`fa-${slug}`), el );
		} );

	});
}
