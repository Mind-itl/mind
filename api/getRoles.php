<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\{Passwords, Users};
	use Mind\Users\{Teacher, Student};

	class getRoles extends Api_method {
		public static function handle(): array {
			if (!Utils::isset_get_fields("login"))
				return [
					"status" => "error",
					"error" => [
						"message" => "No `login` argument"
					]
				];

			$login = $_GET['login'];

			if (!Users::has_login($login, true))
				return [
					"status" => "error",
					"error" => [
						"message" => "No user with that login"
					]
				];

			$user = Users::get($login, true);
			return $user->get_roles();
		}	
	}
?>
