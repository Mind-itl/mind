<?php
	namespace Mind\Db;

	use Mind\Users\{User, Teacher, Student};
	use Mind\Server\Utils;

	class Passwords {
		public static function hash_password(string $pass): string {
			return md5(md5("}2sa(<@!".$pass));
		}

		public static function has_login(string $login): bool {
			$r = Db::query("
				SELECT *
				FROM `passwords`
				WHERE `LOGIN` = ?s
				", $login
			);

			return $r->num_rows != 0;
		}

		public static function check_password(string $login, string $pass, bool $is_enter_login=true): ?User {
			$hash = static::hash_password($pass);

			$login_field = $is_enter_login ? "ENTER_LOGIN" : "LOGIN";

			$user = Db::query("
				SELECT *
				FROM `passwords`
				WHERE `$login_field` = ?s
				", $login
			);

			if ($user->num_rows == 0)
				return null;

			$user = $user->fetch_assoc();

			if ($user['HASH'] == $hash && isset($user['LOGIN']))
				return Users::get($user['LOGIN']);
			else
				return null;
		}

		public static function enter_user(string $login, string $pass): bool {
			if ($user = static::check_password($login, $pass)) {
				$_SESSION["login"] = $user->get_login();
				$_SESSION["role"] = $user instanceof Student ? "student" : "teacher";
				return true;
			}
			return false;
		}

		public static function register_user(string $login, string $pass, string $role): bool {
			if ($role != "student" && $role != "teacher")
				return false;

			$hash = static::hash_password($pass);

			Db::query("
				INSERT INTO `passwords` (
					`LOGIN`,
					`HASH`,
					`ROLE`,
					`ENTER_LOGIN`
				) VALUES (?s, ?s, ?s, ?s)
				", $login, $hash, $role, $login
			);

			return true;
		}

		public static function change_password(string $login, string $old_password, string $new_password): bool {
			if (!static::check_password($login, $old_password, false))
				return false;

			Db::query("
				UPDATE passwords
				SET HASH = ?s
				WHERE LOGIN = ?s
				", static::hash_password($new_password), Utils::get_curr()->get_login()
			);

			return true;
		}

		public static function change_enter_login(User $user, string $new_login): bool {
			$r = Db::query("
				SELECT * FROM passwords WHERE ENTER_LOGIN=?s
				", $new_login
			);

			if ($r->num_rows != 0)
				return false;

			Db::query("
				UPDATE passwords SET ENTER_LOGIN=?s WHERE LOGIN=?s
				", $new_login, $user->get_login()
			);

			return true;
		}
	}
?>
