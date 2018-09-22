class CurrentRate {
	constructor(views) {
		this.views = views;

		this.time = 0;
		this.student = "";
		this.points = 0;

		this.success = false;
		this.has = false;

		this.render();
		setInterval(this.timer.bind(this), 1000);
	}
	
	newRate(student, points, time) {
		this.success = false;
		this.has = true;

		this.time = time;
		this.points = points;
		this.student = student;
		
		this.render();
	}

	render() {
		if (!this.has) {
			this.views.div.hidden = true;
			return;
		} else
			this.views.div.hidden = false;

		if (this.success)
			this.views.div.classList.add("success-rate");
		else
			this.views.div.classList.remove("success-rate");

		this.views.points.innerHTML = this.points;
		this.views.student.innerHTML = this.student;
		this.views.time.innerHTML = this.time;
	}

	timer() {
		if (this.success || !this.has)
			return;

		this.time--;
		if (this.time<=0) {
			this.success = true;
		}

		this.render()
	}
}