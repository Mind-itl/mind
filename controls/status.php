<?php
	namespace Mind\Controls;

	use Mind\Server\{Control, Utils};

	class Status extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}
	}
?>
