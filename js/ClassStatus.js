import React from "react";

const moment = require("moment");

moment.locale('ru');

const time_format = "D MMMM YYYY";
const student_name_format = "family given father";
const get_name = student => student_name_format.split(' ').map(el => student.names[el]).join(' ')
 
export default class ClassStatus extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return <table className="classStatus"><tbody>
			<tr>
				<th>Ученик</th>
				{this.props.statuses.map(el => 
					<th>{el}</th>
				)}
			</tr>
			{this.props.students.
				sort((a,b) => {
					a = get_name(a);
					b = get_name(b);
					if (a < b)
						return -1;
					if (a > b)
						return 1;
					return 0;
				}).
				map(el =>
					<StudentStatus names={el.names} status={el.status} login={el.login} time={el.time} statuses={this.props.statuses}/>
				)
			}
		</tbody></table>;
	}
}

class StudentStatus extends React.Component {
	constructor(props) {
		super(props);
		this.state = {status: props.status, time: props.time};
	}

	getName() {
		return get_name(this.props);
	}

	setStatus(status) {
		fetch(`/api/setStatus?login=${this.props.login}&status=${status}&token=site_mind_key_3`).catch(e=>console.log(e));
		this.setState({status: status, time: new Date()});
	}

	getTime() {
		if (typeof this.state.time === 'string' || this.state.time instanceof String) {
			this.state.time = new Date(this.state.time);
		}

		let t = this.state.time;

		if (t)
			return moment(this.state.time).format(time_format);

		return "";
	}

	render() {
		return <tr className="studentStatus">
			<td>{this.getName()}</td>

			{this.props.statuses.map(type =>
				<td className={type == this.state.status ? 'type-it' : 'type-not-it'}>
					<button onClick={() => this.setStatus(type)}>
						{type == this.state.status ? '+' : '-'}
					</button>
				</td>
			)}
			<td className="status-time">
				{this.getTime()}
			</td>
		</tr>
	}
}
