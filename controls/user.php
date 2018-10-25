<?php
	class User_control extends Control {
		public function has_access(array $args): bool {
			return is_logined();
		}

		protected function get_data(array $args): array {
			if (isset($args[1]) && $args[1]!="")
				$user = get_user($args[1]);
			else 
				$user = get_curr();

			return [
				"he" => $user
			];
		}
	}
?>
