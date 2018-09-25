window.onload = function() {
	const get_music_elem = function(music) {
		let cls;
		if (music.student_vote_this)
			music.cls = "vote-this";
		else
			music.cls = "vote-not-this";

		let el = $("#primer_music_el").clone();

		el.children(".music-id").html(music.id);
		el.children(".music_performer").html(music.performer);
		el.children(".music_title").html(music.title);
		el.children(".votes").html(music.votes_count);
		el.addClass(music.cls);

		return el;
	}

	const render = function(musics) {
		$("#music_list").children().remove();
		musics.forEach(music => {
			$("#music_list").append(get_music_elem(music));
		});
		$(".vote").click(function() {
			console.log("click");
			let self = this;
			let val = $(self).parent().parent().
				children(".music-id").html().trim();

			$.ajax({
				method: "POST",
				url: "/vote_music",
				data: {
					"id": val
				},
				dataType: "json"
			}).done(function(data) {
				console.log(data);
				render(data);
			});
		});
	};


	$.ajax({
		url: "/vote_music",
		dataType: "json"
	}).done(function(data) {
		console.log(data);
		render(data);
	});
}
