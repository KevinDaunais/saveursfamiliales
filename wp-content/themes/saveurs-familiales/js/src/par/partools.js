/**
*	List of custom reusable functions
*/

class Partools {

	/**
	*	Generates an svg icon
	*
	*	@param icon - id of svg symbol
	*	@return DOM - html element
	*/
	static get_icon = (icon = 'fa-cloud-download') => {
		const temp = document.createElement('DIV');
		temp.innerHTML = `<div class="icon"><svg class="fa ${icon}"><use xlink:href="#${icon}"></use></svg></div>`;

		return temp.firstChild;
	};

	/**
	*	EVENT REDIRECTION
	*
	*	@param eventType - string - type of eventListener
	*	@param element - DOM - element that triggers the event
	*	@param target - DOM - element that receives the event
	*/

	static redirectEvent(eventType, fromElement, toElement){
		fromElement.addEventListener(eventType, function (event) {
			toElement.dispatchEvent(new event.constructor(event.type, event));
			// event.preventDefault();
			// event.stopPropagation();
		});
	}


	/**
	*	INTERNET EXPLORER DETECTION
	*
	*	@param string - browser name
	*	@return bool - true if browser === IE
	*/

	static isBrowser(browser = 'IE', OS){
		browser = browser.toUpperCase();

		const ua = window.navigator.userAgent;
		let rB = false;
		let rO = false;

		switch(browser){

			case 'CHROME':
				if(ua.includes('Chrome/')) rB = true;
				break;

			case 'FIREFOX':
				if(ua.includes('Firefox/')) rB = true;
				break;

			case 'EDGE':
				if(ua.includes('Edge/')) rB = true;
				break;

			case 'IE':
			case 'IE11':
			case 'EXPLORER':
			default:
				if(ua.includes('MSIE ')) rB = true;
				if(ua.includes('Trident/')) rB = true;
				break;

		}

		if(OS){
			OS = OS.toUpperCase();

			switch(OS){

				case 'MS':
				case 'WINDOW':
				case 'WINDOWS':
					if(ua.includes('Windows')) rO = true;
					break;

				case 'Android':
					console.error('Unverified : Please validate this condition');
					if(ua.includes('iPad;')) rO = true;
					break;

				case 'IPAD':
					console.error('Unverified : Please validate this condition');
					if(ua.includes('iPad;')) rO = true;
					break;

				case 'IPHONE':
					console.error('Unverified : Please validate this condition');
					if(ua.includes('iPhone;')) rO = true;
					break;

				case 'LINUX':
					console.error('Unverified : Please validate this condition');
					if(ua.includes('Linux')) rO = true;
					break;

				case 'OSX':
				case 'MAC':
				default:
					console.error('Unverified : Please validate this condition');
					if(ua.includes('Macintosh;')) rO = true;
					break;

			}

			return { browser: rB, system: rO };
		}

		return rB;
	}

}

export default Partools
