<?php
	class Select_student_control extends Control {
		public function __construct() {
			parent::__construct("select_student");
		}

		protected function get_data(array $args): array {
			return [
				"CLASSES" => get_classes_json()
			];
		}
	}
?>