/**
*	@data data-sticky="{selector}" - sticky element top when specified element overlaps the target element
*/


const STATE_NAME = 'sticky';

const state = {
	header: undefined,
	elements: [],
	doc_height: 0,
	admin_bar: undefined,
}

window.addEventListener('load', on_load);
document.addEventListener('scroll', on_scroll);
document.addEventListener('body', on_change); // ??

function on_load(e){
	init();
}

function on_change(e){
	init();
}

function on_scroll(e){

	state.elements.forEach(element => {
		if(element){
			scroll_compare(element);
		}
	})

}

function init(){
	state.window_height = window.innerHeight;
	state.header = document.querySelector('header.header');
	const items = Array.from( document.querySelectorAll('[data-sticky]') );

	state.elements = get_items(items);
	state.admin_bar = document.getElementById('wpadminbar');

	on_scroll();
}

function get_items(items){
	return items.map(item => {
		const parent = parentify(item);
		const data = item.getAttribute('data-sticky');
		const rect = item.getBoundingClientRect();

		return { item, data, rect, parent };
	});
}

function parentify(item){
	const parent = document.createElement('DIV');

	parent.classList.add('sticky-clone');
	parent.setAttribute('data-sticky-height', item.offsetHeight);

	item.parentNode.replaceChild(parent, item);
	parent.appendChild(item);

	return parent;
}

function scroll_compare(element){
	const rect = element.parent.getBoundingClientRect();
	const admin_height = state.admin_bar ? state.admin_bar.offsetHeight : 0;
	const top_pos  = document.querySelector(element.data).offsetHeight + admin_height;

	const a = 0;
	const b = rect.top - state.header.offsetHeight - admin_height;

	element.item.classList[ (a > b) ? 'add' : 'remove' ](STATE_NAME);

	if( a > b ){
		const parent_height = element.parent.getAttribute('data-sticky-height');
		element.item.classList.add('is-sticky');
		element.item.style.position = 'fixed';
		element.item.style.top = `${top_pos}px`;
		element.parent.style.height = `${parent_height}px`;

	} else {
		element.item.classList.remove('is-sticky');
		element.item.setAttribute('style', '');
		element.parent.setAttribute('style', '');

	}

}
