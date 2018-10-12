<?php
	declare(strict_types=1);

	require_once LIBS."db.php";
	require_once LIBS."Student.php";
	require_once LIBS."Teacher.php";

	function get_user(string $login, string $role = ""): ?User {
		if ($role == "") {
			$role = safe_query_assoc("
				SELECT ROLE
				FROM `passwords`
				WHERE LOGIN = ?s
				", $login
			)["ROLE"];
		}

		if ($role == "teacher")
			$user = new Teacher($login);
		elseif ($role == "student")
			$user = new Student($login);
		else
			return null;

		return $user;
	}
?>
