(function($) {

	window.addEventListener('load', onLoad);
	window.addEventListener('scroll', onScroll);

	// parSocials();

	function onLoad(e){
		parAdmin();
		PARanimation();
	}

	function onScroll(e){
		PARanimation();
	}

	function parAdmin(){
		$('#wpadminbar').addClass('fixed');
	}

	let animationObject;

	function PARanimation() {

		if( $.type(animationObject) === "undefined" ){
			animationObject = $('[paranim-type]');
		}

		animationObject.each(function (index, element) {
			var $currentElement = $(element),
				animationType = $currentElement.attr('paranim-type');

			if (PARonscreen($currentElement)) {
				$currentElement.addClass('animated ' + animationType);
			}
		});
	}

	function PARonscreen(element) {
		// window bottom edge
		var windowBottomEdge = $(window).scrollTop() + $(window).height();

		// element top edge
		var elementTopEdge = element.offset().top;
		var offset = 200;

		// if element is between window's top and bottom edges
		return elementTopEdge + offset <= windowBottomEdge;
	}

	// function parSocials(){
	// 	if ( $.fn.jsSocials == undefined ) return;
	//
	// 	$(".share-list").each(function() {
	// 		$(this).jsSocials({
	// 			shareIn: "popup",
	// 			text : $(this).data('title'),
	// 			url : $(this).data('url'),
	// 			showCount: false,
	// 			showLabel: false,
	// 			shares: [
	// 			{ share: "facebook", logo: "data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjE2IiBoZWlnaHQ9IjI4IiB2aWV3Qm94PSIwIDAgMTYgMjgiPjx0aXRsZT5mYWNlYm9vazwvdGl0bGU+PHBhdGggZD0iTTE0Ljk4NCAwLjE4N3Y0LjEyNWgtMi40NTNjLTEuOTIyIDAtMi4yODEgMC45MjItMi4yODEgMi4yNXYyLjk1M2g0LjU3OGwtMC42MDkgNC42MjVoLTMuOTY5djExLjg1OWgtNC43ODF2LTExLjg1OWgtMy45ODR2LTQuNjI1aDMuOTg0di0zLjQwNmMwLTMuOTUzIDIuNDIyLTYuMTA5IDUuOTUzLTYuMTA5IDEuNjg3IDAgMy4xNDEgMC4xMjUgMy41NjMgMC4xODd6Ij48L3BhdGg+PC9zdmc+" },
	// 			{ share: "twitter", logo: "data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjI2IiBoZWlnaHQ9IjI4IiB2aWV3Qm94PSIwIDAgMjYgMjgiPjx0aXRsZT50d2l0dGVyPC90aXRsZT48cGF0aCBkPSJNMjUuMzEyIDYuMzc1Yy0wLjY4OCAxLTEuNTQ3IDEuODkxLTIuNTMxIDIuNjA5IDAuMDE2IDAuMjE5IDAuMDE2IDAuNDM4IDAuMDE2IDAuNjU2IDAgNi42NzItNS4wNzggMTQuMzU5LTE0LjM1OSAxNC4zNTktMi44NTkgMC01LjUxNi0wLjgyOC03Ljc1LTIuMjY2IDAuNDA2IDAuMDQ3IDAuNzk3IDAuMDYzIDEuMjE5IDAuMDYzIDIuMzU5IDAgNC41MzEtMC43OTcgNi4yNjYtMi4xNTYtMi4yMTktMC4wNDctNC4wNzgtMS41LTQuNzE5LTMuNSAwLjMxMyAwLjA0NyAwLjYyNSAwLjA3OCAwLjk1MyAwLjA3OCAwLjQ1MyAwIDAuOTA2LTAuMDYzIDEuMzI4LTAuMTcyLTIuMzEyLTAuNDY5LTQuMDQ3LTIuNS00LjA0Ny00Ljk1M3YtMC4wNjNjMC42NzIgMC4zNzUgMS40NTMgMC42MDkgMi4yODEgMC42NDEtMS4zNTktMC45MDYtMi4yNS0yLjQ1My0yLjI1LTQuMjAzIDAtMC45MzggMC4yNS0xLjc5NyAwLjY4OC0yLjU0NyAyLjQ4NCAzLjA2MiA2LjIxOSA1LjA2MyAxMC40MDYgNS4yODEtMC4wNzgtMC4zNzUtMC4xMjUtMC43NjYtMC4xMjUtMS4xNTYgMC0yLjc4MSAyLjI1LTUuMDQ3IDUuMDQ3LTUuMDQ3IDEuNDUzIDAgMi43NjYgMC42MDkgMy42ODcgMS41OTQgMS4xNDEtMC4yMTkgMi4yMzQtMC42NDEgMy4yMDMtMS4yMTktMC4zNzUgMS4xNzItMS4xNzIgMi4xNTYtMi4yMTkgMi43ODEgMS4wMTYtMC4xMDkgMi0wLjM5MSAyLjkwNi0wLjc4MXoiPjwvcGF0aD48L3N2Zz4=" },
	// 			{ share: "linkedin", logo: "data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjI0IiBoZWlnaHQ9IjI4IiB2aWV3Qm94PSIwIDAgMjQgMjgiPjx0aXRsZT5saW5rZWRpbjwvdGl0bGU+PHBhdGggZD0iTTUuNDUzIDkuNzY2djE1LjQ4NGgtNS4xNTZ2LTE1LjQ4NGg1LjE1NnpNNS43ODEgNC45ODRjMC4wMTYgMS40ODQtMS4xMDkgMi42NzItMi45MDYgMi42NzJ2MGgtMC4wMzFjLTEuNzM0IDAtMi44NDQtMS4xODgtMi44NDQtMi42NzIgMC0xLjUxNiAxLjE1Ni0yLjY3MiAyLjkwNi0yLjY3MiAxLjc2NiAwIDIuODU5IDEuMTU2IDIuODc1IDIuNjcyek0yNCAxNi4zNzV2OC44NzVoLTUuMTQxdi04LjI4MWMwLTIuMDc4LTAuNzUtMy41LTIuNjA5LTMuNS0xLjQyMiAwLTIuMjY2IDAuOTUzLTIuNjQxIDEuODc1LTAuMTI1IDAuMzQ0LTAuMTcyIDAuNzk3LTAuMTcyIDEuMjY2djguNjQxaC01LjE0MWMwLjA2My0xNC4wMzEgMC0xNS40ODQgMC0xNS40ODRoNS4xNDF2Mi4yNWgtMC4wMzFjMC42NzItMS4wNjIgMS44OTEtMi42MDkgNC42NzItMi42MDkgMy4zOTEgMCA1LjkyMiAyLjIxOSA1LjkyMiA2Ljk2OXoiPjwvcGF0aD48L3N2Zz4=" },
	// 			{ share: "email", logo: "data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjI4IiBoZWlnaHQ9IjI4IiB2aWV3Qm94PSIwIDAgMjggMjgiPjx0aXRsZT5lbnZlbG9wZTwvdGl0bGU+PHBhdGggZD0iTTI4IDExLjA5NHYxMi40MDZjMCAxLjM3NS0xLjEyNSAyLjUtMi41IDIuNWgtMjNjLTEuMzc1IDAtMi41LTEuMTI1LTIuNS0yLjV2LTEyLjQwNmMwLjQ2OSAwLjUxNiAxIDAuOTY5IDEuNTc4IDEuMzU5IDIuNTk0IDEuNzY2IDUuMjE5IDMuNTMxIDcuNzY2IDUuMzkxIDEuMzEzIDAuOTY5IDIuOTM4IDIuMTU2IDQuNjQxIDIuMTU2aDAuMDMxYzEuNzAzIDAgMy4zMjgtMS4xODggNC42NDEtMi4xNTYgMi41NDctMS44NDQgNS4xNzItMy42MjUgNy43ODEtNS4zOTEgMC41NjItMC4zOTEgMS4wOTQtMC44NDQgMS41NjMtMS4zNTl6TTI4IDYuNWMwIDEuNzUtMS4yOTcgMy4zMjgtMi42NzIgNC4yODEtMi40MzggMS42ODctNC44OTEgMy4zNzUtNy4zMTMgNS4wNzgtMS4wMTYgMC43MDMtMi43MzQgMi4xNDEtNCAyLjE0MWgtMC4wMzFjLTEuMjY2IDAtMi45ODQtMS40MzctNC0yLjE0MS0yLjQyMi0xLjcwMy00Ljg3NS0zLjM5MS03LjI5Ny01LjA3OC0xLjEwOS0wLjc1LTIuNjg4LTIuNTE2LTIuNjg4LTMuOTM4IDAtMS41MzEgMC44MjgtMi44NDQgMi41LTIuODQ0aDIzYzEuMzU5IDAgMi41IDEuMTI1IDIuNSAyLjV6Ij48L3BhdGg+PC9zdmc+" }
	// 		]
	// 		});
	// 	});
	// }

}(jQuery));

has_scrollbar();
function has_scrollbar(){
	if(document.body.clientWidth < window.innerWidth) document.body.classList.add('has-scrollbar');
}
