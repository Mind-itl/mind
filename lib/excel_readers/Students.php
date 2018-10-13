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

		static function process(Closure $f): array {
			//todo
		}

		static function add_student($student) {
			safe_query("
				INSERT INTO students (
					GIVEN_NAME, FATHER_NAME, FAMILY_NAME, CLASS_NUM, CLASS_LIT, LOGIN
				) VALUES (
					?s, ?s, ?s, ?i, ?s
				)"
			);
		}
	}
?>
