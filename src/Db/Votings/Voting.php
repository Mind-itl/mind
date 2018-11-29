<?php
	namespace Mind\Db\Votings;

	use Mind\Db\Db;
	use Mind\Users\{User, Teacher, Student};
	use Mind\Server\Utils;

	class Voting {
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

		/**
		 * @return array<Variant>
		*/
		public function get_variants(): array {
			$ret = [];

			$r = Db::query("
				SELECT *
				FROM voting_variants
				WHERE VOTING_ID = ?i
				", $this->id
			);

			foreach ($r as $v)
				$ret[] = new Variant($this, intval($v["VARIANT_ID"]));

			return $ret;
		}

		public function vote(User $user, Variant $var): void {
			assert($var->get_voting()->get_id() === $this->id);

			if ($this->get_vote_variant($user))
				$this->unvote($user);

			Db::query("
				INSERT INTO votes (
					LOGIN, VOTING_ID, VARIANT_ID
				) VALUES (
					?s, ?i, ?i
				)
				", $user->get_login(), $this->id, $var->get_id()
			);
		}

		public function unvote(User $user): void {
			Db::query("
				DELETE FROM votes
				WHERE
					VOTING_ID = ?i AND
					LOGIN = ?s
				", $this->id, $user->get_login()
			);
		}

		public function get_vote_variant(User $user): ?Variant {
			$r = Db::query("
				SELECT VARIANT_ID
				FROM votes
				WHERE
					VOTING_ID = ?i AND
					LOGIN = ?s
				", $this->id, $user->get_login()
			);

			if ($r->num_rows === 0)
				return null;

			$id = $r->fetch_assoc()["VARIANT_ID"];
			return new Variant($this, $id);
		}

		public function get_id(): int {
			return $this->id;
		}
		public function get_title(): string {
			return $this->title;
		}
		public function get_description(): string {
			return $this->desc;
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

		/**
		 * @param array<string> $variants
		*/
		public static function create(string $title, string $desc, \DateTime $till, array $variants): Voting {
			Db::query("
				INSERT INTO votings (
					TITLE, DESCRIPTION, TILL_DATE
				) VALUES (
					?s, ?s, ?i
				)
				", $title, $desc, $till->format('U')
			);

			$id = Db::query_assoc("
				SELECT ID
				FROM votings
				ORDER BY ID DESC
				LIMIT 1
			")["ID"];

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
