<?php
	class Changelog_control extends Control {
		public function has_access(array $args): bool {
			return is_logined();
		}

		protected function get_data(array $args): array {
			return [
				"changelog" => file_get_contents(ROOT."CHANGELOG.md")
			];
		}
	}
?>
