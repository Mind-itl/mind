<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json, Music};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Internat extends Control {
		public function has_access(array $args): bool {
			return
				Utils::is_logined() && (
					Utils::get_curr() instanceof Student ||
					Utils::get_curr()->has_role("vospit")
				);
		}

		public function get_data(array $args): array {
			if (Utils::isset_post_fields("song-singer", "song-name"))
				Music::add($_POST["song-singer"], $_POST["song-name"], Utils::get_curr());	

			return [
				"vospits" => $this->get_vospits()
			];
		}

		public function get_vospits(): array {
			$today = (new \DateTime())->format('l');

			$r = Db::query("SELECT * FROM dutes WHERE DAY=?s", $today);

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
