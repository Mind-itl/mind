<?php

class InternatCest {
	public function pageWorksWhenStudent(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->click("Интернат");
		$I->seeInTitle("Интернат");
		$I->see("Сегодня дежурят");
		$I->see("Голосование");		
	}

	public function pageDoesntWorkWhenTeacher(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->amOnPage("/internat");
		$I->seeResponseCodeIs(403);
	}

	public function pageDoesntWorkWhenNotLogined(AcceptanceTester $I) {
		$I->amOnPage("/internat");
		$I->seeInTitle("Войти");
	}
}
