const React = require("react");
const ReactDOM = require("react-dom");

const e = React.createElement;

class Auction extends React.Component {
	constructor(props) {
		super(props);

		this.state = { status: "closed" };

		let host = window.location.origin.replace(/https?/, "ws");

		this.socket = new WebSocket(host);

		this.socket.onopen = function () {
			this.setState({ status: "connected" });
		}.bind(this);

		this.socket.onerror = function () {
			this.setState({ status: "error" });
		}.bind(this);

		this.socket.onclose = function () {
			if (this.state.status != "error") this.setState({ status: "closed" });
		}.bind(this);

		this.socket.onmessage = function (event) {
			let data = JSON.parse(event.data);
			this.on_socket_message(data);
		}.bind(this);
	}

	on_socket_message(data) {}

	render() {
		// if (this.state.status == "closed") {
		// 	return "Аукцион пока не начался";
		// } else if (this.state.status == "error") {
		// 	return "Нет соединения с сервером";
		// }

		return React.createElement(
			"div",
			null,
			"Hello!"
		);
	}
}