<?php
	class Auction_control extends Control {
		private $row_view;

		public function has_access(array $args): bool {
			return is_logined() && get_curr()->is_student();
		}

		protected function get_data(array $args): array {
			return [
				"points" => [
					"count" => get_curr()->get_points(),
					"noun" => get_points_case(get_curr()->get_points())
				]
			];
		}
	}
?>
