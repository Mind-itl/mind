<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\{Passwords, Users, Db};
	use Mind\Users\{Teacher, Student};

	class addRole extends Api_method {
		public static function handle(): array {
			if (!Utils::isset_get_fields("login", "role"))
				return [
					"status" => "error",
					"error" => [
						"message" => "No `login` or `role` argument"
					]
				];

			$login = $_GET['login'];
			$role = $_GET['role'];
			$role_arg = $_GET['role_arg'] ?? "";

			if (!Users::has_login($login, true))
				return [
					"status" => "error",
					"error" => [
						"message" => "No user with that login"
					]
				];

			$user = Users::get($login, true);

			$has_role = Db::query("
				SELECT *
				FROM teacher_roles
				WHERE
					LOGIN = ?s AND
					ROLE = ?s
				", $user->get_login(), $role
			)->num_rows > 0;

			if ($has_role)
				Db::query("
					DELETE FROM teacher_roles
					WHERE
						LOGIN = ?s AND
						ROLE = ?s
					", $user->get_login(), $role
				);
			else
				Db::query("
					INSERT INTO teacher_roles (
						LOGIN, ROLE, ARG
					) VALUES (
						?s, ?s, ?s
					)", $user->get_login(), $role, $role_arg
				);

			return [];
		}	
	}
?>
