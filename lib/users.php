<?php
	declare(strict_types=1);

	require_once "db.php";
	require_once "Student.php";
	require_once "Teacher.php";

	$_login_user_cache = array();

	function get_user(string $login, string $role = ""): User {
		global $_login_users_cache;

		if (isset($_login_users_cache[$login]))
			return $_login_users_cache[$login];

		if ($role == "") {
			$role = sql_query_assoc("SELECT ROLE FROM `passwords` WHERE LOGIN='$login'")["ROLE"];
		}

		if ($role == "teacher")
			$user = new Teacher($login);
		elseif ($role == "student")
			$user = new Student($login);
		else
			return null;

		$_login_users_cache[$login] = $user;
		return $user;
	}
?>