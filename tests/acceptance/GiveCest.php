<?php

class GiveCest {
	public function pageWorksWhenStudent(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->click("Передать баллы");
		$I->seeInTitle("Передать баллы");
		$I->see("Баланс");
	}

	public function pageDoesntWorkWhenTeacher(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->amOnPage("/give");
		$I->seeResponseCodeIs(403);
	}

	public function pageDoesntWorkWhenNotLogined(AcceptanceTester $I) {
		$I->amOnPage("/give");
		$I->seeInTitle("Войти");
	}
}
