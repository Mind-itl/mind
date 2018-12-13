<?php
	namespace Mind\Db;

	use Mind\Users\{User, Teacher, Student};

	class Statuses {
		public static function get_types(): array {
			$r = Db::query_assoc("
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

		public static function set(Student $user, string $status): void {
			$login = $user->get_login();
			if (Db::query("SELECT * FROM student_status WHERE LOGIN=?s", $login)->num_rows != 0) {
				Db::query("UPDATE student_status SET STATUS=?s, DATA=CURRENT_TIMESTAMP() WHERE LOGIN=?s", $status, $login);
			} else {
				Db::query("INSERT INTO student_status (LOGIN, STATUS) VALUES (?s, ?s)", $login, $status);
			}
		}

		public static function get_students_by_classes() {
			$ret = [];
			foreach (static::get_classes() as $class) {
				$students = [];

				$r = Db::query(
					"SELECT LOGIN FROM students WHERE CLASS_NUM=?i AND CLASS_LIT=?s",
					intval($class[0]),
					$class[1]
				);

				foreach ($r as $i) {
					$login = $i["LOGIN"];
					$r = Db::query("SELECT * FROM student_status WHERE LOGIN=?s", $login);

					if ($r = $r->fetch_assoc()) {
						$status = $r['STATUS'];
						$time = $r["DATA"];
					} else {
						$time = "";
						$status = "неизвестно";
					}

					$students[] = [
						"person" => Users::get($login),
						"status" => $status,
						"time" => $time
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
