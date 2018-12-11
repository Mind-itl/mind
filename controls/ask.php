<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Transactions};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	require_once Utils::ROOT."causes.php";

	class Ask extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		protected function get_data(array $args): array {
			if (Utils::isset_post_fields("question")) {
				$question = $_POST["question"];

				Db::query("
					INSERT INTO questions (
						LOGIN, QUESTION
					) VALUES (
						?s, ?s
					)", Utils::get_curr()->get_login(), $question
				);

				$result = "success";
			}

			if (Utils::isset_post_fields("remove_id")) {
				$id = intval($_POST["remove_id"]);
				Db::query("
					DELETE FROM questions
					WHERE ID = ?i
					", $id
				);
			}

			$r = Db::query("
				SELECT * FROM questions
				ORDER BY TIME
				LIMIT 10
			");

			$qs = [];

			foreach ($r as $q) {
				$qq = [
					"time" => new \DateTime($q["TIME"]),
					"text" => $q["QUESTION"],
					"from" => Users::get($q["LOGIN"]),
					"answered" => isset($q["ANSWERER"]),
					"id" => $q["ID"]
				];

				if ($qq["answered"]) {
					$qq["answer"] = $q["ANSWER"];
					$qq["answerer"] = Users::get($q["ANSWERER_LOGIN"]);
				}

				$qs[] = $qq;
			}

			$can_answer =
				Utils::get_curr()->has_role("zam") ||
				Utils::get_curr()->has_role("diric") ||
				Utils::get_curr()->has_role("president") ||
				Utils::get_curr()->has_role("secretar");

			$can_remove = $can_answer;

			return [
				"questions" => $qs,
				"result" => $result ?? "none",
				"can_remove" => $can_remove,
				"can_answer" => $can_answer
			];
		}
	}
?>
