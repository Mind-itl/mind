<?php
	require_once LIBS."passwords.php";

	class Broadcast_control extends Control {
		public function has_access(array $args): bool {
			return is_logined() && get_curr()->has_role("teacher");
		}

		protected function get_data(array $args): array {
			if (isset_post_fields("selector", "message")) {

				$student_logins = $_POST['selector'];
				$message       = $_POST['message'];

				foreach (explode("\n", $student_logins) as $student_login) {
					$student_login = trim($student_login);

					if ($student_login === "")
						continue;

					if (is_incorrect($student_login) || !has_login($student_login))
						$result = false;
					else {
						$student = get_user($student_login);
						add_notification($student, get_curr(), $message);

						$result = true;
					}

					if ($result) {
						$result = "success";
					} else {
						$result = "fail";
						break;
					}
				}
			}

			return [
				"result" => $result ?? "not_set",
				"classes" => get_classes_json()
			];
		}
	}
?>
