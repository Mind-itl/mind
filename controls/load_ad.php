<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	const BANNERS = Utils::ROOT."public_html/banners/";

	class Load_ad extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined() && Utils::get_curr()->has_role("zam");
		}

		protected function get_data(array $args): array {
			if (
				Utils::isset_post_fields(
					"url", "title", "from_date", "until_date"
				) &&
				isset($_FILES['img'])
			) {
				$last_id = Db::query_assoc("
					SELECT ID
					FROM ads
					ORDER BY ID DESC
					LIMIT 1"
				)["ID"];

				$last_id = intval($last_id);
				$last_id++;

				if (!file_exists(BANNERS)) {
					mkdir(BANNERS, 0777, true);
				}

				$ext = pathinfo($_FILES['img']['name'])["extension"];

				if (!in_array($ext, ["jpg", "png", "gif", "jpeg"])) {
					return [
						"result" => "error"
					];
				}

				move_uploaded_file($_FILES['img']['tmp_name'], BANNERS."$last_id.$ext");

				Db::query("
					INSERT INTO ads (
						IMG_PATH, LINK, FROM_DATE, TILL_DATE, ALT
					) VALUES (
						?s, ?s, ?s, ?s, ?s
					)", "/banners/$last_id.$ext", $_POST["url"], $_POST["from_date"], $_POST["until_date"], $_POST["title"]
				);
			}

			return [
				"result" => $result ?? "",
			];
		}
	}
?>
