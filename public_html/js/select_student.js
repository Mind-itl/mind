(function(classes) {
	'use strict';

	const mess = 'Выберите класс';

	$("#class_select").append(`<option id="remove-cls">${mess}</option>`);

	for (let cls in classes) {
		$("#class_select").append(`<option>${cls}</option>`);
	}

	$("#class_select").change(() => {
		let val = $("#class_select").val();

		if (val==mess)
			return;

		$("#remove-cls").remove();

		$("#student_select").children().remove();

		classes[val].forEach((el) => {
			let login = el["LOGIN"];
			let name = ["FAMILY_NAME", "GIVEN_NAME", "FATHER_NAME"]
				.map((name) => el[name])
				.reduce((a, b) => `${a} ${b}`);

			$("#student_select").append(
				$('<option>', {
					value: login,
					html: name
				})
			);
		});
	}).change();

})(student_list);