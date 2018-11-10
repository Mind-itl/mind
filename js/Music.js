import React from "react";
import $ from "jquery";

export default class Music extends React.Component {
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

		const remove = function() {
			$.ajax({
				method: "POST",
				url: "/vote_music",
				data: {
					id: this.props.id,
					remove: true
				},
				dataType: "json"
			}).done(function(data) {
				console.log(data);
				this.props.update(data);
			}.bind(this));
		}.bind(this);

		const cls = this.props.voted ? "vote-this" : "vote-not-this";
		return <div className={"music_el one-music cls " + cls}>
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
					window.is_teacher ? 
					<button className="remove-music voted-for-this" onClick={remove}>
						&times;
					</button> : null
				}
			</div>
		</div>;
	}
}
