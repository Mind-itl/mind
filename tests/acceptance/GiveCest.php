<?php

require_once dirname(__DIR__, 2)."/config.php";

class GiveCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->click("Передать баллы");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Передать баллы");
		$I->see("Баланс");
	}
}
