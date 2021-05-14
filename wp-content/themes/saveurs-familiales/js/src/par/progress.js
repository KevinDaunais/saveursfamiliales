/**
*	Generates a progress bar inside targeted element
*
*	@data [data-progress-bar] - generates a bar that scales horizontaly to indicate scroll progression
*
*	@exemple <div data-progress-bar></div>
*/

const state = {
	bars: []
}

on_load();
window.addEventListener('scroll', on_scroll);

function on_load(){
	init();
}

function init(){
	state.bars = Array.from( document.querySelectorAll('[data-progress-bar]') );

	state.bars.forEach(bar => {
		const v_bar = document.createElement('DIV');
		v_bar.style.width = '100%';
		v_bar.style.transform = 'translateX(-100%)';
		v_bar.classList.add('value-bar');

		bar.appendChild(v_bar);
	})

	on_scroll();
}

function on_scroll(){
	const progress = Math.min( Math.max( window.scrollY / (document.body.offsetHeight - window.innerHeight) , 0.01), 1 ) * 100;

	state.bars.forEach(bar => {
		const v_bar = bar.querySelector('.value-bar');

		v_bar.style.transform = `translateX(${progress - 100}%)`;
	});
}
