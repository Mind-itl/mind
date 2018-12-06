<?php

require_once dirname(__DIR__, 2)."/config.php";

class TeacherProfileCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsTeacher();
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Профиль");
	}

	public function infoWorks(AcceptanceTester $I) {
		$I->see(TEST_TEACHER_NAME);
	}
}
