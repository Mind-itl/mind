<?php
	namespace Mind\Api;

	use Mind\Server\{Api_method, Utils};
	use Mind\Db\{Statuses, Users};
	use Mind\Db\Votings\{Variant, Voting};
	use Mind\Users\Student;

	class Vote extends Api_method {
		public static function handle(): array {
			if (isset($_GET["login"]))
				$user = Users::get($_GET['login']);
			elseif (Utils::is_logined())
				$user = Utils::get_curr();
			else
				return [
					"status" => "error"
				];

			if (!Utils::isset_get_fields("voting_id", "variant_id"))
				return [
					"status" => "error"
				];

			$voting = Voting::get(intval($_GET["voting_id"]));
			$variant = new Variant($voting, intval($_GET["variant_id"]));

			$user_vote = $voting->get_vote_variant($user);

			if ($user_vote && $user_vote->get_id() === $variant->get_id())
				$voting->unvote($user);
			else
				$voting->vote($user, $variant);

			return [];
		}
	}
?>
