<?php

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
