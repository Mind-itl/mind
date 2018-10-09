<?php
	require_once LIBS."music.php";

	class Internat_control extends Control {
		public function has_access(array $args): bool {
			return is_logined() && (get_curr()->is_student() || get_curr()->has_role("vospit"));
		}

		public function get_data(array $args): array {
			if (isset_post_fields("song-singer", "song-name"))
				add_music($_POST["song-singer"], $_POST["song-name"], get_curr());	

			return [
				"vospits" => $this->get_vospits()
			];
		}

		public function get_vospits(): array {
			$today = (new DateTime())->format('l');

			$r = safe_query("SELECT * FROM dutes WHERE DAY=?s", $today);

			$ret = [];
			foreach ($r as $v) {
				$ret[] = [
					"login" => $v["LOGIN"],
					"block" => $v["BLOCK"]
				];
			}

			return $ret;
		}
	}
?>
