<?php
	class Give_control extends Control {
		public function has_access(array $args): bool {
			return get_curr()->has_role("student");
		}

		protected function get_data(array $args): array {
			if (isset_post_fields("login", "points")) {
				$login = $_POST['login'];
				$points = $_POST['points'];

				if (is_incorrect($login, $points)) {
					error_log('incorrect $login $points in give.php:11');
					$result = false;
				} else {
					error_log('error give.php:14');
					$result = get_curr()->give_points($login, intval($points));
				}

				if ($result) {
					$result = $this->get("SUCCESS_DIV");
				} else {
					$result = $this->get("FAIL_DIV");
				}
			}

			return [
				"RESULT_DIV" => $result ?? "",
				"POINTS" => get_points_in_case(get_curr()->get_points())
			];
		}

		public function __construct() {
			parent::__construct("give");
		}
	}
?>