<?php

require_once dirname(__DIR__, 2)."/config.php";

class BroadcastCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Оповестить учеников");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Оповестить учеников");
		$I->see("Добавить учеников");
		$I->see("Введите сообщение");
	}
}
