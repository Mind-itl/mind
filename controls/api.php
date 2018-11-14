<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	const API = Utils::ROOT."api/";

	class Api extends Control {
		public function __construct(string $name) {}

		public function has_access(array $args): bool {
			if (!isset($_GET['token']))
				return false;
			if ($_GET['token'] === "android_mind_key_2")
				return true;
			if ($_GET['token'] === "site_mind_key_3")
				return true;

			return false;
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
			$file = API.$args[1].".php";
			if (!file_exists($file)) {
				return [
					"status" => "error",
					"error" => [
						"message" => "No such method"
					]
				];
			}

			require_once $file;

			$func = "api_".$args[1];

			return $func();
		}
	}
?>
