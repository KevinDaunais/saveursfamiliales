window.addEventListener('load', () => fixBgCover());

function fixBgCover(scope = document){
	let ua = window.navigator.userAgent;
	let old_ie = ua.indexOf('MSIE ');
	let new_ie = ua.indexOf('Trident/');
	let ms_ie = (old_ie > -1) || (new_ie > -1);

	if (ms_ie){
		const aBgSets = scope.querySelectorAll('[data-bgset]');

		for(let i = 0; i < aBgSets.length; i++){
			const data_ie = aBgSets[i].getAttribute('data-ie');
			aBgSets[i].style.backgroundImage = `url('${data_ie}')`;
			aBgSets[i].classList.add('ie--loaded');
		}
	}
}

window.fixBgCover = fixBgCover;
