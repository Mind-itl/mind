<?php
	require_once "utils.php";

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
			return [
				"NAME" => $this->name(),
				"USER_INFO" => $this->user_info(),
				"TODAY" => $this->today(),
				"TIMETABLE" => $this->timetable(),
				"NOTIFICATIONS" => $this->notifications(),
				"DAYTIME" => $this->daytime(),
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

		private function notifications(): string {
			$notification_view = load_view("profile_notification_row");

			$read_class = $this->get("CHECKED_MESSAGE_TR_CLASS");
			$unread_class = $this->get("UNCHECKED_MESSAGE_TR_CLASS");
			
			$nots = get_notifications(get_curr());

			$str = "";
			foreach ($nots as $v) {
				$str .= $this->process_view($notification_view, [
					"CLASS" => $v["read"] ? $read_class : $unread_class,
					"MESSAGE" => $v["message"],
					"TIME" => $v["time"],
					"ID" => $v["id"]
				], []);
			}

			return $str;
		}

		private function name(): string {
			$name = get_curr()->is_student() ? "gi" : "gi ft";
			$name = get_curr()->get_full_name($name);

			return $name;
		}

		private function user_info(): string {
			$str = "";

			if (get_curr()->is_student()) {
				$points = get_curr()->get_points();
				$noun = get_points_case($points);
				
				$str .= "У Вас на счету <strong>$points</strong> $noun";
			} else {
				foreach (get_curr()->get_roles() as $role) {
					$rol = $this->roles_r[$role] ?? $role;
					$str .= "$rol, ";
				}  
				$str = substr($str, 0, -2);
				$str = "Должность: $str";
			}

			return $str;
		}

		private function table_date(): DateTime {
			$today = new DateTime();
			$tomorrow = new DateTime('10-09-2018');

			$h = $today->format('H');
			$h = intval($h);

			if ($h >= 13)
				return $tomorrow;
			else
				return $today;
		}

		private function today(): string {
			$a = $this->table_date();
			$d = $a->format("d.m.Y"); 

			$r = $a->format("l");
			$r = today_rus($r);

			$n = ($a->format("l") == (new DateTime())->format("l")) ? "Сегодня" : "Завтра";
			return "$n: $r, $d";
		}

		private function timetable(): string {
			if (get_curr()->is_teacher())
				return "";

			$day = $this->table_date()->format("l");
			$class = get_curr()->get_class();

			$lessons = sql_query(
				"SELECT LESSON, PLACE
				FROM lessons
				WHERE
					CLASS='$class' AND
					WEEKDAY='$day'
				ORDER BY NUMBER");

			$str = "";
			foreach ($lessons as $lesson) {
				$s = tag("td", $lesson["LESSON"]) . tag("td", $lesson["PLACE"]);
				$str .= tag("tr", $s);
			}

			return $str;
		}

		public function __construct() {
			parent::__construct("profile");
		}
	}
?>