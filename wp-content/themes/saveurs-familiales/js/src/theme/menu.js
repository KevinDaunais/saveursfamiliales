
const state = {
	submenu_wrappers: [],
}

on_load();

function on_load(){
	state.submenu_wrappers = Array.from( document.querySelectorAll('.menu > .menu-item-has-children') );

	state.mobile_wrappers = Array.from(document.querySelectorAll('.menu-mobile .menu-item-has-children') );

	format_submenu_wrappers();
}

function format_submenu_wrappers(){
	state.submenu_wrappers.forEach(item => {
        const text_element = item.querySelector('a');
        
        
		const temp = document.createElement('DIV');
		temp.innerHTML = '<svg class="fa fa-angle-down"><use xlink:href="#fa-angle-down"></use></svg>';
		const icon = temp.firstChild;
    
        text_element.insertBefore(icon, text_element.firstChild);
	});
	


	state.mobile_wrappers.forEach(item => {
        const text_element = item.querySelector('a');        

		const temp = document.createElement('DIV');
		temp.innerHTML = '<svg class="fa fa-angle-down"><use xlink:href="#fa-angle-down"></use></svg>';
		const icon = temp.firstChild;

		text_element.insertBefore(icon, text_element.firstChild);
	});
}
