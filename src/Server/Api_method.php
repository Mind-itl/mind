<?php
	declare(strict_types=1);

	namespace Mind\Server;

	abstract class Api_method {
		public static function check_token(string $token) {
			if ($token === "android_mind_key_2")
				return true;

			return false;
		}

		public static function handle_method(string $name): ?array {
			$cl = "\\Mind\\Api\\$name::handle";

			if (!is_callable($cl))
				return null;

			return call_user_func($cl);
		}

		abstract public static function handle(): array;
	}
?>
