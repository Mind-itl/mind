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
				"trans_by_day" => $this->group_by_days($trans),
				"points" => [
					"count" => $sum,
					"noun" => get_points_case($sum)
				]
			];
		}

		protected function group_by_days(array $trans): array {
			$arr = [];

			foreach ($trans as $tran) {
				$d = $tran["date"]->format("d.m.Y");
				$arr[$d] = $arr[$d] ?? [];
				$arr[$d][] = $tran;
			}

			$raa = [];

			foreach ($arr as $day => $transs) {
				$raa[] = [
					"date" => $transs[0]["date"],
					"trans" => $transs
				];
			}

			return $raa;
		}

		protected function trans(Student $student): array {
			$table = [];
			$sum = 0;
			foreach ($student->get_transactions() as $trans) {
				if (isset($trans["FROM_LOGIN"]))
					$from_user = get_user($trans["FROM_LOGIN"]);

				$code = $trans["CAUSE"];
				$cause = get_cause_title($code);

				if ($cause == "Передача баллов") {
					if ($trans["POINTS"] < 0)
						$cause .= " пользователю ".get_user($trans['TO_LOGIN'])->get_full_name("gi fm");
				}

				$row = [
					'cause' => $cause,
					'from' => $from_user,
					'date' => new DateTime($trans["TIME"]),
					'points' => $trans["POINTS"]
				];


				$sum += $row['points'];
				$table[] = $row;
			}

			return [$table, $sum];
		}
	}
?>
