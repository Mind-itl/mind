<?php
	require_once LIBS."music.php";

	class Internat_control extends Control {
		public function has_access(array $args): bool {
			return is_logined() && get_curr()->is_student();
		}

		public function get_data(array $args): array {
			if (isset_post_fields("performer", "title"))
				add_music($_POST["performer"], $_POST["title"], get_curr());	

			return [];
		}
	}
?>
