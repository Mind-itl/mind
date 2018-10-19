'use strict';

require("../main.js");
const $ = require("jquery");

$("#add-student-button").click(function() {
	let val = $("#student_select").val();
	if (val === "")
		return;
	
	let logins = $("#selector-list").val();

	$("#selector-list").val(logins + val +'\n').show();

	console.log("asd");
});
