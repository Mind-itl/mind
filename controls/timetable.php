<?php
	class Timetable_control extends Control {
		public function has_access(array $args): bool {
			return get_curr()->has_role("student");
		}

		protected function get_data(array $args): array {

			$weekdays = [
				"Monday", 
				"Tuesday", 
				"Wednesday", 
				"Thursday", 
				"Friday", 
				"Saturday", 
				"Sunday"
			];

			$class = get_curr()->get_class();

			$days = [];
			foreach ($weekdays as $day) {
				$r = sql_query("
					SELECT *
					FROM lessons
					WHERE
						CLASS = '$class' AND
						WEEKDAY = '$day'
				");

				$lessons = [];
				foreach ($r as $v) {
					$lessons[] = [
						"name" => $v["LESSON"],
						"place" => $v["PLACE"]
					];
				}

				$days[] = [
					"name" => $day,
					"lessons" => $lessons
				];
			}

			return [
				"days" => $days
			];
		}
	}
?>
