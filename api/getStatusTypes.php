<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\Statuses;

	class getStatusTypes extends Api_method {
		public static function handle(): array {
			return Statuses::get_types();
		}	
	}
?>
