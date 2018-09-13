<?php
	class Timetable_control extends Control {
		public function __construct() {
			parent::__construct("timetable");
		}

		public function has_access(array $args): bool {
			return get_curr()->has_role("student");
		}

		protected function get_data(array $args): array {
			$view_day = load_view("timetable_day_table");
			$view_lesson = load_view("timetable_lesson_row");

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

			$str = "";
			foreach ($weekdays as $day) {
				$r = sql_query("
					SELECT *
					FROM lessons
					WHERE
						CLASS = '$class' AND
						WEEKDAY = '$day'
				");

				$s = "";
				foreach ($r as $v) {
					$s .= $this->process_view($view_lesson, [
						"LESSON" => $v["LESSON"],
						"PLACE" => $v["PLACE"]
					], []);
				}

				$str .= $this->process_view($view_day, [
					"WEEKDAY" => today_rus($day),
					"LESSONS" => $s
				], []);
			}

			return [
				"TIMETABLE" => $str
			];
		}
	}
?>