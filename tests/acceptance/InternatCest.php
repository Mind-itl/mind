<?php

class InternatCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->click("Интернат");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Интернат");
		$I->see("Сегодня дежурят");
		$I->see("Голосование");		
	}
}
