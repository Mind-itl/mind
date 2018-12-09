<?php
	declare(strict_types=1);
	
	namespace Mind\Users;
	
	use Mind\Db\{Users, Causes, Db, Transactions};

	class Teacher extends User {
		private function download_from_bd() {
			$st_assoc = Users::get_assoc("teachers", $this->login);

			$this->given_name = $st_assoc["GIVEN_NAME"];
			$this->family_name = $st_assoc["FAMILY_NAME"];
			$this->father_name = $st_assoc["FATHER_NAME"];

			$this->email = $st_assoc["EMAIL"];

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

			$this->roles[] = "teacher";
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

		public function give_points(Student $to, string $cause): bool {
			if (!Causes::has($cause))
				return false;

			$points = Causes::get_price($cause);
			return Transactions::add($this, $to, $points, $cause);
		}

		public function get_children(): array {
			$ret = [];

			if ($this->has_role("classruk")) {
				$class = [];

				$group_name = $this->get_role_arg("classruk");
				if ($group_name !== null) {
					list($class_num, $class_lit) = explode("-", $group_name);

					$r = Db::query("
						SELECT LOGIN
						FROM `students`
						WHERE
							CLASS_LIT = ?s AND
							CLASS_NUM = ?s
						", $class_lit, $class_num
					);
					foreach ($r as $st) {
						$student = Users::get($st["LOGIN"]);
						$class[] = $student;
					}

					$ret = $class;
				}
			}

			return $ret;
		}
	}
?>
