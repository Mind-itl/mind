<?php
	class Student_control extends Control {
		private $row_view;

		public function has_access(array $args): bool {
			return is_logined();
		}

		protected function get_data(array $args): array {
			$user = get_user($args[1]);
			list($table, $sum) = $this->pre_table($user);
			return [
				"SUM" => $sum,
				"TABLE" => $this->table($table),
				"CSS_PAGE_LINK" => "<link rel='stylesheet' href='/css/points.css'>"
			];
		}

		private function class_row(array $row): string {
			return $this->process_view($this->row_view, [
				"TIME" => $row['time'],
				"FROM" => $row['from'],
				"POINTS" => $row['points'],
				"CAUSE" => $row['cause'],
				"CLS" => $row["cls"]
			], []);
		}

		protected function table($table): string {
			$s = "";
			foreach ($table as $row) {
				$s .= $this->class_row($row);
			}
			return $s;
		}

		public function __construct() {
			$this->row_view = load_view("points_table_row");
			parent::__construct("points");
		}

		protected function pre_table(Student $student): array {
			$table = [];

			foreach ($student->get_transactions() as $trans) {
				if (isset($trans["FROM_LOGIN"])) {
					$name = get_user($trans["FROM_LOGIN"])->get_full_name("fm gi");

					if ($trans["FROM_LOGIN"] == $student->get_login())
						$cls = "from_me";
					else
						$cls = "not_from_me";
				} else {
					$cls = "not_from_me";
					$name = "";
				}

				$code = $trans["CAUSE"];
				$cause = get_cause_title($code);

				$row = [
					'cause' => $cause,
					'from' => $name,
					'cls' => $cls,
					'time' => $trans["NORM_TIME"],
					'points' => $trans["POINTS"]
				];

				$table[] = $row;
			}

			return [$table, $student->get_points()];
		}
	}
?>