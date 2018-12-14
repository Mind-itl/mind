<?php

class VotingCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/voting/24");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Голосование");
		$I->see("Твикс");
		$I->see("А какую палочку выберешь ты?");
		$I->see("Левую");
		$I->see("Правую");
	}
}
