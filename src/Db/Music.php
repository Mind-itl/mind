<?php
	namespace Mind\Db;

	use Mind\Users\{User, Teacher, Student};
	use Mind\Server\Utils;

	class Music {
		public static function get() {
			$music = [];

			if (Utils::is_logined())
				$cid = static::get_vote(Utils::get_curr());
			else
				$cid = -1;

			$r = Db::query("SELECT * FROM music");
			foreach ($r as $v) {
				$id = $v["ID"];

				$votes_count = Db::query("
					SELECT COUNT(*) AS COUNT
					FROM music_votes
					WHERE ID=?i
					", $id
				)->fetch_assoc()["COUNT"];


				$music[] = [
					"title" => $v["TITLE"],
					"performer" => $v["PERFORMER"],
					"votes_count" => $votes_count,
					"id" => $v["ID"],
					"student_vote_this" => ($v["ID"] == $cid)
				];

			}

			return $music;
		}

		public static function get_vote(User $user): int {
			$r = Db::query("
				SELECT * FROM music_votes WHERE LOGIN=?s
				", $user->get_login()
			);

			if ($r = $r->fetch_assoc())
				return $r["ID"];

			return -1;
		}

		public static function add_vote(User $user, int $id) {
			Db::query("
				INSERT INTO music_votes (LOGIN, ID) VALUES (?s, ?i)
				", $user->get_login(), $id
			);
		}

		public static function remove_vote(User $user) {
			Db::query("DELETE FROM music_votes WHERE LOGIN=?s", $user->get_login());
		}

		public static function add(string $performer, string $title, User $from) {
			Db::query("
				INSERT INTO music (
					PERFORMER, TITLE, LOGIN
				) VALUES (
					?s, ?s, ?s
				)", $performer, $title, $from->get_login()
			);
		}

		public static function remove(int $id) {
			Db::query("
				DELETE FROM music
				WHERE ID = ?i
				", $id
			);
			Db::query("
				DELETE FROM music_votes
				WHERE ID = ?i
				", $id
			);
		}
	}
?>
