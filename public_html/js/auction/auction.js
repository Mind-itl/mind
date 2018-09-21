class Auction {
	constructor(views, socket) {
		this.currRate = new CurrentRate(views.curr_rate);

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

		this.views.auction.off.hidden = true;
		this.views.auction.on.hidden = false;

		this.started = true;
	}

	end() {
		console.log("Auction has ended");

		this.views.auction.off.hidden = false;
		this.views.auction.on.hidden = true;
		
		this.started = false;
	}

	new_rate(student, points, time) {
		console.log(`
			New rate:
			- student: |${student}|,
			- points: |${points}|,
			- time: |${time}|
		`);

		this.currRate.newRate(student, points, time);
	}

	new_lot(name, points) {
		console.log(`
			New lot:
			- name: |${name}|,
			- points: |${points}|
		`);
	}
}
	
