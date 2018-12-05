<?php

require_once dirname(__DIR__, 2)."/config.php";

class ProfileCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_RIGHT_LOGIN);
		$I->fillField("password", TEST_RIGHT_PASSWORD);
		$I->click("Войти");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Профиль");
	}
}
