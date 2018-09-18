<?php
	class Select_student_control extends Control {
		protected function get_data(array $args): array {
			return [
				"classes" => get_classes_json()
			];
		}
	}
?>
