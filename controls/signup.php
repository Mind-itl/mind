<?php
	require_once 'passwords.php';

	class Signup_control extends Control {
		private static $post_fields = [
			"login", "password", "sname", "name", "fname", "bday"
		];

		public function __construct() {
			parent::__construct("signup");
		}

		public function has_access(array $args): bool {
			return !is_logined();
		}

		protected function get_data(array $args): array {
			if (isset_post_fields(...static::$post_fields)) {
				$this->post();
			}

			return [
				"CLASSES" => $this->get_classes()
			];
		}

		private function get_classes(): string {
			$q = sql_query("SELECT DISTINCT(CLASS) AS CLASS FROM lessons");
			$r = [];

			foreach ($q as $v) {
				$r[] = $v["CLASS"];
			}

			return json_encode($r);
		}

		private function post() {
			$user = $_POST;

			$login = $user["login"];
			$password = $user["password"];
			$role = $user["role"];

			$name = $user["name"];
			$fname = $user["fname"];
			$sname = $user["sname"];

			$bday = $user["bday"];
			$class = $user["class"] ?? "";

			list($class_num, $class_lit) = explode('-', $class);

			register_user($user["login"], $user["password"], $user["role"]);
			if ($user["role"] == "teacher") {
				sql_query("
					INSERT INTO teachers (
						GIVEN_NAME, FAMILY_NAME, FATHER_NAME, ROLE, LOGIN, BIRTHDAY
					) VALUES (
						'$name', '$sname', '$fname', '', '$login', '$bday'
					)
				");
			} else {
				sql_query("
					INSERT INTO students (
						GIVEN_NAME, FAMILY_NAME, FATHER_NAME, LOGIN, CLASS_NUM, CLASS_LIT, BIRTHDAY
					) VALUES (
						'$name', '$sname', '$fname', '$login', $class_num, $class_lit, '$bday'
					)
				");
			}

			enter_user($login, $password);

			redirect("/");
		}
	}
?>	