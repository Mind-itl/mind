'use strict';

import $ from "jquery";
import "../main.js";

$("#add-student-button").click(function() {
	let val = $("#student_select").val();
	if (val === "")
		return;
	
	let logins = $("#selector-list").val();

	$("#selector-list").val(logins + val +'\n').show();

	console.log("asd");
});
