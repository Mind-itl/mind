<?php
	declare(strict_types=1);

	namespace Mind\Users;

	use Mind\Db\{Users, Causes, Db, Transactions};	

	class Student extends User {
		/**
		 * @var int $group_num
		 * @var string $group_lit
		 */
		private $group_num, $group_lit;

		public function __construct(string $login) {
			$this->login = $login;

			$st_assoc = Users::get_assoc("students", $this->login);
			$this->from_assoc($st_assoc);

			$this->group_num = intval($st_assoc["CLASS_NUM"]);
			$this->group_lit = $st_assoc["CLASS_LIT"];

			if (!in_array("student", $this->roles))
				$this->roles[] = "student";
		}

		public function get_points(): int {
			$got_points = Db::query_assoc("
				SELECT SUM(POINTS) AS SUM
				FROM transactions
				WHERE TO_LOGIN = ?s
			", $this->login)["SUM"] ?? 0;	
			
			$given_points = Db::query_assoc("
				SELECT SUM(`POINTS`) AS SUM
				FROM `transactions`
				WHERE `FROM_LOGIN`= ?s
			", $this->login)["SUM"] ?? 0;

			return $got_points - $given_points;
		}

		public function get_group_name(string $format="num-lit"): string {
			$search = array("num", "lit");
			$replace = array($this->group_num, $this->group_lit);

			return str_replace($search, $replace, $format);
		}

		public function get_classruk(): ?Teacher {
			$r = Db::query("
				SELECT LOGIN
				FROM teacher_roles
				WHERE
					ROLE = 'classruk' AND
					ARG = ?s
				", $this->get_group_name()
			);

			$clruk = null;

			if ($a = $r->fetch_assoc()) {
				$clruk = Users::get($a["LOGIN"]);
			}

			if (!($clruk instanceof Teacher)) {
				return null;
			}

			return $clruk;
		}
	}
?>
