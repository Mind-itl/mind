<?php
 	function add_notification(User $user, string $message) {
 		$login = $user->get_login();
 		
 		safe_query(
 			"INSERT INTO notifications (
 				TO_USER,
 				MESSAGE,
 				READED
 			) VALUES (
				?s, ?s, FALSE
			)", $login, $message
		);
 	}

 	function get_notifications(User $user): array {
 		$login = $user->get_login();
 		$s = safe_query(
 			"SELECT
 				DATE_FORMAT(TIME, '%H:%i %d.%m.%y') AS NTIME,
 				MESSAGE,
 				READED,
 				ID
 			FROM notifications
 			WHERE TO_USER = ?s
 			ORDER BY TIME DESC
 			", $login
 		);

 		$nots = [];
 		foreach ($s as $v) {
 			$nots[] = [
 				"time" => $v["NTIME"],
 				"message" => $v["MESSAGE"],
 				"read" => $v["READED"],
 				"id" => $v["ID"]
 			];
 		}

 		return $nots;
 	}
?>
