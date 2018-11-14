<?php
	declare(strict_types=1);
	require_once "causes.php";

	function get_classes_json(): string {
		$query = safe_query(
			"SELECT
				CONCAT(CLASS_NUM, '-', CLASS_LIT) AS CLASS,
				GIVEN_NAME,
				FATHER_NAME,
				FAMILY_NAME,
				LOGIN
			FROM students
			ORDER BY
				CLASS_NUM, CLASS_LIT,
				FAMILY_NAME, GIVEN_NAME
			"
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
