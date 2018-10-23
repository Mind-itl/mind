import React from "react";

const student_name_format = "family given father";
const get_name = student => student_name_format.split(' ').map(el => student.names[el]).join(' ')
 
export default class ClassStatus extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return <table><tbody>
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
					<StudentStatus names={el.names} status={el.status} login={el.login} statuses={this.props.statuses}/>
				)
			}
		</tbody></table>;
	}
}

class StudentStatus extends React.Component {
	constructor(props) {
		super(props);
		this.state = {status: props.status};
	}

	getName() {
		return get_name(this.props);
	}

	setStatus(status) {
		fetch(`/api/setStatus?login=${this.props.login}&status=${status}`);
		this.setState({status: status});
	}

	render() {
		return <tr>
			<td>{this.getName()}</td>

			{this.props.statuses.map(type => 
				<td>
					<button onClick={() => this.setStatus(type)}>
						{type == this.state.status ? '+' : '-'}
					</button>
				</td>
			)}
		</tr>
	}
}
