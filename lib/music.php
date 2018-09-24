<?php
	function get_music() {
		$music = [];

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
			];

		}

		return $music;
	}
?>
