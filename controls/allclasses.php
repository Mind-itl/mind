<?php
	class Allclasses_control extends Control {
		// public function has_access(array $args): bool {
		// 	return is_logined() && get_curr()->has_role("zam");
		// }

		public function get_data(array $args): array {
			list($arr, $sum) = $this->get_points_by_classes();
			return [
				"points_by_classes" => $arr,
				"sum" => $sum
			];
		}

		public function get_points_by_classes(): array {
			$arr = [];
			$ssum = 0;
			foreach ($this->get_classes() as $class) {
				list($students, $sum) = $this->get_points_by_students(...$class);

				$ssum += $sum;

				$arr[] = [
					"class_name" => $class[0].'-'.$class[1],
					"points_by_students" => $students,
					"sum" => $sum
				];
			}

			return [$arr, $ssum];
		}

		public function get_classes(): array {
			$classes = [];

			$r = safe_query("
				SELECT
					CLASS_NUM, CLASS_LIT
				FROM students
				GROUP BY
					CLASS_NUM, CLASS_LIT
			");
			foreach ($r as $i) {
				$classes[] = [$i["CLASS_NUM"],$i["CLASS_LIT"]];
			}

			return $classes;
		}

		public function get_points_by_students(string $class_num, string $class_lit): array {
			$students = [];

			$r = safe_query("
				SELECT * FROM students
				WHERE
					CLASS_LIT=?s AND
					CLASS_NUM=?i
				ORDER BY CLASS_NUM, CLASS_LIT
				", $class_lit, $class_num
			);

			$sum = 0;
			
			foreach ($r as $i) {
				$user = get_user($i["LOGIN"]);
				$students[] = $user;
				$sum  += $user->get_points();
			}


			return [$students, $sum];
		} 
	}
?>
