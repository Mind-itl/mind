<?php

class StatusCest {
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
