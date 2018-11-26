<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users};
	use Mind\Server\{Control, Utils, Api_method};
	use Mind\Users\{User, Teacher, Student};

	const API = Utils::ROOT."api/";

	class Api extends Control {
		public function __construct(string $name) {}

		public function has_access(array $args): bool {
			if (isset($_GET['token']))
				return Api_method::check_token($_GET['token']);

			return Utils::is_logined();
		}

		public function get_html(array $args): string {
			$obj = $this->handle($args);
			header('Content-Type: application/json');
			$json = json_encode($obj);

			if ($json === false)
				return "";

			return $json;
		}

		private function handle($args): array {
			$r = Api_method::handle_method($args[1]);

			return $r ?? [
				"status" => "error",
				"error" => [
					"message" => "No such method"
				]
			];
		}
	}
?>
