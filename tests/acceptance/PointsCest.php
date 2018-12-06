<?php

require_once dirname(__DIR__, 2)."/config.php";

class PointsCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->click("Мои баллы");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Баллы");
		$I->see(TEST_STUDENT_NAME);
		$I->see("Баланс");
	}
}
