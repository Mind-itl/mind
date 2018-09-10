<?php
	class Signup_control extends Control {
		public function __construct() {
			parent::__construct("signup");
		}

		public function has_access(array $args): bool {
			return !is_logined();
		}

		protected function get_data(array $args): array {
			return [
				"CLASSES" => $this->get_classes()
			];
		}

		private function get_classes(): string {
			$q = sql_query("SELECT DISTINCT(CLASS) AS CLASS FROM lessons");
			$r = [];

			foreach ($q as $v) {
				$r[] = $v["CLASS"];
			}

			return json_encode($r);
		}
	}
?>	