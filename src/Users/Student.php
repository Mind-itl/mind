<?php
	declare(strict_types=1);

	namespace Mind\Users;

	use Mind\Db\{Users, Causes, Db, Transactions};	

	class Student extends User {
		/**
		 * @var string $class_num
		 * @var string $class_lit
		 */
		private $class_num, $class_lit;

		private function download_from_bd() {
			$st_assoc = Users::get_assoc("students", $this->login);
			
			$this->given_name = $st_assoc["GIVEN_NAME"];
			$this->family_name = $st_assoc["FAMILY_NAME"];			
			$this->father_name = $st_assoc["FATHER_NAME"];

			$this->email = $st_assoc["EMAIL"];

			$this->class_num = $st_assoc["CLASS_NUM"];
			$this->class_lit = $st_assoc["CLASS_LIT"];

			$this->enter_login = $st_assoc["ENTER_LOGIN"];

			$r = Db::query("
				SELECT ROLE, ARG
				FROM teacher_roles
				WHERE LOGIN = ?s
			", $this->login);

			$this->roles = [];
			$this->role_args = [];

			foreach ($r as $role) {
				$this->roles[] = $role["ROLE"];
				$this->role_args[$role["ROLE"]] = $role["ARG"];
			}

			$this->roles[] = "student";
		}

		private function upload_to_bd() {

		}	

		public function __construct(string $login, bool $load = true) {
			$this->login = $login;

			if ($load)
				$this->download_from_bd();
		}

		public function __destruct() {

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

		public function add_points(User $from, int $points, string $cause): bool {
			return Transactions::add($from, $this, $points, $cause);
		}

		public function get_transactions(): array {
			return Transactions::of_student($this);
		}

		public function get_class(string $format="num-lit"): string {
			$search = array("num", "lit");
			$replace = array($this->class_num, $this->class_lit);

			return str_replace($search, $replace, $format);
		}

		public function give_points(User $to, int $points): bool {
			return Transactions::add($this, $to, $points, "C");
		}

		public function get_classruk(): ?Teacher {
			$r = Db::query("
				SELECT LOGIN
				FROM teacher_roles
				WHERE
					ROLE = 'classruk' AND
					ARG = ?s
				", $this->get_class()
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
