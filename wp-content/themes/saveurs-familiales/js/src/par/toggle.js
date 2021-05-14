/**
*	Toggle [{ACTIVE_NAME}] class on click html data attribute listener
*	- also adds a bodyclass
*
*	@data data-toggle="something" - click event to toggle
*	@data data-open="something" - click event to open
*	@data data-close="something" - click event to close
*	@data data-listener="something" - item to receive click event and get active className
*	@data data-listener-class="className" - active className of listener item
*/

//this class name will be formated like this: {ATTR_NAME}--{ACTIVE_NAME}
const ACTIVE_NAME = 'active';

const state = {
	toggleButtons: [],
	closeButtons: [],
	openButtons: [],
}

on_load();

function on_load(e){
	init();
}

function init(){
	state.toggleButtons = Array.from( document.querySelectorAll('[data-toggle]') );
	state.closeButtons = Array.from( document.querySelectorAll('[data-close]') );
	state.openButtons = Array.from( document.querySelectorAll('[data-open]') );

	state.toggleButtons.forEach( button => button.addEventListener( 'click', function(e){ on_click(this, 'toggle') } ) );
	state.closeButtons.forEach( button => button.addEventListener( 'click', function(e){ on_click(this, 'close') } ) );
	state.openButtons.forEach( button => button.addEventListener( 'click', function(e){ on_click(this, 'open') } ) );
}

function on_click(button, attr = 'toggle'){
	const data = button.getAttribute(`data-${attr}`);
	const class_name = `${data}--${ACTIVE_NAME}`;
	const active =  attr === 'open' ? false :
						attr === 'close' ? true :
							button.className.includes(class_name);

	do_toggle(data, active);
}

function do_toggle(data, isActive){
	const class_name = `${data}--${ACTIVE_NAME}`;

	// only get the listener and toggle of the click action
	// because when you close/open you want the action happens on the toggle
	let others = [];
	others = [...others, ...Array.from( document.querySelectorAll(`[data-listener="${data}"]`) ) ];
	others = [...others, ...Array.from( document.querySelectorAll(`[data-toggle="${data}"]`) ) ];

	others.forEach( other => {
		let attrClass = other.getAttribute(`data-listener-class`);
		let action = isActive ? 'remove' : 'add';

		if( attrClass )
			attrClass = `${attrClass}--${ACTIVE_NAME}`;

		other.classList[action](attrClass || class_name);
	} );

	document.body.classList[isActive ? 'remove' : 'add'](class_name);
}
