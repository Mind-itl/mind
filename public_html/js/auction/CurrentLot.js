class CurrentLot {
	constructor(views) {
		this.views = views;

		this.name = "";
		this.min_points = "";
	
		this.render();
	}

	render() {
		this.views.name.innerHTML = this.name;
		this.views.min_points.innerHTML = this.min_points;
	}

	newLot(name, min_points) {
		this.name = name;
		this.min_points = min_points;

		this.render();
	}
}
