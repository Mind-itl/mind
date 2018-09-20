<?php
	class Auction_control extends Control {
		private $row_view;

		public function has_access(array $args): bool {
			return is_logined();
		}

		protected function get_data(array $args): array {
			return [];
		}
	}
?>
