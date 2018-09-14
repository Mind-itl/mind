<?
 	function add_notification(User $user, string $message) {
 		$login = $user->get_login();
 		sql_query(
 			"INSERT INTO notifications (
 				TO_USER,
 				MESSAGE,
 				READED
 			) VALUES (
				'$login',
				'$message',
				FALSE
			)"
		);
 	}

 	function get_notifications(User $user): array {
 		$login = $user->get_login();
 		$s = sql_query(
 			"SELECT
 				DATE_FORMAT(TIME, '%H:%i %d.%m.%y') AS NTIME,
 				MESSAGE,
 				READED,
 				ID
 			FROM notifications
 			WHERE TO_USER='$login'
 			ORDER BY TIME DESC"
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