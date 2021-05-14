/**
*	Scroll [STATE_NAME] class on scroll past destination html data attribute listener
*
*	@data data-scroll-item="something" - item to set state class on
*	@data data-scroll-dest="something" - target to check overlap and activate state class
*	@data data-scroll-height="140" - height to activate class on itself
*/


const STATE_NAME = 'scrolled';

const state = {
	elements: [],
}

onLoad();
document.addEventListener('scroll', on_scroll);

function onLoad(e){
	init();
}

function init(){
	const items = Array.from( document.querySelectorAll('[data-scroll-item], [data-scroll-height]') );

	state.elements = items.map(item => {

		if( item.hasAttribute('data-scroll-item') ){
			const data = item.getAttribute('data-scroll-item');
			const dest = document.querySelector(`[data-scroll-dest="${data}"]`);

			return { item, dest };

		} else {
			const data = item.getAttribute('data-scroll-height');

			return {
				item,
				height: parseInt(data)
			};

		}

	});

	on_scroll();
}

function on_scroll(e){
	state.elements.forEach(element => {
		if(element.dest){
			scroll_compare(element);
		}
		else if(element.height){
			scroll_height(element);
		}

	})
}

function scroll_compare(element){
	const itemRect = element.item.getBoundingClientRect();
	const destRect = element.dest.getBoundingClientRect();

	const a = itemRect.bottom;
	const b = destRect.top;

	element.item.classList[ (a > b) ? 'add' : 'remove' ](STATE_NAME);
}

function scroll_height(element){
	const isScrolled = window.scrollY > element.height;
	element.item.classList[ (isScrolled) ? 'add' : 'remove' ](STATE_NAME);
}
