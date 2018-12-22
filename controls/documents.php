<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Documents extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		public function get_data(array $args): array {
			if (Utils::isset_post_fields("path","title") && isset($_FILES["file"]))
				$status = $this->add_protocol();

			$r = Db::query("
				SELECT * FROM files
				ORDER BY ID DESC
			");

			$files = [];

			foreach ($r as $p) {
				$files[] = [
					"title" => $p["TITLE"],
					"url" => "/files/" . $p["PATH"],
					"id" => intval($p["ID"])
				];
			}

			$can_edit =
				Utils::get_curr()->has_role("zam") ||
				Utils::get_curr()->has_role("president") ||
				Utils::get_curr()->has_role("secretar");

			return [
				"can_edit" => $can_edit,
				"files" => $files,
				"status" => $status ?? "notset",
				"link" => $link ?? ""
			];
		}

		private function add_protocol() {
			$path = trim($_POST["path"]);
			$title = trim($_POST["title"]);

			if (
				strpos($path, '/') !== false ||
				strpos($path, '\\') !== false
			)
				return "fail";

			$path = basename($path);

			$ext = pathinfo($path)["extension"] ?? "";
			if (!in_array($ext, ["pdf", "doc", "docx", "html"]))
				return ["fail", ""];

			$has_path = Db::query_assoc("
				SELECT COUNT(*) AS COUNT
				FROM files
				WHERE PATH = ?s
				", $path
			)["COUNT"] > 0;

			if ($has_path)
				return "already";

			Db::query("
				INSERT INTO files (
					PATH, TITLE
				) VALUES (
					?s, ?s
				)", $path, $title
			);

			if (!file_exists(Utils::ROOT."/public_html/files/")) {
				mkdir(Utils::ROOT."/public_html/files/", 0777, true);
			}

			move_uploaded_file($_FILES['file']['tmp_name'], Utils::ROOT."/public_html/files/$path");
			return "success";
		}
	}
?>
