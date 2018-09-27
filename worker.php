<?php
	require __DIR__."/vendor/autoload.php";
	const ROOT = __DIR__ ."/";
	const LIBS = ROOT."lib/";
	
	require LIBS."websocket.php";	

	use Workerman\Worker;
	echo "Start!\n";

	$ws_worker = new Worker("websocket://0.0.0.0:2346");
	$ws_worker->count = 4;

	$ws_worker->onConnect = function($connection) {
		$connection->send(json_encode(["type"=>"begin"]));
	};

	$ws_worker->onMessage = function($connection, $data) use ($ws_worker) {
		on_message(json_decode($data, true), $ws_worker, $connection);
	};

	$ws_worker->onClose = function($connection) {
		echo "Connection closed\n";
	};

	Worker::runAll();
?>
