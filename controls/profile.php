<?php
	require_once "utils.php";

	check_logined();

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
				"TIMETABLE" => $this->timetable()
			];
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
				
				$str .= "<h2>У Вас на счету $points $noun</h2>";
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
			$lessons = [
				["Математика", "203"],
				["Математика", "203"],
				["Русский язык", "203"],
				["Биология", "316"],
				["География", "316"],
				["Физическая культура", "115"],
				["Подготовка к ОГЭ (русский язык)", "104"],
				["Подготовка к ОГЭ (русский язык)", "104"],
			];

			$str = "";
			foreach ($lessons as $lesson) {
				$s = tag("td", $lesson[0]) . tag("td", $lesson[1]);
				$str .= tag("tr", $s);
			}

			return $str;
		}

		public function __construct() {
			parent::__construct("profile");
		}
	}
?>