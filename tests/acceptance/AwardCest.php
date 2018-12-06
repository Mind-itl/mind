<?php

require_once dirname(__DIR__, 2)."/config.php";

class AwardCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_TEACHER_LOGIN);
		$I->fillField("password", TEST_TEACHER_PASSWORD);
		$I->click("Войти");
		$I->click("Начислить баллы");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Начислить баллы");
		$I->see("Выберите ученика");
	}
}
