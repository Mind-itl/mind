<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Transactions};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	require_once Utils::ROOT."causes.php";

	class Award extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined() && Utils::get_curr() instanceof Teacher;
		}

		protected function get_data(array $args): array {
			if (Utils::isset_post_fields("login", "cause")) {
				$student_login = $_POST["login"];
				$cause = $_POST['cause'];

				if (Utils::is_incorrect($student_login, $cause))
					$result = false;
				else
					$result = Transactions::add(
						Utils::curr_teacher(),
						Users::student($student_login),
						$cause
					);

				if ($result) {
					$result = "success";
				} else {
					$result = "fail";
				}
			}

			return [
				"result" => $result ?? "",
				"causes" => json_encode(causes_list)
			];
		}
	}
?>
