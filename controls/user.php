<?php
	namespace Mind\Controls;

	use Mind\Db\Users;
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

			return [
				"he" => $user
			];
		}
	}
?>
