<?php
	namespace Mind\Controls;

	use Mind\Db\Users;
	use Mind\Server\{Control, Utils};
	use Mind\Db\Votings\{Variant, Voting as Voting_obj};


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
				"voting" => $voting
			];
		}
	}
?>
