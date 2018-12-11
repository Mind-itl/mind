<?php
	namespace Mind\Db\Excel\Readers;

	use Mind\Db\Excel\Reader;

	use Mind\Server\Utils;
	use Mind\Db\Db;

	class Duties extends Reader {
		static function get_name(): string {
			return "Расписание дежурств";
		}

		static function format_name(string $name): string {
			preg_match('/(\w+) *(\w)\.? *(\w)\.?/u', $name, $m);
			return $m[1]." ".mb_strtoupper($m[2]).".".mb_strtoupper($m[3]).".";
		}

		static function format_day(string $day): string {
			return Utils::today_en($day);
		}

		static function process(\Closure $get): array {
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

		static function handle(\Closure $get) {
			Db::query("DELETE FROM dutes");

			$a = self::process($get);
			foreach ($a as $i) {
				Db::query("
					INSERT INTO dutes (
						LOGIN, BLOCK, DAY 
					) VALUES (?s, ?s, ?s)
					", $i["login"], $i["block"], $i["day"]
				);
			}
		}
	}
?>
