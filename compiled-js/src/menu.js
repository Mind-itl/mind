'use strict';

const $ = require("jquery");

$(".theme_link").prop("disabled", true);
$("#" + localStorage.getItem("theme")).prop("disabled", false);

if (!localStorage.getItem("theme")) localStorage.setItem("theme", "first_theme");

$("#choose_theme").mouseenter(function () {
	$("#choose_theme_vars").show();
});

$("#choose_theme").mouseleave(function () {
	$("#choose_theme_vars").hide();
});

$("#choose_theme_vars").children().click(function () {
	var css_files = {
		"Первая": "first_theme",
		"Вторая": "second_theme"
	};

	var title = $(this).html();
	title = css_files[title];
	localStorage.setItem("theme", title);

	$(".theme_link").prop("disabled", true);
	$("#" + localStorage.getItem("theme")).prop("disabled", false);
});

let coll = document.getElementsByClassName("menulink");
let arr = Array.from(coll);

arr.filter(a => a.href == document.location).forEach(a => a.classList.toggle("active"));