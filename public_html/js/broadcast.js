window.onload = function() {
	'use strict';
	let students = (function(students){
		let arr = {};
		for (let cls in students) {
			students[cls].forEach(el=>{
				arr[el.LOGIN] = `${el.CLASS}, ${el.FAMILY_NAME} ${el.FATHER_NAME} ${el.GIVEN_NAME}`;
			});
		}

		return arr;
	})(list_of_students);

	console.log(students);
};
