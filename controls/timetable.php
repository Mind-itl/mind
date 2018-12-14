<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json, Causes};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Timetable extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined() && Utils::get_curr() instanceof Student;
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

			$class = Utils::curr_student()->get_group_name();

			$days = [];

			foreach ($weekdays as $day) {
				$r = Db::query("
					SELECT *
					FROM lessons
					WHERE
						CLASS = ?s AND
						WEEKDAY = ?s
					ORDER BY NUMBER
					", $class, $day
				);


				$last_num = -1;
				$lessons = [];

				foreach ($r as $v) {
					if ($v["NUMBER"] == $last_num)
						continue;

					$lessons[] = [
						"name" => $v["LESSON"],
						"place" => $v["PLACE"],
						"number" => $v["NUMBER"]
					];

					$last_num = $v["NUMBER"];
				}

				$days[] = [
					"name" => Utils::today_rus($day),
					"lessons" => $lessons
				];

			}

			return [
				"days" => $days
			];
		}
	}
?>
