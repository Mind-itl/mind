<?php
	namespace Mind\Server;

	use Twig_Environment,
		Twig_Loader_Filesystem,
		Twig_Function,
		Twig_Filter;

	const ROOT = __DIR__."/../../";
	const VIEWS = ROOT."views/";

	class Twig_loader {

		public static $funcs;
 		public static $filters;

 		private static $twig;

		private static function create_twig(): Twig_Environment {
			$loader = new Twig_Loader_Filesystem(VIEWS);
			$twig = new Twig_Environment($loader);
			return $twig;
		}

		private static function add_functions(Twig_Environment $twig) {
			foreach (self::$funcs as $name => $func)
				$twig->addFunction(new Twig_Function($name, $func));
		
			foreach (self::$filters as $name => $filter)
				$twig->addFilter(new Twig_Filter($name, $filter));
		}

		public static function get_twig(): Twig_Environment {
			if (self::$twig === null) {
				self::$twig = self::create_twig();
				self::add_functions(self::$twig);
			}

			return self::$twig;
		}
	}

	Twig_loader::$funcs = [
		"controller" => function(string $control_name): void {
			$control = Route::load_control($control_name);
			if ($control->has_access([]))
				echo $control->get_html([]);
			else
				Route::no_access();
		},
		"has_css" => function(string $file_name): bool {
			return file_exists(Utils::ROOT."/public_html/css/$file_name");
		},
		"has_js" => function(string $file_name): bool {
			return file_exists(Utils::ROOT."/public_html/js/$file_name");
		},
		"has_dist" => function(string $file_name): bool {
			return file_exists(Utils::ROOT."/public_html/dist/$file_name");
		},
		"get_role_name" => function(string $role): string {
			return \Mind\Users\Role::get_role_name($role);
		},
		"get_role_arg_name" => function(string $role): string {
			return \Mind\Users\Role::get_role_arg_name($role);
		},
		"get_roles" => function() {
			return \Mind\Users\Role::get_roles();
		}
	];

	Twig_loader::$filters = [
		"weekday_rus" => function(string $day): string {
			return Utils::today_rus($day);
		},
		"month_rus" => function(int $month): string {
			return Utils::month_rus($month);
		},
		"fdate" => function(\DateTime $date, string $format): string {
			$s = strftime($format, $date->getTimestamp());
			$month = Utils::month_rus(intval($date->format('n')));

			return str_replace("%Q", $month, $s);
		},
		"markdown" => function(string $text): string {
			$parsedown = new \Parsedown();
			$parsedown
				->setSafeMode(true)
				->setBreaksEnabled(true);

			return $parsedown->text($text);
		}
	];

?>
