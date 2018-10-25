import React from "react";

import ClassStatus from "./ClassStatus.js";

export default class StatusTables extends React.Component {
	constructor(props) {
		super(props);
		this.state = {classes: []};
		this.load();
	}

	load() {
		Promise.all([
			fetch('/api/getStatus?token=site_mind_key_3'),
			fetch('/api/getStatusTypes?token=site_mind_key_3')
		]).then(([data1, data2]) => 
			Promise.all([data1.json(), data2.json()])
		).then(([classes, statuses]) => 
			this.setState({classes: classes, statuses: statuses})
		);
	}

	render() {
		if (this.state.classes)
			return this.state.classes.map(el => 
				<ClassStatus name={el.name} students={el.students} statuses={this.state.statuses}/>
			);
		else
			return "";
	}
}
