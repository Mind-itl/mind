<?php
namespace Mind\Api;

use Mind\Server\{Api_method, Utils};
use Mind\Db\{Passwords, Users, Db, Transactions};
use Mind\Users\{Teacher, Student};

class getTransactions extends Api_method {
	public static function handle(): array {
		if (!Utils::isset_get_fields("login"))
			return [
				"status" => "error",
				"error" => [
					"message" => "No `login` argument"
				]
			];

		$login = $_GET['login'];

		if (!Users::has_login($login, true) || (!Users::get($login, true) instanceof Student))
			return [
				"status" => "error",
				"error" => [
					"message" => "No student with that login"
				]
			];

		$user = Users::student($login, true);

		$ret = [];

		foreach (Transactions::of_student($user) as $val) {
			$ret[] = [
				"time" => $val["NORM_TIME"],
				"from" => $val["FROM_LOGIN"],
				"to" => $val["TO_LOGIN"],
				"cause" => $val["CAUSE"],
				"points" => $val["POINTS"] 	
			];
		}

		return $ret;
	}	
}
