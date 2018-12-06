<?php

class StudentProfileCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsStudent();
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Профиль");
	}

	public function infoWorks(AcceptanceTester $I) {
		$I->see(TEST_STUDENT_NAME);
		$I->see("Баланс");
		$I->see(TEST_STUDENT_GROUP);
		$I->see(TEST_STUDENT_CLASSRUK);
	}
}
