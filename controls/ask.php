<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Transactions, Notifications};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	require_once Utils::ROOT."causes.php";

	class Ask extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		protected function get_data(array $args): array {
			if (Utils::isset_post_fields("question"))
				$this->add_question();

			if (Utils::isset_post_fields("remove_id"))
				$this->remove_question();

			if (Utils::isset_post_fields("answer", "id"))
				$this->answer_question();

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
					"answered" => isset($q["ANSWERER_LOGIN"]),
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

		private function add_question() {
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

		private function remove_question() {
			$id = intval($_POST["remove_id"]);

			Db::query("
				DELETE FROM questions
				WHERE ID = ?i
				", $id
			);
		}

		private function answer_question() {
			$answer = $_POST["answer"];
			$answer = trim($answer);

			$id = intval($_POST['id']);

			if ($answer === "") {
				Db::query("
					UPDATE questions
					SET
						ANSWER = NULL,
						ANSWERER_LOGIN = NULL
					WHERE ID = ?i
					", $id
				);				

				return;
			}

			Db::query("
				UPDATE questions
				SET
					ANSWER = ?s,
					ANSWERER_LOGIN = ?s
				WHERE ID = ?i
				", $answer, Utils::get_curr()->get_login(), $id
			);

			$from_user = Users::get(
				Db::query_assoc("
					SELECT LOGIN
					FROM questions
					WHERE ID = ?i
					", $id
				)["LOGIN"]
			);

			Notifications::add($from_user, Utils::get_curr(), "На ваш вопрос ответили");
		}
	}
?>
