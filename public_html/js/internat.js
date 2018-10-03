window.onload = function() {
	'use strict';
	const get_music_elem = function(music) {
		let cls;
		if (music.student_vote_this)
			music.cls = "vote-this";
		else
			music.cls = "vote-not-this";

		let el = $("#primer_music_el").clone();

		el.removeAttr("id");
		el.addClass(music.cls);
		el.find(".music-id").html(music.id);
		el.find(".music_performer").html(music.performer);
		el.find(".music_title").html(music.title);
		el.find(".votes").html(music.votes_count);
		el.addClass(music.cls);

		return el;
	}

	const render = function(musics) {
		$("#music_list").children(".music_el:not(#primer_music_el)").remove();
		musics.sort((a,b)=>{
			if (a.votes_count < b.votes_count)
				return -1;
			else if (b.votes_count < a.votes_count)
				return 1;
			return 0;
		}).forEach(music => {
			$("#music_list").prepend(get_music_elem(music));
		});
		$(".vote").click(function() {
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
				render(data);
			});
		});
	};


	$.ajax({
		url: "/vote_music",
		dataType: "json"
	}).done(function(data) {
		render(data);
	});
}
