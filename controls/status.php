<?php
	class Status_control extends Control {
		public function has_access(array $args): bool {
			return is_logined();
		}
	}
?>
