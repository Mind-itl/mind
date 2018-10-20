import React from "react";
import $ from "jquery";

import Music from "./Music.js";

export default class MusicList extends React.Component {
	constructor(props) {
		super(props);
		this.state = {musics: []};
		this.loadMusic();
	}

	loadMusic() {
		let self = this;
		$.ajax({
			url: "/vote_music",
			dataType: "json"
		}).done(function(data) {
			self.setState({musics: data});
		});
	}

	render() {
		let self = this;
		return this.state.musics.sort((a,b)=>{
			if (a.votes_count < b.votes_count)
				return 1;
			else if (b.votes_count < a.votes_count)
				return -1;
			return 0;
		}).map(el =>
			<Music
				update={this.loadMusic.bind(self)}
				id={el.id}
				title={el.title}
				performer={el.performer}
				votes={el.votes_count}
				voted={el.student_vote_this}
			/>
		);
	}
}
