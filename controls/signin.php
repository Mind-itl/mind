<?php
	require_once LIBS."passwords.php";

	class Signin_control extends Control {
		public function __construct() {
			parent::__construct("signin");
		}

		public function has_access(array $args): bool {
			return !is_logined();
		}

		protected function get_data(array $args): array {
			$result = "not_set";

			if (isset_post_fields("login", "password")) {
				$login = $_POST['login'];
				$password = $_POST['password'];

				if (!check_correct($login) || !check_correct($password)) { 
					$result = "incorrect";
				} elseif (enter_user($login, $password)) {
					$result = "right";
					redirect("profile");
				} else {
					$result = "wrong";
				}
			}

			return [
				"result" => $result,
				"login" => $login ?? ""
			];
		}
	}
?>
