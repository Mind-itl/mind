<?php

require_once dirname(__DIR__, 2)."/config.php";

class GroupCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Выписка по классу");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Выписка по классу");
		$I->see("Баланс класса");
	}
}
