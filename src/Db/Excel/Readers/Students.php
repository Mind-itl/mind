<?php
	namespace Mind\Db\Excel\Readers;

	use Mind\Db\Excel\Reader;

	use Mind\Server\Utils;
	use Mind\Db\{Db, Passwords, Notifications, Users};

	class Students extends Reader {
		static function get_name(): string {
			return "Ученики";
		}

		static function handle(\Closure $f) {
			foreach (static::process($f) as $student) {
				static::add_student($student);
			}
		}

		static function format_name(string $name): string {
			preg_match('/(\w+) *(\w)\.? *(\w)\.?/u', $name, $m);
			return $m[1]." ".mb_strtoupper($m[2]).".".mb_strtoupper($m[3]).".";
		}

		static function process(\Closure $f): array {
			$n = 4; // количество циферок в логине
			$i = 1;
			$arr = [];
			while ($f(0, $i) != "") {
				$arr[$i] = [];
				$arr[$i]["family_name"] = $f(1, $i);
				$arr[$i]["name"] = $f(2, $i);
				$arr[$i]["father_name"] = $f(3, $i);

				$class = $f(4, $i);
				[$aaa, $bbb] = explode('-', $class);
				$arr[$i]["num"] = $aaa;
				$arr[$i]["lit"] = $bbb;

				//$arr[$i]["birthday"] = $f(6, $i);
				while (true) {
					$str = "";
					for ($j = 0; $j < $n; $j++) {
						$rand = random_int(0, 9);
						$str .= "$rand";
					}
					$a = Db::query_assoc("
						SELECT COUNT(LOGIN) AS COUNT FROM students
						WHERE
							LOGIN = ?s		
					", $str)["COUNT"];
					$b = Db::query_assoc("
						SELECT COUNT(ENTRY_LOGIN) AS COUNT FROM students
						WHERE
							LOGIN = ?s
					", $str)["COUNT"];

					if (intval($a) + intval($b) == 0) {
						$arr[$i]["login"] = $str;
						break;
					}
				}
				$i++;
			}
			return $arr;
		}

		static function add_student($student) {
			$i = $student;
			$a = Db::query_assoc("
				SELECT COUNT(LOGIN) AS COUNT FROM students 
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

			Db::query("
				INSERT INTO students (
					GIVEN_NAME, FATHER_NAME, FAMILY_NAME, CLASS_NUM, CLASS_LIT, LOGIN
				) VALUES (
					?s, ?s, ?s, ?i, ?s, ?s
				)", $i["name"], $i["father_name"], $i["family_name"], intval($i["num"]), $i["lit"], $i["login"]
			);
			Passwords::register_user($i["login"], $pas, "student");

			$user = Users::student($i["login"]);
			$teacher = $user->get_classruk();

			if ($teacher) {
				Notifications::add($teacher, $user, "Пользователь зарегестрировался. Логин: ".$i["login"]." Пароль: $pas");
			}
		}
	}
?>
