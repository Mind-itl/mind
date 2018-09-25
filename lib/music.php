<?php
	function get_music() {
		$music = [];

		if (is_logined() && get_curr()->is_student())
			$cid = get_music_vote(get_curr());
		else
			$cid = -1;

		$r = safe_query("SELECT * FROM music");
		foreach ($r as $v) {
			$id = $v["ID"];

			$votes_count = safe_query("
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

	function get_music_vote(Student $student): int {
		$r = safe_query("
			SELECT * FROM music_votes WHERE LOGIN=?s
			", $student->get_login()
		);

		if ($r = $r->fetch_assoc())
			return $r["ID"];

		return -1;
	}

	function add_music_vote(Student $student, int $id) {
		safe_query("
			INSERT INTO music_votes (LOGIN, ID) VALUES (?s, ?i)
			", $student->get_login(), $id
		);
	}

	function remove_music_vote(Student $student) {
		safe_query("DELETE FROM music_votes WHERE LOGIN=?s", $student->get_login());
	}
?>
