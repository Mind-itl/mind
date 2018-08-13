(function(list) {
	'use strict';
	function uniq(arr) {
		return $.grep(arr, function(v, k){
	    	return $.inArray(v ,arr) === k;
		});
	}

	let kinds = uniq(list.map(a => a.kind));
	kinds.forEach(el => {
		$("#award_kind").append("<option>" + el +"</option>");
	});

	let causes = {};
	list.forEach(el => {
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

})(causes_list);