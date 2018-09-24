<?php
	require_once LIBS."music.php";

	class Internat_control extends Control {
		public function has_access(array $args): bool {
			return get_curr()->is_student();
		}

		public function get_data(array $args): array {
			return [
				"musics" => get_music(),
				"user_vote_id" => get_music_vote(get_curr())
			];
		}
	}
?>
