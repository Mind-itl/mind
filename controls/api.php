<?php
	const API = ROOT."api/";

	class Api_control extends Control {
		public function __construct(string $name) {}

		public function get_html(array $args): string {
			$obj = $this->handle($args);
			header('Content-Type: application/json');
			return json_encode($obj);
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
