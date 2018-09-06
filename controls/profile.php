<?php
	require_once "utils.php";

	function today_rus(string $today): string { 
		return [
			"Monday" => "понедельник", 
			"Tuesday" => "вторник", 
			"Wednesday" => "среда", 
			"Thursday" => "четверг", 
			"Friday" => "пятница", 
			"Saturday" => "суббота", 
			"Sunday" => "воскресенье"
		][$today];
	}

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
				"NOTIFICATIONS" => $this->notifications()
			];
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
					"TIME" => $v["time"]
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
				$noun = get_points_in_case($points);
				
				$str .= "<h2>У Вас на счету $noun</h2>";
			}
			else {
				foreach (get_curr()->get_roles() as $role) {
					$rol = $this->roles_r[$role] ?? $role;
					$str .= "$rol, ";
				}  
				$str = substr($str, 0, -2);
				$str = "<h2>Должность: $str";
			}

			return $str;
		}

		private function today(): string {
			$r = today_rus(date("l"));
			$d = date("d.m.Y");

			return "$r, $d";
		}

		private function timetable(): string {
			if (get_curr()->is_teacher())
				return "";

			$day = date("l");
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