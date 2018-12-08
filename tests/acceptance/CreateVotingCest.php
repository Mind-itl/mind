<?php

class CreateVotingCest {
	public function pageWorksWhenZam(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->click("Добавить голосование");
		$I->seeInTitle("Добавить голосование");
	}
}
