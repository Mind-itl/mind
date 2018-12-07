<?php

class ChangelogCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/changelog");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Changelog");
		$I->see("Версия 0.1.0");
	}
}
