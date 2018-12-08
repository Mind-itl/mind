<?php

class VotingCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/voting/9");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Голосование");
		$I->see("Название");
		$I->see("Описание");
		$I->see("один");
		$I->see("два");
		$I->see("три");
		$I->see("четыре");
	}
}
