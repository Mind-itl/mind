<?php
	check_roles("student");

	require_once CONTROLS.'/student.php';

	class Points_control extends Student_control {
		protected function get_data(array $args): array {
			list($table, $sum) = $this->pre_table(get_curr());

			return [
				"SUM" => $sum,
				"TABLE" => $this->table($table),
				"CSS_PAGE_LINK" => "<link rel='stylesheet' href='/css/points.css'>"
			];
		}
	}
?>