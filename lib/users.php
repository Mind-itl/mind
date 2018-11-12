<?php
	declare(strict_types=1);

	require_once LIBS."db.php";
	require_once LIBS."Student.php";
	require_once LIBS."Teacher.php";

	function get_user(string $login, string $role = "", bool $is_enter_login=false): ?User {
		$login_field = $is_enter_login ? "ENTER_LOGIN" : "LOGIN";

		$r = safe_query_assoc("
			SELECT *
			FROM `passwords`
			WHERE `$login_field` = ?s
			", $login
		);

		$role = $r["ROLE"];
		$login = $r["LOGIN"];

		if ($role == "teacher")
			$user = new Teacher($login);
		elseif ($role == "student")
			$user = new Student($login);
		else
			return null;

		return $user;
	}
?>
