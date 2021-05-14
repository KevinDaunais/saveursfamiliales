/**
*	Smooth scroll to anchor on anchor click
*/

let OFFSET = -70; //offset end scroll position

const state = {
	header: undefined,
	anchors: [],
}

window.addEventListener('load', on_load);

function on_load(e){
	state.header = document.querySelector('header.header');

	if(state.header)
		OFFSET = -state.header.getBoundingClientRect().height;


	if(window.location.hash){
		const hash = window.location.hash;
		window.location.hash = ''; //prevent jump

		const element = document.querySelector(hash);
		if(element) scroll_to(e, hash, element);
	}

	state.anchors = Array.from( document.querySelectorAll(`[href*="#"]`) );

	init();
}

function init(){
	state.anchors.forEach(link => {
		const hash = link.hash;

		//Filter out unwanted hashes
		if(hash === '') return;
		if(hash.startsWith('#url=')) return;
		if(!hash.startsWith('#')) return;
		if(!link.href.includes(window.location.origin)) return;

		const element = document.querySelector(hash);
		if(element) link.addEventListener('click', (e) => scroll_to(e, hash, element));
	});
}

function scroll_to(e, hash, target){
	e.preventDefault();

	window.history.pushState(null, null, hash);

	window.scroll({
		top: target.offsetTop + OFFSET,
		left: 0,
		behavior: 'smooth'
	});
}
