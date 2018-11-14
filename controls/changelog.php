<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Changelog extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		protected function get_data(array $args): array {
			return [
				"changelog" => file_get_contents(Utils::ROOT."CHANGELOG.md")
			];
		}
	}
?>
