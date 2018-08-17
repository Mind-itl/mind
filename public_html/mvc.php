<?php
	declare(strict_types=1);
	require_once "utils.php";
	require_once "config.php";
	require_once "Control.php";

	function not_found() {
		header("HTTP/1.0 404 Not Found");
		echo Control::process_view(load_view("404"), [], []);
		exit();
	}

	function add_to_arr(&$arr, $arr2) {
		foreach ($arr2 as $key => $value) {
			$arr[$key] = $value;
		}
	}

	function load_view(string $view_name): string {
		$view_file = VIEWS."$view_name.html";
		$view = file_get_contents($view_file);
		return $view;
	}

	function has_view(string $view_name): bool {
		$view_file = VIEWS."$view_name.html";
		return file_exists($view_file);
	}

	function get_data_from_view(string $view): array {
		preg_match_all("/\{\{ (.+)\{(.*)\} \}\}/", $view, $matches, PREG_SET_ORDER);
		$data = [];

		foreach ($matches as $key => $value) {
			$data[$value[1]] = $value[2];
		}

		$view = preg_replace("/\{\{ (.+)\{(.*)\} \}\}/", "", $view);

		return [$view, $data];
	}

	function get_control_name(string $c): string {
		$x = strtoupper(substr($c, 0, 1));
		$xs = substr($c, 1);
		return "$x{$xs}_control";
	}

	function load_control(string $c): Control {
		require_once CONTROLS."$c.php";
		$c = get_control_name($c);
		return new $c;
	}

	function has_control(string $control_name): bool {
		$control_file = CONTROLS."$control_name.php";
		return file_exists($control_file);
	}

	function mvc_main() {
		$url = explode('/', substr($_SERVER['REQUEST_URI'], 1));
		$control = $url[0];
		$control_file = CONTROLS."$control.php";

		if (file_exists($control_file)) {
			require $control_file;
		} else {
			not_found();
		}

		$conr = load_control($control);
		echo $conr->get_html($url);
	}
	mvc_main();
?>