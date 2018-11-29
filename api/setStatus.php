<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\{Statuses, Users};
	use Mind\Users\Student;

	class setStatus extends Api_method {
		public static function handle(): array {
			$user = Users::get($_GET['login']);

			if (!$user instanceof Student)
				return [];

			Statuses::set($user, $_GET['status']);
			return [];
		}
	}
?>
