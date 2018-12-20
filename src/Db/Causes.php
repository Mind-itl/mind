<?php
	namespace Mind\Db;

	require_once __DIR__."/../../causes.php";

	use Mind\Users\{User, Teacher, Student};

	class Causes {
		public static function get_price(string $cause): int {
			foreach (causes_list as $v) {
				if ($v["code"] == $cause)
					return $v['price'];
			}
		}

		public static function has(string $cause): bool {
			foreach (causes_list as $v) {
				if ($v["code"] == $cause){
					return true;
				}
			}

			return false;
		}

		public static function get_title(string $cause): string {
			$special_codes = [
				'D' => 'Начальные баллы',
				'C' => 'Передача баллов',
				"E" => 'Покупка на аукционе'
			];

			if (isset($special_codes[$cause]))
				return $special_codes[$cause]; 

			foreach (causes_list as $v) {
				if ($v["code"] == $cause)
					return $v['title'];
			}
		}
	}
?>
