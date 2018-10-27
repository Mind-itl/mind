<?php
	require_once LIBS."passwords.php";

	class Teachers_excel_reader extends Excel_reader {
		static function get_name(): string {
			return "Учителя";
		}

		static function handle(Closure $f) {
			foreach (static::process($f) as $teacher) {
				static::add_teacher($teacher);
			}
		}

		// static function format_name(string $name): string {
		// 	preg_match('/(\w+) *(\w)\.? *(\w)\.?/u', $name, $m);
		// 	return $m[1]." ".mb_strtoupper($m[2]).".".mb_strtoupper($m[3]).".";
		// }

		static function format_name(string $name): string {
			return strtolower($name);
		}

		static function process(Closure $f): array {
			$n = 4; // количество циферок в логине
			$i = 1;
			$arr = [];
			while ($f(0, $i) != "") {
				$arr[$i] = [];
				$arr[$i]["family_name"] = $f(1, $i);
				$arr[$i]["name"] = $f(2, $i);
				$arr[$i]["father_name"] = $f(3, $i);

				$j = 5;
				$empty = [];
				while ($f($j, $i) != "") {
					$duty = $f($j, $i);

					$asd = explode(' ', $duty);
					$aaa = $asd[0];
					$bbb = $asd[1] ?? "";

					// $aaa = self::format_name($aaa);
					// $bbb = self::format_name($bbb);
					if ($aaa == "классрук")
						$aaa = "classruk";
					else if ($aaa == "вocпитатель")
						$aaa = "vospit";
					else if ($aaa == "учитель")
						$aaa = "predmet";
					$empty[] = [
						"duties" => $aaa,
						"classes" => $bbb
					];
					$j++;
				}
				$arr[$i]["many_duties"] = $empty;
				
				//$arr[$i]["birthday"] = $f(6, $i);
				while (true) {
					$str = "";
					for ($j = 0; $j < $n; $j++) {
						$rand = random_int(0, 9);
						$str .= "$rand";
					}
					$a = safe_query_assoc("
						SELECT COUNT(LOGIN) AS COUNT FROM teachers
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

		static function add_teacher(array $teacher) {
			$i = $teacher;
			$a = safe_query_assoc("
				SELECT COUNT(LOGIN) AS COUNT FROM teachers 
				WHERE
					LOGIN = ?s
			", $i["login"]
			)["COUNT"];
			if (intval($a) != 0)
				return;

			$pas = "";
			for ($j = 0; $j < 5; $j++) {
				$pas .= (random_int(0, 9));
			}

			safe_query("
				INSERT INTO teachers (
					GIVEN_NAME, FATHER_NAME, FAMILY_NAME, LOGIN
				) VALUES (
					?s, ?s, ?s, ?s
				)", $i["name"], $i["father_name"], $i["family_name"], $i["login"]
			);
			register_user($i["login"], $pas, "teacher");

			foreach ($i["many_duties"] as $q) {
				safe_query("
					INSERT INTO teacher_roles (
						LOGIN, ROLE, ARG
					) VALUES (
						?s, ?s, ?s
					)", $i["login"], $q["duties"], $q["classes"]
				);
			}

			$user = get_curr();

			add_notification($user, get_user($i["login"]), "Пользователь зарегестрировался. Логин: ".$i["login"]." Пароль: $pas");
		}
	}
?>
