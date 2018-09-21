window.onload = function() {
	'use strict';

	const gid = e => document.getElementById(e);

	const views = {
		curr_lot: {
			name: gid("curr_lot_name"),
			min_points: gid("curr_lot_min_points"),
		},
		curr_rate: {
			points: gid("curr_rate_points"),
			student: gid("curr_rate_student"),
			time: gid("curr_rate_time"),
			div: gid("curr_rate")
		},
		history: gid("rate_history"),
		auction: {
			off: gid("auction-off"),
			on: gid("auction-on")
		}
	};

	new Promise(function(resolve, reject) {
		let socket = new WebSocket("ws:" + document.location.host + "/ws");

		socket.onopen = function() {
			resolve(socket);
		}
		socket.onerror = function(error) {
			reject(error);
		}
	}).then(
		socket => {
			let auction = new Auction(views, socket);
		},
		error => {
			views.auction.off.innerHTML = "Проблемы с сервером";
		}
	);
};
