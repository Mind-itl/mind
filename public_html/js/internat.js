window.onload = function() {
	$(".vote").click(function() {
		let self = this;
		let val = $(self).parent().parent().
			children(".music-id").html().trim();

		$.ajax({
			method: "POST",
			url: "/vote_music",
			data: {
				"vote": val
			}
		}).done(function() {
			location.reload();
		});
	});
}
