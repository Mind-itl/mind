<?php
	declare(strict_types=1);
	require_once "HtmlFormatter.php";

	class Control {
		protected $data;
		private $name;
		private $view;

		protected function get(string $key): string {
			return $this->data[$key];
		}

		public function __construct(string $name) {
			$this->name = $name;
			$this->data = [];
			
			$view = load_view($name);
			list($view, $args) = get_data_from_view($view);

			$this->data = $this->get_default_data();

			$this->view = $view;
			add_to_arr($this->data, $args);
		}

		protected function get_data(array $args): array {
			return [];
		}

		protected function get_default_data(): array {
			return [
				"CSS_PAGE_LINK" => "<link rel='stylesheet' href='/css/$this->name.css'>"
			];
		}

		public static function process_view(string $view, array $data, array $args): string {
			$clback = function($m) use ($data, $args) {
				if (isset($data[$m[1]]))
					return $data[$m[1]];

				if (has_control($m[1]))
					return load_control($m[1])->get_html($args);

				if (has_view($m[1]))
					return load_view($m[1]);

				return $m[0];
			};

			$view = preg_replace_callback("/\{\{ (.+?) \}\}/", $clback, $view);
			return $view;
		}

		public function has_access(array $args): bool {
			return true;
		}

		public function get_html(array $args): string {
			$data = $this->data;
			add_to_arr($data, $this->get_data($args));

			if (isset($data['MAIN_VIEW'])) {
				$html = load_view('main');
				$html = preg_replace("/\{\{ BODY \}\}/", $this->view, $html);
			} else {
				$html = $this->view;
			}

			$html = $this->process_view($html, $data, $args);
			return HtmlFormatter::format($html);
		}

	}
?>