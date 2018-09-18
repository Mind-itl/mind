<?php
	class Give_control extends Control {
		public function has_access(array $args): bool {
			return get_curr()->has_role("student");
		}

		protected function get_data(array $args): array {
			if (isset_post_fields("login", "points")) {
				$login = $_POST['login'];
				$points = $_POST['points'];

				if (is_incorrect($login, $points) || $login == get_curr()->get_login()) {
					error_log('incorrect $login $points in give.php:11');
					$result = false;
				} else {
					$result = get_curr()->give_points($login, intval($points));
				}

				if ($result) {
					$result = "success";
				} else {
					$result = "fail";
				}
			}

			return [
				"result" => $result ?? "",
				"points" => get_points_in_case(get_curr()->get_points())
			];
		}
	}
?>
