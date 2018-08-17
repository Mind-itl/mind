<?php
	declare(strict_types=1);

	abstract class Control {
		public $data;
		private $name;
		private $view;

		protected function __construct(string $name) {
			$this->name = $name;
			$this->data = [];
			
			$view = load_view($name);
			list($view, $args) = get_data_from_view($view);

			$this->view = $view;
			$this->data = $args;
		}

		abstract protected function get_data(array $args): array;

		public function get_html(array $args): string {
			$data = $this->data;
			add_to_arr($data, $this->get_data($args));

			if (isset($data['MAIN_VIEW'])) {
				$html = load_view('main');
				$html = preg_replace("/\{\{ BODY \}\}/", $this->view, $html);
			} else {
				$html = $this->view;
			}

			$clback = function($m) use ($data) {
				if (isset($data[$m[1]]))
					return $data[$m[1]];

				if (has_view($m[1]))
					return load_view($m[1]);

				return $m[0];
			};

			$html = preg_replace_callback("/\{\{ (.+) \}\}/", $clback, $html);
			return $html;
		}

	}
?>