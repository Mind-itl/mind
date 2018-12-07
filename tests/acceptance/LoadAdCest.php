<?php

class LoadAdCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->amOnPage("/load_ad");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Добавить баннер");
	}
}
