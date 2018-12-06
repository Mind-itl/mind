<?php

require_once dirname(__DIR__, 2)."/config.php";

class DocumentsCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
		$I->fillField("login", TEST_STUDENT_LOGIN);
		$I->fillField("password", TEST_STUDENT_PASSWORD);
		$I->click("Войти");
		$I->click("Документы");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Документы\\Сведения");
	}
}
