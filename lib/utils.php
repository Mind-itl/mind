<?php
	declare(strict_types=1);

	const ROOT = __DIR__ . "/../";
	require_once ROOT."config.php";
	
	const CONTROLS = ROOT."controls/";
	const VIEWS = ROOT."views/";
	const LIBS = ROOT."lib/";

	require_once "users.php";
	require_once "notifications.php";
	
	require_once ROOT."vendor/autoload.php";

	setlocale(LC_TIME, "ru_RU.UTF-8");
	session_start();

	if (isset($_SESSION["login"])) {
		$curr_user = get_user($_SESSION['login'], $_SESSION['role']);
	}

	function add_to_arr(&$arr, $arr2) {
		foreach ($arr2 as $key => $value) {
			$arr[$key] = $value;
		}
	}


	function get_curr() {
		global $curr_user;
		return $curr_user;
	}

	function is_logined(): bool {
		return isset($_SESSION['login']);
	}

	function check_logined() {
		if (!is_logined()) {
			redirect("/index");
		}
	}

	function check_roles(string ...$roles) {
		check_logined();

		foreach ($roles as $role) {
			if (!get_curr()->has_role($role))
				redirect("/index");
		}
	}

	function isset_get_fields(string ...$fields) {
		foreach ($fields as $field) {
			if (!isset($_GET[$field]))
				return false;
		}

		return true;
	}

	function isset_post_fields(string ...$fields) {
		foreach ($fields as $field) {
			if (!isset($_POST[$field]))
				return false;
		}

		return true;
	}

	function redirect($url) {
		?>
		<script>
			window.location="<?=$url?>";
		</script>
		<?php
		exit();
	}

	function tag(string $tag, string $html): string {
		return "<$tag>$html</$tag>";
	}

	function is_incorrect(string ...$strs): bool {
		foreach ($strs as $str) {
			if (!check_correct($str)) {
				error_log($str);
				return true;
			}
		}

		return false;
	}

	function today_rus(string $today): string { 
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

	function today_en(string $today): string {
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

	function month_rus(string $month): string {
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

	const lesson_times = [
		["8:00", "8:40"],
		["8:45", "9:25"],
		["9:40", "10:20"],
		["10:50", "11:30"],
		["11:40", "12:20"],
		["12:25", "13:05"]
	];
?>
