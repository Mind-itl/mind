<?php

class CreateVotingCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->click("Добавить голосование");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Добавить голосование");
	}
}
