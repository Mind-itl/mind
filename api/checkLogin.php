<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\Passwords;

	class CheckLogin extends Api_method {
		public static function handle(): array {
			if (!Utils::isset_get_fields("password", "login")) {
				return [
					"status" => "error"
				];
			}

			$login = $_GET['login'];
			$password = $_GET['password'];

			if (!Passwords::check_password($login, $password))
				$status = false;
			else
				$status = true;

			return [
				"status" => $status
			];
		}	
	}
?>
