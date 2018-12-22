<?php
	namespace Mind\Server;

	use Mind\Db\{Db, Users};
	use Mind\Server\{Control, Utils, Api_method};
	use Mind\Users\{User, Teacher, Student};

	class MarkdownControl extends Control {
		private $file_name;

		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		public function __construct(string $file_name) {
			$this->file_name = $file_name;
		}

		public function get_html(array $args): string {
			$file = $this->file_name . ".md";
			$text = file_get_contents(Utils::VIEWS."$file");

			$parsedown = new \Parsedown();
			$parsedown
				->setSafeMode(true)
				->setBreaksEnabled(true);

			$text = $parsedown->text($text);
			$text =
				"{% extends 'markdown.html' %}\n".
				"{% block body %}\n".
				'<div class="container-points container">'.
				$text .
				'</div>'.
				"{% endblock %}";

			$template = Twig_loader::get_twig()->createTemplate($text);
			return $template->render([]);
		}
	}
?>
