<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\{Db, Users, Notifications};

	class readNotification extends Api_method {
		public static function handle(): array {
			if (!Utils::isset_get_fields("id")) {
				return [
					"status" => "error"
				];
			}

			$id = $_GET['id'];

			Notifications::read(intval($id));

			return [];
		}
	}
?>
