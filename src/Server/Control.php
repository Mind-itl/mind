<?php
	declare(strict_types=1);

	namespace Mind\Server;

	class Control {
		protected $template;
		protected $name;

		/**
		 * @param string $name Name of view that will be used (without `.html` ext)
		 */
		public function __construct(string $name) {
			$this->name = $name;
			$this->template = Twig_loader::get_twig()->load("$name.html");
		}

		/**
		 * Should be overrided in extending class
		 * Should return `true` if current user has **access** to this page or `false` otherwise
		 * `true` by default
		 * 
		 * @param array<string> $args Splitted by '\' url request path
		 * @return bool
		 */
		public function has_access(array $args): bool {
			return true;
		}

		/**
		 * Should be overrided in extending class
		 * Should return assoc array of values that will be enable from view template
		 * 
		 * `[]` by default
		 * 
		 * @param array $args Splitted by '\' url request path
		 * @return array<string, mixed> 
		 */
		protected function get_data(array $args): array {
			return [];
		}

		/**
		 * Return default array of values that will be enable from view template
		 * This values can be overriden in `get_data` method
		 * Keys: `["control_name", "is_logined", "me"]`
		 * 
		 * @return array<string, mixed>
		 */
		private function get_default_data(): array {
			$arr =  [
				"control_name" => $this->name,
				"is_logined" => Utils::is_logined(),
			];
			
			if (Utils::is_logined()) {
				$arr["me"] = Utils::get_curr();
			}

			return $arr;
		}

		/**
		 * Return html proccessed with templator
		 * 
		 * @param array $args Splitted by '\' url request path
		 * @return string
		 */
		public function get_html(array $args): string {
			$data = $this->get_default_data();

			foreach ($this->get_data($args) as $key => $value) {
				$data[$key] = $value;
			}

			$html = $this->template->render($data);
			return $html;
		}

	}
?>
