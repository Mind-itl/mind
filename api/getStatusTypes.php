<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\Passwords;

	class getStatusTypes extends Api_method {
		public static function handle(): array {
			return Status_model::get_status_types();
		}	
	}
?>
