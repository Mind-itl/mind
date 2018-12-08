<?php

class LoadCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->click("Загрузить данные");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Загрузить данные");
	}
}
