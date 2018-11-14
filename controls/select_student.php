<?php
	namespace Mind\Controls;

	use Mind\Db\{Db, Users, Notifications, Json, Causes};
	use Mind\Server\{Control, Utils};
	use Mind\Users\{User, Teacher, Student};

	class Select extends Control {
		protected function get_data(array $args): array {
			return [
				"classes" => Json::get_classes()
			];
		}
	}
?>
