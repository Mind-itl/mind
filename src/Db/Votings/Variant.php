<?php
	namespace Mind\Db\Votings;

	use Mind\Db\Db;
	use Mind\Users\{User, Teacher, Student};
	use Mind\Server\Utils;

	class Variant {
		private $voting, $id, $title;

		public function __construct(Voting $voting, int $id) {
			$this->id = $id;
			$this->voting = $voting;

			$this->title = Db::query_assoc("
				SELECT TITLE
				FROM voting_variants
				WHERE
					VOTING_ID = ?i AND
					VARIANT_ID = ?i
				", $voting->get_id(), $id
			)["TITLE"];
		}

		public function get_voting(): Voting {
			return $this->voting;
		}

		public function voted_by(User $user): bool {
			return Db::query("
				SELECT *
				FROM votes
				WHERE
					VOTING_ID = ?i AND
					VARIANT_ID = ?i AND
					LOGIN = ?s
				", $this->voting->get_id(), $this->id, $user->get_login()
			)->num_rows > 0;
		}

		public function get_count(): int {
			return intval(
				Db::query_assoc("
					SELECT COUNT(*) AS COUNT
					FROM votes
					WHERE
						VOTING_ID = ?i AND
						VARIANT_ID = ?i 
					", $this->voting->get_id(), $this->id
				)["COUNT"]
			);
		}

		public function get_id(): int {
			return $this->id;
		}

		public function get_title(): string {
			return $this->title;
		}
	}
?>
