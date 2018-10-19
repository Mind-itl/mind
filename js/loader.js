require("../loader.css");

const $ = require("jquery");

$(window).load(function () {
	$('.main_container').delay(400).fadeIn();
	$('.loader').delay(100).fadeOut();
});
