<?php
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
			$control = load_control($control_name);
			if ($control->has_access([]))
				echo $control->get_html([]);
			else
				no_access();
		}
	];

	Twig_loader::$filters = [
		"weekday_rus" => function(string $day): string {
			return today_rus($day);
		},
		"month_rus" => function(string $month): string {
			return month_rus($month);
		}
	];
?>
