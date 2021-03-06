<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json};
	use Mind\Server\{Control, Utils, Route};
	use Mind\Users\{User, Teacher, Student};

	class Group extends Control {
		private $row_view;

		public function has_access(array $args): bool {
			if (!Utils::is_logined())
				return false;

			if (isset($args[1]) && $args[1] != "")
				return true;
			else
				return Utils::get_curr()->has_role("classruk");
		}

		protected function get_data(array $args): array {
			$class_name = $args[1] ?? Utils::curr_teacher()->get_role_arg("classruk");
			
			if (!$this->class_exists($class_name))
				Route::not_found();

			[$class, $sum] = $this->get_sum_class($class_name);

			return [
				"group" => $class_name,
				"points" => [
					"count" => $sum,
					"noun" => Utils::get_points_case($sum)
				],
				"students" => $class,
			];
		}

		private function class_exists(string $class): bool {
			if (strpos($class, "-") === false)
				return false;

			[$class_num, $class_lit] = explode("-", $class);

			return Db::query_assoc("
				SELECT COUNT(*) AS COUNT
				FROM students
				WHERE
					CLASS_LIT = ?s AND
					CLASS_NUM = ?s
				", $class_lit, intval($class_num)
			)["COUNT"] > 0;
		}

		private function get_sum_class(string $class_name) {
			$class = [];
			$sum = 0;

			foreach ($this->get_students_in_class($class_name) as $student) {
				$class[] = $student;

				$sum += $student->get_points();
			}

			return [$class, $sum];
		}
		
		private function get_students_in_class(string $class_name): array {
			$class = [];

			[$class_num, $class_lit] = explode("-", $class_name);

			$r = Db::query("
				SELECT LOGIN
				FROM `students`
				WHERE
					CLASS_LIT = ?s AND
					CLASS_NUM = ?s
				ORDER BY
					FAMILY_NAME,
					GIVEN_NAME
				", $class_lit, $class_num
			);

			foreach ($r as $st) {
				$student = Users::get($st["LOGIN"]);
				$class[] = $student;
			}

			return $class;
		}
	}
?>
