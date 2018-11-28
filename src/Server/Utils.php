<?php
	namespace Mind\Server;

	use Mind\Users\{User, Teacher, Student};
	use Mind\Db\Users;

	class Utils {
		const ROOT = __DIR__."/../../";
		const CONTROLS = self::ROOT."controls/";
		const VIEWS = self::ROOT."views/";
		const LIBS = self::ROOT."lib/";

		public static function is_logined(): bool {
			return isset($_SESSION['login']);
		}

		public static function get_curr(): User {
			return Users::get($_SESSION['login']);
		}

		public static function curr_teacher(): Teacher {
			return Users::teacher($_SESSION['login']);
		}

		public static function curr_student(): Student {
			return Users::student($_SESSION['login']);
		}

		public static function redirect($url) {
			if ($url === "/" && $_SERVER["REQUEST_URI"] != "/out")
				$url .= "?from=" . $_SERVER['REQUEST_URI'];

			?>
			<script>
				window.location="<?=$url?>";
			</script>
			<?php
			exit();
		}

		public static function today_rus(string $today): string { 
			return [
				"Monday" => "Понедельник", 
				"Tuesday" => "Вторник", 
				"Wednesday" => "Среда", 
				"Thursday" => "Четверг", 
				"Friday" => "Пятница", 
				"Saturday" => "Суббота", 
				"Sunday" => "Воскресенье"
			][$today];
		}

		public static function today_en(string $today): string {
			return [
				"Понедельник" => "Monday", 
				"Вторник" => "Tuesday", 
				"Среда" => "Wednesday", 
				"Четверг" => "Thursday", 
				"Пятница" => "Friday", 
				"Суббота" => "Saturday", 
				"Воскресенье" => "Sunday"
			][$today];
		}

		public static function month_rus(int $month): string {
			return [
				'',
				'января',
				'февраля',
				'марта',
				'апреля',
				'мая',
				'июня',
				'июля',
				'августа',
				'сентября',
				'октября',
				'ноября',
				'декабря'
			][$month];
		}

		public static function get_points_in_case($points) {
			$noun = static::get_points_case($points);
			return "$points $noun";
		}

		public static function get_points_case($points) {
			$apoints = abs($points);
			if ($apoints % 100 <= 20 && $apoints %100 >= 10)
				$noun = "баллов";
			elseif ($apoints % 10 == 0 || $apoints % 10 >= 5)
				$noun = "баллов";
			elseif ($apoints % 10 == 1)
				$noun = "балл";
			else
				$noun = "балла";

			return $noun;
		}
		
		public static function check_correct(string $str): bool {
			return strlen($str) !== 0 &&
				   preg_match("/^[a-zA-Z0-9_]+$/", $str);
		}

		public static function is_incorrect(string ...$strs): bool {
			foreach ($strs as $str) {
				if (!static::check_correct($str)) {
					error_log($str);
					return true;
				}
			}

			return false;
		}

		public static function isset_get_fields(string ...$fields) {
			foreach ($fields as $field) {
				if (!isset($_GET[$field]))
					return false;
			}

			return true;
		}

		public static function isset_post_fields(string ...$fields) {
			foreach ($fields as $field) {
				if (!isset($_POST[$field]))
					return false;
			}

			return true;
		}
	}

?>
