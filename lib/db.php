<?php
	declare(strict_types=1);
	require_once "causes.php";

	function safe_query(...$args) {
		$safe = new SafeMySQL([
			'user' => DB_USER,
			'db' => DB_NAME,
			'pass' => DB_PASSWORD
		]);

		return $safe->query(...$args);
	}

	function safe_query_assoc(...$args) {
		return safe_query(...$args)->fetch_assoc();
	}

	function assoc_user(string $table, string $login): array {
		return safe_query_assoc("
			SELECT *
			FROM `$table`
			WHERE `LOGIN` = ?s
			", $login
		);
	}

	function get_student_points(string $login): int {
		$got_points = safe_query_assoc("
			SELECT SUM(POINTS) AS SUM
			FROM transactions
			WHERE TO_LOGIN = ?s
		", $login)["SUM"] ?? 0;	
		
		$given_points = safe_query_assoc("
			SELECT SUM(`POINTS`) AS SUM
			FROM `transactions`
			WHERE `FROM_LOGIN`= ?s
		", $login)["SUM"] ?? 0;

		return $got_points - $given_points;
	}

	function add_transaction(string $from_login, string $to_login, int $points, string $cause): bool {
		$from_user = get_user($from_login);
		$to_user = get_user($to_login);

		if (!$to_user->has_role("student"))
			return false;

		if ($from_user->has_role("student") && $from_user->get_points() < $points)
			return false;

		safe_query(
			"INSERT INTO `transactions` (
				FROM_LOGIN,
				TO_LOGIN,
				POINTS,
				CAUSE
			) VALUES (
				?s, ?s, ?i, ?s
			)", $from_login, $to_login, $points, $cause
		);

		$points = get_points_in_case(intval($points));

		add_notification(
			$to_user,
			$from_user,
			"Вам перечислили баллы",
			intval($points)
		);

		return true;
	}

	function get_student_transactions(string $login): array {
		$ret = [];
		$query = safe_query(
			"SELECT
				DATE_FORMAT(TIME, '%H:%i %d.%m.%y') AS NORM_TIME,
				FROM_LOGIN,
				TO_LOGIN,
				CAUSE,
				POINTS,
				TIME
			FROM `transactions`
			WHERE
				FROM_LOGIN=?s OR
				TO_LOGIN=?s
			ORDER BY TIME DESC
			", $login, $login
		);

		foreach ($query as $q) {
			if ($q["FROM_LOGIN"] == $login)
				$q["POINTS"] = -$q["POINTS"];
			
			$ret[] = $q;
		}

		return $ret;
	}

	function get_classes_json(): string {
		$query = safe_query(
			"SELECT
				CONCAT(CLASS_NUM, '-', CLASS_LIT) AS CLASS,
				GIVEN_NAME,
				FATHER_NAME,
				FAMILY_NAME,
				LOGIN
			FROM students
			ORDER BY CLASS_NUM, CLASS_LIT"
		);
		$classes = [];

		foreach ($query as $student) {
			$class = $student["CLASS"];
			$classes[$class] = $classes[$class] ?? [];

			$classes[$class][] = $student;
		}

		return json_encode($classes);
	}

	function get_events_json(): string {
		$query = safe_query("SELECT * FROM `calendar`");

		$events = [];
		foreach ($query as $event) {
			$events[] = $event;
		}

		return json_encode($events);
	}

	function get_cause_price(string $cause): int {
		foreach (causes_list as $v) {
			if ($v["code"] == $cause)
				return $v['price'];
		}
	}

	function has_cause(string $cause): bool {
		foreach (causes_list as $v) {
			if ($v["code"] == $cause){
				return true;
			}
		}

		return false;
	}

	function get_cause_title(string $cause): string {
		$special_codes = [
			'D' => 'Начальные баллы',
			'C' => 'Передача баллов',
		];

		if (isset($special_codes[$cause]))
			return $special_codes[$cause]; 

		foreach (causes_list as $v) {
			if ($v["code"] == $cause)
				return $v['title'];
		}
	}

	function get_teacher_by_name(string $name): ?Teacher {
		$arr = explode(' ', $name);
		$family_name = $arr[0];
		$arr = explode('.', $arr[1]);
		$first_init = $arr[0];
		$second_init = $arr[1];

		$arr = safe_query("SELECT * FROM teachers WHERE FAMILY_NAME = ?s", $family_name);

		foreach ($arr as $i) {
			if ($i["GIVEN_NAME"][0] == $first_init && $i["FATHER_NAME"][0] == $second_init) {
				return get_user($i["LOGIN"]);
			}
		}
		return null;
	}
?>
