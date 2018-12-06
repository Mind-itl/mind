<?php

require_once dirname(__DIR__, 2)."/config.php";

class GroupCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_TEACHER_LOGIN);
		$I->fillField("password", TEST_TEACHER_PASSWORD);
		$I->click("Войти");
		$I->click("Выписка по классу");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Выписка по классу");
		$I->see("Баланс класса");
	}
}
