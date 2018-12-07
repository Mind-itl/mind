<?php
	namespace Mind\Db;

	require_once __DIR__."/../../config.php";

	class Db {
		public static function query(...$args): \mysqli_result {
			$sql = new \SafeMySQL([
				'user' => DB_USER,
				'db' => DB_NAME,
				'pass' => DB_PASSWORD
			]);

			return $sql->query(...$args);
		}

		public static function query_assoc(...$args): array {
			return static::query(...$args)->fetch_assoc();
		}
	}
?>
