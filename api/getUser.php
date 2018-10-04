<?php
	require_once LIBS."passwords.php";

	function api_getUser() {
		if (!isset_get_fields("login"))
			return [
				"status" => "error",
				"error" => [
					"message" => "No `login` argument"
				]
			];

		if (!has_login($_GET['login']))
			return [
				"status" => "error",
				"error" => [
					"message" => "No such user"
				]
			];

		$user = get_user($_GET['login']);

		return [
			"is_student" => $user->is_student(),
			"name" => $user->get_full_name()
		];
	}
?>
