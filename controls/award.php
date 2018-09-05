<?php
	class Award_control extends Control {
		public function has_access(array $args): bool {
			return get_curr()->has_role("teacher");
		}

		protected function get_data(array $args): array {
			if (isset_post_fields("login", "cause")) {
				$student_login = $_POST["login"];
				$cause = $_POST['cause'];

				if (is_incorrect($student_login, $cause))
					$result = false;
				else
					$result = get_curr()->give_points($student_login, $cause);

				if ($result) {
					$result = $this->get("SUCCESS_DIV");
				} else {
					$result = $this->get("FAIL_DIV");
				}
			}

			return [
				"RESULT_DIV" => $result ?? "",
				"CAUSES" => json_encode(causes_list)
			];
		}

		public function __construct() {
			parent::__construct("award");
		}
	}
?>