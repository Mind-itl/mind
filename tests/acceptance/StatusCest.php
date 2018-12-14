<?php

class StatusCest {
	public function pageDoesntWorkForStudent(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/ask");
		$I->seeResponseCodeIs(403);
	}

	public function pageWorksForZam(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->click("Ученики");
		$I->seeInTitle("Ученики");
	}

	public function pageDoesntWorkWhenNotLogined(AcceptanceTester $I) {
		$I->amOnPage("/status");
		$I->seeInTitle("Войти");
	}
}
