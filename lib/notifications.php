<?php
	function add_notification(User $to_user, User $from_user, string $message) {		
		safe_query(
			"INSERT INTO notifications (
				TO_USER,
				FROM_USER,
				MESSAGE,
				READED
			) VALUES (
				?s, ?s, ?s, FALSE
			)",
			$to_user->get_login(),
			$from_user->get_login(),
			$message
		);
	}

	function get_notifications(User $user): array {
		$login = $user->get_login();
		$s = safe_query(
			"SELECT
				DATE_FORMAT(TIME, '%H:%i %d.%m.%y') AS NTIME,
				MESSAGE,
				READED,
				FROM_USER,
				ID
			FROM notifications
			WHERE TO_USER = ?s
			ORDER BY TIME DESC
			", $login
		);

		$nots = [];
		foreach ($s as $v) {
			$usr = get_user($v["FROM_USER"])->get_names();
			$usr["is_student"] = get_user($v["FROM_USER"])->is_student();
			$nots[] = [
				"time" => $v["NTIME"],
				"message" => $v["MESSAGE"],
				"read" => $v["READED"],
				"id" => $v["ID"],
				"from" => $usr
			];
		}

		return $nots;
	}
?>
