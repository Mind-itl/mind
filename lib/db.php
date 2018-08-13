<?php
	declare(strict_types=1);
	
	require_once "config.php";
	require_once "causes.php";

	function sql_query(string $query) {
		$mysql = new mysqli(DB_ADDRESS, DB_USER, DB_PASSWORD, DB_NAME);
		$res = $mysql->query($query);

		return $res;
	}

	function sql_query_assoc(string $query) {
		return sql_query($query)->fetch_assoc();
	}

	function assoc_user(string $table, string $login): array {
		return sql_query_assoc("SELECT * FROM `$table` WHERE `LOGIN` = '$login'");
	}

	function get_student_points(string $login): int {
		$got_points = sql_query_assoc("SELECT SUM(`POINTS`) AS SUM FROM `transactions` WHERE `TO_LOGIN`='$login'")["SUM"] ?? 0;
		$given_points = sql_query_assoc("SELECT SUM(`POINTS`) AS SUM FROM `transactions` WHERE `FROM_LOGIN`='$login'")["SUM"] ?? 0;

		return $got_points - $given_points;
 	}

 	function add_transaction(string $from_login, string $to_login, int $points, string $cause): bool {
 		$from_user = get_user($from_login);
 		if ($from_user->has_role("student") && $from_user()->get_points() < $points)
 			return false;

 		sql_query("INSERT INTO `transactions` (FROM_LOGIN, TO_LOGIN, POINTS, CAUSE) VALUES ('$from_login', '$to_login', $points, '$cause')");
 		return true;
 	}

 	function get_student_transactions(string $login): array {
 		$ret = [];
 		$query = sql_query("SELECT * FROM `transactions` WHERE FROM_LOGIN='$login' OR TO_LOGIN='$login' ORDER BY TIME");

 		foreach ($query as $q) {
 			$ret[] = $q;
 		}

 		return $ret;
 	}

 	function get_classes_json(): string {
 		$query = sql_query("SELECT CONCAT(CLASS_NUM, '-', CLASS_LIT) AS CLASS, GIVEN_NAME, FATHER_NAME, FAMILY_NAME, LOGIN FROM students ORDER BY CLASS_NUM, CLASS_LIT");
		$classes = [];

		foreach ($query as $student) {
			$class = $student["CLASS"];
			$classes[$class] = $classes[$class] ?? [];

			$classes[$class][] = $student;
		}

		return json_encode($classes);
 	}

 	function get_events_json(): string {
 		$query = sql_query("SELECT * FROM `calendar`");

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
 		foreach (causes_list as $v) {
 			if ($v["code"] == $cause)
 				return $v['title'];
 		}
 	}
?>