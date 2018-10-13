<?php
	class Timetable_excel_reader extends Excel_reader {
		static function get_name(): string {
			return "Расписание";
		}

		static function handle(Closure $f) {
			foreach (static::process($f) as $lesson) {
				static::add_lesson($lesson);
			}
		}

		static function process(Closure $f): array {
			$lessons = [];
			$c = $f(0, 0);
			$mx = 30;
			for ($i = 1; $i <= $mx; $i += 3) {
				$denek = $f($i, 0);
				if ($denek == "")
					break;
				for ($j = 1; $j <= $mx; $j++) {
					$arr = [];
					$arr["class"] = $c;
					$arr["day"] = $denek;
					$arr["num"] = $j;
					$arr["name"] = $f($i, $j);
					$arr["place"] = $f($i + 2, $j);
					$arr["teacher"] = $f($i + 1, $j);
					$lessons[] = $arr;
 				}
			}
			return $lessons;
		}

		static function add_lesson($lesson) {
			safe_query("
				INSERT INTO LESSONS (
					CLASS, WEEKDAY, NUMBER, LESSON, PLACE
				) VALUES (
					?s, ?s, ?i, ?s, ?s
				)",
				$lesson["class"],
				$lesson["day"],
				$lesson["num"],
				$lesson["name"],
				$lesson["place"]
			);
		}
	}
?>
