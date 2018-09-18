<?php
	declare(strict_types=1);

	require_once LIBS."User.php";
	require_once LIBS."db.php";

	class Student extends User {
		private $class_num, $class_lit;

		private function download_from_bd() {
			$st_assoc = assoc_user("students", $this->login);
			
			$this->given_name = $st_assoc["GIVEN_NAME"];
			$this->family_name = $st_assoc["FAMILY_NAME"];			
			$this->father_name = $st_assoc["FATHER_NAME"];

			$this->class_num = $st_assoc["CLASS_NUM"];
			$this->class_lit = $st_assoc["CLASS_LIT"];
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

		public function has_role(string $role): bool {
			return $role=="student";
		}

		public function get_points(): int {
			return get_student_points($this->login);
		}

		public function add_points(string $from_login, int $points, string $cause): bool {
			return add_transaction($from_login, $this->login, $points, $cause);
		}

		public function get_transactions(): array {
			return get_student_transactions($this->login);
		}

		public function get_class(string $format="num-lit"): string {
			$search = array("num", "lit");
			$replace = array($this->class_num, $this->class_lit);

			return str_replace($search, $replace, $format);
		}

		public function give_points(string $to_login, int $points): bool {
			return add_transaction($this->login, $to_login, $points, "C");
		}
	}
?>
