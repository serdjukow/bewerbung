$(document).ready(function () {

	var image = document.querySelectorAll('.header__image ');
	new simpleParallax(image, {
		delay: 0.1,
		orientation: 'left',
		scale: 1.50,
		overflow: true
	 });

});

