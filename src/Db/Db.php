<?php
	namespace Mind\Db;

	require_once __DIR__."/../../config.php";

	class Db {
		public static function query(...$args) {
			$sql = new \SafeMySQL([
				'user' => DB_USER,
				'db' => DB_NAME,
				'pass' => DB_PASSWORD
			]);

			/** @var mixed */
			$r = $sql->query(...$args);

			return $r;
		}

		public static function query_assoc(...$args): array {
			$r = static::query(...$args)->fetch_assoc();

			if ($r === null)
				throw new \Exception("Wrong assoc sql query");

			return $r;
		}
	}
?>
