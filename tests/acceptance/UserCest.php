<?php

class UserCest {
	public function customStudentWorks(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/user/".TEST_STUDENT_LOGIN);
		$I->seeInTitle(TEST_STUDENT_LOGIN);
		$I->see(TEST_STUDENT_NAME);
		$I->see(TEST_STUDENT_LOGIN);
		$I->see(TEST_STUDENT_GROUP);
	}

	public function customTeacherWorks(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/user/".TEST_TEACHER_LOGIN);
		$I->seeInTitle(TEST_TEACHER_LOGIN);
		$I->see(TEST_TEACHER_NAME);
		$I->see(TEST_TEACHER_LOGIN);
		$I->dontSee("Баланс");
	}

	public function wrongUserDoesntWorks(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/user/wronguser123qwe");
		$I->seeResponseCodeIs(404);
	}

}
