<?php
	require_once LIBS.'passwords.php';

	class Signup_control extends Control {
		private static $post_fields = [
			"login", "password", "sname", "name", "fname"
		];

		public function has_access(array $args): bool {
			return !is_logined();
		}

		protected function get_data(array $args): array {
			if (isset_post_fields(...static::$post_fields)) {
				$status = $this->post();
			}

			return [
				"classes" => $this->get_classes(),
				"status" => $status ?? "not_stated"
			];
		}

		private function get_classes(): string {
			$q = safe_query("SELECT DISTINCT(CLASS) AS CLASS FROM lessons");
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

			if (get_user($login)) {
				return "already";
			}

			// $bday = $user["bday"];
			$class = $user["class"] ?? "";

			list($class_num, $class_lit) = explode('-', $class);

			register_user($login, $password, $role);
			if ($role == "teacher") {
				safe_query("
					INSERT INTO teachers (
						GIVEN_NAME, FAMILY_NAME, FATHER_NAME, LOGIN
					) VALUES (
						?s, ?s, ?s, ?s, ?s
					)", $name, $sname, $fname, $login
				);
			} else {
				safe_query("
					INSERT INTO students (
						GIVEN_NAME, FAMILY_NAME, FATHER_NAME, LOGIN, CLASS_NUM, CLASS_LIT
					) VALUES (
						?s, ?s, ?s, ?s, ?i, ?i
					)", $name, $sname, $fname, $login, $class_num, $class_lit
				);
				$user = get_user($login);
				if ($clruk = $user->get_classruk())
					add_notification($user, $clruk, "Ученик зарегистрировался");
			}

			enter_user($login, $password);

			redirect("/");
		}
	}
?>	
