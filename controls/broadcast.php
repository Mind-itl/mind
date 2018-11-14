<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Broadcast extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined() && Utils::get_curr() instanceof Teacher;
		}

		protected function get_data(array $args): array {
			if (Utils::isset_post_fields("selector", "message")) {

				$student_logins = $_POST['selector'];
				$message        = $_POST['message'];

				foreach (explode("\n", $student_logins) as $student_login) {
					$student_login = trim($student_login);

					if ($student_login === "")
						continue;

					if (Utils::is_incorrect($student_login) || !Users::has_login($student_login))
						$result = false;
					else {
						$student = Users::get($student_login);
						Notifications::add($student, Utils::get_curr(), $message);

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
				"classes" => Json::get_classes()
			];
		}
	}
?>
