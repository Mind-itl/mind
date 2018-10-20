const $ = require("jquery");

$(window).on('load', function () {
	$('.main_container').delay(400).fadeIn();
	$('.loader').delay(100).fadeOut();
});

