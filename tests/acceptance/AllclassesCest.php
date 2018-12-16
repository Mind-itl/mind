<?php

class AllclassesCest {
	public function pageWorks(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->click("Общая ведомость");
		$I->seeInTitle("Общая ведомость");
		$I->see("Итого по лицею");
		$I->see(TEST_STUDENT_GROUP);
	}

	public function pageDoesntWorkWhenNotLogined(AcceptanceTester $I) {
		$I->amOnPage("/allclasses");
		$I->seeInTitle("Войти");
	}

	public function pageDoesntWorkWhenStudent(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/allclasses");
		$I->seeResponseCodeIs(404);
	}
}
