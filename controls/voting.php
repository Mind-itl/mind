<?php
	namespace Mind\Controls;

	use Mind\Db\{Users, Voting as Voting_obj};
	use Mind\Server\{Control, Utils};

	class Voting extends Control {
		public function has_access(array $args): bool {
			return
				Utils::is_logined() &&
				isset($args[1]) && $args[1]!="";
		}

		protected function get_data(array $args): array {
			$id = intval($args[1]);

			$voting = Voting_obj::get($id);

			return [
				"voting" => [
					"id" => $id,
					"title" => $voting->get_title(),
					"description" => $voting->get_description(),
					"variants" => $voting->get_variants()
				]
			];
		}
	}
?>
