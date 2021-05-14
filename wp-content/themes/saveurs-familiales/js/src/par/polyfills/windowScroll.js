if(window.scrollY == undefined){
	setValues();
	window.addEventListener('scroll', setValues);

	function setValues(){
		window.scrollY = window.pageYOffset;
		window.scrollX = window.pageXOffset;
	}
}
