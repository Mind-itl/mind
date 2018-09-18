<?php
	declare(strict_types=1);

	require_once __DIR__."/../lib/utils.php";
	require_once LIBS."Control.php";

	function not_found() {
		header("HTTP/1.0 404 Not Found");

		echo "404";
		exit();
	}

	function no_access() {
		redirect("/");
	}

	function has_pure_page(string $name): bool {
		$view_file = VIEWS."$name.html";
		return file_exists($view_file);
	}


	function load_control(string $c): Control {
		function get_control_class_name(string $c): string {
			$x = strtoupper(substr($c, 0, 1));
			$xs = substr($c, 1);
			return "$x{$xs}_control";
		}

		require_once CONTROLS."$c.php";
		$c = get_control_class_name($c);
		return new $c;
	}

	function has_control(string $control_name): bool {
		$control_file = CONTROLS."$control_name.php";
		return file_exists($control_file);
	}

	$loader = new Twig_Loader_Filesystem(VIEWS);
	$twig = new Twig_Environment($loader);

	function get_twig() {
		global $twig;
		return $twig;
	}

	function has_public_file(string $url): bool {
		$public_file = "public_html".$url;
		return
			file_exists($public_file) &&
			is_file($public_file);
	}

	function mvc_main() {
		$url = $_SERVER['REQUEST_URI'];
		if (has_public_file($url))
			return false;

		$url_arr = explode('/', substr($url, 1));

		$control_name = $url[0];

		if ($control_name === "" || $control_name === "/") {
			if (is_logined())
				$control_name = "profile";
			else
				$control_name = "signin"; 
		}

		if (has_control($control_name)) {
			$control = load_control($control_name);

			if ($control->has_access($url_arr))
				echo $control->get_html($url_arr);
			else
				no_access();

		} elseif (has_pure_page($control_name)) {
			$control = new Control($control_name);
			echo $control->get_html($url_arr);
		} else
			not_found();
	}

	if (mvc_main()===false) {
		return false;
	}
?>
