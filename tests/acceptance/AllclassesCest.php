<?php

class AllclassesCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->click("Общая ведомость");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Общая ведомость");
		$I->see("Итого по лицею");
		$I->see(TEST_STUDENT_GROUP);
	}
}
