<?php
	declare(strict_types=1);
	
	require_once LIBS."User.php";
	require_once LIBS."utils.php";

	// function parse_roles(string $roles_raw): array {
	// 	$roles = [];
	// 	$args = [];

	// 	foreach (explode(",", $roles_raw) as $role) {
	// 		if (preg_match("/(.+)\((.+)\)/", $role, $matches)) {
	// 			$roles[] = $matches[1];
	// 			$args[$matches[1]] = $matches[2];
	// 		} else {
	// 			$roles[] = $role;
	// 		}
	// 	}

	// 	return [$roles, $args];
	// }
	
	class Teacher extends User {
		/*
			array of enum {
				diric, classruk(class), vospit(class), zam, admin, predmet(subject)
			}
		*/
		private $roles;
		private $role_args;

		private function download_from_bd() {
			$st_assoc = assoc_user("teachers", $this->login);

			$this->given_name = $st_assoc["GIVEN_NAME"];
			$this->family_name = $st_assoc["FAMILY_NAME"];
			$this->father_name = $st_assoc["FATHER_NAME"];

			$this->enter_login = $st_assoc["ENTER_LOGIN"];

			$r = safe_query("
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
		}
		
		private function upload_to_bd() {

		}

		public function __construct(string $login, $load = true) {
			$this->login = $login;

			if ($load)
				$this->download_from_bd();
		}

		public function __destruct() {

		}

		public function has_role(string $role): bool {
			if ($role == "teacher")
				return true;

			return in_array($role, $this->roles); 
		}

		public function get_role_arg(string $role): string {
			if (isset($this->role_args[$role]))
				return $this->role_args[$role];
			return null;
		}

		public function give_points(string $to_login, string $cause): bool {
			if (!has_cause($cause))
				return false;

			$points = get_cause_price($cause);
			return add_transaction($this->login, $to_login, $points, $cause);
		}

		public function get_children(): array {
			$ret = [];

			if ($this->has_role("classruk")) {
				$class = [];

				list($class_num, $class_lit) = explode("-", $this->get_role_arg("classruk"));

				$r = safe_query("
					SELECT LOGIN
					FROM `students`
					WHERE
						CLASS_LIT = ?s AND
						CLASS_NUM = ?s
					", $class_lit, $class_num
				);
				foreach ($r as $st) {
					$student = get_user($st["LOGIN"], "student");
					$class[] = $student;
				}

				$ret = $class;
			}

			return $ret;
		}

		public function get_roles(): array {
			return $this->roles;
		}
	}
?>
