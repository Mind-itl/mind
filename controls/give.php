<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Give extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined() && Utils::get_curr() instanceof Student;
		}

		protected function get_data(array $args): array {
			if (Utils::isset_post_fields("login", "points")) {
				$login = $_POST['login'];
				$points = $_POST['points'];

				if (Utils::is_incorrect($login, $points) || $login == Utils::get_curr()->get_login()) {
					error_log('incorrect $login $points in give.php:11');
					$result = false;
				} else {
					$result = Utils::curr_student()->give_points($login, intval($points));
				}

				if ($result) {
					$result = "success";
				} else {
					$result = "fail";
				}
			}

			return [
				"result" => $result ?? "",
				"points" => [
					"count" => Utils::curr_student()->get_points(),
					"noun" => Utils::get_points_case(Utils::curr_student()->get_points())
				]
			];
		}
	}
?>
