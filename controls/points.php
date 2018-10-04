<?php
	class Points_control extends Control {
		public function has_access(array $args): bool {
			if (isset($args[1]) && $args[1]!="")
				return is_logined();
			else
				return is_logined() && get_curr()->is_student();
		}

		protected function get_data(array $args): array {
			if (isset($args[1]) && $args[1]!="")
				$user = get_user($args[1]);
			else 
				$user = get_curr();

			list($trans, $sum) = $this->trans($user);

			return [
				"table" => $trans,
				"points" => [
					"count" => $sum,
					"noun" => get_points_case($sum)
				]
			];
		}

		protected function trans(Student $student): array {
			$table = [];
			$sum = 0;
			foreach ($student->get_transactions() as $trans) {
				if (isset($trans["FROM_LOGIN"]))
					$name = get_user($trans["FROM_LOGIN"])->get_full_name("fm gi");
				else
					$name = "";

				if ($trans["POINTS"] >= 0)
					$cls = "good-points";
				else
					$cls = "bad-points";

				$code = $trans["CAUSE"];
				$cause = get_cause_title($code);

				if ($cause == "Передача баллов") {
					if ($trans["POINTS"] < 0)
						$cause .= " пользователю ".get_user($trans['TO_LOGIN'])->get_full_name("gi fm");
				}

				$row = [
					'cause' => $cause,
					'from' => $name,
					'cls' => $cls,
					'time' => $trans["NORM_TIME"],
					'points' => $trans["POINTS"]
				];


				$sum += $row['points'];
				$table[] = $row;
			}

			return [$table, $sum];
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

		protected function pre_table(Student $student): array {
			$table = [];

			foreach ($student->get_transactions() as $trans) {
				if (isset($trans["FROM_LOGIN"]))
					$name = get_user($trans["FROM_LOGIN"])->get_full_name("fm gi");
				else
					$name = "";

				if ($trans["POINTS"] >= 0)
					$cls = "good-points";
				else
					$cls = "bad-points";

				$code = $trans["CAUSE"];
				$cause = get_cause_title($code);

				if ($cause == "Передача баллов") {
					if ($trans["POINTS"] >= 0) {
						$cause .= " мне";
					} else {
						$cause .= " пользователю ".get_user($trans['TO_LOGIN'])->get_full_name("gi fm");
					}
				}

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
