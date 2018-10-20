<?php
	class Students_excel_reader extends Excel_reader {
		static function get_name(): string {
			return "Ученики";
		}

		static function handle(Closure $f) {
			foreach (static::process($f) as $student) {
				static::add_student($student);
			}
		}

		static function format_name(string $name): string {
			preg_match('/(\w+) *(\w)\.? *(\w)\.?/u', $name, $m);
			return $m[1]." ".mb_strtoupper($m[2]).".".mb_strtoupper($m[3]).".";
		}

		static function process(Closure $f): array {
			$n = 4; // количество циферок в логине
			$i = 1;
			$arr = [];
			while ($f(1, $i) != "") {
				$arr[$i] = [];
				$arr[$i]["name"] = self::format_name($f(1, $i));
				$arr[$i]["father_name"] = self::format_name($f(2, $i));
				$arr[$i]["family_name"] = self::format_name($f(3, $i));
				$arr[$i]["num"] = $f(4, $i);
				$arr[$i]["lit"] = $f(5, $i);
				$arr[$i]["birthday"] = $f(6, $i);
				while (true) {
					$str = "";
					for ($j = 0; $j < $n; $j++) {
						$rand = rand_int(0, 9);
						$str .= "$rand";
					}
					$a = safe_query_assoc("
						SELECT COUNT(LOGIN) AS COUNT FROM students
						WHERE
							LOGIN = ?s		
					", $str)["COUNT"];
					if (intval($a) == 0) {
						$arr[$i]["login"] = $str;
						break;
					}
				}
				$i++;
			}
			return $arr;
		}

		static function add_student($student) {
			$arr = self::process($get);
			foreach ($arr as $i) {
				$a = safe_query("
					SELECT COUNT(LOGIN) AS COUNT FROM students 
					WHERE
					 	LOGIN = ?s
				", $i["login"]
				)["COUNT"];
				if (intval($a) != 0)
					continue;
				$pas = "";
				for ($j = 0; $j < 5; $j++) {
					$pas .= (rand_int(0, 9));
				}
				safe_query("
					INSERT INTO students (
						GIVEN_NAME, FATHER_NAME, FAMILY_NAME, CLASS_NUM, CLASS_LIT, BIRTHDAY, LOGIN
					) VALUES (
						?s, ?s, ?s, ?i, ?s, ?s, ?s
					)", $i["name"], $i["father_name"], $i["family_name"], $i["num"], $i["lit"], $i["birthday"], $i["login"]
				);
				register_user($i["login"], $pas, "student");
				// return login and password to excel
			}
		}
	}
?>