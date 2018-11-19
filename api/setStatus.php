<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\Statuses;

	function api_setStatus() {
		$user = Users::get($_GET['login']);
		Statuses::set($user, $_GET['status']);
		return [];
	}
?>
