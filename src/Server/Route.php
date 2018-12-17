<?php
	declare(strict_types=1);

	namespace Mind\Server;

	Class Route {
		public static function not_found(): void {
			header("HTTP/1.0 404 Not Found");

			if (Utils::is_logined())
				$c = new Control("404_logined");
			else
				$c = new Control("404");
			
			echo $c->get_html([]);
			
			exit();
		}

		public static function no_access() {
			if (Utils::is_logined())
				static::not_found();
			else
				Utils::redirect("/?from=".$_SERVER["REQUEST_URI"]);
			exit();
		}

		public static function has_pure_page(string $name): bool {
			$view_file = Utils::VIEWS."$name.html";
			return file_exists($view_file);
		}

		public static function get_control_class_name(string $c): string {
			$x = strtoupper(substr($c, 0, 1));
			$xs = substr($c, 1);
			return "\\Mind\\Controls\\$x{$xs}";
		}

		public static function load_control(string $name): Control {

			require_once Utils::CONTROLS."$name.php";

			$c = self::get_control_class_name($name);
			return new $c($name);
		}

		public static function has_control(string $control_name): bool {
			$control_file = Utils::CONTROLS."$control_name.php";
			return file_exists($control_file);
		}

		public static function has_public_file(string $url): bool {
			$public_file = "public_html".$url;
			return
				file_exists($public_file) &&
				is_file($public_file);
		}

		public static function init(): void {
			require_once dirname(__DIR__, 2)."/config.php";

			setlocale(LC_TIME, "ru_RU.UTF-8");
			session_start();

			Log::init();
			Log::info("start");
		}

		public static function main() {
			static::init();

			$url = $_SERVER['REQUEST_URI'];
			if (self::has_public_file($url))
				return false;

			$url = explode('?', $url)[0];
			$url_arr = explode('/', substr($url, 1));
			$control_name = $url_arr[0];

			if ($control_name === "" || $control_name === "/") {
				if (Utils::is_logined())
					$control_name = "profile";
				else
					$control_name = "signin"; 
			}

			if (self::has_control($control_name)) {
				$control = self::load_control($control_name);

				if ($control->has_access($url_arr))
					echo $control->get_html($url_arr);
				else
					self::no_access();

			} elseif (self::has_pure_page($control_name)) {
				$control = new Control($control_name);
				$html = $control->get_html($url_arr);
				echo $html;
			} else
				self::not_found();
		}
	}
?>
