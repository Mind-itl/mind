<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Auction extends Control {
		private $row_view;

		public function has_access(array $args): bool {
			return Utils::is_logined() && Utils::get_curr() instanceof User;
		}

		protected function get_data(array $args): array {
			return [
				"points" => [
					"count" => Utils::get_curr()->get_points(),
					"noun" => Utils::get_points_case(Utils::get_curr()->get_points()),
				],
				// "scripts" => $this->scripts()
			];
		}

		protected function scripts(): string {
			$str = "";
			$dir = Utils::ROOT."public_html/js/auction/";

			foreach (scandir($dir) as $file) {
				$str .= file_get_contents($dir.$file);
			}

			return $str;
		}
	}
?>
