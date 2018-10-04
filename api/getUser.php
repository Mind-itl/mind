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

		$ret = [
			"login" => $user->get_login(),
			"is_student" => $user->is_student(),
			"names" => [
				"given" => $user->get_given_name(),
				"family" => $user->get_family_name(),
				"father" => $user->get_father_name(),
			],
		];

		if ($user->is_teacher()) {
			$ret["roles"] = $user->get_roles();
			$ret["roles_args"] = [];

			foreach ($user->get_roles() as $role) {
				$role_arg = $user->get_role_arg($role);
				if (isset($role_arg))
					$ret["role_args"][$role] = $role_arg;
			}
		} else {
			$ret["points"] = $user->get_points();
		}

		return $ret;
	}
?>
