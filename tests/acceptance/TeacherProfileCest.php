<?php

require_once dirname(__DIR__, 2)."/config.php";

class TeacherProfileCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_TEACHER_LOGIN);
		$I->fillField("password", TEST_TEACHER_PASSWORD);
		$I->click("Войти");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Профиль");
	}

	public function infoWorks(AcceptanceTester $I) {
		$I->see(TEST_TEACHER_NAME);
	}
}
