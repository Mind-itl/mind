<?php
	require_once LIBS."passwords.php";

	class Settings_control extends Control {
		public function has_access(array $args): bool {
			return is_logined();
		}

		protected function get_data(array $args): array {
			$result = "not_stated";

			if (isset_post_fields("type")) {
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
		}

		private function change_password(): string {
			if (!isset_post_fields("old_password", "new_password"))
				return "fail";

			$old = $_POST["old_password"];
			$new = $_POST["new_password"];
			$login = get_curr()->get_login();

			if (!change_password($login, $old, $new))
				return "wrong";

			return "success";
		}
	}
?>
