<?php
	class Duties_excel_reader extends Excel_reader {
		static function get_name(): string {
			return "Расписание дежурств";
		}

		static function format_name(string $name): string {
			preg_match('/(\w+) *(\w)\.? *(\w)\.?/u', $name, $m);
			return $m[1]." ".mb_strtoupper($m[2]).".".mb_strtoupper($m[3]).".";
		}

		static function format_day(string $day): string {
			return today_en($day);
		}

		static function process(Closure $get): array {
			$i = 1;
			$day = "";
			$a = [];
			while (true) {
				$arr = [];
				$j = $get(0, $i);
				if ($j != "")
					$day = $j;
				$arr["day"] = self::format_day($day);
				
				$login = $get(1, $i);
				if ($login == "")
					break;
				$login = self::format_name($login);

				$arr["login"] = $login;
				$arr["block"] = trim($get(2, $i));
				$i++;
				$a[] = $arr;
			}
			return $a;
		}

		static function handle(Closure $get) {
			$a = self::process($get);
			foreach ($a as $i) {
				safe_query("
					DELETE FROM dutes
					WHERE
						BLOCK = ?s AND
						DAY = ?s
					", $i["block"], $i["day"]
				)
				safe_query("
					INSERT INTO dutes (
						LOGIN, BLOCK, DAY 
					) VALUES (?s, ?s, ?s)",
					$i["login"], $i["block"], $i["day"]);
			}
		}
	}
?>
