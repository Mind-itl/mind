<?php
	class Class_control extends Control {
		private $row_view;

		protected function get_data(array $args): array {
			return [
				"CLASS_SUM" => $this->class_sum(),
				"CLASS_TABLE" => $this->class_table(),
				"CSS_PAGE_LINK" => "<link rel='stylesheet' href='/css/points.css'>"
			];
		}

		private function class_sum(): string {
			return "$this->points_sum";
		}

		public function has_access(array $args): bool {
			return get_curr()->has_role("classruk");
		}

		private function class_row(array $row): string {
			return $this->process_view($this->row_view, [
				"NAME" => $row['name'],
				"LOGIN" => $row['login'],
				"POINTS" => $row['points']
			], []);
		}

		private function class_table(): string {
			$s = "";
			foreach ($this->table as $row) {
				$s .= $this->class_row($row);
			}
			return $s;
		}

		public function __construct() {
			$this->row_view = load_view("class_table_row");
			parent::__construct("class");

			$this->load();
		}

		private function load() {
			$this->table = [];
			$this->points_sum = 0;

			foreach (get_curr()->get_children() as $student) {
				$row = [
					"points" => $student->get_points(),
					"login" => $student->get_login(),
					"name" => $student->get_full_name("fm gi")
				];
				$this->table[] = $row;

				$this->points_sum += $student->get_points(); 
			}
		}
	}
?>