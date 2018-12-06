<?php

class DocumentsCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Документы");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Документы\\Сведения");
	}
}
