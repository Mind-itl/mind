<?php
	require_once "utils.php";
	require_once "passwords.php";

	class Register_control extends Control {
		public function __construct() {
			parent::__construct("register");
		}

		public function has_access(array $args): bool {
			return !is_logined();
		}

		protected function get_data(array $args): array {
			$result = "NOT_SET";

			if (isset_post_fields("login", "password")) {
				$login = $_POST['login'];
				$password = $_POST['password'];

				if (!check_correct($login) || !check_correct($password)) { 
					$result = "INCORRECT";
				} elseif (enter_user($login, $password)) {
					$result = "GOOD";
					redirect("profile");
				} else {
					$result = "BAD";
				}
			}

			if ($result === "NOT_SET") {
				$result = "";
			} elseif ($result === "INCORRECT") {
				$result = $this->get("BAD_PASS");
			} else {
				$result = $this->get("WRONG_PASS");
			}

			return [
				"RESULT" => $result,
				"LOGIN" => $login ?? ""
			];
		}
	}
?>