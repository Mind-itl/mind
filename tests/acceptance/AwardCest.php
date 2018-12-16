<?php

class AwardCest {
	public function pageWorksWhenTeacher(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Начислить баллы");
		$I->seeInTitle("Начислить баллы");
		$I->see("Выберите ученика");
	}

	public function pageDoesntWorkWhenStudent(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/award");
		$I->seeResponseCodeIs(404);
	}

	public function pageDoesntWorkWhenNotLogined(AcceptanceTester $I) {
		$I->amOnPage("/award");
		$I->seeInTitle("Войти");
	}
}
