<?php

class TimetableCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsStudent();
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
