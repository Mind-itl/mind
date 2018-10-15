<?php
	class Timetable_control extends Control {
		public function has_access(array $args): bool {
			return is_logined() && get_curr()->has_role("student");
		}

		protected function get_data(array $args): array {

			$weekdays = [
				"Monday", 
				"Tuesday", 
				"Wednesday", 
				"Thursday", 
				"Friday", 
				"Saturday", 
			];

			$class = get_curr()->get_class();

			$days = [];
			foreach ($weekdays as $day) {
				$r = safe_query("
					SELECT *
					FROM lessons
					WHERE
						CLASS = ?s AND
						WEEKDAY = ?s
					ORDER BY NUMBER
					", $class, $day
				);

				$lessons = [];
				foreach ($r as $v) {
					$lessons[] = [
						"name" => $v["LESSON"],
						"place" => $v["PLACE"],
						"number" => $v["NUMBER"]
					];
				}

				$days[] = [
					"name" => today_rus($day),
					"lessons" => $lessons
				];
			}

			return [
				"days" => $days
			];
		}
	}
?>
