(function() {
	'use strict';

	const gid = e => document.getElementById(e);

	const curr_lot = {
		nameSpan: gid("curr_lot_name"),
		name: "",

		minPointsSpan: gid("curr_lot_min_points"),
		minPoints: 0,

		getName: function() {
			return this.name;
		},
		setName: function(name) {
			this.name = name;
			this.update();
		},

		getMinPoints: function() {
			return this.minPoints;
		},
		setMinPoints: function(points) {
			this.minPoints = points;
			this.update();
		},

		update: function() {
			this.nameSpan.innerHTML = this.name;
			this.minPointsSpan.innerHTML = this.minPoints;
		},

		init: function() {
			this.update();
		},
	};
	curr_lot.init();

	const curr_rate = {
		pointsSpan: gid("curr_rate_points"),
		points: 0,

		studentSpan: gid("curr_rate_student"),
		student: "",

		rateSpan: gid("curr_rate"),
		rate: false,

		timeSpan: gid("curr_rate_time"),
		time: 0,

		timeDiv: gid("curr_rate_time_div"),

		success: false,

		getTime: function() {
			return this.time;
		},
		setTime: function() {
			this.time = time;
			this.update();
		},

		getPoints: function() {
			return this.points;
		},
		setPoints: function(points) {
			this.points = points;
			this.update();
		},

		getStudent: function() {
			return this.student;
		},
		setStudent: function(student) {
			this.student = student;
			this.update();
		},

		hasRate: function() {
			return this.rate;
		},
		setRate: function(rate) {
			this.rate = rate;
			this.update();
		},

		hide: function() {
			this.rateSpan.hidden = true;
		},
		show: function() {
			this.rateSpan.hidden = false;
		},

		update: function() {
			if (!this.hasRate()) {
				this.hide();
				return;
			}

			this.show();
			this.pointsSpan.innerHTML = this.points;
			this.studentSpan.innerHTML = this.student;
			this.timeSpan.innerHTML = this.time;

			if (this.success)
				this.rateSpan.classList.add("success-rate");
			else
				this.rateSpan.classList.remove("success-rate");
		},

		successRate: function() {
			this.success = true;
			this.update();
		},

		add: function(student, points, time=5) {
			this.rate = true;
			this.success = false;
			this.student = student;
			this.points = points;
			this.time = time;

			this.update();
		},

		init: function() {
			setInterval(() => {

				if (!this.hasRate() || this.success)
					return;

				this.time--;
				this.update();

				if (this.time==0) {
					this.successRate();
					return;
				}

			}, 1000);
		}
 	};

	curr_rate.init();
	// curr_rate.add("Семёнов Роман", "100");

})();
