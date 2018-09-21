(function() {
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
			time: gid("curr_rate_time")
		},
		history: gid("rate_history")
	};

	class Auction {
		constructor(views, socket) {
			this.started = false;
			this.views = views;
			this.socket = socket;

			socket.onmessage = this.onSocketMessage;

			this.send({type: "connect"});
		}

		send(data) {
			this.socket.send(JSON.stringify(data));
		}

		onSocketMessage(event) {
			const self = this;

			let data = JSON.parse(event.data);

			const f = {
				begin: function(data) {
					self.begin();
				},
				end: function(data) {
					self.end();
				},
				new_rate: function(data) {
					self.addRate(data.student, data.points, data.time);
				},
				new_lot: function(data) {
					self.setLot(data.name, data.points)
				}
			}

			if (data.type === undefined || !(data.type in f))
				return;

			f[data.type](data.data);
		}

		begin() {
			console.log("Auction has begun");
		}

		end() {
			console.log("Auction has ended");
		}

		new_rate(student, points, time) {
			console.log(`
				New rate:
				- student: |${student}|,
				- points: |${points}|,
				- time: |${time}|
			`);
		}

		new_lot(name, points) {
			console.log(`
				New lot:
				- name: |${name}|,
				- points: |${points}|
			`);
		}
	}

	new Promise(function(resolve, reject) {
		let socket = new WebSocket("ws:" + document.location.host);

		socket.onopen = function() {
			resolve(socket);
		}
		socket.onerror = function(error) {
			reject(error);
		}
	}).then(function(socket) {
		let auction = new Auction(views, socket);

		testing(auction);
	});

	function testing(auction) {
		// auction.begin();
	}

})();
