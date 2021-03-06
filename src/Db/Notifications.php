<?php
	namespace Mind\Db;

	use Mind\Users\{User, Teacher, Student};

	class Notifications {
		static public function add(User $to_user, User $from_user, string $message, int $points = -1) {		
			if ($points == -1)
				Db::query(
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
				Db::query(
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

		static public function get(User $user): array {
			$login = $user->get_login();
			$s = Db::query(
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
				if (!Users::has_login($v["FROM_USER"])) {
					\Mind\Server\Log::info("No user: " . $v["FROM_USER"]);
					continue;
				}

				$usr = Users::get($v["FROM_USER"]);

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

		static public function read(int $id) {
			Db::query("
				UPDATE notifications
				SET READED=1
				WHERE ID=?i
				", $id
			);
		}
	}
?>
