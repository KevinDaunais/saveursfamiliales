/**
*	Generates a placeholder with the video thumbnail and a button to activate the embed on click
*
*	@data data-embed-id - exemple: youtube video id
*	@data data-embed-host - exemple: "youtube"
*	@aria aria-placeholder - exemple: "voir la video"
*/

import Partools from './partools';

const state = {
	elements: []
}

on_load();

function on_load(){
	state.elements = Array.from( document.querySelectorAll('[data-embed-id][data-embed-host]') );
	init();
}

function init(){
	generate_content();
}

function generate_content(){
	state.elements.forEach(element => {
		const id = element.getAttribute('data-embed-id');
		const host = element.getAttribute('data-embed-host');
		const btn_text = element.getAttribute('aria-placeholder');

		const placeholder = get_placeholder(id, host, btn_text);

		element.appendChild(placeholder.body);

		placeholder.button.addEventListener('click', (e) => {
			load_embed(element, id, host);
		})
	})
}

function load_embed(t, id, host){
	const content = get_iframe(id, host);
	t.innerHTML = '';
	t.appendChild(content);
}

function get_placeholder(id, host, text){
	const body = document.createElement('DIV');
	body.classList.add('lazy-embed-placeholder');
	body.style.backgroundImage = `url('${get_thumbnail(id, host)}')`;

	const wrapper = document.createElement('DIV');
	wrapper.classList.add('lazy-embed-wrapper');

	let span;
	if( text ){
		span = document.createElement('SPAN');
		span.innerHTML = text;
	}

	const button = document.createElement('BUTTON');
	button.classList.add('lazy-embed-button');

	body.appendChild(wrapper);
	wrapper.appendChild(button);
	if( text ) button.appendChild( span );
	button.appendChild( Partools.get_icon('fa-play') );

	return { body, button };
}

function get_iframe(id, host){
	const body = document.createElement('IFRAME');
	body.setAttribute( 'src', get_src(id, host) );
	body.setAttribute( 'frameborder', 0 );
	body.setAttribute( 'allowfullscreen', '' );
	body.setAttribute( 'autoplay', '' );
	body.setAttribute( 'mute', 1 );

	return body;
}

function get_src(id, host){
	switch (host) {

		case 'youtube':
		default:
			return `https://www.youtube.com/embed/${id}?rel=0&showinfo=0&autoplay=1&mute=1`;

	}
}

function get_thumbnail(id, host){
	switch (host) {

		case 'youtube':
		default:
			return `https://img.youtube.com/vi/${id}/sddefault.jpg`;

	}
}
