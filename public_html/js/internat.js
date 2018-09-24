window.onload = function() {
	$(".vote").click(function() {
		let val = $(this).parent().parent().
			children(".music-id").html().trim();

		

		console.log(val);
	});
}
