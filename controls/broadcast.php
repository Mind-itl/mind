<?php
	require_once LIBS."passwords.php";

	class Broadcast_control extends Control {
		public function has_access(array $args): bool {
			return get_curr()->has_role("teacher");
		}

		protected function get_data(array $args): array {
			if (isset_post_fields("selector", "message")) {

				$student_login = $_POST['selector'];
				$message       = $_POST['message'];

				if (is_incorrect($student_login) || !has_login($student_login))
					$result = false;
				else {
					$student = get_user($student_login);
					add_notification($student, $message);

					$result = true;
				}

				if ($result) {
					$result = "success";
				} else {
					$result = "fail";
				}
			}

			return [
				"result" => $result ?? "not_set"
			];
		}
	}
?>
