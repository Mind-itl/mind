<?php
	declare(strict_types=1);

	require_once LIBS."db.php";

	function hash_password(string $pass): string {
		return md5(md5("}2sa(<@!".$pass));
	}

	function has_login(string $login): bool {
		$r = safe_query("
			SELECT *
			FROM `passwords`
			WHERE `LOGIN` = ?s
			", $login
		);

		return $r->num_rows != 0;
	}

	function check_password(string $login, string $pass): User {
		$hash = hash_password($pass);
		$user = safe_query_assoc("
			SELECT *
			FROM `passwords`
			WHERE `ENTER_LOGIN` = ?s
			", $login
		);

		if ($user['HASH'] == $hash)
			return get_user($user['LOGIN']);
		else
			return false;
	}

	function enter_user(string $login, string $pass): bool {
		if ($user = check_password($login, $pass)) {
			$_SESSION["login"] = $user->get_login();
			$_SESSION["role"] = $user->is_student() ? "student" : "teacher";
			return true;
		}
		return false;
	}

	function register_user(string $login, string $pass, string $role): bool {
		if ($role != "student" && $role != "teacher")
			return false;

		$hash = hash_password($pass);

		safe_query("
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

	function change_password(string $login, string $old_password, string $new_password): bool {
		if (!check_password($login, $old_password))
			return false;

		safe_query("
			UPDATE passwords
			SET HASH = ?s
			WHERE LOGIN = ?s
			", hash_password($new_password), get_curr()->get_login()
		);

		return true;
	}
?>
