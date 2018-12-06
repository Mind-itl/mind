<?php

require_once dirname(__DIR__, 2)."/config.php";

class BroadcastCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_TEACHER_LOGIN);
		$I->fillField("password", TEST_TEACHER_PASSWORD);
		$I->click("Войти");
		$I->click("Оповестить учеников");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Оповестить учеников");
		$I->see("Добавить учеников");
		$I->see("Введите сообщение");
	}
}
