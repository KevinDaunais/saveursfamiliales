/**
*	Send data-tracker=[{cat}] category on click to google analytics
*
*	@data data-tracker="category" - category to set on click event
*	@default data-tracker = [{DEFAULT_CAT}]
*/

const DEFAULT_CAT = 'social';

const state = {
	nodes: [],
}

init();

function init(){
	state.nodes = Array.from( document.querySelectorAll(`[data-tracker]`) );

	state.nodes.forEach( node => node.addEventListener('click', track) );
}

function track(e){
	let cat = this.getAttribute('data-tracker');
	if( cat === '' ) cat = DEFAULT_CAT;

	const args = {
		eventCategory: cat,
		eventAction: 'Open',
		eventLabel: ''
	}

	if( typeof __gaTracker != 'undefined' ) __gaTracker('send', 'event', args);

	if( typeof ga != 'undefined' ) ga('send', 'event', args);
}
