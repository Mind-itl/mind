<?php
namespace Mind\Api;

use Mind\Server\{Api_method, Utils};
use Mind\Db\{Passwords, Users, Db, Transactions};
use Mind\Users\{Teacher, Student};

class buyLot extends Api_method {
	public static function handle(): array {
		if (!Utils::isset_get_fields("login", "points"))
			return [
				"status" => "error",
				"error" => [
					"message" => "No `login` of `points` argument"
				]
			];

		if (!Utils::is_logined())
			return [
				"status" => "error",
				"error" => [
					"message" => "No curr login"
				]
			];

		$login = $_GET['login'];
		$points = intval($_GET['points']);

		if (!Users::has_login($login, true) || (!Users::get($login, true) instanceof Student))
			return [
				"status" => "error",
				"error" => [
					"message" => "No student with that login"
				]
			];

		$student = Users::student($login, true);
		$result = Transactions::add(Utils::get_curr(), $student, "E", -$points);

		return [
			"result" => $result
		];
	}
}
