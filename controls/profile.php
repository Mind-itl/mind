<?php
	class Profile_control extends Control {
		public function has_access(array $args): bool {
			return is_logined();
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
				"clruk_name" => $cl_ruk,
				"login" => get_curr()->get_login()
			];
		}

		private function get_group_clruk(): array {
			if (get_curr()->is_teacher())
				return ["", ""];

			$class = get_curr()->get_class();

			if ($clruk = get_curr()->get_classruk()) {
				$clruk = $clruk->get_names();
			}
			return [$class, $clruk ?? null];
		}

		private function points(): array {
			if (!get_curr()->is_student()) 
				return [];

			$points = get_curr()->get_points();
			return [
				"count" => $points,
				"noun" => get_points_case($points)
			];
		}

		private function daytime(): string {
			$h = (new DateTime())->format("H");
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
			$nots = get_notifications(get_curr());
			return $nots;
		}

		private function table_date(): DateTime {
			$today = new DateTime();
			$tomorrow = new DateTime('tomorrow');

			$h = $today->format('H');
			$h = intval($h);

			if ($h >= 17)
				return $tomorrow;
			else
				return $today;
		}

		private function is_today(): bool {
			$a = $this->table_date();
			return $a->format("l") == (new DateTime())->format("l");
		}

		private function timetable(): array {
			if (get_curr()->is_teacher())
				return [];

			$day = $this->table_date()->format("l");
			$class = get_curr()->get_class();

			$lessons = safe_query(
				"SELECT LESSON, PLACE, NUMBER
				FROM lessons
				WHERE
					CLASS = ?s AND
					WEEKDAY = ?s
				ORDER BY NUMBER
				", $class, $day
			);

			$arr = [];
			foreach ($lessons as $lesson) {
				$num = intval($lesson["NUMBER"]);
				if (isset(lesson_times[$num-1])) {
					$f = "H:i";
					$bg = DateTime::createFromFormat($f, lesson_times[$num-1][0]);
					$end = DateTime::createFromFormat($f, lesson_times[$num-1][1]);

					$is_now = $bg <= (new DateTime()) && (new DateTime()) <= $end;
				}

				$arr[] = [
					"lesson" => $lesson["LESSON"],
					"place" => $lesson["PLACE"],
					"is_now" => $is_now ?? false,
					"number" => $num
				];
			}

			return $arr;
		}
	}
?>
