<?php
	use Workerman\Connection\ConnectionInterface;
	use Workerman\Worker;

	$callbacks = [];
	$callbacks["newRate"] = function($data, $worker, $connection) {
		//todo check rate
		safe_query("
			INSERT INTO rates (
				LOGIN, POINTS, TIME
			) VALUES (
				?s, ?i, ?i
			)", $data["login"], $data["points"], $data["time"]
		);
	}

	function on_message(array $data, Worker $worker, ConnectionInterface $connection) {
		$type = $data["type"];

		if (isset($callbacks[$type]))
			$callbacks[$type]($data, $worker, $connection);
	}
?>
