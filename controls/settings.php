<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json, Causes, Passwords};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Settings extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		protected function get_data(array $args): array {
			$result = "not_stated";

			if (Utils::isset_post_fields("type")) {
				$result = $this->post_handle();
			}

			return [
				"result" => $result
			];
		}

		private function post_handle(): string {
			$type = $_POST["type"];
			
			if ($type=="change_password") {
				return $this->change_password();
			}
			if ($type=="change_login") {
				return $this->change_login();
			}
		}

		private function change_password(): string {
			if (!Utils::isset_post_fields("old_password", "new_password"))
				return "fail";

			$old = $_POST["old_password"];
			$new = $_POST["new_password"];
			$login = Utils::get_curr()->get_login();

			if (!Passwords::change_password($login, $old, $new))
				return "wrong";

			return "success";
		}

		private function change_login(): string {
			if (!Utils::isset_post_fields("new_login", "password"))
				return "fail";

			$new_login = $_POST["new_login"];
			$password = $_POST["password"];

			if (!Passwords::check_password(Utils::get_curr()->get_login(), $password, false))
				return "wrong";

			$r = Passwords::change_enter_login(Utils::get_curr(), $new_login);
			return $r ? "success" : "fail";
		}
	}
?>
