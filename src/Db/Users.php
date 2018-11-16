<?php
	namespace Mind\Db;

	use Mind\Users\{User, Teacher, Student};

	class Users {
		public static function get_assoc(string $table, string $login): array {
			$r = Db::query_assoc("
				SELECT * FROM `$table` WHERE `LOGIN` = ?s
				", $login
			);

			$rr = Db::query_assoc("
				SELECT * FROM passwords WHERE LOGIN = ?s
				", $login
			);

			$r["ENTER_LOGIN"] = $rr["ENTER_LOGIN"];
			return $r;
		}

		public static function get(string $login, bool $is_enter_login=false): User {
			$login_field = $is_enter_login ? "ENTER_LOGIN" : "LOGIN";

			$r = Db::query_assoc("
				SELECT *
				FROM `passwords`
				WHERE `$login_field` = ?s
				", $login
			);

			$role = $r["ROLE"];
			$login = $r["LOGIN"];

			$user = null;

			if ($role == "teacher")
				$user = new Teacher($login);
			elseif ($role == "student")
				$user = new Student($login);

			return $user;
		}

		public static function has_login(string $login, bool $is_enter_login=false): bool {
			$login_field = $is_enter_login ? "ENTER_LOGIN" : "LOGIN";

			$r = Db::query("
				SELECT *
				FROM `passwords`
				WHERE `$login_field` = ?s
				", $login
			);

			return $r->num_rows != 0;
		}
	}

?>
