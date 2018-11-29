<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};
	use Mind\Db\Votings\{Variant, Voting};

	class Create_voting extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined() && Utils::get_curr()->has_role("zam");
		}

		protected function get_data(array $args): array {
			if (Utils::isset_post_fields("title", "desc", "till", "variants")) {
				$title = trim($_POST["title"]);
				$desc = trim($_POST["desc"]);
				$till = new \DateTime($_POST['till']);

				$variants = explode(";", $_POST["variants"]);

				foreach ($variants as &$var) {
					$var = trim($var);
				}

				$id = Voting::create($title, $desc, $till, $variants)->get_id();
			
				$link = "/voting/$id";
				Utils::redirect($link);
			}

			return [
				"res_link" => $link ?? null
			];
		}
	}
?>
