/**
*	Activate data-anim=[{anim}] class on scroll past element's top position
*
*	@data data-anim="anim-class" - item to set state class on and use as breakpoint
*/

const HIDE_CLASS = 'hide';

const state = {
	elements: [],
}

on_load();
window.addEventListener('scroll', on_scroll);

function on_load(e){
	init();
	on_scroll();
}

function on_scroll(e){
	check_anim();

	if(state.elements.length === 0) window.removeEventListener('scroll', on_scroll);
}

function init(){
	const elements = document.querySelectorAll('[data-anim]');
	state.elements = Array.from( elements );

	hide_elements();
}

function hide_elements(){
	state.elements.forEach(element => {
		element.classList.add(HIDE_CLASS);
	});
}

function check_anim(){
	state.elements.forEach(element => {
		const passedElement = element.getBoundingClientRect().top - window.innerHeight <= 0;

		if(passedElement) do_anim(element);
	});
}

function do_anim(element){
	const animClass = element.getAttribute('data-anim');
	element.classList.add(animClass);
	element.classList.remove(HIDE_CLASS);

	state.elements = state.elements.filter(el => el != element);
}
