<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\{Passwords, Users};
	use Mind\Users\{Teacher, Student};

	class getUser extends Api_method {
		public static function handle(): array {
			if (!Utils::isset_get_fields("login"))
				return [
					"status" => "error",
					"error" => [
						"message" => "No `login` argument"
					]
				];

			if (!Users::has_login($_GET['login'], true))
				return [
					"status" => "error",
					"error" => [
						"message" => "No such user"
					]
				];

			$user = Users::get($_GET['login'], true);

			$ret = [
				"login" => $user->get_enter_login(),
				"is_student" => $user->has_role("student"),
				"names" => [
					"given" => $user->get_given_name(),
					"family" => $user->get_family_name(),
					"father" => $user->get_father_name(),
				],
			];

			if ($user instanceof Teacher) {
				$ret["roles"] = $user->get_roles();
				$ret["role_args"] = [];

				foreach ($user->get_roles() as $role) {
					$role_arg = $user->get_role_arg($role);
					if (isset($role_arg))
						$ret["role_args"][$role] = $role_arg;
				}
			} elseif ($user instanceof Student) {
				$ret["points"] = $user->get_points();
				$ret["group"] = [
					"par" => intval($user->get_class("num")),
					"lit" => $user->get_class("lit")
				];
			}

			return $ret;
		}
	}
?>
