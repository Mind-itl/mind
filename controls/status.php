<?php
	namespace Mind\Controls;

	use Mind\Server\{Control, Utils};
	use Mind\Db\Statuses;

	class Status extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		public function get_data(array $args): array {


			return [
				"statuses" => Statuses::get_types(),
				"groups" => Statuses::get_students_by_classes()
			];
		}
	}
?>
