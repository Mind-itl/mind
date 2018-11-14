<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json, Causes};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	const lesson_times = [
		["8:00", "8:40"],
		["8:45", "9:25"],
		["9:40", "10:20"],
		["10:50", "11:30"],
		["11:40", "12:20"],
		["12:25", "13:05"]
	];

	class Profile extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		private $roles_r = [
			"predmet" => "учитель-предметник",
			"classruk" => "классный руководитель",
			"diric" => "директор",
			"vospit" => "воспитатель",
			"zam" => "завуч"
		];

		protected function get_data(array $args): array {
			list($group, $cl_ruk) = $this->get_group_clruk();

			return [
				"date" => $this->table_date(),
				"is_today" => $this->is_today(),
				"timetable" => $this->timetable(),
				"notifications" => $this->notifications(),
				"daytime" => $this->daytime(),
				"points" => $this->points(),
				"group" => $group,
				"clruk" => $cl_ruk,
				"login" => Utils::get_curr()->get_login()
			];
		}

		private function get_group_clruk(): array {
			if (!Utils::get_curr() instanceof Student)
				return ["", null];

			$class = Utils::get_curr()->get_class();
			$clruk = Utils::get_curr()->get_classruk();

			return [$class, $clruk ?? null];
		}

		private function points(): array {
			if (!Utils::get_curr() instanceof Student) 
				return [];

			$points = Utils::get_curr()->get_points();
			return [
				"count" => $points,
				"noun" => Utils::get_points_case($points)
			];
		}

		private function daytime(): string {
			$h = (new \DateTime())->format("H");
			$h = intval($h);

			$night   = "Доброй ночи" ;
			$morning = "Доброе утро" ;
			$day     = "Добрый день" ;
			$evening = "Добрый вечер";

			if ($h < 5)
				return $night;
			elseif ($h < 12)
				return $morning;
			elseif ($h < 16)
				return $day;
			elseif ($h < 22)
				return $evening;

			return $night;
		}

		private function notifications(): array {			
			$nots = Notifications::get(Utils::get_curr());
			return $nots;
		}

		private function table_date(): \DateTime {
			$today = new \DateTime();
			$tomorrow = new \DateTime('tomorrow');

			$h = $today->format('H');
			$h = intval($h);

			if ($h >= 17)
				return $tomorrow;
			else
				return $today;
		}

		private function is_today(): bool {
			$a = $this->table_date();
			return $a->format("l") == (new \DateTime())->format("l");
		}

		private function timetable(): array {
			if (!Utils::get_curr() instanceof Student)
				return [];

			$day = $this->table_date()->format("l");
			$class = Utils::get_curr()->get_class();

			$lessons = Db::query(
				"SELECT LESSON, PLACE, NUMBER
				FROM lessons
				WHERE
					CLASS = ?s AND
					WEEKDAY = ?s
				ORDER BY NUMBER
				", $class, $day
			);

			$arr = [];

			$last_num = -1;

			foreach ($lessons as $lesson) {
				$num = intval($lesson["NUMBER"]);

				if ($num == $last_num)
					continue;

				if (isset(lesson_times[$num-1])) {
					$f = "H:i";
					$bg = \DateTime::createFromFormat($f, lesson_times[$num-1][0]);
					$end = \DateTime::createFromFormat($f, lesson_times[$num-1][1]);

					$is_now = $bg <= (new \DateTime()) && (new \DateTime()) <= $end;
				}

				$arr[] = [
					"lesson" => $lesson["LESSON"],
					"place" => $lesson["PLACE"],
					"is_now" => $is_now ?? false,
					"number" => $num
				];

				$last_num = $num;
			}

			return $arr;
		}
	}
?>
