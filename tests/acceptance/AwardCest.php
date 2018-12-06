<?php

class AwardCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Начислить баллы");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Начислить баллы");
		$I->see("Выберите ученика");
	}
}
