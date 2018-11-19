<?php
	namespace Mind\Db\Excel\Readers;

	use Mind\Db\Excel\Reader;

	use Mind\Server\Utils;
	use Mind\Db\Db;

	class Timetable extends Reader {
		static function get_name(): string {
			return "Расписание";
		}

		static function handle(\Closure $f) {
			static::delete_timetable($f);
			foreach (static::process($f) as $lesson) {
				static::add_lesson($lesson);
			}
		}

		static function delete_timetable(\Closure $f): void {
			Db::query("DELETE FROM lessons WHERE CLASS = ?s", self::format_group($f(0, 0)));
		}

		static function process(\Closure $f): array {
			$lessons = [];
			$c = $f(0, 0);
			$mx = 30;
			for ($i = 1; $i <= $mx; $i += 3) {
				$denek = $f($i, 0);
				if ($denek == "")
					break;
				for ($j = 2; $j <= $mx; $j++) {
					if ($f($i+1, $j) == "")
						break;
					$arr = [];
					$arr["class"] = self::format_group($c);
					$arr["day"] = self::format_day($denek);
					$arr["num"] = intval($f(0, $j));
					$arr["name"] = $f($i, $j);
					$arr["place"] = $f($i + 2, $j);
					$arr["teacher"] = self::format_name($f($i + 1, $j));
					$lessons[] = $arr;
 				}
			}
			return $lessons;
		}

		static function format_name(string $name): string {
			preg_match('/(\w+) *(\w)\.? *(\w)\.?/u', $name, $m);
			if (!isset($m[1]))
				echo "$name\n";
			return $m[1]." ".mb_strtoupper($m[2]).".".mb_strtoupper($m[3]).".";
		}

		static function format_group(string $group): string {
			preg_match('/(\d+)\D+?(\d+)/', $group, $m);
			return $m[1]."-".$m[2];
		}

		static function format_day(string $day): string {
			return Utils::today_en($day);
		}

		static function add_lesson($lesson) {
			Db::query("
				INSERT INTO lessons (
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
