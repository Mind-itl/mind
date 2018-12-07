<?php

class PointsCest {
	public function myPointsWorks(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->click("Мои баллы");
		$I->seeInTitle("Баллы");
		$I->see(TEST_STUDENT_NAME);
		$I->see("Баланс");
	}

	public function customStudentPointsWork(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/points/". TEST_STUDENT_LOGIN);
		$I->seeInTitle("Баллы");
		$I->see(TEST_STUDENT_NAME);
		$I->see("Баланс");
	}
}
