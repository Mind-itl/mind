<?php
	class Status_model {
		public static function get_status_types(): array {
			$r = safe_query_assoc("
				SELECT COLUMN_TYPE
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE 
					TABLE_NAME = 'student_status' AND 
					COLUMN_NAME = 'STATUS'
				"
			)["COLUMN_TYPE"];

			$r = substr($r, 5);
			$r = substr($r, 0, strlen($r)-1);

			$r = explode(',',$r);
			foreach ($r as &$q) {
				$q = substr($q, 1);
				$q = substr($q, 0, strlen($q)-1);
			}

			return $r;
		}
		
		public static function get_classes(): array {
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

		public static function set_status(Student $user, string $status): void {
			$login = $user->get_login();
			if (safe_query("SELECT * FROM student_status WHERE LOGIN=?s", $login)->num_rows != 0) {
				safe_query("UPDATE student_status SET STATUS=?s, DATA=CURRENT_TIMESTAMP() WHERE LOGIN=?s", $status, $login);
				return;
			}

			safe_query("INSERT INTO student_status (LOGIN, STATUS) VALUES (?s, ?s)", $login, $status);
		}

		public static function get_students_by_classes() {
			$ret = [];
			foreach (static::get_classes() as $class) {
				$students = [];

				$r = safe_query(
					"SELECT LOGIN FROM students WHERE CLASS_NUM=?i AND CLASS_LIT=?s",
					intval($class[0]),
					$class[1]
				);

				foreach ($r as $i) {
					$login = $i["LOGIN"];
					$r = safe_query("SELECT STATUS FROM student_status WHERE LOGIN=?s", $login);

					if ($r = $r->fetch_assoc())
						$status = $r['STATUS'];
					else
						$status = "hz";

					$students[] = [
						"names" => get_user($login)->get_names(),
						"login" => $login,
						"status" => $status
					];
				}

				$ret[] = [
					"name" => $class[0].'-'.$class[1],
					"students" => $students
				];
			}

			return $ret;
		}
	}
?>
