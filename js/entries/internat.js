'use strict';

import "../main.js";
import $ from "jquery";

import React from "react";
import ReactDOM from "react-dom";

class MusicList extends React.Component {
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

class Music extends React.Component {
	render() {
		const vote = function() {
			console.log(this.props.id);
			$.ajax({
				method: "POST",
				url: "/vote_music",
				data: {
					"id": this.props.id
				},
				dataType: "json"
			}).done(function(data) {
				console.log(data);
				this.props.update(data);
			}.bind(this));
		}.bind(this);

		const cls = this.props.voted ? "vote-this" : "vote-not-this";
		return <div className="music_el one-music {cls}">
			<div hidden className="music-id">
				{this.props.id}
			</div>
			<div className="music_name">
				<span className="music_performer song-singer">
					{this.props.performer} 
				</span>
				<span className="music-divider"> - </span>
				<span className="music_title song-name">
					{this.props.title}
				</span>
			</div>
			<div className="vote-info">
				<span className="votes vote-count">
					{this.props.votes}
				</span>

				{
					this.props.voted ?
						<button className="vote unvote voted-for-this" onClick={vote}>
							&times;
						</button>
					:
						<button className="vote dovote vote-for-this" onClick={vote}>
							+
						</button>
				}
				{
					false ? 
					<button className="remove-music voted-for-this">
						&times;
					</button> : null
				}
			</div>
		</div>;
	}
}

document.addEventListener("DOMContentLoaded", function() {
	ReactDOM.render(<MusicList/>, document.getElementById("music_list"));
});
