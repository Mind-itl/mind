<?php

require_once dirname(__DIR__, 2)."/config.php";

class StudentProfileCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_STUDENT_LOGIN);
		$I->fillField("password", TEST_STUDENT_PASSWORD);
		$I->click("Войти");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Профиль");
	}

	public function infoWorks(AcceptanceTester $I) {
		$I->see(TEST_STUDENT_NAME);
		$I->see("Баланс");
		$I->see(TEST_STUDENT_GROUP);
		$I->see(TEST_STUDENT_CLASSRUK);
	}
}
