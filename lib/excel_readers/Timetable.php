<?php
	class Timetable extends Excel_reader {
		static function process(Closure $f): array {
			//todo
		}

		static function handle(Closure $f) {
			foreach (static::process($f) as $lesson) {
				static::add_lesson($lesson);
			}
		};

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
			)
		}
	}
?>
