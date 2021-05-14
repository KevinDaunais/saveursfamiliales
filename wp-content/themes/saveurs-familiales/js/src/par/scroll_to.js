const state = {
	elements: []
}

on_load();

function on_load(){
	state.elements = Array.from( document.querySelectorAll('[data-scroll-down]') );
	init();
}

function init(){
	state.elements.forEach(element => element.addEventListener('click', (e) => {
		e.preventDefault();
		scroll_down();
	}));
}

function scroll_down(){

	window.scrollTo({
		top: window.innerHeight * 0.66,
		left: 0,
		behavior: 'smooth'
	});
}
