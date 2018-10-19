'use strict';

const $ = require("jquery");

function uniq(arr) {
	return arr.filter(function(elem, pos) {
		return arr.indexOf(elem) == pos;
	})
}

document.addEventListener("DOMContentLoaded", function() {
	let kinds = uniq(window.causes_list.map(a => a.kind));
	kinds.forEach(el => {
		$("#award_kind").append("<option>" + el +"</option>");
	});

	let causes = {};
	window.causes_list.forEach(el => {
		let kind = el['kind'];
		causes[kind] = causes[kind] || [];
		causes[kind].push({
			code: el['code'],
			title: el['title']
		});
	});

	$("#award_kind").change(() => {
		let kind = $("#award_kind").val();

		$("#award_cause").children().remove();
		causes[kind].forEach(el => {
			let title = el['title'];
			let code = el['code'];

			$("#award_cause").append(
				`<option value="${code}">
					${title}
				</option>`
			);
		});
	}).change();
});
