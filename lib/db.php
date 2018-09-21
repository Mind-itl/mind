<?php
	declare(strict_types=1);
	require_once "causes.php";

	function get_pdo() {
		$dsn = 
			"mysql:host=".DB_ADDRESS.";".
			"dbname=".DB_NAME.';'.
			"charset=utf8";

		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $opt);
		return $pdo;
	}

	function pdo_query(string $r, array $arr) {
		$r = get_pdo()->prepare($r);
		$r->execute($arr);
		return $r;
	}

	function pdo_assoc_execute(string $r, array $arr) {
		return pdo_query($r, $arr)->fetch();
	}

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

	function sql_query(string $query) {
		$mysql = new mysqli(DB_ADDRESS, DB_USER, DB_PASSWORD, DB_NAME);
		$res = $mysql->query($query);

		return $res;
	}

	function sql_query_assoc(string $query) {
		$q = sql_query($query);
		if ($q === false) {
			error_log("db.php:17 sql returned false");
			$q = sql_query($query);
		}

		return $q->fetch_assoc();
	}

	function assoc_user(string $table, string $login): array {
		return pdo_assoc_execute("
			SELECT *
			FROM `$table`
			WHERE `LOGIN` = ?",
			[$login]
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
 			$from_user->get_full_name("gi fm")." перечислил(а) вам $points"
 		);
 		add_notification(
 			$from_user,
 			"Вы перечислили $points пользователю под именем ".$to_user->get_full_name("gi fm")
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
 				POINTS
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
?>
