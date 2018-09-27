<?php
	/*
	
	Types:
		objects:
			login_t = string //≤60 chars
			time_t = int //milliseconds
			Rate_id = int
			Lot_id = int

			Rate(time_t time, login_t login, int min_points, Rate_id id)
			Lot(string name, int min_points, Lot_id id)

		websocket->client_*:
			begin(Lot lot)
			end

			newRate(Rate rate)
			newLot(Lot lot)
			history(array<Rate|lot>)
			
			sold(Lot_id, Rate_id)

			error(string msg)

		client_student->websocket:
			newRate(Rate rate)

		client_teacher->websocket:
			newLot(Lot lot)
			begin(Lot lot)
			end
	*/

	use Workerman\Connection\ConnectionInterface;
	use Workerman\Worker;

	$callbacks = [];

	$callbacks["begin"] = function($data, $worker, $connection) use ($callbacks) {
		$callbacks["newRate"]($data, $worker, $connection);
	};

	$callbacks["end"] = function($data, $worker, $connection) {
		//todo check login
		safe_query("DELETE FROM rates; DELETE FROM lots");
	};

	$callbacks["newRate"] = function($data, $worker, $connection) {
		//todo check rate
		safe_query("
			INSERT INTO rates (
				LOGIN, POINTS, TIME
			) VALUES (
				?s, ?i, ?i
			)", $data["login"], $data["points"], $data["time"]
		);

		foreach ($worker->connections as $conn) {
			$conn->send(json_encode($data));
		}
	};

	$callbacks["newLot"] = function($data, $worker, $connection) {
		//todo check lot
		safe_query("
			INSERT INTO lots (
				NAME, MIN_POINTS
			) VALUES (
				?s, ?i
			)", $data["name"], $data["min_points"]
		);

		foreach ($worker->connections as $conn) {
			$conn->send(json_encode($data));
		}
	};

	function on_connect(Worker $worker, ConnectionInterface $connection) {

	}

	function on_message(array $data, Worker $worker, ConnectionInterface $connection) {
		$type = $data["type"];

		if (isset($callbacks[$type]))
			$callbacks[$type]($data, $worker, $connection);
	}
?>
