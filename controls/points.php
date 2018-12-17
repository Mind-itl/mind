<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json, Causes, Transactions};
	use Mind\Server\{Control, Utils, Route};
	use Mind\Users\{User, Teacher, Student};

	class Points extends Control {
		public function has_access(array $args): bool {
			if (isset($args[1]) && $args[1]!="")
				return Utils::is_logined();
			else
				return Utils::is_logined() && Utils::get_curr() instanceof Student;
		}

		protected function get_data(array $args): array {
			if (isset($args[1]) && $args[1]!="") {
				$login = trim($args[1]);

				if (
					!Users::has_login($login, true) ||
					!Users::get($login, true) instanceof Student
				) Route::not_found();

				$user = Users::student($login, true);
			} else
				$user = Utils::curr_student();

			[$trans, $sum] = $this->trans($user);

			return [
				"trans_by_day" => $this->group_by_days($trans),
				"points" => [
					"count" => $sum,
					"noun" => Utils::get_points_case($sum)
				],
				"he" => $user
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
			foreach (Transactions::of_student($student) as $trans) {
				$from_user = null;
				$to_user = null;

				if (isset($trans["FROM_LOGIN"]))
					$from_user = Users::get($trans["FROM_LOGIN"]);

				if (isset($trans["TO_LOGIN"]))
					$to_user = Users::get($trans["TO_LOGIN"]);

				$code = $trans["CAUSE"];
				$cause = Causes::get_title($code);

				$from_me = false;
				if ($cause == "Передача баллов") {
					if ($trans["POINTS"] < 0) {
						$from_me = true;
						// $cause .= " пользователю ".Users::get($trans['TO_LOGIN'])->get_full_name("gi fm");
					}
				}

				$row = [
					'cause' => $cause,
					'from' => $from_user,
					'to' => $to_user,
					'date' => new \DateTime($trans["TIME"]),
					'points' => $trans["POINTS"],
					'from_me' => $from_me
				];


				$sum += $row['points'];
				$table[] = $row;
			}

			return [$table, $sum];
		}
	}
?>
