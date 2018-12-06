<?php

require_once dirname(__DIR__, 2)."/config.php";

class InternatCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_RIGHT_LOGIN);
		$I->fillField("password", TEST_RIGHT_PASSWORD);
		$I->click("Войти");
		$I->click("Интернат");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Интернат");
		$I->see("Сегодня дежурят");
		$I->see("Голосование");		
	}
}
