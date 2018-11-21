<?php
	declare(strict_types=1);

	namespace Mind\Db\Excel;

	class Formatter {
		/**
		 * @param string $name - $name in format like 'Petrov P.P.'
		 */
		public static function abbr_name(string $name): string {
			$name = static::lower($name);
			$name = preg_replace("/ё/u", "е", $name);

			preg_match('/(\w+) *(\w)\.? *(\w)\.?/u', $name, $m);

			$m[1] = static::upper_first($m[1]);

			return $m[1]." ".static::upper($m[2]).".".static::upper($m[3]).".";
		}

		public static function upper(string $str): string {
			return mb_strtoupper($str);
		}

		public static function lower(string $str): string {
			return mb_strtolower($str);
		}

		public static function upper_first(string $str): string {
			return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr($str, 1, mb_strlen($str)-1, 'utf-8');
		}

		public static function lower_first(string $str): string {
			return mb_substr(mb_strtolower($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr($str, 1, mb_strlen($str)-1, 'utf-8');
		}
	}
?>
