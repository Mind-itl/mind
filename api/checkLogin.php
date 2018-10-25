<?php
	require_once API."checkLogin.php";
	require_once LIBS."passwords.php";

	function api_checkLogin() {
		if (!isset_get_fields("password", "login")) {
			return [
				"status" => "error"
			];
		}

		$login = $_GET['login'];
		$password = $_GET['password'];

		if (!check_password($login, $password))
			$status = false;
		else
			$status = true;

		return [
			"status" => $status
		];
	}	
?>
