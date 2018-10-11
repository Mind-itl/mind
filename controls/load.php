<?php
	require_once LIBS."Excel_reader.php";

	class Load_control extends Control {
		public function has_access(array $args): bool {
			return is_logined() && get_curr()->is_teacher();
		}

		protected function get_data(array $args): array {
			if (isset_post_fields("excel_type")) {
				$this->post_handle();
			}

			return [];
		}

		private function post_handle() {
			$type = $_POST["excel_type"];
			switch ($type) {
				case 'Расписание':
					require_once ROOT.'lib/excel_readers/Timetable.php';
					Timetable::load($_FILES['excel']['tmp_name']);
				break;
			}
		}
	}
?>
