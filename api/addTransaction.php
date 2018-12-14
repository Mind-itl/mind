<?php
namespace Mind\Api;

use Mind\Server\{Api_method, Utils};
use Mind\Db\{Passwords, Users, Db, Transactions};
use Mind\Users\{Teacher, Student};

class addTransaction extends Api_method {
	public static function handle(): array {
		if (!Utils::isset_get_fields("from_login", "to_login"))
			return [
				"status" => "error",
				"error" => [
					"message" => "No `to_login` of `from_login` argument"
				]
			];

		$to_login = $_GET['to_login'];
		$from_login = $_GET['from_login'];

		if (!Users::has_login($to_login, true) || (!Users::get($to_login, true) instanceof Student))
			return [
				"status" => "error",
				"error" => [
					"message" => "No user with that login"
				]
			];

		if (!Users::has_login($from_login, true))
			return [
				"status" => "error",
				"error" => [
					"message" => "No user with that login"
				]
			];

		$to_user = Users::student($to_login, true);
		$from_user = Users::get($from_login, true);

		if (!isset($_GET['cause']) && $from_user instanceof Teacher)
			return [
				"status" => "error",
				"error" => [
					"message" => "No cause"
				]
			];

		$cause = trim($_GET['cause'] ?? "C");
		$points = intval($_GET['points'] ?? 0);

		$result = Transactions::add($from_user, $to_user, $cause, $points);

		return [
			"result" => $result
		];
	}	
}
