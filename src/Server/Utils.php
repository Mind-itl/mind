<?php
	namespace Mind\Server;

	use Mind\Users\User;
	use Mind\Db\Users;

	class Utils {
		const ROOT = __DIR__."/../../";
		const CONTROLS = ROOT."controls/";
		const VIEWS = ROOT."views/";
		const LIBS = ROOT."lib/";

		public static function is_logined(): bool {
			return isset($_SESSION['login']);
		}

		public static function get_curr(): ?User {
			if (isset($_SESSION["login"]))
				return Users::get($_SESSION['login']);

			return null;
		}

		public static function redirect($url) {
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
	}

?>
