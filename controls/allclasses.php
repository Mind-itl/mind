<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Allclasses extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined() && (
				Utils::get_curr()->has_role("zam") ||
				Utils::get_curr()->has_role("pedorg") ||
				Utils::get_curr()->has_role("diric")
			);
		}

		public function get_data(array $args): array {
			[$arr, $sum] = $this->get_points_by_classes();
			return [
				"points_by_classes" => $arr,
				"sum" => $sum
			];
		}

		public function get_points_by_classes(): array {
			$arr = [];
			$ssum = 0;
			foreach ($this->get_classes() as $class) {
				[$students, $sum] = $this->get_points_by_students(...$class);

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

			$r = Db::query("
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

			$r = Db::query("
				SELECT * FROM students
				WHERE
					CLASS_LIT=?s AND
					CLASS_NUM=?i
				ORDER BY
					FAMILY_NAME,
					GIVEN_NAME
				", $class_lit, $class_num
			);

			$sum = 0;
			
			foreach ($r as $i) {
				$user = Users::get($i["LOGIN"]);

				if (!($user instanceof Student))
					continue;

				$students[] = $user;
				$sum += $user->get_points();
			}

			return [$students, $sum];
		} 
	}
?>
