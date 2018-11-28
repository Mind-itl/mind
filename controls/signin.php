<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json, Causes, Passwords};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Signin extends Control {
		public function has_access(array $args): bool {
			return !Utils::is_logined();
		}

		protected function get_data(array $args): array {
			$result = "not_set";

			if (Utils::isset_post_fields("login", "password")) {

				$login = $_POST['login'];
				$password = $_POST['password'];

				if (!Utils::check_correct($login) || !Utils::check_correct($password)) { 
					$result = "incorrect";
				} elseif (Passwords::enter_user($login, $password)) {
					$result = "right";

					if (isset($_GET["from"]))
						Utils::redirect($_GET["from"]);
					else
						Utils::redirect("/");
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
