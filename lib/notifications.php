<?php
	function add_notification(User $to_user, User $from_user, string $message, int $points = -1) {		
		if ($points == -1)
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
		else
			safe_query(
				"INSERT INTO notifications (
					TO_USER,
					FROM_USER,
					MESSAGE,
					POINTS,
					READED
				) VALUES (
					?s, ?s, ?s, ?i, FALSE
				)",
				$to_user->get_login(),
				$from_user->get_login(),
				$message,
				$points
			);
	}

	function get_notifications(User $user): array {
		$login = $user->get_login();
		$s = safe_query(
			"SELECT
				TIME,
				MESSAGE,
				READED,
				FROM_USER,
				POINTS,
				ID
			FROM notifications
			WHERE TO_USER = ?s
			ORDER BY TIME DESC
			", $login
		);

		$nots = [];
		foreach ($s as $v) {
			$usr = get_user($v["FROM_USER"]);
			$nots[] = [
				"date" => $v["TIME"],
				"message" => $v["MESSAGE"],
				"read" => $v["READED"],
				"id" => $v["ID"],
				"from" => $usr,
				"points" => intval($v["POINTS"])
			];
		}

		return $nots;
	}
?>
