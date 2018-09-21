class CurrentRate {
	constructor(views) {
		this.views = views;

		this.time = 0;
		this.student = "";
		this.points = 0;

		this.success = false;
		this.has = false;

		setInterval(this.timer.bind(this), 1000);
	}
	
	newRate(student, points, time) {
		this.success = false;

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
			views.div.classList.add("success-rate");
		else
			views.div.classList.remove("success-rate");

		this.views.points.innerHTML = this.points;
		this.views.student.innerHTML = this.student;
		this.views.time.innerHTML = this.time;
	}

	timer() {
		if (this.success || !this.has)
			return;

		this.time--;
		if (time==0) {
			this.succes = true;
		}

		this.render()
	}
}
