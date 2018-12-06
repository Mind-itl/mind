<?php

require_once dirname(__DIR__, 2)."/config.php";

class TimetableCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_STUDENT_LOGIN);
		$I->fillField("password", TEST_STUDENT_PASSWORD);
		$I->click("Войти");
		$I->click("Расписание");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Расписание");
	}

	public function timetableWorks(AcceptanceTester $I) {
		$days = [
			"Понедельник", "Вторник", "Среда",
			"Четверг", "Пятница", "Суббота"
		];

		foreach ($days as $day) {
			$I->see($day);
		}
	}
}
