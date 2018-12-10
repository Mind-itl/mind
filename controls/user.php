<?php
	namespace Mind\Controls;

	use Mind\Db\Users;
	use Mind\Users\Student;
	use Mind\Server\{Control, Utils, Route};

	class User extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		protected function get_data(array $args): array {
			if (isset($args[1]) && $args[1]!="") {
				if (Users::has_login($args[1], true))	
					$user = Users::get($args[1], true);
				else
					Route::not_found();
			}

			$user = $user ?? Utils::get_curr();


			$can_edit_role = false;

			if ($user instanceof Student) {
				$clruk = $user->get_classruk();
				if ($clruk !== null && Utils::get_curr()->has_role("classruk")) {
					$l = $clruk->get_login();
					$ll = Utils::get_curr()->get_login();
					$can_edit_role = $l == $ll;
				}
			}

			$can_edit_role = $can_edit_role || Utils::get_curr()->has_role("zam");

			return [
				"he" => $user,
				"can_edit_role" => $can_edit_role
			];
		}
	}
?>
