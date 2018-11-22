<?php
	namespace Mind\Db;

	use Mind\Users\{User, Teacher, Student};
	use Mind\Server\Utils;

	class Votings {
		private $title, $desc, $till, $id;

		public function __construct(int $id) {
			$a = Db::query_assoc("
				SELECT *
				FROM votings
				WHERE ID=?i
				", $id
			);

			$this->title = $a["TITLE"];
			$this->desc = $a["DESCRIPTION"];
			$this->id = $id;
		}

		public function get_variants(): array {
			$ret = [];

			$r = Db::query("
				SELECT *
				FROM voting_variants
				WHERE VOTING_ID = ?i
				", $this->id
			);

			foreach ($r as $v) {
				$id = intval($v["VARIANT_ID"]);
				$count = $this->get_variant_votes_count($id);

				$ret[] = [
					"id" => $id,
					"title" => $v["TITLE"],
					"count" => $count
				]
			}

			return $ret;
		}

		public function get_variant_votes_count(int $var_id): int {
			return intval(
				Db::query_assoc("
					SELECT COUNT(*) AS COUNT
					FROM votes
					WHERE
						VOTING_ID = ?i AND
						VARIANT_ID = ?i 
					", $this->id, $var_id
				)["COUNT"]
			);
		}

		public function add_variant(string $str): void {
			$last_var_id = Db::query_assoc("
				SELECT VARIANT_ID
				FROM voting_variants
				WHERE VOTING_ID = ?i
				ORDER BY VARIANT_ID DESC
				LIMIT 1
				", $this->id
			)["VARIANT_ID"];
			$last_var_id = intval($last_var_id);

			Db::query("
				INSERT INTO voting_variants (
					VOTING_ID, VARIANT_ID, TITLE
				) VALUES (
					?i, ?i, ?s
				)", $this->id, $last_var_id+1, $str
			);
		}

		public static function create(string $title, string $desc, \DateTime $till, array $variants): Voting {
			$id = Db::query_assoc("
				INSERT INTO votings (
					TITLE, DESCRIPTION, TILL_DATE
				) VALUES (
					?s, ?s, ?i
				);

				SELECT LAST_INSERT_ID() as ID FROM votings;
				", $title, $desc, $till->format('U')
			)["ID"];

			$v = static::get($id);

			foreach ($variants as $var) {
				$v->add_variant($var);
			}

			return $v;
		}

		public static function get(int $id): Voting {
			return new Voting($id);
		}
	}
?>
