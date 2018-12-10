<?php
	namespace Mind\Db;

	use Mind\Users\{User, Teacher, Student};

	class Users {
		/**
		 * @var array<string, array<string,User>>
		 */
		private static $_user_cache = [
			"ENTER_LOGIN" => [],
			"LOGIN" => []
		];

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

			if (isset(static::$_user_cache[$login_field][$login]))
				return static::$_user_cache[$login_field][$login];

			if (!static::has_login($login, $is_enter_login))
				throw new \Exception("No user with this login");

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
			else
				throw new \Exception("User has incorrect role");

			static::$_user_cache["ENTER_LOGIN"][$user->get_enter_login()] = $user;
			static::$_user_cache["LOGIN"][$user->get_login()] = $user;

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

		public static function student(string $login, bool $is_enter_login=false): Student {
			$user = static::get($login, $is_enter_login);

			if (!$user instanceof Student)
				throw new \Exception("No student with that login: $login");

			return $user;
		}

		public static function teacher(string $login, bool $is_enter_login=false): Teacher {
			$user = static::get($login, $is_enter_login);

			if (!$user instanceof Teacher)
				throw new \Exception("No teacher with that login: $login");

			return $user;
		}
	}

?>
