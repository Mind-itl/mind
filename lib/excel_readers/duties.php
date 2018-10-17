<?php
	class Duties_excel_reader extends Excel_reader {
		static function get_name(): string {
			return "Расписание дежурств";
		}

		static function format_name(string $name): string {
			preg_match('/(\w+) *(\w)\.? *(\w)\.?/u', $name, $m);
			return $m[1]." ".mb_strtoupper($m[2]).".".mb_strtoupper($m[3]).".";
		}

		static function process(Closure $get): array {
			$i = 1;
			$day = "";
			$a = [];
			while (true) {
				$arr = [];
				$j = $get($i, 0);
				if ($j != "")
					$day = $j;
				$arr["day"] = $day;
				$login = self::format_name($get($i, 1));
				$arr["login"] = $login;
				$arr["block"] = trim($get($i, 2));
				$i++;
				$a[] = $arr;
			}
			return $a;
		}

		static function handle(Closure $get) {
			$a = self::process($get);
			foreach ($a as $i) {
				safe_query("
					INSERT INTO dutes (
						LOGIN, BLOCK, DAY 
					) VALUES (?s, ?s, ?s)",
					$i["login"], $i["block"], $i["day"]);
			}
		}
	}
?>