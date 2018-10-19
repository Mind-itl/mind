'use strict';

require("../main.js");
const $ = require("jquery");

function uniq(arr) {
	arr.filter(function(elem, pos) {
		return arr.indexOf(elem) == pos;
	})
}

let kinds = uniq(causes_list.map(a => a.kind));
kinds.forEach(el => {
	$("#award_kind").append("<option>" + el +"</option>");
});

let causes = {};
causes_list.forEach(el => {
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
