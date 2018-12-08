<?php

class ChangelogCest {
	public function pageWorks(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/changelog");
		$I->seeInTitle("Changelog");
		$I->see("Версия 0.1.0");
	}
}
