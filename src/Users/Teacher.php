<?php
	declare(strict_types=1);
	
	namespace Mind\Users;
	
	use Mind\Db\{Users, Causes, Db, Transactions};

	class Teacher extends User {
		private function download_from_bd() {}

		public function __construct(string $login) {
			$this->login = $login;

			$st_assoc = Users::get_assoc("teachers", $this->login);
			$this->from_assoc($st_assoc);

			if (!in_array("teacher", $this->roles))
				$this->roles[] = "teacher";
		}

		public function get_children(): array {
			if (!$this->has_role("classruk"))
				return [];

			$group_name = $this->get_role_arg("classruk");
			if ($group_name === null || $group_name === "")
				return [];

			list($class_num, $class_lit) = explode("-", $group_name);

			$r = Db::query("
				SELECT LOGIN
				FROM `students`
				WHERE
					CLASS_LIT = ?s AND
					CLASS_NUM = ?s
				", $class_lit, $class_num
			);

			$group = [];
			foreach ($r as $st) {
				$student = Users::get($st["LOGIN"]);
				$group[] = $student;
			}

			return $group;
		}
	}
?>
